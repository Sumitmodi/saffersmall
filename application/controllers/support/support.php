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

class Support extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->root = 'business/main';

        $this->load->model('common/common', 'model1');
    }

    public function entry($target = NULL)
    {
        try
        {
            $cats = $this->model->select('app_category', 'category_name,sno', NULL, array('category_name' => 'asc'));

            if ($cats != false) {

                $this->data['cats'] = $cats;
            }
            
            $social_links = $this->model->select('social_links','*');
            
            $this->data['social_links'] = $social_links;
            
            if ($target != NULL && $target != 'contact')
            {
                $this->show($target);
            } else
                $this->contact();
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }

    public function show($target = NULL)
    {
        try
        {
            if ($target != NULL)
            {
                
                /* show post */
                $post = $this->model1->select('admin_post', '*', array('LOWER(title)' => $target, 'LOWER(status)' => 'a'), NULL, 1);
                
                $this->data['result'] = $post;

                /* show list of sfi members with its links at the right side of support page */
                $sfi = $this->model1->select('business_members', '*', array('is_sfi' => 1, 'LOWER(status)' => 'a'), NULL, 5);
                
                $this->data['sfi_data'] = $sfi;


                $category = $this->model1->select('app_category', '*', NULL, 'rand()', 5);

                foreach ($category as $categories)
                {
                    $cat_ads = $this->model1->select('business_ads', 'sno, name, bid', array('cat_id' => $categories['sno'], 'LOWER(status) !=' => 'w', 'LOWER(status) !=' => 'd'), 'rand()', rand(5, 10));
                    
                    if(!empty($cat_ads)){
                        
                        foreach($cat_ads as $k=>$cat_ad){

                            $cat_user = $this->model1->select('business_members', 'username', array('sno'=>$cat_ad['bid']), null, 1);

                            $cat_ads[$k]['user'] = $cat_user->username;
                        }

                        $cat_info[] = array(
                            'category' => $categories,
                            'cat_ads' => $cat_ads

                        );
                    }
                }

                $this->data['cat_info'] = $cat_info;

                $highlight_jobs = $this->model1->select('ad_extra', 'ad_id', array('is_highlight' => 1));

                if ($highlight_jobs != false)
                {
                    foreach ($highlight_jobs as $highlight_job)
                    {
                        $ads[] = $this->model1->select('business_ads', 'sno, images', array(
                            'sno' => $highlight_job['ad_id'],
                            'status !=' => 'W',
                            'status !=' => 'D'), NULL, 4);
                    }
                    $this->data['ads'] = $ads;
                }
            } else
            {
                $this->data['result'] = NULL;

                $this->data['sfi_data'] = NULL;

                $this->data['cat_info'] = NULL;

                $this->data['ads'] = NULL;
            }

            $this->page = 'support/support';

            $this->header = 200;

            $this->message = '';

            $this->root = 'home/home';

            $this->response();
        } catch (Exception $ex)
        {
            
        }
    }

    public function contact()
    {
        try
        {
            $data = $this->input->post(NULL, TRUE);
            /*
             * get posted data to $data and then check whether the data are posted or not. 
             * if data are empty, just show the contact form
             */

            $address = $this->model1->select('admin_post', '*', array('title' => 'address'), 'date_added desc', 1);

            if (false != $address)
            {
                $this->data['address'] = $address;
            }

            if (!empty($data))
            {
                $posted_data = array(
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'subject' => $data['subject'],
                    'comments' => $data['comments']
                );

                $comment = $this->model1->insert('contact_us', $posted_data);

                if ($comment)
                {
                    $this->message = 'Your message has been received. Thank you!';
                } else
                {
                    $this->message = 'Sorry! We could not process your message this time.';
                }
            }

            $highlight_jobs = $this->model1->select('ad_extra', 'ad_id', array('is_highlight' => 1));

            if ($highlight_jobs != false)
            {
                foreach ($highlight_jobs as $highlight_job)
                {
                    $ads[] = $this->model1->select('business_ads', 'sno, images', array(
                        'sno' => $highlight_job['ad_id'],
                        'status !=' => 'W',
                        'status !=' => 'D'), NULL, 4);
                }
                $this->data['ads'] = $ads;
            }


            $this->page = 'support/contact';

            $this->header = 200;

            $this->root = 'home/home';

            $this->response();
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();
        }
    }

}
