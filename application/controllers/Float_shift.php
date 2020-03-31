<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Float_shift extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("Model_float");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    if ($this->session->userdata('role') == 1) {
      redirect('auth/login');
    }
    
  }

  public function index()
  {
    $this->load->view('back/pages/v_float');
  }

  public function fetch_float()
  {   
     $fetch_data = $this->Model_float->make_datatables();  
     $data = array();
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
          $sub_array[] = $row->tanggal;
          $sub_array[] = $row->jam;  
          $sub_array[] = $row->id_kasir;
          $sub_array[] = $row->user_name;
          $sub_array[] = $row->no_pos;
          $sub_array[] = $row->shift;  
          $sub_array[] = number_format($row->float_value);
          $sub_array[] = number_format($row->end_shift); 
          $data[] = $sub_array;  
     }  
     $output = array(  
          "draw"            => intval($_POST["draw"]),  
          "recordsTotal"    => $this->Model_float->get_all_data(),  
          "recordsFiltered" => $this->Model_float->get_filtered_data(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
  }

  //insert diskon
  public  function insert_float(){
    $insert_data = array(
       'id_kasir'    => $this->input->post("id_kasir"),
       'tanggal'     => date('Y-m-d'),
       'jam'         => date("H:i:s"),
       'no_pos'      => $this->input->post("no_pos"),
       'shift'       => $this->input->post("shift"),
       'float_value' => $this->input->post("setoran_awal"),
       'end_shift'   => 0,
    );
    $cek_float = $this->Model_float->cek_float()->num_rows();
    if ($cek_float > 0) {
      echo 'already';
      return false;
    }
    $data = $this->Model_float->insert_float($insert_data);

    //insert ke tbl_kas_flow
     $insert_data = array(
        'no_faktur'   => $this->input->post("shift"),
        'tanggal'     => date('Y-m-d'),  
        'jam'         => date("H:i:s"),
        'arah'        => 'Pemasukan',
        'nilai_masuk' => $this->input->post("setoran_awal"),
        'nilai_keluar'=> 0,
        'user_id'     => $this->session->userdata('id_karyawan'),
        'keterangan'  => 'Setoran awal '.$this->input->post("shift")
    );
    $data_kas_flow = $this->Model_float->ins_kas_flow($insert_data);
    echo json_encode($data);
  }

  //mengambil data penjualan shift hari ini
  public function get_sales_kasir(){
    $data=$this->Model_float->get_sales_kasir()->row_array();
    $sales_kasir = number_format($data['grand_total']);
    echo $sales_kasir;
  }

  //update nilai end shift pada table float
  public function update_end_shift(){
    $cek_end_shift = $this->Model_float->cek_end_shift()->row_array();
    $end_shift = $cek_end_shift['end_shift'];
    /*print_r($end_shift);
    die;*/
    if ($end_shift > 0) {
      echo 'already';
      return false;
    }
    else if ($end_shift == '') {
      echo 'not_found';
      return false;
    }
    $data=$this->Model_float->update_end_shift();
    echo json_encode($data);
  }


}


  
