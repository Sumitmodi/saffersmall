<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : step5.php
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

class Step5 extends CI_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->library('session');

        $this->load->model('common/common', 'm');
    }

    public function manage() {
        try {

            $this->data['title'] = $this->title('Place AD', 'Step 5');
            
            $this->data['class'] = 'placead';

            $user = $this->m->select('business_members', 'sno', array('username' => $this->session->userdata('username')), NULL, 1);

            if (false == $user) {

                $this->header('register');

                return false;
            }

            /*
             * Check if the user has already selected a package.
             */

            $pkg = $this->m->select('business_packages', '*', array('bid' => $user->sno), NULL, 1);

            /*
             * If not the user needs to select a package for his package.
             */

            if (false == $pkg) {

                $selectPackage = true;
            } else {

                /*
                 * If user has selected a package, check if it has expired or not.
                 */

                $d1 = new DateTime(date('Y/m/d'));

                $d2 = new DateTime(date('Y/m/d', strtotime($pkg->date_expire)));

                $gap = date_diff($d1, $d2, FALSE);

                if (($gap->y > 0 || $gap->m > 0 || $gap->d > 0) && $gap->invert == 1) {

                    /*
                     * Package has expired
                     */

                    $selectPackage = true;
                } else {

                    /*
                     * Package is still alive
                     */

                    $selectPackage = false;
                }
            }
            
            if(isset($this->unseen_notifications)){
                
                $this->data['unseen_notifications'] = $this->unseen_notifications;
            }
            
            else $this->data['unseen_notifications'] = null;

            if ($selectPackage) {
                
                $packages = $this->model->select('app_packages','*', array('LOWER(type)'=>'p'));
                
                $this->data['packages'] = $packages;

                $this->page = 'placead/step4';
            } else {

                $this->header('dashboard/placead?_=6');
            }
            
            $this->header = 200;
            $this->message = 'Your data saved.';
        } catch (Exception $e) {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();

            $this->page = 'placead/step1';
        }
    }

}
