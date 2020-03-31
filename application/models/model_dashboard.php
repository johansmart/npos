<?php  
 class Model_dashboard extends CI_Model  
 {  

      public function jml_barang(){
        $query = $this->db->query("SELECT kode_barang FROM master_barang ");
        return $query->num_rows();
      }

      public function stock_kosong(){
        $query = $this->db->query("SELECT kode_barang FROM master_barang where sales_stock='0'");
        return $query->num_rows();
      }

      public function sales_hari_ini(){
        $hari_ini     = date("Y-m-d"); 
        $query = $this->db->query("SELECT coalesce(sum(grand_total),0) as sales_today FROM tbl_penjualan where tanggal='$hari_ini' ");
        return $query->row_array();
      }

      public function sales_bulan_ini(){
        $hari_ini     = date("Y-m-d");
        $tgl_pertama  = date('Y-01-01', strtotime($hari_ini)); 
        $tgl_terakhir = date('Y-m-t', strtotime($hari_ini));
        $query = $this->db->query("SELECT coalesce(sum(grand_total),0) as sales_month FROM tbl_penjualan where  tanggal between '$tgl_pertama' and '$tgl_terakhir'");
        return $query->row_array();
      }

      public function getdata_chart_date(){
        $hari_ini     = date("Y-m-d");
        $tgl_pertama  = date('Y-m-01', strtotime($hari_ini));
        $tgl_terakhir = date('Y-m-t', strtotime($hari_ini)); 
        $last_day     = date('t',strtotime($hari_ini)); 
        $query = $this->db->query("
          SELECT tbl_tanggal.left_date as left_date,
          coalesce(tot_sales,0) as jml_sales
          FROM tbl_tanggal 
          left JOIN 
          (SELECT tbl_tanggal.left_date, sum(tbl_penjualan.grand_total)as tot_sales FROM tbl_tanggal, tbl_penjualan WHERE tbl_tanggal.left_date=tbl_penjualan.left_date and tbl_penjualan.tanggal between '$tgl_pertama' and '$tgl_terakhir'  GROUP BY tbl_penjualan.left_date ASC 
          ) as total ON tbl_tanggal.left_date=total.left_date WHERE tbl_tanggal.left_date <=  $last_day"
        );
        return $query->result();
      }


      public function getdata_chart_time(){
        $hari_ini     = date("Y-m-d");
        $query = $this->db->query("
          SELECT LEFT(tbl_jam.left_time,5) as jam,
          coalesce(total_kendaraan,0) as jml_kendaraan 
          FROM tbl_jam left JOIN 
          (SELECT tbl_jam.left_time, sum(tbl_penjualan.grand_total)as total_kendaraan FROM tbl_jam, tbl_penjualan WHERE tbl_jam.left_time=tbl_penjualan.left_time and tbl_penjualan.tanggal='$hari_ini' GROUP BY tbl_penjualan.left_time ASC 
          ) as total ON tbl_jam.left_time=total.left_time"
        );
        return $query->result();
      }

      



 }  