<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : category.php
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
 * This class will be used to define categories and their lists
 * which be used while creating ads.
 */

class Category extends CI_Controller
{

    protected $target;

    public function __construct()
    {
        parent::__construct();

        $this->root = 'admin/main';
        
        unset($this->model);

        $this->load->model('common/common', 'model1');
    }

    public function enter()
    {
        try
        {
            $target = $this->uri->segment(3);
            /*
             * If there an item in the 2nd uri segment attempt to 
             * load it. First check it is a module of business controller
             * then check if its a common module.
             */
            if (!empty($target))
            {

                $file = CONTROLDIR . DS . 'admin' . DS . 'category' . DS . strtolower($target) . EXT;

                if (file_exists($file))
                {

                    $this->control = $this->load->controller(ucfirst($target), 'admin' . DS . 'category' . DS . strtolower($target));
                } else
                {
                    $this->control = $this->load->controller(ucfirst($target), 'common' . DS . 'category' . DS . strtolower($target));
                    /*
                     * Not yet sure about it though.
                     * Lets see what it takes in the future.
                     * Just tried to make sure although its an external module,
                     * it stays within the business dashboard theme.
                     */
                }
                $this->control->$target();
            } else
            {
                $target = $this->input->get('target', TRUE);

                if (empty($target))
                {
                    $target = $this->input->get('_', TRUE);
                }

                if (empty($target))
                {
                    $this->category();
                } else
                {
                    $id = $this->input->get('id', TRUE);

                    $this->$target($id);
                }
            }
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();

            $this->page = 'business/category/category';
        }
    }

    private function category()
    {
        try
        {

            $cat = $this->model1->select('app_category', '*');

            if (true == $cat)
            {
                $this->data['result'] = $cat;
            } else
            {
                $this->data['result'] = NULL;
            }

            $this->data['title'] = $this->title('Category ', 'Lists');

            $this->page = 'admin/category/category';

            $this->header = 200;

            $this->message = 'Category List';

            $this->root = 'admin/main';

            $this->response();
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();

            $this->page = 'business/category/category';
        }
    }

    private function add()
    {
        try
        {

            $this->load->model('admin/adminmodel', 'model');

            $this->data['title'] = 'Category :: Add';
            /*
             * Just get all the data in the post request
             */
            $data = $this->input->post(NULL, TRUE);

            $data1 = $this->input->post('name');

            $size = $this->input->post('size');

            $cat_item = array();

            for ($i = 1; $i <= $size; $i++)
            {
                $cat_item[$i] = $this->input->post('item' . $i);
            }

            if (empty($data) || $data1 == "")
            {
                $this->page = 'admin/category/create';

                $this->header = 200;

                $this->message = 'Create Category';

                $this->root = 'admin/main';

                $this->response();

                return;
            }

            /*
             * Data has been posted.
             */

            $exist = $this->model->select('app_category', 'category_name', array('category_name' => $data['name']), NULL, '1');

            if ($exist == false)
            {
                /*
                 * Add a new category
                 */
                $insert = $this->model->insert('app_category', array('category_name' => $data['name']));

                if ($insert == false)
                {
                    throw new Exception('Some error occurred while adding new category.', '900');
                } else
                {
                    $cat_inserted = $this->model->select('app_category', array('category_name', 'sno'), array('category_name' => $data['name']), NULL, '1');
                    
                    for ($j = 1; $j <= count($cat_item); $j++)
                    {
                        $item_data = array(
                            'cat_id' => $cat_inserted->sno,
                            'item_name' => $cat_item[$j]
                        );

                        $list_insert = $this->model->insert('app_cat_items', $item_data);
                    }

                    $uri = base_url() . "admin/category";

                    redirect($uri);
                }

                $this->header = 200;

                $this->message = 'Category ' . $data['name'] . ' created succesfully.';

                $this->category();
            } else
            {
                throw new Exception('Category <i>' . $data['name'] . '</i> already exists.', '900');
            }
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();

            $this->page = 'admin/category/create';

            $this->root = 'admin/main';
            $this->response();
        }
    }

    private function edit($id)
    {
        try
        {

            $this->load->model('admin/adminmodel', 'model');
            
            $this->data['title'] = 'Category :: Edit';
            
            /*
             * Just get all the data in the post request
             */
            $data = $this->input->post(NULL, TRUE);
            
            $data1 = $this->input->post('name');
            
            $size = $this->input->post('size');
            
            $cat_item = array();

            if (empty($data))
            {
                $exist = $this->model->select('app_category', 'category_name', array('sno' => $id));
                
                if ($exist != false)
                {
                    $exist_list = $this->model->select('app_cat_items', 'item_name', array('cat_id' => $id));
                } else
                {
                    throw new Exception('Category does not exists.', '900');
                }
                
                $result_data = array(
                    'cat_info' => $exist,
                    'cat_item' => $exist_list
                );

                $this->data['result'] = $result_data;

                $this->page = 'admin/category/create';

                $this->header = 200;

                $this->message = 'Edit Category';

                $this->root = 'admin/main';

                $this->response();

                return;
            } else
            {
                for ($i = 1; $i <= $size; $i++)
                {
                    $cat_item[$i] = $this->input->post('item' . $i);
                }
                
                $cat_update = $this->model->update('app_category', array('category_name' => $data['name']), array('sno' => $id));

                if ($cat_update)
                {
                    $delet_item = $this->model->delete('app_cat_items', array('cat_id' => $id));
                    
                    for ($j = 1; $j <= count($cat_item); $j++)
                    {
                        $item_data = array(
                            'cat_id' => $id,
                            'item_name' => $cat_item[$j]
                        );

                        $list_update = $this->model->insert('app_cat_items', $item_data);
                    }

                    $uri = base_url() . "admin/category";

                    redirect($uri);
                }

                $this->header = 200;
                $this->message = 'Category ' . $data['name'] . ' created succesfully.';

                $this->category();
            }
        } catch (Exception $e)
        {
            $this->header = $e->getCode();

            $this->message = $e->getMessage();

            $this->page = 'admin/category/create';

            $this->root = 'admin/main';

            $this->response();
        }
    }

    private function delete($id)
    {
        try
        {
            $this->load->model('admin/adminmodel', 'model');

            $this->data['title'] = 'Category :: delete';

            $where_con = array(
                'sno' => $id
            );

            $delete_cat = $this->model->delete('app_category', $where_con);

            if ($delete_cat)
            {
                $where_cond = array(
                    'cat_id' => $id
                );
                $delete_cat_items = $this->model->delete('app_cat_items', $where_cond);
            } else
            {
                throw new Exception('Category does not exists.', '900');
            }

            $uri = base_url() . "admin/category";

            redirect($uri);
        } catch (Exception $e)
        {
            $this->header = $e->getCode();

            $this->message = $e->getMessage();

            $this->page = 'admin/category/create';

            $this->root = 'admin/main';

            $this->response();
        }
    }

}
