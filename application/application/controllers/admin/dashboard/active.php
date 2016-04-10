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

class Active extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->root = 'admin/main';
        $this->load->model('admin/adminmodel','adminm');
        $this->load->model('common/common', 'model1');
        
    }

    public function active_ad($p_id) { 
        try { //echo"here";
            //$p_id = $this->input->get('id', TRUE);
             //echo $p_id;
            $target = $this->session->userdata('new_target');
            // $target; //return;
             $result = $this->adminm->active_ads($p_id);
             if($result == TRUE){
                 if($target == 'block_ads')
                 $uri = "http://localhost/saffersmall/admin/dashboard/block_ads";
                 else if($target == 'active_ads')
                 $uri = "http://localhost/saffersmall/admin/dashboard/active_ads";
                 else
                 $uri = "http://localhost/saffersmall/admin/dashboard";
                 
                 
                 redirect ($uri);
             }
             else echo "error";
        } catch (Exception $e) {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }
    
    public function inactive_ad($p_id){
        try { //echo"here";
            //$p_id = $this->input->get('id', TRUE);
             //echo $p_id;
            $target = $this->session->userdata('new_target');
            //echo $target;
             $result = $this->adminm->inactive_ads($p_id);
             if($result == TRUE){
                 if($target == 'block_ads')
                 $uri = "http://localhost/saffersmall/admin/dashboard/block_ads";
                 else if($target == 'active_ads')
                 $uri = "http://localhost/saffersmall/admin/dashboard/active_ads";
                 else
                 $uri = "http://localhost/saffersmall/admin/dashboard";
                 
                 redirect ($uri);
             }
             else echo "error";
        } catch (Exception $e) {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }
    
    public function disapprove_ad($p_id){
        try { //echo"here";
            //$p_id = $this->input->get('id', TRUE);
             //echo $p_id;
            
            $ads = $this->model->select('business_ads', 'name', array('sno'=>$p_id), NULL, 1);
            $admin = $this->model->select('app_admin', 'sno, name', array('username'=>$this->session->userdata('admin_username')), NULL, 1);
            $data1 = $this->input->post('suggestion');    
            $sug_val = array(
                'ad_id'=>$p_id,
                'suggestion'=>$data1,
                'action'=>"The &quot;{$ads->name}&quot; has been disapproved by &quot;{$admin->name}&quot;.",
                        'notify'=>0
            );
            $insert = $this->adminm->insert('notification',$sug_val);
            if ($insert == false) {
                    throw new Exception('Some error occurred while adding suggestion.', '900');
                }
                
            $target = $this->session->userdata('new_target');
             $result = $this->adminm->disapprove_ads($p_id);
             if($result == TRUE){
                 if($target == 'block_ads')
                 $uri = "http://localhost/saffersmall/admin/dashboard/block_ads";
                 else if($target == 'active_ads')
                 $uri = "http://localhost/saffersmall/admin/dashboard/active_ads";
                 else
                 $uri = "http://localhost/saffersmall/admin/dashboard";
                 
                 redirect ($uri);
             }
             else throw new Exception('can not disapprove.', '900');
        } catch (Exception $e) {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
            $this->page = 'admin/category/create';
                  
            $this->root = 'admin/main';
            $this->response();
        }
    }
    
    
}
