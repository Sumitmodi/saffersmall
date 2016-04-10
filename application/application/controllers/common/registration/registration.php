<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : registration.php
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

class Registration extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /*
     * Route further into a sub module from here.
     */

    public function enter($method = null) {
        try {
            
            /*
             * Before registration check if there are any login sessions already.
             */
            
            $this->data['title'] = $this->title(DOMAIN, 'Registration');

            $type = $this->input->get('type');

            if (empty($type)) {
                $type = 'business';
            } else {
                $type = strtolower($type);
            }

            $module = ucfirst($type) . 'Register';

            $this->control = $this->load->controller($module, 'common/registration/' . $type . '/' . $type);

            $method = is_null($method) ? 'register' : $method;

            if (method_exists($this->control, $method)) {

                $this->control->{$method}();
            } else {

                show_404();
            }                       

            $this->control->response();
        } catch (Exception $e) {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }

}
