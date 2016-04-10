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

class Add_admins extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->root = 'admin/main';

        $this->load->model('common/common', 'model1');
    }

    public function add_admins()
    { 
        try
        {
            
            $data = $this->input->post(NULL, TRUE);
            
            if(empty($data)){
                
                $this->page = 'admin/admins/create';

                $this->header = 200;

                $this->message = ' Add Admin';
                                
                $this->data['result']=NULL;

                $this->response();
                
                return;
            }
               
            $exist = $this->model->select('app_admin', 'username', array('username' => $data['username']), NULL, '1');

            if ($exist == false)
            {
            
                $posted_data = array(
                    'name'=>$data['name'],
                        'username'=> $data['username'],
                        'password'=> md5($data['password']),
                        'email'=> $data['email']
                        
                );
                
                $insert = $this->model1->insert('app_admin',$posted_data);
                
                if(TRUE == $insert){
                    
                    $this->message = "Your profile has been inserted successfully.";
                    
                    $new_data = $this->model->select('app_admin', '*', array('username' => $data['username']), NULL, '1');
                    
                    $this->data['result']=NULL;
                }
                
                else
                    throw new Exception('Some error occurred while updating profile.', '900');
            }
            
             else
            {
                throw new Exception('Admin <i>' . $data['username'] . '</i> already exists.', '900');
            }
            
            
                $this->page = 'admin/admins/show_admins';

                $this->header = 200;

                $this->message = 'Admin Profile';

                $this->response();
            
            
        } catch (Exception $e)
        { 
          
            $this->header = $e->getCode();
            
            $this->message = $e->getMessage();
            
            $this->page = 'admin/admins/create';
            
            $this->root = 'admin/main';
            
            $this->response();
        }
    }

   
}
