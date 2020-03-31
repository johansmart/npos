<?php  
 class Model_satuan extends CI_Model  
 {  
      /*variable datatables*/
      var $table = "satuan";  
      var $select_column = array("kode_satuan","satuan","user_reg", "tanggal");
      var $order_column = array("kode_satuan","satuan","user_reg", "tanggal",null);
      /*function get data from database*/  
      public function make_query()  
      {  
        $this->db->select($this->select_column);  
        $this->db->from($this->table);; 
        if(isset($_POST["search"]["value"]))  
        {  
            $this->db->like("kode_satuan", $_POST["search"]["value"]);  
            $this->db->or_like("satuan", $_POST["search"]["value"]);
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

      //cek satuan yang sudah ada
      public function cek_satuan()  
      {
        $nama_satuan = $this->input->post("nama_satuan");
        return $get_data   = $this->db->query("SELECT satuan as nama_satuan FROM satuan where satuan='$nama_satuan'");
      }

      //cek supplier edit
      public function cek_satuan_edit()  
      {
        $id            = $this->input->post("id");
        $nama_satuan = $this->input->post("nama_satuan");
        return $get_data   = $this->db->query("SELECT satuan as nama_satuan FROM satuan where satuan='$nama_satuan' AND kode_satuan!='$id'");
      }

      //auto generate no_supplier  
      public function kode_satuan(){
        $query = $this->db->query(" SELECT max(kode_satuan)as kode_satuan FROM satuan limit 1 ");
        return $query;
      }

      //insert supplier
      public  function insert_satuan($data)  
      { 
        $this->db->insert('satuan',$data);
      }

      //hapus satuan
      public function delete_satuan()
      {   
        $kode_satuan  = $this->input->post('kode_satuan');
        $this->db->where(array('kode_satuan' => $kode_satuan));  
        $this->db->delete("satuan");  
      }

      /*update supplier*/  
      function update_satuan()  
      {  
          $id           = $this->input->post('id');
          $nama_satuan  = trim(strtoupper($this->input->post("nama_satuan")));
          $this->db->set('satuan', $nama_satuan);
          $this->db->set('user_reg', $this->session->userdata('id_karyawan'));
          $this->db->set('tanggal', date('Y-m-d'));
          $this->db->where('kode_satuan', $id);
          $result=$this->db->update('satuan');
          return $result;
      }

      
      
      
 }  