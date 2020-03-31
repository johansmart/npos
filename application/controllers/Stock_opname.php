<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_opname extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("Model_stock_opname");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    if ($this->session->userdata('role') < 1) {
      redirect('auth/login');
    }
  }

  public function index()
  {
    $this->load->view('back/pages/v_stock_opname');
  }
/*fetch temp stock opname*/
  public function fetch_stock_opname(){   
  $fetch_data = $this->Model_stock_opname->make_datatables();  
     $data = array();
     $num = 1;
     foreach($fetch_data as $row)  
     {  
        $sub_array = array();
        $sub_array[] = $num++;
        $sub_array[] = $row->tanggal;
        $sub_array[] = $row->kode_barang;
        $sub_array[] = $row->nama_barang;
        $sub_array[] = number_format($row->harga_beli);
        $sub_array[] = $row->satuan;
        $sub_array[] = $row->kategori;
        $sub_array[] = $row->sales_stock;
        $sub_array[] = '<input id="post_fisik" value="'.$row->fisik.'" name="post_fisik" type="text" class = "fisik" style="width:100%;height:20px;border-color:white;border: none;background-color:#fcf8e3"></input>';
        //$sub_array[] = '<a href="#" id="edit">'.$row->fisik.'</a>';
        $sub_array[] = $row->fisik - $row->sales_stock;
        $sub_array[] = number_format(($row->fisik - $row->sales_stock) * ($row->harga_beli));
        $sub_array[] = '<a href="#" name="delete" id="delete" class="text-maroon"><i class="fa fa-remove"></i></a>';
        $data[] = $sub_array; 
         
     }  
     $output = array(  
        "draw"            => intval($_POST["draw"]),  
        "recordsTotal"    => $this->Model_stock_opname->get_all_data(),  
        "recordsFiltered" => $this->Model_stock_opname->get_filtered_data(),  
        "data"            => $data  
     );  
     echo json_encode($output);  
    }

  /*fetch master barang*/
  public function fetch_master_barang(){  
     $fetch_data = $this->Model_stock_opname->cari_produk();  
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
          "recordsTotal"    => $this->Model_stock_opname->get_all_data_cari_produk(),  
          "recordsFiltered" => $this->Model_stock_opname->get_filtered_data_cari_produk(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
  }

  //register stock opname
  public  function register_by_product(){
      $insert_data = array(
       'kode_barang' => $this->input->post("kode_barang"),
       'kategori'    => $this->input->post("kategori"),
       'sales_stock' => $this->input->post("stock"),
       'fisik'       => 0,
       'diff'        => 0,
       'diff_value'  => 0,
       'user_id'     => $this->session->userdata('id_karyawan'),
       'tanggal'     => date('Y-m-d'),
       'jam'         => date("H:i:s"),
       'status'      => 'SO-By-Product'
    );
    $cek_barang = $this->Model_stock_opname->cek_barang()->num_rows();  
    if ($cek_barang > 0) {
      echo 'already';
      return false;
    }
    else{
      $data = $this->Model_stock_opname->insert_tmp_stock_opname($insert_data);
      echo json_encode($data);
    }
    
  }

  //insert reg category  
  public function register_by_category(){
    $this->Model_stock_opname->reset_stock_opname();
    $data = $this->Model_stock_opname->get_cat_reg()->result();
      foreach ($data as $d) {
        $insert_data = array(
           'kode_barang' => $d->kode_barang,
           'kategori'    => $this->input->post("kategori"),
           'sales_stock' => $d->sales_stock,
           'fisik'       => 0,
           'diff'        => 0,
           'diff_value'  => 0,
           'user_id'     => $this->session->userdata('id_karyawan'),
           'tanggal'     => date('Y-m-d'),
           'jam'         => date("H:i:s"),
           'status'      => 'SO-By-Category'
        );
        $data = $this->Model_stock_opname->insert_tmp_stock_opname($insert_data);
      }
    echo json_encode($data); 
  }

  //insert reg all product
  public function register_by_allproduct(){
    $this->Model_stock_opname->reset_stock_opname();
    $data = $this->Model_stock_opname->get_all_product_reg()->result();
      foreach ($data as $d) {
        $insert_data = array(
           'kode_barang' => $d->kode_barang,
           'kategori'    => $d->kategori,
           'sales_stock' => $d->sales_stock,
           'fisik'       => 0,
           'diff'        => 0,
           'diff_value'  => 0,
           'user_id'     => $this->session->userdata('id_karyawan'),
           'tanggal'     => date('Y-m-d'),
           'jam'         => date("H:i:s"),
           'status'      => 'SO-By-All-Product'
        );
        $data = $this->Model_stock_opname->insert_tmp_stock_opname($insert_data);
      }
    echo json_encode($data); 
  }

  //update stock
  public function update_fisik(){
    $data = $this->Model_stock_opname->update_fisik(); 
    echo json_encode($data);
  }

  //hapus seluruh isi table temp_beli_barang
  public function reset_form(){    
    $this->Model_stock_opname->clear_temp_stock_opname();   
  }

  //hapus barang register 
  public function delete_register(){    
    $this->Model_stock_opname->delete_register();   
  }

   //insert data ke tbl_pembelian dan tbl_det_pembelian
  public function ins_det_stock_opname(){
    $get_data  = $this->Model_stock_opname->get_temp_stock_opname()->result();
    
    //insert ke table_detai_pembelian
      foreach ($get_data as $data) {
         $insert_data = array(
            'kode_barang' => $data->kode_barang,
            'harga_beli'  => $data->harga_beli, 
            'stock'       => $data->sales_stock,
            'fisik'       => $data->fisik,
            'diff'        => $data->fisik - $data->sales_stock,
            'diff_value'  => $data->fisik - $data->sales_stock * $data->harga_beli, 
            'reg_date'    => $data->tanggal,
            'transf_date' => date('Y-m-d'),
            'transf_time' => date("H:i:s"),
            'user_id'     => $this->session->userdata('id_karyawan'),
        );
        $data = $this->Model_stock_opname->ins_det_stock_opname($insert_data);
      }
      echo json_encode($data);
      $this->Model_stock_opname->update_stock();
      $this->Model_stock_opname->clear_temp_stock_opname();
  }

  //Reset print
  public function reset_stock_opname(){    
    $this->Model_stock_opname->reset_stock_opname();   
  } 
   

}


  
