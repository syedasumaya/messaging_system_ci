<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Message extends Base_controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('site/message_model');
        $this->load->model('site/site_model');
        $this->load->library("pagination");
        $this->load->library('file_processing');
        $this->load->library('image_lib');
    }

    public function internal_messaging() {
        is_loggedin();

        $count = $this->message_model->check_id_exist(get_segment(2));
        if ($count > 0) {
   
            $data['prof_id'] = get_segment(2);
            $data['title'] = " All Messages";
            $data['row'] = $this->site_model->get_profile_info($data['prof_id']);
            $conversation = $this->message_model->get_conversation_id();
            if ($conversation != null) {
                $data['msg_sender_info'] = $this->message_model->get_msg_sender_info($conversation);
            }

            $data['messages'] = $this->message_model->get_message(get_userid());
			//person whom with no conversation
            $data['count2'] = $this->message_model->check_any_conversation(get_segment(2));  
            $this->load->view('site/common/header', $data);
            $this->load->view('site/message/internal_messaging', $data);
            $this->load->view('site/common/footer');
        } else {
            $data['title'] = "Message";
            $this->load->view('site/common/header', $data);
            $this->load->view('site/profile/profile');
            $this->load->view('site/common/footer');
        }
    }

    public function send_message() {
       
        $date = date('Y-m-d H:i:s');
        // image upload function
        if (isset($_FILES['msg_image']) && !empty($_FILES['msg_image']['name'][0])) {
            $filearray = array();
            $config['upload_path'] = './images/msg_image/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '80246';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $fileinfo = $this->upload->do_multi_upload("msg_image");
            if (!$fileinfo) {
                $data = array();
                $data['error'] = $this->upload->display_errors();
                if ($data['error']) {
                    $this->session->set_flashdata("error", $data['error'] . " Allowed file types are jpg,jpeg,png,gif");
                    redirect('internal_messaging/' . get_segment(2));
                }
            } else {
                if (isset($fileinfo) && (is_array($fileinfo))) {
                    $filearray = $_FILES['msg_image'];
                    $info['msg_image'] = $filearray['name'][0];
                }
              
            }
        }

        if (isset($_FILES['msg_attach']) && !empty($_FILES['msg_attach']['name'][0])) {
            $filearray = array();
            $config['upload_path'] = './images/msg_attach/';
            $config['allowed_types'] = 'doc|txt|pdf|zip|docx|rar|pptx|xlsx|xls';
            $config['max_size'] = '80246';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $fileinfo = $this->upload->do_multi_upload("msg_attach");
            if (!$fileinfo) {
                $data = array();
                $data['error'] = $this->upload->display_errors();
                if ($data['error']) {
                    $this->session->set_flashdata("error", $data['error'] . " Allowed file types are doc,txt,pdf,zip,docx,rar,pptx,xlsx,xls");
                    redirect('internal_messaging/' . get_segment(2));
                }
            } else {
                if (isset($fileinfo) && (is_array($fileinfo))) {
                    $filearray = $_FILES['msg_attach'];
                    $info['msg_attach'] = $filearray['name'][0];
                }
                
            }
        }//END HERE

        $info['message'] = nl2br($this->input->post('message'));
        $info['msg_from'] = get_userid();   //sender_id
        $info['msg_to'] = $this->input->post('msg_to');  //receiver_id
        $info['msg_date'] = $date;
        $info['msg_delete_to'] = 1; //before delete
        $info['msg_delete_from'] = 1; //before delete
            if($info['msg_from'] != $info['msg_to']){
                 $data['full_msg'] = $this->message_model->insert_msg($info);  //insert
                 $info['time'] = date("h:i A", strtotime($info['msg_date']));
            $json = array();     
           if (isset($info['message']) && $info['message'] != null) {
                
               $json['message'] = $info['message'];
           }   
           if (isset($info['msg_image']) && $info['msg_image'] != null) {
                
               $json['msg_image'] = $info['msg_image'];
           }  
           if (isset($info['msg_attach']) && $info['msg_attach'] != null) {
                
               $json['msg_attach'] = $info['msg_attach'];
           }  
          $json['time'] = $info['time'];
      
        }else{
            $json['failed'] = 'failed';
        }
         echo json_encode($json);
    }
 
    public function ajax_find(){
          
        $search =  $this->input->post('confirm');
        $confirm_name = $this->message_model->get_confirm_name($search);
        if($confirm_name == true){
        foreach($confirm_name as $value){
           $first = $value['first_name']; 
           $last = $value['last_name'];  
           $json= array('name'=>$first. " " .$last,'image'=>$value['profile_image'],'id'=>$value['user_id']);
       } 
       }else{
           $json= array('failed'=>'failed','message'=>'Not found!!!');
       }  
        echo json_encode($json);
       
        
    }
    public function check_messages(){
        $uid = get_userid();
        $id =  $this->input->post('confirm');
        $check_messages = $this->message_model->check_new_messages($id,$uid);
        if(!empty($check_messages)){
        $update_messages = $this->message_model->update_new_messages($id,$uid);
        if($update_messages == true){
        foreach ($check_messages as $check) {
            $json['success'] = 'success';
            if (isset($check['message']) && $check['message'] != null) {
                $json['message'] = $check['message'];
            }
            if (isset($check['msg_image']) && $check['msg_image'] != null) {
            $json['msg_image'] = $check['msg_image'];
            }
            if (isset($check['msg_attach']) && $check['msg_attach'] != null) {
            $json['msg_attach'] = $check['msg_attach'];
            }
           if (isset($check['msg_date']) && $check['msg_date'] != null) {
            $json['time'] = date("h:i A", strtotime($check['msg_date']));
            $json['date'] = date("Y:m:d", strtotime($check['msg_date']));
           }
        }
        }
        }else{
            $json['failed'] = 'failed';
        }
        echo json_encode($json);
    }
     public function notification(){
        $json = array();
        $uid = get_userid();
        $notification = $this->message_model->stop_notification($uid);
        if($notification == true){
            $json['success'] = 'Updated successfully';
        }
        else{
            $json['failed'] = 'failed';
        }
        echo json_encode($json);
     }
     
       public function makeunread(){
     
                 $json = array();
                $id =   $this->input->post('id');
                $uid =   $this->input->post('uid');
                
                $makeMsgUnread = $this->message_model->makeMsgUnread ($id , $uid);
                
                if($makeMsgUnread == true){
                     $json['success'] = 1;
                     $json['msg'] = 'Updated successfully';
                }else{
                      $json['success'] = 0; 
                }
              
                 echo json_encode($json);
     }
     
     public function delete_conversation(){
         $uid = get_userid();
         $id = $this->uri->segment(2);
         $delete_conversation = $this->message_model->delete_conversation($uid,$id); 
         if($delete_conversation == true){
              redirect('internal_messaging/' . $uid);
         }
         
     }

}
