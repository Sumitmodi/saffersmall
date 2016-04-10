<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : ads.php
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

/*
 * Class to return ads by a user
 */

class Ads extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function enter()
    {
        try
        {
            $username = $this->uri->segment(2);

            if (false == $username)
            {
                throw new Exception('User is not defined.', 400);
            }

            $user = $this->model->select('business_members', '*', array('username' => $username), NULL, 1);

            if (false == $user)
            {
                throw new Exception('The user you reuested does not exist.', '400');
            }

            $ads = $this->model->select('business_ads', '*', array('bid' => $user->sno, 'LOWER(status)' => 'a'));

            /*
             * Test whether the request has been made from the ui or dashboard
             */

            $is = $this->input->get('dashboard', false);

            if ($is != false && empty($is))
            {
                /*
                 * Request from dashboard
                 */
                $this->dashboard($user, $ads);

                $this->response();
            } else
            {
                /*
                 * Request from the app ui.
                 * 
                 * The rest of request will be handled by this function itself.
                 */
                $this->appui($user, $ads);
            }
        } catch (Exception $e)
        {
            show_error($e->getMessage(), $e->getCode());
        }
    }

    /*
     * APP ui requests
     */

    private function appui($user, $ads)
    {      
        $control = $this->load->controller('Search', 'ui/search/search');

        if (!$control)
        {
            show_404();

            return;
        }

        $control->enter($user, $ads);
    }
    
    /*
     * Requests from business dashboard
     */
    private function dashboard($user,$ads)
    {
        
    }

}
