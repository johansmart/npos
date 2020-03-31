<?php  
 class Model_pos extends CI_Model  
 {  
    /*function get data from database*/  
    public function make_query(){
      $this->db->select('*');  
      $this->db->from('temp_trx_pos');
      //$this->db->where('id_karyawan='.$this->session->userdata('id_karyawan').' ');
    }

    /*function datatables*/
    public function make_datatables(){
      $this->make_query();  
      $query = $this->db->get();  
      return $query->result();  
    }

    //mengambil info data dari tabel master barang untuk ditampilkan difungsi add_item  
    public function get_info_prod(){  
      $barcode  = trim($this->input->post('barcode'));
      return $get_data   = $this->db->query("SELECT * FROM master_barang where  kode_barang='$barcode' ");
    }

    //cek float
    public function cek_float(){  
      return $get_data   = $this->db->query("SELECT float_value as float_value FROM tbl_float where  tanggal='".date('Y-m-d')."' AND id_kasir='".$this->session->userdata('id_karyawan')."' ");
    }

    //cek end shift
    public function cek_end_shift(){  
      return $get_data   = $this->db->query("SELECT id_kasir  FROM tbl_float where  tanggal='".date('Y-m-d')."' AND id_kasir='".$this->session->userdata('id_karyawan')."' AND end_shift > 0 ");
    }

    //cek closing
    /*public function cek_closing(){  
      return $get_data   = $this->db->query("SELECT kas_akhir as kas_akhir FROM tbl_closing where  tanggal='".date('Y-m-d',strtotime('yesterday'))."' ");
    }*/

    //mengambil data diskon
    public function get_diskon($barcode){  
      $tgl_hari_ini = date('Y-m-d');
      return $get_data   = $this->db->query("SELECT * FROM diskon where  barcode='$barcode' AND status='1' AND tgl_selesai >= '$tgl_hari_ini' ");
    }

    public function search_barang($cari_barang){
        $this->db->like('nama_barang', $cari_barang , 'both');
        $this->db->order_by('id', 'ASC');
        $this->db->limit(10);
        return $this->db->get('master_barang')->result();
    }

    /*insert item ke tbl temp_trx_pos*/  
    public function inst_temp_trx_pos($data){  
      $barcode       = trim($this->input->post('barcode'));
      $get_data      = $this->db->query("SELECT * FROM temp_trx_pos where  barcode='$barcode' AND remark !='Batal' ");
      $check         = $get_data->num_rows();
      $get_update    = $get_data->row_array();
      $remark        = $get_update['remark'];
      $qty_update    = $get_update['qty']+1;
      $hrg_update    = $get_update['harga_brg']*$qty_update;
      $diskon_update = $get_update['discount']*$qty_update;

      if ($check>0 && $remark !='Batal') {
        $this->db->set('total_harga', $hrg_update);
        $this->db->set('qty', $qty_update);
        $this->db->set('tot_diskon', $diskon_update);
        $this->db->where('barcode', $barcode);
        $where = "remark!='Batal'";
        $this->db->where($where);
        $result   = $this->db->update('temp_trx_pos');
        return false;
      }
      else{
        $this->db->insert('temp_trx_pos',$data);
      }
    }

    //membatalkan product jika klik tombol batal
    public  function product_batal(){   
      $id = trim($this->input->post('id')); 
      $this->db->set('remark', 'Batal');
      $this->db->where('id', $id);
      $this->db->update('temp_trx_pos');
    }

    //set harga grosir jika klik tombol set_grosir
    public  function set_harga_grosir(){   
      $id = trim($this->input->post('id'));
      $get_data = $this->db->query("SELECT barcode,qty,harga_brg FROM temp_trx_pos where id='$id' AND remark !='Batal'");
      $data           = $get_data->row_array();
      $barcode        = $data['barcode'];
      $get_hrg_grosir = $this->db->query("SELECT coalesce(harga_grosir,0) as harga_grosir FROM master_barang where  kode_barang='$barcode' ");
      $get_grosir     = $get_hrg_grosir->row_array();
      $harga_grosir   = $get_grosir['harga_grosir'];
      $qty            = $data['qty'];
      $hrg_update     = $get_grosir['harga_grosir']*$qty;
      if ($harga_grosir >0)
      {
        $this->db->set('harga_brg', $harga_grosir);
        $this->db->set('total_harga',$hrg_update);
        $this->db->set('remark', 'Harga grosir');
        $this->db->where('id', $id);
        $this->db->update('temp_trx_pos');
        //mengembalikan data ke controller pos function set_harga_grosir
        return 1;
      }
      else {
        //mengembalikan data ke controller pos untuk ditampilkan sebagai pesan
        return 0;
      }
    }

    //tambah qty jik klik tombol Add_qty
    public  function add_qty(){   
      $id            = trim($this->input->post('id'));
      $tambah_qty    = trim($this->input->post('tambah_qty')); 
      $get_data      = $this->db->query("SELECT * FROM temp_trx_pos where  id='$id' AND remark !='Batal' ");
      $get_add_qty   = $get_data->row_array();
      $qty           = $get_add_qty['qty'];
      $add_qty       = $get_add_qty['qty']+$tambah_qty;
      $harga_update  = $get_add_qty['harga_brg']*$add_qty;
      $diskon_update = $get_add_qty['discount']*$add_qty;

      $this->db->set('qty', $add_qty);
      $this->db->set('total_harga', $harga_update);
      $this->db->set('tot_diskon', $diskon_update);
      $this->db->where('id', $id);
      $this->db->update('temp_trx_pos');
    }

    //mengambil data total,diskon dan grand total
    public  function total(){ 
      return $get_data   = $this->db->query("SELECT sum(total_harga)as total FROM `temp_trx_pos` where remark !='Batal' ");  
    }
    public  function diskon(){
      return $get_data   = $this->db->query("SELECT sum(tot_diskon)as diskon FROM `temp_trx_pos`  where remark !='Batal' ");  
    }
    public  function grand_total(){
      return $get_data   = $this->db->query("SELECT sum(total_harga)-sum(tot_diskon) as grand_total FROM `temp_trx_pos`  where remark !='Batal' ");  
    }
    //selsai mengambil data total

    //menghapus isi tabel temp_trx_pos (tabel keranjang)
    public  function clear_tmp_trx(){
      $this->db->truncate('temp_trx_pos'); 
    }

    //get no save terakhir pada table save_trx_pos   
    public  function get_no_save(){   
      return $get_data   = $this->db->query("SELECT no_save FROM `save_trx_pos` where tanggal='".date('Y-m-d')."' order by id desc limit 1 ");
    }

    //menampilkan tranksasi yang tersimpan jik tombol call_trx di klik 
    public function get_save_trx_pos(){ 
      $query = $this->db->query("
      SELECT no_save,no_pos,no_bill,save_trx_pos.id_karyawan as id_karyawan,users.user_name as user_name,tanggal,jam 
      FROM `save_trx_pos` 
      LEFT JOIN users ON save_trx_pos.id_karyawan = users.user_id
      where tanggal ='".date('Y-m-d')."' AND id_karyawan='".$this->session->userdata('id_karyawan')."' AND status='0'  group by no_save
      ");
      return $query;
    }

    //menyimpan/hold tranksasi jik tombol save_trx di klik
    public function get_data_no_save(){  
      return $get_data   = $this->db->query("SELECT no_save FROM temp_trx_pos where  id_karyawan='".$this->session->userdata('id_karyawan')."' limit 1 ");
    }
    public function get_temp_trx_pos(){  
      return $get_data   = $this->db->query("SELECT * FROM temp_trx_pos where  id_karyawan='".$this->session->userdata('id_karyawan')."' ");
    }
    public  function inst_save_trx($data){   
      $this->db->insert('save_trx_pos',$data);
      $this->db->where("id_karyawan", $this->session->userdata('id_karyawan'));  
      $this->db->delete("temp_trx_pos");
    }
    public  function update_status_no_save($update_no_save){   
      $this->db->set('status', 1);
      $this->db->where('no_save', $update_no_save);
      $this->db->where('tanggal=',date('Y-m-d'));
      $this->db->update('save_trx_pos');
    }

    //selsai menyimpan/hold transaksi

    //mengambil data table save_trx_pos
    public function get_data_save_trx_pos(){  
      $no_save  = trim($this->input->post('no_save'));
      return $get_data   = $this->db->query("SELECT * FROM save_trx_pos where no_save='$no_save' AND id_karyawan='".$this->session->userdata('id_karyawan')."'  AND tanggal='".date('Y-m-d')."' AND status='0' ");
    }
    public  function inst_temp_trx($data){ 
      $this->db->insert('temp_trx_pos',$data);
    }
    //selesai mengambil data table save_trx_pos

    //insert data ke tbl_penjualan dan tbl_det_penjualan  
    public function get_penjualan(){
      return $get_data   = $this->db->query("SELECT sum(total_harga)as total,sum(tot_diskon)as tot_diskon,coalesce(sum(total_harga)-sum(tot_diskon))as grand_total,no_save as no_save FROM `temp_trx_pos` where id_karyawan ='".$this->session->userdata('id_karyawan')."' AND remark!='Batal'");
    }
    public function get_det_penjualan(){  
      return $get_data   = $this->db->query("SELECT * FROM temp_trx_pos where  id_karyawan='".$this->session->userdata('id_karyawan')."' AND remark!='Batal' ");
    }
    public  function ins_penjualan($data_penjualan){ 
      $this->db->insert('tbl_penjualan',$data_penjualan);
    }

    public  function ins_det_penjualan($data_det_penjualan){   
      $this->db->insert('tbl_det_penjualan',$data_det_penjualan);
      //hapus isi table save_trx_pos
      //$this->db->where("id_karyawan", $this->session->userdata('id_karyawan'));  
      //$this->db->delete("save_trx_pos");
    }
    //selesai insert penjualan

    //insert ke tbl_piutang
    public  function ins_piutang($data_piutang)  
    { 
      $this->db->insert('tbl_piutang',$data_piutang);
    }

    //insert ke kartu kredit
    public  function ins_kartu_kredit($data_kartu_kredit)  
    { 
      $this->db->insert('kartu_kredit',$data_kartu_kredit);
    }

    //insert ke table tbl_det_piutang
    public  function ins_det_piutang($data_det_piutang){   
      $this->db->insert('tbl_det_piutang',$data_det_piutang);

    }

    //insert ke tbl_kas_flow
    public  function ins_kas_flow($data_kas_flow){ 
      $this->db->insert('tbl_kas_flow',$data_kas_flow);
    }

    //get no faktur terakhir pada table penjualan / table save_trx_pos  
    public  function get_no_bill(){ 

      //no bill table penjualan  
       $get_data   = $this->db->query("SELECT no_bill FROM `tbl_penjualan` where tanggal='".date('Y-m-d')."' order by id desc limit 1 ");
       //no bill table save_trx_pos
       $get_data2   = $this->db->query("SELECT no_bill FROM `save_trx_pos` where tanggal='".date('Y-m-d')."' order by id desc limit 1 ");

       $no_bill_penj = $get_data->row_array();
       $no_bill_save = $get_data2->row_array();
       //return $no_bill_penj;
     

       if ($no_bill_penj > $no_bill_save) {
          return $no_bill_penj;
       }
       else{
        return $no_bill_save;
       }
       
    }

    //mengambil data kembalian untuk ditampilkan di modal kembalian
    public function get_kembalian(){
      return $get_data   = $this->db->query("SELECT kembali as kembali FROM tbl_penjualan where id_kasir='".$this->session->userdata('id_karyawan')."' ORDER BY id DESC limit 1 ");

    }

    //mengambil data transaksi terakhir
    public function get_last_trx(){  
      return $get_data   = $this->db->query("SELECT grand_total as grand_total,bayar as bayar, kembali as kembali,no_faktur as no_faktur,tipe_bayar as tipe_bayar FROM tbl_penjualan where id_kasir='".$this->session->userdata('id_karyawan')."' AND tanggal='".date('Y-m-d')."' ORDER BY id DESC limit 1 ");
    }

    //mengambil data penjualan kasir hari ini
    public function get_sales_kasir(){  
      return $get_data   = $this->db->query("SELECT sum(grand_total) as grand_total FROM tbl_penjualan where id_kasir='".$this->session->userdata('id_karyawan')."' AND tanggal='".date('Y-m-d')."' AND tipe_bayar='Tunai' ");
    }

    //mengambil data shift kasir hari ini
    public function get_shift(){  
      return $get_data   = $this->db->query("SELECT shift as shift FROM tbl_float where id_kasir='".$this->session->userdata('id_karyawan')."' AND tanggal='".date('Y-m-d')."' ");
    }

    //merubah harga jual pada table master barang jika tombol Rbh_hrg di klik
    public  function change_price(){   
      $barcode_chg_prc  = $this->input->post('barcode_chg_prc');
      $chg_prc          = $this->input->post('chg_prc');
      $get_data         = $this->db->query("SELECT * FROM temp_trx_pos where  barcode='$barcode_chg_prc' AND remark !='Batal' AND id_karyawan='".$this->session->userdata('id_karyawan')."' ");
      $result        = $get_data->row_array();
      $result_array  = $get_data->result();

      $qyt         = $result['qty'];
      $qyt         = $result['qty'];
      $harga_brg   = ['harga_brg'];
      $upd_tot_hrg = $qyt*$chg_prc;

      foreach ($result_array as $data) {
      $insert_data = array(
            'kode_barang' => $barcode_chg_prc, 
            'old_price'   => $data->harga_brg,
            'new_price'   => $chg_prc,
            'tanggal'     => date('Y-m-d'),
            'jam'         => date("H:i:s"),
            'id_kasir'    => $this->session->userdata('id_karyawan')
        );
      }

      $this->db->set('harga_brg', $chg_prc);
      $this->db->where('kode_barang', $barcode_chg_prc);
      $this->db->update('master_barang');
      //update price temp trx pos
      $this->db->set('harga_brg', $chg_prc);
      $this->db->set('total_harga', $upd_tot_hrg);
      $this->db->set('remark', '');
      $this->db->where('barcode', $barcode_chg_prc);
      $this->db->where('remark !=', 'Batal');
      $this->db->update('temp_trx_pos');
      //insert chg_price;
      $this->db->insert('chg_price',$insert_data);
    }

    //merubah harga grosir pada table master barang jika tombol Rbh_gsir di klik
    public  function change_price_grosir(){  
      $barcode_chg_grosir  = $this->input->post('barcode_chg_grosir');
      $chg_grosir          = $this->input->post('chg_grosir');
      $get_data            = $this->db->query("SELECT * FROM temp_trx_pos where  barcode='$barcode_chg_grosir' AND remark !='Batal' AND id_karyawan='".$this->session->userdata('id_karyawan')."' ");
      $result        = $get_data->row_array();
      $result_array  = $get_data->result();

      $qyt         = $result['qty'];
      $qyt         = $result['qty'];
      $harga_brg   = ['harga_brg'];
      $upd_tot_hrg = $qyt*$chg_grosir;

      foreach ($result_array as $data) {
      $insert_data = array(
            'kode_barang'      => $barcode_chg_grosir, 
            'old_price_grosir' => $data->harga_brg,
            'new_price_grosir' => $chg_grosir,
            'tanggal'          => date('Y-m-d'),
            'jam'              => date("H:i:s"),
            'id_kasir'         => $this->session->userdata('id_karyawan')
        );
      }

      $this->db->set('harga_grosir', $chg_grosir);
      $this->db->where('kode_barang', $barcode_chg_grosir);
      $this->db->update('master_barang');
      //update price temp trx pos
      $this->db->set('harga_brg', $chg_grosir);
      $this->db->set('total_harga', $upd_tot_hrg);
      $this->db->set('remark', 'Harga grosir');
      $this->db->where('barcode', $barcode_chg_grosir);
      $this->db->where('remark !=', 'Batal');
      $this->db->update('temp_trx_pos');
      //insert chg_price;
      $this->db->insert('chg_price_grosir',$insert_data);
    }

    //update stock pada table master barang
    public function update_stock(){
      $get_data     = $this->db->query("SELECT * FROM temp_trx_pos where id_karyawan='".$this->session->userdata('id_karyawan')."' AND remark!='Batal' ");
      $result =  $get_data->result();
      foreach ($result as $data) {
        $kode_barang = $data->barcode;
        $jumlah      = $data->qty;
        $this->db->set('book_stock','book_stock'.'-'. $jumlah, FALSE);
        $this->db->set('sales_stock','sales_stock'.'-'. $jumlah, FALSE);
        $this->db->set('terjual','terjual'.'+'. $jumlah, FALSE);
        $this->db->where(array('kode_barang' => $kode_barang));
        $result=$this->db->update('master_barang');
      }
    }

    //mengambil data promo
    public function get_promo(){  
      $tgl_hari_ini = date('Y-m-d');
      return $get_data   = $this->db->query("SELECT * FROM promo where tgl_selesai >= '$tgl_hari_ini' ");
    }

    //select 2 kategori
    public function select_pelanggan(){
      $query = $this->db->query("SELECT kode_pelanggan as id, nama_pelanggan as text FROM master_pelanggan where nama_pelanggan LIKE '%".$this->input->post("q")."%' order by nama_pelanggan asc  ");
      return $query->result_array();
    }

    //select 2 bank
    public function select_bank(){
      $query = $this->db->query("SELECT id as id, nama_bank as text FROM master_bank where nama_bank LIKE '%".$this->input->post("q")."%' order by id asc  ");
      return $query->result_array();
    }  

    //get kode pelanggan
    public function get_kode_plg($pelanggan){  
      $tgl_hari_ini = date('Y-m-d');
      return $get_data   = $this->db->query("SELECT kode_pelanggan as kode_pelanggan FROM master_pelanggan where nama_pelanggan='$pelanggan' ");
    }     

 }  