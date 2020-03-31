<?php  
 class Model_kategori extends CI_Model  
 {  
      /*variable datatables*/
      var $table = "kategori";  
      var $select_column = array("kode_kategori","nama_kategori","user_reg", "tanggal");
      var $order_column = array("kode_kategori","nama_kategori","user_reg", "tanggal",null);
      /*function get data from database*/  
      public function make_query()  
      {  
        $this->db->select($this->select_column);  
        $this->db->from($this->table);; 
        if(isset($_POST["search"]["value"]))  
        {  
            $this->db->like("kode_kategori", $_POST["search"]["value"]);  
            $this->db->or_like("nama_kategori", $_POST["search"]["value"]);
            $this->db->or_like("user_reg", $_POST["search"]["value"]); 
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

      //cek kategori yang sudah ada
      public function cek_kategori()  
      {
        $nama_kategori = $this->input->post("nama_kategori");
        return $get_data   = $this->db->query("SELECT nama_kategori as nama_kategori FROM Kategori where nama_kategori='$nama_kategori'");
      }

      //cek supplier edit
      public function cek_kategori_edit()  
      {
        $id            = $this->input->post("id");
        $nama_kategori = $this->input->post("nama_kategori");
        return $get_data   = $this->db->query("SELECT nama_kategori as nama_kategori FROM Kategori where nama_kategori='$nama_kategori' AND kode_kategori!='$id'");
      }

      //auto generate no_supplier  
      public function kode_kategori(){
        $query = $this->db->query(" SELECT max(kode_kategori)as kode_kategori FROM kategori limit 1 ");
        return $query;
      }

      //insert supplier
      public  function insert_kategori($data)  
      { 
        $this->db->insert('kategori',$data);
      }

      //hapus kategori
      public function delete_kategori()
      {   
        $kode_kategori  = $this->input->post('kode_kategori');
        $this->db->where(array('kode_kategori' => $kode_kategori));  
        $this->db->delete("kategori");  
      }

      /*update supplier*/  
      function update_kategori()  
      {  
          $id             = $this->input->post('id');
          $nama_kategori  = trim(strtoupper($this->input->post("nama_kategori")));
          $this->db->set('nama_kategori', $nama_kategori);
          $this->db->set('user_reg', $this->session->userdata('id_karyawan'));
          $this->db->set('tanggal', date('Y-m-d'));
          $this->db->where('kode_kategori', $id);
          $result=$this->db->update('kategori');
          return $result;
      }

      
      
      
 }  