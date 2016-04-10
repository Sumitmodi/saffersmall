<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : search.php
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

class Search extends CI_Controller
{
    /*
     * An array of the results fetched during search.
     */

    protected $result;

    /*
     * An array of results displayed on the curren page.
     */
    protected $current;


    /*
     * Pagination vars
     */

    /*
     * The current page
     */
    protected $curpage;

    /*
     * The total number of pages
     */
    protected $pages;

    /*
     * Results per page
     */
    protected $rpp = 10;

    public function __construct()
    {

        parent::__construct();

        unset($this->model);

        $this->load->model('common/common', 'model');

        $this->data = $this->load->controller('Header', 'common/header/header')->enter($this->model)->get('data');

        $this->root = 'home/home';
    }

    public function enter($user = false, $ads = false)
    {
        try
        {
            $start = microtime(true);

            if (false == $user)
            {
                $q = $this->input->get('query', true);

                $c = $this->input->get('cat', true);

                if ($q == 'null')
                {
                    $q = false;
                }

                if ($c == 'null')
                {
                    $c = false;
                }

                /*
                 * If nothing has been entered in the search boxes
                 */
                if (false == $q && false == $c)
                {

                    $result = $this->model->select('business_ads', '*', array('LOWER(status)' => 'a'), array('date_added' => 'desc'));
                }

                /*
                 * If some data has been entered
                 */
                if ($q != false && $c != false)
                {

                    /*
                     * Fetch all the category list
                     */
                    $cat = $this->model->select('app_category', 'sno,category_name', array('LOWER(category_name)' => strtolower($c)), NULL, 1);
                    /*
                     * If categories do not exist on the system,
                     * set var c to false (search by cat disabled)
                     */
                    if ($cat == false)
                    {

                        $c = false;
                    } else
                    {

                        /*
                         * Search a product in a particular category
                         */

                        $result = $this->find($q, $cat->sno);
                    }
                } else
                {

                    /*
                     * If product name is empty
                     */

                    if ($q == false)
                    {

                        /*
                         * Search by category
                         */
                        $cat = $this->model->select('app_category', 'sno,category_name', array('LOWER(category_name)' => strtolower($c)), NULL, 1);

                        if (false == $cat)
                        {
                            $result = array();

                            $this->data['nores'] = true;
                        } else
                        {

                            $result = $this->model->select('business_ads', '*', array('cat_id' => $cat->sno, 'LOWER(status)' => 'a'), array('date_added' => "desc"));
                        }
                    }

                    /*
                     * If category is empty. Search by a product name
                     */
                    if ($c == false)
                    {

                        $result = $this->find($q);
                    }
                }

                /*
                 * Check if its an advanced search.
                 */
                if ($this->input->get('adv') == false)
                {
                    $res = $this->advanced($result);
                }

                $this->prepareTitle($q, $c);
            } else
            {
                $result = $ads;

                $this->data['title'] = $this->title($user->username, 'Ads');
            }

            $this->page = 'search/search';

            if (count(array($result)) == 0)
            {
                $this->data['nores'] = true;

                $this->response();

                return;
            }

            /*
             * Loop through the results to get extra information about the ad.
             */

            foreach ($result as $k => $r)
            {
                $r = (object) $r;

                $user = $this->model->select('business_members', 'person_name,username,address,country,city,state', array('sno' => $r->bid), NULL, 1);

                $ext = $this->model->select('ad_extra', '*', array('ad_id' => $r->sno), NULL, 1);

                if ($ext != false)
                {
                    if (!$this->expired($ext->end_date))
                    {
                        $result[$k]['extra'] = $ext;
                    }
                }

                $feats = $this->model->select('ad_features', '*', array('ad_id' => $r->sno));

                if ($feats != false)
                {
                    $result[$k]['feats'] = $feats;
                }

                $result[$k]['user'] = $user;

                $result[$k]['views'] = $this->views($r->sno);

                /*
                 * This variable will store the sno of all the results
                 */

                $this->result[] = $result[$k]['sno'];
            }

            $this->data['total'] = count($result);

            $this->paginate($result);

            /*
             * An array of sno of results prepared to be displayed.
             */

            $this->current = array_column($this->data['result'], 'sno');

            /*
             * Related search
             */

            $this->related();

            $this->data['time'] = microtime(true) - $start;

            $this->response();
        } catch (Exception $e)
        {

            show_error($e->getMessage(), $e->getCode());
        }
    }

    /*
     * Filter results for advanced search
     */

