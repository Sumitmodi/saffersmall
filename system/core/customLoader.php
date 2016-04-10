<?php

/*
 *   Project : Project name
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

class SM_loader extends CI_Loader {

    public function __construct() {
        parent::__construct();
    }

    public function controller($class, $path = false) {

        if (false == $path) {
            /*
             * The first arg contains path to the file
             */
            $path = rtrim(str_replace('\\', DS, str_replace('/', DS, $class)),'.'.EXT).'.'.EXT;
            
            $segs = explode(DS,$path);
            
            $file = end($segs);
            
            $class = pathinfo($file,PATHINFO_FILENAME);
            
            if(file_exists($path)){
                require_once $path;
                
                return new $class;
            }
            
            show_404();
            
        } else {

            /*
             * Clean the path
             */

            $path = str_replace('\\', DS, str_replace('/', DS, $path));

            /*
             * We will make two attempts to load the file.
             * First we assume the filename is in the path
             */

            $first = rtrim($path, '.' . EXT) . '.' . EXT;

            $file = APPPATH . DS . $first;

            if (file_exists($file)) {
                require_once $file;
                
                return new $class;
            }
            
            /*
             * We will now make the second attempt to load the file.
             * We assume the file name is in the class name
             */
            
            $class = rtrim($class,'.' . EXT);
            
            $second = $class . '.' . EXT;
            
            $file = $file . DS . $second;
            
            if(file_exists($file)){
                require_once $file;
                
                return new $class;
            }
            /*
             * The controller does not exist.
             */
            show_404();            
        }
    }

}
