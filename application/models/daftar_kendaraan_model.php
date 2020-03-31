<?php  
 class Daftar_kendaraan_model extends CI_Model  
 {  
   /*variable datatables*/
      var $table = "tmp_today";  
      var $select_column = array("id","id_kendaraan","no_polisi","jenis_kendaraan","tanggal","waktu_masuk","jumlah_helm","user_id","user_name");  
      var $order_column = array("id_kendaraan","no_polisi","jenis_kendaraan", "tanggal","waktu_masuk","jumlah_helm","user_id","user_name");
      /*function get data from database*/  
      function make_query()  
      {  
        //$hari_ini     = date("Y-m-d");
        $this->db->select($this->select_column);  
        $this->db->from($this->table);
       /* $this->db->where('tanggal = "'.$hari_ini.'"');*/

          if(isset($_POST['search']['value']))  
          {  
              $this->db->group_start();
              $this->db->like("id_kendaraan", $_POST['search']['value']);   
              $this->db->or_like("no_polisi", $_POST['search']['value']);
              $this->db->or_like("jenis_kendaraan", $_POST['search']['value']);
              $this->db->or_like("tanggal", $_POST['search']['value']);
              $this->db->or_like("waktu_masuk", $_POST['search']['value']);
              $this->db->or_like("jumlah_helm", $_POST['search']['value']);
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

      function get_all_data(){   
           $this->db->select($this->select_column);  
           $this->db->from($this->table);  
           return $this->db->count_all_results();  
      }


      /*function getmax_id_kendaraan(){
       $hari_ini   = date("Y-m-d");  
       $query = $this->db->query("SELECT id FROM kendaraan_masuk  order by id desc limit 1");
        return $query->row_array();
      }*/


      function insert_kendaraan_masuk($data){
          $this->db->insert('kendaraan_masuk',$data);
      }

      function insert_tmp_today($data){
          $this->db->insert('tmp_today',$data);
      }

      /*begin notification*/
      function content_notif_total(){
        $hari_ini   = date("Y-m-d");   
        $query = $this->db->query("SELECT no_polisi FROM kendaraan_masuk where tanggal='$hari_ini' ");
        return $query->num_rows();
      }

      function label_notif_masuk(){
        $hari_ini   = date("Y-m-d");   
        $query = $this->db->query("SELECT no_polisi FROM tmp_today where tanggal='$hari_ini' ");
        return $query->num_rows();
      }
  
      function label_notif_keluar(){
        $hari_ini   = date("Y-m-d");   
        $query = $this->db->query("SELECT no_polisi FROM tmp_today ");
        return $query->num_rows();
      }

      function content_notif_motor(){
        $hari_ini   = date("Y-m-d");   
        $query = $this->db->query("SELECT no_polisi FROM kendaraan_masuk where jenis_kendaraan='MOTOR' and tanggal='$hari_ini'");
        return $query->num_rows();
      }

      function content_notif_mobil(){
        $hari_ini   = date("Y-m-d");   
        $query = $this->db->query("SELECT no_polisi FROM kendaraan_masuk where jenis_kendaraan='MOBIL' and tanggal='$hari_ini'");
        return $query->num_rows();
      }
      /*end notification*/

      function getdata_post_insert_keluar(){
        $id_kendaraan = $this->input->post('id_kendaraan_keluar');
        //$hari_ini     = date("Y-m-d"); 
        $query = $this->db->query("SELECT * from tmp_today where id_kendaraan='$id_kendaraan' ");
        return $query->row_array();
      }

      function getdata_post_karcis_hilang(){
        $id_kendaraan = $this->input->post('id_kendaraan_kh');
        //$hari_ini     = date("Y-m-d"); 
        $query = $this->db->query("SELECT * from tmp_today where id_kendaraan='$id_kendaraan' ");
        return $query->row_array();
      }

      function insert_kendaraan_keluar($data){
            $hari_ini   = date("Y-m-d");
            $id_kendaraan_keluar = $this->input->post('id_kendaraan_keluar');
            $hsl          = $this->db->query("SELECT id_kendaraan FROM kendaraan_keluar WHERE id_kendaraan='$id_kendaraan_keluar' and tanggal='$hari_ini'");
            if($hsl->num_rows()>0){
              return 1;
              return false;
            }
            else{
              $this->db->insert('kendaraan_keluar',$data);
              $id_kendaraan  = $this->input->post('id_kendaraan_keluar');
              $this->db->where("id_kendaraan", $id_kendaraan);  
              $this->db->delete("tmp_today");
            }
      }

      function getdata_direct_out($id_kendaraan){
        $query = $this->db->query("SELECT * from tmp_today where id_kendaraan='$id_kendaraan' ");
        return $query->row_array();
      }

      function insert_karcis_hilang($data){
          $this->db->insert('karcis_hilang',$data);
      }

      function insert_multiple_kendaraan_keluar($data){
          $id_kendaraan = $this->input->post('id_kendaraan_kh');
          $this->db->insert('kendaraan_keluar',$data);
          $this->db->where("id_kendaraan", $id_kendaraan);  
          $this->db->delete("tmp_today");
      }

      /*function get ajax*/
    function get_no_polisi(){
        $hari_ini   = date("Y-m-d");
        $id_kendaraan = $this->input->post('id_kendaraan');
        $query = $this->db->query("SELECT no_polisi from tmp_today where id_kendaraan='$id_kendaraan' ");
        return $query->row_array();
     }

          /*function get id kendaraan karcis hilang*/
    function get_id_kendaraan_kh(){
        $hari_ini   = date("Y-m-d");
        $no_polisi_kh = $this->input->post('no_polisi_kh');
        $query = $this->db->query("SELECT id_kendaraan from tmp_today where no_polisi='$no_polisi_kh' ");
        return $query->row_array();
     } 

          /*function get ajax*/
    function get_jam_masuk(){
        $hari_ini   = date("Y-m-d");
        $id_kendaraan = $this->input->post('id_kendaraan');
        $query = $this->db->query("SELECT waktu_masuk from tmp_today where id_kendaraan='$id_kendaraan' ");
        return $query->row_array();
     } 

    function get_jenis_kendaraan($id_kendaraan){
        $check  = $this->db->get_where('kendaraan_masuk' ,array('id'=>$id_kendaraan));
        return $check->row_array();
     }
     
      function get_waktu_masuk($id_kendaraan){
        $check  = $this->db->get_where('kendaraan_masuk' ,array('id'=>$id_kendaraan));
        return $check->row_array();
     }

      function delete_kendaraan(){
          $hari_ini   = date("Y-m-d");  
          $id_kendaraan  = $this->input->post('id_kendaraan');
          $this->db->where("id", $id_kendaraan);
          $this->db->where("tanggal", $hari_ini);  
          $this->db->delete("kendaraan_masuk");  
      }

      function delete_tmp_today(){  
          $id_kendaraan  = $this->input->post('id_kendaraan');
          $this->db->where("id_kendaraan", $id_kendaraan);  
          $this->db->delete("tmp_today");  
      }

      function delete_kendaraan_masuk(){  
          $id_kendaraan  = $this->input->post('id_kendaraan');
          $this->db->where("id_kendaraan", $id_kendaraan);  
          $this->db->delete("kendaraan_masuk");  
      }

      function getdata_print(){
        //$hari_ini     = date("Y-m-d"); 
        $query = $this->db->query("SELECT * from kendaraan_masuk order by id desc limit 1");
        return $query->row_array();
      }

      function getdata_yesterday(){
        $hari_ini     = date("Y-m-d"); 
        $query = $this->db->query("SELECT * from tmp_today where tanggal < '$hari_ini'");
        return $query->num_rows();
      }



 }  