<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lap_penj_perbarang extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("model_lap_penj_perbarang");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    /*if ($this->session->userdata('role') != 3) {
      redirect('auth/login');
    }*/
  }

  public function index()
  {
    $this->load->view('back/pages/v_lap_penj_perbarang');
  }

  /*fetch laporan detil penjualan*/
  public function fetch_lap_penj_perbarang(){   
     $fetch_data = $this->model_lap_penj_perbarang->make_datatables();  
     $data = array();
     $num = 1;
     foreach($fetch_data as $row)  
     {  
        $sub_array = array();
        $sub_array[] = $num++;
        $sub_array[] = $row->kode_barang;
        $sub_array[] = $row->nama_barang;
        //$sub_array[] = number_format($row->harga_beli);
        $sub_array[] = number_format($row->qty);
        //$sub_array[] = number_format($row->discount);
        $sub_array[] = number_format($row->total);
        //$sub_array[] = number_format($row->nilai_hrg_beli);
        $sub_array[] = number_format($row->profit);
        $data[] = $sub_array;  
     }  
     $output = array(  
        "draw"            => intval($_POST["draw"]),  
        "recordsTotal"    => $this->model_lap_penj_perbarang->get_all_data(),  
        "recordsFiltered" => $this->model_lap_penj_perbarang->get_filtered_data(),  
        "data"            => $data  
     );  
     echo json_encode($output);  
  }
}


  
