<?php
   defined('BASEPATH') OR exit('No direct script access allowed');
   class Secure_area extends CI_Controller {
          
       function __construct()
	    {
            parent::__construct();	
            if(!$this->session->userdata('access_token')){
                redirect('auth/login');
            }
        }
   }
   /* End of file Secure_area.php */
?>