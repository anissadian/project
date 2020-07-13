<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require_once("Secure_area.php");
    class User extends Secure_area {
            
        public function __construct()
        {
            parent::__construct();
            $this->load->model('m_user');
        }
        

        public function update_token(){
            $id = $this->input->post('id');
            $data['device_token'] = $this->input->post('token');

            $result = $this->m_user->update_token($id, $data);

            if($result){
                echo json_encode(array('success' => true));
            }else{
                echo json_encode(array('success' => false));
            }
        }

        public function get_user_chat(){
            $data = $this->m_user->get_user_chat();

            echo json_encode($data);
        }

        public function get_user_chat_messages(){
            $id = $this->input->get('id');
            $data = $this->m_user->get_user_chat_messages($id);

            echo json_encode($data);
        }
    }
?>