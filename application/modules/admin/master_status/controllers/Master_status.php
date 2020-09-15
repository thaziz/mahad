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
class Master_status extends MX_Controller {


	/**
	 * 
	 */

	public function __construct(){
		//check if the user has logged in, otherwise redirect to login page
		if(!isset($this->session->userdata['logged_in'])){
			redirect(base_url('panel/login'));
		}
		$this->menu = $this->menu_model->load_menu('admin', 'bidang');
		if(!isset($this->menu['rule']['panel/master_status'])){
			show_404();
		}
		$this->load->model('master_status/master_status_model');
		
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'The %s is exist, try another one.');
		
	}

	public function index(){
		//check the privileges of the user
		$auth = $this->template->set_auth($this->menu['rule']['panel/master_status']['v']);
		if($_POST && $auth){
			$list = $this->master_status_model->get_load_result();
	        $data = array();
	        $no = $_POST['start'];
	        foreach ($list as $admin) {
	            $no++;
	         
	            $row = array();	            
	            $row[] = $admin->name;	
	            $row[] = $admin->enabled;	          
	            $row[] = $admin->id;
	            $data[] = $row;
	        }
	 
	        $output = array(
	                        "draw" => $_POST['draw'],
	                        "recordsTotal" => $this->master_status_model->count_all(),
	                        "recordsFiltered" => $this->master_status_model->count_filtered(),
	                        "data" => $data,
	                );
	        echo json_encode($output);
		}else{

            $data['menu'] = $this->menu;
            //write user activity to logger
            $data['rules'] = $this->menu['rule']['panel/master_status'];
           // var_dump($data['rules']);exit();
	        $this->userlog->add_log($this->session->userdata['name'], 'ACCESS ADMINISTRATOR MENU');
			$this->template->view('view_index', $data);
		}
	}


	

}
