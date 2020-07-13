<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require_once("Secure_area.php");
    class Chat extends Secure_area {
        
        public function __construct()
        {
            parent::__construct();
            $this->load->model("m_chat");
        }
        

        public function send()
        {
            $data = $this->input->post();
            $data['sender_id'] = $this->session->userdata('user_id');
            $data['chat_status'] = 0;
            $data['chat_datetime'] = date('Y-m-d H:i:s');
            $id = $this->m_chat->insert_chat($data);
            
            $result = $this->m_chat->get_chat_by_id($id);
            echo json_encode($result);
        }
    }
?>