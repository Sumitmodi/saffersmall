<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : businessmodel.php
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

class BusinessModel extends CI_Model {

    public function __construct() {

        parent::__construct();

        $this->activity = $this->load->controller('Activity', 'common/activity/activity');

        $this->activity->set('table', 'user_activity');
    }

    public function insert($table, $insert) {

        return $this->db->insert($table, $insert);
    }

    public function lastInsert() {

        return $this->db->insert_id();
    }

    public function inactive_ads($user, $name) {

        $name = str_replace('-', ' ', $name);

        $username = $this->session->userdata('username');

        if ($username == $user) {

            $user_id = $this->model->select('business_members', 'sno', array('username' => $user), NULL, 1);

            $data = array(
                'status' => 'I'
            );

            $where_data = array(
                'name' => $name,
                'bid' => $user_id->sno
            );

            $this->db->where($where_data);

            $result = $this->db->update('business_ads', $data);

            if ($result) {

                $activity = array(
                    'bid' => $user_id->sno,
                    'activity' => "The &quot;{$name}&quot; has been inactivated by &quot;{$user}&quot;."
                );

                $this->activity->set('activity', $activity);

                $this->activity->log();

                return TRUE;
            } else
                return FALSE;
        }

        else {
            return false;
        }
    }
    
    public function active_ads($user, $name) {

        $name = str_replace('-', ' ', $name);

        $username = $this->session->userdata('username');

        if ($username == $user) {

            $user_id = $this->model->select('business_members', 'sno', array('username' => $user), NULL, 1);

            $data = array(
                'status' => 'A'
            );

            $where_data = array(
                'name' => $name,
                'bid' => $user_id->sno
            );

            $this->db->where($where_data);

            $result = $this->db->update('business_ads', $data);

            if ($result) {

                $activity = array(
                    'bid' => $user_id->sno,
                    'activity' => "The &quot;{$name}&quot; has been activated by &quot;{$user}&quot;."
                );

                $this->activity->set('activity', $activity);

                $this->activity->log();

                return TRUE;
            } else
                return FALSE;
        }

        else {
            return false;
        }
    }

    public function remove_ads($user, $name) {

        $name = str_replace('-', ' ', $name);

        $username = $this->session->userdata('username');

        if ($username == $user) {

            $user_id = $this->model->select('business_members', 'sno', array('username' => $user), NULL, 1);
            
            $ads = $this->model->select('business_ads','sno', array('name'=>$name), NULL, 1);

            $where_data = array(
                'name' => $name,
                'bid' => $user_id->sno
            );

            $this->db->where($where_data);

            $result = $this->db->delete('business_ads');
            
            
            
            $this->db->delete('ad_extra', array('ad_id'=>$ads->sno));
            
            $this->db->delete('ad_counter', array('ad_id'=>$ads->sno));
            
            $this->db->delete('ad_favourites', array('ad_id'=>$ads->sno));
            
            $this->db->delete('transaction_info', array('ad_id'=>$ads->sno));

            if ($result) {
                $activity = array(
                    'bid' => $user_id->sno,
                    'activity' => "The &quot;{$name}&quot; has been removed by &quot;{$user}&quot;."
                );

                $this->activity->set('activity', $activity);

                $this->activity->log();

                return TRUE;
            } else
                return FALSE;
        }
        else {
            return false;
        }
    }

}
