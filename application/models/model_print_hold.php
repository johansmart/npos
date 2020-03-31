<?php  
 class Model_print_hold extends CI_Model  
 {  
      
    //mengambil no faktur terakhir terakhir
    public function get_last_hold(){  
      return $get_data   = $this->db->query("
            SELECT 
            save_trx_pos.no_save
            ,save_trx_pos.no_pos
            ,save_trx_pos.tanggal
            ,save_trx_pos.jam
            ,users.user_name
            ,save_trx_pos.id_karyawan
            FROM save_trx_pos
            left join users
            on save_trx_pos.id_karyawan=users.user_id
            where id_karyawan='".$this->session->userdata('id_karyawan')."' 
            ORDER BY save_trx_pos.id DESC limit 1 
        ");
    }
 
 }  