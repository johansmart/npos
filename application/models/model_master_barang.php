<?php  
 class Model_master_barang extends CI_Model  
 {  
      /*variable datatables*/
      var $table = "master_barang";  
      var $select_column = array(
       "master_barang.id",
       "master_barang.kode_barang", 
       "master_barang.nama_barang",
       "satuan.satuan",
       "master_barang.kode_kategori",
       "kategori.nama_kategori",
       "master_barang.harga_beli",
       "master_barang.harga_brg",
       "master_barang.harga_grosir",
       "master_barang.kode_supp",
       "supplier.nama_supp",
       "master_barang.sales_stock"
      );
      var $order_column = array(
        "id",
        "kode_barang",
        "nama_barang",
        "satuan",
        "kode_kategori",
        "nama_kategori",
        "harga_beli",
        "harga_brg",
        "harga_grosir",
        "kode_supp",
        "nama_supp",
        "sales_stock",
        null
      );
      /*function get data from database*/  
      public function make_query()  
      {  
        $this->db->select($this->select_column);  
        $this->db->from($this->table);
        $this->db->join('supplier', 'master_barang.kode_supp = supplier.kode_supp', 'left');
        $this->db->join('kategori', 'master_barang.kode_kategori = kategori.kode_kategori', 'left');
        $this->db->join('satuan', 'master_barang.kode_satuan = satuan.kode_satuan', 'left');  
        if(isset($_POST["search"]["value"]))  
        {  
            $this->db->like("master_barang.kode_barang", $_POST["search"]["value"]);  
            $this->db->or_like("master_barang.nama_barang", $_POST["search"]["value"]);
            $this->db->or_like("kategori.nama_kategori", $_POST["search"]["value"]);
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

      //select 2 satuan
      public function select_satuan(){
        $query = $this->db->query("SELECT kode_satuan as id, satuan as text FROM satuan where satuan LIKE '%".$this->input->post("q")."%' ");
        return $query->result_array();
      }

      //select 2 kategori
      public function select_kategori(){
        $query = $this->db->query("SELECT kode_kategori as id, nama_kategori as text FROM kategori where nama_kategori LIKE '%".$this->input->post("q")."%' ");
        return $query->result_array();
      }

      //select 2 kategori
      public function select_supplier(){
        $query = $this->db->query("SELECT kode_supp as id, nama_supp as text FROM supplier where nama_supp LIKE '%".$this->input->post("q")."%' order by nama_supp asc  ");
        return $query->result_array();
      }

      //get get_kode_kategori
      public function get_kode_kategori()  
      {
        $kategori = $this->input->post("kategori");
        return $get_data   = $this->db->query("SELECT kode_kategori as kode_kategori FROM kategori where nama_kategori='$kategori' ");
      }

      //get get_kode_satuan
      public function get_kode_satuan()  
      {
        $satuan = $this->input->post("satuan");
        return $get_data   = $this->db->query("SELECT kode_satuan as kode_satuan FROM satuan where satuan='$satuan'");
      }

      //get get_kode_supp
      public function get_kode_supp()  
      {
        $supplier = $this->input->post("supplier");
        return $get_data   = $this->db->query("SELECT kode_supp as kode_supp FROM supplier where nama_supp='$supplier'");
      }

      //cek barang yang sudah ada
      public function cek_barang()  
      {
        $kode_barang = $this->input->post("kode_barang");
        return $get_data   = $this->db->query("SELECT kode_barang as kode_barang FROM master_barang where kode_barang='$kode_barang'");
      }

      //cek barang yang akan diedit
      public function cek_barang_edit()  
      {
        $id          = $this->input->post("id");
        $kode_barang = $this->input->post("kode_barang");
        return $get_data   = $this->db->query("SELECT kode_barang as kode_barang FROM master_barang where kode_barang='$kode_barang'AND id!='$id'");
      }

      //insert barang
      public  function insert_barang($data)  
      { 
        $this->db->insert('master_barang',$data);
      }

      //hapus barang
      public function delete_product()
      {   
        $kode_barang  = $this->input->post('kode_barang');
        $this->db->where(array('kode_barang' => $kode_barang));  
        $this->db->delete("master_barang");  
      }

      /*update barang*/  
      public function update_product($kategori,$satuan,$supplier)  
      {  
          $id           = $this->input->post('id');
          $kode_barang  = $this->input->post('kode_barang');
          $nama_barang  = trim(strtoupper($this->input->post("nama_barang")));
          $satuan       = $satuan;
          $kategori     = $kategori;
          $supplier     = $supplier;
          $harga_beli   = $this->input->post('harga_beli');
          $harga_jual   = $this->input->post('harga_jual');
          $harga_grosir = $this->input->post('harga_grosir');

          $this->db->set('kode_barang', $kode_barang);
          $this->db->set('nama_barang', $nama_barang);
          $this->db->set('kode_kategori', $kategori);
          $this->db->set('kode_satuan', $satuan);
          $this->db->set('harga_brg', $harga_jual);
          $this->db->set('harga_beli', $harga_beli);
          $this->db->set('kode_supp', $supplier);
          $this->db->set('tgl_reg', date('Y-m-d'));
          $this->db->set('user_reg', $this->session->userdata('id_karyawan'));
          $this->db->set('harga_grosir', $harga_grosir);
          $this->db->where('id', $id);
          $result=$this->db->update('master_barang');
          return $result;
      }

       //auto generate barcode  
      public function auto_barcode(){
        $query = $this->db->query(" SELECT max(kode_barang)as auto_kode FROM master_barang WHERE LEFT(kode_barang, 4) ='0400' limit 1 ");
        return $query;
      }
      
      
 }  