<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_barang extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("model_master_barang");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    if ($this->session->userdata('role') <1) {
      redirect('auth/login');
    }
  }

  public function index()
  {
    $this->load->view('back/pages/v_master_barang');
  }
  
  /*fetch master barang*/
  public function fetch_master_barang(){   
     $fetch_data = $this->model_master_barang->make_datatables();  
     $data = array();
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
          $sub_array[] = $row->id;
          $sub_array[] = $row->kode_barang;  
          $sub_array[] = $row->nama_barang;
          $sub_array[] = $row->satuan;
          $sub_array[] = $row->kode_kategori;  
          $sub_array[] = $row->nama_kategori; 
          $sub_array[] = $row->harga_beli;
          $sub_array[] = $row->harga_brg;
          $sub_array[] = $row->harga_grosir;
          $sub_array[] = $row->kode_supp;
          $sub_array[] = $row->nama_supp;
          $sub_array[] = '<button type="button"  name="delete" id="delete"  class="btn btn-danger glyphicon glyphicon-remove btn-flat btn-xs"></button>'.'&nbsp;'.'<button type="button"  name="edit" id="edit"  class="btn bg-blue glyphicon glyphicon-edit btn-flat btn-xs"></button>';
          $data[] = $sub_array;  
     }  
     $output = array(  
          "draw"            => intval($_POST["draw"]),  
          "recordsTotal"    => $this->model_master_barang->get_all_data(),  
          "recordsFiltered" => $this->model_master_barang->get_filtered_data(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
  }

  //select 2 satuan  
  public function select_satuan(){
     $data = $this->model_master_barang->select_satuan();      
      echo json_encode($data);   
  }

  //select 2 kategori  
  public function select_kategori(){
     $data = $this->model_master_barang->select_kategori();      
      echo json_encode($data);   
  }

  //select 2 supplier  
  public function select_supplier(){
     $data = $this->model_master_barang->select_supplier();      
      echo json_encode($data);   
  }

  //insert  barang
  public  function insert_barang(){
    $get_kode_kategori = $this->model_master_barang->get_kode_kategori()->row_array();
    $get_kode_satuan   = $this->model_master_barang->get_kode_satuan()->row_array();
    $get_kode_supp     = $this->model_master_barang->get_kode_supp()->row_array();
    
    $insert_data = array(
       'kode_barang'   => $this->input->post("kode_barang"),
       'nama_barang'   => trim(strtoupper($this->input->post("nama_barang"))),

       'kode_kategori' => $get_kode_kategori['kode_kategori'],
       'kode_satuan'   => $get_kode_satuan['kode_satuan'],
       'harga_brg'     => $this->input->post("harga_jual"),
       'harga_beli'    => $this->input->post("harga_beli"),

       'kode_supp'     => $get_kode_supp['kode_supp'],
       
       'tgl_reg'       => date('Y-m-d'),
       'user_reg'      => $this->session->userdata('id_karyawan'),
       'book_stock'    => 0,
       'sales_stock'   => 0,
       'harga_grosir'  => $this->input->post("harga_grosir")
    );

    $cek_barang = $this->model_master_barang->cek_barang()->num_rows();
    if ($cek_barang >0) {
      echo json_encode($cek_barang);
      return false;
    }
    else
    {
      $data = $this->model_master_barang->insert_barang($insert_data);
      echo json_encode($data);
    }
  }

  //hapus barang
  public function delete_product(){    
    $this->model_master_barang->delete_product();   
  }

  //update barang
  public function update_product(){
    $get_kode_kategori = $this->model_master_barang->get_kode_kategori()->row_array();
    $get_kode_satuan   = $this->model_master_barang->get_kode_satuan()->row_array();
    $get_kode_supp     = $this->model_master_barang->get_kode_supp()->row_array();

    $kategori = $get_kode_kategori['kode_kategori'];
    $satuan   = $get_kode_satuan['kode_satuan'];
    $supplier = $get_kode_supp['kode_supp'];

    $cek_barang = $this->model_master_barang->cek_barang_edit()->num_rows();
    if ($cek_barang >0) {
      echo json_encode($cek_barang);
      return false;
    }
    else
    {
      $data = $this->model_master_barang->update_product($kategori,$satuan,$supplier); 
      echo json_encode($data);
    }  
  }

  //auto generate barcode  
  public function auto_barcode(){
     $data  = $this->model_master_barang->auto_barcode()->row_array();
     $baris = $data['auto_kode'];
     $reult_barcode = $data['auto_kode']+1; 
     if ($baris=='')
     {
        echo '04001001';
     }
     else
     {
      echo '0'.$reult_barcode;  
     }   
       
  }     

}


  
