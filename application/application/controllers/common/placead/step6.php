<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : step6.php
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

class Step6 extends CI_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->library('session');
    }

    public function manage() {
        try {

            $data = $this->input->post(NULL, TRUE);
            
            $this->data['title'] = $this->title('Bump Your Ad','Step 6');
                      
            if (!empty($data)) {

                $this->parse($data);
            }
            
            $this->page = 'placead/step5';
            
            $this->header = 200;
            $this->message = 'You package has been saved succesfully.';
            
            
        } catch (Exception $e) {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();

            $this->page = 'placead/step4';
        }
    }

    private function parse() {
        /*
         * Currently
         */
        $this->session->set_userdata('package','basic');
        return true;
    }

}
