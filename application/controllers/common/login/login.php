<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
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
 *   get permissions from the author or the distrubutor of this code.
 * 
 *   However do not expect any help or support from the author.
 */

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
    }

    public function enter()
    {
        try
        {

            $this->data['title'] = $this->title(DOMAIN, 'Login');

            /*
             * Check session, if someone is already logged in.
             */

            $logged = $this->session->userdata('login_type');

            if (!empty($logged))
            {
                $this->header('dashboard');
            }

            $type = $this->input->get('type', TRUE);

            if (empty($type))
            {
                $type = strtolower('business');
            } else
            {
                $type = strtolower($type);
            }

            $module = ucfirst($type) . 'Login';

            $this->control = $this->load->controller($module, 'common/login/' . $type . '/' . $type);

            $this->control->login();

            $this->control->response();
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }

}
