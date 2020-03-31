<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lap_stock_kosong extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("model_lap_stock_kosong");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    /*if ($this->session->userdata('role') != 3) {
      redirect('auth/login');
    }*/
  }

  public function index()
  {
    $this->load->view('back/pages/v_lap_stock_kosong');
  }
/*fetch lap pembelian*/
  public function fetch_lap_stock_kosong(){   
     $fetch_data = $this->model_lap_stock_kosong->make_datatables();  
     $data = array();
     $num = 1;
     foreach($fetch_data as $row)  
     {  
        $sub_array = array();
        $sub_array[] = $num++;
        $sub_array[] = $row->kode_barang;
        $sub_array[] = $row->nama_barang;
        $sub_array[] = $row->satuan;
        $sub_array[] = $row->nama_kategori;
        $sub_array[] = number_format($row->harga_brg);
        $sub_array[] = $row->terjual;
        $sub_array[] = $row->sales_stock;

        $data[] = $sub_array;  
     }  
     $output = array(  
        "draw"            => intval($_POST["draw"]),  
        "recordsTotal"    => $this->model_lap_stock_kosong->get_all_data(),  
        "recordsFiltered" => $this->model_lap_stock_kosong->get_filtered_data(),  
        "data"            => $data  
     );  
     echo json_encode($output);  
  }

  //update stock
  public function update_stock(){
    $data = $this->model_lap_stock_kosong->update_stock(); 
    echo json_encode($data);
  }

  
}


  
