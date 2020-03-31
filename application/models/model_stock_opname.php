<?php  
 class Model_stock_opname extends CI_Model  
 {  
/*variable datatables*/
      var $table = "temp_stock_opname";
      var $select_column = array(
        "temp_stock_opname.tanggal",
        "temp_stock_opname.kode_barang",
        "master_barang.nama_barang",
        "master_barang.harga_beli as harga_beli",
        "satuan.satuan",
        "temp_stock_opname.kategori",
        "temp_stock_opname.sales_stock",
        "temp_stock_opname.fisik",
        "temp_stock_opname.diff",
        "temp_stock_opname.diff_value",

      );  
      var $order_column  = array(
        null,
        "tanggal",
        "kode_barang",
        "nama_barang",
        "harga_brg",
        "satuan",
        "kategori",
        "sales_stock",
        "fisik",
        "diff",
        "diff_value",
        null
      );
      /*function get data from database*/  
      function make_query()  
      {  
        $this->db->select($this->select_column);  
        $this->db->from($this->table);
        $this->db->join('master_barang', 'temp_stock_opname.kode_barang = master_barang.kode_barang', 'left');
        $this->db->join('satuan', 'master_barang.kode_satuan = satuan.kode_satuan', 'left');
        if(isset($_POST['search']['value']))  
        {  
            $this->db->group_start();   
            $this->db->like("temp_stock_opname.kode_barang", $_POST['search']['value']);
            $this->db->or_like("master_barang.nama_barang", $_POST['search']['value']);
            //$this->db->or_like("kategori.nama_kategori", $_POST['search']['value']);
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

       //insert register
      public  function insert_tmp_stock_opname($data)  
      { 
        $this->db->insert('temp_stock_opname',$data);
      }

      /*cek barang yg sudah ada*/
      public function cek_barang()  
      {
        $kode_barang   = $this->input->post('kode_barang');
        $query = $this->db->query("SELECT kode_barang FROM temp_stock_opname WHERE kode_barang='$kode_barang'");
        return $query;
      }

      //get category register
      public  function get_cat_reg()  
      { 
        $post_cat = $this->input->post("post_cat");
        $query = $this->db->query("SELECT kode_barang,sales_stock FROM master_barang WHERE kode_kategori='$post_cat' ");
        return $query;
      }

      //get all product register
      public  function get_all_product_reg()  
      { 
        $query = $this->db->query("SELECT kode_barang as kode_barang, CONCAT(kategori.kode_kategori,' - ',kategori.nama_kategori) as kategori,sales_stock FROM master_barang LEFT JOIN kategori on master_barang.kode_kategori=kategori.kode_kategori ");
        return $query;
      }

      /*update barang*/  
      public function update_fisik()  
      {  

          $kode_barang  = $this->input->post('kode_barang');
          $get_stock = $this->db->query("SELECT sales_stock,harga_brg FROM master_barang WHERE kode_barang='$kode_barang'");
          $data        = $get_stock->row_array();
          $stock       = $data['sales_stock'];
          $harga       = $data['harga_brg'];
          $fisik       = $this->input->post('fisik');
          $diff        = $fisik - $stock;
          $diff_value  = $diff * $harga;
          $this->db->set('fisik', $fisik);
          $this->db->set('diff', $diff);
          $this->db->set('diff_value', $diff_value);
          $this->db->where('kode_barang', $kode_barang);
          $result=$this->db->update('temp_stock_opname');
          return $result;
      }

      //hapus isi table temp_stock_opname
      public function clear_temp_stock_opname(){
        $this->db->where(array('user_id' => $this->session->userdata('id_karyawan')));  
        $this->db->delete("temp_stock_opname");
      }

      //hapus rgister barang
      public function delete_register(){   
        $kode_barang  = $this->input->post('kode_barang');
        $this->db->where(array('kode_barang' => $kode_barang,'user_id' => $this->session->userdata('id_karyawan')));  
        $this->db->delete("temp_stock_opname");  
      }

      /*get data temp_stock_opname*/
      public function get_temp_stock_opname() { 
        $query = $this->db->query("
        SELECT
        temp_stock_opname.kode_barang,
        master_barang.harga_beli,
        master_barang.sales_stock,
        temp_stock_opname.fisik,
        temp_stock_opname.diff,
        temp_stock_opname.diff_value,
        temp_stock_opname.tanggal
        FROM temp_stock_opname 
        LEFT JOIN master_barang
        on temp_stock_opname.kode_barang = master_barang.kode_barang
        WHERE user_id ='".$this->session->userdata('id_karyawan')."' ");
        return $query;
      }

      //update stock pada table master barang
      public function update_stock(){
      $get_data     = $this->db->query("SELECT * FROM temp_stock_opname where user_id='".$this->session->userdata('id_karyawan')."'");
      $result =  $get_data->result();
      foreach ($result as $data) {
        $kode_barang = $data->kode_barang;
        $fisik       = $data->fisik;
        $this->db->set('book_stock',$fisik, FALSE);
        $this->db->set('sales_stock',$fisik, FALSE);
        $this->db->where(array('kode_barang' => $kode_barang));
        $result=$this->db->update('master_barang');
      }
     } 

      //insert ke table tbl_det_stock_opname
      public  function ins_det_stock_opname($data)  
      { 
        $this->db->insert('tbl_det_stock_opname',$data);
      }

      //reset print
      public function reset_stock_opname(){
        $this->db->where(array('user_id' => $this->session->userdata('id_karyawan')));  
        $this->db->delete("temp_stock_opname");
      }     




 }  