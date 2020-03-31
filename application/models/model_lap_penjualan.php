<?php  
 class Model_lap_penjualan extends CI_Model  
 {  
 	 /*variable datatables*/
      var $table = "tbl_penjualan";  
      var $select_column = array("no_faktur", "tanggal","jam", "total", "discount","grand_total","bayar","kembali","id_kasir","tipe_bayar");  
      var $order_column  = array(null,"id_kasir","no_faktur", "tanggal","jam", "total", "discount","grand_total","bayar","kembali","tipe_bayar");
      /*function get data from database*/  
      function make_query()  
      {  
      	$this->db->select($this->select_column);  
      	$this->db->from($this->table);
		    $this->db->where('tanggal BETWEEN "'.$_POST["start_date"]. '" AND "'.$_POST["end_date"].'" ');

          if(isset($_POST['search']['value']))  
          {  
          	  $this->db->group_start(); 	
              $this->db->like("no_faktur", $_POST['search']['value']);
              $this->db->or_like("id_kasir", $_POST['search']['value']);
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