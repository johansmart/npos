<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->session->userdata('status') != "login"){
			redirect('auth/login');
		}
	}

	public function index(){
		$this->load->view('back/pages/v_profile');
	}
		/*cek user_id exist*/
	public function get_old_pass(){
	    $old_pass=$this->input->post('old_pass');
	    $this->load->model("profile_model"); 
	    $data = $this->profile_model->cek_old_pass($old_pass);
	    echo $data;
	}

	public  function update_pass(){
	    $this->load->model('profile_model');
	    $data=$this->profile_model->update_pass();
	    echo json_encode($data);
	}

	public  function update_image(){
		$user_id= $this->session->userdata('user_id');
	    $user_image = $this->upload_image();
	    $this->load->model('profile_model');
	    $result		= $this->profile_model->update_image($user_image,$user_id);
	   	echo $result;
	    
	}

	/*upload image*/
	public function upload_image(){   
       if($_FILES["user_image"] !='')  
       {    
          $extension = explode('.', $_FILES['user_image']['name']);
          if ($_FILES['user_image']['name'] !='') {
             $new_name = rand() . '.' . $extension[1]; 
            }
           else{
            $new_name =  '010101.jpg'; 
           }   
           
          $destination = './upload/img_user/' . $new_name;  
          move_uploaded_file($_FILES['user_image']['tmp_name'], $destination);  
          return $new_name;  
       }
	}

	    
}
