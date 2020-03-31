<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag_print extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("Model_tag_print");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    if ($this->session->userdata('role') < 1) {
      redirect('auth/login');
    }
  }

  public function index()
  {
    $this->load->view('back/pages/v_tag_print');
  }

  public function fetch_print()
  {   
     $fetch_data = $this->Model_tag_print->make_datatables();  
     $data = array();
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
          $sub_array[] = $row->tanggal;
          $sub_array[] = $row->jam;  
          $sub_array[] = $row->user_id;
          $sub_array[] = $row->user_name;
          $sub_array[] = $row->kode_barang;
          $sub_array[] = $row->nama_barang; 
          $sub_array[] = $row->harga_brg;
          $sub_array[] = $row->kategori;
          $data[] = $sub_array;  
     }  
     $output = array(  
          "draw"            => intval($_POST["draw"]),  
          "recordsTotal"    => $this->Model_tag_print->get_all_data(),  
          "recordsFiltered" => $this->Model_tag_print->get_filtered_data(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
  }

  /*fetch master barang*/
  public function fetch_master_barang(){  
     $fetch_data = $this->Model_tag_print->cari_produk();  
     $data = array();
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
           $sub_array[] = $row->id;
          $sub_array[] = '<a href="#" id="barcode" data-id="'.$row->kode_barang.'">'.$row->kode_barang.'</a>';
          $sub_array[] = $row->nama_barang;
          $sub_array[] = $row->satuan;
          $sub_array[] = $row->kode_kategori.' - '.$row->nama_kategori;
          $sub_array[] = $row->harga_beli;
          $sub_array[] = $row->sales_stock;
          //$sub_array[] = $row->harga_grosir;
          $data[] = $sub_array;  
     }  
     $output = array(  
          "draw"            => intval($_POST["draw"]),  
          "recordsTotal"    => $this->Model_tag_print->get_all_data_cari_produk(),  
          "recordsFiltered" => $this->Model_tag_print->get_filtered_data_cari_produk(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
  }

  //insert manual print
  public  function insert_manual_print(){
    $insert_data = array(
       'tanggal'       => date('Y-m-d'),
       'jam'           => date("H:i:s"),
       'user_id'       => $this->session->userdata('id_karyawan'),
       'kode_barang'   => $this->input->post("kode_barang"),
       'kategori'      => $this->input->post("kategori"),
    );
    $cek_float = $this->Model_tag_print->cek_print()->num_rows();
    if ($cek_float > 0) {
      echo 'already';
      return false;
    }
    $data = $this->Model_tag_print->insert_manual_print($insert_data);
  }

  //Reset print
  public function reset_print(){    
    $this->Model_tag_print->reset_print();   
  } 

  //select 2 kategori  
  public function select_kategori(){
    $data = $this->Model_tag_print->select_kategori();      
    echo json_encode($data);   
  }

  //insert category print  
  public function ins_cat_print(){
    $this->Model_tag_print->reset_print();
    $data = $this->Model_tag_print->get_cat_print()->result();
      foreach ($data as $d) {
        $insert_data = array(
           'tanggal'     => date('Y-m-d'),
           'jam'         => date("H:i:s"),
           'user_id'     => $this->session->userdata('id_karyawan'),
           'kode_barang' => $d->kode_barang,
           'kategori'    => $this->input->post("kategori"),
        );
        $data = $this->Model_tag_print->insert_manual_print($insert_data);
      }
    echo json_encode($data); 
  }

  //insert all print  
  public function ins_all_print(){
    $this->Model_tag_print->reset_print();
    $data = $this->Model_tag_print->get_all_print()->result();
      foreach ($data as $d) {
        $insert_data = array(
           'tanggal'     => date('Y-m-d'),
           'jam'         => date("H:i:s"),
           'user_id'     => $this->session->userdata('id_karyawan'),
           'kode_barang' => $d->kode_barang,
           'kategori'    => $d->kategori,
        );
        $data = $this->Model_tag_print->insert_manual_print($insert_data);
      }
    echo json_encode($data); 
  }

  //print  
 /* public function print_label(){
    //$data = $this->Model_tag_print->get_data_print()->result();
    $data['print_label'] = $this->Model_tag_print->get_data_print()->result(); 
    $this->load->view('back/pages/v_print',$data);

  }*/



}


  
