<?php  
 class Model_lap_sisa_hutang extends CI_Model  
 {  
      /*variable datatables*/
      var $table = "tbl_hutang";  
      var $select_column = array(
       "tbl_hutang.id",
       "tbl_hutang.no_nota",
       "tbl_hutang.no_hutang", 
       "tbl_hutang.kode_supp",
       "supplier.nama_supp",
       "tbl_hutang.total_hutang as total_hutang",
       "tbl_hutang.total_bayar as total_bayar",
       "coalesce(total_hutang - total_bayar) as sisa_hutang"
      );
      var $order_column = array(
        "id",
        "no_nota",
        "no_hutang",
        "kode_supp",
        "nama_supp",
        "total_hutang",
        "total_bayar",
        "sisa_hutang",
        null
      );
      /*function get data from database*/  
      public function make_query()  
      {  
        $this->db->select($this->select_column);  
        $this->db->from($this->table);
        $this->db->join('supplier', 'tbl_hutang.kode_supp = supplier.kode_supp', 'left'); 
        if(isset($_POST["search"]["value"]))  
        {  
            $this->db->like("tbl_hutang.no_nota", $_POST["search"]["value"]);  
            $this->db->or_like("supplier.nama_supp", $_POST["search"]["value"]);
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

    //insert bayar hutang
    public  function insert_bayar_hutang($data)  
    { 
      $this->db->insert('tbl_bayar_hutang',$data);
    }

    //update jumlah bayar hutang
    public function update_jumlah_bayar(){
      $no_nota       = $this->input->post("no_nota");
      $bayar_hutang  = $this->input->post("bayar_hutang");
      $this->db->set('total_bayar','total_bayar'.'+'. $bayar_hutang, FALSE);
      $this->db->where(array('no_nota' => $no_nota));
      $result=$this->db->update('tbl_hutang');
    }

    //insert ke tbl_kas_flow
    public  function ins_kas_flow($data_kas_flow){ 
      $this->db->insert('tbl_kas_flow',$data_kas_flow);
    }

 }  