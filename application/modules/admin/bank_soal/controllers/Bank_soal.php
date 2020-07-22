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
		if(!isset($this->menu['rule']['panel/bank_soal'])){
			show_404();
		}
		$this->load->model('bank_soal/bank_soal_model');
		
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		
	}

	public function index(){
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/bank_soal']['v']);
		if($_POST && $auth){
			$list = $this->bank_soal_model->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $admin) {
	            $no++;
	            /*
	            'ms_id',
                        'ms_jenis_kel',
                        'ms_jenis_ujian',
                        'ms_matkul',
                        'ms_level',
                        'ms_kelas',
                        'ms_dosen',
                        'ms_startdate',
                        'ms_enddate',
                        'ms_starttime' ,
                        'ms_endtime' ,
                        'ms_created',
                        'ms_created_by',
                        'ms_waktu',
                        */
	            $row = array();	            
	            $row[] = $admin->ms_jenis_ujian;	
	            $row[] = $admin->subject_ar_name.' ('.$admin->time.')';
	            $row[] = $admin->ms_jenis_kel=='L'?'Laki-laki':'Perempuan';
	            $row[] = $admin->ms_level;
	            $row[] = $admin->ms_kelas;
	            $row[] = $admin->ms_startdate;
	            $row[] = $admin->ms_starttime .' - '.$admin->ms_endtime;
	            $row[] = $admin->ms_created;	            
	            $row[] = $admin->ms_status;
	            $row[] = $admin->ms_id;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->bank_soal_model->count_all(),
	                        "recordsFiltered" => $this->bank_soal_model->count_filtered(),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/bank_soal'];
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS ADMINISTRATOR MENU');
			$this->template->view('view_index', $data);
		}
	}


    public function import_data($id=null)
    {
        if($id==null){
                echo json_encode(array('status' => 'ERROR', 'errors'=>'Master Soal belum di simpan'));
                exit();
        }

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
                    foreach ($sheet->getRowIterator() as $row) {
                      $index++;
                        $skip = false;
                        if ($index == 1 && isset($_POST['header'])) {
                            continue;
                        } else {
                                $data[] = $row;
                        }
                    }
                }
            }            
            $reader->close();
            if (unlink($file)) {
                rmdir('assets' . $path);
            }
            $data['result'] = $this->bank_soal_model->insert_batch($id, $data);
           	$result["status"]=true;
           	$data['type']=$_POST['type'];
           	$result["view"]=($this->load->view('view_tambah_detail', $data,TRUE));

           	echo json_encode($result);
            
        }
    }



	public function insert(){
		$this->load->helper(array('form', 'url', 'countries'));
		$auth = $this->template->set_auth($this->menu['rule']['panel/bank_soal']['c']);
		if($_POST && $auth){
			
            $this->form_validation->set_rules('level', 'Level', 'required');
            $this->form_validation->set_rules('kelas', 'Kelas', 'required');
            $this->form_validation->set_rules('jenis', 'Jenis', 'required');
            $this->form_validation->set_rules('matkul', 'Mata Kuliah', 'required');
            $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required');
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
            $this->form_validation->set_rules('stime_perday', 'Tanggal', 'required');
            $this->form_validation->set_rules('etime_perday', 'Tanggal', 'required');
            
            

            
            if ($this->form_validation->run() == false){
            	$data['status'] = false;
            	$data['e']['level'] = form_error('level', '<div class="has-error">', '</div>');
            	$data['e']['kelas'] = form_error('kelas', '<div class="has-error">', '</div>');
            	$data['e']['jenis'] = form_error('jenis', '<div class="has-error">', '</div>');
            	
                $data['e']['matkul'] = form_error('matkul', '<div class="has-error">', '</div>');
                $data['e']['jk'] = form_error('jk', '<div class="has-error">', '</div>');
                $data['e']['tanggal'] = form_error('tanggal', '<div class="has-error">', '</div>');
                
            	$data['e']['stime_perday'] = form_error('stime_perday', '<div class="has-error">', '</div>');
                $data['e']['etime_perday'] = form_error('etime_perday', '<div class="has-error">', '</div>');
            
                

            	echo json_encode($data);
            }else{
                
        $d=(implode(", ", $_POST));
            	if($a=$this->bank_soal_model->insert()){
            		$this->userlog->add_log($this->session->userdata['name'], 
            		'INSERT Bank_soal with ID = '.$a['id']
            		.' NAME = '.$d);
                    echo json_encode($a);
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
            //var_dump($_POST);exit();
          /*	$a=$this->bank_soal_model->insert_detail();
            //var_dump($a);exit();
			$result["view"]=($this->load->view('view_tambah_per_detail', $a,TRUE));
            $result["status"]=true;
            echo json_encode($result);

     */     
            if($_POST['sd_master_soal']==''){
                    $this->form_validation->set_rules('master_id', 'Master Soal', 'required');
            }
            $this->form_validation->set_rules('soal', 'Soal', 'required');
            if($_POST['jenis']!='esai'){
            $this->form_validation->set_rules('kunci', 'Kunci Jawaban', 'required');
            
            $this->form_validation->set_rules('a', 'Jawaban A', 'required');
            $this->form_validation->set_rules('b', 'Jawaban B', 'required');
            }
            if($_POST['jenis']=='pilihan'){
                    $this->form_validation->set_rules('c', 'Jawaban C', 'required');
                    $this->form_validation->set_rules('d', 'Jawaban D', 'required');
            }
            if ($this->form_validation->run() == false){
            	$data['status'] = false;
            	$data['e']['soal'] = form_error('soal', '<div class="has-error">', '</div>');
            	$data['e']['kunci'] = form_error('kunci', '<div class="has-error">', '</div>');
            	$data['e']['a'] = form_error('a', '<div class="has-error">', '</div>');
                $data['e']['b'] = form_error('b', '<div class="has-error">', '</div>');
                $data['e']['c'] = form_error('c', '<div class="has-error">', '</div>');
                $data['e']['d'] = form_error('d', '<div class="has-error">', '</div>');
            	$data['e']['master_id'] = form_error('master_id', '<div class="has-error">', '</div>');
            	
            	echo json_encode($data);
            }else{
                if($_POST['sd_master_soal']==''){
                      $d=(implode(", ", $_POST));
                	if($a=$this->bank_soal_model->insert_detail()){
                        if($a['status']==false){
                            echo json_encode($a);    
                        }else{                   
                       
                        $this->userlog->add_log($this->session->userdata['name'], 
                        'INSERT Bank_soal with ID = '.$a['id_soal']
                        .' NAME = '.$d);
                        
                        $result["view"]=($this->load->view('view_tambah_per_detail', $a,TRUE));
                        $result["status"]=true;
                        $result['is_use']='insert';
                        echo json_encode($result);
                        }
                    }
                }else{
                    $d=(implode(", ", $_POST));
                    if($a=$this->bank_soal_model->update_detail()){   
                        if($a['status']==false){
                            echo json_encode($a);    
                        }else{                   
                        $this->userlog->add_log($this->session->userdata['name'], 
                        'Edit Bank_soal with sd_master_soal = '.$_POST['sd_master_soal']
                        .' sd_detailid = '.$_POST['sd_detailid']);
                        
                        $result["view"]=($this->load->view('view_tambah_per_detail', $a,TRUE));
                        $result["status"]=true;
                        $result['is_use']='update';
                        $result['detailid']=$_POST['sd_detailid'];
                        echo json_encode($result);
                        }

                    }                    
                }
            }
		}
	}


        public function edit($id){
        $this->load->helper(array('form', 'url', 'countries'));
        $auth = $this->template->set_auth($this->menu['rule']['panel/bank_soal']['e']);

        if($_POST && $auth){
       
            $this->form_validation->set_rules('master_id', 'Master Soal', 'required');
            $this->form_validation->set_rules('soal', 'Soal', 'required');
            if($_POST['jenis']!='esai'){
            $this->form_validation->set_rules('kunci', 'Kunci Jawaban', 'required');
            
            $this->form_validation->set_rules('a', 'Jawaban A', 'required');
            $this->form_validation->set_rules('b', 'Jawaban B', 'required');
            }
            if($_POST['jenis']=='pilihan'){
                    $this->form_validation->set_rules('c', 'Jawaban C', 'required');
                    $this->form_validation->set_rules('d', 'Jawaban D', 'required');
            }
            if ($this->form_validation->run() == false){
                $data['status'] = false;
                $data['e']['soal'] = form_error('soal', '<div class="has-error">', '</div>');
                $data['e']['kunci'] = form_error('kunci', '<div class="has-error">', '</div>');
                $data['e']['a'] = form_error('a', '<div class="has-error">', '</div>');
                $data['e']['b'] = form_error('b', '<div class="has-error">', '</div>');
                $data['e']['c'] = form_error('c', '<div class="has-error">', '</div>');
                $data['e']['d'] = form_error('d', '<div class="has-error">', '</div>');
                $data['e']['master_id'] = form_error('master_id', '<div class="has-error">', '</div>');
                
                echo json_encode($data);
            }else{
                
            }
        }else{
                    $data=$this->bank_soal_model->edit_data($id);
                    //var_dump($data);exit();
                    $data['menu'] = $this->menu;
                    $data['matkul']=$this->bank_soal_model->get_matkul();
                    
                    $this->userlog->add_log($this->session->userdata['name'], 'ACCESS EDIT BANK SOAL MENU');
                    $this->template->view('view_edit', $data);


        }
    }



    public function update(){

        $this->load->helper(array('form', 'url', 'countries'));
        $auth = $this->template->set_auth($this->menu['rule']['panel/bank_soal']['c']);
        if($_POST && $auth){
            
            $this->form_validation->set_rules('level', 'Level', 'required');
            $this->form_validation->set_rules('kelas', 'Kelas', 'required');
            $this->form_validation->set_rules('jenis', 'Jenis', 'required');
            $this->form_validation->set_rules('matkul', 'Mata Kuliah', 'required');
            $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'required');
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
            $this->form_validation->set_rules('stime_perday', 'Tanggal', 'required');
            $this->form_validation->set_rules('etime_perday', 'Tanggal', 'required');
            
            

            
            if ($this->form_validation->run() == false){
                $data['status'] = false;
                $data['e']['level'] = form_error('level', '<div class="has-error">', '</div>');
                $data['e']['kelas'] = form_error('kelas', '<div class="has-error">', '</div>');
                $data['e']['jenis'] = form_error('jenis', '<div class="has-error">', '</div>');
                
                $data['e']['matkul'] = form_error('matkul', '<div class="has-error">', '</div>');
                $data['e']['jk'] = form_error('jk', '<div class="has-error">', '</div>');
                $data['e']['tanggal'] = form_error('tanggal', '<div class="has-error">', '</div>');
                
                $data['e']['stime_perday'] = form_error('stime_perday', '<div class="has-error">', '</div>');
                $data['e']['etime_perday'] = form_error('etime_perday', '<div class="has-error">', '</div>');
            
                

                echo json_encode($data);
            }else{
                
        $d=(implode(", ", $_POST));
                if($a=$this->bank_soal_model->update()){
                    $this->userlog->add_log($this->session->userdata['name'], 
                    'INSERT Bank_soal with ID = '.$_POST['id_master']
                    .' NAME = '.$d);
                    echo json_encode($a);
                }
            }
        }else{
            $data['matkul']=$this->bank_soal_model->get_matkul();
            $data['menu'] = $this->menu;
            $this->userlog->add_log($this->session->userdata['name'], 'ACCESS INPUT ANGGARAN MENU');
            $this->template->view('view_insert', $data);
        }
    }



	public function edit_detail(){
              $data=$this->bank_soal_model->edit_detail();
              echo json_encode($data);
    }


    public function delete(){
        $auth = $this->template->set_auth($this->menu['rule']['panel/bank_soal']['d']);
        if ($auth) {
            $data=$this->bank_soal_model->delete();
            if ($data['status']==true) {
                /*$this->userlog->add_log($this->session->userdata['name'], ' DELETE CAMPAIGN ID ' . $info[0]->campaign_id . ' DELETE CAMPAIGN NAME ' . $info[0]->campaign_name);
                $data['status'] = true;*/
                print_r(json_encode($data));
            } else {
                $data['status'] = false;
            }
            
        } else {
            $this->template->view('');
        }
    }

	

}
