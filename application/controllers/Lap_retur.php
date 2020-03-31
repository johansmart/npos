<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lap_retur extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("model_lap_retur");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    /*if ($this->session->userdata('role') != 3) {
      redirect('auth/login');
    }*/
  }

  public function index()
  {
    $this->load->view('back/pages/v_lap_retur');
  }
/*fetch lap retur*/
  public function fetch_lap_retur(){   
     $fetch_data = $this->model_lap_retur->make_datatables();  
     $data = array();
     $num = 1;
     foreach($fetch_data as $row)  
     {  
        $sub_array = array();
        $sub_array[] = $num++;
        $sub_array[] = $row->id_karyawan;
        $sub_array[] = $row->no_nota;
        $sub_array[] = $row->no_retur;
        $sub_array[] = $row->tanggal;
        $sub_array[] = $row->jam;
        $sub_array[] = $row->kode_supp;
        $sub_array[] = $row->nama_supp;
        $sub_array[] = number_format($row->nilai_retur);
        $data[] = $sub_array;  
     }  
     $output = array(  
        "draw"            => intval($_POST["draw"]),  
        "recordsTotal"    => $this->model_lap_retur->get_all_data(),  
        "recordsFiltered" => $this->model_lap_retur->get_filtered_data(),  
        "data"            => $data  
     );  
     echo json_encode($output);  
  }

  
}


  
