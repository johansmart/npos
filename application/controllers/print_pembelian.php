<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Print_pembelian extends CI_Controller {


public function __construct(){
    parent::__construct();
      $this->load->library('Pdf');
      $this->load->model("Model_list_print_pembelian");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
 }

public function prev(){
$purc_no = $this->uri->segment(3);
$data['print_header'] = $this->Model_list_print_pembelian->get_data_print_header($purc_no)->row_array();
$data['print_table']  = $this->Model_list_print_pembelian->get_data_print_tbl($purc_no)->result();
$data['print_footer'] = $this->Model_list_print_pembelian->get_data_print_fooot_tbl($purc_no)->row_array();

$this->load->view('back/pages/v_print_pembelian',$data);
$html = $this->output->get_output();
$this->load->library('pdf');
$this->dompdf->loadHtml($html);
$this->dompdf->setPaper('A4', 'potrait');
$this->dompdf->render();
$this->dompdf->stream("welcome.pdf", array("Attachment"=>0));
}

  /*public function prev(){
    $this->load->view('back/pages/v_prt',$data);
  }*/

  	

}


  
