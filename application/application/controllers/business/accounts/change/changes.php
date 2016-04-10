<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : changes.php
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

class Change extends CI_Controller {

    public function __construct() {

        parent::__construct();

        if (!empty($this->model)) {

            unset($this->model);
        }

        $this->load->model('common/common', 'model');

        $this->activity = $this->load->controller('Activity', 'common/activity/activity');

        $this->activity->set('table', 'user_activity');
    }

    public function enter($method) {

        try {

            if (method_exists($this, strtolower($method))) {

                $this->{$method}();
            } else {

                show_404();
            }
        } catch (Exception $e) {

            $this->header = $e->getCode();

            $this->message = $e->getMessage();
        }
    }

    private function name() {
        try {

            $data = $this->input->post(NULL, TRUE);

            if (false == $data) {

                throw new Exception('Please enter your name.', '200');
            }

            $user = $this->model->select('business_members', 'sno,password,username', array('username' => $this->session->userdata('username')), NULL, 1);

            if (false == $user) {

                throw new Exception('User does not exist.', '900');
            }

            if (md5($data['password']) != $user->password) {

                throw new Exception('Your entered password did not match with the account password.', 900);
            }

            $update = $this->model->update('business_members', array('person_name' => $data['name']), array('username' => $user->username, 'password' => md5($data['password'])));

            if (false == $update) {

                throw new Exception('Some error occured. Please try later.', 900);
            }

            $this->header = 200;

            $this->message = 'Name changed successfully.';

            $this->page = 'business/response';
        } catch (Exception $e) {
            $this->header = $e->getCode();

            $this->message = $e->getMessage();

            $this->page = 'business/forms/name';
        }
    }

    private function email() {
        try {

            $data = $this->input->post(NULL, TRUE);

            if (false == $data) {

                throw new Exception('Please enter your email.', '200');
            }

            $user = $this->model->select('business_members', 'sno,password,username,email', array('username' => $this->session->userdata('username')), NULL, 1);

            if (false == $user) {

                throw new Exception('User does not exist.', '900');
            }

            if (md5($data['password']) != $user->password) {

                throw new Exception('Your entered password did not match with the account password.', 900);
            }

            $this->load->library('pin');

            $this->load->library('mcrypt');

            $pins = $this->model->select('unverified_business', 'pin');

            $temp = array();

            if ($pins != false) {

                foreach ($pins as $p) {

                    array_push($temp, $p['pin']);
                }
            }

            $this->pin->excludes($temp);

            $pin = $this->pin->generate();

            if ((bool) $pin == false) {

                throw new Exception('Some internal error occured. Please try later.', '900');
            }

            $crypt = date('Y/m/d h:i:s');

            $this->mcrypt->set('string', $crypt);

            $this->mcrypt->set('key', KEY);

            $this->mcrypt->set('iv', IV);

            $this->mcrypt->set('error', true);

            $token = $this->mcrypt->eord('e');

            if ((bool) $token == false) {

                throw new Exception('Some internal error occured. Please try later.', '900');
            }

            $insert = array('bid' => $user->sno, 'pin' => $pin, 'token' => $token);

            if (!$this->model->insert('unverified_business', $insert)) {

                throw new Exception('Some internal error occured.', '900');
            }

            $update = $this->model->update('business_members', array('email' => $data['email']), array('username' => $user->username, 'password' => md5($data['password'])));

            if (false == $update) {

                throw new Exception('Some error occured. Please try later.', 900);
            }


            $insert['user'] = $user->username;

            $insert['old'] = $user->email;

            $insert['new'] = $data['email'];


            $this->load->library('mailer');

            $file = VIEWDIR . DS . 'emails' . DS . 'activation';

            $this->mailer->set('error', false);

            $headers = $this->mailer->activate('headers');

            $headers->
                    from('registrar@saffersmall.com')->
                    to($data['email'])->
                    subject('Email Verification :: Saffersmall')->
                    mime()->
                    charset()->
                    content()->
                    reply('do not reply')->
                    xmailer('Saffersmall Email Engine')->
                    process();

            $message = $this->mailer->activate('message');

            $message->
                    vars($insert)->
                    read($file, 'email')->
                    process();

            $sent = $this->mailer->mail();

            $this->header = 200;

            if (!$sent) {

                $this->message = 'Some error occured while trying to send email. Please try later.';
            } else {

                $this->message = 'Email changed successfully. Please check your email.';
            }

            $activity = array(
                'bid' => $user->sno,
                'activity' => "Changed email from &quot;{$user->email}&quot; to &quot;{$data['email']}&quot;."
            );

            $this->activity->set('activity', $activity);
            $this->activity->log();

            $this->page = 'business/change/email';
        } catch (Exception $e) {

            $this->header = $e->getCode();

            $this->message = $e->getMessage();

            $this->page = 'business/forms/email';
        }
    }

