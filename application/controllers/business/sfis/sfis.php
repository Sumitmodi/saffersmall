<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : sfis.php
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

class Sfis extends CI_Controller {

    public function __construct() {

        parent::__construct();
        
        unset($this->model);

        $this->load->model('common/common', 'model');

        $this->load->controller('LoginVerify', 'common/verification/login')->login();
    }

    public function enter() {
        try {

            $user = $this->model->select('business_members', 'sno,city,state,country', array('username' => $this->session->userdata('username')), NULL, 1);
            
            $this->data['title'] = $this->title('Members','Nearby');
            
            $this->data['class'] = 'sfis';

            if (false == $user) {

                throw new Exception('User does not exist.', '900');
            }

            /*
             * Try and match country , state, city first
             */
            $sfis = $this->model->select('business_members', 'username,person_name,country,state,city,business_name,sno,telephone,is_sfi,profile_link,address,fax,postal_code,email,date_added', array('country' => $user->country, 'state' => $user->state, 'city' => $user->city,'sno != '=>$user->sno), array('date_added' => 'desc'));
            /*
             * Then, Try and match country , state
             */
            
            if (false == $sfis) {

                $sfis = $this->model->select('business_members', 'username,person_name,country,state,city,business_name,sno,is_sfi,telephone,profile_link,address,fax,postal_code,email,date_added', array('country' => $user->country, 'state' => $user->state,'sno != '=>$user->sno), array('date_added' => 'desc'));
            }
            
            /*
             * Further try and match country, city
             */
            
            if (false == $sfis) {

                $sfis = $this->model->select('business_members', 'username,person_name,country,state,city,business_name,sno,is_sfi,telephone,profile_link,address,fax,postal_code,email,date_added', array('country' => $user->country, 'city' => $user->city,'sno != '=>$user->sno), array('date_added' => 'desc'));
            }
            
            if($sfis != false){
                
                foreach($sfis as $k=>$s){
                    
                    $s = (object) $s;
                    
                    $ads = $this->model->select('business_ads','sno,name,location,city,country',array('bid'=>$s->sno),array('date_added'=>"desc"));
                    
                    if($ads != false) {
                        
                        $sfis[$k]['ads'] = $ads;
                        
                         

                    }
                    
                }
                
                if(isset($this->unseen_notifications)){
                
                $this->data['unseen_notifications'] = $this->unseen_notifications;
            }
            
            else $this->data['unseen_notifications'] = null;
                
                $this->data['sfis'] = $sfis;
                
            }
            

            $this->root = 'business/main';

            $this->page = 'business/users';
            
            $this->response();
        } catch (Exception $e) {

            show_error($e->getMessage(), $e->getCode());
        }
    }

}
