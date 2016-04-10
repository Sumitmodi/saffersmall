<?php

/*
 *   Project : Saffersmall
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 */

/*
 *   <Saffersmall :: Online Ads and Marketing Directory>
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
 * This will be our entry gate to any module in the system.
 * We can determine and load any modules from here.
 */

class Entry extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (isset($this->model))
        {
            unset($this->model);
        }

        $this->load->model('common/common', 'emodel');

        $page_viewed = $this->session->userdata('page_viewed');

        if ($page_viewed == FALSE)
        {
            $ip = $this->get_client_ip();

            $browser = $this->getBrowser();

            $os = $this->getOS();

            $viewed_data = array(
                'ip' => $ip,
                'browser' => $browser,
                'os' => $os
            );

            if ($this->emodel->insert('page_counter', $viewed_data))
            {
                $this->session->set_userdata('page_viewed', TRUE);
            }

            unset($this->emodel);
        }
    }

    /*
     * Get the browser of any visitor
     */

    private function getBrowser()
    {
        $user_agent = $this->input->server('HTTP_USER_AGENT');

        $browser = "Unknown Browser";

        $browser_array = array(
            '/msie/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/safari/i' => 'Safari',
            '/chrome/i' => 'Chrome',
            '/opera/i' => 'Opera',
            '/netscape/i' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i' => 'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value)
        {

            if (preg_match($regex, $user_agent))
            {
                $browser = $value;
            }
        }

        return strtolower($browser);
    }

    /*
     * Get the ip address of any visitor
     */

    private function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
        {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } else if (getenv('HTTP_X_FORWARDED_FOR'))
        {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } else if (getenv('HTTP_X_FORWARDED'))
        {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } else if (getenv('HTTP_FORWARDED_FOR'))
        {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } else if (getenv('HTTP_FORWARDED'))
        {
            $ipaddress = getenv('HTTP_FORWARDED');
        } else if (getenv('REMOTE_ADDR'))
        {
            $ipaddress = getenv('REMOTE_ADDR');
        } else
        {
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }

    /*
     * Get the os of a visitor
     */

    private function getOS()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_platform = "Unknown OS Platform";

        $os_array = array(
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($os_array as $regex => $value)
        {

            if (preg_match($regex, $user_agent))
            {
                $os_platform = $value;
            }
        }

        return $os_platform;
    }

    /*
     * Our home page
     */

    public function home()
    {
        try
        {

            $this->control = $this->load->controller('Home', 'ui/home/home');

            $this->control->enter();
        } catch (Exception $e)
        {
            show_error($e->getMessage(), $e->getCode());
        }
    }

    /*
     * Search
     */

    public function search()
    {

        /*
         * Load the search module
         */
        $this->control = $this->load->controller('Search', 'ui/search/search');

        $this->control->enter();
    }

    public function admin($target)
    {
        /*
         * Load the Admin controller
         */
        $control = $this->load->controller('Admin', 'admin/admin');

        /*
         * Handle everything in there.
         */
        $control->enter($target);
    }

    /*
     * This generic function is used to load dashboard or
     * 
     * determine the entry module either it is a sfi,business,
     * 
     * or user.
     */

    public function dashboard()
    {
        try
        {

            $this->load->library('session');

            $controller = $this->session->userdata('login_type');
            
           

            if ($controller == false)
            {

                $this->header('login');

                return;
            }

            $module = strtolower($controller);

            $control = $this->load->controller(ucfirst($module), $module . '/' . $module);

            if (!$control)
            {

                show_404();
            }

            $control->entry();
        } catch (Exception $e)
        {
            
        }
    }

    /*
     * Login Handler
     */

    public function login()
    {
        try
        {

            $this->control = $this->load->controller('Login', 'common/login/login');
            
            $this->control->enter();
            
            
        } catch (Exception $e)
        {
            show_error($e->getMessage(), $e->getCode());
        }
    }

    /*
     * Registration entry
     */

    public function register()
    {
        try
        {

            $this->control = $this->load->controller('Registration', 'common/registration/registration');

            $this->control->enter();
        } catch (Exception $e)
        {
            show_error($e->getMessage(), $e->getCode());
        }
    }

    /*
     * Account activation
     */

    public function activate()
    {
        try
        {

            $this->control = $this->load->controller('Registration', 'common/registration/registration');

            $this->control->enter('activate');
        } catch (Exception $e)
        {
            show_error($e->getMessage(), $e->getCode());
        }
    }

    /*
     * Payments Page
     */

    public function payment($type = null)
    {
        try
        {
            
            if($type == 'paypal' || $type == null){
            
                $this->control = $this->load->controller('Payments', 'common/payment/payment');
                
                $this->control->enter();
            }
            
            else {
                
                $this->control = $this->load->controller('Eft_payment', 'common/payment/eft_payment');
                
                if($type == 'eft')
                $this->control->enter();

                else if($type == 'eft_success')          
                    $this->control->success();

                else if($type == 'eft_cancel')
                    $this->control->cancel();
            }
            
            
        } catch (Exception $e)
        {
            show_error($e->getMessage(), $e->getCode());
        }
    }
    
    public function notify(){
        
       /**
     * Notes:
     * - All lines with the suffix "// DEBUG" are for debugging purposes and
     *   can safely be removed from live code.
     * - Remember to set PAYFAST_SERVER to LIVE for production/live site
     */
    // General defines
    define( 'PAYFAST_SERVER', 'TEST' );
        // Whether to use "sandbox" test server or live server
    define( 'USER_AGENT', 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)' );
        // User Agent for cURL
     
    // Messages
        // Error
    define( 'PF_ERR_AMOUNT_MISMATCH', 'Amount mismatch' );
    define( 'PF_ERR_BAD_SOURCE_IP', 'Bad source IP address' );
    define( 'PF_ERR_CONNECT_FAILED', 'Failed to connect to PayFast' );
    define( 'PF_ERR_BAD_ACCESS', 'Bad access of page' );
    define( 'PF_ERR_INVALID_SIGNATURE', 'Security signature mismatch' );
    define( 'PF_ERR_CURL_ERROR', 'An error occurred executing cURL' );
    define( 'PF_ERR_INVALID_DATA', 'The data received is invalid' );
    define( 'PF_ERR_UKNOWN', 'Unkown error occurred' );
     
        // General
    define( 'PF_MSG_OK', 'Payment was successful' );
    define( 'PF_MSG_FAILED', 'Payment has failed' );
     
     
    // Notify PayFast that information has been received
    header( 'HTTP/1.0 200 OK' );
    flush();
     
    // Variable initialization
    $pfError = false;
    $pfErrMsg = '';
    $filename = 'notify.txt'; // DEBUG
    $output = ''; // DEBUG
    $pfParamString = '';
    $pfHost = ( PAYFAST_SERVER == 'LIVE' ) ?
     'www.payfast.co.za' : 'sandbox.payfast.co.za';
     
    //// Dump the submitted variables and calculate security signature
    if( !$pfError )
    {
        $output = "Posted Variables:\n\n"; // DEBUG
     
        // Strip any slashes in data
        foreach( $_POST as $key => $val )
            $pfData[$key] = stripslashes( $val );
     
        // Dump the submitted variables and calculate security signature
        foreach( $pfData as $key => $val )
        {
           if( $key != 'signature' )
             $pfParamString .= $key .'='. urlencode( $val ) .'&';
        }
     
        // Remove the last '&' from the parameter string
        $pfParamString = substr( $pfParamString, 0, -1 );
        $pfTempParamString = $pfParamString;
         
        // If a passphrase has been set in the PayFast Settings, then it needs to be included in the signature string.
        $passPhrase = 'XXXXX'; //You need to get this from a constant or stored in you website
        if( !empty( $passPhrase ) )
        {
            $pfTempParamString .= '&passphrase='.urlencode( $passPhrase );
        }
        $signature = md5( $pfTempParamString );
     
        $result = ( $_POST['signature'] == $signature );
     
        $output .= "Security Signature:\n\n"; // DEBUG
        $output .= "- posted     = ". $_POST['signature'] ."\n"; // DEBUG
        $output .= "- calculated = ". $signature ."\n"; // DEBUG
        $output .= "- result     = ". ( $result ? 'SUCCESS' : 'FAILURE' ) ."\n"; // DEBUG
    }
     
    //// Verify source IP
    if( !$pfError )
    {
        $validHosts = array(
            'www.payfast.co.za',
            'sandbox.payfast.co.za',
            'w1w.payfast.co.za',
            'w2w.payfast.co.za',
            );
     
        $validIps = array();
     
        foreach( $validHosts as $pfHostname )
        {
            $ips = gethostbynamel( $pfHostname );
     
            if( $ips !== false )
                $validIps = array_merge( $validIps, $ips );
        }
     
        // Remove duplicates
        $validIps = array_unique( $validIps );
     
        if( !in_array( $_SERVER['REMOTE_ADDR'], $validIps ) )
        {
            $pfError = true;
            $pfErrMsg = PF_ERR_BAD_SOURCE_IP;
        }
    }
     
    //// Connect to server to validate data received
    if( !$pfError )
    {
        // Use cURL (If it's available)
        if( function_exists( 'curl_init' ) )
        {
            $output .= "\n\nUsing cURL\n\n"; // DEBUG
     
            // Create default cURL object
            $ch = curl_init();
     
            // Base settings
            $curlOpts = array(
                // Base options
                CURLOPT_USERAGENT => USER_AGENT, // Set user agent
                CURLOPT_RETURNTRANSFER => true,  // Return output as string rather than outputting it
                CURLOPT_HEADER => false,         // Don't include header in output
                CURLOPT_SSL_VERIFYHOST => true,
                CURLOPT_SSL_VERIFYPEER => false,
     
                // Standard settings
                CURLOPT_URL => 'https://'. $pfHost . '/eng/query/validate',
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $pfParamString,
            );
            curl_setopt_array( $ch, $curlOpts );
     
            // Execute CURL
            $res = curl_exec( $ch );
            curl_close( $ch );
     
            if( $res === false )
            {
                $pfError = true;
                $pfErrMsg = PF_ERR_CURL_ERROR;
            }
        }
        // Use fsockopen
        else
        {
            $output .= "\n\nUsing fsockopen\n\n"; // DEBUG
     
            // Construct Header
            $header = "POST /eng/query/validate HTTP/1.0\r\n";
            $header .= "Host: ". $pfHost ."\r\n";
            $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $header .= "Content-Length: " . strlen( $pfParamString ) . "\r\n\r\n";
     
            // Connect to server
            $socket = fsockopen( 'ssl://'. $pfHost, 443, $errno, $errstr, 10 );
     
            // Send command to server
            fputs( $socket, $header . $pfParamString );
     
            // Read the response from the server
            $res = '';
            $headerDone = false;
     
            while( !feof( $socket ) )
            {
                $line = fgets( $socket, 1024 );
     
                // Check if we are finished reading the header yet
                if( strcmp( $line, "\r\n" ) == 0 )
                {
                    // read the header
                    $headerDone = true;
                }
                // If header has been processed
                else if( $headerDone )
                {
                    // Read the main response
                    $res .= $line;
                }
            }
        }
    }
     
    //// Get data from server
    if( !$pfError )
    {
        // Parse the returned data
        $lines = explode( "\n", $res );
     
        $output .= "\n\nValidate response from server:\n\n"; // DEBUG
     
        foreach( $lines as $line ) // DEBUG
            $output .= $line ."\n"; // DEBUG
    }
     
    //// Interpret the response from server
    if( !$pfError )
    {
        // Get the response from PayFast (VALID or INVALID)
        $result = trim( $lines[0] );
     
        $output .= "\nResult = ". $result; // DEBUG
     
        // If the transaction was valid
        if( strcmp( $result, 'VALID' ) == 0 )
        {
            // Process as required
        }
        // If the transaction was NOT valid
        else
        {
            // Log for investigation
            $pfError = true;
            $pfErrMsg = PF_ERR_INVALID_DATA;
        }
    }
     
    // If an error occurred
    if( $pfError )
    {
        $output .= "\n\nAn error occurred!";
        $output .= "\nError = ". $pfErrMsg;
    }
     
    //// Write output to file // DEBUG
    file_put_contents( $filename, $output ); // DEBUG
    
    }

    /*
     * Logout
     */

    public function logout()
    {
        try
        {
            $this->control = $this->load->controller('Logout', 'common/logout/logout');

            $this->control->enter();
        } catch (Exception $e)
        {
            show_error($e->getMessage(), $e->getCode());
        }
    }

    /*
     * View particular ad
     */

    public function ad()
    { 
        $this->control = $this->load->controller('Product', 'ui/product/product');

        $this->control->enter();
    }
    
    
    public function dashboard_ad()
    { 
        $this->control = $this->load->controller('Product', 'ui/product/product');

        $this->control->enter_dashbaord_ad();
    }
    
    public function ad_list()
    { 
        $target = $this->uri->segment(3);
        
        $this->control = $this->load->controller('Product', 'ui/product/product');

        $this->control->adList($target);
    }


    /*
     * Support pages
     */

    public function support($target = NULL)
    {
        $target = $this->uri->segment(2);

        $control = $this->load->controller('support', 'support/support');

        /*
         * Handle everything in there.
         */
        $control->entry($target);
    }

    /*
     * All ads by a user
     */

    public function userads()
    { 
        $this->control = $this->load->controller('Ads', 'common/ads/ads');

        $this->control->set('model', $this->emodel);

        $this->control->enter();
    }
    
    public function verify()
    { 
        $this->page = 'business/activate';
        
        $this->root = 'home/home';
               
        $this->response();
    }
    
    public function blog()
    { 
        $this->control = $this->load->controller('Blog', 'blog/blog');

        //$this->control->set('model', $this->emodel);

        $this->control->enter();
    }
    
    public function forgot_password()
    {
        try
        {

            $this->control = $this->load->controller('forgot_password', 'common/login/forgot_password');
       
            $this->control->enter();
            
        } catch (Exception $e)
        {
            show_error($e->getMessage(), $e->getCode());
        }
        
        
    }
    
    public function reset()
    {
        $this->root = 'common/login';
        
        $this->load->model('common/common', 'model');
        
        $this->data['nomenu'] = true;

        $postedData = $this->input->post(NULL, TRUE);

        $loginType = $postedData['loginType'];

        if ($loginType == 'business')
        {
            $table = 'business_members';

            $loginType = 'business';
        }

        
        if (isset($postedData['pin']))
        {

            if ($postedData['pin'] == "")
            {
                $this->page = 'business/no-request';
               
                $this->response();
               
                return;
            }
        }

        if (isset($postedData['pass_1']) && isset($postedData['pass_2']))
        {
            if ($postedData['pass_1'] != $postedData['pass_2'])
            {
                $data['message'] = 'Password entered do not match.';
            } elseif (strlen($postedData['pass_1']) < 6)
            {
                $data['message'] = 'Password must be at least 6 characters';
            } else
            {
                $update = $this->model->update($table, array('password' => md5($postedData['pass_1'])), array('username' => $postedData['username']));

                if (false != $update)
                {
                    $this->session->set_userdata('message', 'Your account has been set with new password.');
                    
                    $user_id = $this->model->select('business_members', 'sno', array('username'=>$postedData['username'], null, 1));
                    
                    $this->model->delete('unverified_business', array('bid'=>$user_id['sno']));

                    $this->header('login');

                    return;
                }
            }
        } else
        {

            $this->data['username'] = $postedData['username'];

            $this->data['loginType'] = $loginType;
        }

        $this->page = 'business/reset';
               
        $this->response();
        
    }

}
