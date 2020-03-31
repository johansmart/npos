<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biaya extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("model_biaya");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    if ($this->session->userdata('role') < 1) {
      redirect('auth/login');
    }
  }

  public function index()
  {
    $this->load->view('back/pages/v_biaya');
  }

  public function fetch_biaya()
  {   
     $fetch_data = $this->model_biaya->make_datatables();  
     $data = array();
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
          $sub_array[] = $row->tanggal;
          $sub_array[] = $row->jam;  
          $sub_array[] = $row->user_id;
          $sub_array[] = $row->user_name;
          $sub_array[] = $row->id_biaya;
          $sub_array[] = $row->jenis_biaya;
          $sub_array[] = $row->nilai_biaya;
          $sub_array[] = $row->keterangan;  
          $data[] = $sub_array;  
     }  
     $output = array(  
          "draw"            => intval($_POST["draw"]),  
          "recordsTotal"    => $this->model_biaya->get_all_data(),  
          "recordsFiltered" => $this->model_biaya->get_filtered_data(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
  }

  //select 2 biaya  
  public function select_biaya(){
     $data = $this->model_biaya->select_biaya();      
      echo json_encode($data);   
  }

  //insert  barang
  public  function insert_biaya(){
    $get_id_biaya = $this->model_biaya->get_id_biaya()->row_array();
    $insert_data = array(
       'user_id'     => $this->session->userdata('id_karyawan'),
       'tanggal'     => date('Y-m-d'),
       'jam'         => date("H:i:s"),
       'id_biaya'    => $get_id_biaya['id_biaya'],
       'nilai_biaya' => $this->input->post("nilai_biaya"),
       'keterangan'  => trim($this->input->post("keterangan"))
    );
    $data = $this->model_biaya->insert_biaya($insert_data);

    //insert ke tbl_kas_flow
     $insert_data = array(
        'no_faktur'   => $get_id_biaya['id_biaya'],
        'tanggal'     => date('Y-m-d'),  
        'jam'         => date("H:i:s"),
        'arah'        => 'Pengeluaran',
        'nilai_masuk' => 0,
        'nilai_keluar'=> $this->input->post("nilai_biaya"),
        'user_id'     => $this->session->userdata('id_karyawan'),
        'keterangan'  => trim($this->input->post("keterangan"))
    );
    $data_kas_flow = $this->model_biaya->ins_kas_flow($insert_data);
    echo json_encode($data);
 
  }



}


  
