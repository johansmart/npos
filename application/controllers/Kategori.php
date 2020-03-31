<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("model_kategori");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    if ($this->session->userdata('role') < 1) {
      redirect('auth/login');
    }
  }

  public function index()
  {
    $this->load->view('back/pages/v_kategori');
  }
/*fetch user*/
  public function fetch_kategori(){   
     $fetch_data = $this->model_kategori->make_datatables();  
     $data = array();
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
          $sub_array[] = $row->kode_kategori;
          $sub_array[] = $row->nama_kategori;  
          $sub_array[] = $row->user_reg;
          $sub_array[] = $row->tanggal; 
          $sub_array[] = '<button type="button"  name="delete" id="delete"  class="btn btn-danger glyphicon glyphicon-remove btn-flat btn-xs"></button>'.'&nbsp;'.'<button type="button"  name="edit" id="edit"  class="btn bg-blue glyphicon glyphicon-edit btn-flat btn-xs"></button>';
          $data[] = $sub_array;  
     }  
     $output = array(  
          "draw"            => intval($_POST["draw"]),  
          "recordsTotal"    => $this->model_kategori->get_all_data(),  
          "recordsFiltered" => $this->model_kategori->get_filtered_data(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
    }

  //insert supplier
  public  function insert_kategori(){
    $data          = $this->model_kategori->kode_kategori()->row_array();
    $kode_kategori = $data['kode_kategori']+1;
    $insert_data = array(
       'kode_kategori' => $kode_kategori,
       'nama_kategori' => trim(strtoupper($this->input->post("nama_kategori"))),
       'user_reg'      => $this->session->userdata('id_karyawan'),
       'tanggal'       => date('Y-m-d')
    );

    $cek_kategori = $this->model_kategori->cek_kategori()->num_rows();
    if ($cek_kategori >0) {
      echo json_encode($cek_kategori);
      return false;
    }
    else
    {
      $data = $this->model_kategori->insert_kategori($insert_data);
      echo json_encode($data);
    }
  }

  //hapus barang
  public function delete_kategori(){    
    $this->model_kategori->delete_kategori();   
  }

  //update supplier
  public function update_kategori(){
    $cek_kategori = $this->model_kategori->cek_kategori_edit()->num_rows();
    if ($cek_kategori >0) {
      echo json_encode($cek_kategori);
      return false;
    }
    else
    {
      $data = $this->model_kategori->update_kategori(); 
      echo json_encode($data);
    }  
  }     

}


  
