<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : step2.php
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

class Step2 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        unset($this->model);
        
        $this->load->model('common/common', 'model');
    }

    public function manage() {
        try {
            $data = $this->input->post(NULL, TRUE);
            
            $this->data['class'] = 'placead';

            if (empty($data)) {
                throw new Exception('Some data was expected with this request. Sorry that we cannot proceed further.', '900');
            }

            if (empty($data['name'])) {
                throw new Exception('Name of the product must be specified.', '900');
            }

            if (empty($data['category'])) {
                throw new Exception('Please select a category for your product.', '900');
            }

            $cat = $this->model->select('app_category', 'category_name,sno', array('category_name' => $data['category']), NULL, 1);
            
            if (false === $cat) {
                throw new Exception('Not a valid category for your product was selected.', '900');
            }
            
            $this->session->set_userdata('category',$cat->sno);
            
            $lists = $this->model->select('app_cat_items', 'item_name', array('cat_id' => $cat->sno));

            $list = array();

            if ($lists != false) {

                foreach ($lists as $l):

                    $list[] = $l['item_name'];

                endforeach;
            }

            $defaults = $this->model->select('app_cat_items', 'item_name', array('cat_id' => 0));

            if (false == $defaults) {
                $defaults = array('price', 'description', 'website', 'facebook', 'google', 'youtube', 'twitter','pininterest','instagram');
            }

            $required = array('price', 'description');

            $lists = array();

            $lists = array_merge($list, $defaults);
            
            $feats = array();
            
            foreach ($lists as $list) {
                $list = (object) $list;

                if (in_array($list->scalar, $required)) {

                    if (!isset($data[$list->scalar]) || empty($data[$list->scalar])) {

                        throw new Exception(ucfirst($list->scalar) . ' is required.', '900');
                    }
                }

                if (isset($data[$list->scalar]) && !empty($data[$list->scalar])) {
                    
                    $feats[$list->scalar] = $data[$list->scalar];
                    
                    //$this->session->set_userdata(strtolower($list->scalar), $data[$list->scalar]);
                }
            }
            
            if(count($feats) > 0){
                
                $this->session->set_userdata('features',$feats);
            }

            $this->data['title'] = $this->title('Place AD', 'Step 2');

            $this->session->set_userdata('product', $data['name']);

            $this->page = 'placead/step2';

            $this->header = 200;
            
            $this->message = 'Your data saved.';
        } catch (Exception $e) {
            $this->header = $e->getCode();
            
            $this->message = $e->getMessage();

            $this->data['title'] = $this->title('Place AD', 'Step 1');

            $this->page = 'placead/step1';
        }
    }

    public function test() {
        try {
            
            if(false){
                throw new Exception('Something went wrong!','900');
            }
            
        } catch (Exception $e) {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }

}
