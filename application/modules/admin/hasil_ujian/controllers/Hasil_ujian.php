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
class Hasil_ujian extends MX_Controller {


	/**
	 * 
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'hasil ujian');
		if(!isset($this->menu['rule']['panel/hasil_ujian'])){
			show_404();
		}
		$this->load->model('hasil_ujian/hasil_ujian_model');
        $this->load->model('hasil_ujian/list_ujian_model');
		
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		
	}

	public function index(){
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/hasil_ujian']['v']);
		if($_POST && $auth){
			$list = $this->hasil_ujian_model->get_load_result();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $admin) {
                $masuk='disabled=""';
            if(strtotime(date('H:i:s')) >=strtotime($admin->ms_starttime) &&
                strtotime(date('H:i:s'))<=strtotime($admin->ms_endtime)){         
                $masuk='';
            }
				$no++;
				$row = array();	            
				$row[] = $admin->subject_ar_name;
                $row[] =$admin->ms_level.' '.$admin->ms_kelas;	
				$row[] = $admin->ms_startdate.' '.$admin->ms_starttime.' '.$admin->ms_endtime;
				$row[] = $admin->ms_id;				
                $row[] = $masuk;             
				$data[] = $row;
			

        }

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->hasil_ujian_model->count_all(),
				"recordsFiltered" => $this->hasil_ujian_model->count_filtered(),
				"data" => $data,
			);
			echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/hasil_ujian'];
          //  var_dump($data['rules']);exit();
			$this->userlog->add_log($this->session->userdata['name'], 'ACCESS Hasil Ujian MENU');
			$this->template->view('view_index', $data);
		}
	}


	public function list($id)
	{
        $auth = $this->template->set_auth($this->menu['rule']['panel/hasil_ujian']['v']);
        if($_POST && $auth){
            $list = $this->list_ujian_model->get_load_result($id);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $admin) {
                
                $no++;
                $row = array();             
                $row[] = $admin->adm_name;
                $row[] = $admin->subject_ar_name;
                $row[] =$admin->ms_level.' '.$admin->ms_kelas;  
                $row[] =$admin->u_nilai_pilihan;
                $row[] =$admin->u_nilai_benarsalah;
                $row[] =$admin->u_nilai_esai;
                $row[] =$admin->u_nilai_total;
                $row[] = $admin->u_id;                                       
                $data[] = $row;
            

        }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->list_ujian_model->count_all($id),
                "recordsFiltered" => $this->list_ujian_model->count_filtered($id),
                "data" => $data,
            );
            echo json_encode($output);
        }else{
            $data['menu'] = $this->menu;
            $data['id'] = $id;
            //write user activity to logger
            $data['rules'] = $this->menu['rule']['panel/hasil_ujian'];
          //  var_dump($data['rules']);exit();
            $this->userlog->add_log($this->session->userdata['name'], 'ACCESS Hasil Ujian MENU');
            $this->template->view('view_list', $data);     
        }
        
    }



    public function insert(){
    	$this->load->helper(array('form', 'url', 'countries'));
    	$auth = $this->template->set_auth($this->menu['rule']['panel/hasil_ujian']['c']);
    	if($_POST && $auth){
    		$a=$this->hasil_ujian_model->insert();
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
        	$data['matkul']=$this->hasil_ujian_model->get_matkul();
        	$data['menu'] = $this->menu;
        	$this->userlog->add_log($this->session->userdata['name'], 'ACCESS INPUT ANGGARAN MENU');
        	$this->template->view('view_insert', $data);
        }
    }


	//ujian 
    public function ujian_ol($id){
    	$this->load->helper(array('form', 'url', 'countries'));
    	$auth = $this->template->set_auth($this->menu['rule']['panel/hasil_ujian']['c']);
    	if($_POST && $auth){
    		$a=$this->hasil_ujian_model->insert();
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
        	$data=$this->hasil_ujian_model->ujian_ol($id);	
        	$data['id']=$id;	
        	$data['menu'] = $this->menu;
        	$this->userlog->add_log($this->session->userdata['name'], 'ACCESS Ujian Online MENU');
        	$this->template->view('view_ujian_ol', $data);
        }
    }

    public function insert_detail(){
    	$this->load->helper(array('form', 'url', 'countries'));
    	$auth = $this->template->set_auth($this->menu['rule']['panel/hasil_ujian']['c']);
    	if($_POST && $auth){
    		$a=$this->hasil_ujian_model->insert_detail();
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
  
public function save($id){

    $data=['u_nilai_pilihan'=>$_POST['nilai_pilihan'],
            'u_nilai_benarsalah'=>$_POST['nilai_bs'],
            'u_nilai_esai'=>$_POST['nilai_esai'],
            'u_nilai_total'=>$_POST['total']
          ];
    $this->db->where('u_id',$id);
  $a=$this->db->update('ujian',$data);
  echo json_encode($a);
        
}

public function save_per_soal($id){
    $this->hasil_ujian_model->save_per_soal();
}

public function chek($id,$detail,$kunci,$data){
	$a=0;
	foreach ($data as $k => $v) {

		if($id==$v->sd_master_soal && $detail==$v->sd_detailid && strtolower($kunci)==strtolower($v->sd_kunci)){

			$a=1;
		}
	}
	return $a;
}

public function edit($id){
	$this->load->helper(array('form', 'url', 'countries'));
	$auth = $this->template->set_auth($this->menu['rule']['panel/hasil_ujian']['e']);
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
	$auth = $this->template->set_auth($this->menu['rule']['panel/hasil_ujian']['d']);
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



public function detail_ujian($id){
    $auth = $this->template->set_auth($this->menu['rule']['panel/hasil_ujian']['v']);
    if($auth){
        
        $data=$this->list_ujian_model->detail_ujian($id);
        //var_dump($data);exit();
        $data['menu'] = $this->menu;
        $data['id']=$id;
            //write user activity to logger
        $data['rules'] = $this->menu['rule']['panel/hasil_ujian'];
          //  var_dump($data['rules']);exit();
        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS Detail Per Hasil Ujian MENU');
        $this->template->view('view_ujian', $data);
    }else{
        $this->template->view('');
    }
}

}
