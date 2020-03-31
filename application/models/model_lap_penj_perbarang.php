<?php  
 class Model_lap_penj_perbarang extends CI_Model  
 {  
 	 /*variable datatables*/
      var $table = "tbl_det_penjualan";  
      var $select_column = array(
        "tbl_det_penjualan.kode_barang",
        "master_barang.nama_barang",
        "master_barang.harga_beli",
        "coalesce(sum(tbl_det_penjualan.qty),0) as qty",
        "coalesce(sum(tbl_det_penjualan.total),0) as total",
        "coalesce(sum(tbl_det_penjualan.qty)*(master_barang.harga_beli),0) as nilai_hrg_beli",
        "coalesce(sum(tbl_det_penjualan.total)-(master_barang.harga_beli * sum(tbl_det_penjualan.qty)),0) as profit"
      );  
      var $order_column  = array(null,"kode_barang","nama_barang","qty","total","profit");
      /*function get data from database*/  
      function make_query()  
      {  
      	$this->db->select($this->select_column);  
      	$this->db->from($this->table);
        //$this->db->join('tbl_penjualan', 'tbl_det_penjualan.no_faktur = tbl_penjualan.no_faktur', 'left');
        $this->db->join('master_barang', 'tbl_det_penjualan.kode_barang = master_barang.kode_barang', 'left');
	      $this->db->where('tbl_det_penjualan.tanggal BETWEEN "'.$_POST["start_date"]. '" AND "'.$_POST["end_date"].'"');
        $this->db->group_by("tbl_det_penjualan.kode_barang");

        if(isset($_POST['search']['value']))  
        {  
        	  $this->db->group_start(); 	
            $this->db->like("tbl_det_penjualan.no_faktur", $_POST['search']['value']);
            $this->db->or_like("tbl_det_penjualan.kode_barang", $_POST['search']['value']);
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