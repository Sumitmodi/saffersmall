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

<!--<script>
    jQuery(document).ready(function ($) {
        var options = {
            $AutoPlay: true,
            $AutoPlayInterval: 2000,
            $SlideDuration: 500,
            $DragOrientation: 3,
            $UISearchMode: 0,
            $ArrowNavigatorOptions: {//[Optional] Options to specify and enable arrow navigator or not
                $Class: $JssorArrowNavigator$, //[Requried] Class to create arrow navigator instance
                $ChanceToShow: 2                               //[Required] 0 Never, 1 Mouse Over, 2 Always
            },
            $ThumbnailNavigatorOptions: {
                $Class: $JssorThumbnailNavigator$,
                $ChanceToShow: 2,
                $Loop: 2,
                $SpacingX: 15, //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                $SpacingY: 3, //[Optional] Vertical space between each thumbnail in pixel, default value is 0
                $DisplayPieces: 3, //[Optional] Number of pieces to display, default value is 1
                $ParkingPosition: 204, //[Optional] The offset position to park thumbnail,

                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$, //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 0, //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            }
        };

        var jssor_slider1 = new $JssorSlider$("slider1_container", options);

        //responsive code begin
        //you can remove responsive code if you don't want the slider scales while window resizes
        function ScaleSlider() {
            var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
            if (parentWidth)
                jssor_slider1.$ScaleWidth(Math.min(parentWidth, 720));
            else
                window.setTimeout(ScaleSlider, 30);
        }

        ScaleSlider();

        if (!navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|IEMobile)/)) {
            $(window).bind('resize', ScaleSlider);
        }
    });
</script>-->



<!--header-->
<header class="header"> <!--affix-top" data-spy="affix" data-offset-top="1-->
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-4">
                    <p>Your one stop online shopping mall</p>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-8">
                    <div class="nav-wrapper">
                        <ul>

                            <li class="<?php echo $this->uri->segment(1) == '' ? 'active' : NULL; ?>">                                    
                                <a href="<?php echo base_url(); ?>">Home</a>
                            </li>
                            <?php 
                            if ($this->session->userdata('login_type') == false)
                            {
                                ?>
                                <li><a href="<?php echo base_url(); ?>login">Login</a></li>
                                <li><a href="<?php echo base_url(); ?>register">Register</a></li>
                                <?php
                            } else
                            {
                                if($this->session->userdata('login_type') == 'admin') $dash = 'admin/dashboard';
                                else $dash = 'dashboard';
                                ?>
                                <li class="<?php echo $this->uri->segment(1) == 'dashboard' ? 'active' : NULL; ?>">                                    
                                    <a href="<?php echo base_url().$dash ?>">My Dashboard</a>
                                </li>
                                <li>                                    
                                    <a href="<?php echo base_url(); ?>logout">Logout</a>
                                </li>
                                <!--<li><a href="<?php echo base_url(); ?>cart">Basket <img src="img/basket.png" /> <span>0</span></a></li>-->
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <?php 
                    if(isset($logos) && is_array($logos)){
                    foreach($logos as $logo){ 
                        if($logo['title'] == 'main-logo')
                            $logo_img = $logo['logo'];
                        $logo_dir = base_url().'assets/uploads/logos/'.$logo_img;
                    }
                    }
                    else $logo_dir = base_url().'assets/img/saffersmall-logo-final.png';
?>
                    <div class="logo-wrap" data-animate-to="fadeInLeft"><a href="<?php echo base_url(); ?>"> <img src="<?php echo $logo_dir ;?>" style="height:100px"></a>  </div>
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
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Search item" id="1" name="query">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Item Category" id="1" name="cat">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6col-sm-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Country" id="3" name="country">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="State" id="2" name="state">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="City" id="1" name="city">
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <input type="hidden" name="adv" value="1"/>
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
                                        <option value="null" >Select a category</option>
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
                                <input name="query" type="text" class="form-control" style="font-weight:bold;" placeholder="Search ads here" id="autocomplete" >
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
</header>
<!--/header--> 

