<?php  
 class Model_master_supplier extends CI_Model  
 {  
      /*variable datatables*/
      var $table = "supplier";  
      var $select_column = array
       ("id","kode_supp","nama_supp", "nama_kontak","tlp_supp","alamat_supp");
      var $order_column = array("id","kode_supp","nama_supp", "nama_kontak","tlp_supp","alamat_supp",null);
      /*function get data from database*/  
      public function make_query()  
      {  
        $this->db->select($this->select_column);  
        $this->db->from($this->table);; 
        if(isset($_POST["search"]["value"]))  
        {  
            $this->db->like("kode_supp", $_POST["search"]["value"]);  
            $this->db->or_like("nama_supp", $_POST["search"]["value"]);
            $this->db->or_like("nama_kontak", $_POST["search"]["value"]);
            $this->db->or_like("tlp_supp", $_POST["search"]["value"]); 
            $this->db->or_like("alamat_supp", $_POST["search"]["value"]); 
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

      //cek supplier yang sudah ada
      public function cek_supplier()  
      {
        $nama_supplier = $this->input->post("nama_supplier");
        return $get_data   = $this->db->query("SELECT nama_supp as nama_supplier FROM supplier where nama_supp='$nama_supplier'");
      }

      //cek supplier edit
      public function cek_supplier_edit()  
      {
        $id            = $this->input->post("id");
        $nama_supplier = $this->input->post("nama_supplier");
        return $get_data   = $this->db->query("SELECT nama_supp as nama_supplier FROM supplier where nama_supp='$nama_supplier' AND id!='$id'");
      }

      //auto generate no_supplier  
      public function no_supplier(){
        $query = $this->db->query(" SELECT max(kode_supp)as kode_supp FROM Supplier limit 1 ");
        return $query;
      }

      //insert supplier
      public  function insert_supplier($data)  
      { 
        $this->db->insert('supplier',$data);
      }

      //hapus suplier
      public function delete_supplier()
      {   
        $kode_supp  = $this->input->post('kode_supp');
        $this->db->where(array('kode_supp' => $kode_supp));  
        $this->db->delete("supplier");  
      }

      /*update supplier*/  
      public function update_supplier()  
      {  
          $id             = $this->input->post('id');
          $nama_supplier  = trim(strtoupper($this->input->post("nama_supplier")));
          $nama_kontak    = trim(strtoupper($this->input->post("nama_kontak")));
          $telp_supp      = $this->input->post('telp_supp');
          $alamat_supp    = trim(strtoupper($this->input->post("alamat_supp")));
          $this->db->set('nama_supp', $nama_supplier);
          $this->db->set('nama_kontak', $nama_kontak);
          $this->db->set('tlp_supp', $telp_supp);
          $this->db->set('alamat_supp', $alamat_supp);
          $this->db->set('reg_id', $this->session->userdata('id_karyawan'));
          $this->db->set('tanggal', date('Y-m-d'));
          $this->db->where('id', $id);
          $result=$this->db->update('supplier');
          return $result;
      }

      
      
      
 }  