    private function username() {
        try {

            $data = $this->input->post(NULL, TRUE);

            if (empty($data)) {

                $this->page = 'business/forms/username';

                throw new Exception('Your current username is : ' . $this->session->userdata('username'), '200');
            }

            if (empty($data['username'])) {

                throw new Exception('Please enter a valid username.', '900');
            }

            $user = $this->model->select('business_members', 'sno,username', array('username' => $this->session->userdata('session')), NULL, 1);

            if (false == $user) {

                throw new Exception('User does not exist.', '900');
            }

            $taken = $this->model->select('business_members', 'sno,password,username', array('username' => $data['username']), NULL, 1);

            if ($taken != false) {

                if ($taken->username == $this->session->userdata('username')) {

                    throw new Exception('Please select another username.', '900');
                } else {

                    if (md5($data['password']) != $taken->password) {

                        throw new Exception('Password did not match.', '900');
                    }

                    throw new Exception('The username is already taken.', '900');
                }
            } else {

                if (strlen($data['username']) < 6) {

                    throw new Exception('Username must be at least 6 characters.', '900');
                }

                $update = $this->model->update('business_members', array('username' => $data['username']), array('username' => $this->session->userdata('username')));

                if (false == $update) {

                    throw new Exception('Error updating username. Please try later.', '900');
                } else {

                    $this->session->set_userdata('username', $data['username']);

                    $this->header = 200;

                    $this->message = 'Username changed successfully.';
                }
            }

            $activity = array(
                'bid' => $user->sno,
                'activity' => "Changed username from &quot;{$user->username}&quot; to &quot;{$data['username']}&quot;"
            );

            $this->activity->set('activity', $activity);
            $this->activity->log();

            $this->header = 200;

            $this->page = 'business/response';
        } catch (Exception $e) {

            $this->header = $e->getCode();

            $this->message = $e->getMessage();

            $this->page = 'business/forms/username';
        }
    }

    private function password() {
        try {
            
        } catch (Exception $e) {

            $this->header = $e->getCode();

            $this->message = $e->getMessage();
        }
    }

    private function address() {
        try {
            
            $data = $this->input->post(NULL,TRUE);
            
            if(empty($data)){
                
                throw new Exception('Please enter your address.','200');
            }
            
            $user = $this->model->select('business_members','sno,email,address,username',array('username'=>$this->session->userdata('username'),'password'=>md5($data['password'])),NULL,1);
            
            if(false == $user){
                
                throw new Exception('User does not exist.','900');
            }
            
            if(empty($data['address'])){
                
                throw new Exception('Please enter a valid address.','900');
            }
            
            $update = array('address'=>$data['address']);
            
            if(!$this->model->update('business_members',$update,array('username'=>$user->username))){
                
                throw new Exception('Some internal occured and data could not be saved. Please try later.','9000');
            }
            
            if(empty($user->address)){
                
                $activity['activity'] = 'Added business address &quot;'.$data['address'].'&quot.';                
            } else{
                
                $activity['activity'] = "Changed business address from &quot;{$user->address}&quot; to &quot;{$data['address']}&quot;.";
            }
            
            $activity['bid'] = $user->sno;
            
            $this->activity->set('activity',$activity);
            
            $this->activity->log();
            
            $this->header = 200;
            
            $this->message = 'Address Saved Successfully.';
            
            $this->page = 'business/response';
            
        } catch (Exception $e) {
            
            $this->header = $e->getCode();
            
            $this->message = $e->getMessage();
            
            $this->page = 'business/forms/address';
        }
    }    
    
