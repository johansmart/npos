<?php  
 class Model_trans_kartu_kredit extends CI_Model  
 {  
   /*variable datatables*/
      var $table = "kartu_kredit";  
      var $select_column = array("no_faktur", "tanggal","jam", "no_kartu", "bank","jml_debit","validity","approval_no","id_kasir");  
      var $order_column  = array("no_faktur", "tanggal","jam", "no_kartu", "bank","jml_debit","validity","approval_no","id_kasir");
      /*function get data from database*/  
      function make_query()  
      {  
        $this->db->select($this->select_column);  
        $this->db->from($this->table);
        $this->db->where('tanggal BETWEEN "'.$_POST["start_date"]. '" AND "'.$_POST["end_date"].'"');

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