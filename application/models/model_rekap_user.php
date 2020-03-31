<?php  
 class Model_rekap_user extends CI_Model{  

    public function query($sql){
     $data = $this->db->query($sql);
    return $data->result_array();
  }





 }  