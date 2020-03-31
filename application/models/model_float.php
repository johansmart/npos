<?php  
 class Model_float extends CI_Model  
 {  
      /*variable datatables*/
      var $table = "tbl_float";  
      var $select_column = array("tanggal","jam","id_kasir","user_name","no_pos","shift","float_value","end_shift");  
      var $order_column = array("tanggal","jam","id_kasir","user_name","no_pos","shift","float_value","end_shift");
      /*function get data from database*/  
      public function make_query()  
      {  
        $this->db->select($this->select_column); 
        $this->db->from($this->table);
        $this->db->join('users', 'tbl_float.id_kasir = users.user_id', 'left');
        $this->db->where('tanggal =',date('Y-m-d'));

        if(isset($_POST["search"]["value"]))  
        {  
            $this->db->like("id_kasir", $_POST["search"]["value"]);  
            //$this->db->or_like("tanggal", $_POST["search"]["value"]);
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

      //cek float
      public  function cek_float()  
      { 
        $shift = $this->input->post("shift");
        $query = $this->db->query("SELECT float_value FROM tbl_float WHERE tanggal='".date('Y-m-d')."' AND shift='$shift' ");
        return $query;
      }

      //insert float
      public  function insert_float($data)  
      { 
        $this->db->insert('tbl_float',$data);
      }

      //insert ke tbl_kas_flow
      public  function ins_kas_flow($data_kas_flow){ 
        $this->db->insert('tbl_kas_flow',$data_kas_flow);
      }

      //mengambil data penjualan shift hari ini
      public function get_sales_kasir(){  
        return $get_data   = $this->db->query("SELECT sum(grand_total) as grand_total FROM tbl_penjualan where id_kasir='".$this->session->userdata('id_karyawan')."' AND tanggal='".date('Y-m-d')."' AND tipe_bayar!='Piutang' ");
      }

      //update nilai end shift pada table float
      public function update_end_shift(){
          $id_kasir      = $this->input->post('id_kasir');
          $no_pos        = $this->input->post('no_pos');
          $shift         = $this->input->post('shift');
          $setoran_akhir = $this->input->post('setoran_akhir');
          $this->db->set('end_shift',$setoran_akhir, FALSE);
          $this->db->where('id_kasir =',$id_kasir);
          $this->db->where('tanggal =',date('Y-m-d'));
          $this->db->where('shift =',$shift);
          $result=$this->db->update('tbl_float');
      }

      //cek end shift
      public  function cek_end_shift(){   
        $shift = $this->input->post("shift");
        $query = $this->db->query("SELECT sum(end_shift) as end_shift FROM tbl_float WHERE tanggal='".date('Y-m-d')."' AND shift='$shift' AND id_kasir='".$this->session->userdata('id_karyawan')."' ");
        return $query;
      }


      
 }  