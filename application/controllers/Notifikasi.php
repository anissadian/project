<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_user');
    }
    

    public function index(){
        $data['title'] = "Notifikasi";
        $data['users'] = $this->m_user->get_user_list();
        $this->load->view('v_notifikasi', $data, FALSE);
        
    }

    /**
     * Send to a single device
     */
    public function kirim()
    {
        $to = $this->input->post('to');
        $title = $this->input->post('title');
        $messages = $this->input->post('messages');

        $token = $this->m_user->get_user_token($to)->device_token;

        $this->load->library('fcm');
        $this->fcm->setTitle($title);
        $this->fcm->setMessage($messages);

        /**
         * payload is used to send additional data in the notification
         * This is purticularly useful for invoking functions in background
         * -----------------------------------------------------------------
         * set payload as null if no custom data is passing in the notification
         */
        $payload = array('notification' => '');
        $this->fcm->setPayload($payload);

        // $this->fcm->setImage(base_url('assets/img/google-logo.png'));
        $this->fcm->setImage('');

        $json = $this->fcm->getPush();

        $p = $this->fcm->send($token, $json);

        print_r($p);
    }

    public function sendToMultiple()
    {
        $token = array('Registratin_id1', 'Registratin_id2'); // array of push tokens
        $message = "Test notification message";

        $this->load->library('fcm');
        $this->fcm->setTitle('Test FCM Notification');
        $this->fcm->setMessage($message);
        $this->fcm->setIsBackground(false);
        // set payload as null
        $payload = array('notification' => '');
        $this->fcm->setPayload($payload);
        $this->fcm->setImage('https://firebase.google.com/_static/9f55fd91be/images/firebase/lockup.png');
        $json = $this->fcm->getPush();

        $result = $this->fcm->sendMultiple($token, $json);
    }
}
