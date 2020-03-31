<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adjust_barang extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("model_adjust_barang");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    if ($this->session->userdata('role') < 1) {
      redirect('auth/login');
    }
  }

  public function index()
  {
    $this->load->view('back/pages/v_adjust_barang');
  }



  public function fetch_temp_adjust_barang(){  
  $fetch_data = $this->model_adjust_barang->make_datatables();  
  $data = array();
  foreach($fetch_data as $row)  
  {  
    $sub_array = array();
    $sub_array[] = $row->kode_barang;  
    $sub_array[] = $row->nama_barang;
    $sub_array[] = $row->satuan;
    $sub_array[] = $row->kode_supp;
    $sub_array[] = number_format($row->harga_beli);
    //$sub_array[] = number_format($row->stock);
    $sub_array[] = $row->jumlah;
    $sub_array[] = number_format($row->nilai_adjust);
    $sub_array[] = $row->alasan;   
    $sub_array[] = '<button type="button"  name="delete" id="delete"  class="btn btn-danger glyphicon glyphicon-remove btn-flat btn-xs"></button>';        
    $data[] = $sub_array;
  }

  $input_last_row[] = '<input id="kode_barang" name="kode_barang" class="isi" required="" type="text" tabindex="1"  style="height:25px;width:100%;background-color: #f2e6ff" >';

  $input_last_row[] = '<input id="nama_barang" name="nama_barang" class="input-sm"  type="text" readonly style="height:25px;width:100%;background-color: #f2e6ff;">';

  $input_last_row[] = '<input id="satuan"  name="satuan" class="input-sm" required=""   type="text"  readonly  style="height:25px;width:100%;background-color: #f2e6ff;">';

  $input_last_row[] = '<input id="kode_supp"  name="kode_supp" class="input-sm" required=""   type="text"  readonly style="height:25px;width:100%;background-color: #f2e6ff;">';

  $input_last_row[] = '<input id="harga_beli" value="0" readonly name="harga_beli" class="input-sm" type="text"   style="height:25px;width:100%;background-color: #f2e6ff;">';

/*    $input_last_row[] = '<input id="sales_stock" value="0" readonly name="sales_stock" class="input-sm" type="text"   style="height:25px;width:100%;background-color: white;">';*/

  $input_last_row[] = '<input id="jumlah" autocomplete="off" required name="jumlah" class="isi"  type="text" tabindex="2"  style="height:25px;width:100%;background-color: #f2e6ff" ">';

  $input_last_row[] = '<input id="nilai_adjust" value="0" readonly name="nilai_adjust" class="input-sm"  type="text"   style="height:25px;width:100%;background-color: #f2e6ff;">';

  $input_last_row[] = '<select id="alasan" required tabindex="3" name="alasan" style="height:20px;">
                      <option>Expire Date</option>
                      <option>Kemasan Rusak</option>
                      <option>Kelebihan input</option>
                      <option>Kesalahan stock opname</option>
                      <option>Lain-Lain</option>
                    </select>';

  $input_last_row[] = '<button type="submit"  name="add" id="add"  class="btn bg-blue glyphicon glyphicon-plus btn-flat btn-xs"></button>';

  $data[] = $input_last_row; 

  $output = array(  
      "draw"            => intval($_POST["draw"]),  
      "recordsTotal"    => $this->model_adjust_barang->get_all_data(),  
      "recordsFiltered" => $this->model_adjust_barang->get_filtered_data(),  
      "data"            => $data  
  );  
    echo json_encode($output);
  }


  /*get item info*/
  public function get_item_info()
  {
    $data = $this->model_adjust_barang->get_item_info()->row_array();
    $row  = $this->model_adjust_barang->get_item_info()->num_rows();
/*    print_r($data);
    die;*/
    $item_info = array(
        $data['nama_barang'],
        $data['satuan'],
        $data['kode_supp'],
        $data['harga_beli'],
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

  //insert temp beli barang
  public  function insert_tmp_adjust_barang(){
      $insert_data = array(
     'kode_barang'  => $this->input->post("kode_barang"),
     'nama_barang'  => $this->input->post("nama_barang"),
     'satuan'       => $this->input->post("satuan"),   
     'kode_supp'    => $this->input->post("kode_supp"),
     'harga_beli'   => $this->input->post("harga_beli"),
     'jumlah'       => $this->input->post("jumlah"),
     'nilai_adjust' => $this->input->post("nilai_adjust"),
     'alasan'       => $this->input->post("alasan"),
     'id_karyawan'  => $this->session->userdata('id_karyawan')
      );  
      $data = $this->model_adjust_barang->insert_tmp_adjust_barang($insert_data);
      echo json_encode($data);
  }

  /*sum total harga beli untuk footer dataable*/
  public function sum_nilai_adjust()
  {
    $data         = $this->model_adjust_barang->sum_nilai_adjust()->row_array();
    $row          = $this->model_adjust_barang->sum_nilai_adjust()->num_rows();
    $nilai_adjust = $data['nilai_adjust'];
    if ($row>0)
    {
     echo $nilai_adjust;
    }
    else
    {
      echo'0';
    }
  }

  //hapus barang 
  public function delete_product(){    
    $this->model_adjust_barang->delete_product();   
  }

  //hapus seluruh isi table temp_adjust_barang
  public function reset_form(){    
    $this->model_adjust_barang->clear_temp_adjust_barang();   
  }

  //insert data ke tbl_adjust dan tbl_det_adjust
  public function ins_adjust_barang()
  {

    $get_adjust      = $this->model_adjust_barang->get_adjust()->result();
    $get_det_adjust  = $this->model_adjust_barang->get_det_adjust()->result();

    //menyiapkan no adjust
    $get_no_slip     = $this->model_adjust_barang->get_no_slip()->row_array();
    $data_no_slip    = substr($get_no_slip['seq'], 0, 4)+1;
    $seq             = sprintf("%04s", $data_no_slip);
    /*print_r($seq);
    die;*/
  
    //insert ke tbl_adjust
    foreach ($get_adjust as $data) {
         $insert_data = array(
            'seq'         => $seq,
            'no_adjust'   => 'ADJ'.'-'.date('ymd').'-'.$seq, 
            'tanggal'     => date('Y-m-d'), 
            'left_date'   => date('d'), 
            'jam'         => date("H:i:s"),
            'left_time'   => date('H:00:00'),
            'nilai_adjust'=> $data->nilai_adjust,
            'id_karyawan' => $this->session->userdata('id_karyawan')

        );
        $data_adjust = $this->model_adjust_barang->ins_adjust($insert_data);
      }

      //insert ke tbl_det_adjust
      foreach ($get_det_adjust as $data) {
         $insert_det_data = array(
            'no_adjust'   => 'ADJ'.'-'.$seq.date('ymd'), 
            'kode_barang' => $data->kode_barang, 
            'harga_beli'  => $data->harga_beli,
            'jml_adjust'  => $data->jumlah,
            'nilai_adjust'=> $data->nilai_adjust,
            'alasan'      => $data->alasan
        );
        $data_det_adjust = $this->model_adjust_barang->ins_det_adjust($insert_det_data);
      }
      echo json_encode($data_det_adjust);
      $this->model_adjust_barang->update_stock();
      $this->model_adjust_barang->clear_temp_adjust_barang();
  }


}
 

  
