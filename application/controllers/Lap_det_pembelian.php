<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lap_det_pembelian extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("model_lap_det_pembelian");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    /*if ($this->session->userdata('role') != 3) {
      redirect('auth/login');
    }*/
  }

  public function index()
  {
    $this->load->view('back/pages/v_lap_det_pembelian');
  }

  /*fetch laporan detil pembelian*/
  public function fetch_lap_det_pembelian(){   
     $fetch_data = $this->model_lap_det_pembelian->make_datatables();  
     $data = array();
     $num = 1;
     foreach($fetch_data as $row)  
     {  
        $sub_array = array();
        $sub_array[] = $num++;
        $sub_array[] = $row->tanggal;
        $sub_array[] = $row->no_nota;
        $sub_array[] = $row->kode_barang;
        $sub_array[] = $row->nama_barang;
        $sub_array[] = $row->kode_supp;
        $sub_array[] = $row->nama_supp;
        $sub_array[] = number_format($row->harga_beli);
        $sub_array[] = number_format($row->jumlah);
        $sub_array[] = number_format($row->total_harga_beli);
        
        $data[] = $sub_array;  
     }  
     $output = array(  
        "draw"            => intval($_POST["draw"]),  
        "recordsTotal"    => $this->model_lap_det_pembelian->get_all_data(),  
        "recordsFiltered" => $this->model_lap_det_pembelian->get_filtered_data(),  
        "data"            => $data  
     );  
     echo json_encode($output);  
  }




}


  
