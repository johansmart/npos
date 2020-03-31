<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lap_penjualan extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("model_lap_penjualan");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    /*if ($this->session->userdata('role') != 3) {
      redirect('auth/login');
    }*/
  }

  public function index()
  {
    $this->load->view('back/pages/v_lap_penjualan');
  }

/*fetch lap pembelian*/
  public function fetch_lap_penjualan(){   
     $fetch_data = $this->model_lap_penjualan->make_datatables();  
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
        $sub_array[] = number_format($row->total);
        $sub_array[] = number_format($row->discount);
        $sub_array[] = number_format($row->grand_total);
        $sub_array[] = number_format($row->bayar);
        $sub_array[] = number_format($row->kembali); 
        $sub_array[] = $row->tipe_bayar;
        
        $data[] = $sub_array;  
     }  
     $output = array(  
        "draw"            => intval($_POST["draw"]),  
        "recordsTotal"    => $this->model_lap_penjualan->get_all_data(),  
        "recordsFiltered" => $this->model_lap_penjualan->get_filtered_data(),  
        "data"            => $data  
     );  
     echo json_encode($output);  
  }
}


  