    private function postal() {
        try {
            
            $data = $this->input->post(NULL,TRUE);
            
            if(empty($data)){
                
                throw new Exception('Please enter your pin number.','200');
            }
            
            $user = $this->model->select('business_members','sno,email,postal_code,username',array('username'=>$this->session->userdata('username'),'password'=>md5($data['password'])),NULL,1);
            
            if(false == $user){
                
                throw new Exception('User does not exist.','900');
            }
            
            if(empty($data['postal_code'])){
                
                throw new Exception('Please enter a valid pin number.','900');
            }
            
            $update = array('postal_code'=>$data['postal_code']);
            
            if(!$this->model->update('business_members',$update,array('username'=>$user->username))){
                
                throw new Exception('Some internal occured and data could not be saved. Please try later.','9000');
            }
            
            if(empty($user->postal_code)){
                
                $activity['activity'] = 'Added business pin code &quot;'.$data['postal_code'].'&quot.';                
            } else{
                
                $activity['activity'] = "Changed business pin code from &quot;{$user->postal_code}&quot; to &quot;{$data['postal_code']}&quot;.";
            }
            
            $activity['bid'] = $user->sno;
            
            $this->activity->set('activity',$activity);
            
            $this->activity->log();
            
            $this->header = 200;
            
            $this->message = 'Postal Code Saved Successfully.';
            
            $this->page = 'business/response';
            
        } catch (Exception $e) {
            
            $this->header = $e->getCode();
            
            $this->message = $e->getMessage();
            
            $this->page = 'business/forms/pincode';
        }
    }
        
    private function country() {
        try {
            
            $data = $this->input->post(NULL,TRUE);
            
            if(empty($data)){
                
                throw new Exception('Please enter your country.','200');
            }
            
            $user = $this->model->select('business_members','sno,email,country,username',array('username'=>$this->session->userdata('username'),'password'=>md5($data['password'])),NULL,1);
            
            if(false == $user){
                
                throw new Exception('User does not exist.','900');
            }
            
            if(empty($data['country'])){
                
                throw new Exception('Please enter your country.','900');
            }
            
            $update = array('country'=>$data['country']);
            
            if(!$this->model->update('business_members',$update,array('username'=>$user->username))){
                
                throw new Exception('Some internal occured and data could not be saved. Please try later.','9000');
            }
            
            if(empty($user->country)){
                
                $activity['activity'] = 'Added country &quot;'.$data['country'].'&quot.';                
            } else{
                
                $activity['activity'] = "Changed country from &quot;{$user->country}&quot; to &quot;{$data['country']}&quot;.";
            }
            
            $activity['bid'] = $user->sno;
            
            $this->activity->set('activity',$activity);
            
            $this->activity->log();
            
            $this->header = 200;
            
            $this->message = 'Country Saved Successfully.';
            
            $this->page = 'business/response';
            
        } catch (Exception $e) {
            
            $this->header = $e->getCode();
            
            $this->message = $e->getMessage();
            
            $this->page = 'business/forms/country';
        }
    }
    
    private function state() {
        try {
            
            $data = $this->input->post(NULL,TRUE);
            
            if(empty($data)){
                
                throw new Exception('Please enter your state.','200');
            }
            
            $user = $this->model->select('business_members','sno,state,username',array('username'=>$this->session->userdata('username'),'password'=>md5($data['password'])),NULL,1);
            
            if(false == $user){
                
                throw new Exception('User does not exist.','900');
            }
            
            if(empty($data['state'])){
                
                throw new Exception('Please enter your state.','900');
            }
            
            $update = array('state'=>$data['state']);
            
            if(!$this->model->update('business_members',$update,array('username'=>$user->username))){
                
                throw new Exception('Some internal occured and data could not be saved. Please try later.','9000');
            }
            
            if(empty($user->state)){
                
                $activity['activity'] = 'Added state &quot;'.$data['state'].'&quot.';                
            } else {
                
                $activity['activity'] = "Changed state from &quot;{$user->state}&quot; to &quot;{$data['state']}&quot;.";
            }
            
            $activity['bid'] = $user->sno;
            
            $this->activity->set('activity',$activity);
            
            $this->activity->log();
            
            $this->header = 200;
            
            $this->message = 'State Saved Successfully.';
            
            $this->page = 'business/response';
            
        } catch (Exception $e) {
            
            $this->header = $e->getCode();
            
            $this->message = $e->getMessage();
            
            $this->page = 'business/forms/state';
        }
    }
    
