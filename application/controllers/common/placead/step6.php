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
            
            //echo '<pre>'; print_r($data);
            
            $this->data['title'] = $this->title('Bump Your Ad','Step 6');
                      
            if (!empty($data)) {

                $this->parse($data);
            }
            
            if(isset($this->unseen_notifications)){
                
                $this->data['unseen_notifications'] = $this->unseen_notifications;
            }
            
            else $this->data['unseen_notifications'] = null;
            
            $packages = $this->model->select('app_packages','*', array('LOWER(type)'=>'e'));
               //echo '<pre>'; print_r($packages);  return;
                if(isset($packages) && is_array($packages)){
                     
                    foreach($packages as $package){
                         
                         if(strtolower($package['name']) == 'bumpup ads'){
                          
                             $this->data['bumpup'] = $package['name'];
                             
                             $this->data['bumpup_price'] = $package['price'];
                             
                             $this->data['bumpup_length'] = $package['length']; 
                                     
                         }
                         
                         if(strtolower($package['name']) == 'top ads'){
                          
                             $this->data['top'] = $package['name'];
                             
                             $this->data['top_price'] = $package['price'];
                             
                             $this->data['top_length'] = $package['length']; 
                                     
                         }
                         
                         if(strtolower($package['name']) == 'highlight ads'){
                          
                             $this->data['highlight'] = $package['name'];
                             
                             $this->data['highlight_price'] = $package['price'];
                             
                             $this->data['highlight_length'] = $package['length']; 
                                     
                         }
                         
                         if(strtolower($package['name']) == 'home ads'){
                          
                             $this->data['home'] = $package['name'];
                             
                             $this->data['home_price'] = $package['price'];
                             
                             $this->data['home_length'] = $package['length']; 
                                     
                         }
                         
                         if(strtolower($package['name']) == 'urgent ads'){
                          
                             $this->data['urgent'] = $package['name'];
                             
                             $this->data['urgent_price'] = $package['price'];
                             
                             $this->data['urgent_length'] = $package['length']; 
                                     
                         }
                         
                     }
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

    private function parse($data) {
        /*
         * Currently
         */
        $this->session->set_userdata('package_name',$data['package_name']);
        
        $this->session->set_userdata('package_price',$data['package_price']);
        return true;
    }

}
