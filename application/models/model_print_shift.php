<?php  
 class Model_print_shift extends CI_Model  
 {  
      
    //mengambil data shift
    public function get_last_start_shift(){  
      return $get_data   = $this->db->query("
        SELECT 
        tbl_float.id_kasir
        ,tbl_float.no_pos
        ,tbl_float.tanggal
        ,tbl_float.jam
        ,tbl_float.shift
        ,tbl_float.float_value
        ,users.user_name
        FROM tbl_float
        left join users
        on tbl_float.id_kasir=users.user_id
        where id_kasir='".$this->session->userdata('id_karyawan')."' AND tanggal='".date('Y-m-d')."'
        ORDER BY tbl_float.id DESC limit 1 
        ");
    }

    public function get_last_end_shift(){  
      return $get_data   = $this->db->query("
        SELECT 
        tbl_float.id_kasir
        ,tbl_float.no_pos
        ,tbl_float.tanggal
        ,tbl_float.jam
        ,tbl_float.shift
        ,tbl_float.end_shift
        ,users.user_name
        FROM tbl_float
        left join users
        on tbl_float.id_kasir=users.user_id
        where id_kasir='".$this->session->userdata('id_karyawan')."' AND tanggal='".date('Y-m-d')."'
        ORDER BY tbl_float.id DESC limit 1 
        ");
    }
 
 }  