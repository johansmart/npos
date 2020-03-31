<?php


defined('BASEPATH') OR exit('No direct script access allowed');
class Pos extends CI_Controller {

  function __construct(){
    parent::__construct();
      $this->load->model("model_pos");
      if($this->session->userdata('status') != "login"){
      redirect('auth/login');
    }
    if ($this->session->userdata('role') == 1) {
      redirect('auth/login');
    }
  }

  //index
  public function index(){
    $data_float     = $this->model_pos->cek_float()->num_rows();
    $data_end_shift = $this->model_pos->cek_end_shift()->num_rows();
    /*print_r($data_end_shift);
    die;*/
    if ($data_float==0) {
      $this->load->view('back/pages/v_float');
    }
    else if ($data_end_shift > 0) {
      $this->load->view('back/pages/v_error_500');
    }
    else{
      $data['result_promo'] = $this->model_pos->get_promo()->result();
      $data['last_trx']     = $this->model_pos->get_last_trx()->result();
      $data['sls_kasir']     = $this->model_pos->get_sales_kasir()->row_array();
      $this->load->view('back/pages/v_pos',$data);
    }
  }

  //menampilkan table temp_trx_pos
  public function fetch_temp_trx_pos(){ 
     $fetch_data = $this->model_pos->make_datatables();  
     $data = array();
     $num = 1;
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
          $sub_array[] = $row->id;
          //class row color
          $sub_array[] = '<a  class="no_select" style="text-decoration:none">'.$row->barcode.'</a>';
          //class row color
          $sub_array[] = $row->nama_barang;
          $sub_array[] = number_format($row->harga_brg);
          $sub_array[] = number_format($row->qty);
          $sub_array[] = number_format($row->total_harga);
          $sub_array[] = number_format($row->tot_diskon);
          $sub_array[] = number_format($row->total_harga-$row->tot_diskon);
          $sub_array[] = $row->remark;
          $data[] = $sub_array;  
     }  
     $output = array(  
          "data"            => $data  
     );  
     echo json_encode($output);  
  }

