<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Satuan extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("model_satuan");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    if ($this->session->userdata('role') < 1) {
      redirect('auth/login');
    }
  }

  public function index()
  {
    $this->load->view('back/pages/v_satuan');
  }
/*fetch satuan*/
  public function fetch_satuan(){   
     $fetch_data = $this->model_satuan->make_datatables();  
     $data = array();
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
          $sub_array[] = $row->kode_satuan;
          $sub_array[] = $row->satuan;  
          $sub_array[] = $row->user_reg;
          $sub_array[] = $row->tanggal; 
          $sub_array[] = '<button type="button"  name="delete" id="delete"  class="btn btn-danger glyphicon glyphicon-remove btn-flat btn-xs"></button>'.'&nbsp;'.'<button type="button"  name="edit" id="edit"  class="btn bg-blue glyphicon glyphicon-edit btn-flat btn-xs"></button>';
          $data[] = $sub_array;  
     }  
     $output = array(  
          "draw"            => intval($_POST["draw"]),  
          "recordsTotal"    => $this->model_satuan->get_all_data(),  
          "recordsFiltered" => $this->model_satuan->get_filtered_data(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
    }

  //insert satuan
  public  function insert_satuan(){
    $data          = $this->model_satuan->kode_satuan()->row_array();
    $kode_satuan = $data['kode_satuan']+1;
    $insert_data = array(
       'kode_satuan' => $kode_satuan,
       'satuan'      => trim(strtoupper($this->input->post("nama_satuan"))),
       'user_reg'    => $this->session->userdata('id_karyawan'),
       'tanggal'     => date('Y-m-d')
    );

    $cek_satuan = $this->model_satuan->cek_satuan()->num_rows();
    if ($cek_satuan >0) {
      echo json_encode($cek_satuan);
      return false;
    }
    else
    {
      $data = $this->model_satuan->insert_satuan($insert_data);
      echo json_encode($data);
    }
  }

  //hapus satuan
  public function delete_satuan(){    
    $this->model_satuan->delete_satuan();   
  }

  //update satuan
  public function update_satuan(){
    $cek_satuan = $this->model_satuan->cek_satuan_edit()->num_rows();
    if ($cek_satuan >0) {
      echo json_encode($cek_satuan);
      return false;
    }
    else
    {
      $data = $this->model_satuan->update_satuan(); 
      echo json_encode($data);
    }  
  }     

}


  
