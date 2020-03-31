<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lap_trans_kartu_kredit extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("model_trans_kartu_kredit");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    /*if ($this->session->userdata('role') != 3) {
      redirect('auth/login');
    }*/
  }

  public function index()
  {
    $this->load->view('back/pages/v_trans_kartu_kredit');
  }

/*fetch lap pembelian*/
  public function fetch_lap_trans_kartu_kredit(){   
     $fetch_data = $this->model_trans_kartu_kredit->make_datatables();  
     $data = array();
     $num = 1;
     foreach($fetch_data as $row)  
     {  
        $sub_array = array();
        $sub_array[] = $num++;
        $sub_array[] = $row->id_kasir;
        $sub_array[] = $row->no_faktur;
        $sub_array[] = $row->tanggal;
        $sub_array[] = $row->jam;
        $sub_array[] = $row->no_kartu;
        $sub_array[] = $row->bank;
        $sub_array[] = number_format($row->jml_debit);
        $sub_array[] = $row->validity;
        $sub_array[] = $row->approval_no; 
        
        $data[] = $sub_array;  
     }  
     $output = array(  
        "draw"            => intval($_POST["draw"]),  
        "recordsTotal"    => $this->model_trans_kartu_kredit->get_all_data(),  
        "recordsFiltered" => $this->model_trans_kartu_kredit->get_filtered_data(),  
        "data"            => $data  
     );  
     echo json_encode($output);  
  }
}


  
