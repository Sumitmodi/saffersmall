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

class Active extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->root = 'admin/main';

        $this->load->model('admin/adminmodel', 'adminm');
    }

    public function active_user($u_id)
    {
        try
        {
            $result = $this->adminm->active_business($u_id);
            if ($result == TRUE)
            {
                $this->header('admin/sfi_control');
            } else
            {
                throw new Exception('Some error occured.', '900');
            }
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }

    public function block_user($u_id)
    {
        try
        {
            $result = $this->adminm->block_business($u_id);
            if ($result == TRUE)
            {
                $uri = $uri = "http://localhost/saffersmall/admin/sfi_control";
                redirect($uri);
            } else
                echo "error";
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }

    public function inactive_user($u_id)
    {
        try
        { //echo"here";
            //$p_id = $this->input->get('id', TRUE);
            //echo $p_id;
            $result = $this->adminm->inactive_business($u_id);
            if ($result == TRUE)
            {
                $uri = $uri = "http://localhost/saffersmall/admin/sfi_control";
                redirect($uri);
            } else
                echo "error";
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }

    public function user_ads($u_id)
    {
        try
        {
            $ads = $this->model1->select('business_ads', '*', array('status' => 'W'));

            if (true == $ads)
            {
                $items = array();
                foreach ($ads as $ad)
                {
                    $lists = $this->model1->select('ad_features', array('list_name', 'list_value', 'date_added'), array('ad_id' => $ad['sno']), array('date_added' => 'asc'));
                    $post_man = $this->model1->select('business_members', array('business_name', 'person_name'), array('sno' => $ad['bid']));
                    $items[] = array(
                        'lists' => $lists,
                        'item' => $ad,
                        'post_man' => $post_man
                    );
                }

                $this->data['result'] = $items;
            }

            $ads = $this->model1->select('business_ads', '*', array('bid' => $u_id));
            if (true == $ads)
            {
                $items = array();
                foreach ($ads as $ad)
                {
                    $lists = $this->model1->select('ad_features', array('list_name', 'list_value', 'date_added'), array('ad_id' => $ad['sno']), array('date_added' => 'asc'));
                    $post_man = $this->model1->select('business_members', array('business_name', 'person_name'), array('sno' => $u_id));
                    $items[] = array(
                        'lists' => $lists,
                        'item' => $ad,
                        'post_man' => $post_man
                    );
                }

                $this->data['result'] = $items;
            } else
            {
                $this->data['result'] = NULL;
            }

            $this->data['title'] = $this->title('Admin ', 'Logged in');
            
            $this->page = 'admin/dashboard/dashboard';
            
            $this->header = 200;
            
            $this->message = 'Step :: first loaded successfully.';
            
            $this->root = 'admin/main';
            
            $this->response();
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }

}
