<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_chat extends CI_Model {

    public function insert_chat($data){
        $this->db->insert('chat_messages', $data);
        return $this->db->insert_id();
    }

    public function get_user_chat(){
        $this->db->select('CONCAT(u.first_name," ", u.last_name) sender, c.*, CONCAT(r.first_name," ", r.last_name) receiver, r.picture');
        $this->db->from('chat_messages c');
        $this->db->join('users u', 'u.id = c.sender_id');
        $this->db->join('users r', 'r.id = c.receiver_id', 'left');
        $this->db->join('(SELECT MAX(id_messages) as id_messages, sender_id, receiver_id FROM chat_messages group by sender_id, receiver_id) l', 'c.id_messages = l.id_messages and u.id = l.sender_id and r.id = l.receiver_id');
        
        $this->db->where('u.email', $this->session->userdata('user_data')['email']);
        
        $this->db->order_by('c.id_messages', 'desc');
        return $this->db->get()->result();
    }

    public function get_user_chat_messages($receiver){
        $this->db->select('CONCAT(u.first_name," ", u.last_name) sender, u.picture as sender_picture, c.*, DATE_FORMAT(c.chat_datetime, "%d %M %Y") as chat_datetime, CONCAT(r.first_name," ", r.last_name) receiver, r.picture as receiver_picture');
        $this->db->from('chat_messages c');
        $this->db->join('users u', 'u.id = c.sender_id');
        $this->db->join('users r', 'r.id = c.receiver_id', 'left');
        // $this->db->join('(SELECT MAX(id_messages) as id_messages, sender_id, receiver_id FROM chat_messages group by sender_id, receiver_id) l', 'c.id_messages = l.id_messages and u.id = l.sender_id and r.id = l.receiver_id');
        
        
        $this->db->group_start();
            $this->db->where('u.email', $this->session->userdata('user_data')['email']);
            $this->db->where('r.id', $receiver);    
            $this->db->or_group_start();
                $this->db->where('r.email', $this->session->userdata('user_data')['email']);
                $this->db->where('u.id', $receiver); 
            $this->db->group_end();
        $this->db->group_end();
        
        $this->db->order_by('c.id_messages', 'desc');
        return $this->db->get()->result();
    }

    public function get_chat_by_id($id){
        $this->db->select('CONCAT(u.first_name," ", u.last_name) sender, u.picture as sender_picture, c.*, DATE_FORMAT(c.chat_datetime, "%d/%m/%Y %H:%i") as chat_datetime, CONCAT(r.first_name," ", r.last_name) receiver, r.picture as receiver_picture');
        $this->db->from('chat_messages c');
        $this->db->join('users u', 'u.id = c.sender_id');
        $this->db->join('users r', 'r.id = c.receiver_id', 'left');
        // $this->db->join('(SELECT MAX(id_messages) as id_messages, sender_id, receiver_id FROM chat_messages group by sender_id, receiver_id) l', 'c.id_messages = l.id_messages and u.id = l.sender_id and r.id = l.receiver_id');
        
        
        $this->db->where('c.id_messages', $id);
        return $this->db->get()->row();
    }
}

/* End of file M_login.php */

?>