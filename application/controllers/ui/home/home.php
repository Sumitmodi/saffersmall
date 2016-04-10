<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : home.php
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

class Home extends CI_Controller {

    protected $ads;
    protected $sfi;

    public function __construct() {

        parent::__construct();

        if (isset($this->model)) {
            unset($this->model);
        }

        $this->root = 'home/home';

        $this->load->model('common/common', 'model');

        $this->load->library('geoplugin');
    }

    public function enter() {
        try {

            $this->data['title'] = $this->title('Home', DOMAIN);

            $social_links = $this->model->select('social_links', '*');

            $this->data['social_links'] = $social_links;

            $main_logo = $this->model->select('admin_logos', '*');

            $this->data['logos'] = $main_logo;

            $this->page = 'home/main';

            $this->header = 200;

            $this->message = '';

            $this->categories();

            $this->homeAds();

            $this->allAds();

            $this->adsByCat();

            $this->linkAds();


            //echo '<pre>'; print_r($this->data['home_ads']);

            /*
             * Since we have all the ads, we need to filter these ads to 
             * 
             * fit in the different sections of the home page
             */
            /* echo '<pre>';
              print_r($this->ads);
              echo '</pre>'; */

            $this->response();
        } catch (Exception $e) {

            $this->header = $e->getCode();

            $this->message = $e->getMessage();
        }
    }

    private function adsByCat() {
        if ($this->data['sysdown'] == true) {
            return false;
        }
        //echo '<pre>'; print_r($this->data['cats']); print_r($this->data['ads']);


        foreach ($this->data['cats'] as $k => $c) {
            foreach ($this->data['ads'] as $ad) {
                $ad = !is_object($ad) ? (object) $ad : $ad;
                if ($ad->cat_id == $c['sno']) {
                    if (!isset($this->data['cats'][$k]['ads'])) {
                        $this->data['cats'][$k]['ads'] = array();
                        $cat_ads = array();
                    }

                    array_push($this->data['cats'][$k]['ads'], $ad);
                }
            }
        }
    }

    private function homeAds() {

        $this->data['home_ads'] = null;

        $home_ads = $this->model->select('ad_extra', 'ad_id', array('is_home' => 1));
        //echo '<pre>'; print_r($home_ads);
        if (isset($home_ads) && is_array($home_ads)) {

            foreach ($home_ads as $home_ad) {

                $ads_home = $this->model->select('business_ads', '*', array('sno' => $home_ad['ad_id'], 'LOWER(status)' => 'a', 'is_link_ad'=>0), array('date_added' => 'desc'));


                if (isset($ads_home) && is_array($ads_home)) {
                    foreach ($ads_home as $k => $ad_home) {

                        $user = $this->model->select('business_members', 'sno,person_name,is_sfi,profile_link,telephone,username', array('sno' => $ad_home['bid']), NULL, 1);

                        if (false == $user) {
                            continue;
                        }

                        $ads_home[$k]['user'] = $user->person_name;

                        $ads_home[$k]['user_name'] = $user->username;

                        $ads_home[$k]['username'] = $user->username;
                    }

                    $this->data['home_ads'] = $ads_home;
                }


                //echo '<pre>'; print_r($this->data['home_ads']);
            }
        }
    }

    private function linkAds() {

        $this->data['link_ads'] = null;

        $link_ads = $this->model->select('business_ads', '*', array('is_link_ad' => 1, 'LOWER(status)' => 'a'), array('date_added' => 'desc'));


        if (isset($link_ads) && is_array($link_ads)) {
            foreach ($link_ads as $k => $link_ad) {

                $user = $this->model->select('business_members', 'sno,person_name,is_sfi,profile_link,telephone,username', array('sno' => $link_ad['bid']), NULL, 1);

                if (false == $user) {
                    continue;
                }

                $link_ads[$k]['user'] = $user->person_name;

                $link_ads[$k]['user_name'] = $user->username;

                $link_ads[$k]['username'] = $user->username;
            }
//echo '<pre>';print_r($link_ads);
            $this->data['link_ads'] = $link_ads;
        }
    }

    private function categories() {

        $cats = $this->model->select('app_category', 'category_name,sno', NULL, array('category_name' => 'asc'));

        if ($cats != false) {

            $this->data['cats'] = $cats;
        }
    }

    private function allAds() {
        try {

            $ads = $this->model->select('business_ads', '*', array('LOWER(status)' => 'a', 'is_link_ad '=>0), array('date_added' => 'desc'));

            if (false == $ads) {

                $this->data['sysdown'] = true;

                return false;
            }

            $this->data['sysdown'] = false;

            /*
             * Now we filter the ads by sfi/recent/features/home/etc
             */

            $sfi = array();

            $forSearch = array();

            $normal = array();

            foreach ($ads as $k => $ad):

                $ad = (object) $ad;

                $extra = $this->model->select('ad_extra', '*', array('ad_id' => $ad->sno), array('date_added' => 'desc'), 1);

                $forSearch[] = $ad->name;

                if (false == $extra) {

                    $ad->bump = 0;

                    $ad->topad = 0;

                    $ad->highlight = 0;

                    $ad->urgent = 0;

                    $ad->home = 0;

                    $ad->extra_expired = true;
                } else {

                    $ad->bump = $extra->is_bumpup;

                    $ad->topad = $extra->is_topad;

                    $ad->highlight = $extra->is_highlight;

                    $ad->urgent = $extra->is_urgent;

                    $ad->home = $extra->is_home;

                    $ad->extra_expired = $this->expired($extra->end_date);
                }

                $ad->expired = $this->expired($ad->expire_date);

                $user = $this->model->select('business_members', 'sno,person_name,is_sfi,profile_link,telephone,username', array('sno' => $ad->bid), NULL, 1);

                if (false == $user) {
                    continue;
                }

                $ad->is_sfi = $user->is_sfi;

                $ad->user = $user->person_name;

                $ad->profile = $user->profile_link;

                $ad->phone = $user->telephone;

                $ad->username = $user->username;

                if ($user->is_sfi == 1) {

                    array_push($sfi, $ad);
                }

                $ads[$k] = $ad;

            endforeach;

            $this->data['sfi'] = $this->sfi = $sfi;

            $user = $this->session->userdata('visitor');

            if (false == $user) {

                $ipinfo = $this->geoplugin->locate();

                $user = new stdClass();

                $user->country = strtolower($this->geoplugin->countryName);

                $user->city = strtolower($this->geoplugin->city);

                $user->state = strtolower($this->geoplugin->region);

                $user->ip = $this->geoplugin->ip;

                $this->session->set_userdata('visitor', $user);
            }

            $this->data['forSearch'] = json_encode($forSearch);

            return $this->data['ads'] = $this->ads = $ads;
        } catch (Exception $e) {

            $this->header = $e->getCode();

            $this->message = $e->getMessage();
        }
    }

    private function expired($date, $cur = false) {

        $cur = $cur == false ? date('Y/m/d') : $cur;

        $cur = new DateTime(date('Y/m/d', strtotime($cur)));

        $sup = new DateTime(date('Y/m/d', strtotime($date)));

        $diff = $sup->diff($cur, FALSE);

        /*
         * The extra support has expired
         */

        if ($diff->d > 0 && $diff->invert == 0) {

            return 1;
        }

        /*
         * It is still alive
         */

        return 0;
    }

}
