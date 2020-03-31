<?php  
 class Model_tag_print extends CI_Model  
 {  
      /*variable datatables*/
      var $table = "tbl_tag_print";  
      var $select_column = array("tanggal","jam","tbl_tag_print.user_id","user_name","tbl_tag_print.kode_barang","nama_barang","harga_brg","kategori");  
      var $order_column = array("tanggal","jam","tbl_tag_print.user_id","user_name","kode_barang","nama_barang","harga_brg","kategori");
      /*function get data from database*/  
      public function make_query()  
      {  
        $this->db->select($this->select_column); 
        $this->db->from($this->table);
        $this->db->join('users', 'tbl_tag_print.user_id = users.user_id', 'left');
        $this->db->join('master_barang', 'tbl_tag_print.kode_barang = master_barang.kode_barang', 'left');
        if(isset($_POST["search"]["value"]))  
        {  
            $this->db->like("tbl_tag_print.user_id", $_POST["search"]["value"]);  
            $this->db->or_like("tanggal", $_POST["search"]["value"]);
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

      
      //datatable cari produk
      /*variable datatables*/
      var $table2 = "master_barang";  
      var $select_column2 = array(
       "master_barang.id",
       "master_barang.kode_barang", 
       "master_barang.nama_barang",
       "satuan.satuan",
       "kategori.kode_kategori",
       "kategori.nama_kategori",
       "master_barang.harga_beli",
       "master_barang.sales_stock"
      );
      var $order_column2 = array(
        "id",
        "kode_barang",
        "nama_barang",
        "satuan",
        "nama_kategori",
        "harga_beli",
        "sales_stock"
      );
      /*function get data from database*/  
      public function make_query_cari_produk()  
      {  
        $this->db->select($this->select_column2);  
        $this->db->from($this->table2);
        $this->db->join('kategori', 'master_barang.kode_kategori = kategori.kode_kategori', 'left');
        $this->db->join('satuan', 'master_barang.kode_satuan = satuan.kode_satuan', 'left');  
        if(isset($_POST["search"]["value"]))  
        {  
            $this->db->like("master_barang.kode_barang", $_POST["search"]["value"]);  
            $this->db->or_like("master_barang.nama_barang", $_POST["search"]["value"]);
            $this->db->or_like("kategori.nama_kategori", $_POST["search"]["value"]);
        }  
        if(isset($_POST["order"]))  
        {  
            $this->db->order_by($this->order_column2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
        }  
        else  
        {  
            $this->db->order_by('id', 'DESC');  
        }  
      }
      /*function datatables*/
      public function cari_produk(){  
           $this->make_query_cari_produk();  
           if($_POST["length"] != -1)  
           {  
              $this->db->limit($_POST['length'], $_POST['start']);  
           }  
           $query = $this->db->get();  
           return $query->result();  
      }  
      public function get_filtered_data_cari_produk(){  
           $this->make_query_cari_produk();  
           $query = $this->db->get();  
           return $query->num_rows();  
      }       
      public function get_all_data_cari_produk()  
      {  
           $this->db->select("*");  
           $this->db->from($this->table2);  
           return $this->db->count_all_results();  
      }


      //cek float
      public  function cek_print()  
      { 
        $kode_barang = $this->input->post("kode_barang");
        $query = $this->db->query("SELECT kode_barang FROM tbl_tag_print WHERE kode_barang='$kode_barang' ");
        return $query;
      }

      //insert manual print
      public  function insert_manual_print($data)  
      { 
        $this->db->insert('tbl_tag_print',$data);
      }

      //reset print
      public function reset_print(){
        $this->db->where(array('user_id' => $this->session->userdata('id_karyawan')));  
        $this->db->delete("tbl_tag_print");
      }

      //select 2 kategori
      public function select_kategori(){
        $query = $this->db->query("SELECT kode_kategori as id, CONCAT(kode_kategori,' - ',nama_kategori) as text FROM kategori where nama_kategori LIKE '%".$this->input->post("q")."%' ");
        return $query->result_array();
      }

      //get category print
      public  function get_cat_print()  
      { 
        $post_cat = $this->input->post("post_cat");
        $query = $this->db->query("SELECT kode_barang FROM master_barang WHERE kode_kategori='$post_cat' ");
        return $query;
      }

      /*get item info*/
      public function get_all_print()  
      {
        $query = $this->db->query("SELECT kode_barang as kode_barang, CONCAT(kategori.kode_kategori,' - ',kategori.nama_kategori) as kategori FROM master_barang LEFT JOIN kategori on master_barang.kode_kategori=kategori.kode_kategori ");
        return $query;
      }

      /*get data print*/
      public function get_data_print()  
      {
        $query = $this->db->query("SELECT master_barang.nama_barang,master_barang.harga_brg,tbl_tag_print.kode_barang,tbl_tag_print.kategori FROM tbl_tag_print left join master_barang on tbl_tag_print.kode_barang=master_barang.kode_barang ");
        return $query;
      }





      
 }  