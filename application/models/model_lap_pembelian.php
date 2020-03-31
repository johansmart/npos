<?php  
 class Model_lap_pembelian extends CI_Model  
 {  
 	 /*variable datatables*/
      var $table = "tbl_pembelian";  
      var $select_column = array("tbl_pembelian.id_karyawan","tbl_pembelian.purc_no","tbl_pembelian.tanggal","tbl_pembelian.jam","tbl_pembelian.kode_supp","supplier.nama_supp","tbl_pembelian.total_beli","tbl_pembelian.total_hutang","tbl_pembelian.tipe_bayar");  
      var $order_column  = array(null,"id_karyawan", "tbl_pembelian.purc_no","tanggal", "jam", "kode_supp","nama_supp","total_beli","total_hutang","tipe_bayar");
      /*function get data from database*/  
      function make_query()  
      {  
      	$this->db->select($this->select_column);  
      	$this->db->from($this->table);
        $this->db->join('supplier', 'tbl_pembelian.kode_supp = supplier.kode_supp', 'left');
		    $this->db->where('tbl_pembelian.tanggal BETWEEN "'.$_POST["start_date"]. '" AND "'.$_POST["end_date"].'"');

          if(isset($_POST['search']['value']))  
          {  
          	  $this->db->group_start(); 	
              $this->db->like("tbl_pembelian.purc_no", $_POST['search']['value']);
              $this->db->or_like("tbl_pembelian.kode_supp", $_POST['search']['value']);
              $this->db->or_like("supplier.nama_supp", $_POST['search']['value']);
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