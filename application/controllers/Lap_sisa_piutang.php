<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lap_sisa_piutang extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("Model_lap_sisa_piutang");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    if ($this->session->userdata('role') < 1) {
      redirect('auth/login');
    }
  }

  public function index()
  {
    $this->load->view('back/pages/v_lap_sisa_piutang');
  }
  
  /*fetch master barang*/
  public function fetch_sisa_piutang(){   
     $fetch_data = $this->Model_lap_sisa_piutang->make_datatables();  
     $data = array();
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
          $sub_array[] = $row->id;
          $sub_array[] = $row->no_faktur; 
          $sub_array[] = $row->tanggal;
          $sub_array[] = $row->no_piutang; 
          $sub_array[] = $row->kode_pelanggan;
          $sub_array[] = $row->nama_pelanggan;
          $sub_array[] = $row->total_piutang;  
          $sub_array[] = $row->total_bayar; 
          $sub_array[] = $row->sisa_piutang;
          $sub_array[] = '<button type="button"  name="edit" id="edit"  class="btn bg-blue fa fa-money btn-flat btn-xs"></button>';
          $data[] = $sub_array;  
     }  
     $output = array(  
          "draw"            => intval($_POST["draw"]),  
          "recordsTotal"    => $this->Model_lap_sisa_piutang->get_all_data(),  
          "recordsFiltered" => $this->Model_lap_sisa_piutang->get_filtered_data(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
  }

  //insert  bayar piutang
  public  function insert_bayar_piutang(){
    $insert_data = array(
       'tanggal'        => date('Y-m-d'),
       'jam'            => date("H:i:s"),
       'no_piutang'     => $this->input->post("no_piutang"),
       'jumlah_piutang' => $this->input->post("jumlah_piutang"),
       'jumlah_bayar'   => $this->input->post("bayar_piutang"),
       'user_id'        => $this->session->userdata('id_karyawan'),
    );
    $data = $this->Model_lap_sisa_piutang->insert_bayar_piutang($insert_data);
    $this->Model_lap_sisa_piutang->update_jumlah_bayar();

    //insert ke tbl_kas_flow
    $insert_data = array(
          'no_faktur'   => $this->input->post("no_piutang"),
          'tanggal'     => date('Y-m-d'),  
          'jam'         => date("H:i:s"),
          'arah'        => 'Pemasukan',
          'nilai_masuk' => $this->input->post("bayar_piutang"),
          'nilai_keluar'=> 0,
          'user_id'     => $this->session->userdata('id_karyawan'),
          'keterangan'  => 'Pemasukan pembayaran piutang no_faktur '.$this->input->post("no_faktur")
    );
    $data_kas_flow = $this->Model_lap_sisa_piutang->ins_kas_flow($insert_data);
  }


  //update piutang
  /*public function update_jml_bayar_piutang(){
    $get_jumlah_bayar = $this->Model_lap_sisa_piutang->get_jumlah_bayar()->row_array();
    $jumlah_bayar     = $get_jumlah_bayar['total_bayar'];
    $data = $this->Model_lap_sisa_piutang->update_jumlah_bayar($jumlah_bayar); 

  }*/


}


  
