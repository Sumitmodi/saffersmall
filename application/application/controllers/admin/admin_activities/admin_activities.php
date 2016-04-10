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

class Admin_activities extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->root = 'admin/main';

        $this->load->model('common/common', 'model1');
    }

    public function enter()
    {
        try
        {

            $data1 = $this->input->post('radios');

            if ($data1 != "")
            {
                $current_date = date('Y-m-d H:i:s');

                if ($data1 == "day")
                {
                    $new_date = Date('Y-m-d H:i:s', strtotime("-1 days"));
                } else if ($data1 == "week")
                {
                    $new_date = Date('Y-m-d H:i:s', strtotime("-7 days"));
                } else if ($data1 == "month")
                {
                    $new_date = Date('Y-m-d H:i:s', strtotime("-30 days"));
                }

                if ($data1 == "all")
                {
                    $where_con = array(
                        'date_added <=' => Date('Y-m-d H:i:s', strtotime("+1 days"))
                    );
                } else
                {
                    $where_con = array(
                        'date_added >=' => $new_date,
                        'date_added <=' => $current_date
                    );
                }

                $clear = $this->model1->delete('admin_activity', $where_con);

                $activities = $this->model1->select('admin_activity', '*', NULL, array('date_added' => 'asc'));
                if (true == $activities)
                {

                    $this->data['result'] = $activities;
                } else
                    $this->data['result'] = NULL;


                $this->page = 'admin/admin_activities/admin_activities';

                $this->header = 200;

                $this->message = 'Admin Actibvity Log.';

                $this->root = 'admin/main';

                $this->response();
                return;
            }
            $activities = $this->model1->select('admin_activity', '*', NULL, array('date_added' => 'asc'));
            if (true == $activities)
            {
                $this->data['result'] = $activities;
            } else
            {
                $this->data['result'] = NULL;
            }

            $this->page = 'admin/admin_activities/admin_activities';
            
            $this->header = 200;
            
            $this->message = 'Admin Activity Log';
            
            $this->root = 'admin/main';
            
            $this->response();
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }

}
