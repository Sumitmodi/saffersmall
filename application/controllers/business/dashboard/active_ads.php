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

class Active_ads extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

         $this->root = 'business/main';

        $this->load->model('common/common', 'model1');
    }

    public function enter()
    {
        try
        {
            
            if (isset($this->unseen_notifications)) {

                $this->data['unseen_notifications'] = $this->unseen_notifications;
            } else
                $this->data['unseen_notifications'] = null;
            
            $this->data['title'] = $this->title('Active Ads', 'Dashboard');
            
            $user = $this->model->select('business_members', 'sno,person_name', array('username' => $this->session->userdata('username')), NULL, 1);

            if (false == $user) {

                $this->header('register');

                return false;
            }

            $ads = $this->model->select('business_ads', '*', array('bid' => $user->sno, 'LOWER(status)'=>'a'), array('date_added' => 'desc'));

            if ($ads != false) {

                foreach ($ads as $k => $ad) {

                    $imgs = explode(',', $ad['images']);

                    $img = $imgs[rand(0, count($imgs) - 1)];

                    unset($ads[$k]['images']);

                    $ads[$k]['image'] = 'products/images/' . $img;

                    $t = strtolower($ad['status']) == 'a' ? 'Active' :
                            (strtolower($ad['status']) == 'w' ? 'Waiting Approval' :
                                    (strtolower($ad['status']) == 'e' ? 'Expired' :
                                            (strtolower($ad['status']) == 'i' ? 'Inactive' :
                                                    'unknown')));

                    unset($ads[$k]['status']);

                    $ads[$k]['status'] = $t;

                    $ad_user = $this->model->select('business_members', 'sno,username', array('sno' => $ad['bid']), NULL, 1);

                    $ads[$k]['username'] = $ad_user->username;

                    $props = $this->model->select('ad_features', '*', array('ad_id' => $ad['sno']));

                    if (false == $props) {

                        continue;
                    }

                    $ads[$k]['props'] = $props;
                }

                $this->data['ads'] = $ads;
            }
            
            $this->data['ad_list'] = true;
            
            $this->page = 'business/ads';

            $this->message = 'Welcome again, ' . $user->person_name;

            $this->response();
        } catch (Exception $e)
        {
            $this->header = $e->getCode();

            $this->message = $e->getMessage();

           
        }
    }

}
