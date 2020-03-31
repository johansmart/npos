<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*initialize escPos*/
require __DIR__ . '/print/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


class Print_shift extends CI_Controller {

	function __construct(){
		parent::__construct();
      $this->load->model("Model_print_shift");
			if($this->session->userdata('status') != "login"){
			redirect('auth/login');
		}
    /*if ($this->session->userdata('role') != 3) {
      redirect('auth/login');
    }*/
	}

public function print_start_shift()
{
  $data = $this->Model_print_shift->get_last_start_shift()->row_array();
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
  $printer -> text("START OF SFHIFT\n");
  $printer -> selectPrintMode();
  $printer -> text("--------------------------------\n");
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text("Print Date ".date('Y-m-d').' '.date("H:i:s")."\n");
  $printer -> selectPrintMode();
  $printer -> text("--------------------------------\n");
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text('POSNO : '.$data['no_pos']."\n");
  $printer -> text('SHIFT : '.$data['shift']."\n");
  $printer -> text('KASIR : '.$data['user_name']."\n");
  $printer -> text("--------------------------------\n");
  $printer -> text('Setoran Awal :'.$data['float_value']."\n");
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

public function print_end_shift()
{
  $data = $this->Model_print_shift->get_last_end_shift()->row_array();
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
  $printer -> text("END OF SFHIFT\n");
  $printer -> selectPrintMode();
  $printer -> text("--------------------------------\n");
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text("Print Date ".date('Y-m-d').' '.date("H:i:s")."\n");
  $printer -> selectPrintMode();
  $printer -> text("--------------------------------\n");
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text('POSNO : '.$data['no_pos']."\n");
  $printer -> text('SHIFT : '.$data['shift']."\n");
  $printer -> text('KASIR : '.$data['user_name']."\n");
  $printer -> text("--------------------------------\n");
  $printer -> text('Setoran Akhir :'.$data['end_shift']."\n");
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


  
