<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pelanggan extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("model_master_pelanggan");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    if ($this->session->userdata('role') < 1) {
      redirect('auth/login');
    }
  }

  public function index()
  {
    $this->load->view('back/pages/v_master_pelanggan');
  }
/*fetch user*/
  public function fetch_master_pelanggan(){   
     $fetch_data = $this->model_master_pelanggan->make_datatables();  
     $data = array();
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
          $sub_array[] = $row->kode_pelanggan;
          $sub_array[] = $row->nama_pelanggan; 
          $sub_array[] = $row->alamat; 
          $sub_array[] = $row->no_telepon;
          $sub_array[] = $row->email;
          $sub_array[] = $row->user_reg;
          $sub_array[] = $row->tanggal; 
          $sub_array[] = '<button type="button"  name="delete" id="delete"  class="btn btn-danger glyphicon glyphicon-remove btn-flat btn-xs"></button>'.'&nbsp;'.'<button type="button"  name="edit" id="edit"  class="btn bg-blue glyphicon glyphicon-edit btn-flat btn-xs"></button>';
          $data[] = $sub_array;  
     }  
     $output = array(  
          "draw"            => intval($_POST["draw"]),  
          "recordsTotal"    => $this->model_master_pelanggan->get_all_data(),  
          "recordsFiltered" => $this->model_master_pelanggan->get_filtered_data(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
    }

   //insert data ke tbl_adjust dan tbl_det_adjust
  public function insert_pelanggan()
  {
    //menyiapkan no pelanggan
    $get_kode_pelanggan   = $this->model_master_pelanggan->get_kode_pelanggan()->row_array();
    $data_kode = $get_kode_pelanggan['max_kode']+1;
    $text           = 'PLG-5711';

    if ($data_kode ===1)
    {
      $kode_pelanggan = "0001"; 
    }
    else if ($data_kode > 0 && $data_kode < 10)
    {
      $kode_pelanggan = "000".$data_kode; 
    }
    else if ($data_kode >= 10 && $data_kode < 100)
    {
      $kode_pelanggan = '00'.$data_kode;
    }
    else if ($data_kode >= 100 && $data_kode < 1000)
    {
      $kode_pelanggan ='0'.$data_kode;
    }
      else if ($data_kode >= 1000)
    {
      $kode_pelanggan = $data_kode;
    }
    //selesai menyiapkan kode_pelanggan

    //insert ke table master pelanggan
    $insert_data = array(
      'seq'            => $kode_pelanggan,
      'kode_pelanggan' => $text.'-'.$kode_pelanggan, 
      'nama_pelanggan' => trim(strtoupper($this->input->post("nama_pelanggan"))), 
      'alamat'         => trim(strtoupper($this->input->post("alamat"))), 
      'no_telepon'     => $this->input->post("no_telepon"),
      'email'          => $this->input->post("email"),
      'user_reg'       => $this->session->userdata('id_karyawan'),
      'tanggal'        => date('Y-m-d')
    );
    $data_pelanggan = $this->model_master_pelanggan->insert_pelanggan($insert_data);
    echo json_encode($data_pelanggan);
  }

  //hapus barang
  public function delete_pelanggan(){    
    $this->model_master_pelanggan->delete_pelanggan();   
  }

  //update supplier
  public function update_pelanggan(){
    $data = $this->model_master_pelanggan->update_pelanggan(); 
    echo json_encode($data);
  }     

}


  
