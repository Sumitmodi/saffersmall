<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        $this->root = 'admin/main';
        
        $this->load->model('admin/adminmodel', 'adminm');
    }

    public function enter()
    {
        try
        {
            if($this->session->userdata('admin_username') != false && $this->session->userdata('login_type') == 'admin')
            {
                $this->header('admin/dashboard');
                
                return $this;
            }
            
            $data = $this->input->post(NULL, TRUE);

            if (empty($data))
            {
                $this->data['title'] = $this->title('Admin ', 'Login');

                $this->page = 'admin/login';

                $this->header = 200;

                $this->message = 'Please login before we continue...';

                $this->root = 'admin/main';

                $this->response();

                return;
            } else
            {
                $user_name = $data['uname'];

                $password = md5($data['password']);

                $result = $this->adminm->validate_user($user_name, $password);

                if ($result == TRUE)
                {
                    $ses_data = array('admin_username' => $user_name);

                    $this->session->set_userdata($ses_data);

                    $this->session->set_userdata('login_type', 'admin');

                    $this->header('admin/dashboard');
                } else
                    throw new Exception('Entered credentials do not validate you as an admin.', '900');
            }
        } catch (Exception $e)
        {
            $this->header = $e->getCode();

            $this->message = $e->getMessage();

            $this->root = 'admin/main';
            
            $this->data['title'] = $this->title('Admin ', 'Login');

            $this->page = 'admin/login';
            
            $this->response();
        }
    }

}
