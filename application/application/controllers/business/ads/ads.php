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

class Ads extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        unset($this->model);

        $this->load->model('business/businessmodel', 'model');

        $this->load->library('session');

        $this->root = 'business/main';

        /*
         * Lets save the activity log as TODO.
         */

        $this->activity = $this->load->controller('Activity', 'common/activity/activity');

        $this->activity->set('table', 'user_activity');
    }

    public function enter()
    {
        try
        {

            $this->login('business');

            $hasAdPlaced = $this->session->userdata('product');

            if ($hasAdPlaced != false)
            {

                $this->saveAd();
            }

            $this->data['title'] = $this->title('Ads', 'Dashboard');

            $this->data['class'] = 'dashboard';

            $user = $this->model->select('business_members', 'sno,person_name', array('username' => $this->session->userdata('username')), NULL, 1);

            if (false == $user)
            {

                $this->header('register');

                return false;
            }

            $ads = $this->model->select('business_ads', '*', array('bid' => $user->sno), array('date_added' => 'desc'));

            if ($ads != false)
            {

                foreach ($ads as $k => $ad)
                {

                    $imgs = explode(',', $ad['images']);

                    $img = $imgs[rand(0, count($imgs) - 1)];

                    unset($ads[$k]['images']);

                    $ads[$k]['image'] = 'products/images/' . $img;

                    $t = strtolower($ad['status']) == 'a' ? 'Active' :
                            (strtolower($ad['status']) == 'w' ? 'Waiting Approval' :
                                    (strtolower($ad['status']) == 'e' ? 'Expired' :
                                            'unknown'));

                    unset($ads[$k]['status']);

                    $ads[$k]['status'] = $t;

                    $props = $this->model->select('ad_features', '*', array('ad_id' => $ad['sno']));

                    if (false == $props)
                    {

                        continue;
                    }

                    $ads[$k]['props'] = $props;
                }

                $this->data['ads'] = $ads;
            }

            $this->page = 'business/ads';

            $this->message = 'Welcome again, ' . $user->person_name;

            $this->response();
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
        }
    }

    /*
     * Save an AD created by the user.
     */

    private function saveAd()
    {
        /*
         * If a user did not pay, his/her ad wont be saved
         */

        if ($this->session->userdata('payment') != 'success')
        {
            /*
             * For testing lets ignore this by commenting out the return statement
             */
            //return false;
        }

        $user = $this->session->userdata('username');

        if (false == $user)
        {

            return;
        }

        $user = $this->model->select('business_members', 'sno', array('username' => $user), NULL, 1);

        if (false == $user)
        {

            return;
        }

        $product = array();

        $product['bid'] = $user->sno;

        $product['name'] = $this->session->userdata('product');

        $product['cat_id'] = $this->session->userdata('category');

        if ($this->session->userdata('country') != false)
        {

            $product['country'] = $this->session->userdata('country');
        }

        if ($this->session->userdata('state') != false)
        {

            $product['location'] = $this->session->userdata('state');
        }

        if ($this->session->userdata('city') != false)
        {

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
        if (false == $pkg)
        {
            $pkg = $this->model->select('app_packages', 'sno,length,price', array('LOWER(name)' => 'basic'), NULL, 1);
        }

        $product['package_id'] = $pkg->sno;

        if ($this->session->userdata('images') != false)
        {

            $product['images'] = $this->session->userdata('images');
        }

        if ($this->session->userdata('video') != false)
        {

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

        if ($added)
        {

            $this->session->unset_userdata('product');

            $this->session->unset_userdata('category');

            $this->session->unset_userdata('country');

            $this->session->unset_userdata('state');

            $this->session->unset_userdata('city');

            $this->session->unset_userdata('price');

            $this->session->unset_userdata('description');

            $this->session->unset_userdata('images');

            $this->session->unset_userdata('video');

            $lastId = $this->model->lastInsert();


            if ($this->session->userdata('package') != false)
            {

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
                    $this->session->userdata('home') != false)
            {
                if ($this->session->userdata('payment') == 'success')
                {
                    if (isset($lastId))
                    {
                        $insert = array(
                            'payment_method' => $this->session->userdata('paymethod') == false ? 'paypal' : $this->session->userdata('paymethod'),
                            'bid' => $user->sno,
                            'gross_amount' => $this->session->userdata('pay') == false ? 0 : $this->session->userdata('pay'),
                            'recieved_amount' => $this->session->userdata('pay') == false ? 0 : $this->session->userdata('pay'),
                            'payment_status' => 'R',
                            'ad_id' => $lastId,
                        );

                        /*
                         * Later better we replace these bool values with actual numbers.
                         */

                        if ($this->session->userdata('bump') != false)
                        {
                            $insert['is_bump'] = '1';
                        }

                        if ($this->session->userdata('top') != false)
                        {
                            $insert['is_top'] = '1';
                        }

                        if ($this->session->userdata('highlight') != false)
                        {
                            $insert['is_highlight'] = '1';
                        }

                        if ($this->session->userdata('urgent') != false)
                        {
                            $insert['is_urgent'] = '1';
                        }

                        if ($this->session->userdata('home') != false)
                        {
                            $insert['is_home'] = '1';
                        }

                        $this->model->insert('transaction_info', $insert);
                    }
                }
            }

            if (isset($lastId))
            {
                $extra = array();

                $extra['ad_id'] = $lastId;

                if ($this->session->userdata('bump') != false)
                {
                    $extra['is_bumpup'] = 1;
                }

                if ($this->session->userdata('top') != false)
                {
                    $extra['is_topad'] = 1;
                }

                if ($this->session->userdata('highlight') != false)
                {
                    $extra['is_highlight'] = 1;
                }

                if ($this->session->userdata('urgent') != false)
                {
                    $extra['is_urgent'] = 1;
                }

                if ($this->session->userdata('home') != false)
                {
                    $extra['is_home'] = 1;
                }

                $extra['start_date'] = date('Y/m/d');

                $extra['end_date'] = date('Y/m/d', strtotime('+7 days'));

                $insert = $this->model->insert('ad_extra', $extra);

                $this->session->unset_userdata('features');
            }

            $this->session->unset_userdata('pay');

            $this->session->unset_userdata('referer');

            $this->data['message'] = 'Your product has been posted for review by admin. It will online soon after been approved by admin.';
        } else
        {

            $this->data['message'] = 'Your product could not be added this time. Please try later.';
        }
    }

}
