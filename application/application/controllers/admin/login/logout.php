<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Logout extends CI_Controller
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
            $this->session->unset_userdata('admin_username');

            $this->session->unset_userdata('login_type');

            $this->header('admin/login');
            
            return $this;
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }

}
