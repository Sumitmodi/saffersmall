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

class Sfi_control extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->root = 'admin/main';

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

                $file = CONTROLDIR . DS . 'admin' . DS . 'sfi_control' . DS . strtolower($target) . EXT;

                if (file_exists($file))
                {

                    $this->control = $this->load->controller(ucfirst($target), 'admin' . DS . 'sfi_control' . DS . strtolower($target));
                } else
                {
                    $this->control = $this->load->controller(ucfirst($target), 'common' . DS . 'sfi_control' . DS . strtolower($target));
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
                    $this->sfi_control();
                } else
                {
                    $this->control = $this->load->controller(ucfirst($target), 'admin' . DS . 'sfi_control_business' . DS . strtolower($target));
                }

                $action = $this->input->get('action', TRUE);

                $id = $this->input->get('id', TRUE);

                if (!empty($target))
                {
                    $this->control->$action($id);
                }
            }
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();

            $this->page = 'business/sfi_control/sfi_control';
        }
    }

    private function sfi_control()
    {
        try
        {

            $user = $this->model1->select('business_members', '*', array('status !=' => 'B', 'is_sfi' => 1));

            if (true == $user)
            {
                $this->data['result'] = $user;
            } else
            {
                $this->data['result'] = NULL;
            }

            $this->data['title'] = $this->title('SFI', 'Members');
            
            $this->page = 'admin/sfi_control/sfi_control';
            
            $this->header = 200;
            
            $this->message = 'SFI Members Dashboard. Monitor your SFI\'s here.';
            
            $this->root = 'admin/main';
            
            $this->response();
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();

            $this->page = 'business/sfi_control/sfi_control';
        }
    }

}
