<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : accounts.php
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

class Accounts extends CI_Controller {

    public function __construct() {

        parent::__construct();
        
        unset($this->model);

        $this->load->model('common/common', 'model');

        $this->root = 'business/main';

        $this->load->controller('LoginVerify', 'common/verification/login')->login();
    }

    public function enter() {
        try {

            /*
             * Get the target item
             */
           if(isset($this->unseen_notifications)){
                
                $this->data['unseen_notifications'] = $this->unseen_notifications;
            }
            
            else $this->data['unseen_notifications'] = null;

            
            $target = $this->uri->segment(3);//$this->input->get('target', TRUE);
            
            $this->target = !empty($target) ? strtolower($target) : 'dashboard';

            /*
             * Process the target
             */
            if (method_exists($this, $this->target)) {

                $this->{$this->target}();
            } else {

                show_404();
            }

            $this->response();
        } catch (Exception $e) {

            $this->header = $e->getCode();

            $this->message = $e->getCode();

            show_error($this->message);
        }
    }

    private function username() {
        try {

            $username = $this->session->userdata('username');
        } catch (Exception $e) {

            $this->header = $e->getCode();

            $this->message = $e->getMessage();

            $this->page = '';
        }
    }

    private function dashboard() {
        try {

            $this->data['title'] = $this->title('Dashboard', 'Account');
            
            $this->data['class'] = 'accounts';

            $user = $this->model->select('business_members', '*', array('username' => $this->session->userdata('username')), NULL, 1);

            if (false == $user) {

                $this->header('login');
            }

            $this->data['user'] = $user;

            $this->page = 'business/account';

            $this->header = 200;

            $this->message = 'Welcome to your accounts dashboard';
        } catch (Exception $e) {

            $this->header = $e->getCode();

            $this->message = $e->getMessage();

            $this->page = 'business/account';
        }
    }

    private function change() {
        try {

            $target = $this->input->get('target', TRUE);
            
            if (empty($target)) {

                $target = $this->input->post('target', TRUE);
            }

            if (empty($target)) {

                throw new Exception('The detail to be changed could not be verified.', '900');
            }
            
            $this->control = $this->load->controller('Change','business/accounts/change/changes');
            
            $this->control->enter(strtolower($target));
            
            $header  = $this->control->get('header');
            
            $message = $this->control->get('message');
            
            $page  = $this->control->get('page');
            
            $this->header = empty($header) ? 200 : $header;
            
            $this->message = empty($message) ? '' : $message;
            
            $this->page = empty($page) ? 'business/account' : $page;
            
            
        } catch (Exception $e) {

            $this->header = $e->getCode();

            $this->message = $e->getCode();

            $this->page = 'business/account';
        }
    }

    private function add() {
        
    }

}
