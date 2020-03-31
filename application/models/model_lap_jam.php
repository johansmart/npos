<?php  
 class Model_lap_jam extends CI_Model{  
   
  public function __construct(){
    parent::__construct();
  }

  public function query($sql){
    $data = $this->db->query($sql);
    return $data->result_array();
  }




}





 