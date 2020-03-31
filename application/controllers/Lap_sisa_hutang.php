<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lap_sisa_hutang extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("Model_lap_sisa_hutang");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    if ($this->session->userdata('role') < 1) {
      redirect('auth/login');
    }
  }

  public function index()
  {
    $this->load->view('back/pages/v_lap_sisa_hutang');
  }
  
  /*fetch master barang*/
  public function fetch_sisa_hutang(){   
     $fetch_data = $this->Model_lap_sisa_hutang->make_datatables();  
     $data = array();
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
          $sub_array[] = $row->id;
          $sub_array[] = $row->no_nota; 
          $sub_array[] = $row->no_hutang; 
          $sub_array[] = $row->kode_supp;
          $sub_array[] = $row->nama_supp;
          $sub_array[] = $row->total_hutang;  
          $sub_array[] = $row->total_bayar; 
          $sub_array[] = $row->sisa_hutang;
          $sub_array[] = '<button type="button"  name="edit" id="edit"  class="btn bg-blue fa fa-money btn-flat btn-xs"></button>';
          $data[] = $sub_array;  
     }  
     $output = array(  
          "draw"            => intval($_POST["draw"]),  
          "recordsTotal"    => $this->Model_lap_sisa_hutang->get_all_data(),  
          "recordsFiltered" => $this->Model_lap_sisa_hutang->get_filtered_data(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
  }

  //insert  bayar hutang
  public  function insert_bayar_hutang(){
    $insert_data = array(
       'tanggal'        => date('Y-m-d'),
       'jam'            => date("H:i:s"),
       'no_nota'        => $this->input->post("no_nota"),
       'no_hutang'      => $this->input->post("no_hutang"),
       'kode_supp'      => $this->input->post("kode_supp"),
       'jumlah_hutang'  => $this->input->post("jumlah_hutang"),
       'jumlah_bayar'   => $this->input->post("bayar_hutang"),
       'user_id'        => $this->session->userdata('id_karyawan'),
    );
    $data = $this->Model_lap_sisa_hutang->insert_bayar_hutang($insert_data);
    $this->Model_lap_sisa_hutang->update_jumlah_bayar();

    //insert ke tbl_kas_flow
    $insert_data = array(
          'no_faktur'   => $this->input->post("no_nota"),
          'tanggal'     => date('Y-m-d'),  
          'jam'         => date("H:i:s"),
          'arah'        => 'Pengeluaran',
          'nilai_masuk' => 0,
          'nilai_keluar'=> $this->input->post("bayar_hutang"),
          'user_id'     => $this->session->userdata('id_karyawan'),
          'keterangan'  => 'Pengeluaran pembayaran hutang nota '.$this->input->post("no_nota")
    );
    $data_kas_flow = $this->Model_lap_sisa_hutang->ins_kas_flow($insert_data);
  }


  //update hutang
  /*public function update_jml_bayar_hutang(){
    $get_jumlah_bayar = $this->Model_lap_sisa_hutang->get_jumlah_bayar()->row_array();
    $jumlah_bayar     = $get_jumlah_bayar['total_bayar'];
    $data = $this->Model_lap_sisa_hutang->update_jumlah_bayar($jumlah_bayar); 

  }*/


}


  
