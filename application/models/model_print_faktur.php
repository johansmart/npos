<?php  
 class Model_print_faktur extends CI_Model  
 {  
      
    //mengambil no faktur terakhir terakhir
    public function get_last_faktur(){  
      return $get_data   = $this->db->query("
            SELECT 
            tbl_penjualan.no_faktur
            ,tbl_penjualan.tanggal
            ,tbl_penjualan.jam
            ,users.user_name
            ,tbl_penjualan.grand_total
            ,tbl_penjualan.bayar
            ,tbl_penjualan.kembali
            ,tbl_penjualan.piutang
            ,tbl_penjualan.tipe_bayar
            FROM tbl_penjualan
            left join users
            on tbl_penjualan.id_kasir=users.user_id
            where id_kasir='".$this->session->userdata('id_karyawan')."' 
            ORDER BY tbl_penjualan.id DESC limit 1 
        ");
    }

    public function get_item_faktur($no_faktur){  
      return $get_data   = $this->db->query("
        SELECT 
            tbl_det_penjualan.no_faktur 
            ,tbl_det_penjualan.tanggal
            ,tbl_det_penjualan.kode_barang
            ,master_barang.nama_barang
            ,tbl_det_penjualan.harga
            ,tbl_det_penjualan.total
            ,tbl_det_penjualan.qty
            FROM `tbl_det_penjualan`
            left join master_barang
            on tbl_det_penjualan.kode_barang = master_barang.kode_barang
            WHERE tanggal='".date('Y-m-d')."' and no_faktur='$no_faktur'
        ");
    }

    //mengambil no piutang
    public function get_no_piutang($no_faktur){  
      return $get_data   = $this->db->query("
            SELECT no_piutang as no_piutang FROM tbl_piutang where no_faktur='$no_faktur' AND tanggal='".date('Y-m-d')."'
            
        ");
    }

    //mengambil transaksi debitcard
    public function get_debit_trx($no_faktur){  
      return $get_data   = $this->db->query("
            SELECT no_kartu as no_kartu,bank as bank,validity as validity,approval_no as approval_no FROM kartu_kredit where no_faktur='$no_faktur' AND tanggal='".date('Y-m-d')."'
        ");
    }




      
      
      
 }  