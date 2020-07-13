<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require_once("Secure_area.php");
    class Home extends Secure_area {
    
        public function index()
        {
            $data['title'] = "Home";
            $this->load->view('v_home', $data);
        }
    }
?>