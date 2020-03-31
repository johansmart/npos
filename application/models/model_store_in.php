<?php  
 class Model_store_in extends CI_Model  
 {  
      /*variable datatables*/
      var $table = "store_in";  
      var $select_column = array(
       "store_in.tanggal",
       "store_in.jam",
       "store_in.kode_barang", 
       "master_barang.nama_barang",
       "satuan.satuan",
       "kategori.nama_kategori",
       "store_in.stock_awal",
       "store_in.qty",
       "store_in.stock_akhir"
      );
      var $order_column = array(
        null,
        "tanggal",
        "jam",
        "kode_barang", 
        "nama_barang",
        "satuan",
        "nama_kategori",
        "stock_awal",
        "qty", 
        "stock_akhir"
      );
      /*function get data from database*/  
      public function make_query()  
      {  
        $this->db->select($this->select_column);  
        $this->db->from($this->table);
        $this->db->join('master_barang', 'store_in.kode_barang = master_barang.kode_barang', 'left');
        $this->db->join('kategori', 'master_barang.kode_kategori = kategori.kode_kategori', 'left');
        $this->db->join('satuan', 'master_barang.kode_satuan = satuan.kode_satuan', 'left');  
        if(isset($_POST["search"]["value"]))  
        {  
            $this->db->like("store_in.kode_barang", $_POST["search"]["value"]);  
            $this->db->or_like("master_barang.nama_barang", $_POST["search"]["value"]);
            $this->db->or_like("kategori.nama_kategori", $_POST["search"]["value"]);
            $this->db->or_like("store_in.tanggal", $_POST["search"]["value"]);  
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

      /*get item info*/
      public function get_item_info()  
      {
        $kode_barang   = trim($this->input->post('kode_barang'));
        //$colum = array("master_barang.nama_barang", "satuan.satuan","master_barang.kode_supp","master_barang.harga_beli");
        $this->db->select('*');  
        $this->db->from('master_barang');
        $this->db->join('satuan', 'master_barang.kode_satuan = satuan.kode_satuan', 'left');
        $this->db->where('kode_barang', $kode_barang);
        $query = $this->db->get();  
        return $query;
      }

      /*cek barang sebelum insert ke table store in*/
      public function cek_barang($kode_barang)  
      {
        $this->db->select('kode_barang');  
        $this->db->from('master_barang');
        $this->db->where('kode_barang', $kode_barang);
        $query = $this->db->get();  
        return $query;
      }

      //insert barang
      public  function insert_barang($data)  
      { 
        $this->db->insert('store_in',$data);
      }

      //update stock
    public function update_stock($kode_barang, $jumlah){
        $this->db->set('book_stock','book_stock'.'+'. $jumlah, FALSE);
        $this->db->set('sales_stock','sales_stock'.'+'. $jumlah, FALSE);
        $this->db->set('str_in','str_in'.'+'. $jumlah, FALSE);
        $this->db->where(array('kode_barang' => $kode_barang));
        $result=$this->db->update('master_barang');
    }
   
 }  