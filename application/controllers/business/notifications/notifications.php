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

class Notifications extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        unset($this->model);

        $this->load->model('common/common', 'model');

        $this->load->controller('LoginVerify', 'common/verification/login')->login();
    }

    public function enter()
    {
        try
        {

            $user = $this->model->select('business_members', 'sno', array('username' => $this->session->userdata('username')), NULL, 1);

            $bus_ads = $this->model->select('business_ads','sno', array('bid'=>$user->sno));
            
            
            
            if (false == $user)
            {

                throw new Exception('User does not exist.');
            }

            if(empty($bus_ads)){
                
            }
           
            
           if (!empty($bus_ads)) { 
                
                foreach ($bus_ads as $ads) {

                    $notifications[] = $this->model->select('notification', '*', array('ad_id' => $ads['sno']));

                    $unseen_notifications[] = $this->model->select('notification', '*', array('ad_id' => $ads['sno'], 'notify' => 0));
                }

              
            
            //echo '<pre>'; print_r($notifications); return;
            
                if (false == $notifications)
                {
                    //do nothing
                } else
                {

                    $this->data['notifications'] = $notifications;
                }
           }
            
           if(isset($this->unseen_notifications)){
            
               $this->data['unseen_notifications'] = $this->unseen_notifications;
           }
           
           else $this->data['unseen_notifications'] = null;
            
             if (!empty($bus_ads)) { 
                foreach($bus_ads as $ads){

                    $this->model->update('notification', array('notify'=>1), array('ad_id'=>$ads['sno']));
                }
             }

            $this->page = 'business/notifications';

            $this->root = 'business/main';

            $this->header = 200;

            $this->message = 'Activity log';

            $this->response();
        } catch (Exception $e)
        {

            show_error($e->getMessage(), $e->getCode());
        }
    }

}
