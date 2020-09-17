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
class Ujian extends MX_Controller {


	/**
	 * 
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'ujian');
		if(!isset($this->menu['rule']['panel/ujian'])){
			show_404();
		}
		$this->load->model('ujian/ujian_model');
		
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		
	}
    public function tes(){
        $data='';
        $this->load->view('baru', $data);
    }
	public function index(){
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/ujian']['v']);
		if($_POST && $auth){
			$list = $this->ujian_model->get_load_result();
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
				$row[] = $admin->ms_startdate.' '.$admin->ms_starttime.' - '.$admin->ms_endtime;
				$row[] = $admin->u_status=='1'?'Selesai':'Proses';
				/*$row[] = $admin->u_nilai_total;*/
				$row[] = $admin->ms_id;				
                $row[] = $masuk;             
				$data[] = $row;
			

        }

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->ujian_model->count_all(),
				"recordsFiltered" => $this->ujian_model->count_filtered(),
				"data" => $data,
			);
			echo json_encode($output);
		}else{
			$data['menu'] = $this->menu;
			//write user activity to logger
			$data['rules'] = $this->menu['rule']['panel/ujian'];
          //  var_dump($data['rules']);exit();
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
            $data['result'] = $this->ujian_model->insert_batch($id, $data);
            $result["status"]=true;
            $data['type']=$_POST['type'];
            $result["view"]=($this->load->view('view_tambah_detail', $data,TRUE));

            echo json_encode($result);
            
        }
    }



    public function insert(){
    	$this->load->helper(array('form', 'url', 'countries'));
    	$auth = $this->template->set_auth($this->menu['rule']['panel/ujian']['c']);
    	if($_POST && $auth){
    		$a=$this->ujian_model->insert();
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
        	$data['matkul']=$this->ujian_model->get_matkul();
        	$data['menu'] = $this->menu;
        	$this->userlog->add_log($this->session->userdata['name'], 'ACCESS INPUT ANGGARAN MENU');
        	$this->template->view('view_insert', $data);
        }
    }


	//ujian 
    public function ujian_ol($id){
    	$this->load->helper(array('form', 'url', 'countries'));
    	$auth = $this->template->set_auth($this->menu['rule']['panel/ujian']['c']);
    	if($_POST && $auth){
    		$a=$this->ujian_model->insert();
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
        	$data=$this->ujian_model->ujian_ol($id);	
        	$data['id']=$id;	
        	$data['menu'] = $this->menu;
        	$this->userlog->add_log($this->session->userdata['name'], 'ACCESS Ujian Online MENU');
        	$this->template->view('view_ujian_ol', $data);
        }
    }

    public function insert_detail(){
    	$this->load->helper(array('form', 'url', 'countries'));
    	$auth = $this->template->set_auth($this->menu['rule']['panel/ujian']['c']);
    	if($_POST && $auth){
    		$a=$this->ujian_model->insert_detail();
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
        //var_dump($_POST);exit();

        $n=0;
        $pilihan=$this->ujian_model->chek_jawaban('pilihan');
        $data=[];
        $_data=[];
        for ($i=1; $i <=$_POST['jenis1'] ; $i++) { 
            if($_POST['type'.$i]=='pilihan'){
                $data=['ud_ujian'=>$_POST['id_ujian'],'ud_master_soal'=>$_POST['ud_master_soal'.$i],
                'ud_detailid'=>$_POST['ud_detailid'.$i],
            ];
                    //var_dump($_POST['jawaban'.$i]);
            if(isset($_POST['jawaban'.$i])){

                if($a=$this->chek($_POST['ud_master_soal'.$i],$_POST['ud_detailid'.$i],$_POST['jawaban'.$i],$pilihan)==1){
                    $n+=$a;
                    $data['ud_jawaban']=$_POST['jawaban'.$i];
                    $data['ud_status']=1;
                }
                else{

                    $data['ud_jawaban']=isset($_POST['jawaban'.$i])?$_POST['jawaban'.$i]:'';
                    $data['ud_status']=0;
                }
            }else{
                
                $data['ud_jawaban']=isset($_POST['jawaban'.$i])?$_POST['jawaban'.$i]:'';
                $data['ud_status']=0;
            }
            $_data[]=$data;
        }
    }

$pilihan=$this->ujian_model->save_jawaban('pilihan',$_POST['id_ujian'],$_data,$n,$_POST['jenis1']);

    $n=0;
    $pilihan=$this->ujian_model->chek_jawaban('bn');
    $data=[];
    $_data=[];

    for ($i=1; $i <=$_POST['jenis2'] ; $i++) { 
        if($_POST['type_bs'.$i]=='bn'){
            $data=['ud_ujian'=>$_POST['id_ujian'],'ud_master_soal'=>$_POST['ud_master_soal_bs'.$i],
            'ud_detailid'=>$_POST['ud_detailid_bs'.$i],
        ];
                    //var_dump($_POST['jawaban'.$i]);
        if(isset($_POST['jawaban_bs'.$i])){
            if($a=$this->chek($_POST['ud_master_soal_bs'.$i],$_POST['ud_detailid_bs'.$i],$_POST['jawaban_bs'.$i],$pilihan)==1){
                $n+=$a;
                $data['ud_jawaban']=$_POST['jawaban_bs'.$i];
                $data['ud_status']=1;
            }
            else{
                
                $data['ud_jawaban']=isset($_POST['jawaban_bs'.$i])?$_POST['jawaban_bs'.$i]:'';
                $data['ud_status']=0;
            }
        }else{

            $data['ud_jawaban']=isset($_POST['jawaban_bs'.$i])?$_POST['jawaban_bs'.$i]:'';
            $data['ud_status']=0;
        }
        $_data[]=$data;
    }
}

$pilihan=$this->ujian_model->save_jawaban('bn',$_POST['id_ujian'],$_data,$n,$_POST['jenis2']);

//exit();
var_dump($n);exit();

}

public function save_per_soal($id){
    $a=$this->ujian_model->save_per_soal();
    echo json_encode($a);
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
	$auth = $this->template->set_auth($this->menu['rule']['panel/ujian']['e']);
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

public function selesai($id){
        $a=$this->ujian_model->selesai($id);
        echo json_encode($a);
}



 public function b($id){
        $this->load->helper(array('form', 'url', 'countries'));
        $auth = $this->template->set_auth($this->menu['rule']['panel/ujian']['c']);
        if($_POST && $auth){
            $a=$this->ujian_model->insert();
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
            $data=$this->ujian_model->ujian_ol($id);    
            $data['id']=$id;    
            $data['menu'] = $this->menu;
            $this->userlog->add_log($this->session->userdata['name'], 'ACCESS Ujian Online MENU');
            $this->template->view('bck', $data);
        }
    }



}
