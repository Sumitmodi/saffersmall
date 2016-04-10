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

class Admin_logos extends CI_Controller {

    protected $target;

    public function __construct() {
        parent::__construct();

        $this->root = 'admin/main';

        $this->load->library('imageuploader');

        unset($this->model);

        $this->load->model('common/common', 'model1');
    }

    public function enter() {
        try {
            $target = $this->uri->segment(3);
            /*
             * If there an item in the 3nd uri segment attempt to 
             * load it. First check it is a module of business controller
             * then check if its a common module.
             */
            if (!empty($target)) {

                $file = CONTROLDIR . DS . 'admin' . DS . 'admin_logos' . DS . strtolower($target) . EXT;

                if (file_exists($file)) {

                    $this->control = $this->load->controller(ucfirst($target), 'admin' . DS . 'admin_logos' . DS . strtolower($target));
                } else {
                    $this->control = $this->load->controller(ucfirst($target), 'common' . DS . 'admin_logos' . DS . strtolower($target));
                    /*
                     * Not yet sure about it though.
                     * Lets see what it takes in the future.
                     * Just tried to make sure although its an external module,
                     * it stays within the business dashboard theme.
                     */
                }
                $this->control->$target();
            } else {
                $target = $this->input->get('target', TRUE);

                if (empty($target)) {
                    $target = $this->input->get('_', TRUE);
                }

                if (empty($target)) {
                    $this->admin_logos();
                } else {
                    $id = $this->input->get('id', TRUE);
                    $this->$target($id);
                }
            }
        } catch (Exception $e) {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();

        }
    }

    private function admin_logos() {
        try {
            $post = $this->model1->select('admin_logos', '*');

            if (true == $post) {
                $this->data['result'] = $post;
            } else {
                $this->data['result'] = NULL;
            }

            $this->page = 'admin/admin_logos/admin_logos';

            $this->header = 200;

            $this->root = 'admin/main';

            $this->response();
            
        } catch (Exception $e) {
            $this->header = $e->getCode();

            $this->message = $e->getMessage();

        }
    }

    private function add() {
        try {
            $this->load->model('admin/adminmodel', 'model');

            $this->data['title'] = 'Admin Logos :: Add';
            /*
             * Just get all the data in the post request
             */
            $data = $this->input->post(NULL, TRUE);
            if (empty($data)) {
                $this->page = 'admin/admin_logos/create';

                $this->header = 200;

                $this->message = 'Add a logo.';

                $this->response();
                return;
            }

            $files = $_FILES;

            $title = strtolower($data['title']);
            
            $exist = $this->model->select('admin_logos', 'title', array('title' => $title), NULL, '1');


            if ($exist == false) {
                /*
                 * Add a new link
                 */
                
                $dir = BASEDIR.'/assets/uploads/logos';
                
                if(!file_exists($dir)){
                    mkdir($dir);
                }

                if ($files['admin_logo']['error'] != 4) {
                    $this->imageuploader->
                            set('file', $files)->
                            set('name', 'admin_logo')->
                            set('uploadType', 'single')->
                            set('fileType', 'image')->
                            set('root', BASEDIR)->
                            set('directory', 'assets/uploads/logos')->
                            set('minWidth', 30)->
                            set('minHeight', 30);

                    if ($logoUpload = $this->imageuploader->upload()) {
                        $logoFile = $this->imageuploader->get('fileName');
                    }
                } else {
                    throw new Exception('Logo should not be empty', '900');
                }


                if ($logoUpload) {
                    $post_data = array(
                        'title' => $title,
                        'link' => $data['link'],
                        'logo' => $logoFile
                    );

                    $insert = $this->model->insert('admin_logos', $post_data);

                    $this->header("admin/admin_logos");

                    return $this;
                } else {
                    throw new Exception('There is something error in image upload', '900');
                }
            } else {
                throw new Exception('The <i>' . $data['title'] . '</i> already exists.', '900');
            }
        } catch (Exception $e) {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();

            $this->page = 'admin/admin_logos/create';

            $this->response();
        }
    }

    private function edit($id) {
        try {

            $this->load->model('admin/adminmodel', 'model');

            $this->data['title'] = 'Admin Logos :: Edit';

            /*
             * Just get all the data in the post request
             */
            $data = $this->input->post(NULL, TRUE);

            $data1 = $this->input->post('title');

            $files = $_FILES;
            
            $title = strtolower($data['title']);

            $post = $this->model->select('admin_logos', '*', array('sno' => $id));

            if (empty($data)) {

                if ($post == false) {
                    throw new Exception('Post does not exists.', '900');
                }

                $this->data['result'] = $post;

                $this->page = 'admin/admin_logos/create';

                $this->header = 200;

                $this->message = 'Edit the Logo.';

                $this->root = 'admin/main';

                $this->response();

                return;
            } else {
                if ($post[0]['logo'] != '') {
                    $filename = BASEDIR . "/assets/uploads/logos/" . $post[0]['logo'];

                    if (file_exists($filename)) {
                        unlink($filename);
                    }
                }
                if ($files['admin_logo']['error'] != 4) {
                    $this->imageuploader->
                            set('file', $files)->
                            set('name', 'admin_logo')->
                            set('uploadType', 'single')->
                            set('fileType', 'image')->
                            set('root', BASEDIR)->
                            set('directory', 'assets/uploads/logos')->
                            set('minWidth', 30)->
                            set('minHeight', 30);

                    if ($logoUpload = $this->imageuploader->upload()) {
                        $logoFile = $this->imageuploader->get('fileName');
                    }
                } else {
                    throw new Exception('Logo should not be empty', '900');
                }

                
                if ($logoUpload) {
                    $post_data = array(
                        'title' => $title,
                        'link' => $data['link'],
                        'logo' => $logoFile
                    );

                    $post_update = $this->model->update('admin_logos', $post_data, array('sno' => $id));

                    $this->header("admin/admin_logos");

                    return $this;
                } else {
                    throw new Exception('There is something error in image upload', '900');
                }
            }
        } catch (Exception $e) {
            $this->header = $e->getCode();

            $this->message = $e->getMessage();

            $this->page = 'admin/admin_logos/create';

            $this->root = 'admin/main';

            $this->response();
        }
    }

    private function delete($id) {
        try {
            $this->load->model('admin/adminmodel', 'model');

            $this->data['title'] = 'Admin Logos :: delete';

            $where_con = array(
                'sno' => $id
            );

            $delete_cat = $this->model->delete('admin_logos', $where_con);
            if ($delete_cat) {
                $uri = base_url() . "admin/admin_logos";
                redirect($uri);
            } else {
                throw new Exception('Post does not exists.', '900');
            }
        } catch (Exception $e) {
            $this->header = $e->getCode();

            $this->message = $e->getMessage();

            $this->page = 'admin/admin_logos/create';

            $this->root = 'admin/main';

            $this->response();
        }
    }

}