    private function advanced($results)
    {
        try
        {
            if (count($results) == 0)
            {
                return array();
            }

            $city = $this->input->get('city');

            $country = $this->input->get('country');

            $loc = $this->input->get('state');

            $match = array();

            if (false == $city && false == $country && false == $loc)
            {
                return $results;
            }

            $city = strtolower($city);

            $country = strtolower($country);

            $loc = strtolower($loc);

            foreach ($results as $res)
            {
                $res = (object) $res;

                if (false == $country)
                {

                    if (false == $city)
                    {
                        /*
                         * Search by location only
                         */
                        if (strtolower($res->location) == $loc)
                        {
                            $match[] = $res;
                        }
                    } else
                    {
                        if (false == $loc)
                        {
                            /*
                             * Search by city only
                             */
                            if (strtolower($res->city) == $city)
                            {
                                $match[] = $res;
                            }
                        } else
                        {
                            /*
                             * Search by city and location(state)
                             */
                            if (strtolower($res->city) == $city && strtolower($res->location) == $loc)
                            {
                                $match[] = $res;
                            }
                        }
                    }
                } else
                {
                    if (false == $city)
                    {
                        if (false == $loc)
                        {
                            /*
                             * Search by country only
                             */
                            if (strtolower($res->country) == strtolower($country))
                            {
                                $match[] = $res;
                            }
                        } else
                        {
                            /*
                             * Search by country and location
                             */
                            if (strtolower($res->country) == $country && strtolower($res->location) == $loc)
                            {
                                $match[] = $res;
                            }
                        }
                    } else
                    {
                        if (false == $loc)
                        {
                            /*
                             * Search by country and city
                             */
                            if (strtolower($res->country) == $country && strtolower($res->city) == $city)
                            {
                                $match[] = $res;
                            }
                        } else
                        {
                            /*
                             * Search by country, city and state
                             */
                            if (strtolower($res->country) == $country &&
                                    strtolower($res->location) == $loc &&
                                    strtolower($res->city) == $city)
                            {
                                $match[] = $res;
                            }
                        }
                    }
                }
            }

            /*
             * No Match found
             */

            if (count($match) == 0)
            {
                return array();
            }

            $results = array();

            foreach ($match as $m)
            {
                /*
                 * Convert object to array
                 */
                $m = json_decode(json_encode($m), true);

                array_push($results, $m);
            }

            return $results;
        } catch (Exception $e)
        {
            $this->header = $e->getCode();

            $this->message = $e->getMessage();
        }
    }

    /*
     * Set the related search param.
     * 
     * Be displayed on the sidebar
     */

    private function related()
    {
        /*
         *  The related things finder is quite large algorithm, lets leave as a todo for later. 
         */

        /*
         * $related = $this->load->controller('Related', 'ui/search/related');

          $related->set('to', '');

          $related->set('find', '');

          $related->set('is', '');

          $related->set('minimal', $this->result);

          $related->set('strict', $this->current);
         */

        /*
         * Get highlighted ads
         */
        $highlighed = $this->model->select('ad_extra', 'ad_id,end_date', array('is_highlight' => '1'), 'date_added rand()');

        if ($highlighed != false)
        {
            $active = array();

            foreach ($highlighed as $k => $h)
            {
                $h = (object) $h;

                if (!$this->expired($h->end_date))
                {
                    $user = $this->model->select('business_members', 'username', array('sno' => $h->bid), NULL, 1);

                    if (false == $user)
                    {
                        continue;
                    }

                    $h->uid = $user->sno;

                    array_push($active, $h);
                }
            }

            if (count($active) > 0)
            {
                /*
                 * Currently we will take out any four of the ads randomly like rolling a dice.
                 * 
                 * We will use some algorithm later to find the best fitted for a page
                 */
                if (shuffle($active))
                {
                    /*
                     * We only want to display 4 highlighted ads on the sidebar.
                     */
                    $this->data['sidetop'] = array_rand($active, 4);
                }
            }
        }

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

        /*
         * Get urgent ads
         */

        $urgent = $this->model->select('ad_extra', 'ad_id,end_date', array('is_urgent' => '1'), 'date_added rand()');

        if ($urgent != false)
        {
            $active = array();

            foreach ($urgent as $k => $h)
            {
                $h = (object) $h;

                if (!$this->expired($h->end_date))
                {
                    $ad = $this->model->select('business_ads', '*', array('sno' => $h->ad_id), NULL, 1);

                    if (false == $ad)
                    {
                        continue;
                    }

                    $user = $this->model->select('business_members', 'username', array('sno' => $ad->bid), NULL, 1);

                    if (false == $user)
                    {
                        continue;
                    }

                    $ad->user = $user->sno;

                    array_push($active, $ad);
                }
            }

            if (count($active) > 0)
            {
                /*
                 * Currently we will take out any four of the ads randomly like rolling a dice.
                 * 
                 * We will use some algorithm later to find the best fitted for a page
                 */
                if (shuffle($active))
                {
                    /*
                     * We only want to display 4 highlighted ads on the sidebar.
                     */
                    $this->data['sidebot'] = array_rand($active, 4);
                }
            }
        }
    }

