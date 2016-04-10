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
    <header class="header">
        <div class="container-fluid clearfix">
            <div class="logo">
                <h1> <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/img/logo_short.png" alt="capital log"></a> </h1>
            </div>
            <div class="profile"> 
                <?php
                if ($this->session->userdata('login_type') == 'admin')
                {
                    ?>
                    <a href="<?php echo base_url(); ?>admin/dashboard"> 
                        <span>
                            <img src="<?php echo base_url(); ?>assets/img/john.jpg" alt="">
                        </span>
                        Hello <?php echo $this->session->userdata('admin_username'); ?>!  &nbsp;&nbsp;
                        <i class="fa fa-caret-down"></i>
                    </a> 
<?php } ?>
            </div>
        </div>
    </header>
    <section class="body-part clearfix">
        <?php
        if ($this->session->userdata('login_type') === 'admin')
        {
            ?>
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

                    <?php
                    $username = $this->session->userdata('admin_username');
                    if ($username != NULL)
                    {
                        ?>
                        <div class="left-nav collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="<?php echo base_url(); ?>admin/dashboard"><span><i class="fa fa-folder-open"></i></span><strong>Ads Status</strong></a>
                                    <ul>
                                        <li><a href="<?php echo base_url(); ?>admin/dashboard/active_ads"><i class="fa fa-caret-right"></i>Active Ads</a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/dashboard/block_ads"><i class="fa fa-caret-right"></i>Disapproved Ads</a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/dashboard/expire_ads"><i class="fa fa-caret-right"></i>Expired Ads</a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-caret-right"></i>Awaiting Activation</a></li>
                                    </ul>      
                                </li>
                                <!--<li><a href="<?php echo base_url(); ?>admin/control_user"><span><i class="fa fa-users"></i></span><strong>Control Users</strong></a>
                                <ul>
                                      <li><a href="<?php echo base_url(); ?>admin/control_user/active_users"><i class="fa fa-caret-right"></i>Active Users</a></li>
                                      <li><a href="<?php echo base_url(); ?>admin/control_user/inactive_users"><i class="fa fa-caret-right"></i>Inactive Users</a></li>
                                      <li><a href="<?php echo base_url(); ?>admin/control_user/block_users"><i class="fa fa-caret-right"></i>Blocked Users</a></li>
                
                                  </ul>
                                </li>-->
                                <li><a href="<?php echo base_url(); ?>admin/control_business"><span><i class="glyphicon glyphicon-user"></i></span><strong>Registered Business</strong></a>
                                    <ul>
                                        <li><a href="<?php echo base_url(); ?>admin/control_business/active_business"><i class="fa fa-caret-right"></i>Active Business</a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/control_business/inactive_business"><i class="fa fa-caret-right"></i>Inactive Business</a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/control_business/block_business"><i class="fa fa-caret-right"></i>Blocked Business</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?php echo base_url(); ?>admin/sfi_control"><span><i class="glyphicon glyphicon-user"></i></span><strong>SFI/TC Members</strong></a>
                                    <ul>
                                        <li><a href="<?php echo base_url(); ?>admin/sfi_control/active_business"><i class="fa fa-caret-right"></i>Active Members</a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/sfi_control/inactive_business"><i class="fa fa-caret-right"></i>Inactive Members</a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/sfi_control/block_business"><i class="fa fa-caret-right"></i>Blocked Members</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?php echo base_url(); ?>admin/control_payment"><span><i class="fa fa-dollar"></i></span><strong>Account/Payment</strong></a>
                                    <ul>
                                        <li><a href="<?php echo base_url(); ?>admin/control_payment/received"><i class="fa fa-caret-right"></i>Received</a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/control_payment/pending"><i class="fa fa-caret-right"></i>Pending</a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/control_payment/canceled"><i class="fa fa-caret-right"></i>Canceled </a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/control_payment/failed"><i class="fa fa-caret-right"></i>Failed</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?php echo base_url(); ?>admin/category"><span><i class="glyphicon glyphicon-th-list"></i></span><strong>Category</strong></a>
                                    <ul>
                                        <li><a href="<?php echo base_url(); ?>admin/category"><i class="fa fa-caret-right"></i>Category List</a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/category?target=add"><i class="fa fa-caret-right"></i>Add Category</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?php echo base_url(); ?>admin/admin_post"><span><i class="glyphicon glyphicon-edit"></i></span><strong>Posts</strong></a>
                                    <ul>
                                        <li><a href="<?php echo base_url(); ?>admin/admin_post"><i class="fa fa-caret-right"></i>Post List</a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/admin_post?target=add"><i class="fa fa-caret-right"></i>Add Post</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/admin_activities">
                                        <span><i class="fa fa-bar-chart-o"></i></span>
                                        <strong>Activity Log</strong>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>admin/admins">
                                        <span><i class="fa fa-folder-open"></i></span><strong>Admin</strong>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="<?php echo base_url(); ?>admin/admins">
                                                <i class="fa fa-caret-right"></i>Active Admin
                                            </a>
                                        </li>
                                        
                                        <li>
                                            <a href="<?php echo base_url(); ?>admin/admins/add_admins">
                                                <i class="fa fa-caret-right"></i>Add Admin
                                            </a>
                                        </li>
                                    </ul>      
                                </li>
                                <li><a href="<?php echo base_url(); ?>admin/logout"><span><i class="fa fa-sign-out"></i></span><strong>Logout</strong></a></li>

                            </ul>
                        </div>
            <?php } ?>
                </nav>
            </div>
<?php } ?>        