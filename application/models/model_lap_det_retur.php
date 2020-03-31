<?php  
 class Model_lap_det_retur extends CI_Model  
 {  
 	 /*variable datatables*/
      var $table = "tbl_det_retur";  
      var $select_column = array(
        "tbl_retur.id_karyawan",
        "tbl_det_retur.no_nota",
        "tbl_det_retur.no_retur",
        "tbl_retur.tanggal",
        "tbl_retur.jam",
        "tbl_det_retur.kode_barang",
        "master_barang.nama_barang",
        "tbl_det_retur.harga_beli",
        "tbl_det_retur.jml_retur",
        "tbl_det_retur.nilai_retur",
        "tbl_det_retur.alasan"
      );  
      var $order_column  = array(null,"id_kasir","no_nota","no_retur","tanggal","jam","kode_barang","nama_barang","harga_beli","jml_retur","nilai_retur","alasan");
      /*function get data from database*/  
      function make_query()  
      {  
      	$this->db->select($this->select_column);  
      	$this->db->from($this->table);
        $this->db->join('tbl_retur', 'tbl_det_retur.no_retur = tbl_retur.no_retur', 'left');
        $this->db->join('master_barang', 'tbl_det_retur.kode_barang = master_barang.kode_barang', 'left');
	      $this->db->where('tbl_retur.tanggal BETWEEN "'.$_POST["start_date"]. '" AND "'.$_POST["end_date"].'"');
        //$this->db->group_by("tbl_det_retur.no_nota");

        if(isset($_POST['search']['value']))  
        {  
        	  $this->db->group_start(); 	
            $this->db->like("tbl_det_retur.no_nota", $_POST['search']['value']);
            $this->db->or_like("tbl_det_retur.kode_barang", $_POST['search']['value']);
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