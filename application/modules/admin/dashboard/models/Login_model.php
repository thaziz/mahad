<?php

class Login_model extends CI_Model {

	private $pref ='';

	function __construct(){
		parent::__construct();
        $this->load->database();
        $this->pref = $this->config->item('tb_pref');
    }
	function validate(){
		//var_dump($_POST);exit();
		$admin = $this->db->where('adm_login',trim($_POST['adm_login']))->
				
		get($this->pref.'admin',1)->row();
		if(!empty($admin)){
			if($admin->adm_active==0){
				$data['valid'] = false;
				$data['error'] = 'The user is inactive';
			}elseif(hash('sha1', trim($_POST['password']))==$admin->adm_password){
				$data['valid'] = true;

				$data['data'] = array(
									'id'=>$admin->adm_id,
									'name'=>$admin->adm_name,
									'bidang_id'=>$admin->adm_bidang,
									
									'bidang'=>$admin->d_name,
									'ext'=>$admin->adm_login,
									'grp_id'=>$admin->grp_id
								);
				//update lastconnection admin user
				$this->db->where('adm_id', $admin->adm_id);
				$this->db->update($this->pref.'admin', 
								array(
									'adm_lastlogin'=>date('Y-m-d H:i:s'),
									'adm_lastlogout'=>NULL,
									'adm_ip'=>$this->input->ip_address()
									)
								);
				$this->db->insert($this->pref.'user_in_log', array('adm_id'=>$admin->adm_id, 'login_time'=>date('Y-m-d H:i:s')));
				$data['data']['in_log_id'] = $this->db->insert_id();
			}else{
				$data['valid'] = false;
				$data['error'] = 'Invalid password';
			}
		}else{
			$data['valid'] = false;
			$data['error'] = 'Invalid extension';
		}
		return $data;
	}
	public function logout($id){
		$this->db->where('adm_id', $id);
		$this->db->update($this->pref.'admin',array('adm_lastlogout'=>date('Y-m-d H:i:s')));
		$this->db->where('id',$this->session->userdata('in_log_id'))->update($this->pref.'user_in_log', array('logout_time'=>date('Y-m-d H:i:s')));
	}
	

}