<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : ads.php
 * 
 *   Project : saffersmall
 */

/*
 *   <one line to give the program's name and a brief idea of what it does.>
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

class Ads extends CI_Controller {

    public function __construct() {

        parent::__construct();

        unset($this->model);

        $this->load->model('business/businessmodel', 'model');

        $this->load->library('session');

        $this->load->library('imageuploader');

        $this->root = 'business/main';

        /*
         * Lets save the activity log as TODO.
         */

        $this->activity = $this->load->controller('Activity', 'common/activity/activity');

        $this->activity->set('table', 'user_activity');
    }

    public function enter() {
        try {

            $this->data['unseen_notifications'] = $this->unseen_notifications;

            $action = $this->input->get('action');
            //echo $action;
            $id = null;

            $user = null;

            $name = null;

            if (!empty($action)) {

                $id = $this->input->get('id');

                $user = $this->input->get('user');

                $name = $this->input->get('name');

                if ($id != null)
                    $this->$action($id);

                if ($name != null && $user != null)
                    $this->$action($user, $name);

                if ($id == NULL && $user == NULL && $name == NULL)
                    $this->$action();

                return;
            }

            $this->login('business');

            $edit_extra = $this->session->userdata('edit_extra');

            $ad_id = $this->session->userdata('ad_id');

            if ($edit_extra == 1) {

                $this->edit_extra($ad_id);
            }

            $hasAdPlaced = $this->session->userdata('product');

            if ($hasAdPlaced != false) {

                $this->saveAd();
            }

            $this->data['title'] = $this->title('Ads', 'Dashboard');

            $this->data['class'] = 'dashboard';

            $user = $this->model->select('business_members', 'sno,person_name', array('username' => $this->session->userdata('username')), NULL, 1);

            if (false == $user) {

                $this->header('register');

                return false;
            }

            $ads = $this->model->select('business_ads', '*', array('bid' => $user->sno), array('date_added' => 'desc'));

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

            $this->page = 'business/ads';

            $this->message = 'Welcome again, ' . $user->person_name;

            $this->response();
        } catch (Exception $e) {
            $this->header = $e->getCode();
        }
    }

    /*
     * Save an AD created by the user.
     */

    private function saveAd() {
        /*
         * If a user did not pay, his/her ad wont be saved
         */

        if ($this->session->userdata('payment') != 'success') {
            /*
             * For testing lets ignore this by commenting out the return statement
             */
            //return false;
        }

        $user = $this->session->userdata('username');

        if (false == $user) {

            return;
        }

        $user = $this->model->select('business_members', 'sno', array('username' => $user), NULL, 1);

        if (false == $user) {

            return;
        }

        $product = array();

        $product['bid'] = $user->sno;

        $product['name'] = $this->session->userdata('product');

        $product['cat_id'] = $this->session->userdata('category');

        if ($this->session->userdata('country') != false) {

            $product['country'] = $this->session->userdata('country');
        }

        if ($this->session->userdata('state') != false) {

            $product['location'] = $this->session->userdata('state');
        }

        if ($this->session->userdata('city') != false) {

            $product['city'] = $this->session->userdata('city');
        }

        $feats = $this->session->userdata('features');

        $product['price'] = $feats['price'];

        unset($feats['price']);

        $product['description'] = $feats['description'];

        unset($feats['description']);

        $pkg = $this->model->select('app_packages', 'sno,length,price', array('LOWER(name)' => $this->session->userdata('package')), NULL, 1);

        /*
         * In case package was not found on the system. The default will be used.
         */
        if (false == $pkg) {
            $pkg = $this->model->select('app_packages', 'sno,length,price', array('LOWER(name)' => 'basic'), NULL, 1);
        }

        $product['package_id'] = $pkg->sno;

        if ($this->session->userdata('images') != false) {

            $product['images'] = $this->session->userdata('images');
        }

        if ($this->session->userdata('video') != false) {

            $product['video'] = $this->session->userdata('video');
        }

        $product['status'] = 'W';

        /*
         * Currently the ad will expire as soon as the package selected by a user expires.
         * 
         * But, later be changed to unlimited.
         */

        $product['expire_date'] = date('Y/m/d', strtotime('+' . $pkg->length . 'months'));

        $added = $this->model->insert('business_ads', $product);

        if ($added) {

            $lastId = $this->model->lastInsert();

            $this->session->unset_userdata('product');

            $this->session->unset_userdata('category');

            $this->session->unset_userdata('country');

            $this->session->unset_userdata('state');

            $this->session->unset_userdata('city');

            $this->session->unset_userdata('price');

            $this->session->unset_userdata('description');

            $this->session->unset_userdata('images');

            $this->session->unset_userdata('video');




            if ($this->session->userdata('package') != false) {

                $package['bid'] = $user->sno;

                $package['package'] = $product['package_id']; //current

                $package['date_selected'] = date('Y/m/d');

                $package['date_expire'] = date('Y/m/d', strtotime('+' . $pkg->length . 'months'));

                $package['amount_paid'] = $pkg->price;

                $pkged = $this->model->insert('business_packages', $package);

                $this->session->unset_userdata('package');
            }


            /*
             * Insert a transaction info about extra features selected for an ad.
             */


            if ($this->session->userdata('bump') != false ||
                    $this->session->userdata('top') != false ||
                    $this->session->userdata('highlight') != false ||
                    $this->session->userdata('urgent') != false ||
                    $this->session->userdata('home') != false) {
                if ($this->session->userdata('payment') == 'success') {
                    if (isset($lastId)) {
                        $insert = array(
                            'payment_method' => $this->session->userdata('paymethod') == false ? 'paypal' : $this->session->userdata('paymethod'),
                            'bid' => $user->sno,
                            'gross_amount' => $this->session->userdata('pay') == false ? 0 : $this->session->userdata('pay'),
                            'received_amount' => $this->session->userdata('pay') == false ? 0 : $this->session->userdata('pay'),
                            'payment_status' => 'R',
                            'ad_id' => $lastId,
                        );

                        /*
                         * Later better we replace these bool values with actual numbers.
                         */

                        if ($this->session->userdata('bump') != false) {
                            $insert['is_bumpup'] = '1';
                        }

                        if ($this->session->userdata('top') != false) {
                            $insert['is_topad'] = '1';
                        }

                        if ($this->session->userdata('highlight') != false) {
                            $insert['is_highlight'] = '1';
                        }

                        if ($this->session->userdata('urgent') != false) {
                            $insert['is_urgent'] = '1';
                        }

                        if ($this->session->userdata('home') != false) {
                            $insert['is_home'] = '1';
                        }

                        $this->model->insert('transaction_info', $insert);
                    }
                }
            }

            if (isset($lastId)) {
                $extra = array();

                $extra['ad_id'] = $lastId;

                if ($this->session->userdata('bump') != false) {
                    $extra['is_bumpup'] = 1;
                }

                if ($this->session->userdata('top') != false) {
                    $extra['is_topad'] = 1;
                }

                if ($this->session->userdata('highlight') != false) {
                    $extra['is_highlight'] = 1;
                }

                if ($this->session->userdata('urgent') != false) {
                    $extra['is_urgent'] = 1;
                }

                if ($this->session->userdata('home') != false) {
                    $extra['is_home'] = 1;
                }

                $extra['start_date'] = date('Y/m/d');

                $extra['end_date'] = date('Y/m/d', strtotime('+7 days'));

                $insert = $this->model->insert('ad_extra', $extra);

                $this->session->unset_userdata('features');

                $this->session->unset_userdata('bump');

                $this->session->unset_userdata('top');

                $this->session->unset_userdata('highlight');

                $this->session->unset_userdata('urgent');

                $this->session->unset_userdata('home');
            }

            $this->session->unset_userdata('pay');

            $this->session->unset_userdata('referer');

            $this->data['message'] = 'Your product has been posted for review by admin. It will online soon after been approved by admin.';
        } else {

            $this->data['message'] = 'Your product could not be added this time. Please try later.';
        }
    }

    private function modify($id) {

        /*
         * modify ads
         */
        $data = $this->input->post(NULL, TRUE);

        $ad = $this->model->select('business_ads', '*', array('sno' => $id), null, 1);

        $this->data['flag'] = true;

        $this->data['id'] = $id;

        $this->data['ads'] = $ad;

        $step = $this->input->get('step', TRUE);


        /* step 1 display info
         * 
         */
        if (empty($data) && $step == "") {
            //echo '<pre>';print_r($ad);

            $props = $this->model->select('ad_features', '*', array('ad_id' => $ad->sno));

            $ad_cat = $this->model->select('app_category', 'category_name,sno', array('sno' => $ad->cat_id), null, 1);

            $this->data['props'] = $props;

            $this->data['ad_cat'] = $ad_cat;

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

                        $list[] = ltrim($l->item_name, ' ');
                    }
                }

                if (!empty($list)) {
                    sort($list);
                }

                $items[] = array(
                    'cat' => $cat['category_name'],
                    'lists' => $list
                );
            }

            $this->data['items'] = json_encode($items);

            foreach ($cats as $c) {
                $temp[] = ucfirst($c['category_name']);
            }


            $this->data['cats'] = json_encode($temp);


            $this->page = 'placead/step1';

            $this->response();
        }



        /* step 2 edit data from step 2
         * 
         */
        if ($step == 2) {

            if (!empty($data)) {
                $cat = $this->model->select('app_category', 'category_name,sno', array('category_name' => $data['category']), NULL, 1);

                $updated_data1 = array(
                    'name' => $data['name'],
                    'cat_id' => $cat->sno,
                    'price' => $data['price'],
                    'description' => $data['description']
                );

                $update1 = $this->model->update('business_ads', $updated_data1, array('sno' => $id));

                if ($update1) {

                    $this->page = 'placead/step2';

                    $this->response();
                }
            } else {
                $this->page = 'placead/step2';

                $this->response();
            }
        }

        /* edit data from step 3
         * 
         */
        if ($step == 3) {
            if (!empty($data)) {
                $updated_data2 = array(
                    'country' => $data['country'],
                    'location' => $data['state'],
                    'city' => $data['city']
                );

                $update2 = $this->model->update('business_ads', $updated_data2, array('sno' => $id));

                if ($update2) {

                    $this->page = 'placead/step3';

                    $this->response();
                }
            } else {
                $this->page = 'placead/step3';

                $this->response();
            }
        }

        /* edit data from step 4
         * 
         */

        if ($step == 4) {
            //if (!empty($data)) {
                $files = $_FILES;
                //echo'<pre>'; print_r($files);

                $this->load->library('imageuploader');

                $imgs = $this->session->userdata('images');

                if (empty($imgs)) {

                    if ($files['images']['error'][0] == 0):

                        $this->imageuploader->
                                set('file', $files)->
                                set('name', 'images')->
                                set('uploadType', 'multiple')->
                                set('fileType', 'image')->
                                set('root', BASEDIR)->
                                set('directory', 'assets/uploads/products/images')->
                                set('minWidth', 150)->
                                set('minHeight', 150);

                        if ($this->imageuploader->upload()) {

                            $uploaded = $this->imageuploader->get('fileName');

                            if (count($uploaded) == 0) {

                                throw new Exception('For some images were not uploaded.', '900');
                            } else {

                                $images = implode(',', $uploaded);
                            }
                        } else {

                            throw new Exception('Images could not uploaded. Please try later.', '900');
                        }
                    else:

                        //throw new Exception('Please select at least one image.');

                        $images = $ad->images;

                    endif;
                }

                $vdos = $this->session->userdata('video');

                if (empty($vdos)) {

                    if ($files['video']['error'] == 0):

                        $uploader = $this->imageuploader->
                                set('file', $files)->
                                set('name', 'video')->
                                set('uploadType', 'single')->
                                set('fileType', 'video')->
                                set('root', BASEDIR)->
                                set('directory', 'assets/uploads/products/videos');

                        if ($uploader->upload()) {

                            $name = $uploader->get('fileName');

                            if (!empty($name)) {

                                $video = $name;

                                $vup = true;
                            }
                        } else {

                            // throw new Exception('video could not be uploaded.', '900');

                            $video = $ad->video;
                        }

                    endif;
                }

                if (!isset($vup) || @$vup == flase) {

                    if (!empty($data['url'])) {

                        $video = $data['url'];
                    } else
                        $video = null;
                }


                $updated_data3 = array(
                    'images' => $images,
                    'video' => $video
                );


                $update3 = $this->model->update('business_ads', $updated_data3, array('sno' => $id));

                if ($update3) {

                    $extra = $this->model->select('ad_extra', '*', array('ad_id' => $id), null, 1);

                    $this->data['extra'] = $extra;


                    $this->page = 'placead/step5';

                    $this->response();
                }
//            } else {
//                $this->page = 'placead/step5';
//
//                $this->response();
//            }
        }

        if ($step == 5) {


            $this->session->set_userdata('edit_extra', 1);

            $this->session->set_userdata('ad_id', $id);

            $extra = $this->model->select('ad_extra', '*', array('ad_id' => $id), null, 1);

            $this->data['extra'] = $extra;

            $data = $this->input->post(NULL, TRUE);



            $sum = 0;

            if (isset($data['bump']) && $extra->is_bumpup != 1) {

                $sum += 29;

                $this->session->set_userdata('bump', 1);
            }

            if (isset($data['top']) && $extra->is_topad != 1) {

                $sum += 169;

                $this->session->set_userdata('top', 1);
            }

            if (isset($data['highlight']) && $extra->is_highlight != 1) {

                $sum += 39;


                $this->session->set_userdata('highlight', 1);
            }

            if (isset($data['urgent']) && $extra->is_urgent != 1) {


                $sum += 59;

                $this->session->set_userdata('urgent', 1);
            }

            if (isset($data['home']) && $extra->is_home != 1) {

                $sum += 339;

                $this->session->set_userdata('home', 1);
            }

            if ($sum > 0) {

                $this->session->set_userdata('referer', 'dashboard');

                $this->session->set_userdata('pay', $sum);

                $this->header('payment');
            } else {

                $this->header('dashboard');
            }
        }
    }

    private function edit_extra($id) {

        $user = $this->session->userdata('username');

        if (false == $user) {

            return;
        }

        $user = $this->model->select('business_members', 'sno', array('username' => $user), NULL, 1);


        if ($this->session->userdata('bump') != false ||
                $this->session->userdata('top') != false ||
                $this->session->userdata('highlight') != false ||
                $this->session->userdata('urgent') != false ||
                $this->session->userdata('home') != false) {

            if ($this->session->userdata('payment') == 'success') {

                if (isset($id)) {

                    $insert = array(
                        'payment_method' => $this->session->userdata('paymethod') == false ? 'paypal' : $this->session->userdata('paymethod'),
                        'bid' => $user->sno,
                        'gross_amount' => $this->session->userdata('pay') == false ? 0 : $this->session->userdata('pay'),
                        'received_amount' => $this->session->userdata('pay') == false ? 0 : $this->session->userdata('pay'),
                        'payment_status' => 'R',
                        'ad_id' => $id,
                    );

                    /*
                     * Later better we replace these bool values with actual numbers.
                     */

                    if ($this->session->userdata('bump') != false) {
                        $insert['is_bumpup'] = '1';
                    }

                    if ($this->session->userdata('top') != false) {
                        $insert['is_topad'] = '1';
                    }

                    if ($this->session->userdata('highlight') != false) {
                        $insert['is_highlight'] = '1';
                    }

                    if ($this->session->userdata('urgent') != false) {
                        $insert['is_urgent'] = '1';
                    }

                    if ($this->session->userdata('home') != false) {
                        $insert['is_home'] = '1';
                    }

                    $this->model->insert('transaction_info', $insert);
                }
            }
        }

        $extra = array();

        //$extra['ad_id'] = $id;

        if ($this->session->userdata('bump') != false) {
            $extra['is_bumpup'] = 1;
        }

        if ($this->session->userdata('top') != false) {
            $extra['is_topad'] = 1;
        }

        if ($this->session->userdata('highlight') != false) {
            $extra['is_highlight'] = 1;
        }

        if ($this->session->userdata('urgent') != false) {
            $extra['is_urgent'] = 1;
        }

        if ($this->session->userdata('home') != false) {
            $extra['is_home'] = 1;
        }

        $extra['start_date'] = date('Y/m/d');

        $extra['end_date'] = date('Y/m/d', strtotime('+7 days'));

        $insert = $this->model->update('ad_extra', $extra, array('ad_id' => $id));




        $this->session->unset_userdata('pay');

        $this->session->unset_userdata('referer');
    }

    public function inactive($user, $name) {
        try {

            $result = $this->model->inactive_ads($user, $name);

            if ($result == TRUE) {

                $this->session->set_userdata('ad_msg', 'successfully inactivated');

                $uri = base_url() . 'dashboard';

                redirect($uri);
            } else
                throw new Exception('can not inactive.', '900');
        } catch (Exception $e) {

            $this->session->set_userdata('ad_msg', 'error');

            $this->header = $e->getCode();

            $this->message = $e->getMessage();

            $uri = base_url() . 'dashboard';

            redirect($uri);
        }
    }

    public function active($user, $name) {
        try {

            $result = $this->model->active_ads($user, $name);

            if ($result == TRUE) {

                $this->session->set_userdata('ad_msg', 'successfully activated');

                $uri = base_url() . 'dashboard';

                redirect($uri);
            } else
                throw new Exception('can not active.', '900');
        } catch (Exception $e) {

            $this->session->set_userdata('ad_msg', 'error');

            $this->header = $e->getCode();

            $this->message = $e->getMessage();

            $uri = base_url() . 'dashboard';

            redirect($uri);
        }
    }

    public function disapproved_ads() {
        try {

            $username = $this->session->userdata('username');

            $user_id = $this->model->select('business_members', 'sno', array('username' => $username), NULL, 1);

            $bus_ads = $this->model->select('business_ads', 'sno', array('bid' => $user_id->sno));

            $i = 0;
            foreach ($bus_ads as $ads) {

                $disapproved_ads[] = $this->model->select('notification', '*', array('ad_id' => $ads['sno'], 'suggestion !=' => 'NULL', 'notify' => 0));

                foreach ($disapproved_ads as $note) {
                    if ($note[0]['action'] != '') {
                        $i = $i + 1;
                    }
                }
            }


            if ($i == 0) {
                $uri = base_url() . 'dashboard';

                redirect($uri);
            } else {

                $this->data['disapproved_ads'] = $disapproved_ads;
            }

            $this->page = 'business/disapproved_ads';

            $this->response();
        } catch (Exception $e) {

            $this->header = $e->getCode();

            $this->message = $e->getMessage();
        }
    }

    public function remove($user, $name) {
        try {

            $this->session->set_userdata('ad_msg', 'successfully removed.');


            $result = $this->model->remove_ads($user, $name);

            if ($result == TRUE) {

                $uri = base_url() . 'dashboard';

                redirect($uri);
            } else
                throw new Exception('can not remove.', '900');
        } catch (Exception $e) {

            $this->session->set_userdata('ad_msg', 'error');

            $this->header = $e->getCode();

            $this->message = $e->getMessage();

            $uri = base_url() . 'dashboard';

            redirect($uri);
        }
    }

    public function report($user, $name) {
        try {

            $name = str_replace('-', ' ', $name);

            $user_id = $this->model->select('business_members', 'sno', array('username' => $user), null, 1);

            $bus_id = $this->model->select('business_ads', 'sno', array('name' => $name, 'bid' => $user_id->sno), null, 1);

            $log = $this->model->select('ad_counter', '*', array('ad_id' => $bus_id->sno));

            if (false == $log) {
                //do nothing
            } else {

                $this->data['log'] = $log;
            }

            $this->page = 'business/report';

            $this->root = 'business/main';

            $this->header = 200;

            $this->message = 'Report log';

            $this->response();
        } catch (Exception $e) {

            $this->header = $e->getCode();

            $this->message = $e->getMessage();
        }
    }

}
