<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*initialize escPos*/
require __DIR__ . '/print/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


class Print_hold extends CI_Controller {

	function __construct(){
		parent::__construct();
      $this->load->model("Model_print_hold");
			if($this->session->userdata('status') != "login"){
			redirect('auth/login');
		}
    /*if ($this->session->userdata('role') != 3) {
      redirect('auth/login');
    }*/
	}

public function print_hold_save()
{
  $data = $this->Model_print_hold->get_last_hold()->row_array();
  //$no_faktur = $data['no_faktur'];
  //$item_title = $this->model_print_faktur->get_item_faktur($no_faktur)->row_array();
  //$item_content = $this->model_print_faktur->get_item_faktur($no_faktur)->result();
  /*print_r($data);
  die;*/
  // Enter the share name for your USB printer here
  $connector = new WindowsPrintConnector("EPSON TM-U220 Receipt");
  $printer   = new Printer($connector);

  /* header */
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text("Date ".$data['tanggal'].' '.$data['jam']."\n");
  $printer -> selectPrintMode();
  $printer -> text('--------------------------------');
  $printer -> feed();
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text('POSNO :'.$data['no_pos']);
  $printer -> feed();
  $printer -> text('SAVE NO :'.$data['no_save']);
  $printer -> feed();
  $printer -> text('--------------------------------');
  $printer -> feed();
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text('Kasir :'.$data['id_karyawan'].'-'.$data['user_name']);
  $printer -> feed();
  /* content */
  $printer -> cut();
  /* Close printer */
  $printer -> close();
  echo json_encode('success');
}

/*
error yang dimatikan
Filename: C:\xampp\htdocs\n_pos\application\controllers\print\src\Mike42\Escpos\PrintConnectors\WindowsPrintConnector.php
Line Number: 293
Line Number: 375

*/








}


  
