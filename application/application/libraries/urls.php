<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : urls.php
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

class Urls {

    public function __construct() {
        
    }

    /*
     * Function to check if the current host is localhost 
     * or a real server
     */

    public function isLocalhost() {
        $domain = $_SERVER['SERVER_NAME'];

        for ($i = 0; $i <= strlen($domain) - strlen('localhost'); $i++) {

            $sub = substr($domain, $i, strlen('localhost'));

            if (strtolower($sub) == 'localhost')
                return true;
        }

        return false;
    }

    public function adminListsUrl() {
        if ($this->isLocalhost()) {
            return '/' . DOMAIN . '/admin/lists';
        } else {
            return '/admin/lists';
        }
    }

    public function adminCatsUrl() {
        if ($this->isLocalhost()) {
            return '/' . DOMAIN . '/admin/category';
        } else {
            return '/admin/category';
        }
    }

    public function adminNotisUrl() {
        if ($this->isLocalhost()) {
            return '/' . DOMAIN . '/admin/notifications';
        } else {
            return '/admin/notifications';
        }
    }

    public function adminActivityUrl() {
        if ($this->isLocalhost()) {
            return '/' . DOMAIN . '/admin/activity';
        } else {
            return '/admin/activity';
        }
    }

    public function adminAcUrl() {
        if ($this->isLocalhost()) {
            return '/' . DOMAIN . '/admin/accounts';
        } else {
            return '/admin/accounts';
        }
    }

    public function adminAdsUrl() {
        if ($this->isLocalhost()) {
            return '/' . DOMAIN . '/admin/ads';
        } else {
            return '/admin/ads';
        }
    }

    public function adminPostsUrl() {
        if ($this->isLocalhost()) {
            return '/' . DOMAIN . '/admin/posts';
        } else {
            return '/admin/posts';
        }
    }

    public function adminReportsUrl() {
        if ($this->isLocalhost()) {
            return '/' . DOMAIN . '/admin/reports';
        } else {
            return '/admin/reports';
        }
    }

    public function adminUsersUrl() {
        if ($this->isLocalhost()) {
            return '/' . DOMAIN . '/admin/users';
        } else {
            return '/admin/users';
        }
    }

}
