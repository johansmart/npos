<?php  
 class Model_list_print_pembelian extends CI_Model  
 {  
   /*variable datatables*/
      var $table = "tbl_pembelian";  
      var $select_column = array(
       "tbl_pembelian.tanggal",
       "tbl_pembelian.purc_no",
       "tbl_pembelian.kode_supp",
       "supplier.nama_supp",
       "tbl_pembelian.total_beli",
       "tbl_pembelian.tipe_bayar",
       "tbl_pembelian.id_karyawan"
      );  
      var $order_column = array(
        null,
        "tanggal",
        "purc_no",
        "kode_supp",
        "kode_pelanggan",
        "nama_supp",
        "total_beli",
        "tipe_bayar",
        "id_karyawan",
        null
      );

      function make_query()  
      {  
        $this->db->select($this->select_column);  
        $this->db->from($this->table);
        $this->db->join('supplier', 'tbl_pembelian.kode_supp = supplier.kode_supp', 'left'); 
        $this->db->where('tbl_pembelian.tanggal BETWEEN "'.$_POST["start_date"]. '" AND "'.$_POST["end_date"].'"');

          if(isset($_POST['search']['value']))  
          {  
              $this->db->group_start();   
              $this->db->like("tbl_pembelian.purc_no", $_POST["search"]["value"]);  
              $this->db->or_like("supplier.nama_supp", $_POST["search"]["value"]);
              $this->db->or_like("tbl_pembelian.purc_no", $_POST["search"]["value"]);
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


       /*get data print header*/
      public function get_data_print_header($purc_no)  
      {
        $query = $this->db->query("SELECT * FROM tbl_pembelian left join supplier on tbl_pembelian.kode_supp = supplier.kode_supp left join users on tbl_pembelian.id_karyawan = users.user_id WHERE purc_no ='$purc_no' ");
        return $query;
      }

       /*get data print table*/
      public function get_data_print_tbl($purc_no)  
      {
        $query = $this->db->query("SELECT * FROM tbl_det_pembelian left join master_barang on tbl_det_pembelian.kode_barang = master_barang.kode_barang WHERE no_nota ='$purc_no' ");
        return $query;
      }

      public function get_data_print_fooot_tbl($purc_no)  
      {
        $query = $this->db->query("SELECT sum(total_harga_beli) as total FROM tbl_det_pembelian WHERE no_nota ='$purc_no' ");
        return $query;
      }

 }  