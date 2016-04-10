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

class Active_business extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->root = 'admin/main';

        $this->load->model('common/common', 'model1');
    }

    public function active_business()
    {
        try
        {
            $business = $this->model1->select('business_members', '*', array('status' => 'A'));
            
            if (true == $business)
            {
                $this->data['result'] = $business;
            } else
            {
                $this->data['result'] = NULL;
            }

            $this->data['title'] = $this->title('SFI ', 'Active');
            
            $this->page = 'admin/sfi_control/sfi_control';
            
            $this->header = 200;
            
            $this->message = 'Active SFI Members';
            
            $this->root = 'admin/main';
            
            $this->response();
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }

}
