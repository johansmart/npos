<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lap_biaya extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("model_lap_biaya");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
  }

  public function index()
  {
    $this->load->view('back/pages/v_lap_biaya');
  }
/*fetch lap pembelian*/
  public function fetch_lap_biaya(){   
     $fetch_data = $this->model_lap_biaya->make_datatables();  
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
        $sub_array[] = $row->id_biaya;
        $sub_array[] = $row->jenis_biaya;
        $sub_array[] = $row->nilai_biaya;
        $sub_array[] = $row->keterangan; 
        $data[] = $sub_array;  
     }  
     $output = array(  
        "draw"            => intval($_POST["draw"]),  
        "recordsTotal"    => $this->model_lap_biaya->get_all_data(),  
        "recordsFiltered" => $this->model_lap_biaya->get_filtered_data(),  
        "data"            => $data  
     );  
     echo json_encode($output);  
  }

  
}


  
