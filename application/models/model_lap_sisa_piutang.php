<?php  
 class Model_lap_sisa_piutang extends CI_Model  
 {  
      /*variable datatables*/
      var $table = "tbl_piutang";  
      var $select_column = array(
       "tbl_piutang.id",
       "tbl_piutang.no_faktur",
       "tbl_piutang.tanggal",
       "tbl_piutang.no_piutang",  
       "tbl_piutang.kode_pelanggan",
       "master_pelanggan.nama_pelanggan",
       "tbl_piutang.total_piutang as total_piutang",
       "tbl_piutang.total_bayar as total_bayar",
       "coalesce(total_piutang - total_bayar) as sisa_piutang"
      );
      var $order_column = array(
        "id",
        "no_faktur",
        "tanggal",
        "no_piutang",
        "kode_pelanggan",
        "nama_supp",
        "total_piutang",
        "total_bayar",
        "sisa_piutang",
        null
      );
      /*function get data from database*/  
      public function make_query()  
      {  
        $this->db->select($this->select_column);  
        $this->db->from($this->table);
        $this->db->join('master_pelanggan', 'tbl_piutang.kode_pelanggan = master_pelanggan.kode_pelanggan', 'left'); 
        if(isset($_POST["search"]["value"]))  
        {  
            $this->db->like("tbl_piutang.no_faktur", $_POST["search"]["value"]);  
            $this->db->or_like("master_pelanggan.nama_pelanggan", $_POST["search"]["value"]);
            $this->db->or_like("tbl_piutang.no_piutang", $_POST["search"]["value"]);
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

    //insert bayar piutang
    public  function insert_bayar_piutang($data)  
    { 
      $this->db->insert('tbl_bayar_piutang',$data);
    }

    //update jumlah bayar piutang
    public function update_jumlah_bayar(){
      $no_piutang     = $this->input->post("no_piutang");
      $bayar_piutang  = $this->input->post("bayar_piutang");
      $this->db->set('total_bayar','total_bayar'.'+'. $bayar_piutang, FALSE);
      $this->db->where(array('no_piutang' => $no_piutang));
      $result=$this->db->update('tbl_piutang');
    }

    //insert ke tbl_kas_flow
    public  function ins_kas_flow($data_kas_flow){ 
      $this->db->insert('tbl_kas_flow',$data_kas_flow);
    }

 }  