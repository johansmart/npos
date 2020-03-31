<?php  
 class Model_lap_biaya extends CI_Model  
 {  
 	 /*variable datatables*/
      var $table = "tbl_biaya";  
      var $select_column = array("tanggal","jam","tbl_biaya.user_id","user_name","tbl_biaya.id_biaya","jenis_biaya","nilai_biaya","keterangan");  
      var $order_column  = array("tanggal","jam","user_id","user_name","user_id","id_biaya","jenis_biaya","nilai_biaya","keterangan");
      /*function get data from database*/  
      function make_query()  
      {  
      	$this->db->select($this->select_column);  
      	$this->db->from($this->table);
        $this->db->join('users', 'tbl_biaya.user_id = users.user_id', 'left');
        $this->db->join('master_biaya', 'tbl_biaya.id_biaya = master_biaya.id_biaya', 'left');
		    $this->db->where('tbl_biaya.tanggal BETWEEN "'.$_POST["start_date"]. '" AND "'.$_POST["end_date"].'"');

          if(isset($_POST['search']['value']))  
          {  
          	$this->db->group_start(); 	
            $this->db->like("tbl_biaya.user_id", $_POST["search"]["value"]);  
            $this->db->or_like("tanggal", $_POST["search"]["value"]);
            $this->db->or_like("user_name", $_POST["search"]["value"]);
            $this->db->or_like("tbl_biaya.id_biaya", $_POST["search"]["value"]);
            $this->db->or_like("master_biaya.jenis_biaya", $_POST["search"]["value"]);
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