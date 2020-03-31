<?php  
 class Model_closing extends CI_Model  
 {  
      /*variable datatables*/
      var $table = "tbl_closing";  
      var $select_column = array("tanggal","jam","id_kasir","user_name","no_pos","end_of_shift_1","end_of_shift_2","total_kas","pengeluaran","kas_akhir");  
      var $order_column = array("tanggal","jam","id_kasir","user_name","no_pos","end_of_shift_1","end_of_shift_2","total_kas","pengeluaran","kas_akhir");
      /*function get data from database*/  
      public function make_query()  
      {  
        $this->db->select($this->select_column); 
        $this->db->from($this->table);
        $this->db->join('users', 'tbl_closing.id_kasir = users.user_id', 'left');
        if(isset($_POST["search"]["value"]))  
        {  
            $this->db->like("id_kasir", $_POST["search"]["value"]);  
            $this->db->or_like("tanggal", $_POST["search"]["value"]);
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


      //cek end of shift
      public function cek_end_shift()  
      { 
        $query = $this->db->query("SELECT coalesce(sum(end_shift),0) as end_shift FROM tbl_float WHERE tanggal='".date('Y-m-d')."' AND id_kasir='".$this->session->userdata('id_karyawan')."' ");
        return $query;
      }

      //ambil data end of shift 1
      public function get_end_shift_1()  
      {
        $start_date = $this->input->post('start_date');
        $query = $this->db->query("SELECT coalesce(sum(end_shift),0) as end_shift_1 FROM tbl_float WHERE tanggal='$start_date' AND shift='SHIFT 1' ");
        return $query;
      }

      //ambil data end of shift 2
      public function get_end_shift_2()  
      {
        $start_date = $this->input->post('start_date');
        $query = $this->db->query("SELECT coalesce(sum(end_shift),0) as end_shift_2 FROM tbl_float WHERE tanggal='$start_date' AND shift='SHIFT 2' ");
        return $query;
      }

      //ambil data biaya
      public function get_biaya()  
      {
        $start_date = $this->input->post('start_date');
        $query = $this->db->query("SELECT coalesce(sum(nilai_biaya),0) as biaya FROM tbl_biaya WHERE tanggal='$start_date' ");
        return $query;
      }

      //cek closing
      public  function cek_closing()  
      { 
        $query = $this->db->query("SELECT kas_akhir FROM tbl_closing WHERE tanggal='".date('Y-m-d')."' AND id_kasir='".$this->session->userdata('id_karyawan')."' ");
        return $query;
      }


      //insert closing
      public  function insert_closing($data)  
      { 
        $this->db->insert('tbl_closing',$data);
      }




      
 }  