<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : placead.php
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


/*
 * @Place Ad Class.
 * This class is common to SFI and Business members.
 * So, Placed it here.
 */

class PlaceAd extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function enter($step = NULL) {
        try {

            if (is_null($step)) {
                $step = $this->input->get('_', TRUE);
            }

            $step = empty($step) ? 1 : (int) $step;

            $this->control = $this->load->controller('Step' . $step, 'common' . DS . 'placead' . DS . 'step' . $step);

            $this->control->manage();

            $this->header = $this->control->get('header');

            $msg = $this->session->userdata('message');

            if (empty($msg)) {

                $this->message = $this->control->get('message');
            }

            if ($step - 1 > 0) {
              
                if ($this->header != 200) {

                    $this->message = $this->control->get('message');

                    $this->session->set_userdata('message', $this->message);

                    $this->enter($step - 1);
                } else {

                    $this->message = $this->control->get('message');
                }
            }


            $this->data = $this->control->get('data');

            $this->page = $this->control->get('page');

            $this->data['page'] = $this->page;

            $this->response();
        } catch (Exception $e) {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }

}
