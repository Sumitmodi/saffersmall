<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : login.php
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

class LoginVerify extends CI_Controller {

    public function __construct() {

        parent::__construct();

        if (isset($this->model)) {

            unset($this->model);
        }

        $this->load->model('common/common', 'model');
    }

    public function login() {
        try {

            $user = $this->session->userdata('username');

            if (empty($user)) {

                $this->session->set_userdata('message', 'Please login to continue..');

                $this->header('login');

                return false;
            }

            $user = $this->model->select('business_members', 'sno', array('username' => $user), NULL, 1);

            if (false == $user) {

                $this->session->set_userdata('message', 'Please login to continue..');

                $this->header('login');

                return flase;
            }

            if (false == $this->session->userdata('login_type')) {

                $this->session->set_userdata('message', 'Please login to continue..');


                $this->header('login');

                return false;
            }

            return true;
        } catch (Exception $e) {

            $this->header = $e->getCode();

            $this->message = $e->getMessage();
        }
    }

}
