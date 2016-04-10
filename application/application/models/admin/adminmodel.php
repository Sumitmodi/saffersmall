<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : adminmodel.php
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

class AdminModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default',TRUE);
        
        $this->activity = $this->load->controller('Activity', 'common/activity/activity');

        $this->activity->set('table', 'admin_activity');
        
    }

    public function insert($table, $insert) {
        return $this->db->insert($table, $insert);
    }
    
    public function validate_user($username,$password){
        $this->db->where(array('username'=>$username,'password'=>$password));
        $result = $this->db->get('app_admin');
       //echo '<pre>';
        //print_r($result);
        if($result->num_rows>0)
            return true;
        else return false;
    }
    
    public function select_ads(){
        $this->db->where(array('status'=>'A'));
        $result = $this->db->get('business_ads');
        echo '<pre>';
        print_r($result);
        if($result->num_rows>0){
            return $result;
        }
        else return NULL;
            
    }
    
    public function active_ads($id){
        //$this->load->model('admin/adminmodel','adminm');
        $ads = $this->model->select('business_ads', 'name', array('sno'=>$id), NULL, 1);
        $admin = $this->model->select('app_admin', 'sno, name', array('username'=>$this->session->userdata('admin_username')), NULL, 1);
            
        $data = array(
            'status'=>'A'
        );
        $where_data = array(
            'sno'=>$id
        );
        $this->db->where($where_data);
        $result = $this->db->update('business_ads',$data);
        if($result){
            $activity = array(
                'aid' => $admin->sno,
                'activity' => "The &quot;{$ads->name}&quot; has been approved by &quot;{$admin->name}&quot;."
            );
                
            $notification = array(
                'ad_id'=>$id,
                'action'=>"The &quot;{$ads->name}&quot; has been approved by &quot;{$admin->name}&quot;.",
                        'notify'=>0
            );
            $this->insert('notification',$notification);
           
            $this->activity->set('activity', $activity);
            $this->activity->log();

        return TRUE;
        }
        else return FALSE;
    }
    
    public function inactive_ads($id){
        $ads = $this->model->select('business_ads', 'name', array('sno'=>$id), NULL, 1);
        $admin = $this->model->select('app_admin', 'sno, name', array('username'=>$this->session->userdata('admin_username')), NULL, 1);
        
        $data = array(
            'status'=>'W'
        );
        $where_data = array(
            'sno'=>$id
        );
        $this->db->where($where_data);
        $result = $this->db->update('business_ads',$data);
        if($result){
            $activity = array(
                'aid' => $admin->sno,
                'activity' => "The &quot;{$ads->name}&quot; has been inactivated by &quot;{$admin->name}&quot;."
            );

            $this->activity->set('activity', $activity);
            $this->activity->log();

            return TRUE;
        }
        else return FALSE;
    }
    
     public function disapprove_ads($id){
        $ads = $this->model->select('business_ads', 'name', array('sno'=>$id), NULL, 1);
        $admin = $this->model->select('app_admin', 'sno, name', array('username'=>$this->session->userdata('admin_username')), NULL, 1);
        
         $data = array(
            'status'=>'D'
        );
        $where_data = array(
            'sno'=>$id
        );
        $this->db->where($where_data);
        $result = $this->db->update('business_ads',$data);
        if($result){
                $activity = array(
                'aid' => $admin->sno,
                'activity' => "The &quot;{$ads->name}&quot; has been disapproved by &quot;{$admin->name}&quot;."
            );

            $this->activity->set('activity', $activity);
            $this->activity->log();

            return TRUE;
        }
        else return FALSE;
    }
    
    public function active_user($id){
        $user = $this->model->select('app_users', 'name', array('sno'=>$id), NULL, 1);
        $admin = $this->model->select('app_admin', 'sno, name', array('username'=>$this->session->userdata('admin_username')), NULL, 1);
        
        $data = array(
            'status'=>'A'
        );
        $where_data = array(
            'sno'=>$id
        );
        $this->db->where($where_data);
        $result = $this->db->update('app_users',$data);
        if($result){
            $activity = array(
                'aid' => $admin->sno,
                'activity' => "The &quot;{$user->name}&quot; has been activated by &quot;{$admin->name}&quot;."
            );

            $this->activity->set('activity', $activity);
            $this->activity->log();

            return TRUE;
        }
        else return FALSE;
    }

    public function block_user($id){
        $user = $this->model->select('app_users', 'name', array('sno'=>$id), NULL, 1);
        $admin = $this->model->select('app_admin', 'sno, name', array('username'=>$this->session->userdata('admin_username')), NULL, 1);
        
        $data = array(
            'status'=>'B'
        );
        $where_data = array(
            'sno'=>$id
        );
        $this->db->where($where_data);
        $result = $this->db->update('app_users',$data);
        if($result){
            $activity = array(
                'aid' => $admin->sno,
                'activity' => "The &quot;{$user->name}&quot; has been blocked by &quot;{$admin->name}&quot;."
            );

            $this->activity->set('activity', $activity);
            $this->activity->log();

            return TRUE;
        }
        else return FALSE;
    }
    
    public function inactive_user($id){
        $user = $this->model->select('app_users', 'name', array('sno'=>$id), NULL, 1);
        $admin = $this->model->select('app_admin', 'sno, name', array('username'=>$this->session->userdata('admin_username')), NULL, 1);
        
        $data = array(
            'status'=>'W'
        );
        $where_data = array(
            'sno'=>$id
        );
        $this->db->where($where_data);
        $result = $this->db->update('app_users',$data);
        if($result){
            $activity = array(
                'aid' => $admin->sno,
                'activity' => "The &quot;{$user->name}&quot; has been inactivated by &quot;{$admin->name}&quot;."
            );

            $this->activity->set('activity', $activity);
            $this->activity->log();

            return TRUE;
        }
        else return FALSE;
    }
    
    public function active_business($id){
        $user = $this->model->select('business_members', 'name', array('sno'=>$id), NULL, 1);
        $admin = $this->model->select('app_admin', 'sno, name', array('username'=>$this->session->userdata('admin_username')), NULL, 1);
        
        $data = array(
            'status'=>'A'
        );
        $where_data = array(
            'sno'=>$id
        );
        $this->db->where($where_data);
        $result = $this->db->update('business_members',$data);
        if($result){
            $activity = array(
                'aid' => $admin->sno,
                'activity' => "The &quot;{$user->name}&quot; has been activated by &quot;{$admin->name}&quot;."
            );

            $this->activity->set('activity', $activity);
            $this->activity->log();

            return TRUE;
        }
        else return FALSE;
    }

    public function block_business($id){
        $user = $this->model->select('business_members', 'name', array('sno'=>$id), NULL, 1);
        $admin = $this->model->select('app_admin', 'sno, name', array('username'=>$this->session->userdata('admin_username')), NULL, 1);
        
        $data = array(
            'status'=>'B'
        );
        $where_data = array(
            'sno'=>$id
        );
        $this->db->where($where_data);
        $result = $this->db->update('business_members',$data);
        if($result){
            $activity = array(
                'aid' => $admin->sno,
                'activity' => "The &quot;{$user->name}&quot; has been blocked by &quot;{$admin->name}&quot;."
            );

            $this->activity->set('activity', $activity);
            $this->activity->log();

            return TRUE;
        }
        else return FALSE;
    }
    
    public function inactive_business($id){
        $user = $this->model->select('business_members', 'name', array('sno'=>$id), NULL, 1);
        $admin = $this->model->select('app_admin', 'sno, name', array('username'=>$this->session->userdata('admin_username')), NULL, 1);
        
        $data = array(
            'status'=>'W'
        );
        $where_data = array(
            'sno'=>$id
        );
        $this->db->where($where_data);
        $result = $this->db->update('business_members',$data);
        if($result){
            $activity = array(
                'aid' => $admin->sno,
                'activity' => "The &quot;{$user->name}&quot; has been inactivated by &quot;{$admin->name}&quot;."
            );

            $this->activity->set('activity', $activity);
            $this->activity->log();

            return TRUE;
        }
        else return FALSE;
    }
}
