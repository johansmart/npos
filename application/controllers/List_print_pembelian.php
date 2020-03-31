<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class List_print_pembelian extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("Model_list_print_pembelian");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    if ($this->session->userdata('role') < 1) {
      redirect('auth/login');
    }
  }

  public function index()
  {
    $this->load->view('back/pages/v_list_print_pembelian');
  }
  
  /*fetch master barang*/
  public function fetch_list_print(){   
     $fetch_data = $this->Model_list_print_pembelian->make_datatables();  
     $data = array();
     $num = 1;
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
          $sub_array[] = $num++;
          $sub_array[] = $row->tanggal; 
          $sub_array[] = $row->purc_no;
          $sub_array[] = $row->kode_supp; 
          $sub_array[] = $row->nama_supp;
          $sub_array[] = $row->total_beli;
          $sub_array[] = $row->tipe_bayar;  
          $sub_array[] = $row->id_karyawan; 
          $sub_array[] = '<a href="'.base_url("print_pembelian/prev/".$row->purc_no).'" id="print"  class="btn bg-blue fa fa-print btn-flat btn-xs"></a>';
          $data[] = $sub_array;  
     }  
     $output = array(  
          "draw"            => intval($_POST["draw"]),  
          "recordsTotal"    => $this->Model_list_print_pembelian->get_all_data(),  
          "recordsFiltered" => $this->Model_list_print_pembelian->get_filtered_data(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
  }


}


  