    /*
     * Paginate the results
     */

    private function paginate($results)
    {
        $page = $this->input->get('_');

        $this->pages = ceil(count($results) / $this->rpp);

        $this->curpage = false == $page ? 1 : ($page > $this->pages ? $this->pages : ($page < 1 ? 1 : $page));

        $this->data['pages'] = $this->pages;

        $this->data['result'] = array_slice($results, ($this->curpage - 1 ) * $this->rpp, $this->curpage * $this->rpp, false);

        $this->data['url'] = $this->pageUrl();

        $this->data['curpage'] = $this->curpage;

        $this->data['from'] = ($this->curpage - 1) * $this->rpp + 1;

        $this->data['to'] = ($this->curpage - 1 ) * $this->rpp + count($this->data['result']);

        $this->prevPage($this->pages, $this->curpage);

        $this->nextPage($this->pages, $this->curpage);
    }

    /*
     * The pagination url
     */

    private function pageUrl()
    {
        $q = $this->input->get('query');

        $c = $this->input->get('cat');

        if (false == $q)
        {
            return '?cat=' . $c;
        }

        if (false == $c)
        {
            return '?query=' . $q;
        }

        if (false == $c && false == $q)
        {
            return '?';
        }

        return '?query=' . $q . '&cat=' . $c;
    }

    /*
     * The next page
     */

    private function nextPage($total, $cur)
    {
        if ($cur == $total)
        {
            $this->data['nextpage'] = $total;

            /*
             * The above statement is valid. Lets make the pagination circular. So whenever, someone clicks next page 
             * 
             * from the last page, he is redirected to first page.
             */

            $this->data['nextpage'] = 1;
        } else
        {
            $this->data['nextpage'] = $cur + 1;
        }
    }

    /*
     * The previous page
     */

    private function prevPage($total, $cur)
    {
        if ($cur == 1)
        {
            $this->data['prevpage'] = 1;
            /*
             * Like said in the previous function, lets make this one circular too.
             */
            $this->data['prevpage'] = $total;
        } else
        {
            $this->data['prevpage'] = $cur - 1;
        }
    }

    /*
     * Count the total views of the ad
     */

    private function views($sno)
    {
        $res = array($this->model->select('ad_features', '*', array('ad_id' => $sno)));

        return $res == false ? 0 : count($res);
    }

    /*
     * Check if the ad has expired or not.
     */

    private function expired($date, $cur = false)
    {

        $cur = $cur == false ? date('Y/m/d') : $cur;

        $cur = new DateTime(date('Y/m/d', strtotime($cur)));

        $sup = new DateTime(date('Y/m/d', strtotime($date)));

        $diff = $sup->diff($cur, FALSE);

        /*
         * The extra support has expired
         */

        if ($diff->d > 0 && $diff->invert == 0)
        {

            return 1;
        }

        /*
         * It is still alive
         */

        return 0;
    }

    private function prepareTitle($q = false, $c = false)
    {
        if (false == $q && false == $c)
        {
            return $this->data['title'] = 'Search';
        } else
        {
            if (false == $q)
            {
                $this->data['title'] = $this->title('Search', $c);
            } else
            {
                if (false == $c)
                {
                    $this->data['title'] = $this->title($q, 'Search');
                } else
                {
                    $this->data['title'] = $this->title($q, $c);
                }
            }
        }
    }

    private function find($q, $catid = false)
    {
        try
        {
            $q = explode(' ', $q);

            $num = count($q);

            $total = pow(2, $num);

            $res = array();

            $str = microtime(true);

            /*
             * Permute the query string
             */
            for ($i = 0; $i < $total; $i++)
            {

                $t = null;

                for ($j = 0; $j < $num; $j++)
                {

                    if (pow(2, $j) & $i)
                    {

                        $t = $t . $q[$j] . ' ';
                    }
                }

                if (!empty($t))
                {

                    $t = rtrim($t, ' ');

                    $t = ltrim($t, ' ');

                    $res[] = $t;
                }
            }

            return $this->model->search($res, $catid);
        } catch (Exception $e)
        {

            $this->header = $e->getCode();

            $this->message = $e->getMessage();
        }
    }

}
