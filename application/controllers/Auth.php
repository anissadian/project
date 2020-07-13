<?php
   defined('BASEPATH') OR exit('No direct script access allowed');
   class Auth extends CI_Controller {
        
        public function __construct()
        {
            parent::__construct();
            $this->load->model('m_login');
        }
        


        public function index()
        {
            
        }

        public function register(){
            $this->load->view('v_register');
            
        }

        public function google_login(){
            include_once APPPATH . 'libraries/vendor/autoload.php';

            $google_client = new Google_Client();

            $google_client->setClientId('450495525138-roemb355lhltetidkj39bbkm8kf000sk.apps.googleusercontent.com');

            $google_client->setClientSecret('WDT29s8TeOml0JJQc-IqdODl');

            $google_client->setRedirectUri('http://localhost/project/auth/google_login');

            $google_client->addScope('email');
            $google_client->addScope('profile');
            // print_r($this->session->userdata());

            if(isset($_GET["code"])){
                $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

                if(!isset($token["error"])){
                    $google_client->setAccessToken($token['access_token']);

                    $this->session->set_userdata('access_token', $token['access_token']);

                    $google_service = new Google_Service_Oauth2($google_client);

                    $data = $google_service->userinfo->get();
                    // print_r($data);
                    $current_datetime = date('Y-m-d H:i:s');

                    $user = $this->m_login->is_registered($data['id']);
                    if(!empty($user)){
                        //update data
                        $user_data = array(
                            'first_name' => $data['given_name'],
                            'last_name' => $data['family_name'],
                            'email' => $data['email'],
                            'picture' => $data['picture'],
                            'update_time' => $current_datetime,
                        );

                        $this->m_login->update_user_data($user_data, $data['id']);
                        $this->session->set_userdata('user_id', $user->id);
                    }else{
                        $user_data = array(
                            'oauth_id' => $data['id'],
                            'first_name' => $data['given_name'],
                            'last_name' => $data['family_name'],
                            'email' => $data['email'],
                            'picture' => $data['picture'],
                            'create_time' => $current_datetime,
                        );

                        if($this->m_login->insert_user_data($user_data)){
                            $user = $this->m_login->is_registered($data['id']);
                            $this->session->set_userdata('user_id', $user->id);
                        }
                    }

                    // echo $data['id'];
                    $this->session->set_userdata('user_data', $user_data);
                }
            }
            if(!$this->session->userdata('access_token')){
                $login_button = '<a href="'.$google_client->createAuthUrl().'" class="btn btn-default btn-block btn-flat"><img width="20px" margin-right:5px" alt="Google sign-in" src="'.base_url('assets/img/google-logo.png').'" />
                Login with Google</a>';
                $data['login_button'] = $login_button;

                $this->load->view('v_login', $data);
            }else{
                // echo $this->session->userdata('access_token');
                redirect('home', 'refresh');
            }
        }

        public function login(){
            include_once APPPATH . 'libraries/vendor/autoload.php';
            $google_client = new Google_Client();

            $google_client->setClientId('450495525138-roemb355lhltetidkj39bbkm8kf000sk.apps.googleusercontent.com');

            $google_client->setClientSecret('WDT29s8TeOml0JJQc-IqdODl');

            $google_client->setRedirectUri('http://localhost/project/auth/google_login');

            $google_client->addScope('email');
            $google_client->addScope('profile');

            $login_button = '<a href="'.$google_client->createAuthUrl().'" class="btn btn-default btn-block btn-flat"><img width="20px" margin-right:5px" alt="Google sign-in" src="'.base_url('assets/img/google-logo.png').'" />
                Login with Google</a>';
                $data['login_button'] = $login_button;


            $this->load->view('v_login', $data, FALSE);
            
        }

        public function logout(){
            $this->session->unset_userdata('access_token');
            $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('user_data');

            redirect('auth/login');
        }
   
   }
   
   /* End of file Auth.php */
   
?>