<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*initialize escPos*/
require __DIR__ . '/print/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


class Print_closing extends CI_Controller {

	function __construct(){
		parent::__construct();
      $this->load->model("Model_print_closing");
			if($this->session->userdata('status') != "login"){
			redirect('auth/login');
		}
    /*if ($this->session->userdata('role') != 3) {
      redirect('auth/login');
    }*/
	}

public function print_closing()
{
  $data = $this->Model_print_closing->get_last_closing()->row_array();
  $rincian = $this->Model_print_closing->get_rincian_trx()->result();
  //$no_faktur = $data['no_faktur'];
  //$item_title = $this->model_print_faktur->get_item_faktur($no_faktur)->row_array();
  //$item_content = $this->model_print_faktur->get_item_faktur($no_faktur)->result();
/*  print_r($rincian);
  die;*/
  // Enter the share name for your USB printer here
  $connector = new WindowsPrintConnector("EPSON TM-U220 Receipt");
  $printer   = new Printer($connector);

  /* header */
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text("CLOSING HARIAN\n");
  $printer -> selectPrintMode();
  $printer -> text("--------------------------------\n");
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text("Print Date ".date('Y-m-d').' '.date("H:i:s")."\n");
  $printer -> selectPrintMode();
  $printer -> text("--------------------------------\n");
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text('Setoran Akhir Shift 1 : '.$data['end_of_shift_1']."\n");
  $printer -> text('Setoran Akhir Shift 2 : '.$data['end_of_shift_2']."\n");
  $printer -> text("--------------------------------\n");

  $printer -> text("Rincian\n");
  $printer -> text("--------------------------------\n");
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  foreach ($rincian as $rincian) { 
    $printer -> text($rincian->tipe_bayar." : ".$rincian->grand_total."\n");
  }

  $printer -> text("--------------------------------\n");

  $printer -> text('Total Kas :'.$data['total_kas']."\n");
  $printer -> text("--------------------------------\n");

  $printer -> text('Pengeluaran :'.$data['pengeluaran']."\n");
  $printer -> text("--------------------------------\n");

  $printer -> text('Kas Akhir :'.$data['kas_akhir']."\n");
  $printer -> text("--------------------------------\n");

  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text("Mengetahui\n");
  $printer -> feed(4);
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text("Ttd\n");
  $printer -> text("--------------------------------\n");
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
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


  
