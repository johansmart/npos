<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_supplier extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("model_master_supplier");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    if ($this->session->userdata('role') < 1) {
      redirect('auth/login');
    }
  }

  public function index()
  {
    $this->load->view('back/pages/v_master_supplier');
  }
/*fetch user*/
  public function fetch_master_supplier(){   
     $fetch_data = $this->model_master_supplier->make_datatables();  
     $data = array();
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
          $sub_array[] = $row->id;
          $sub_array[] = $row->kode_supp;  
          $sub_array[] = $row->nama_supp;
          $sub_array[] = $row->nama_kontak;
          $sub_array[] = $row->tlp_supp;  
          $sub_array[] = $row->alamat_supp; 
          $sub_array[] = '<button type="button"  name="delete" id="delete"  class="btn btn-danger glyphicon glyphicon-remove btn-flat btn-xs"></button>'.'&nbsp;'.'<button type="button"  name="edit" id="edit"  class="btn bg-blue glyphicon glyphicon-edit btn-flat btn-xs"></button>';
          $data[] = $sub_array;  
     }  
     $output = array(  
          "draw"            => intval($_POST["draw"]),  
          "recordsTotal"    => $this->model_master_supplier->get_all_data(),  
          "recordsFiltered" => $this->model_master_supplier->get_filtered_data(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
    }

  //insert supplier
  public  function insert_supplier(){
    $data          = $this->model_master_supplier->no_supplier()->row_array();
    $kode_supplier = $data['kode_supp']+1;
    $insert_data = array(
       'kode_supp'     => $kode_supplier,
       'nama_supp'     => trim(strtoupper($this->input->post("nama_supplier"))),
       'nama_kontak'   => $this->input->post("nama_kontak"),
       'tlp_supp'      => $this->input->post("telp_supp"),
       'alamat_supp'   => $this->input->post("alamat_supp"),
       'reg_id'        => $this->session->userdata('id_karyawan'),
       'tanggal'       => date('Y-m-d')
    );

    $cek_supplier = $this->model_master_supplier->cek_supplier()->num_rows();
    if ($cek_supplier >0) {
      echo json_encode($cek_supplier);
      return false;
    }
    else
    {
      $data = $this->model_master_supplier->insert_supplier($insert_data);
      echo json_encode($data);
    }
  }

  //hapus barang
  public function delete_supplier(){    
    $this->model_master_supplier->delete_supplier();   
  }

  //update supplier
  public function update_supplier(){
    $cek_barang = $this->model_master_supplier->cek_supplier_edit()->num_rows();
    if ($cek_barang >0) {
      echo json_encode($cek_barang);
      return false;
    }
    else
    {
      $data = $this->model_master_supplier->update_supplier(); 
      echo json_encode($data);
    }  
  }     

}


  
