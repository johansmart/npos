<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_in extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("Model_store_in");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    if ($this->session->userdata('role') < 1) {
      redirect('auth/login');
    }
  }

  public function index()
  {
    $this->load->view('back/pages/v_store_in');
  }
/*fetch user*/
  public function fetch_store_in(){   
     $fetch_data = $this->Model_store_in->make_datatables();  
     $data = array();
     $num = 1;
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
          $sub_array[] = $num++;
          $sub_array[] = $row->tanggal;
          $sub_array[] = $row->jam;
          $sub_array[] = $row->kode_barang;  
          $sub_array[] = $row->nama_barang;
          $sub_array[] = $row->satuan;
          $sub_array[] = $row->nama_kategori;
          $sub_array[] = $row->stock_awal; 
          $sub_array[] = $row->qty;
          $sub_array[] = $row->stock_akhir;
          $data[] = $sub_array;  
     }  
     $output = array(  
          "draw"            => intval($_POST["draw"]),  
          "recordsTotal"    => $this->Model_store_in->get_all_data(),  
          "recordsFiltered" => $this->Model_store_in->get_filtered_data(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
    }

  /*get item info*/
  public function get_item_info()
  {
    $data = $this->Model_store_in->get_item_info()->row_array();
    $row  = $this->Model_store_in->get_item_info()->num_rows();
    $item_info = array(
        $data['nama_barang'],
        $data['satuan'],
        $data['harga_brg'],
        $data['sales_stock']
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
    
  //insert  barang
  public  function insert_barang(){
    $insert_data = array(
       'kode_barang'  => $this->input->post("kode_barang"),
       'stock_awal'   => $this->input->post("stock"),
       'qty'          => $this->input->post("qty"),
       'stock_akhir'  => $this->input->post("stock")+$this->input->post("qty"),
       'tanggal'      => date('Y-m-d'),
       'jam'          => date("H:i:s"),
       'user_id'      => $this->session->userdata('id_karyawan')
      );

      $kode_barang = $this->input->post("kode_barang");
      $this->Model_store_in->cek_barang($kode_barang);
      $row  = $this->Model_store_in->get_item_info()->num_rows();
      if ($row ==0) {
        echo 'empty_err';
        return false;
      }
      else{
        $data = $this->Model_store_in->insert_barang($insert_data);
        $kode_barang = $this->input->post("kode_barang");
        $jumlah      = $this->input->post("qty");
        $this->Model_store_in->update_stock($kode_barang,$jumlah);
        echo json_encode($data);
      }
      
  }

   

}


  
