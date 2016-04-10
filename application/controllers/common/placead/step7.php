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
        
        session_start();

        if (empty($this->model)) {

            $this->load->model('common/common', 'model');
            
           
        }
    }

    public function manage() {
        try {

           
            $this->data['title'] = $this->title('Place Ad', 'Select payments');
            
            if(isset($this->unseen_notifications)){
                
                $this->data['unseen_notifications'] = $this->unseen_notifications;
            }
            
            else $this->data['unseen_notifications'] = null;
            
            

            $data = $this->input->post(NULL, TRUE);
//            echo '<pre>';
//            print_r($data); return;

            $sum = 0;

            if($data['later'] != 'later' || $data['later'] == ''){ 
            if (isset($data['bump'])) {

                $packages = $this->model->select('app_packages','*', array('LOWER(type)'=>'e', 'LOWER(name)'=>'bumpup ads'), null, 1);
                
                $sum += $packages->price*$packages->length;
               
                $this->session->set_userdata('bump', 1);
                 //echo "here"; echo $sum; return;
            }

            if (isset($data['top'])) {

                $packages = $this->model->select('app_packages','*', array('LOWER(type)'=>'e', 'LOWER(name)'=>'top ads'), null, 1);
                
                $sum += $packages->price*$packages->length;

                $this->session->set_userdata('top', 1);
            }

            if (isset($data['highlight'])) {

                $packages = $this->model->select('app_packages','*', array('LOWER(type)'=>'e', 'LOWER(name)'=>'highlight ads'), null, 1);
                
                $sum += $packages->price*$packages->length;

                $this->session->set_userdata('highlight', 1);
            }

            if (isset($data['urgent'])) {


                $packages = $this->model->select('app_packages','*', array('LOWER(type)'=>'e', 'LOWER(name)'=>'urgent ads'), null, 1);
                
                $sum += $packages->price*$packages->length;

                $this->session->set_userdata('urgent', 1);
            }

            if (isset($data['home'])) {

                $packages = $this->model->select('app_packages','*', array('LOWER(type)'=>'e', 'LOWER(name)'=>'home ads'), null, 1);
                
                $sum += $packages->price*$packages->length;

                $this->session->set_userdata('home', 1);
            }
                  
            if ($sum > 0 ) {
                
                //$sum = $sum*0.08594;
                
                //$sum = round($sum, 2);
                
               
                
                 //$sum = sprintf('%0.2f', $sum); 
                 
                if($this->session->userdata('package_name')!= null){
                
                    $package_price = $this->model->select('app_packages', 'price, length', array('name'=>  $this->session->userdata('package_name')), null, 1);

                    $sum += $package_price->price*$package_price->length;
                }

                $this->session->set_userdata('referer', 'dashboard');
                
                $sum = number_format((float)$sum, 2);
                //echo $sum;  
                $this->session->set_userdata('pay',$sum);
               
                $payment_type = $data['payment'];
                
//                echo $payment_type; echo 'here';
//                return;
                if($payment_type == 'paypal')
                redirect(base_url().'payment');
                
                else 
                    redirect (base_url ().'payment/eft');
                //$this->header('payment');
            } else {

                $this->header('dashboard');
            }
            }
            
            else{
               
                $_SESSION['anti_session'] = 0;
                
                $this->header('dashboard');
            }
            
        } catch (Exception $e) {

            $this->header = $e->getCode();

            $this->message = $e->getMessage();

            $this->page = 'placead/step5';
        }
    }

}
