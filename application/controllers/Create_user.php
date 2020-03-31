<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_user extends CI_Controller {

	function __construct(){
		parent::__construct();
			if($this->session->userdata('status') != "login"){
			redirect('auth/login');
		}
    if ($this->session->userdata('role') != 3) {
      redirect('auth/login');
    }
	}

	public function index()
	{
		$this->load->view('back/pages/v_create_user');
	}
/*fetch user*/
	public function fetch_user(){  
     $this->load->model("crud_model");  
     $fetch_data = $this->crud_model->make_datatables();  
     $data = array();
     $no_image = '010101.jpg'; 
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();

          $sub_array[] = '<img src="'.base_url().'upload/img_user/'.$row->image.'" class="img-thumbnail" width="50" height="35" style="width: 60px;height: 70px"/>';
          $sub_array[] = $row->user_id;  
          $sub_array[] = $row->user_name;
          $sub_array[] = $row->role;
          $sub_array[] = $row->date;  
          $sub_array[] = $row->created;      
          $sub_array[] = '<button type="button" name="update" id="update" data-id="'.$row->id.'" class="btn btn-primary glyphicon glyphicon-edit btn-xs btn-flat"></button>&nbsp;<button type="button" name="delete" id="delete" data-id="'.$row->id.'" class="btn btn-danger glyphicon glyphicon-remove btn-flat btn-xs"></button>';  
          /*$sub_array[] = '<button type="button" name="delete" id="delete" data-id="'.$row->id.'" class="btn btn-danger glyphicon glyphicon-remove btn-flat btn-xs"></button>';  */
          $data[] = $sub_array;  
     }  
     $output = array(  
          "draw"            => intval($_POST["draw"]),  
          "recordsTotal"    => $this->crud_model->get_all_data(),  
          "recordsFiltered" => $this->crud_model->get_filtered_data(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
    }
/*insert user*/
  public  function user_action(){
      $insert_data = array(  
           'user_id'   => $this->input->post('user_id'),  
           'user_name' => trim(strtoupper($this->input->post("user_name"))), 
           'password'  => md5($this->input->post("password")),
           'image'     => $this->upload_image(),
           'role'      => $this->input->post("role"),
           'date'      => date('Y-m-d'),
           'created'   => $this->session->userdata('id_karyawan')

      );  
      $this->load->model('crud_model');  
      $data = $this->crud_model->insert_crud($insert_data);
      echo json_encode($data);  
  }
/*update user*/
  public  function update_user(){
      $this->load->model('crud_model');
      $data=$this->crud_model->update_crud();
      echo json_encode($data);
  }  
/*upload image*/
  public function upload_image()  
  {  
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
/*delete user*/
  public function delete_single_user()  
  {  
       $this->load->model("crud_model");  
       $this->crud_model->delete_single_user();   
  }

  /*delete user*/
  public function max_user_id()  
  {  
       $this->load->model("crud_model");  
       $data = $this->crud_model->max_user_id();
       $user_id  = $data['user_id'];
       if ($user_id > 0) {
         echo $user_id+1;
       }
       else{
        echo "1320001";
       }
  } 

}


  
