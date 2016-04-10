<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
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

class Forgot_password extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        
        unset($this->model);
        
        $this->load->model('common/common', 'model');  
    }

    public function enter()
    {
        try { 
            
            $this->root = 'common/login';

            $data = $this->input->post();

            $this->data['title'] = $this->title('Login', 'Forgot Password');

            
            $this->header = 200;

            if (empty($data)) {
                
                //$this->data['nomenu'] = true;
                $this->data['nomenu'] = true;

                $this->page = 'business/forgot_password';
               
                $this->response();

                //$this->message = 'Please login before we can continue..';

                return;
            }

            $loginType = $this->input->get('type');

            $email = $this->input->post('email');

            switch (strtolower($loginType)) {
                case 'user':
                    self::forgotForm($loginType);
                    break;

                case 'business':
                    self::forgotForm($loginType);
                    break;

                case 'admin':
                    self::forgotForm();
                    break;

                default:

                    show_404();
            }
            
        } catch (Exception $e) {
            
            $this->header = $e->getCode();
            
            $this->message = $e->getMessage();

            $this->data['nomenu'] = true;

            $this->page = 'business/login';
        }
    }
    
    private function forgotForm($loginType = null)
    {
        
         $this->root = 'common/login';
         
           $this->data['nomenu'] = true;

        $d = $this->input->post(NULL, TRUE);

        if ($loginType == 'business')
        {
            $table = 'business_members';
        } else
        {
            $table = 'app_admin';
        }
        
        if (!empty($d))
        { 
            $user = $this->model->select($table, 'sno, username', array('email' => $d['email']), NULL, 1);
            
            if (false == $user)
            {
                $this->data['message'] = 'Email was not found registered on the our site.';
            } else
            {
                $this->data['username'] = $user->username;

                $this->data['loginType'] = $loginType;

                //$pins = $this->model->select('app_users', 'pin');

                $exclude = array();

//                foreach ($pins as $p)
//                {
//                    $p = (object) $p;
//
//                    if (empty($p->pin))
//                    {
//                        continue;
//                    }
//
//                    $exclude[] = $p->pin;
//                }

                $this->load->library('pin');

                $this->pin->excludes($exclude);

                $pin = $this->pin->generate();

                //$update = $this->model->update($table, array('pin' => $pin), array('email' => $d['email']));

//                if (!$update)
//                {
//                    $data['message'] = 'Some internal error occured. Please try later.';
//                } else
                {

                    $this->load->library('mailer');

                    $fileDir = VIEWDIR . DS . 'fragments' . DS . 'mails';

                    $this->mailer->set('error', false);

                    $headers = $this->mailer->activate('headers');

                    $d['pin'] = $pin;

//                    $headers->
//                            to($d['email'])->
//                            from('info@grasshopit.com')->
//                            subject('Account Recovery')->
//                            mime()->
//                            charset()->
//                            content()->
//                            reply('do not reply')->
//                            xmailer('Grasshopit Mailer')->
//                            process();
//
//                    $message = $this->mailer->activate('message');
//
//                    $message->
//                            vars($d)->
//                            read($fileDir, 'recover')->
//                            process();
//
//                    $sent = $this->mailer->mail();
//
//                    if (!$sent)
//                    {
//                        $data['message'] = 'Sorry we could not send recovery email this time. Please try after sometime.';
//                    } else
                    { 
                        $this->data['message'] = 'We have sent you an activation email. Please enter the activation pin in the following form below.';

                        $this->data['email'] = $d['email'];
                        
                        $unverified_data = array(
                            'bid'=>$user->sno,
                            'pin'=>$pin,
                            'reason'=>'F'
                        );
                        
                        $this->model->insert('unverified_business',$unverified_data);
                        
                        $this->page = 'business/recovery-form';
               
                        $this->response();

                        return;
                    }
                }
            }

            $this->data['email'] = $d['email'];
        }

        $this->page = 'business/forgot_password';
               
        $this->response();

    }
}
