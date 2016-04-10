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

class Invitation_gateway_links extends CI_Controller {

    protected $target;

    public function __construct() {
        parent::__construct();

        $this->root = 'admin/main';

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

                $file = CONTROLDIR . DS . 'admin' . DS . 'invitation_gateway_links' . DS . strtolower($target) . EXT;

                if (file_exists($file)) {

                    $this->control = $this->load->controller(ucfirst($target), 'admin' . DS . 'invitation_gateway_links' . DS . strtolower($target));
                } else {
                    $this->control = $this->load->controller(ucfirst($target), 'common' . DS . 'invitation_gateway_links' . DS . strtolower($target));
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
                    $this->invitation_gateway_links();
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

    private function invitation_gateway_links() {
        try {
            $post = $this->model1->select('invitation_gateway_links', '*');

            if (true == $post) {
                $this->data['result'] = $post;
            } else {
                $this->data['result'] = NULL;
            }

            $this->page = 'admin/invitation_gateway_links/invitation_gateway_links';

            $this->header = 200;

            $this->message = 'Step :: first loaded successfully.';

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

            $this->data['title'] = 'Invitation Gateway Link :: Add';
            /*
             * Just get all the data in the post request
             */
            $data = $this->input->post(NULL, TRUE);
            if (empty($data)) {
                $this->page = 'admin/invitation_gateway_links/create';

                $this->header = 200;

                $this->message = 'Add a Link.';

                $this->response();
                return;
            }

            $link = strtolower($data['link']);
            
            $exist = $this->model->select('invitation_gateway_links', 'link', array('link' => $link), NULL, '1');


            if ($exist == false) {
                /*
                 * Add a new link
                 */
               

                    $insert = $this->model->insert('invitation_gateway_links', array('link'=>$link));

                    $this->header("admin/invitation_gateway_links");

                    return $this;
                
            } else {
                throw new Exception($data['link'] . '</i> already exists.', '900');
            }
        } catch (Exception $e) {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();

            $this->page = 'admin/invitation_gateway_links/create';

            $this->response();
        }
    }

    private function edit($id) {
        try {

            $this->load->model('admin/adminmodel', 'model');

            $this->data['title'] = 'Invitataion Gateway Link :: Edit';

            /*
             * Just get all the data in the post request
             */
            $data = $this->input->post(NULL, TRUE);

            $data1 = $this->input->post('link');

            $link = strtolower($data['link']);

            $post = $this->model->select('invitation_gateway_links', '*', array('sno' => $id));

            if (empty($data)) {

                if ($post == false) {
                    throw new Exception('link does not exists.', '900');
                }

                $this->data['result'] = $post;

                $this->page = 'admin/invitation_gateway_links/create';

                $this->header = 200;

                $this->message = 'Edit the link.';

                $this->root = 'admin/main';

                $this->response();

                return;
            } else {
                

                    $post_update = $this->model->update('invitation_gateway_links', array('link'=>$link), array('sno' => $id));

                    $this->header("admin/invitation_gateway_links");

                    return $this;
               
            }
        } catch (Exception $e) {
            $this->header = $e->getCode();

            $this->message = $e->getMessage();

            $this->page = 'admin/invitation_gateway_links/create';

            $this->root = 'admin/main';

            $this->response();
        }
    }

    private function delete($id) {
        try {
            $this->load->model('admin/adminmodel', 'model');

            $this->data['title'] = 'Invitation Gateway Link :: delete';

            $where_con = array(
                'sno' => $id
            );

            $delete_cat = $this->model->delete('invitation_gateway_links', $where_con);
            if ($delete_cat) {
                $uri = base_url() . "admin/invitation_gateway_links";
                redirect($uri);
            } else {
                throw new Exception('Post does not exists.', '900');
            }
        } catch (Exception $e) {
            $this->header = $e->getCode();

            $this->message = $e->getMessage();

            $this->page = 'admin/invitation_gateway_links/create';

            $this->root = 'admin/main';

            $this->response();
        }
    }

}
