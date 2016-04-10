<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : step4.php
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

class Step4 extends CI_Controller {

    public function __construct() {
        parent::__construct();     

        $this->load->library('session');
    }

    public function manage() {
        try {

            set_time_limit(0);

            $this->data['title'] = $this->title('Place Ad', 'Step 4');

            $this->data['class'] = 'placead';

            $data = $_POST;

            $files = $_FILES;

            $this->load->library('imageuploader');

            $imgs = $this->session->userdata('images');            
            
            if (empty($imgs)) {

                if (isset($files['images'])):

                    $this->imageuploader->
                            set('file', $files)->
                            set('name', 'images')->
                            set('uploadType', 'multiple')->
                            set('fileType', 'image')->
                            set('root', BASEDIR)->
                            set('directory', 'assets/uploads/products/images')->
                            set('minWidth', 150)->
                            set('minHeight', 150);

                    if ($this->imageuploader->upload()) {

                        $uploaded = $this->imageuploader->get('fileName');

                        if (count($uploaded) == 0) {

                            throw new Exception('For some images were not uploaded.', '900');
                        } else {

                            $this->session->set_userdata('images', implode(',', $uploaded));
                                                       
                        }
                    } else {

                        throw new Exception('Images could not uploaded. Please try later.', '900');
                    }
                else:

                    throw new Exception('Please select at least one image.');
                endif;
            }

            $vdos = $this->session->userdata('video');

            if (empty($vdos)) {

                if ($files['video']['error'] == 0):

                    $uploader = $this->imageuploader->
                            set('file', $files)->
                            set('name', 'video')->
                            set('uploadType', 'single')->
                            set('fileType', 'video')->
                            set('root', BASEDIR)->
                            set('directory', 'assets/uploads/products/videos');

                    if ($uploader->upload()) {

                        $name = $uploader->get('fileName');

                        if (!empty($name)) {

                            $this->session->set_userdata('video', $name);

                            $vup = true;
                        }
                    } else {

                        throw new Exception('video could not be uploaded.', '900');
                    }

                endif;
            }

            if (!isset($vup) || @$vup == flase) {

                if (!empty($data['url'])) {

                    $this->session->set_userdata('video', $data['url']);
                }
            }
            
            $this->header = 200;
            
            $this->message = 'Your data saved successfully.';
          
            $this->header('dashboard/placead?_=5');
        } catch (Exception $e) {
            $this->header = $e->getCode();

            $this->message = $e->getMessage();
           
            $this->page = 'placead/step3';
        }
    }

}
