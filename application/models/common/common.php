<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : common.php
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

class Common extends CI_Model {

    public function __construct() {

        parent::__construct();
    }

    public function insert($table, $insert) {

        return $this->db->insert($table, $insert);
    }

    public function lastInsert() {

        return $this->db->insert_id();
    }

    public function search($rows, $c = false) {
        $this->db->cache_delete_all();
     
        $like = null;
        
        foreach ($rows as $row) {
            
            $row = strtolower($row);
            
            $like = $like . "LOWER(name) LIKE '%{$row}%' OR ";
        }

        $like = rtrim($like, 'OR ');

        $sql = "SELECT * FROM `business_ads` WHERE {$like} and LOWER(status) = 'a'";
        
        if($c != false){
            
            $sql .= ' and cat_id ="'.$c.'"';
        }
        
        $sql .= ' order by date_added DESC';
        
        $result = $this->db->query($sql);
        
        return $result->result_array();
    }

}
