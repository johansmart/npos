<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("model_stock");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    if ($this->session->userdata('role') < 1) {
      redirect('auth/login');
    }
  }

  public function index()
  {
    $this->load->view('back/pages/v_stock');
  }
/*fetch lap pembelian*/
  public function fetch_stock(){   
     $fetch_data = $this->model_stock->make_datatables();  
     $data = array();
     $num = 1;
     foreach($fetch_data as $row)  
     {  
        $sub_array = array();
        $sub_array[] = $num++;
        $sub_array[] = $row->kode_barang;
        $sub_array[] = $row->nama_barang;
        $sub_array[] = number_format($row->harga_brg);
        $sub_array[] = $row->satuan;
        $sub_array[] = $row->masuk;
        $sub_array[] = $row->terjual;
        $sub_array[] = $row->retur;
        $sub_array[] = $row->adjust;
        $sub_array[] = $row->str_in;
        $sub_array[] = $row->sales_stock;
        $sub_array[] = number_format($row->nilai_stock);
        /*$sub_array[] = '<button type="button" id="on" class="btn btn-block btn-flat btn-xs '.($row->status =="Register"  ? 'btn-danger' : 'btn-success').' '.($row->status =="Register"  ? 'disabled' : '').'" style="font-size:10px">'.$row->status.'</button> ';*/
        $data[] = $sub_array;  
     }  
     $output = array(  
        "draw"            => intval($_POST["draw"]),  
        "recordsTotal"    => $this->model_stock->get_all_data(),  
        "recordsFiltered" => $this->model_stock->get_filtered_data(),  
        "data"            => $data  
     );  
     echo json_encode($output);  
  }

  //update stock
  public function update_stock(){
    $data = $this->model_stock->update_stock(); 
    echo json_encode($data);
  }

  //register stock opname
    public  function register_stock_opname(){
      $insert_data = array(
       'kode_barang' => $this->input->post("kode_barang"),
       'nama_barang' => $this->input->post("nama_barang"),
       'satuan'      => $this->input->post("satuan"),   
       'stock'       => 0,
       'fisik'       => 0,
       'diff'        => 0,
       'diff_value'  => 0,
       'user_id'     => $this->session->userdata('id_karyawan'),
       'tanggal'     => date('Y-m-d'),
       'jam'         => date("H:i:s"),
       'status'      => 'Register'
  );  
      $data = $this->model_stock->insert_tmp_stock_opname($insert_data);
      echo json_encode($data);
  }

  
}


  
