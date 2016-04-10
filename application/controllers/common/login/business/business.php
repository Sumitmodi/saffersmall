<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : business.php
 * 
 *   Project : saffersmall
 */

/*
 *   <Saffersmall :: Online Ads and Marketing Directory.>
 *   Copyright (C) <2014>  <Sandeep Giri>

 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.

 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.

 *   You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.

 *   This program comes with ABSOLUTELY NO WARRANTY.
 *   This is free software, and you are welcome to redistribute it only if you 
 *   get permissions from the author or the distributor of this code.
 * 
 *   However do not expect any help or support from the author.
 */

class BusinessLogin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        if(isset($this->model))
        {
            unset($this->model);
        }
        
        $this->load->model('common/common', 'model');        
    }

    public function login() {
        try {

            $this->root = 'common/login';
            
            $cats = $this->model->select('app_category', 'category_name,sno', NULL, array('category_name' => 'asc'));

            if ($cats != false) {

                $this->data['cats'] = $cats;
            }
            
            $social_links = $this->model->select('social_links','*');
            
            $this->data['social_links'] = $social_links;

            $data = $this->input->post();

            $this->data['title'] = $this->title('Login', 'Business');

            $this->data['type'] = 'business';

            $this->header = 200;

            if (empty($data)) {

                $this->data['nomenu'] = true;

                $this->page = 'business/login';

                $this->message = 'Please login before we can continue..';

                return;
            }

            if (empty($data['username'])) {
                throw new Exception('Username is required.', '900');
            }

            if (empty($data['password'])) {
                throw new Exception('Password is not required.', '900');
            }

            $user = $this->model->select('business_members', 'sno,username,password,person_name,is_sfi', array('username' => $data['username'], 'password' => md5($data['password'])), NULL, 1);

            if (false == $user) {
                throw new Exception('User does not exist.', '900');
            }

            $verified = $this->model->select('unverified_business', 'sno', array('bid' => $user->sno), NULL, 1);


            $this->session->set_userdata('username', $user->username);

            $this->session->set_userdata('login_type', 'business');
            
            /*
             * If the user is an SFI/TC affiliate
             */
           
            $this->session->set_userdata('is_sfi', "{$user->is_sfi}");
            
            if ($verified != false) {

                $this->session->set_userdata('unverified', true);

                if ($this->input->is_ajax_request()) {

                    $this->data['nomenu'] = true;

                   $this->session->unset_userdata('login_type');
                    
                    $this->page = 'business/verify';
                } else {
                    
                     $this->session->unset_userdata('login_type');
                     
                    $this->header('verify');
                }
                return;
            }

            if (isset($data['remember']) && strtolower(@$data['remember']) == 'remember') {
                $this->input->set_cookie(array('name' => 'sfid', 'value' => sha1($user->sno) . md5($config['encryption_key']),'expire'=>2592000));
            }
            $this->header('dashboard/?target=ads&action=disapproved_ads');
        } catch (Exception $e) {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();

            $this->data['nomenu'] = true;

            $this->page = 'business/login';
        }
    }

}
