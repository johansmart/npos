<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Print_label extends CI_Controller {


public function __construct(){
    parent::__construct();
      $this->load->library('Pdf');
      $this->load->model("Model_tag_print");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
 }

public function prev(){
$data['print_label'] = $this->Model_tag_print->get_data_print()->result();
$data['baris'] = $this->Model_tag_print->get_data_print()->num_rows(); 
$this->load->view('back/pages/v_prt_label',$data);
$html = $this->output->get_output();
$this->load->library('pdf');
$this->dompdf->loadHtml($html);
$this->dompdf->setPaper('A4', 'landscape');
$this->dompdf->render();
$this->dompdf->stream("welcome.pdf", array("Attachment"=>0));
}

  /*public function prev(){
    $this->load->view('back/pages/v_prt',$data);
  }*/

  	

}


  
