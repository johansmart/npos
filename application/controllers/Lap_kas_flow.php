<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lap_kas_flow extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("model_lap_kas_flow");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
  }

  public function index()
  {
    $this->load->view('back/pages/v_lap_kas_flow');
  }
/*fetch lap pembelian*/
  public function fetch_lap_kas_flow(){   
     $fetch_data = $this->model_lap_kas_flow->make_datatables()->result();
     $data_saldo = $this->model_lap_kas_flow->make_datatables()->row_array(); 
    
     $kredit_awal = $data_saldo['nilai_keluar']; 
     $data = array();
     $num = 1;
     foreach($fetch_data as $row)  
     {  
        $sub_array = array();
        $sub_array[] = $num++;
        $sub_array[] = $row->tanggal;
        $sub_array[] = $row->jam;  
        $sub_array[] = $row->user_id;
        $sub_array[] = $row->user_name;
        $sub_array[] = $row->no_faktur;
        $sub_array[] = $row->arah;
        $sub_array[] = $row->nilai_masuk;
        $sub_array[] = $row->nilai_keluar;
        $sub_array[] = $row->Balance;
       /* if ($num<3) {
          $sub_array[] = $saldo_awal;
        }
        else if ($num>2) {
          # code...
        }{

         $sub_array[] = $balance;
        
          
        }*/
        
        $sub_array[] = $row->keterangan; 
        $data[] = $sub_array;  
     }  
     $output = array(  
        "draw"            => intval($_POST["draw"]),  
        "recordsTotal"    => $this->model_lap_kas_flow->get_all_data(),  
        "recordsFiltered" => $this->model_lap_kas_flow->get_filtered_data(),  
        "data"            => $data  
     );  
     echo json_encode($output);  
  }

  
}


  
