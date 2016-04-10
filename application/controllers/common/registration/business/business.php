<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : business.php
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

class BusinessRegister extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        unset($this->model);

        $this->load->model('common/common', 'model');

        $this->load->library('pin');

        $this->load->library('mcrypt');

        $this->load->library('session');

        $this->root = 'common/register';
    }

    public function register()
    {
        try
        {

            $cats = $this->model->select('app_category', 'category_name,sno', NULL, array('category_name' => 'asc'));

            if ($cats != false) {

                $this->data['cats'] = $cats;
            }

            $social_links = $this->model->select('social_links','*');
            
            $this->data['social_links'] = $social_links;
            
            $this->data['title'] = $this->title('Business', 'Registration');

            $this->data['nomenu'] = true;

            $data = $this->input->post(NULL, TRUE);

            if (empty($data))
            {
                $this->page = 'business/register';
                $this->message = 'We are happy to be associated with you.';
                return;
            }

            $this->data['data'] = $data;

            if (!isset($data['terms']) || strtolower(@$data['terms']) != 'accept')
            {

                throw new Exception('You must read and agree to terms and conditions and privacy policy.', '900');
            }

            if (empty($data['registrar']))
            {

                throw new Exception("please enter your name.", '900');
            }

            if (empty($data['business']))
            {

                throw new Exception('Please enter your business name.', '900');
            }

            if (empty($data['email']))
            {

                throw new Exception('Please enter your email address.', '900');
            }

            if (empty($data['phone']))
            {

                throw new Exception('Please enter your phone number.', '900');
            }

            if (empty($data['username']))
            {

                throw new Exception('Please enter a username.', '900');
            }

            if (strlen($data['username']) < 6)
            {

                throw new Exception('Username must be at least 6 characters.', '900');
            }

            if (empty($data['pass_1']) || empty($data['pass_2']))
            {

                throw new Exception('Please enter your password.', '900');
            }

            if ($data['pass_1'] != $data['pass_2'])
            {

                throw new Exception('Passwords do not match.', '900');
            }

            if (strlen($data['pass_1']) < 6)
            {

                throw new Exception('Password must be at least 6 characters.', '900');
            }

            $user = $this->model->select('business_members', 'username', array('username' => $data['username']), NULL, 1);

            if ($user != false)
            {

                throw new Exception('Username taken. Please try another.', '900');
            }

            $email = $this->model->select('business_members', 'username', array('email' => $data['email']), NULL, 1);

            if ($email != false)
            {

                throw new Exception('Email already taken.');
            }

            $insert = array(
                'business_name' => $data['business'],
                'person_name' => $data['registrar'],
                'email' => $data['email'],
                'username' => $data['username'],
                'password' => md5($data['pass_1']),
                'telephone' => $data['phone']
            );

            if (isset($data['sfi']) && strtolower(@$data['sfi'] == 'sfi'))
            {

                $insert['is_sfi'] = 1;

                if (!isset($data['sfi_profile']))
                {

                    throw new Exception('Please enter your SFI/TC profile link.', '900');
                } else
                {

                    if (empty($data['sfi_profile']))
                    {

                        throw new Exception('Please enter your SFI/TC profile link.', '900');
                    }
                }

                $insert['profile_link'] = implode(',', $data['sfi_profile']);
                
                $insert['invitation_gateway_link'] = $data['gateway'];
            }

            $insert = $this->model->insert('business_members', $insert);

            if (false == $insert)
            {
                throw new Exception('Some error occured while registering user. Please try later.', '900');
            }

            $last = $this->model->lastInsert();

            $pins = $this->model->select('unverified_business', 'pin');

            $excludes = array();

            if ($pins != false)
            {

                foreach ($pins as $pin)
                {

                    array_push($excludes, $pin['pin']);
                }
            }

            $this->pin->excludes($excludes);

            $pin = $this->pin->generate();

            $crypt = date('Y/m/d h:i:s');

            $this->mcrypt->set('string', $crypt);

            $this->mcrypt->set('key', KEY);

            $this->mcrypt->set('iv', IV);

            $this->mcrypt->set('error', false);

            $token = $this->mcrypt->eord('e');

            $insert = array();

            $insert = array(
                'bid' => $last,
                'pin' => $pin,
                'token' => $token
            );

            $added = $this->model->insert('unverified_business', $insert);

            if (!$added)
            {
                throw new Exception('Some internal error occured. However, your data has been saved. Please try after some time.', '900');
            }

            $this->load->library('mailer');

            $file = VIEWDIR . DS . 'emails' . DS . 'registration';

            $data['pin'] = $pin;

            $data['token'] = $token;

            $this->mailer->set('error', false);

            $headers = $this->mailer->activate('headers');

            $headers->
                    from('registrar@saffersmall.com')->
                    to($data['email'])->
                    subject('Business Registration :: Saffersmall')->
                    mime()->
                    charset()->
                    content()->
                    reply('do not reply')->
                    xmailer('Saffersmall Email Engine')->
                    process();

            $message = $this->mailer->activate('message');

            $message->
                    vars(array('data' => $data))->
                    read($file, 'business')->
                    process();

            $sent = $this->mailer->mail();

            $this->data['data'] = $data;

            if (!$sent)
            {

                $this->data['emailSent'] = false;

                $this->message = 'Some error occured while trying to send email. Please try later.';
            } else
            {

                $this->data['emailSent'] = true;

                $this->message = 'You have been succesfully registered.';
            }

            $this->page = 'business/activate';

            $this->header = 200;
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();

            $this->page = 'business/register';
            $this->data['nomenu'] = true;
        }
    }

    public function activate()
    {
        try
        {

            $token = $this->uri->segment(3);

            $this->data['nomenu'] = true;

            if (empty($token))
            {

                $this->pin();
            } else
            {

                $this->token($token);
            }

            $this->page = 'business/activate';
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();

            $this->page = 'business/activate';
        }
    }

    private function pin()
    {
        try
        {

            $data = $this->input->post(NULL, TRUE);

            if (empty($data))
            {
                throw new Exception('Please enter the activation pin sent to your email in the box below.', '900');
            }

            $pin = intval($data['pin']);

            if (empty($pin))
            {

                throw new Exception('Not a valid data has been entered as pin number.', '900');
            }

            $user = $this->model->select('unverified_business', 'bid', array('pin' => intval($pin)), NULL, 1);

            if (false == $user)
            {

                throw new Exception('Entered pin number is not valid.', '900');
            }

            $activate = $this->model->delete('unverified_business', array('pin' => $pin));

            if (!$activate)
            {

                throw new Exception('Some error occured while trying to activate your account.', '900');
            }
            
            else {
                
                $this->model->update('business_members',array('status'=>'A'), array('sno'=>$user->bid));
            }

            $this->login($user);
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();

            $this->page = 'business/activate';
        }
    }

    private function token($token)
    {
        try
        {

            $user = $this->model->select('unverified_business', 'bid', array('token' => $token), NULL, 1);

            if (false == $user)
            {

                throw new Exception('User does not exist.');
            }

            /*
             * Check if the token has expired
             */
            $this->load->library('mcrypt');

            $this->mcrypt->set('string', $token);

            $this->mcrypt->set('key', KEY);

            $this->mcrypt->set('iv', IV);

            $this->mcrypt->set('error', false);

            $date = $this->mcrypt->eord('d');

            $d1 = new DateTime(date('Y/m/d h:i:s'));

            $d2 = new DateTime(date('Y/m/d h:i:s', strtotime($date)));

            $diff = date_diff($d1, $d2, TRUE);

            if ($diff->y > 0 || $diff->m > 0 || $diff->d > 0)
            {

                $this->data['need_refresh'] = true;

                throw new Exception('Your activation token has expired.', '900');
            }

            $activate = $this->model->delete('unverified_business', array('token' => $token));

            if (!$activate)
            {

                throw new Exception('Some error occured while trying to activate your account.', '900');
            }

            $this->login($user);
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();

            $this->page = 'business/activate';
        }
    }

    protected function login($user)
    {
        try
        {
            $user = $this->model->select('business_members', 'username', array('sno' => $user->bid), NULL, 1);

            if (false == $user)
            {

                throw new Exception('Seems you do not have an account.', '900');
            }

            $this->session->set_userdata('username', $user->username);

            $this->session->set_userdata('login_type', 'business');

            $this->input->set_cookie(array('name' => 'sfid', 'value' => sha1($user->sno) . md5($config['encryption_key']), 'expire' => 2592000));

            $this->session->set_userdata('first_user', true);

            $this->header('dashboard');
        } catch (Exception $e)
        {
            $this->header = $e->getCode();
            $this->message = $e->getMessage();

            $this->page = 'business/activate';
        }
    }

}
