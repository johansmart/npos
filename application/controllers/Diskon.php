<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diskon extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("Model_diskon");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    if ($this->session->userdata('role') < 1) {
      redirect('auth/login');
    }
  }

  public function index()
  {
    $this->load->view('back/pages/v_diskon');
  }
/*fetch user*/
  public function fetch_diskon(){   
     $fetch_data = $this->Model_diskon->make_datatables();  
     $data = array();
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
          $sub_array[] = $row->id;
          $sub_array[] = $row->barcode;  
          $sub_array[] = $row->nama_barang;
          $sub_array[] = $row->harga_brg;
          $sub_array[] = $row->persen;  
          $sub_array[] = $row->nilai_diskon; 
          $sub_array[] = $row->tgl_mulai; 
          $sub_array[] = $row->tgl_selesai; 
          $sub_array[] = $row->harga_diskon; 
          $sub_array[] = $row->userid;
          $sub_array[] = $row->status;
          $sub_array[] = '<div class="btn-group" id="status" data-toggle="buttons">
              <label class="btn btn-default btn-on-2 btn-xs '.($row->status >0  ? 'active' : '').'" id="on">
              <input type="radio" id="id_on" value="1" name="on_status" checked="checked">ON</label>

              <label class="btn btn-default btn-off-2 btn-xs '.($row->status <1  ? 'active' : '').'" id="off">
              <input type="radio" id="id_off" value="0" name="off_status">OFF</label>
            </div>';  
          $data[] = $sub_array;  
     }  
     $output = array(  
          "draw"            => intval($_POST["draw"]),  
          "recordsTotal"    => $this->Model_diskon->get_all_data(),  
          "recordsFiltered" => $this->Model_diskon->get_filtered_data(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
    }


  //update status on
  public function update_status_on(){
    $this->Model_diskon->update_status_on();
  }

  //update status off
  public function update_status_off(){
    $this->Model_diskon->update_status_off();
  }

  /*get item info*/
  public function get_item_info()
  {
    $data = $this->Model_diskon->get_item_info()->row_array();
    $row  = $this->Model_diskon->get_item_info()->num_rows();
/*    print_r($data);
    die;*/
    $item_info = array(
        $data['nama_barang'],
        $data['satuan'],
        $data['kode_supp'],
        $data['harga_brg'],
        //$data['sales_stock']
    );
    if ($row > 0)
    {
     echo json_encode($item_info);
    }
    else
    {
       echo json_encode($row);
    }
  }


  //insert diskon
  public  function insert_diskon(){
    $insert_data = array(
       'barcode'      => $this->input->post("kode_barang"),
       'nama_barang'  => trim(strtoupper($this->input->post("nama_barang"))),
       'harga_brg'    => $this->input->post("harga_brg"),
       'persen'       => $this->input->post("persen"),
       'nilai_diskon' => $this->input->post("nilai_diskon"),
       'tgl_mulai'    => $this->input->post("start_date"),
       'tgl_selesai'  => $this->input->post("end_date"),
       'harga_diskon' => $this->input->post("harga_diskon"),
       'userid'       => $this->session->userdata('id_karyawan'),
       'date'         => date('Y-m-d'),
       'status'       => 1
    );

    $data = $this->Model_diskon->insert_diskon($insert_data);
    echo json_encode($data);
  }

}


  