    private function city() {
        try {
            
            $data = $this->input->post(NULL,TRUE);
            
            if(empty($data)){
                
                throw new Exception('Please enter your city.','200');
            }
            
            $user = $this->model->select('business_members','sno,city,username',array('username'=>$this->session->userdata('username'),'password'=>md5($data['password'])),NULL,1);
            
            if(false == $user){
                
                throw new Exception('User does not exist.','900');
            }
            
            if(empty($data['city'])){
                
                throw new Exception('Please enter your city.','900');
            }
            
            $update = array('city'=>$data['city']);
            
            if(!$this->model->update('business_members',$update,array('username'=>$user->username))){
                
                throw new Exception('Some internal occured and data could not be saved. Please try later.','9000');
            }
            
            if(empty($user->city)){
                
                $activity['activity'] = 'Added city &quot;'.$data['city'].'&quot.';                
            } else{
                
                $activity['activity'] = "Changed city from &quot;{$user->city}&quot; to &quot;{$data['city']}&quot;.";
            }
            
            $activity['bid'] = $user->sno;
            
            $this->activity->set('activity',$activity);
            
            $this->activity->log();
            
            $this->header = 200;
            
            $this->message = 'City Saved Successfully.';
            
            $this->page = 'business/response';
            
        } catch (Exception $e) {
            
            $this->header = $e->getCode();
            
            $this->message = $e->getMessage();
            
            $this->page = 'business/forms/city';
        }
    }
    
    private function fax() {
        try {
            
            $data = $this->input->post(NULL,TRUE);
            
            if(empty($data)){
                
                throw new Exception('Please enter your fax number.','200');
            }
            
            $user = $this->model->select('business_members','sno,fax,username',array('username'=>$this->session->userdata('username'),'password'=>md5($data['password'])),NULL,1);
            
            if(false == $user){
                
                throw new Exception('User does not exist.','900');
            }
            
            if(empty($data['fax'])){
                
                throw new Exception('Please enter your fax number.','900');
            }
            
            $update = array('fax'=>$data['fax']);
            
            if(!$this->model->update('business_members',$update,array('username'=>$user->username))){
                
                throw new Exception('Some internal occured and data could not be saved. Please try later.','900');
            }
            
            if(empty($user->fax)){
                
                $activity['activity'] = 'Added fax number &quot;'.$data['fax'].'&quot.';                
            } else{
                
                $activity['activity'] = "Changed fax number from &quot;{$user->fax}&quot; to &quot;{$data['fax']}&quot;.";
            }
            
            $activity['bid'] = $user->sno;
            
            $this->activity->set('activity',$activity);
            
            $this->activity->log();
            
            $this->header = 200;
            
            $this->message = 'Fax number Saved Successfully.';
            
            $this->page = 'business/response';
            
        } catch (Exception $e) {
            
            $this->header = $e->getCode();
            
            $this->message = $e->getMessage();
            
            $this->page = 'business/forms/fax';
        }
    }
        
    private function phone() {
        try {
            
            $data = $this->input->post(NULL,TRUE);
            
            if(empty($data)){
                
                throw new Exception('Please enter your phone number.','200');
            }
            
            $user = $this->model->select('business_members','sno,telephone,username',array('username'=>$this->session->userdata('username'),'password'=>md5($data['password'])),NULL,1);
            
            if(false == $user){
                
                throw new Exception('User does not exist.','900');
            }
            
            if(empty($data['phone'])){
                
                throw new Exception('Please enter your phone number.','900');
            }
            
            $update = array('telephone'=>$data['phone']);
            
            if(!$this->model->update('business_members',$update,array('username'=>$user->username))){
                
                throw new Exception('Some internal occured and data could not be saved. Please try later.','900');
            }
            
            if(empty($user->telephone)){
                
                $activity['activity'] = 'Added Telephone number &quot;'.$data['phone'].'&quot.';                
            } else{
                
                $activity['activity'] = "Changed Telephone number from &quot;{$user->telephone}&quot; to &quot;{$data['phone']}&quot;.";
            }
            
            $activity['bid'] = $user->sno;
            
            $this->activity->set('activity',$activity);
            
            $this->activity->log();
            
            $this->header = 200;
            
            $this->message = 'Telephone number Saved Successfully.';
            
            $this->page = 'business/response';
            
        } catch (Exception $e) {
            
            $this->header = $e->getCode();
            
            $this->message = $e->getMessage();
            
            $this->page = 'business/forms/telephone';
        }
    }
}
