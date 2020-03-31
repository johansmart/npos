<?php  
 class Model_lap_stock_opname extends CI_Model  
 {  
 	 /*variable datatables*/
      var $table = "tbl_det_stock_opname";  
      var $select_column = array(
        "tbl_det_stock_opname.transf_date",
        "tbl_det_stock_opname.transf_time",
        "tbl_det_stock_opname.kode_barang",
        "master_barang.nama_barang",
        "tbl_det_stock_opname.stock",
        "tbl_det_stock_opname.fisik",
        "tbl_det_stock_opname.diff",
        "tbl_det_stock_opname.diff_value",
        "tbl_det_stock_opname.user_id"
      );  
      var $order_column  = array(null,"transf_date", "transf_time", "kode_barang", "nama_barang","stock","fisik","diff","diff_value","user_id");
      /*function get data from database*/  
      function make_query()  
      {  
      	$this->db->select($this->select_column);  
      	$this->db->from($this->table);
        $this->db->join('master_barang', 'tbl_det_stock_opname.kode_barang = master_barang.kode_barang', 'left');
	      $this->db->where('tbl_det_stock_opname.transf_date BETWEEN "'.$_POST["start_date"]. '" AND "'.$_POST["end_date"].'"');
        //$this->db->group_by("tbl_det_pembelian.no_nota");

        if(isset($_POST['search']['value']))  
        {  
        	  $this->db->group_start(); 	
            $this->db->like("tbl_det_stock_opname.kode_barang", $_POST['search']['value']);
            $this->db->or_like("tbl_det_stock_opname.transf_date", $_POST['search']['value']);
            $this->db->or_like("tbl_det_stock_opname.user_id", $_POST['search']['value']);
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