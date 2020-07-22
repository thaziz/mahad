<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/third_party/Box/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\Style;
use Box\Spout\Writer\Style\Border;
use Box\Spout\Writer\Style\BorderBuilder;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\WriterFactory;
class Bank_soal extends MX_Controller {


	/**
	 * 
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'bidang');
		if(!isset($this->menu['rule']['panel/input_transaksi'])){
			show_404();
		}
		$this->load->model('bank_soal/bank_soal_model');
		
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		
	}

	public function index(){
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/input_transaksi']['v']);
		if($_POST && $auth){
			$list = $this->transaksi_model->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $admin) {
	            $no++;
	            $row = array();	            
	            $row[] = $admin->a_code;	
	            $row[] = $admin->a_name;
	            $row[] = $admin->t_year;
	            $row[] = number_format($admin->t_nominal,0,',','.');
	            $row[] = $admin->t_note;
	            $row[] = date('d-m-Y H:i:s',strtotime($admin->t_created));
	            $row[] = $admin->t_updated==NULL?'':date('d-m-Y H:i:s',strtotime($admin->t_updated));
	            $row[] = $admin->t_id;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->transaksi_model->count_all(),
	                        "recordsFiltered" => $this->transaksi_model->count_filtered(),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/input_transaksi'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS ADMINISTRATOR MENU');
			$this->template->view('view_index', $data);
		}
	}


    public function import_data($id)
    {
        set_time_limit(900);

        $this->load->library('upload');
        $path = '/upload_soal/' . date('Y-m-d-H_i_s') . '/';
        if (!is_dir($dir = 'assets' . $path)) {
            mkdir($dir);
        }
        $config['allowed_types'] = 'xlsx';
        $config['upload_path']   = $dir;

        $this->upload->initialize($config);
        if (!$this->upload->do_upload('file')) {
            echo json_encode(array('status' => 'ERROR', 'errors' => $this->upload->display_errors()));
        } else {
            $dataFile  = $this->upload->data();
            $file = 'assets' . $path . $dataFile['file_name'];
            $reader = ReaderFactory::create(Type::XLSX); // for XLSX files
            $reader->open(FCPATH . '/' . $file);
            $data = array();
            foreach ($reader->getSheetIterator() as $sheet) {
                $index = 0;
                if ($sheet->getIndex() === 0) {
                    //$rows = $sheet->getRowIterator();
                    //print_r($rows);

                    foreach ($sheet->getRowIterator() as $row) {

                      $index++;
                        $skip = false;
                        if ($index == 1 && isset($_POST['header'])) {
                            continue;
                        } else {
                            	
                                $data[] = $row[0];
                            
                        }
                    }
                }
            }            
            $reader->close();
            if (unlink($file)) {
                rmdir('assets' . $path);
            }
            $result = $this->bank_soal_model->insert_batch($id, $data);
            set_time_limit(30);
            echo json_encode($result);
        }
    }



	public function insert(){
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/bank_soal']['c']);
		if($_POST && $auth){
						$a=$this->bank_soal_model->insert();
echo json_encode($a);
            //$this->form_validation->set_rules('matkul', 'Mata Kuliah', 'required');
            
            if ($this->form_validation->run() == false){
            	/*$data['status'] = false;
            	$data['e']['t_a_code'] = form_error('t_a_code', '<div class="has-error">', '</div>');
            	$data['e']['t_nominal'] = form_error('t_nominal', '<div class="has-error">', '</div>');
            	$data['e']['t_note'] = form_error('t_note', '<div class="has-error">', '</div>');
            	
            	
            	echo json_encode($data);*/
            }else{
            	if($this->transaksi_model->insert()){
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT v_transaksi with ID = '.$this->db->insert_id()
            		.' NAME = '.$_POST['t_a_code']);
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['matkul']=$this->bank_soal_model->get_matkul();
			$data['menu'] = $this->menu;
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS INPUT ANGGARAN MENU');
			$this->template->view('view_insert', $data);
		}
	}

	public function insert_detail(){
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/bank_soal']['c']);
		if($_POST && $auth){
			$a=$this->bank_soal_model->insert_detail();
			echo json_encode($a);
            //$this->form_validation->set_rules('matkul', 'Mata Kuliah', 'required');
            
            if ($this->form_validation->run() == false){
            	/*$data['status'] = false;
            	$data['e']['t_a_code'] = form_error('t_a_code', '<div class="has-error">', '</div>');
            	$data['e']['t_nominal'] = form_error('t_nominal', '<div class="has-error">', '</div>');
            	$data['e']['t_note'] = form_error('t_note', '<div class="has-error">', '</div>');
            	
            	
            	echo json_encode($data);*/
            }else{
            	if($this->transaksi_model->insert()){
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT v_transaksi with ID = '.$this->db->insert_id()
            		.' NAME = '.$_POST['t_a_code']);
            		echo json_encode(array('status'=>true));
            	}
            }
		}
	}


	public function edit($id){
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/input_transaksi']['e']);
		if($_POST && $auth){
		
            $this->form_validation->set_rules('t_a_code', 'Nama Anggaran', 'required');
            $this->form_validation->set_rules('t_tahun', 'Tahun', 'required');
            $this->form_validation->set_rules('t_nominal', 'Nominal', 'required');
            $this->form_validation->set_rules('t_note', 'Keterangan', 'required');


            if ($this->form_validation->run() == false)
            {
            	$data['status'] = false;
            	$data['e']['oa_account_id'] = form_error('oa_account_id', '<div class="has-error">', '</div>');
            	$data['e']['oa_saldo'] = form_error('oa_saldo', '<div class="has-error">', '</div>');
            	echo json_encode($data);
            }else{
            	if($this->transaksi_model->update($id)){
            		$this->userlog->add_log($this->session->userdata['name'],
            		'EDIT Transaksi ID: '.$id.'  WITH NEW VALUE '
            		.http_build_query($_POST,'',', '));
            		echo json_encode(array('status'=>true));
            	}
            }
		}else{
			$data['data'] = $this->transaksi_model->find_by_id($id);
			$data['account'] = $this->transaksi_model->get_account();
			$data['menu'] = $this->menu;
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS EDIT TRANSAKSI ID: '.$id.' NAME: '.$data['data']->a_name);
			$this->template->view('view_account_edit', $data);
		}
	}

	public function delete(){
		$auth = $this->template->set_auth($this->menu['rule']['panel/input_transaksi']['d']);
		if($auth){
			$info = $this->transaksi_model->get_name($_POST['d_id']);
			$info = str_replace('[', '', str_replace(']', '', json_encode($info)));
			if($this->transaksi_model->delete()){
				$this->userlog->add_log($this->session->userdata['name'], 'DELETE TRANSAKSI '.$info);
				$data['status'] = true;
			}else{
				$data['status'] = false;
			}
			echo json_encode($data);
		}else{
			$this->template->view('');
		}
	}

}
