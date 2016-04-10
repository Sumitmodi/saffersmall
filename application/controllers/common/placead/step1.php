<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : step1.php
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

class Step1 extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (empty($this->model)) {
            $this->load->model('common/common', 'model');
        }
    }

    public function manage() {
        try {

            if(isset($this->unseen_notifications)){
                
                $this->data['unseen_notifications'] = $this->unseen_notifications;
            }
            
            else $this->data['unseen_notifications'] = null;

            
            $this->data['title'] = $this->title('Place AD', 'Step 1');

            $this->data['class'] = 'placead';

            $cats = $this->model->select('app_category', 'category_name,sno', NULL, array('date_added' => 'desc'));

            if (false == $cats) {
                throw new Exception('Product Categories have not been added on the system. Please visit next time.', '900');
            }

            $default = $this->model->select('app_cat_items', 'item_name,sno', array('cat_id' => '0'), array('item_name' => 'asc'));
            if (false == $default) {
                $default = array('price', 'description', 'website', 'facebook', 'google', 'youtube', 'twitter');
            }


            $items = array();
            
            $list = array();
            
            foreach ($cats as $cat) {
                $lists = $this->model->select('app_cat_items', 'item_name', array('cat_id' => $cat['sno']), array('item_name' => 'asc'));

                if (false == $lists) {

                    //$list = $default;
                } else {
                    $list = array();
                    foreach ($lists as $l) {

                        $l = (object) $l;

                        $list[] = ltrim($l->item_name,' ');
                    }

                    /* foreach ($default as $d) {
                      $list[] = $d;
                      } */
                }

                if (!empty($list)) {
                    sort($list);
                }

                $items[] = array(
                    'cat' => $cat['category_name'],
                    'lists' => $list
                );
            }

            $this->page = 'placead/step1';

            $this->data['items'] = json_encode($items);

            foreach ($cats as $c) {
                $temp[] = ucfirst($c['category_name']);
            }


            $this->data['cats'] = json_encode($temp);

            $this->header = 200;
            $this->message = 'Step :: first loaded successfully.';
        } catch (Exception $e) {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }

}
