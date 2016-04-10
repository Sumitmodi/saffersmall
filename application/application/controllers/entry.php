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

            if($module == 'admin')
            {
                $this->header('admin/dashboard');

                return $this;
            }

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

    public function payment()
    {
        try
        {

            $this->control = $this->load->controller('Payments', 'common/payment/payment');

            $this->control->enter();
        } catch (Exception $e)
        {
            show_error($e->getMessage(), $e->getCode());
        }
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

}
