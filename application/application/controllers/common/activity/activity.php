<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : activity.php
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

class Activity extends CI_Controller {

    protected $activity;
    protected $table;

    public function __construct() {

        parent::__construct();

        if (!empty($this->model)) {

            unset($this->model);
        }

        $this->load->model('common/common', 'model');
    }

    public function log() {

        try {
            
            if(empty($this->table)){
                
                throw new Exception('Please define the table the log needs to be inserted.','900');
            }                        
            
            if(empty($this->activity)){
                
                throw new Exception('Activity not defined.','900');
            }
            
            if(!is_array($this->activity)){
                
                throw new Exception('Activity data must be an array.','900');
            }
            
            return $this->model->insert($this->table,$this->activity);
            
        } catch (Exception $e) {
            
            $this->header = $e->getCode();
            
            $this->message = $e->getMessage();
        }
    }

}
