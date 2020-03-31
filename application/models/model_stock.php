<?php  
 class Model_stock extends CI_Model  
 {  
 	 /*variable datatables*/
      var $table = "master_barang";
      var $select_column = array(
        "master_barang.kode_barang",
        "master_barang.nama_barang",
        "master_barang.harga_brg as harga_brg",
        "satuan.satuan",
        "master_barang.masuk",
        "master_barang.terjual",
        "master_barang.retur",
        "master_barang.adjust",
        "master_barang.str_in",
        "master_barang.sales_stock as sales_stock",
        "coalesce(sales_stock*harga_brg) as nilai_stock",
      );  
      var $order_column  = array(
        null,
        "kode_barang",
        "nama_barang",
        "harga_brg",
        "satuan",
        "masuk",
        "terjual",
        "retur",
        "adjust",
        "str_in",
        "sales_stock",
        "nilai_stock"
      );
      /*function get data from database*/  
      function make_query()  
      {  
      	$this->db->select($this->select_column);  
      	$this->db->from($this->table);
        $this->db->join('kategori', 'master_barang.kode_kategori = kategori.kode_kategori', 'left');
        $this->db->join('satuan', 'master_barang.kode_satuan = satuan.kode_satuan', 'left');
        $this->db->join('supplier', 'master_barang.kode_supp = supplier.kode_supp', 'left');
	      /*$this->db->where('master_barang.tanggal BETWEEN "'.$_POST["start_date"]. '" AND "'.$_POST["end_date"].'"');*/
        //$this->db->group_by("tbl_det_pembelian.no_nota");

        if(isset($_POST['search']['value']))  
        {  
        	  $this->db->group_start(); 	
            $this->db->like("master_barang.kode_barang", $_POST['search']['value']);
            $this->db->or_like("master_barang.nama_barang", $_POST['search']['value']);
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

      /*update barang*/  
      public function update_stock()  
      {  
          $kode_barang  = $this->input->post('kode_barang');
          $update_stock = $this->input->post('update_stock');
          $this->db->set('sales_stock', $update_stock);
          $this->db->where('kode_barang', $kode_barang);
          $result=$this->db->update('master_barang');
          return $result;
      }

     



 }  