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

class Admin_post extends CI_Controller
{

    protected $target;

    public function __construct()
    {
        parent::__construct();

        $this->root = 'admin/main';

        $this->load->library('imageuploader');
        
        unset($this->model);
        
        $this->load->model('common/common', 'model1');
    }

    public function enter()
    {
        try
        {
            $target = $this->uri->segment(3);
            /*
             * If there an item in the 3nd uri segment attempt to 
             * load it. First check it is a module of business controller
             * then check if its a common module.
             */
            if (!empty($target))
            {

                $file = CONTROLDIR . DS . 'admin' . DS . 'admin_post' . DS . strtolower($target) . EXT;

                if (file_exists($file))
                {

                    $this->control = $this->load->controller(ucfirst($target), 'admin' . DS . 'admin_post' . DS . strtolower($target));
                } else
                {
                    $this->control = $this->load->controller(ucfirst($target), 'common' . DS . 'admin_post' . DS . strtolower($target));
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
                    $this->admin_post();
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

    private function admin_post()
    {
        try
        {
            $post = $this->model1->select('admin_post', '*');

            if (true == $post)
            {
                $this->data['result'] = $post;
            } else
            {
                $this->data['result'] = NULL;
            }

            $this->page = 'admin/admin_post/admin_post';

            $this->header = 200;

            $this->message = 'Step :: first loaded successfully.';

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

            $this->data['title'] = 'Post :: Add';
            /*
             * Just get all the data in the post request
             */
            $data = $this->input->post(NULL, TRUE);
            if (empty($data))
            {
                $this->page = 'admin/admin_post/create';

                $this->header = 200;

                $this->message = 'Add a post.';

                $this->response();
                return;
            }

            $files = $_FILES;

            $exist = $this->model->select('admin_post', 'name', array('name' => $data['name']), NULL, '1');

            if ($exist == false)
            {
                /*
                 * Add a new category
                 */
                if (isset($files['post_image']))
                {
                    $this->imageuploader->
                            set('file', $files)->
                            set('name', 'post_image')->
                            set('uploadType', 'single')->
                            set('fileType', 'image')->
                            set('root', BASEDIR)->
                            set('directory', 'assets/uploads/posts')->
                            set('minWidth', 150)->
                            set('minHeight', 150);
                }
                if ($this->imageuploader->upload())
                {
                    $post_data = array(
                        'title' => $data['title'],
                        'name' => $data['name'],
                        'content' => $data['content'],
                        'image' => $this->imageuploader->get('fileName'),
                        'status' => 'B'
                    );
                    $insert = $this->model->insert('admin_post', $post_data);

                    if ($insert == false)
                    {
                        throw new Exception('Some error occurred while adding new post.', '900');
                    } else
                    {

                        $uri = base_url() . "admin/admin_post";
                        redirect($uri);
                    }
                }
            } else
            {
                throw new Exception('Post <i>' . $data['name'] . '</i> already exists.', '900');
            }
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();

            $this->page = 'admin/admin_post/create';

            $this->response();
        }
    }

    private function edit($id)
    {
        try
        {

            $this->load->model('admin/adminmodel', 'model');

            $this->data['title'] = 'Post :: Edit';
            
            /*
             * Just get all the data in the post request
             */
            $data = $this->input->post(NULL, TRUE);
            
            $data1 = $this->input->post('name');

            $cat_item = array();

            $files = $_FILES;

            $post = $this->model->select('admin_post', '*', array('sno' => $id));

            if (empty($data))
            {

                if ($post == false)
                {
                    throw new Exception('Post does not exists.', '900');
                }
                
                $this->data['result'] = $post;
                
                $this->page = 'admin/admin_post/create';
                
                $this->header = 200;
                                
                $this->message = 'Edit the post.';
                
                $this->root = 'admin/main';
                
                $this->response();

                return;
            } else
            {
                $filename = BASEDIR . "/assets/uploads/posts/" . $post[0]['image'];

                if (file_exists($filename))
                {
                    unlink($filename);
                }
                
                if (isset($files['post_image']))
                {
                    $this->imageuploader->
                            set('file', $files)->
                            set('name', 'post_image')->
                            set('uploadType', 'single')->
                            set('fileType', 'image')->
                            set('root', BASEDIR)->
                            set('directory', 'assets/uploads/posts')->
                            set('minWidth', 150)->
                            set('minHeight', 150);

                    if ($this->imageuploader->upload())
                    {

                        $post_data = array(
                            'title' => $data['title'],
                            'name' => $data['name'],
                            'content' => $data['content'],
                            'image' => $this->imageuploader->get('fileName'),
                            'status' => 'B'
                        );

                        $post_update = $this->model->update('admin_post', $post_data, array('sno' => $id));

                        $this->header("admin/admin_post");

                        return $this;
                    }
                } else
                {
                    throw new Exception('Please select the image.', '900');

                    $this->data['result'] = $post;

                    $this->page = 'admin/admin_post/create';

                    $this->header = 200;

                    $this->message = 'Edit the post.';

                    $this->root = 'admin/main';

                    $this->response();

                    return;
                }
            }
        } catch (Exception $e)
        {
            $this->header = $e->getCode();

            $this->message = $e->getMessage();

            $this->page = 'admin/admin_post/create';

            $this->root = 'admin/main';

            $this->response();
        }
    }

    private function delete($id)
    {
        try
        {
            $this->load->model('admin/adminmodel', 'model');
            
            $this->data['title'] = 'Post :: delete';
            
            $where_con = array(
                'sno' => $id
            );

            $delete_cat = $this->model->delete('admin_post', $where_con);
            if ($delete_cat)
            {
                $uri = base_url() . "admin/admin_post";
                redirect($uri);
            } else
            {
                throw new Exception('Post does not exists.', '900');
            }
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            
            $this->message = $e->getMessage();
          
            $this->page = 'admin/admin_post/create';

            $this->root = 'admin/main';
            
            $this->response();
        }
    }

}
