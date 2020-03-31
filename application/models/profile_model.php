<?php 

class Profile_model extends CI_Model{
	/*cek old passsword*/
	 public function cek_old_pass($old_pass){
	    $check	= $this->db->get_where('users' ,array('password'=>md5($old_pass)));
		if ($check->num_rows()>0) {
			return 1;
		}else{
			return 0;
		}
     }

     public function update_pass()  
      {  
          $user_id    = $this->input->post('user_id');
          $new_pass  = md5($this->input->post("new_pass"));
          $this->db->set('password', $new_pass);
          $this->db->where('user_id', $user_id);
          $result=$this->db->update('users');
          return $result;
      }

     public function update_image($user_image,$user_id)  
      {  
          //$user_id    = $this->session->userdata('user_id');
          $this->db->set('image', $user_image);
          $this->db->where('user_id', $user_id);
          $result=$this->db->update('users');
          return $result;
/*          $check  = $this->db->get_where('users' ,array('image'=>$user_image));
            if ($check->num_rows()>0) {
              return 1;
            }else{
              return 0;
            }*/
      }


	
}










	