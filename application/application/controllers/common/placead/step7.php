<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : step7.php
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

class Step7 extends CI_Controller {

    public function __construct() {

        parent::__construct();

        if (empty($this->model)) {

            $this->load->model('common/common', 'model');
        }
    }

    public function manage() {
        try {

            $this->data['title'] = $this->title('Place Ad', 'Select payments');

            $data = $this->input->post(NULL, TRUE);
            echo '<pre>';
            print_r($data);

            $sum = 0;

            if (isset($data['bump'])) {

                $sum += 29;

                $this->session->set_userdata('bump', 1);
            }

            if (isset($data['top'])) {

                $sum += 169;

                $this->session->set_userdata('top', 1);
            }

            if (isset($data['highlight'])) {

                $sum += 39;


                $this->session->set_userdata('highlight', 1);
            }

            if (isset($data['urgent'])) {


                $sum += 59;

                $this->session->set_userdata('urgent', 1);
            }

            if (isset($data['home'])) {

                $sum += 339;

                $this->session->set_userdata('home', 1);
            }
                     
            if ($sum > 0 || $this->session->userdata('package') != null) {

                $this->session->set_userdata('referer', 'dashboard');
                
                $this->session->set_userdata('pay',$sum);
                
                $this->header('payment');
            } else {

                $this->header('dashboard');
            }
        } catch (Exception $e) {

            $this->header = $e->getCode();

            $this->message = $e->getMessage();

            $this->page = 'placead/step5';
        }
    }

}
