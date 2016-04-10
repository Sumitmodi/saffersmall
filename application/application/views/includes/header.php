<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : header.php
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
?>

<body>
    <!----> 
    <!--header-->
    <header class="header"> <!--affix-top" data-spy="affix" data-offset-top="1-->
        <div class="top-header">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <p>Welcome One, Welcome All!</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="nav-wrapper">
                            <ul>
                                <li class="">                                    
                                    <a href="<?php echo base_url(); ?>">Home</a>
                                </li>
                                <?php if ($this->session->userdata('username') == false) { ?>
                                    <li><a href="<?php echo base_url(); ?>login">Login</a></li>
                                    <li><a href="<?php echo base_url(); ?>register">Register</a></li>
                                <?php } else { ?>
                                    <li class="active">                                    
                                        <a href="<?php echo base_url(); ?>dashboard">My Dashboard</a>
                                    </li>
                                    <li>                                    
                                        <a href="<?php echo base_url(); ?>logout">Logout</a>
                                    </li>
                                    <!--<li><a href="<?php echo base_url(); ?>cart">Basket <img src="<?php echo base_url(); ?>assets/img/basket.png" /> <span>0</span></a></li>-->
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section <?php echo!isset($nomenu) ? 'class="body-part clearfix"' : NULL; ?>>
        <?php if (!isset($nomenu)) { ?>
            <div class="nav-wrap">
                <nav class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>


                    <div class="left-nav collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li <?php echo isset($class) && @$class == 'dashboard' ? 'class="active"' : NULL; ?>>
                                <a href="<?php echo base_url(); ?>dashboard"><span><i class="fa fa-folder-open"></i></span><strong>My Ads</strong></a>
                            </li>
                            <li <?php echo isset($class) && @$class == 'accounts' ? 'class="active"' : NULL; ?>>
                                <a href="<?php echo base_url(); ?>dashboard/accounts"><span><i class="fa fa-edit"></i></span><strong>My Account</strong></a>

                                <!--<ul>
                                    <li>
                                        <a href="#"><i class="fa fa-caret-right"></i>My Details</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-caret-right"></i>Change Password</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-caret-right"></i>Change Email</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-caret-right"></i>Change Username</a>
                                    </li>
                                </ul>-->
                            </li>
                            <li <?php echo isset($class) && @$class == 'placead' ? 'class="active"' : NULL; ?>>
                                <a href="<?php echo base_url(); ?>dashboard/placead"><span><i class="fa fa-bullhorn"></i></span><strong>Place An Ad</strong></a>
                            </li>
                            <?php if($this->session->userdata('is_sfi') == 1) { ?>
                            <li <?php echo isset($class) && @$class == 'sfis' ? 'class="active"' : NULL; ?>>
                                <a href="<?php echo base_url(); ?>dashboard/sfis"><span><i class="fa fa-users"></i></span><strong>Members Around</strong></a>
                            </li>
                            <?php } ?>
                            <li <?php echo isset($class) && @$class == 'payments' ? 'class="active"' : NULL; ?>>
                                <a href="<?php echo base_url(); ?>dashboard/payments"><span><i class="fa fa-dollar"></i></span><strong>Payments</strong></a>
                            </li>
                            <!--<li <?php echo isset($class) && @$class == 'activity' ? 'class="active"' : NULL; ?>>
                                <a href="<?php echo base_url(); ?>dashboard/activity"><span><i class="fa fa-bar-chart-o"></i></span><strong>Reports</strong></a>
                            </li>-->
                            <li <?php echo isset($class) && @$class == 'activity' ? 'class="active"' : NULL; ?>>
                                <a href="<?php echo base_url(); ?>dashboard/activity"><span><i class="fa fa-bar-chart-o"></i></span><strong>My Activity Log</strong></a>
                            </li>
                            <li <?php echo isset($class) && @$class == 'logout' ? 'class="active"' : NULL; ?>>
                                <a href="<?php echo base_url(); ?>logout"><span><i class="fa fa-sign-out"></i></span><strong>Logout</strong></a>
                            </li>
                        </ul>
                    </div>

                </nav>
            </div>  
        <?php } ?>


        <div <?php echo!isset($nomenu) ? 'class="right-section"' : NULL; ?>>
