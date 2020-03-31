<?php  
 class Model_lap_det_pembelian extends CI_Model  
 {  
 	 /*variable datatables*/
      var $table = "tbl_det_pembelian";  
      var $select_column = array(
        "tbl_pembelian.tanggal",
        "tbl_det_pembelian.no_nota",
        "tbl_det_pembelian.kode_barang",
        "master_barang.nama_barang",
        "tbl_pembelian.kode_supp",
        "supplier.nama_supp",
        "tbl_det_pembelian.harga_beli",
        "tbl_det_pembelian.jumlah",
        "tbl_det_pembelian.total_harga_beli",
      );  
      var $order_column  = array(null,"tanggal", "no_nota", "kode_barang", "nama_barang","kode_supp","nama_supp","harga_beli","jumlah","total_harga_beli");
      /*function get data from database*/  
      function make_query()  
      {  
      	$this->db->select($this->select_column);  
      	$this->db->from($this->table);
        $this->db->join('tbl_pembelian', 'tbl_det_pembelian.no_nota = tbl_pembelian.purc_no', 'left');
        $this->db->join('master_barang', 'tbl_det_pembelian.kode_barang = master_barang.kode_barang', 'left');
        $this->db->join('supplier', 'tbl_det_pembelian.kode_supp = supplier.kode_supp', 'left');
	      $this->db->where('tbl_pembelian.tanggal BETWEEN "'.$_POST["start_date"]. '" AND "'.$_POST["end_date"].'"');
        //$this->db->group_by("tbl_det_pembelian.no_nota");

        if(isset($_POST['search']['value']))  
        {  
        	  $this->db->group_start(); 	
            $this->db->like("tbl_det_pembelian.no_nota", $_POST['search']['value']);
            $this->db->or_like("tbl_pembelian.kode_supp", $_POST['search']['value']);
            $this->db->or_like("supplier.nama_supp", $_POST['search']['value']);
            $this->db->or_like("tbl_det_pembelian.kode_barang", $_POST['search']['value']);
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

 }  