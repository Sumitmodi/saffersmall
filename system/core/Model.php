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
 * CodeIgniter Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {

    /**
     * Constructor
     *
     * @access public
     */
    function __construct() {
        log_message('debug', "Model Class Initialized");
        $this->db = $this->load->database('default', TRUE);
    }

    /**
     * __get
     *
     * Allows models to access CI's loaded classes using the same
     * syntax as controllers.
     *
     * @param	string
     * @access private
     */
    function __get($key) {
        $CI = & get_instance();
        return $CI->$key;
    }

    /*
     * Select data from a table
     */

    public function select($table, $select = '*', $where = null, $order = null, $limit = null) {

        if (is_array($select)) {

            $this->db->select(implode(',', $select));
        } else {

            $this->db->select($select);
        }

        $this->db->from($table);

        if (!is_null($where)) {

            $this->db->where($where);
        }

        if (!is_null($order)) {

            if (is_array($order)) {

                foreach ($order as $k => $v) {

                    $this->db->order_by($k, $v);
                }
            }
        }

        if (!is_null($limit)) {

            $this->db->limit($limit);
        }

        $result = $this->db->get();

        if ($result->num_rows() == 0) {

            return false;
        }

        if (intval($limit) == 1) {

            return $result->row();
        }

        return $result->result_array();
    }

    /*
     * Delete a data
     */

    public function delete($table, $where = NULL) {
        if (is_null($where)) {
            /*
             * This might be a risky thing to do.
             */
            //return $this->db->empty_table($table);
            return false;
        }

        return $this->db->delete($table, $where);
    }

    /*
     * Update a data
     */

    public function update($table, $update, $where) {
        
        return $this->db->where($where)->update($table, $update);
    }
    
    public function insert($table, $insert) {

        return $this->db->insert($table, $insert);
    }
    

}

// END Model Class

/* End of file Model.php */
/* Location: ./system/core/Model.php */