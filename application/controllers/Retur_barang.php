<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur_barang extends CI_Controller {

	function __construct(){
		parent::__construct();
      $this->load->model("model_retur_barang");
			if($this->session->userdata('status') != "login"){
			redirect('auth/login');
		}
    if ($this->session->userdata('role') < 1) {
      redirect('auth/login');
    }
	}

	public function index()
	{
		$this->load->view('back/pages/v_retur_barang');
	}

  /*fetch temp beli barang*/
  public function fetch_temp_retur_barang(){  
  $fetch_data = $this->model_retur_barang->make_datatables();  
  $data = array();
  foreach($fetch_data as $row)  
  {  
    $sub_array = array();
    $sub_array[] = $row->no_nota;
    //$sub_array[] = $row->kode_barang;
    $sub_array[] = '<input class="form-control input-sm" type="text" autofocus="" id="kode_barang"  name="kode_barang[]" readonly value="'.$row->kode_barang.'"  style="height:25px;width:100%;margin-top: -5px ;margin-left:-10px;background-color: white;border-color:white;"/>';    
    $sub_array[] = $row->nama_barang;
    $sub_array[] = $row->satuan;
    $sub_array[] = $row->kode_supp;
    $sub_array[] = '
    <input class="form-control input-sm" type="text" autofocus="" autocomplete="off" id="harga_beli"  name="harga_beli[]" readonly value="'.$row->harga_beli.'"  style="height:25px;width:100%;margin-top: -5px ;margin-left:-10px;background-color: white;border-color:white"/>
    ';
    $sub_array[] = '
    <input class="form-control input-sm" type="text" autofocus="" autocomplete="off" id="jml_beli"  name="jml_beli[]" readonly value="'.$row->jumlah.'"  style="height:25px;width:100%;margin-top: -5px ;margin-left:-10px;background-color: white;border-color:white"/>
    ';
    $sub_array[] = $row->total_harga_beli;  
    $sub_array[] = '
    <input class="form-control input-sm" type="text" autofocus="" autocomplete="off" id="jml_retur"  name="jml_retur[]" style="height:20px;width:100%;"/>
    ';
    $sub_array[] = '<select id="alasan" name="alasan[]" style="height:20px;">
                      <option>Expire Date</option>
                      <option>Ganti Produk Lain</option>
                      <option>Kemasan Rusak</option>
                      <option>Lain-Lain</option>
                    </select>';
    $data[] = $sub_array;
  }

  $output = array(  
      "draw"            => intval($_POST["draw"]),  
      "recordsTotal"    => $this->model_retur_barang->get_all_data(),  
      "recordsFiltered" => $this->model_retur_barang->get_filtered_data(),  
      "data"            => $data  
  );  
    echo json_encode($output);
  }

  //insert temp retur
  public function insert_temp_retur(){
    $this->model_retur_barang->clear_temp_retur();
    $get_data   = $this->model_retur_barang->get_det_pembelian()->result();
    foreach ($get_data as $data) {
      $insert_data = array(
         'no_nota'          => $data->no_nota, 
         'kode_barang'      => $data->kode_barang,
         'harga_beli'       => $data->harga_beli,
         'jumlah'           => $data->jumlah,
         'total_harga_beli' => $data->total_harga_beli,
         'id_karyawan'      => $this->session->userdata('id_karyawan'),
    ); 
      $data = $this->model_retur_barang->insert_temp_retur($insert_data);
    }
   }

  //insert temp retur
  public function save_retur(){
      //mulai variable input post
      $kode_barang   = $this->input->post('kode_barang');
      $jml_beli      = $this->input->post('jml_beli');
      $jml_retur     = $this->input->post('jml_retur');
      $harga_beli    = $this->input->post('harga_beli');
      $alasan        = $this->input->post('alasan');
      //selesai variable input post 

      //ambil no_nota untuk dijadikan variable ke model check_jml_sdh_retur
      $get_no_nota   = $this->model_retur_barang->get_no_nota()->row_array();
      $no_nota       = $get_no_nota['no_nota'];

      //periksa isi model check_jml_sdh_retur
      $row_sdh_retur = $this->model_retur_barang->check_jml_sdh_retur($no_nota)->num_rows();
      //data dari model check_jml_sdh_retur

      $data_sdh_retur= $this->model_retur_barang->check_jml_sdh_retur($no_nota)->result();
      /*print_r($data_sdh_retur);
      die;*/
      //mulai kondisi jika isi check_jml_sdh_retur ada maka buat variable array, selainnya 0
      if ($row_sdh_retur>0) {
        $jml_sdh_retur = array();
      }
      else{
        $jml_sdh_retur = 0;
      }
      // selesai kondisi

      //loop isi data model check_jml_sdh_retur
      foreach($data_sdh_retur as $row)
      {
         $jml_sdh_retur[] = $row->jml_retur;
      }
      
      //array dan loop input post
      $data        = array();
      $index       = 0; // Set index array awal dengan 0
      foreach($kode_barang as $datakode_barang){ // Kita buat perulangan berdasarkan kodebarang sampai data terakhir
        array_push($data, array(
          'kode_barang'   => $datakode_barang,
          'jml_bisa_retur'=> $jml_beli[$index]-$jml_sdh_retur[$index],//Ambil dan set data jumlah sesuai index array dari $index
          'jml_retur'     => $jml_retur[$index],//Ambil dan set data jumlah sesuai index array dari $index
          'nilai_retur'   => $jml_retur[$index]*$harga_beli[$index],//Ambil dan set data jumlah sesuai index array dari $index
          'alasan'        => $alasan[$index],//Ambil dan set data jumlah sesuai index array dari $index
        ));
        $index++;
      }
      //update isi table temp_retur
      $this->model_retur_barang->update_send($data);
      /*print_r($jml_sdh_retur);
      die;*/

      //mulai insert ke table temp_retur
      $get_retur       = $this->model_retur_barang->get_retur()->result();
      $get_det_retur   = $this->model_retur_barang->get_det_retur()->result();
      $cek_get_retur   = $this->model_retur_barang->get_det_retur()->num_rows();
      /*print_r($get_det_retur);
      die;*/
      if ($cek_get_retur <1) {
        echo 'err_opt';
        return false;
      }

      else {

        //menyiapkan no retur
        $get_no_slip   = $this->model_retur_barang->get_no_slip()->row_array();
        $data_no_slip   = substr($get_no_slip['seq'], 0, 4)+1;
        $seq            = sprintf("%04s", $data_no_slip);

        foreach ($get_retur as $data) {
          $insert_data = array(
            'seq'         => $seq,
            'no_retur'    => 'RTR'.'-'.date('ymd').'-'.$seq, 
            'no_nota'     => $data->no_nota, 
            'tanggal'     => date('Y-m-d'), 
            'left_date'   => date('d'), 
            'jam'         => date("H:i:s"),
            'left_time'   => date('H:00:00'),
            'nilai_retur' => $data->nilai_retur,
            'id_karyawan' => $this->session->userdata('id_karyawan'),
          ); 

          $check_jumlah         = $this->model_retur_barang->check_jml_retur()->num_rows();
          $check_jml_bisa_retur = $this->model_retur_barang->check_jml_bisa_retur()->num_rows();
            if ($check_jumlah > 0) 
            {
              echo 'err_jml';
              return false;
            }
            else if ($check_jml_bisa_retur > 0) {
              echo 'over_limit';
              return false;
            }
            else
            {
              $data = $this->model_retur_barang->insert_retur($insert_data);
            }
        }
        //selesai insert ke table temp_retur

        //mulai insert ke table tbl_det_retur  
        foreach ($get_det_retur as $data) {
          $insert_det = array(
            'no_retur'    => 'RTR'.'-'.date('ymd').'-'.$seq, 
            'no_nota'     => $data->no_nota,
            'kode_barang' => $data->kode_barang, 
            'harga_beli'  => $data->harga_beli, 
            'jml_retur'   => $data->jml_retur,
            'nilai_retur' => $data->harga_beli* $data->jml_retur,
            'alasan'      => $data->alasan,
          ); 
          $data = $this->model_retur_barang->insert_det_retur($insert_det);
          }
          $this->model_retur_barang->update_stock();
          $this->model_retur_barang->clear_temp_retur();
          echo 'success';
        }
        //selesai insert ke table tbl_det_retur
      }

    //hapus table temp_retur
    public function reset_form(){    
      $this->model_retur_barang->clear_temp_retur();   
    } 


 

  

}


  
