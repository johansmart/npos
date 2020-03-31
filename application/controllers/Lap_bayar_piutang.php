<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lap_bayar_piutang extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("Model_lap_bayar_piutang");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    /*if ($this->session->userdata('role') != 3) {
      redirect('auth/login');
    }*/
  }

  public function index()
  {
    $this->load->view('back/pages/v_lap_bayar_piutang');
  }
/*fetch lap pembelian*/
  public function fetch_lap_bayar_piutang(){   
     $fetch_data = $this->Model_lap_bayar_piutang->make_datatables();  
     $data = array();
     $num = 1;
     foreach($fetch_data as $row)  
     {  
        $sub_array = array();
        $sub_array[] = $num++;
        $sub_array[] = $row->user_id;
        $sub_array[] = $row->no_piutang;
        $sub_array[] = $row->no_faktur;
        $sub_array[] = $row->tanggal;
        $sub_array[] = $row->jam;
        $sub_array[] = $row->kode_pelanggan;
        $sub_array[] = $row->nama_pelanggan;
        $sub_array[] = number_format($row->jumlah_bayar);
        $data[] = $sub_array;  
     }  
     $output = array(  
        "draw"            => intval($_POST["draw"]),  
        "recordsTotal"    => $this->Model_lap_bayar_piutang->get_all_data(),  
        "recordsFiltered" => $this->Model_lap_bayar_piutang->get_filtered_data(),  
        "data"            => $data  
     );  
     echo json_encode($output);  
  }

  
}


  
