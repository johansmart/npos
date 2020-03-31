<?php  
 class Model_lap_kas_flow extends CI_Model  
 {  
 	 /*variable datatables*/
      var $table = "tbl_kas_flow, (SELECT @running_bal := 0) tempName";  
      var $select_column = array(
        "tbl_kas_flow.id",
        "tanggal",
        "jam",
        "tbl_kas_flow.user_id",
        "user_name",
        "no_faktur",
        "arah",
        "nilai_masuk",
        "nilai_keluar",
        "@running_bal := @running_bal + (`nilai_masuk` - `nilai_keluar`)  as `Balance`",
        "keterangan"
      );  
      var $order_column  = array("id","tanggal","jam","tbl_kas_flow.user_id","user_name","no_faktur","arah","nilai_masuk","nilai_keluar","Balance","keterangan");
      /*function get data from database*/  
      function make_query()  
      {  
      	$this->db->select($this->select_column);  
      	$this->db->from($this->table);
        $this->db->join('users', 'tbl_kas_flow.user_id = users.user_id', 'left');
		    $this->db->where('tbl_kas_flow.tanggal BETWEEN "'.$_POST["start_date"]. '" AND "'.$_POST["end_date"].'" AND arah like "%'.$_POST["arah"].'%"');

          if(isset($_POST['search']['value']))  
          {  
          	$this->db->group_start(); 	
            $this->db->like("tbl_kas_flow.user_id", $_POST["search"]["value"]);  
            $this->db->or_like("arah", $_POST["search"]["value"]);
            $this->db->or_like("user_name", $_POST["search"]["value"]);
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
           return $query;  
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