<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*initialize escPos*/
require __DIR__ . '/print/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


class Print_faktur extends CI_Controller {

	function __construct(){
		parent::__construct();
      $this->load->model("model_print_faktur");
			if($this->session->userdata('status') != "login"){
			redirect('auth/login');
		}
    /*if ($this->session->userdata('role') != 3) {
      redirect('auth/login');
    }*/
	}

public function direct_print()
{
  $data=$this->model_print_faktur->get_last_faktur()->row_array();
  $no_faktur    = $data['no_faktur'];
  $no_piutang   = $this->model_print_faktur->get_no_piutang($no_faktur)->row_array();
  $item_content = $this->model_print_faktur->get_item_faktur($no_faktur)->result();
  $debit_card   = $this->model_print_faktur->get_debit_trx($no_faktur)->row_array();
  /*print_r($debit_card);
  die;*/
  // Enter the share name for your USB printer here
  $connector = new WindowsPrintConnector("EPSON TM-U220 Receipt");
  $printer   = new Printer($connector);

  /* header */
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text("TOKO ABADI JAYA.\n");
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text("JL. SEDERHANA 5 NO 16\n");
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text("JAKARTA SELATAN\n");
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text("INDONESIA\n");
  $printer -> selectPrintMode();
  $printer -> text('--------------------------------');
  $printer -> feed();
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text($data['tanggal']." - ".$data['jam']);
  $printer -> feed();
  $printer -> text($data['no_faktur']." / ".$data['user_name']);
  $printer -> feed();
  $printer -> text('--------------------------------');
  $printer -> feed();
  /* content */
  $num = 1;
  foreach ($item_content as $content) {
    $printer -> setJustification(Printer::JUSTIFY_LEFT);
    $printer -> text($num++.". ".$content->nama_barang);
    $printer -> feed();
    $printer -> setJustification(Printer::JUSTIFY_RIGHT);
    $printer -> text($content->qty." * ".number_format($content->harga));
    $printer -> feed();
    $printer -> text("Subtotal"." : ".number_format($content->total));
    $printer -> feed();
  }
  $printer -> text('--------------------------------');
  $printer -> feed();
  //footer
  $printer -> setJustification(Printer::JUSTIFY_RIGHT);
  $printer -> text("Total"." : ".number_format($data['grand_total']));
  $printer -> feed();
  $printer -> setJustification(Printer::JUSTIFY_RIGHT);

  if ($data['piutang']>0) {
    $printer -> text($data['tipe_bayar']." : ".number_format($data['piutang']));
  }
  else{
    $printer -> text($data['tipe_bayar']." : ".number_format($data['bayar']));
  }

  $printer -> feed();
  $printer -> setJustification(Printer::JUSTIFY_RIGHT);
  if ($data['kembali']>=1000 && $data['kembali']<10000) {
    $printer -> text("Kembali"." : "." ".number_format($data['kembali']));
  }
  else if ($data['kembali']<1000) {
    $printer -> text("Kembali"." : "."   ".number_format($data['kembali']));
  }
  else if ($data['kembali']>=10000) {
    $printer -> text("Kembali"." : "."".number_format($data['kembali']));
  }
  $printer -> feed();
  $printer -> text('--------------------------------');
  $printer -> feed();

  if ($no_piutang['no_piutang']>0) {
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer -> text("No Piutang : ".$no_piutang['no_piutang']."\n");
    $printer -> text('--------------------------------');
    $printer -> feed();
  }

  if ($debit_card['approval_no']>0) {
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer -> text("TRACE:".$debit_card['validity']." APRCD:".$debit_card['approval_no']."\n");
    $printer -> text($debit_card['bank'].":".substr_replace($debit_card['no_kartu'],"****",10) ."\n");
    $printer -> text('--------------------------------');
    $printer -> feed();
  }

  /* Footer */
  $printer -> setJustification(Printer::JUSTIFY_CENTER);
  $printer -> text("TERIMA KASIH SUDAH BERBELANJA DI TOKO KAMI\n");
  //$printer -> feed(4);
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


  
