<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model {

    function is_registered($id){
        $this->db->where('oauth_id', $id);
        return $this->db->get('users')->row();
        /* if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        } */
    }

    public function update_user_data($data, $id){
        $this->db->where('oauth_id', $id);
        return $this->db->update('users', $data);
    }

    public function insert_user_data($data){
        return $this->db->insert('users', $data);
    }
    

}

/* End of file M_login.php */

?>