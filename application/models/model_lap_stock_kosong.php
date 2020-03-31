<?php  
 class model_lap_stock_kosong extends CI_Model  
 {  
   /*variable datatables*/
      var $table = "master_barang";  
      var $select_column = array(
        "master_barang.kode_barang",
        "master_barang.nama_barang",
        "satuan.satuan",
        "kategori.nama_kategori",
        "master_barang.harga_brg",
        "master_barang.terjual",
        "master_barang.sales_stock",
      );  
      var $order_column  = array(null,"kode_barang", "nama_barang","satuan","nama_kategori","harga_brg","terjual","sales_stock");
      /*function get data from database*/  
      public function make_query()  
      {

        $this->db->select($this->select_column);  
        $this->db->from($this->table);
        $this->db->join('satuan', 'master_barang.kode_satuan = satuan.kode_satuan', 'left');
        $this->db->join('kategori', 'master_barang.kode_kategori = kategori.kode_kategori', 'left');
        $this->db->where('sales_stock =0');
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