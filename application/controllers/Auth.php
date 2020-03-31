<?php 

class Auth extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('model_userLog');
	}

	function login(){
		if (isset($_POST['submit'])) {
			$user_id 	= $this->input->post('user_id');
			$password 	= $this->input->post('password');
			$result		= $this->model_userLog->login($user_id,$password);
			//$usr_name	= $this->model_userLog->user_name($user_id);
	
			if ($result==1) {
				$name 			= $this->model_userLog->user_name($user_id);
				$get_username 	= $data['user_name'] = $name['user_name'];
				$role 			= $data['role'] 	 = $name['role'];
				$get_image 		= $data['image'] 	 = $name['image'];
				$memb_date 		= $data['date'] 	 = $name['date'];

				$this->session->set_userdata(array('id_karyawan'=>$user_id,'status'=>'login'));
				$this->session->set_userdata(array('user_name'=>$get_username));
				$this->session->set_userdata(array('image'=>$get_image));
				$this->session->set_userdata(array('role'=>$role));
				$this->session->set_userdata(array('memb_date'=>$memb_date));
				redirect('dashboard');
			}else{
				$this->session->set_userdata(array('login_denied'=>'login_denied'));
				redirect('auth/login');
			}
		}
		else{
			$this->load->view('back/auth/login');
		}
	}

	function logout(){
		$this->session->unset_userdata($session_data); 
        $this->session->sess_destroy();
		redirect('auth/login');
	}
	
}