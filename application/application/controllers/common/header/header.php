<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : header.php
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

class Header extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        //$this->load->model('business/businessmodel', 'hmodel');
    }

    public function enter($model)
    {
        try
        {
            $cats = $model->select('app_category', 'category_name', NULL, array('category_name' => 'asc'));

            $ads = $model->select('business_ads', 'country,location,city');

            //unset($this->model);

            /*$cat = array();

            foreach ($cats as $c)
            {
                array_push($cat, $c['category_name']);
            }*/

            $this->data['cats'] = $cats;

            if ($ads == false)
            {
                return $this;
            }

            $cities = array();

            $countries = array();

            $states = array();

            foreach ($ads as $ad)
            {
                if (!in_array($ad['location'], $states) && !empty($ad['location']))
                {
                    array_push($states, $ad['location']);
                }

                if (!in_array($ad['city'], $cities) && !empty($ad['city']))
                {
                    array_push($cities, $ad['city']);
                }

                if (!in_array($ad['country'], $countries) && !empty($ad['country']))
                {
                    array_push($countries, $ad['country']);
                }
            }

            if (count($countries) > 0)
            {
                $this->data['countries'] = $countries;
            }

            if (count($cities) > 0)
            {
                $this->data['cities'] = $cities;
            }

            if (count($states) > 0)
            {
                $this->data['states'] = $states;
            }

            return $this;
        } catch (Exception $e)
        {
            $this->header = $e->getCode();

            $this->message = $e->getMessage();
        }
    }

}
