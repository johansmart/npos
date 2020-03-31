<?php  
 class Model_biaya extends CI_Model  
 {  
      /*variable datatables*/
      var $table = "tbl_biaya";  
      var $select_column = array("tanggal","jam","tbl_biaya.user_id","user_name","tbl_biaya.id_biaya","jenis_biaya","nilai_biaya","keterangan");  
      var $order_column  = array("tanggal","jam","tbl_biaya.user_id","user_name","tbl_biaya.id_biaya","jenis_biaya","nilai_biaya","keterangan");
      /*function get data from database*/  
      public function make_query()  
      {  
        $this->db->select($this->select_column); 
        $this->db->from($this->table);
        $this->db->join('users', 'tbl_biaya.user_id = users.user_id', 'left');
        $this->db->join('master_biaya', 'tbl_biaya.id_biaya = master_biaya.id_biaya', 'left');
        if(isset($_POST["search"]["value"]))  
        {  
            $this->db->like("tbl_biaya.user_id", $_POST["search"]["value"]);  
            $this->db->or_like("tanggal", $_POST["search"]["value"]);
            $this->db->or_like("user_name", $_POST["search"]["value"]);
            $this->db->or_like("tbl_biaya.id_biaya", $_POST["search"]["value"]);
            $this->db->or_like("master_biaya.jenis_biaya", $_POST["search"]["value"]);
        }  
        if(isset($_POST["order"]))  
        {  
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('id', 'DESC');  
        }  
      }
      /*function datatables*/
      public function make_datatables(){  
           $this->make_query();  
           if($_POST["length"] != -1)  
           {  
              $this->db->limit($_POST['length'], $_POST['start']);  
           }  
           $query = $this->db->get();  
           return $query->result();  
      }  
      public function get_filtered_data(){  
           $this->make_query();  
           $query = $this->db->get();  
           return $query->num_rows();  
      }       
      public function get_all_data()  
      {  
           $this->db->select("*");  
           $this->db->from($this->table);  
           return $this->db->count_all_results();  
      }

      //select 2 biaya
      public function select_biaya(){
        $query = $this->db->query("SELECT id_biaya as id, jenis_biaya as text FROM master_biaya where jenis_biaya LIKE '%".$this->input->post("q")."%' ");
        return $query->result_array();
      }

      //get get_kode_kategori
      public function get_id_biaya()  
      {
        $jenis_biaya = $this->input->post("jenis_biaya");
        return $get_data   = $this->db->query("SELECT id_biaya as id_biaya FROM master_biaya where jenis_biaya='$jenis_biaya' ");
      }

      //insert ke tbl_biaya
      public  function insert_biaya($data)  
      { 
        $this->db->insert('tbl_biaya',$data);
      }

      //insert ke tbl_kas_flow
      public  function ins_kas_flow($data_kas_flow){ 
        $this->db->insert('tbl_kas_flow',$data_kas_flow);
      }




      
 }  