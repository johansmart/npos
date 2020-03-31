<?php  
 class Model_promo extends CI_Model  
 {  
      /*variable datatables*/
      var $table = "Promo";  
      var $order_column = array("id","barcode","nama_barang", "harga_brg","persen","nilai_diskon","tgl_mulai","tgl_selesai","harga_diskon","userid","status",null);
      /*function get data from database*/  
      public function make_query()  
      {  
        $this->db->select('*');  
        $this->db->from($this->table);; 
        if(isset($_POST["search"]["value"]))  
        {  
            $this->db->like("barcode", $_POST["search"]["value"]);  
            $this->db->or_like("nama_barang", $_POST["search"]["value"]);
            $this->db->or_like("userid", $_POST["search"]["value"]);
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
        $this->db->select('*');  
        $this->db->from('master_barang');
        $this->db->join('satuan', 'master_barang.kode_satuan = satuan.kode_satuan', 'left');
        $this->db->where('kode_barang', $kode_barang);
        $query = $this->db->get();  
        return $query;
      }

      //insert diskon
      public  function insert_promo($data)  
      { 
        $this->db->insert('promo',$data);
        //update harga master barang
        $kode_barang  = $this->input->post('kode_barang');
        $harga_promo  = $this->input->post('harga_promo');
        $this->db->set('harga_brg', $harga_promo);
        $this->db->where('kode_barang', $kode_barang);
        $result=$this->db->update('master_barang');
      }

      /*update status on*/  
      public function update_status_on()  
      {  
          $id         = $this->input->post('id');
          $on_status  = $this->input->post('on_status');
          $this->db->set('status', $on_status);
          $this->db->where('id', $id);
          $result=$this->db->update('diskon');
          return $result;
      }

      
 }  