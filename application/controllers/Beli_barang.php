<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beli_barang extends CI_Controller {

	function __construct(){
		parent::__construct();
      $this->load->model("model_beli_barang");
			if($this->session->userdata('status') != "login"){
			redirect('auth/login');
		}
    if ($this->session->userdata('role') < 1) {
      redirect('auth/login');
    }
	}

	public function index()
	{
		$this->load->view('back/pages/v_beli_barang');
	}

  /*get no nota*/
  public function get_no_nota()
  {
    $data = $this->model_beli_barang->get_no_nota()->row_array();
    $row  = $this->model_beli_barang->get_no_nota()->num_rows();
    $no_nota = $data['no_nota'];
    if ($row>0)
    {
     echo $no_nota;
    }
    else
    {
      echo'0';
    }
    
  }

  /*fetch temp beli barang*/
  public function fetch_temp_beli_barang(){  
  $fetch_data = $this->model_beli_barang->make_datatables();  
  $data = array();
  foreach($fetch_data as $row)  
  {  
    $sub_array = array();
    $sub_array[] = $row->kode_barang;  
    $sub_array[] = $row->nama_barang;
    $sub_array[] = $row->satuan;
    $sub_array[] = $row->nama_kategori;
    $sub_array[] = number_format($row->harga_beli);
    $sub_array[] = $row->jumlah;
    $sub_array[] = number_format($row->total_harga);  
    $sub_array[] = '<button type="button"  name="delete" id="delete"  class="btn btn-danger glyphicon glyphicon-remove btn-flat btn-xs"></button>';        
    $data[] = $sub_array;
  }

  $input_last_row = array();

  $input_last_row[] = '<input id="kode_barang" name="kode_barang" class="isi" required="" type="text" tabindex="5"  style="height:25px;width:100%;background-color: #f2e6ff" >';

  $input_last_row[] = '<input id="nama_barang" name="nama_barang" class="input-sm"  type="text" readonly style="height:25px;width:100%;background-color: #f2e6ff;">';

  $input_last_row[] = '<input id="satuan"  name="satuan" class="input-sm" required=""   type="text"  readonly  style="height:25px;width:100%;background-color: #f2e6ff;">';

  $input_last_row[] = '<input id="nama_kategori"  name="nama_kategori" class="input-sm" required=""   type="text"  readonly style="height:25px;width:100%;background-color: #f2e6ff;">';

  $input_last_row[] = '<input id="harga_beli"  readonly name="harga_beli" class="input-sm" type="text"   style="height:25px;width:100%;background-color: #f2e6ff;">';

  $input_last_row[] = '<input id="jumlah" autocomplete="off" name="jumlah" class="isi"  type="text" tabindex="6"  style="height:25px;width:100%;background-color: #f2e6ff" ">';

  $input_last_row[] = '<input id="total_harga"  readonly name="total_harga" class="input-sm"  type="text"   style="height:25px;width:100%;background-color: #f2e6ff;">';

  $input_last_row[] = '<button type="submit"  name="add" id="add"  class="btn bg-blue glyphicon glyphicon-plus btn-flat btn-xs"></button>';

  $data[] = $input_last_row;  

  $output = array(  
      "draw"            => intval($_POST["draw"]),  
      "recordsTotal"    => $this->model_beli_barang->get_all_data(),  
      "recordsFiltered" => $this->model_beli_barang->get_filtered_data(),  
      "data"            => $data  
  );  
    echo json_encode($output);
  }

   /*get item info*/
  public function get_item_info()
  {
    $data = $this->model_beli_barang->get_item_info()->row_array();
    $row  = $this->model_beli_barang->get_item_info()->num_rows();
    $item_info = array(
        $data['nama_barang'],
        $data['satuan'],
        $data['nama_kategori'],
        $data['harga_beli']
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

  //periksa no  nota yang sudah ada
  public function check_no_nota(){    
    $get_data = $this->model_beli_barang->check_no_nota()->num_rows();
    echo json_encode($get_data); 
  }

  //insert temp beli barang
  public  function insert_tmp_beli_barang(){
    
      $insert_data = array(
       'no_nota'       => trim($this->input->post("no_nota")),
       'kode_barang'   => $this->input->post("kode_barang"),
       'nama_barang'   => $this->input->post("nama_barang"),
       'satuan'        => $this->input->post("satuan"),   
       'harga_beli'    => $this->input->post("harga_beli"),
       'jumlah'        => $this->input->post("jumlah"),
       'total_harga'   => $this->input->post("total_harga"),
       'id_karyawan'   => $this->session->userdata('id_karyawan'),
       'nama_kategori' => $this->input->post("nama_kategori"),
       'tanggal'       => date('Y-m-d'),
       'left_date'     => date('d'),
       'jam'           => date("H:i:s"),
       'left_time'     => date('H:00:00')
  );  
      $cek_kode_barang = $this->model_beli_barang->cek_kode_barang()->num_rows();
      if ($cek_kode_barang > 0) {
        $data = $this->model_beli_barang->insert_tmp_beli_barang($insert_data);
      }
      else{
        return false;
      }
      
      echo json_encode($data);
  }

  //hapus barang 
  public function delete_product(){    
    $this->model_beli_barang->delete_product();   
  }

  /*sum total harga beli untuk footer datatable*/
  public function sum_total_beli()
  {
    $data         = $this->model_beli_barang->sum_total_beli()->row_array();
    $row          = $this->model_beli_barang->sum_total_beli()->num_rows();
    $total_harga  = $data['total_harga'];
    if ($row>0)
    {
     echo $total_harga;
    }
    else
    {
      echo'0';
    }
  }

  //hapus seluruh isi table temp_beli_barang
  public function reset_form(){    
    $this->model_beli_barang->clear_temp_beli_barang();   
  }

  //insert data ke tbl_pembelian dan tbl_det_pembelian
  public function ins_pembelian()
  {
    $select_supplier = $this->input->post('select_supplier');
    $tipe_bayar      = $this->input->post('tipe_bayar');
    $jumlah_hutang   = $this->input->post('jumlah_hutang');
    $get_pemb        = $this->model_beli_barang->get_pembelian()->result();
    $get_det_pemb    = $this->model_beli_barang->get_det_pembelian()->result();

    $get_no_slip     = $this->model_beli_barang->get_no_slip()->row_array();
    $data_no_slip    = substr($get_no_slip['seq'], 0, 4)+1;
    $seq             = sprintf("%04s", $data_no_slip);

    /*print_r($seq);
    die;*/

    $get_kode_supp = $this->model_beli_barang->get_kode_supp()->row_array();
    $kode_supp = $get_kode_supp['kode_supp'];
    /*print_r($no_nota);
    die;*/
    //insert ke table_pembelian dan tbl_hutang
    foreach ($get_pemb as $data) {
         $insert_data = array(
            'no_nota'     => $seq,
            'tanggal'     => $data->tanggal, 
            'left_date'   => $data->left_date,
            'jam'         => $data->jam,
            'left_time'   => $data->left_time,
            'total_beli'  => $data->total,
            'total_hutang'=> $jumlah_hutang,
            'kode_supp'   => $kode_supp,
            'id_karyawan' => $this->session->userdata('id_karyawan'),
            'tipe_bayar'  => $tipe_bayar,
            'purc_no'     => date('ymd').'-'.$seq

        );

        //insert hutang 
        $insert_hutang = array(
            'no_nota'     => date('ymd').'-'.$seq,
            'kode_supp'   => $kode_supp,
            'no_hutang'   => $seq.date('ymd'),
            'total_hutang'=> $jumlah_hutang,
            'total_bayar' => 0,
        );

        $data_pembelian = $this->model_beli_barang->ins_pembelian($insert_data);
        if ($jumlah_hutang > 0) {
          $data_hutang    = $this->model_beli_barang->ins_hutang($insert_hutang);
        }
        
      }

      //insert ke table_detai_pembelian
      foreach ($get_det_pemb as $data) {
         $insert_data = array(
            'no_nota'          => date('ymd').'-'.$seq,
            'kode_barang'      => $data->kode_barang, 
            'harga_beli'       => $data->harga_beli,
            'jumlah'           => $data->jumlah,
            'total_harga_beli' => $data->total_harga,
            'kode_supp'        => $kode_supp
        );
        $data_det_pembelian = $this->model_beli_barang->ins_det_pembelian($insert_data);
      }

      //insert ke tbl_kas_flow
      
        foreach ($get_pemb as $data) {
           $insert_data = array(
              'no_faktur'   => date('ymd').'-'.$seq,
              'tanggal'     => date('Y-m-d'),  
              'jam'         => date("H:i:s"),
              'arah'        => 'Pengeluaran',
              'nilai_masuk' => 0,
              'nilai_keluar'=> $data->total,
              'user_id'     => $this->session->userdata('id_karyawan'),
              'keterangan'  => 'Pengeluaran pembelian nota '.date('ymd').'-'.$seq
          );
          if ($tipe_bayar=='TUNAI') {
            $data_kas_flow = $this->model_beli_barang->ins_kas_flow($insert_data);
          }
        }
     
      echo json_encode($data_det_pembelian );
      $this->model_beli_barang->update_stock();
      $this->model_beli_barang->clear_temp_beli_barang();
  }

   /*fetch master barang*/
  public function fetch_master_barang(){  
     $fetch_data = $this->model_beli_barang->cari_produk();  
     $data = array();
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
          $sub_array[] = '<a href="#" id="barcode" data-id="'.$row->kode_barang.'">'.$row->kode_barang.'</a>';
          $sub_array[] = $row->nama_barang;
          $sub_array[] = $row->satuan;
          $sub_array[] = $row->kode_kategori.' - '.$row->nama_kategori;
          $sub_array[] = $row->sales_stock;
          $sub_array[] = $row->harga_beli;
          $sub_array[] = $row->harga_grosir;
          $data[] = $sub_array;  
     }  
     $output = array(  
          "draw"            => intval($_POST["draw"]),  
          "recordsTotal"    => $this->model_beli_barang->get_all_data_cari_produk(),  
          "recordsFiltered" => $this->model_beli_barang->get_filtered_data_cari_produk(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
  }

  

}


  
