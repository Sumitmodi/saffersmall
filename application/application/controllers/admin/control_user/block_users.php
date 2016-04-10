<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : dashboard.php
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
 * @Business Dashboard
 * @Any url of format dashboad/(url) will direct here
 */

class Block_users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->root = 'admin/main';
        //$this->load->model('admin/adminmodel','adminm');
        $this->load->model('common/common', 'model1');
    }

    public function block_users() { 
        try {
            $ads = $this->model1->select('app_users', '*', array('status'=>'B'));
            if(true == $ads){
                  $this->data['result'] = $ads;
            }
            else                
                $this->data['result'] = NULL;
            //else $this->data['result'] = '';
            
                    $this->page = 'admin/control_user/control_user';
                    $this->header = 200;
                    $this->message = 'Step :: first loaded successfully.';
                    $this->root = 'admin/main';
                    $this->response();
            
               
        } catch (Exception $e) {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }
    
 }
