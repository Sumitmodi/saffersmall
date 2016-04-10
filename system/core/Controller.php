<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

    private static $instance;
    /*
     * For use in saffersmall
     */

    /*
     * Header status code
     */
    protected $header;
    /*
     * Response message
     */
    protected $message;
    /*
     * Data sent
     */
    protected $data;
    /*
     * The page from view
     */
    protected $page;
    /*
     * The main page to be loaded
     * with each request
     */
    protected $root;
    /*
     * The title of the document
     */
    protected $title;
    /*
     * Any controller loaded within the controller.
     * A simple way to simulate HMVC. thats all
     */
    protected $control;

    /**
     * Constructor
     */
    public function __construct() {
        self::$instance = & $this;

        // Assign all the class objects that were instantiated by the
        // bootstrap file (CodeIgniter.php) to local class variables
        // so that CI can run as one big super object.
        foreach (is_loaded() as $var => $class) {
            $this->$var = & load_class($class);
        }

        $this->load = & load_class('Loader', 'core');

        $this->load->initialize();

        log_message('debug', "Controller Class Initialized");
    }

    public static function &get_instance() {
        return self::$instance;
    }

    /*
     * Set class variables
     */

    public function set($item, $value = false) {
        if (is_array($item)) {

            foreach ($item as $k => $v) {

                $this->{$k} = $v;
            }
        } else {

            $this->{$item} = $value;
        }

        return $this;
    }

    /*
     * Get any class variable
     */

    public function get($item) {

        return $this->{$item};
    }

    /*
     * Response to an ajax request
     */

    protected function ajaxResponse() {
        // header('Content-Type: application/json'); Later use, After we have a js library

        header('Content-Type: text/html; charset=utf-8');

        header('Pragma: no-cache');

        header('X-Frame-Options: deny');

        $header = $this->header >= 900 ? $this->header - 500 : $this->header;

        if ((int) $header == 200) {
            $this->data['response']['status'] = 'success';

            header('HTTP/1.1 200 OK', true, 200);

            header('Status: 200 OK');
        } else {
            $this->data['response']['status'] = 'failure';

            header('HTTP/1.1 ' . $header . ' Error', true, $header);

            header('Status: ' . ($header) . ' Error');
        }

        $this->data['response']['header'] = $header;

        $this->data['response']['message'] = $this->message;
        
        $this->data['page'] = $this->page;

        //$this->load->view($this->data['page'] . '/ajax');

        $this->load->view($this->data['page'],$this->data);
    }

    /*
     * Response to any normal request
     */

    protected function normalResponse() {
        $this->data['page'] = $this->page;

        $this->data['response']['header'] = $this->header >= 900 ? $this->header - 500 : $this->header;

        $this->data['response']['message'] = $this->message;

        $this->load->view($this->root, $this->data);
    }

    /*
     * Set the title of the document
     */

    protected function title($front, $back, $sign = '::') {
        $this->title = ucfirst($front) . ' ' . $sign . ' ' . ucfirst($back);

        return $this->title;
    }

    /*
     * Response to a request.
     */

    protected function response() {

        /*
         * Show response
         */
        if ($this->input->is_ajax_request()) {
            /*
             * Load the required page only defined by target.
             */
            $this->ajaxResponse();
        } else {
            /*
             * Load the default page and include the 
             * page defined by target in the default page.
             */
            $this->normalResponse();
        }
    }

    /*
     * Redirect function
     */

    public function header($location = false, $full = false) {
        if ($full == false) {
            
            @header('Location:' . base_url() . $location);
            
        } else {
            
            @header('Location:' . $location);
        }

        if ($location == false) {
            
            @header('Location:' . base_url());
        }
    }
    
    /*
     * Login validation
     */
    
    protected function login($type){
        
        $this->load->library('session');
        
        $user = $this->session->userdata('login_type');
        
        if(false == $user){                        
            
            $this->header('login');            
            
            return false;
        }
        
        if(strtolower($user) != strtolower($type)){
            
            show_error('You do not have permissions to view this page.', 403);
            
            return false;
        }
        
        return true;
    }

}

// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */