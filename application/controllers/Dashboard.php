<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct(){
		parent::__construct();
         $this->load->model('model_dashboard');  
			if($this->session->userdata('status') != "login"){
			redirect('auth/login');
		}
	}

	public function index(){
		$this->load->view('back/pages/v_dashboard');
	}
	

	public  function jml_barang(){
      $data = $this->model_dashboard->jml_barang();
      echo number_format($data);
	}

	public  function stock_kosong(){
      $data = $this->model_dashboard->stock_kosong();
      echo number_format($data);
	}

	public  function sales_hari_ini(){
      $data = $this->model_dashboard->sales_hari_ini();
      $sls_hari_ini = $data['sales_today'];
      echo number_format($sls_hari_ini);

	}

	public  function sales_bulan_ini(){
      $data = $this->model_dashboard->sales_bulan_ini();
      $sls_bln_ini = $data['sales_month'];
      echo number_format($sls_bln_ini);
	}

	public  function getdata_chart_date(){
      $theDate = date('d'); 
      $data = $this->model_dashboard->getdata_chart_date();
      echo json_encode($data);
	}


   public  function getdata_chart_time(){  
      $data = $this->model_dashboard->getdata_chart_time();
      echo json_encode($data);
    }

  
}
