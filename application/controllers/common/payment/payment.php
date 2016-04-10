<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : payment.php
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

class Payments extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        unset($this->model);
        
        session_start();

        $this->load->model('common/common', 'model');

        $this->load->library('paypal');
    }

    public function enter()
    {
        try
        {
            

            $target = $this->uri->segment(2);

            /* $this->header('dashboard');

              return; */

            if (!empty($target))
            {

                $this->{$target}();

                return;
            }

            $total = $this->getAmount();

            /*
             * Things still remain here to be managed.
             */

            $this->paypal->data('package', $this->session->userdata('package'));

            $this->paypal->data('amount', $total);

            $this->paypal->businessPay();
        } catch (Expception $e)
        {

            $this->header = $e->getCode();

            $this->message = $e->getMessage();
        }
    }

    public function getAmount()
    {

        $session = $this->session;

        $summed = $session->userdata('pay');
        
       
        if (empty($summed))
        {

            $summed = 0;


            if ((bool) $session->userdata('bump') == true)
            {

               $packages = $this->model->select('app_packages','*', array('LOWER(type)'=>'e', 'LOWER(name)'=>'bumpup ads'), null, 1);
                
                $summed += $packages->price*$packages->length;
            }

            if ((bool) $session->userdata('top') == true)
            {

                $packages = $this->model->select('app_packages','*', array('LOWER(type)'=>'e', 'LOWER(name)'=>'top ads'), null, 1);
                
                $summed += $packages->price*$packages->length;
            }

            if ((bool) $session->userdata('highlight') == true)
            {

                $packages = $this->model->select('app_packages','*', array('LOWER(type)'=>'e', 'LOWER(name)'=>'highlight ads'), null, 1);
                
                $summed += $packages->price*$packages->length;
            }

            if ((bool) $session->userdata('urgent') == true)
            {

                $packages = $this->model->select('app_packages','*', array('LOWER(type)'=>'e', 'LOWER(name)'=>'urgent ads'), null, 1);
                
                $summed += $packages->price*$packages->length;
            }

            if ((bool) $session->userdata('home') == true)
            {

                $packages = $this->model->select('app_packages','*', array('LOWER(type)'=>'e', 'LOWER(name)'=>'home ads'), null, 1);
                
                $summed += $packages->price*$packages->length;
            }
        }
        
        //echo $summed;
        
//        $summed = $summed*0.08594;
//        
       //$summed = round($summed, 2);
        
        $summed = sprintf('%0.2f', $summed); 
        
       if ($session->userdata('package_name') != null)
        {
            $package_price = $this->model->select('app_packages', 'price, length', array('name'=>  $session->userdata('package_name')), null, 1);
                
            $summed += $package_price->price*$package_price->length;
        }
        
        return $summed;
    }

    public function success()
    {
        try
        {

            $this->session->set_userdata('payment', 'success');
            
           $_SESSION['anti_session'] = 0;

            $user = $this->model->select('business_members', 'sno', array('username' => $this->session->userdata('username')), NULL, 1);

            if (false == $user)
            {
                $this->header('login');

                return false;
            }

            /*
             * Package insert
             */
//            if ($this->session->userdata('package') != false)
//            {
//                $this->model->insert('transaction_info', array(
//                    'payment_method' => 'paypal',
//                    'bid' => $user->sno,
//                    'gross_amount' => $this->parsePackage($this->session->userdata('package')),
//                    'received_amount' => $this->parsePackage($this->session->userdata('package')),
//                    'payment_status' => 'R')
//                );
//            }
            
            $this->session->set_userdata('paymethod','paypal');
            
            $this->header('dashboard');
        } catch (Exception $e)
        {

            $this->header = $e->getCode();

            $this->message = $e->getMessage();
        }
    }

    public function cancel()
    {
        try
        {
            
            $_SESSION['anti_session'] = 1;
            
            $this->session->set_userdata('payment', 'cancel');

            /*
             * Package insert
             */
            if ($this->session->userdata('package') != false)
            {
                $this->model->insert('transaction_info', array(
                    'payment_method' => 'paypal',
                    'bid' => $user->sno,
                    'gross_amount' => $this->parsePackage($this->session->userdata('package')),
                    'received_amount' => $this->parsePackage($this->session->userdata('package')),
                    'payment_status' => 'C')
                );
            }
            
            $this->session->set_userdata('paymethod','paypal');

            $this->header('dashboard');
        } catch (Exception $e)
        {

            $this->header = $e->getCode();

            $this->message = $e->getMessage();
        }
    }

    private function parsePackage($name)
    {
        $pkg = $this->model->select('app_packages', 'price', array('LOWER(name)' => strtolower($name)), NULL, 1);

        if (false == $pkg)
        {
            /*
             * Currently static, coz still not sure where currency price will be displayed
             */
            return 339;
        }

        return $pkg->price;
    }

}
