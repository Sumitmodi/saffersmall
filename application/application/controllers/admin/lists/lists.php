<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : lists.php
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

class Lists extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->root = 'admin/main';
        $this->load->model('admin/adminmodel', 'model');
    }

    public function enter() {
        try {

            /*
             * Check if the person is logged in and is admin or not.
             * Leave it a TODO:
             */

            /*
             * Get the target item
             */
            $target = $this->input->get('target', TRUE);

            $this->target = !empty($target) ? strtolower($target) : 'dashboard';

            /*
             * Process the target
             */
            if (method_exists($this, $this->target)) {

                $this->{$this->target}();
            } else {

                show_404();
            }

            /*
             * Show response
             */
            if ($this->input->is_ajax_request()) {
                /*
                 * Load the required page only defined by target.
                 */
                $this->ajaxResponse();
            } else {
                /*
                 * Load the default page and include the 
                 * page defined by target in the default page.
                 */
                $this->normalResponse();
            }
        } catch (Exception $e) {
            $this->header = $e->getCode();

            $this->message = $e->getMessage();
        }
    }
    
    private function dashboard() {
        try {
            
            $this->data['title'] = 'Lists :: Dashboard';
            
            $cats = $this->model->select('app_category','sno,category_name',NULL,array('date_added'=>'desc'));
            
            if(false == $cats){
                throw new Exception('Categories have not been added on the system.','900');
            }
            
            $lists = $this->model->select('app_cat_items','sno,cat_id,item_name',NULL,array('date_added'=>'desc'));
           
            if(false == $lists){
                throw new Exception('Lists have not been added on the system.','900');
            }
            
            $this->data['lists'] = $lists;
            
            $listed = array();
            
            foreach($cats as $cat){
                $list = $this->model->select('app_cat_items','sno,item_name',array('cat_id'=>$cat['sno']),array('date_added'=>'desc'));
                $listed[$cat['sno']] = array(
                    'lists' =>  false == $list ? NULL : $lists,
                    'name'  =>  $cat['category_name']
                );
            }
            
            $this->data['listed'] = $listed;
            
            $this->data['cats'] = $cats;
            
            $this->header = 200;
            $this->message = 'Lists loaded successfully.';
            
            $this->page = 'admin/lists/dashboard';
            
        } catch (Exception $e) {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
            
            $this->page = 'admin/lists/dashboard';
        }
    }

    private function add() {
        try {
            $data = $this->input->post(NULL, TRUE);

            $this->data['title'] = 'Lists :: Add';

            $cats = $this->model->select('app_category', 'category_name,sno');

            if (false == $cats) {
                throw new Exception('Categories do not exist on the system. Please create at least one category first.', '900');
            }

            $this->data['cats'] = $cats;

            if (empty($data)) {
                $this->header = '200';
                $this->message = 'Saffersmall registration is now active.';

                $this->page = 'admin/lists/add';

                return;
            }


            $cats = $data['cats'];
            
            $lists = $data['list_name'];

            if (empty($cats)) {
                throw new Exception('Please select at least one category.', '900');
            }

            if (empty($lists)) {
                throw new Exception('No list has been created.', '900');
            }

            $added = array();
            
            foreach ($cats as $c) {
                $cat = $this->model->select('app_category', 'category_name', array('sno' => $c), NULL, '1');
                
                if (false == $cat) {
                    continue;
                }
                
                foreach ($lists as $l):
                    $exist = $this->model->select('app_cat_items', 'sno', array('cat_id' => $c, 'item_name' => $l), null, '1');
                
                    if (false != $exist):
                        continue;
                    endif;
                    
                    $add = $this->model->insert('app_cat_items', array('cat_id' => $c, 'item_name' => $l));
                    
                    if (false != $add):
                        $added[] = $l . ' added in ' . $cat->category_name . ' category';
                    endif;
                    
                endforeach;
            }

            if (sizeof($added) == 0) {
                throw new Exception('For some reason, no list items were created.', '900');
            }

            $this->page = 'admin/lists/add';

            $this->header = 200;
            $this->message = 'Lists created successfully.';

            $this->data['added'] = $added;
        } catch (Exception $e) {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();

            $this->page = 'admin/lists/add';
        }
    }

}
