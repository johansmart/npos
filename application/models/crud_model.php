<?php  
 class Crud_model extends CI_Model  
 {  
      /*variable datatables*/
      var $table = "users";  
      var $select_column = array("id", "user_id", "user_name", "image","role","date","created");  
      var $order_column = array(null, "user_id", "user_name","role","date","created", null, null);
      /*function get data from database*/  
      function make_query()  
      {  
          $this->db->select($this->select_column);  
          $this->db->from($this->table);  
          if(isset($_POST["search"]["value"]))  
          {  
              $this->db->like("user_id", $_POST["search"]["value"]);  
              $this->db->or_like("user_name", $_POST["search"]["value"]);  
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
      function get_all_data()  
      {  
           $this->db->select("*");  
           $this->db->from($this->table);  
           return $this->db->count_all_results();  
      }
      
      /*insert user*/  
      function insert_crud($data)  
      {
        $user_id=$this->input->post('user_id'); 
        $hsl=$this->db->query("SELECT * FROM users WHERE user_id='$user_id'");
          if($hsl->num_rows()>0){
            return 1;
            return false;
          }
          else {
            $this->db->insert('users',$data);
          } 
      }
      /*update user*/  
      function update_crud()  
      {  
          $user_id    = $this->input->post('user_id');
          $user_name  = trim(strtoupper($this->input->post("user_name")));
          $role       = $this->input->post('role');
          $this->db->set('user_name', $user_name);
          $this->db->set('role', $role);
          $this->db->where('user_id', $user_id);
          $result=$this->db->update('users');
          return $result;
      }
      /*delete user*/
      function delete_single_user()  
      {  
          $user_id  = $this->input->post('user_id');
          $this->db->where("id", $user_id);  
          $this->db->delete("users");  
      }

      function max_user_id()  
      {  
        $query = $this->db->query("SELECT * FROM users order by user_id desc limit 1");
        return $query->row_array();
      }

 }  