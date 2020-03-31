<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promo extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("Model_promo");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    if ($this->session->userdata('role') < 1) {
      redirect('auth/login');
    }
  }

  public function index()
  {
    $this->load->view('back/pages/v_promo');
  }
/*fetch user*/
  public function fetch_promo(){   
     $fetch_data = $this->Model_promo->make_datatables();  
     $data = array();
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
          $sub_array[] = $row->id;
          $sub_array[] = $row->barcode;  
          $sub_array[] = $row->nama_barang;
          $sub_array[] = $row->harga_brg;
          $sub_array[] = $row->harga_promo; 
          $sub_array[] = $row->tgl_mulai; 
          $sub_array[] = $row->tgl_selesai; 
          $sub_array[] = $row->userid;
          $data[] = $sub_array;  
     }  
     $output = array(  
          "draw"            => intval($_POST["draw"]),  
          "recordsTotal"    => $this->Model_promo->get_all_data(),  
          "recordsFiltered" => $this->Model_promo->get_filtered_data(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
    }


  /*get item info*/
  public function get_item_info()
  {
    $data = $this->Model_promo->get_item_info()->row_array();
    $row  = $this->Model_promo->get_item_info()->num_rows();
/*    print_r($data);
    die;*/
    $item_info = array(
        $data['nama_barang'],
        $data['satuan'],
        $data['kode_supp'],
        $data['harga_brg'],
        //$data['sales_stock']
    );
    if ($row > 0)
    {
     echo json_encode($item_info);
    }
    else
    {
       echo json_encode($row);
    }
  }

  //insert promo
  public  function insert_promo(){
    $insert_data = array(
       'barcode'      => $this->input->post("kode_barang"),
       'nama_barang'  => trim(strtoupper($this->input->post("nama_barang"))),
       'harga_brg'    => $this->input->post("harga_brg"),
       'harga_promo'  => $this->input->post("harga_promo"),
       'tgl_mulai'    => $this->input->post("start_date"),
       'tgl_selesai'  => $this->input->post("end_date"),
       'userid'       => $this->session->userdata('id_karyawan'),
       'date'         => date('Y-m-d')
    );

    $data = $this->Model_promo->insert_promo($insert_data);
    echo json_encode($data);
  }

  


}


  
