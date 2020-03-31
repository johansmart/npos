<?php 

class model_userLog extends CI_Model{
	function login($user_id,$password){
		$check	= $this->db->get_where('users' ,array('user_id'=>$user_id,'password'=>md5($password)));
		if ($check->num_rows()>0) {
			return 1;
		}else{
			return 0;
		}
	}

	function user_name($user_id){
		$query = $this->db->get_where('users', array('user_id' => $user_id));
	    return $query->row_array();
	}
}










	