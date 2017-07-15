<?php
class Message_model extends CI_Model {

        function __construct(){       
        parent::__construct();
    }
    
    public function insert_msg($data){
	
		$this->db->insert('messages',$data);  
		
	}    
        public function check_id_exist($id){
            
            $query = $this->db->get_where('user', array(
            'user_id' => get_segment(2)
             ));
            $count = $query->num_rows();
            return $count;
        
        }       
        public function check_any_conversation($id){
            
            $this->db->select('*');
            $this->db->where('msg_from', $id); 
            $this->db->or_where('msg_to', $id); 
            $this->db->from('messages');
            $query=$this->db->get();
            $count2 = $query->num_rows();
            return $count2;
                    
        }
        
        public function get_unread_messages($id){             
		    //call from controller:fund            
            $query = $this->db->get_where('messages', array(
            'msg_to' => $id,
            'msg_read' => 0    
             ));
            $count = $query->num_rows();
            return $count;
        }
        public function get_unread_message_by_id($sender_id){
            $id = get_userid();
            $query = $this->db->get_where('messages', array(
            'msg_to' => $id,
            'msg_from' => $sender_id,
            'msg_read' => 0    
             ));
            $count = $query->num_rows();
            return $count;
        }
        
        public function stop_notification($id){
            
            $query = $this->db->query("   
                UPDATE messages SET msg_read = 1 WHERE msg_to = '".$id."'
                 ");
            return true;
            
        }
        
         public function makeMsgUnread ($id , $uid){
        
              $query = $this->db->query("   
                UPDATE messages SET msg_read = 1 WHERE msg_to = '".$uid."'  AND msg_from = '".$id."'
                 ");
            return true;
        
        }
        
        public function check_new_messages($id,$uid){

            $query = $this->db->query("SELECT * FROM messages WHERE msg_to = '".$uid."' AND msg_from = '".$id."' AND msg_read = 0");
           if($query->num_rows() > 0){
                return $query->result_array();
            } else{
                return false;
            }
        } 
        public function update_new_messages($id,$uid){
            $query = $this->db->query("   
                UPDATE messages SET msg_read = 1 WHERE msg_to = '".$uid."' AND msg_from = '".$id."'
                 ");
            return true;
        }
        public function get_message($uid){
     
            $id = get_segment(2);
           $query = $this->db->query("SELECT * FROM messages WHERE (msg_from = '".$uid."' AND msg_delete_from = 1 AND msg_to = '".$id."') OR (msg_to = '".$uid."' AND      msg_delete_to = 1 AND msg_from = '".$id."' )");
          
            return $query->result_array();
          
	}
        
       public function get_conversation_id(){    
           $id = get_userid();
           $this->db->select('*');
           $this->db->where('msg_from',$id);  
           $this->db->or_where('msg_to',$id); 
           $this->db->from('messages');
           $query =  $this->db->get();
           $array = array();
           foreach ($query->result_array() as $t) {
              $array[] = $t['msg_from'];
              $array[] = $t['msg_to'];
               
         }

              return $array;
            }
       
       public function get_msg_sender_info($info){
         
           $userid = get_userid();    
           $info_implode = implode ("," , $info);    
           $sql =
                        "
                        SELECT * FROM (`user`)
                        LEFT JOIN `messages` ON ( `messages`.`msg_to` = `user`.`user_id` ) OR (`messages`.`msg_from` = `user`.`user_id`)
                        WHERE `user_id` IN ($info_implode)  AND (`messages`.`msg_to` = $userid AND `messages`.`msg_delete_to` = 1) OR (`messages`.`msg_from` = $userid  AND `messages`.`msg_delete_from` = 1)
                        GROUP BY `user`.`user_id`
                        ORDER BY `msg_date` DESC
                        ";

            $query = $this->db->query($sql);       
            if($query->num_rows() > 0){               
                return $query->result_array();
            }
       }
      
     public function delete_conversation($uid,$id){
         
            $this->db->select('*');
            $this->db->where('msg_from', $uid); 
            $this->db->or_where('msg_to', $uid); 
            $this->db->from('messages');
            $query=$this->db->get();
            $msg= $query->result_array();
            foreach ($msg as $value) {
                if($value['msg_to']== $uid){
                   $query = $this->db->query("UPDATE messages SET msg_delete_to = 0 WHERE msg_to = '".$uid."' AND msg_from = '".$id."'"); 
                    
                }
                elseif($value['msg_from']== $uid){
                    $query = $this->db->query("UPDATE messages SET msg_delete_from = 0 WHERE msg_from = '".$uid."' AND msg_to = '".$id."'"); 
                    
                }
            }
            return true;
         
     }
        
        public function get_confirm_name($name){
             $session_id = get_userid();
             $query = $this->db->query("   
                SELECT *
                FROM user u
                LEFT JOIN messages m ON ( m.msg_to = u.user_id OR m.msg_from = u.user_id )
                WHERE  (u.first_name LIKE '%".$name."%' OR u.last_name LIKE '%".$name."%') AND ( m.msg_to = '".$session_id."' OR m.msg_from = '".$session_id."')
                GROUP BY u.user_id
                 ");

           if($query->num_rows() > 0){
                return $query->result_array();
            } else{
                return false;
            }
        }
		   
}