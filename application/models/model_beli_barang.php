<?php  
 class Model_beli_barang extends CI_Model  
 {  
  /*variable datatables*/
  var $table = "temp_beli_barang";  
  var $select_column = array("temp_beli_barang.kode_barang", "temp_beli_barang.nama_barang","satuan","master_barang.kode_supp","temp_beli_barang.nama_kategori","temp_beli_barang.harga_beli","jumlah","total_harga");  
  var $order_column = array("temp_beli_barang.kode_barang", "temp_beli_barang.nama_barang", "satuan","kode_supp","nama_kategori","kode_supp","temp_beli_barang.harga_beli","jumlah","total_harga","id_karyawan");
  /*function get data from database*/  
  public function make_query()  
  {  
    $this->db->select($this->select_column);  
    $this->db->from($this->table);
    $this->db->join('master_barang', 'temp_beli_barang.kode_barang = master_barang.kode_barang','left');
    $this->db->join('kategori', 'master_barang.kode_kategori = kategori.kode_kategori','left');
    $this->db->where(array('id_karyawan' => $this->session->userdata('id_karyawan'))); 
    $this->db->where('temp_beli_barang.kode_barang >',0); 
    $this->db->where('temp_beli_barang.nama_kategori !=',''); 
    if(isset($_POST["order"]))  
    {  
        $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
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

  public function get_all_data(){  
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
    $this->db->join('kategori', 'master_barang.kode_kategori = kategori.kode_kategori','left');
    $this->db->where('kode_barang', $kode_barang);
    $query = $this->db->get();  
    return $query;
  }

  /*cek no nota yang sudah ada*/
  public function check_no_nota()  
  {
    $no_nota   = trim($this->input->post('no_nota'));
    $query = $this->db->query("SELECT no_nota FROM tbl_pembelian WHERE no_nota='$no_nota'");
    return $query;
  }

  //insert ke table temp_beli_barang
  public function insert_tmp_beli_barang($data){
    $kode_barang  = $this->input->post('kode_barang');
    $hsl = $this->db->query("SELECT * FROM temp_beli_barang WHERE kode_barang='$kode_barang' and id_karyawan='".$this->session->userdata('id_karyawan')."'");
    if ($hsl->num_rows()>0) {
      return 1;
      return false;
    }
    else {
      $this->db->insert('temp_beli_barang',$data);
    }   
      
  }

  //get no nota
  public function get_no_nota()  
  {
    return $get_data   = $this->db->query("SELECT no_nota as no_nota FROM temp_beli_barang where id_karyawan='".$this->session->userdata('id_karyawan')."' limit 1");
  }

  //get kode_supplier
  public function get_kode_supp()  
  {
    $select_supplier = $this->input->post("select_supplier");
    return $get_data   = $this->db->query("SELECT kode_supp as kode_supp FROM supplier where nama_supp='$select_supplier' limit 1");
  }

   //get no nota
  public function cek_kode_barang()  
  {
    $kode_barang = $this->input->post("kode_barang");
    return $get_data   = $this->db->query("SELECT kode_barang as kode_barang FROM master_barang where kode_barang='$kode_barang' limit 1");
  }
  
  //hapus barang
  public function delete_product(){   
    $kode_barang  = $this->input->post('kode_barang');
    $this->db->where(array('kode_barang' => $kode_barang,'id_karyawan' => $this->session->userdata('id_karyawan')));  
    $this->db->delete("temp_beli_barang");  
  }

  //sum total harga beli untuk footer datatable
  public function sum_total_beli()  
  {
    return $get_data   = $this->db->query("SELECT sum(total_harga) as total_harga FROM temp_beli_barang where id_karyawan='".$this->session->userdata('id_karyawan')."'");
  }

  //hapus isi table temp_beli_barang
  public function clear_temp_beli_barang(){
    $this->db->where(array('id_karyawan' => $this->session->userdata('id_karyawan')));  
    $this->db->delete("temp_beli_barang");
  }


  /*ambil data dari temp_beli_barang untuk dimasukkan ke tbl_pembelian*/    
    public function get_pembelian()  
    {
      return $get_data   = $this->db->query("SELECT sum(total_harga)as total,tanggal as tanggal,left_date as left_date,jam as jam,left_time as left_time FROM `temp_beli_barang` where id_karyawan ='".$this->session->userdata('id_karyawan')."'");
    }

    /*ambil data dari temp_beli_barang untuk dimasukkan ke tbl_det_pembelian*/   
    public function get_det_pembelian()  
    {
      return $get_data   = $this->db->query("SELECT * FROM temp_beli_barang where  id_karyawan='".$this->session->userdata('id_karyawan')."' AND kode_barang !='' ");
    }

    //get slip_no 
    public  function get_no_slip(){ 
      //no bill table penjualan  
       return $get_data   = $this->db->query("SELECT no_nota as seq FROM `tbl_pembelian` where tanggal='".date('Y-m-d')."' order by id desc limit 1 ");
    }

    //insert ke tbl_pembelian
    public  function ins_pembelian($data_pembelian)  
    { 
      $this->db->insert('tbl_pembelian',$data_pembelian);
    }

    //insert ke tbl_hutang
    public  function ins_hutang($data_hutang)  
    { 
      $this->db->insert('tbl_hutang',$data_hutang);
    }

    //insert ke tbl_det_pembelian
    public  function ins_det_pembelian($data_det_pembelian)  
    { 
      $this->db->insert('tbl_det_pembelian',$data_det_pembelian);
    }

    //insert ke tbl_kas_flow
    public  function ins_kas_flow($data_kas_flow){ 
      $this->db->insert('tbl_kas_flow',$data_kas_flow);
    }

    //update stock
    public function update_stock(){
      $get_data     = $this->db->query("SELECT * FROM temp_beli_barang where id_karyawan='".$this->session->userdata('id_karyawan')."'");
      $result =  $get_data->result();
      foreach ($result as $data) {
        $kode_barang = $data->kode_barang;
        $jumlah      = $data->jumlah;
        $this->db->set('book_stock','book_stock'.'+'. $jumlah, FALSE);
        $this->db->set('sales_stock','sales_stock'.'+'. $jumlah, FALSE);
        $this->db->set('masuk','masuk'.'+'. $jumlah, FALSE);
        $this->db->where(array('kode_barang' => $kode_barang));
        $result=$this->db->update('master_barang');
      }
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
       "master_barang.harga_grosir",
       "master_barang.sales_stock"
      );
      var $order_column2 = array(
        "id",
        "kode_barang",
        "nama_barang",
        "satuan",
        "nama_kategori",
        "sales_stock",
        "harga_beli",
        "harga_grosir"
        
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




}  