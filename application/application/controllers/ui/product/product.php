<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : product.php
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

class Product extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (isset($this->model))
        {
            unset($this->model);
        }

        $this->load->model('common/common', 'model');
        
        $this->data = $this->load->controller('Header', 'common/header/header')->enter($this->model)->get('data');

        $this->root = 'home/home';
    }

    /*
     * Enter from here
     */

    public function enter()
    {
        try
        {

            $username = $this->uri->segment(2);

            $user = $this->model->select('business_members', 'sno', array('LOWER(username)' => strtolower($username)), NULL, 1);
            $ad = $this->uri->segment(3);

            $this->data['title'] = $this->title($username, ucwords($this->extract($ad)));

            if (false == $user)
            {
                throw new Exception('Product not found for this user.', '404');
            }

            $this->details($user->sno, $this->extract($ad));

            if (!isset($this->ad->sno))
            {
                show_error('The product your are searching for does not exist.', '404');
            }

            $this->counter($this->ad->sno);

            $this->categories();

            $this->page = 'ui/ad_details';

            $this->data['productSlide'] = true;

            $this->added($this->ad->sno);

            $this->views($this->ad->sno);
            
            $this->catAds();

            $this->response();
        } catch (Exception $e)
        {
            show_error($e->getMessage(), $e->getMessage());
        }
    }

    /*
     * Get a count of user who have added this ad to their wishlist or favourites
     */

    private function added($sno)
    {
        $res = $this->model->select('ad_features', 'count(*) as added', array('ad_id' => $sno));

        $this->data['added'] = $res[0]['added'];
    }

    /*
     * Count the total views of the ad
     */

    private function views($sno)
    {
        $res = array($this->model->select('ad_features', '*', array('ad_id' => $sno)));

        $this->data['views'] = count($res);
    }

    /*
     * All the categories
     */

    private function categories()
    {

        $cats = $this->model->select('app_category', 'category_name,sno', NULL, array('category_name' => 'asc'));

        if ($cats != false)
        {

            $this->data['cats'] = $cats;
        }
    }

    /*
     * Get the actual ad name
     */

    private function extract($data)
    {
        /* for ($i = 0; $i < strlen($data); $i++)
          {
          if ($data[$i] == '-')
          {
          if (isset($data[$i - 1]) && isset($data[$i + 1]))
          {
          if ($data[$i - 1] == $data[$i] && $data[$i] == $data[$i + 1])
          {
          $data[$i] = ' ';
          }
          }
          }
          } */
        return str_replace('-', ' ', $data);
    }

    /*
     * Save the ad counter
     */

    private function counter($id)
    {

        $ad_viewed = $this->session->userdata('ad_viewed' . $id);

        if ($ad_viewed != false)
        {
            return true;
        }

        $user = $this->session->userdata('username');

        if (false == $user)
        {
            $bid = null;
        } else
        {
            $user = $this->model->select('business_members', 'sno', array('username' => $user), NULL, 1);

            if (false == $user)
            {
                $bid = null;
            } else
            {
                $bid = $user->sno;
            }
        }

        if (isset($bid))
        {
            $b_id = $bid;
        } else
        {
            $b_id = NULL;
        }

        $ip = $this->get_client_ip();

        $browser = $this->getBrowser();

        $os = $this->getOS();

        $viewed_data = array(
            'ad_id' => $id,
            'bid' => $b_id,
            'ip' => $ip,
            'browser' => $browser,
            'os' => $os
        );

        $this->model->insert('ad_counter', $viewed_data);

        $this->session->set_userdata('ad_viewed' . $id, TRUE);
    }

    /*
     * Get the browser of any visitor
     */

    private function getBrowser()
    {
        $user_agent = $this->input->server('HTTP_USER_AGENT');

        $browser = "Unknown Browser";

        $browser_array = array(
            '/msie/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/safari/i' => 'Safari',
            '/chrome/i' => 'Chrome',
            '/opera/i' => 'Opera',
            '/netscape/i' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i' => 'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value)
        {

            if (preg_match($regex, $user_agent))
            {
                $browser = $value;
            }
        }

        return strtolower($browser);
    }

    /*
     * Get the ip address of any visitor
     */

    private function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
        {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } else if (getenv('HTTP_X_FORWARDED_FOR'))
        {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } else if (getenv('HTTP_X_FORWARDED'))
        {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } else if (getenv('HTTP_FORWARDED_FOR'))
        {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } else if (getenv('HTTP_FORWARDED'))
        {
            $ipaddress = getenv('HTTP_FORWARDED');
        } else if (getenv('REMOTE_ADDR'))
        {
            $ipaddress = getenv('REMOTE_ADDR');
        } else
        {
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }

    /*
     * Get the os of a visitor
     */

    private function getOS()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_platform = "Unknown OS Platform";

        $os_array = array(
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($os_array as $regex => $value)
        {

            if (preg_match($regex, $user_agent))
            {
                $os_platform = $value;
            }
        }

        return $os_platform;
    }

    /*
     * Get the details about an ad
     */

    private function details($id, $ad)
    {
        try
        {
            $this->ad = $ad = $this->model->select('business_ads', '*', array('bid' => $id, 'LOWER(name)' => $ad), NULL, 1);

            if (true == $ad)
            {
                $lists = $this->model
                        ->select(
                        'ad_features', array('list_name', 'list_value', 'date_added'), array('ad_id' => $ad->sno), array('date_added' => 'asc')
                );

                $post_man = $this->model->select('business_members', array('sno', 'business_name', 'address', 'person_name', 'telephone', 'username', 'image'), array('sno' => $ad->bid), NULL, 1);

                $item = array(
                    'lists' => $lists,
                    'item' => $ad,
                    'user' => $post_man
                );

                $related_ads = $this->model->select('business_ads', '*', array('cat_id' => $ad->cat_id, 'LOWER(status)' => 'a', 'sno != ' => $ad->sno), array('date_added' => 'rand()'));

                /*
                 * Related ads
                 */
                $extra_ads = array();

                /*
                 * The second last section in the sidebar
                 */
                $bot_top = array();

                /*
                 * The last section in the sidebar
                 */
                $bot_bot = array();
                if ($related_ads != false)
                {
                    foreach ($related_ads as $related_ad)
                    {
                        $related_extra = $this->model->select('ad_extra', '*', array('ad_id' => $related_ad['sno']));

                        $business_man = $this->model->select('business_members', array('username', 'person_name'), array('sno' => $related_ad['bid']), NULL, 1);

                        if (count($bot_top) == 4)
                        {
                            $bot_bot[] = array(
                                'related_ads' => $related_ad,
                                'related_extra' => $related_extra,
                                'business_man' => $business_man
                            );
                        } elseif (count($extra_ads) == (count($related_ads) > 8 ? 8 : 4))
                        {
                            $bot_top[] = array(
                                'related_ads' => $related_ad,
                                'related_extra' => $related_extra,
                                'business_man' => $business_man
                            );
                        } else
                        {

                            $extra_ads[] = array(
                                'related_ads' => $related_ad,
                                'related_extra' => $related_extra,
                                'business_man' => $business_man
                            );
                        }
                    }
                }
                /*
                 * Extra work to be done
                 * 
                 * Arrange ads by packages and by extra features associated with the ad
                 */

                $this->data['result'] = $item;

                $this->data['extra_result'] = $extra_ads;

                $sfi = $this->model->select('business_members', '*', array('is_sfi' => 1, 'status' => 'A'));

                $this->data['sfi_data'] = $sfi;

                if (count($bot_top) > 0)
                {
                    $this->data['topbar'] = $bot_top;
                }

                if (count($bot_bot) > 0)
                {
                    $this->data['botbar'] = $bot_bot;
                }
            } else
            {
                $this->data['result'] = NULL;

                $this->data['extra_result'] = NULL;

                $this->data['sfi_data'] = NULL;
            }
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }
    
    /*
     * This function has been hired from seach page to define the listing on the sidebar.
     * 
     * Later it will be replaced by own algorithm.
     */
    
    private function catAds()
    {

        /*
         * Get ads by category. Just listing only
         */

        $cats = $this->model->select('app_category', '*', NULL, 'rand()');

        $cat_info = array();

        foreach ($cats as $cat)
        {
            $catAds = $this->
                    model->
                    select('business_ads', 'sno, name,bid', array(
                'cat_id' => $cat['sno'],
                'status !=' => 'W',
                'status !=' => 'D'
                    ), 'rand()', rand(5, 8)
            );

            $cat_ads = array();

            if ($catAds != false)
            {
                foreach ($catAds as $a)
                {
                    $user = $this->model->select('business_members', 'username', array('sno' => $a['bid']), NULL, 1);

                    if (false == $user)
                    {
                        continue;
                    }

                    $a = (object) $a;

                    $a->user = $user->username;

                    array_push($cat_ads, $a);
                }
            }

            $cat = (object) $cat;

            if (!empty($cat_ads))
            {
                array_push($cat_info, array(
                    'category' => $cat,
                    'ads' => $cat_ads
                ));
            }
        }

        if (count($cat_info) > 0)
        {
            $this->data['catads'] = $cat_info;
        }
    }

}
