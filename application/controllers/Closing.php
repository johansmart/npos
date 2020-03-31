<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Closing extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("model_closing");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    if ($this->session->userdata('role') == 1) {
      redirect('auth/login');
    }
    
  }

  public function index()
  {
    $this->load->view('back/pages/v_closing');
  }

  public function fetch_closing()
  {   
     $fetch_data = $this->model_closing->make_datatables();  
     $data = array();
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
          $sub_array[] = $row->tanggal;
          $sub_array[] = $row->jam;  
          $sub_array[] = $row->id_kasir;
          $sub_array[] = $row->user_name;
          $sub_array[] = $row->no_pos;
          $sub_array[] = number_format($row->end_of_shift_1);  
          $sub_array[] = number_format($row->end_of_shift_2); 
          $sub_array[] = number_format($row->total_kas);
          $sub_array[] = number_format($row->pengeluaran);
          $sub_array[] = number_format($row->kas_akhir);
          $data[] = $sub_array;  
     }  
     $output = array(  
          "draw"            => intval($_POST["draw"]),  
          "recordsTotal"    => $this->model_closing->get_all_data(),  
          "recordsFiltered" => $this->model_closing->get_filtered_data(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
  }

  //get_float
  public function cek_end_shift()
  {
    $cek_end_shift = $this->model_closing->cek_end_shift()->row_array();
    $data = $cek_end_shift['end_shift'];
    echo json_encode($data); 
  }

  //get_float
  public function get_data()
  {
    $baris   = $this->model_closing->get_end_shift_1()->num_rows();
    $shift_1 = $this->model_closing->get_end_shift_1()->row_array();
    $shift_2 = $this->model_closing->get_end_shift_2()->row_array();
    $biaya   = $this->model_closing->get_biaya()->result_array();

    $shft1 = $shift_1['end_shift_1'];
    $shft2 = $shift_2['end_shift_2'];

    foreach($biaya as $row)
    {
       $data_parse[] = $shft1;
       $data_parse[] = $shft2;
       $data_parse[] = $row['biaya'];
    } 

    if ($baris>0) {
     echo json_encode($data_parse); 
    }
    else{
      echo json_encode(0); 
    }
  }

  //insert closing
  public  function insert_closing(){
    $insert_data = array(
       'id_kasir'       => $this->session->userdata('id_karyawan'),
       'tanggal'        => $this->input->post("start_date"),
       'jam'            => date("H:i:s"),
       'no_pos'         => $this->input->post("no_pos"),
       'end_of_shift_1' => $this->input->post("shift_1"),
       'end_of_shift_2' => $this->input->post("shift_2"),
       'total_kas'      => $this->input->post("total_kas"),
       'pengeluaran'    => $this->input->post("pengeluaran"),
       'kas_akhir'      => $this->input->post("kas_akhir")
    );
    $cek_closing = $this->model_closing->cek_closing()->num_rows();
    if ($cek_closing > 0) {
      echo 'already';
      return false;
    }
    /*print_r($insert_data);
    die;*/
    $data = $this->model_closing->insert_closing($insert_data);
    echo json_encode($data);
  }



}


  
