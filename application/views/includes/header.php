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

<script type="text/javascript">
$(function() {
  $('#testform').submit(function(e){
    e.preventDefault();
  });
  
  $('#subject').selectize({create: true});
  $('#tags').selectize({    
    delimiter: ',',
    persist: true,
    create: function(input) {
      return {
        value: input,
        text: input
      }
    }
  });
});
</script>

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
        <?php if ($this->session->userdata('username') == false) { ?>
        <div class="bottom-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="logo-wrap" data-animate-to="fadeInLeft"><a href="<?php echo base_url(); ?>"> <img src="<?php echo base_url(); ?>assets/img/saffersmall-logo-final.png" style="height:100px"></a>  </div>
                    <div class="logo-text"><span>Welcome one, welcome all</span></div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 clearfix">
                    <div class="social-icon">
                        <ul>
                            <?php 
                            if(isset($social_links)){
                            foreach($social_links as $social_link){?>
                            <li> <a href="http://<?php echo $social_link['link']?>" target="_blank"><i class="fa "><img src="<?php echo base_url()?>assets/uploads/posts/<?php echo $social_link['logo']?>"></i></a> </li>
                            <?php }}?>
                            <!--<li><a href="#"><i class="fa fa-flickr"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin-square"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter-square"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus-square"></i></a></li>-->
                        </ul>
                    </div><div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="mySmallModalLabel">Advance Search</h4>
                                </div>
                                <div class="advance-search-wrap">
                                    <form role="form" method="get" action="<?php echo base_url(); ?>search">

                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12"><div class="form-group">
                                                    <input type="text" class="form-control" placeholder="City" id="1" name="city">
                                                </div></div>
                                            <div class="col-lg-12 col-md-12 col-sm-12"><div class="form-group">
                                                    <input type="text" class="form-control" placeholder="State" id="2" name="state">
                                                </div></div>
                                            <div class="col-lg-6 col-md-6 col-sm-6"><div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Country" id="3" name="country">
                                                </div></div>
                                            <div class="col-lg-6 col-md-6 col-sm-6"><div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Rating" name="rating">
                                                </div></div>

                                            <div class="col-lg-3 col-md-3 col-sm-3"><div class="form-group"><label class="control-label">Price Range</label></div></div>
                                            <div class="col-lg-2 col-md-2 col-sm-2"><div class="form-group"><input type="text" class="form-control" placeholder="40"></div></div> 
                                            <div class="col-lg-5 col-md-5 col-sm-5"><div class="form-group"><input type="range" max="4000" min="50"></div></div>
                                            <div class="col-lg-2 col-md-2 col-sm-2"><div class="form-group"><input type="text" class="form-control" placeholder="4000"></div></div>
                                        </div>
                                        <input type="submit" value="Search">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="top-form pull-right" data-animate-to="fadeInRight">
                        <form role="form" class="form-inline" action="<?php echo base_url();?>search" method="get">

                            <div class="form-group">
                                <div class="formrow">
                                    <select id="subject" name="cat">
                                        <option value="null" style="color: #b0afaf">Select a category</option>
                                        <?php
                                        if (isset($cats))
                                        {
                                            foreach ($cats as $c)
                                            {
                                                $c = (object) $c;
                                                ?>
                                                <option value="<?php echo strtolower($c->category_name); ?>"><?php echo ucwords($c->category_name); ?></option>
                                                <?php
                                            }
                                            ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <input name="query" type="text" style="font-weight:bold;" class="form-control" placeholder="Search ads here" id="autocomplete" >
                                <input type="submit" value="">
                            </div>

<!--                            <div class="advance_search">
                                <a href="#" class="a-search" data-toggle="modal" data-target=".bs-example-modal-lg">Advanced Search</a>
                            </div>-->
<br>
                            <div class="" style="float:right;">
                                <a href="#" class="" data-toggle="modal" data-target=".bs-example-modal-lg">Advanced Search</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <?php } ?>
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
                            <?php if ($this->session->userdata('is_sfi') == 1) { ?>
                                <li <?php echo isset($class) && @$class == 'sfis' ? 'class="active"' : NULL; ?>>
                                    <a href="<?php echo base_url(); ?>dashboard/sfis"><span><i class="fa fa-users"></i></span><strong>Members Around</strong></a>
                                </li>
                            <?php } ?>
                            <li <?php echo isset($class) && @$class == 'payments' ? 'class="active"' : NULL; ?>>
                                <a href="<?php echo base_url(); ?>dashboard/notifications">
                                    <span>
                                        <i class="fa fa-dollar"></i>
                                    </span><strong>Notifications</strong>
                                    <?php
                                        $i = 0;
                                        
                                        if(isset($unseen_notifications) || $unseen_notifications != null){
                                        foreach ($unseen_notifications as $k => $notification) {
                                            //echo '<pre>';  print_r($notification);
                                            //echo $notification[0]['sno'];
                                            if ($notification[0]['action'] != '') {
                                                $i = $i + 1;
                                            }
                                            
                                            
                                        }}
                                      ?>
                                    <strong style="<?php if($i != 0) echo 'color:red';?>">
                                       <?php echo $i;?>
                                            </strong>
                                        </a>
                                    </li>
                                    <li <?php echo isset($class) && @$class == 'payments' ? 'class="active"' : NULL; ?>>
                                        <a href="<?php echo base_url(); ?>dashboard/payments"><span><i class="fa fa-dollar"></i></span><strong>Payments</strong></a>
                                    </li>
                                    <li <?php echo isset($class) && @$class == 'activity' ? 'class="active"' : NULL; ?>>
                                        <a href="<?php echo base_url(); ?>dashboard/report"><span><i class="fa fa-bar-chart-o"></i></span><strong>Reports</strong></a>
                                    </li>
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
