<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : payments.php
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

        if (isset($this->model))
        {

            unset($this->model);
        }

        $this->load->model('common/common', 'model');

        $this->load->controller('LoginVerify', 'common/verification/login')->login();
    }

    public function enter()
    {
        try
        {
            $this->data['title'] = $this->title('Payment', 'log');

            $this->root = 'business/main';

            $this->page = 'business/payments';

            $this->data['class'] = 'payments';

            $user = $this->model->select('business_members', 'sno', array('username' => $this->session->userdata('username')), NULL, 1);

            if (false == $user)
            {
                throw new Exception('User does not exist.', '900');
            }

            $log = $this->model->select('transaction_info', '*', array('bid ' => $user->sno), array('pay_time' => 'desc'));

            if ($log != false)
            {
                $this->data['log'] = $log;
            }

            $this->response();
        } catch (Exception $e)
        {
            show_error($e->getMessage(), $e->getCode());
        }
    }

}
