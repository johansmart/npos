<?php  
 class Model_master_pelanggan extends CI_Model  
 {  
      /*variable datatables*/
      var $table = "master_pelanggan";  
      var $select_column = array("kode_pelanggan","nama_pelanggan","alamat","no_telepon","email","user_reg", "tanggal");
      var $order_column = array("kode_pelanggan","nama_pelanggan","alamat","no_telepon","email","user_reg", "tanggal",null);
      /*function get data from database*/  
      public function make_query()  
      {  
        $this->db->select($this->select_column);  
        $this->db->from($this->table);; 
        if(isset($_POST["search"]["value"]))  
        {  
            $this->db->like("kode_pelanggan", $_POST["search"]["value"]);  
            $this->db->or_like("nama_pelanggan", $_POST["search"]["value"]);
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

      //get kode_pelanggan   
      public  function get_kode_pelanggan()  
      { 
        return $get_data   = $this->db->query("SELECT max(seq) as max_kode FROM master_pelanggan ");
      }

      //insert pelanggan
      public  function insert_pelanggan($data)  
      { 
        $this->db->insert('master_pelanggan',$data);
      }

      //hapus pelanggan
      public function delete_pelanggan()
      {   
        $kode_pelanggan  = $this->input->post('kode_pelanggan');
        $this->db->where(array('kode_pelanggan' => $kode_pelanggan));  
        $this->db->delete("master_pelanggan");  
      }

      /*update pelanggan*/  
      public function update_pelanggan()  
      {  
          $id             = $this->input->post('id');
          $nama_pelanggan = trim(strtoupper($this->input->post("nama_pelanggan")));
          $alamat         = trim(strtoupper($this->input->post("alamat")));
          $no_telepon     = $this->input->post("no_telepon");
          $email          = $this->input->post("email");

          $this->db->set('nama_pelanggan', $nama_pelanggan);
          $this->db->set('alamat', $alamat);
          $this->db->set('no_telepon', $no_telepon);
          $this->db->set('email', $email);

          $this->db->set('user_reg', $this->session->userdata('id_karyawan'));
          $this->db->set('tanggal', date('Y-m-d'));
          $this->db->where('kode_pelanggan', $id);
          $result=$this->db->update('master_pelanggan');
          return $result;
      }
      
 }  