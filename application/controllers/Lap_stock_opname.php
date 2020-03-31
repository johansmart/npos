<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lap_stock_opname extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("model_lap_stock_opname");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    /*if ($this->session->userdata('role') != 3) {
      redirect('auth/login');
    }*/
  }

  public function index()
  {
    $this->load->view('back/pages/v_lap_stock_opname');
  }

  /*fetch laporan detil pembelian*/
  public function fetch_lap_stock_opname(){   
     $fetch_data = $this->model_lap_stock_opname->make_datatables();  
     $data = array();
     $num = 1;
     foreach($fetch_data as $row)  
     {  
        $sub_array = array();
        $sub_array[] = $num++;
        $sub_array[] = $row->transf_date;
        $sub_array[] = $row->transf_time;
        $sub_array[] = $row->kode_barang;
        $sub_array[] = $row->nama_barang;
        $sub_array[] = $row->stock;
        $sub_array[] = $row->fisik;
        $sub_array[] = $row->diff;
        $sub_array[] = number_format($row->diff_value);
        $sub_array[] = $row->user_id;
        $data[] = $sub_array;  
     }  
     $output = array(  
        "draw"            => intval($_POST["draw"]),  
        "recordsTotal"    => $this->model_lap_stock_opname->get_all_data(),  
        "recordsFiltered" => $this->model_lap_stock_opname->get_filtered_data(),  
        "data"            => $data  
     );  
     echo json_encode($output);  
  }




}


  
