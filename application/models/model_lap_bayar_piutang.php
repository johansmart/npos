<?php  
 class Model_lap_bayar_piutang extends CI_Model  
 {  
 	 /*variable datatables*/
      var $table = "tbl_bayar_piutang";  
      var $select_column = array("
        tbl_bayar_piutang.user_id",
        "tbl_bayar_piutang.no_piutang",
        "tbl_piutang.no_faktur",
        "tbl_bayar_piutang.tanggal",
        "tbl_bayar_piutang.jam",
        "tbl_piutang.kode_pelanggan",
        "master_pelanggan.nama_pelanggan",
        "tbl_bayar_piutang.jumlah_bayar"
      );  
      var $order_column  = array(null,"id_karyawan","no_piutang", "no_faktur","tanggal", "jam", "kode_pelanggan","nama_pelanggan","jumlah_bayar");
      /*function get data from database*/  
      function make_query()  
      {  
      	$this->db->select($this->select_column);  
      	$this->db->from($this->table);
        $this->db->join('tbl_piutang', 'tbl_bayar_piutang.no_piutang = tbl_piutang.no_piutang', 'left');
        $this->db->join('master_pelanggan', 'tbl_piutang.kode_pelanggan = master_pelanggan.kode_pelanggan', 'left');
		    $this->db->where('tbl_bayar_piutang.tanggal BETWEEN "'.$_POST["start_date"]. '" AND "'.$_POST["end_date"].'"');

          if(isset($_POST['search']['value']))  
          {  
          	  $this->db->group_start(); 	
              $this->db->like("tbl_bayar_piutang.no_piutang", $_POST['search']['value']);
              $this->db->or_like("tbl_piutang.kode_pelanggan", $_POST['search']['value']);
              $this->db->or_like("master_pelanggan.nama_pelanggan", $_POST['search']['value']);
              $this->db->group_end(); 
          }  
          if(isset($_POST["order"]))  
          {  
              $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
          }  
          else  
          {  		
              $this->db->order_by('id', 'ASC');  
              
          }
      }
      /*function datatables*/
      function make_datatables(){  
           $this->make_query();  
           if($_POST["length"] != -1)  
           {  
              $this->db->limit($_POST['length'], $_POST['start']);  
           }

           $query = $this->db->get();  
           return $query->result();  
      }
      function get_filtered_data(){  
           $this->make_query();  
           $query = $this->db->get();  
           return $query->num_rows();  
      }    
      function get_all_data()  
      {  
           $this->db->select($this->select_column);  
           $this->db->from($this->table);  
           return $this->db->count_all_results();  
      }

 }  