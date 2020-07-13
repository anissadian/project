<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {

    public function update_token($id, $data){
        $this->db->where($data);
        $data_update['device_token'] = '';
        if($this->db->update('users', $data_update)){
            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        }
    }

    public function get_user_token($email){
        $this->db->where('email', $email);
        return $this->db->get('users')->row();
        
    }

    public function get_user_list(){
        $this->db->order_by('first_name', 'asc');
        
        return $this->db->get('users')->result();
    }

    public function get_user_chat(){
        $this->db->select('CONCAT(u.first_name," ", u.last_name) sender, u.picture as sender_picture,  m.*, DATE_FORMAT(m.chat_datetime, "%d/%m/%Y %H:%i") as chat_datetime, c.sender_id, c.receiver_id, CONCAT(r.first_name," ", r.last_name) receiver, r.picture as receiver_picture');
        $this->db->from('chat c');
        $this->db->join('chat_messages m', 'c.id = m.id_chat');
        $this->db->join('users u', 'u.id = c.sender_id');
        $this->db->join('users r', 'r.id = c.receiver_id', 'left');
        $this->db->join('(SELECT MAX(id_messages) as id_messages, id_chat FROM chat_messages group by id_chat) l', 'm.id_messages = l.id_messages and l.id_chat = c.id');
        
        $this->db->where('c.sender_id', $this->session->userdata('user_id'));
        $this->db->or_where('c.receiver_id', $this->session->userdata('user_id'));
        
        $this->db->order_by('m.id_messages', 'desc');
        return $this->db->get()->result();
    }

    public function get_user_chat_messages($id){
        $this->db->select('CONCAT(u.first_name," ", u.last_name) sender, u.picture as sender_picture, c.*, DATE_FORMAT(c.chat_datetime, "%d/%m/%Y %H:%i") as chat_datetime, CONCAT(r.first_name," ", r.last_name) receiver, r.picture as receiver_picture');
        $this->db->from('chat_messages c');
        $this->db->join('users u', 'u.id = c.sender_id');
        $this->db->join('users r', 'r.id = c.receiver_id', 'left');
        // $this->db->join('(SELECT MAX(id_messages) as id_messages, sender_id, receiver_id FROM chat_messages group by sender_id, receiver_id) l', 'c.id_messages = l.id_messages and u.id = l.sender_id and r.id = l.receiver_id');
        
        $this->db->where('c.id_chat', $id);
        

        $this->db->group_start();
            $this->db->where('c.sender_id', $this->session->userdata('user_id'));
            $this->db->or_where('c.receiver_id', $this->session->userdata('user_id')); 
        $this->db->group_end(); 
        
        $this->db->order_by('c.id_messages', 'asc');
        return $this->db->get()->result();
    }
}

/* End of file M_login.php */

?>