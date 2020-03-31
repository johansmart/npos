<?php  
 class Model_print_closing extends CI_Model  
 {  
      
    //mengambil data shift
    public function get_last_closing(){  
      return $get_data   = $this->db->query("
        SELECT 
        tbl_closing.id_kasir
        ,tbl_closing.end_of_shift_1
        ,tbl_closing.end_of_shift_2
        ,tbl_closing.total_kas
        ,tbl_closing.pengeluaran
        ,tbl_closing.kas_akhir
        ,users.user_name
        FROM tbl_closing
        left join users
        on tbl_closing.id_kasir=users.user_id
        where id_kasir='".$this->session->userdata('id_karyawan')."' AND tanggal='".date('Y-m-d')."'
        ORDER BY tbl_closing.id DESC limit 1 
        ");
    }

    //rincian penjualan tunai dan nontunai
    public function get_rincian_trx(){  
      return $get_data   = $this->db->query("
        SELECT tipe_bayar as tipe_bayar,sum(grand_total)as grand_total FROM `tbl_penjualan` where tanggal ='".date('Y-m-d')."'group by tipe_bayar
        ");
    }

 }  