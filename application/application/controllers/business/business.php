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
 *   get permissions from the author or the distrubutor of this code.
 * 
 *   However do not expect any help or support from the author.
 */

class Business Extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function entry($module = null) {
        try {
            
            /*
             * TODO:
             * Attempt to check logins and sessions.
             */
            
            $module = empty($module) ? 'dashboard' : $module;                      
           
            $this->module = strtolower($module);

            $this->map();

            $load = 'business/' . $this->module . DS . $this->module;
          
            $control = $this->load->controller(ucfirst($this->module), $load);

            if (!$control) {
                show_404();
            }

            if (method_exists($control, 'enter')) {

                $control->enter();
            } elseif (method_exists($control, 'action')) {

                $control->action();
            } else {
                show_404();
            }
        } catch (Exception $e) {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }

    private function map() {
        try {
            $this->load->helper('directory');

            $scan = directory_map(CONTROLDIR . DS . 'business', 0);

            if ($scan == false) {
                show_error('Something is missing i dont know what it is.', 404);
            }

            foreach ($scan as $k => $v) {
                if (is_numeric($k)) {
                    continue;
                }

                $k = strtolower($k);

                if (stripos($k, $this->module) != false) {
                    $this->module = $k;

                    break;
                }
            }
        } catch (Exception $e) {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }

}