/*  public function get_autocomplete(){
        if (isset($_GET['term'])) {
            $result = $this->model_pos->search_barang($_GET['term']);
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = $row->kode_barang." | ".$row->nama_barang;
                echo json_encode($arr_result);
            }
        }
    }*/
    
  //insert data ke tabel temp_trx_pos (tabel keranjang)
  public function add_item(){
    $barcode    = $this->input->post('barcode');
    $get_data   = $this->model_pos->get_info_prod($barcode)->result();

    $get_diskon = $this->model_pos->get_diskon($barcode)->row_array();
    $diskon     = $get_diskon['nilai_diskon']+0;

    $msg        = $this->model_pos->get_info_prod($barcode)->num_rows();

    foreach ($get_data as $data) {
         $insert_data = array(
            'barcode'         => $data->kode_barang,
            'nama_barang'     => $data->nama_barang,  
            'harga_brg'       => $data->harga_brg,
            'qty'             => 1,
            'discount'        => $diskon,
            'total_harga'     => $data->harga_brg,
            'remark'          => '',
            'tot_diskon'      => $diskon,
            'kode_pelanggan'  => '',
            'kode_kategori'   => $data->kode_kategori,
            'no_save'         => '',
            'id_karyawan'     => $this->session->userdata('id_karyawan')
        );
        $data = $this->model_pos->inst_temp_trx_pos($insert_data);
        echo json_encode($msg);
      }
  }

  //menmabahkan qty tabel temp_trx_pos (tabel keranjang)
  public function get_add_qty(){
    $id         = $this->input->post('id');
    $get_data   = $this->model_pos->get_info_prod($barcode)->result();

    $get_diskon = $this->model_pos->get_diskon($barcode)->row_array();
    $diskon     = $get_diskon['nilai_diskon']+0;

    $msg        = $this->model_pos->get_info_prod($barcode)->num_rows();

    foreach ($get_data as $data) {
         $insert_data = array(
            'barcode'         => $data->kode_barang,
            'nama_barang'     => $data->nama_barang,  
            'harga_brg'       => $data->harga_brg,
            'qty'             => 1,
            'discount'        => $diskon,
            'total_harga'     => $data->harga_brg,
            'remark'          => '',
            'tot_diskon'      => $diskon,
            'id_karyawan'     => $this->session->userdata('id_karyawan')
        );
        $data = $this->model_pos->inst_temp_trx_pos($insert_data);
        echo json_encode($msg);
      }
  }

  //membatalkan product jika klik tombol batal
  public function product_batal(){
    $data=$this->model_pos->product_batal();
    echo json_encode($data);
  }

  //set harga grosir jika klik tombol set_grosir
  public function set_harga_grosir(){
    $data=$this->model_pos->set_harga_grosir();
    echo json_encode($data);
  }

  //tambah qty jik klik tombol Add_qty
  public function add_qty(){
    $data=$this->model_pos->add_qty();
    echo json_encode($data);
  }

  //mengambil data total,diskon dan grand total
  public function total(){
    $data = $this->model_pos->total()->row_array();
    $total = $data['total'];
    echo number_format($total);
  }
  public function diskon(){
    $data = $this->model_pos->diskon()->row_array();
    $diskon = $data['diskon'];
    echo number_format($diskon);
  }
  public function grand_total(){
    $data = $this->model_pos->grand_total()->row_array();
    $grand_total = $data['grand_total'];
    echo number_format($grand_total);
  }

  //menghapus isi tabel temp_trx_pos (tabel keranjang)
  public function clear_tmp_trx(){
    $data=$this->model_pos->clear_tmp_trx();
    echo json_encode($data);
  }

  //menyimpan/hold tranksasi jik tombol save_trx di klik
  public function simpan_trx(){
    $no_pos                  = '1001';
    //data no save
    $get_no_save             = $this->model_pos->get_no_save()->row_array();
    $data_no_save            = substr($get_no_save['no_save'], 0, 4)+1;
    $no_save                 = sprintf("%04s", $data_no_save);
    //data no_pos
    $get_no_bill             = $this->model_pos->get_no_bill();
    
    $data_no_bill            = substr($get_no_bill['no_bill'], 0, 4)+1;
    $no_bill                 = sprintf("%04s", $data_no_bill);

    $get_data         = $this->model_pos->get_temp_trx_pos()->result();
    $data_no_save     = $this->model_pos->get_data_no_save()->row_array();
    $update_no_save   = $data_no_save['no_save'];
    /*print_r($update_no_save);
    die;*/

    foreach ($get_data as $data) {
        $insert_data = array(
            'no_save'         => $no_save,
            'no_pos'          => $no_pos,
            'no_bill'         => $no_bill,
            'barcode'         => $data->barcode,
            'nama_barang'     => $data->nama_barang,  
            'harga_brg'       => $data->harga_brg,
            'qty'             => $data->qty ,
            'discount'        => $data->discount,
            'total_harga'     => $data->total_harga,
            'remark'          => $data->remark,
            'id_karyawan'     => $data->id_karyawan,
            'tot_diskon'      => $data->tot_diskon,
            'kode_kategori'   => $data->kode_kategori,
            'tanggal'         => date('Y-m-d'),
            'jam'             => date("H:i:s"),
            'status'          => 0,
        );
        $data = $this->model_pos->inst_save_trx($insert_data);
        echo json_encode($data);
        $this->model_pos->update_status_no_save($update_no_save);
    }
  }

  //menampilkan table save_trx_pos
  public function fetch_call_trx_pos(){ 
     $fetch_data = $this->model_pos->get_save_trx_pos()->result();  
     $data = array();
     $num = 1;
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
          $sub_array[] = $row->no_save;
          $sub_array[] = $row->no_pos;
          $sub_array[] = $row->no_bill;
          $sub_array[] = $row->id_karyawan;
          $sub_array[] = $row->user_name;
          $sub_array[] = $row->tanggal;
          $sub_array[] = $row->jam;
          $data[] = $sub_array;  
     }  
     $output = array(  
          "data"            => $data  
     );  
     echo json_encode($output);  
  }

  //memanggil tranksasi yang tersimpan jik tombol call_trx di klik
  public function call_trx(){
    $get_data   = $this->model_pos->get_data_save_trx_pos()->result();
    foreach ($get_data as $data) {
         $insert_data = array(
            'barcode'         => $data->barcode,
            'nama_barang'     => $data->nama_barang,  
            'harga_brg'       => $data->harga_brg,
            'qty'             => $data->qty ,
            'discount'        => $data->discount,
            'total_harga'     => $data->total_harga,
            'remark'          => $data->remark,
            'id_karyawan'     => $data->id_karyawan,
            'tot_diskon'      => $data->tot_diskon,
            'kode_kategori'   => $data->kode_kategori,
            'no_save'         => $data->no_save,
        );

        $data = $this->model_pos->inst_temp_trx($insert_data);
      }
      echo json_encode($data);
  }

  //insert data ke tbl_penjualan dan tbl_det_penjualan
  public function ins_penjualan(){
    $bayar                   = $this->input->post('bayar');
    $no_pos                  = '1001';
    $get_data_penjualan      = $this->model_pos->get_penjualan()->result();
    $get_data_det_penjualan  = $this->model_pos->get_det_penjualan()->result();
    $get_no_bill             = $this->model_pos->get_no_bill();
    $data_no_bill            = substr($get_no_bill['no_bill'], 0, 4)+1;
    $no_bill                 = sprintf("%04s", $data_no_bill);
    //update status no_save
    $data_no_save     = $this->model_pos->get_data_no_save()->row_array();
    $update_no_save   = $data_no_save['no_save'];

    //insert ke table_penjualan
    foreach ($get_data_penjualan as $data) {
         $insert_data = array(
            'no_pos'         => $no_pos,
            'no_bill'        => $no_bill,
            'no_faktur'      => $no_pos.'-'.$no_bill,
            'tanggal'        => date('Y-m-d'), 
            'left_date'      => date('d'), 
            'jam'            => date("H:i:s"),
            'left_time'      => date('H:00:00'),
            'id_kasir'       => $this->session->userdata('id_karyawan'),
            'total'          => $data->total,
            'discount'       => $data->tot_diskon,
            'grand_total'    => $data->grand_total,
            'bayar'          => $bayar,
            'kembali'        => $bayar-$data->grand_total,
            'piutang'        => 0,
            'tipe_bayar'     => 'Tunai',
            'kode_pelanggan' => '',
            'no_save'        => $data->no_save,
        );
        $data_penjualan = $this->model_pos->ins_penjualan($insert_data);
      }
      //insert ke table_detai_penjualan
      foreach ($get_data_det_penjualan as $data) {
         $insert_data = array(
            'no_faktur'     => $no_pos.'-'.$no_bill,
            'kode_barang'   => $data->barcode, 
            'harga'         => $data->harga_brg,
            'qty'           => $data->qty,
            'discount'      => $data->discount,
            'total'         => $data->total_harga,
            'keterangan'    => $data->remark,
            'kode_kategori' => $data->kode_kategori,
            'left_time'     => date('H:00:00'),
            'tanggal'       => date('Y-m-d')
        );
        $data_det_penjualan = $this->model_pos->ins_det_penjualan($insert_data);
      }

      //insert ke tbl_kas_flow
      foreach ($get_data_penjualan as $data) {
         $insert_data = array(
            'no_faktur'   => $no_pos.'-'.$no_bill,
            'tanggal'     => date('Y-m-d'), 
            'jam'         => date("H:i:s"),
            'arah'        => 'Pemasukan',
            'nilai_masuk' => $data->grand_total,
            'nilai_keluar'=> 0,
            'user_id'     => $this->session->userdata('id_karyawan'),
            'keterangan'  => 'Pemasukan penjualan faktur '.$no_pos.'-'.$no_bill
        );
        $data_kas_flow = $this->model_pos->ins_kas_flow($insert_data);
      }
      echo json_encode($data_kas_flow );
      $this->model_pos->update_stock();
      $this->model_pos->update_status_no_save($update_no_save);
  }

  //insert piutang
  public function ins_piutang(){
    $piutang   = $this->input->post('piutang');
    $pelanggan = $this->input->post('pelanggan');
    $no_pos    = '1001';
    $get_data_penjualan      = $this->model_pos->get_penjualan()->result();
    $get_data_det_penjualan  = $this->model_pos->get_det_penjualan()->result();
    $get_no_bill             = $this->model_pos->get_no_bill();
    $data_no_bill            = substr($get_no_bill['no_bill'], 0, 4)+1;
    $no_bill                 = sprintf("%04s", $data_no_bill);
    $get_kode_pelanggan      = $this->model_pos->get_kode_plg($pelanggan)->row_array();
    $kode_pelanggan          = $get_kode_pelanggan['kode_pelanggan'];
    //update status no_save
    $data_no_save     = $this->model_pos->get_data_no_save()->row_array();
    $update_no_save   = $data_no_save['no_save'];
    
    //insert ke table_penjualan
    foreach ($get_data_penjualan as $data) {
         $insert_data = array(
            'no_pos'         => $no_pos,
            'no_bill'        => $no_bill,
            'no_faktur'      => $no_pos.'-'.$no_bill,
            'tanggal'        => date('Y-m-d'), 
            'left_date'      => date('d'), 
            'jam'            => date("H:i:s"),
            'left_time'      => date('H:00:00'),
            'id_kasir'       => $this->session->userdata('id_karyawan'),
            'total'          => $data->total,
            'discount'       => $data->tot_diskon,
            'grand_total'    => $data->grand_total,
            'bayar'          => 0,
            'kembali'        => 0,
            'piutang'        => $piutang,
            'tipe_bayar'     => 'Piutang',
            'kode_pelanggan' => $kode_pelanggan,
            'no_save'        => $data->no_save,
        );
         // insert ke tbl_piutang
         $insert_piutang = array(
            'tanggal'        => date('Y-m-d'),
            'no_piutang'     => date('ymd').$no_pos.$no_bill,
            'no_faktur'      => $no_pos.'-'.$no_bill,
            'kode_pelanggan' => $kode_pelanggan,
            'total_piutang'  => $piutang,
            'total_bayar'    => 0,
        );

        $data_penjualan = $this->model_pos->ins_penjualan($insert_data);
        $data_piutang   = $this->model_pos->ins_piutang($insert_piutang);

      }

      //insert ke table_detai_penjualan
      foreach ($get_data_det_penjualan as $data) {
         $insert_data = array(
            'no_faktur'     => $no_pos.'-'.$no_bill,
            'kode_barang'   => $data->barcode, 
            'harga'         => $data->harga_brg,
            'qty'           => $data->qty,
            'discount'      => $data->discount,
            'total'         => $data->total_harga,
            'keterangan'    => $data->remark,
            'kode_kategori' => $data->kode_kategori,
            'left_time'     => date('H:00:00'),
            'tanggal'       => date('Y-m-d')
        );
        $data_det_penjualan = $this->model_pos->ins_det_penjualan($insert_data);
      }

      //insert ke table_detail_piutang
      foreach ($get_data_det_penjualan as $data) {
         $insert_data = array(
            'no_faktur'     => $no_pos.'-'.$no_bill,
            'kode_barang'   => $data->barcode, 
            'harga'         => $data->harga_brg,
            'qty'           => $data->qty,
            'discount'      => $data->discount,
            'total'         => $data->total_harga,
            'keterangan'    => $data->remark,
            'kode_kategori' => $data->kode_kategori,
            'left_time'     => date('H:00:00'),
            'tanggal'       => date('Y-m-d')
        );
        $data_det_piutang = $this->model_pos->ins_det_piutang($insert_data);
      }

      echo json_encode($data_det_piutang);
      $this->model_pos->update_stock();
      $this->model_pos->update_status_no_save($update_no_save);
  }

  //insert kartu kredit
  public function ins_kartu_kredit(){
    $jml_debit   = $this->input->post('jml_debit');
    $no_kartu    = $this->input->post('no_kartu');
    $bank        = $this->input->post('bank');
    $validity    = $this->input->post('validity');
    $approval_no = $this->input->post('approval_no');
    $no_pos                  = '1001';
    $get_data_penjualan      = $this->model_pos->get_penjualan()->result();
    $get_data_det_penjualan  = $this->model_pos->get_det_penjualan()->result();
    $get_no_bill             = $this->model_pos->get_no_bill();
    $data_no_bill            = substr($get_no_bill['no_bill'], 0, 4)+1;
    $no_bill                 = sprintf("%04s", $data_no_bill);
    //update status no_save
    $data_no_save     = $this->model_pos->get_data_no_save()->row_array();
    $update_no_save   = $data_no_save['no_save'];
    //insert ke table_penjualan
    foreach ($get_data_penjualan as $data) {
         $insert_data = array(
            'no_pos'         => $no_pos,
            'no_bill'        => $no_bill,
            'no_faktur'      => $no_pos.'-'.$no_bill,
            'tanggal'        => date('Y-m-d'), 
            'left_date'      => date('d'), 
            'jam'            => date("H:i:s"),
            'left_time'      => date('H:00:00'),
            'id_kasir'       => $this->session->userdata('id_karyawan'),
            'total'          => $data->total,
            'discount'       => $data->tot_diskon,
            'grand_total'    => $data->grand_total,
            'bayar'          => $data->grand_total,
            'kembali'        => 0,
            'piutang'        => 0,
            'tipe_bayar'     => 'Debit',
            'kode_pelanggan' => '',
            'no_save'        => $data->no_save,
        );
         // insert ke kartu kredit
         $insert_kartu_kredit = array(
            'tanggal'     => date('Y-m-d'),
            'jam'         => date("H:i:s"),
            'no_faktur'   => $no_pos.'-'.$no_bill,
            'no_kartu'    => $no_kartu,
            'bank'        => $bank,
            'jml_debit'   => $jml_debit,
            'validity'    => $validity,
            'approval_no' => $approval_no,
            'id_kasir'    => $this->session->userdata('id_karyawan'),
        );
        $data_penjualan    = $this->model_pos->ins_penjualan($insert_data);
        $data_kartu_kredit = $this->model_pos->ins_kartu_kredit($insert_kartu_kredit);
      }

      //insert ke table_detai_penjualan
      foreach ($get_data_det_penjualan as $data) {
         $insert_data = array(
            'no_faktur'     => $no_pos.'-'.$no_bill,
            'kode_barang'   => $data->barcode, 
            'harga'         => $data->harga_brg,
            'qty'           => $data->qty,
            'discount'      => $data->discount,
            'total'         => $data->total_harga,
            'keterangan'    => $data->remark,
            'kode_kategori' => $data->kode_kategori,
            'left_time'     => date('H:00:00'),
            'tanggal'       => date('Y-m-d')
        );
        $data_det_penjualan = $this->model_pos->ins_det_penjualan($insert_data);
      }

      //insert ke tbl_kas_flow
      foreach ($get_data_penjualan as $data) {
         $insert_data = array(
            'no_faktur'   => $no_pos.'-'.$no_bill,
            'tanggal'     => date('Y-m-d'), 
            'jam'         => date("H:i:s"),
            'arah'        => 'Pemasukan',
            'nilai_masuk' => $data->grand_total,
            'nilai_keluar'=> 0,
            'user_id'     => $this->session->userdata('id_karyawan'),
            'keterangan'  => 'Pemasukan penjualan faktur '.$no_pos.'-'.$no_bill
        );
        $data_kas_flow = $this->model_pos->ins_kas_flow($insert_data);
      }
      echo json_encode($data_kas_flow );
      $this->model_pos->update_stock();
      $this->model_pos->update_status_no_save($update_no_save);
  }

  //mengambil data kembalian untuk ditampilkan di modal kembalian
  public function kembalian(){
    $data=$this->model_pos->get_kembalian()->row_array();
    $kembali = $data['kembali'];
    echo json_encode(number_format($kembali));
  }

  //mengambil data transaksi terakhir
  public function last_trx(){
    $data=$this->model_pos->get_last_trx()->row_array();
    $kembali = $data['kembali'];
    $last_trx = array(
            $data['grand_total'],
            $data['bayar'],
            $data['kembali']
        );
    echo json_encode($last_trx);
  }

  //mengambil data transaksi terakhir
  public function get_sales_kasir(){
    $data=$this->model_pos->get_sales_kasir()->row_array();
    $sales_kasir = number_format($data['grand_total']);
    
    echo json_encode($sales_kasir);
  }

  //mengambil data shift
  public function get_shift(){
    $data=$this->model_pos->get_shift()->row_array();
    $shift_kasir = $data['shift'];
    echo json_encode($shift_kasir);
  }  

  //merubah harga jual pada table master barang jika tombol Rbh_hrg di klik
  public function change_price(){
    $data=$this->model_pos->change_price();
    echo json_encode($data);
  }

  //merubah harga grosir pada table master barang jika tombol Rbh_gsir di klik
  public function change_price_grosir(){
    $data=$this->model_pos->change_price_grosir();
    echo json_encode($data);
  }

  /*fetch master barang*/
  public function fetch_master_barang(){
     $this->load->model("model_master_barang");   
     $fetch_data = $this->model_master_barang->make_datatables();  
     $data = array();
     foreach($fetch_data as $row)  
     {  
          $sub_array = array();
          $sub_array[] = '<a href="#" id="barcode" data-id="'.$row->kode_barang.'">'.$row->kode_barang.'</a>';
          $sub_array[] = $row->nama_barang;
          $sub_array[] = $row->satuan;
          $sub_array[] = $row->nama_kategori;
          $sub_array[] = $row->sales_stock;
          $sub_array[] = $row->harga_brg;
          $sub_array[] = $row->harga_grosir;
          $data[] = $sub_array;  
     }  
     $output = array(  
          "draw"            => intval($_POST["draw"]),  
          "recordsTotal"    => $this->model_master_barang->get_all_data(),  
          "recordsFiltered" => $this->model_master_barang->get_filtered_data(),  
          "data"            => $data  
     );  
     echo json_encode($output);  
  }

  //select 2 pelanggan  
  public function select_pelanggan(){
     $data = $this->model_pos->select_pelanggan();      
      echo json_encode($data);   
  }

  //select2 bank
  public function select_bank(){
     $data = $this->model_pos->select_bank();      
      echo json_encode($data);   
  }


}


  
