<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : main.php
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

<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.vticker.min.js"></script>

<script>
    jQuery(document).ready(function ($) {
        var options = {
            $AutoPlay: false,
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
    
    $(function() {
  $('#text-slider1').vTicker();
  $('#text-slider2').vTicker();
  $('#text-slider3').vTicker();
});
</script>



<!--section--> 
<!-- working on progress -->
<section class="slider-wrapper">
    <div class="container">
        <div id="slider1_container" style="position: relative; width: 720px;
             height:300px; overflow: hidden;">

            <!-- Loading Screen -->
            <div u="loading" style="position: absolute; top: 0px; left: 0px;">
                <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                     background-color: #000; top: 0px; left: 0px;width: 100%;height:100%;">
                </div>
                <div style="position: absolute; display: block; background: url(<?php echo base_url(); ?>assets/img/loading.gif) no-repeat center center;
                     top: 0px; left: 0px;width: 100%;height:100%;">
                </div>
            </div>

            <!-- Slides Container -->
            <div u="slides" style="cursor: move; position: relative; float:right; right:0px; /*width: 720px;*/ height: 300px;
                 overflow: hidden; border-left:1px solid rgba(204, 204, 204, 0.51);" class="col-lg-5 col-md-5 col-sm-5 slider-content">      
                 <?php
                 foreach ($sfi as $s)
                 {
                     $img = explode(',', $s->images);
                     
                     $img = base_url() . 'assets/uploads/products/images/' . $img[rand(0, count($img) - 1)];

                     $profile = explode(',', $s->profile);
                    
                     $profile = $profile[rand(0, count($profile) - 1)];
                     
                     $name = strpos($s->name, '-');
                                
                     if($name == TRUE){
                        
                         $name = str_replace('-', '+', $s->name); 

                        $name = str_replace(' ', '-', strtolower($name));
                     }

                     else $name = str_replace(' ', '-', strtolower($s->name));
                     
                     //$name = str_replace(' ', '-', strtolower($s->name))
                     ?>
                    <div>
                        <div class="product-wrap">
                            <div class="product-img">
                                <img src="<?php echo $img; ?>" draggable="true" title="saffersmall">
                            </div>
                            <p> <i class="fa fa-file-text-o"></i>  &nbsp;: &nbsp; &nbsp; <em><?php echo $s->name; ?>  </em></p>
                            <p><i class="fa fa-globe"></i> &nbsp; : &nbsp;&nbsp; <em><a href="<?php echo $profile; ?>"><?php echo $profile; ?></a></em></p>
                            <!--<p><i class="fa fa-phone-square"></i>&nbsp; : &nbsp; &nbsp; <em><?php echo $s->phone; ?></em></p>-->
                            <?php
                            if (isset($s->website))
                            {
                                ?>
                                <p><i class="fa fa-link"></i>  &nbsp;:  &nbsp;&nbsp; <em><?php echo $s->website; ?></em></p>
                            <?php } ?>
                            <p><i class="fa fa-user"></i>  &nbsp;:  &nbsp;&nbsp; <em><?php echo $s->user; ?></em></p>
                            <p><i class="fa fa-eye"></i>  &nbsp;:  &nbsp;&nbsp; <em>
                                    <a href="<?php echo base_url() . 'ad/' . $s->username . '/' . $name; ?>">More info</a>
                                </em>
                            </p>
                        </div>
                        <img u="thumb" src="<?php echo $img; ?>" />
                    </div>
                <?php } ?>

            </div>

            <!-- Thumbnail Navigator Skin Begin -->
            <div u="thumbnavigator" class="jssort07 col-lg-7 col-md-7 col-sm-7" style="position: relative; width: 720px; height: 300px; left: 0px; top: 0px; overflow: hidden; ">
                <style>

                </style>
                <div u="slides" style="cursor: move;">
                    <div u="prototype" class="p" style="POSITION: absolute; WIDTH: 223px; HEIGHT: 257px; TOP: 0; LEFT: 0;">
                        <thumbnailtemplate class="i" style="position:absolute;"></thumbnailtemplate>
                        <div class="o">
                        </div>
                    </div>
                </div>
                <!-- Thumbnail Item Skin End -->
                <span u="arrowleft" class="jssora11l" style="width: 37px; height: 37px; top: 123px; left: 8px;">
                </span>
                <!-- Arrow Right -->
                <span u="arrowright" class="jssora11r" style="width: 37px; height: 37px; top: 123px; right: 8px">
                </span>
                <!-- Arrow Navigator Skin End -->
            </div>
            <!-- ThumbnailNavigator Skin End -->


            <!-- Thumbnail Item Skin End -->
            <span u="arrowleft" class="jssora11l" style="width: 37px; height: 37px; top: 123px; left: 8px;">
            </span>
            <!-- Arrow Right -->
            <span u="arrowright" class="jssora11r" style="width: 37px; height: 37px; top: 123px; right: 8px">
            </span>


        </div>
    </div>
</section>

<!--/section--> 



<section class="section4">
    <div class="container">
        <div class="carousel-wrapper">
            <h2>Recently Added</h2>
            <div id="carousel" class="flexslider">
                <ul class="slides">
                    <?php
                    foreach ($ads as $ad)
                    {
                        $img = explode(',', $s->images);
                        $img = base_url() . 'assets/uploads/products/images/' . $img[rand(0, count($img) - 1)];
                        
                        $ad = !is_object($ad) ? (object) $ad : $ad;
                        //echo'<pre>'; print_r($ad);
                        //echo $ad->username;
                        
                        $name = strpos($ad->name, '-');
                                
                                    if($name == TRUE){
                                        $name = str_replace('-', '+', $ad->name); 
                                        
                                        $name = str_replace(' ', '-', strtolower($name));
                                    }

                                    else $name = str_replace(' ', '-', strtolower($ad->name));
                                    
                       
                        ?>
                        <li>
                            <div class="box"> 
                                <img src="<?php echo $img;?>" alt="<?php echo $ad->name;?>">
                                <div class="price-tag">$<?php echo $ad->price;?></div>
                                <div class="overlay">
                                    <div class="detail">
                                        <a href="<?php echo base_url().'ad/'.$ad->username.'/'.$name;?>">                          
                                        <i class="fa fa-eye"></i> View
                                        </a>
                                    </div>
                                    <!--<div class="price"><a href="#">Add To Cart</a></div>-->

                                </div>
                            </div>
                            <p>
                                <?php 
                                $ad = !is_object($ad) ? (object) $ad : $ad;?>
                                <a href="<?php echo base_url().'ad/'.$ad->username.'/'.$name;?>">
                                    <?php echo $ad->name;?></a>
                            </p>
                            <div class="person">
                                <i class="fa fa-user"></i> Added by <?php echo ucwords($ad->user);?>
                            </div>
                            <span><?php echo formatTime($ad->date_added);?></span>
                        </li>

<?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
</section>


<!--section--> 

<div style=" padding-top: 10px; padding-bottom: 10px; padding-left: 130px">
    <?php 
    if(isset($logos) && is_array($logos)){
    foreach($logos as $logo){
       if($logo['title'] == 'sfi-banner-logo') {
           $logo_img = $logo['logo'];
           $sfi_logo = base_url().'assets/uploads/logos/'.$logo_img;
           $sfi_link = $logo['link'];
       }
       
       if($logo['title'] == 'eazichoice-logo'){
           $eazi_logo = base_url().'assets/uploads/logos/'.$logo['logo'];
           $eazi_link = $logo['link'];
       }
    }
    if(isset($sfi_logo )){
    ?>
    <a href="<?php if(isset($sfi_link)) echo $sfi_link; ?>" target="_blank"><img src="<?php echo $sfi_logo; ?>" style="height: 100px"></a>
    <?php }
    if(isset($eazi_logo)){ ?>
    <a href="<?php if(isset($eazi_link)) echo $eazi_link; ?>" target="_blank"><img src="<?php echo $eazi_logo; ?>" style="height: 100px"></a>
    <?php } 
    
    }?>
</div>

<section class="section3">
    <div class="container">
        <div class="carousel-wrapper">
            <!--<h2>Browse Products by category</h2>-->

            <ul class="nav nav-tabs" role="tablist">
                <?php
                
                //echo '<pre>'; print_r($cats);
                foreach ($cats as $k => $cat)
                {
                    $cat = (object) $cat;
                    $id = strtolower(str_replace(' ', '-', $cat->category_name));
                    $name = ucfirst($cat->category_name);
                    ?> 
                    <li role="presentation" class="<?php echo $k == 0 ? 'active' : NULL; ?>">
                        <a href="#<?php echo $id; ?>" role="tab" data-toggle="tab" id="<?php echo $id; ?>1">
                        <?php echo $name; ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <?php
                foreach ($cats as $k => $cat)
                {
                  
                    //
                    $cat = (object) $cat;
                    $id = strtolower(str_replace(' ', '-', $cat->category_name));
                    $name = ucfirst($cat->category_name);
                    
                    ?> 
                    <div role="tabpanel" class="tab-pane <?php echo $k == 0 ? 'active' : NULL; ?>" id="<?php echo $id; ?>">
                        <div id="carousel<?php echo (7 + $k); ?>" class="flexslider">
                            <ul class="slides">
                                <?php
                               // echo'<pre>';                                print_r($cat);
                                if(isset($cat->ads)){ 
                                foreach ($cat->ads as $l => $ad)
                                {
                                    /* echo '<pre>';
                                      print_r($ad); */
                                    $img = explode(',', $ad->images);
                                    $img = base_url() . 'assets/uploads/products/images/' . $img[rand(0, count($img) - 1)];
                                    
                                    
                                    $name = strpos($ad->name, '-');
                                
                                    if($name == TRUE){
                                        $name = str_replace('-', '+', $ad->name); 
                                        
                                        $name = str_replace(' ', '-', strtolower($name));
                                    }

                                    else $name = str_replace(' ', '-', strtolower($ad->name));
                                    ?> 
                                    <li>
                                        <div class="box"> 
                                            <img src="<?php echo $img; ?>">
                                            <div class="price-tag">$<?php echo $ad->price; ?></div>
                                            <div class="overlay">
                                                <div class="detail">
                                                    <a href="<?php echo base_url() . 'ad/' . $ad->username . '/' . $name; ?>">
                                                        <i class="fa fa-eye"></i>
                                                        View
                                                    </a>
                                                </div>
                                                <!--<div class="price"><a href="#">Add To Cart</a></div>-->
                                            </div>
                                        </div>
                                        <p>
                                            <a href="<?php echo base_url() . 'ad/' . $ad->username . '/' . $name; ?>"><?php echo $ad->name; ?></a>
                                        </p>
                                        <div class="person">
                                            <i class="fa fa-user"></i> Added by <?php echo $ad->user; ?>
                                        </div>

                                        <span><?php echo formatTime($ad->date_added); ?></span>

                                    </li>
                                <?php } }
                                 else echo 'Still there is no product on this category.';
                                ?>
                            </ul>
                        </div>
                    </div>
                <?php } 
               //
                
                               // }?>
            </div>



        </div>
    </div>
</section>
<!--/section--> 


<!--section-->
<?php //echo'<pre>'; print_r($home_ads); echo 'hi';?>
<section class="section2">
    <div class="container">
        <div class="carousel-wrapper">
            <h2>Sponsored Ads </h2>
            <div id="carousel1" class="flexslider">
                <ul class="slides">
                    <?php if($home_ads != ''){ 
                        
                        foreach($home_ads as $home_ad){
                            
                            $img = explode(',', $home_ad['images']);
                                    $img = base_url() . 'assets/uploads/products/images/' . $img[rand(0, count($img) - 1)];
                                    
                                    $name = strpos($home_ad['name'], '-');
                                
                                    if($name == TRUE){
                                        $name = str_replace('-', '+', $home_ad['name']); 
                                        
                                        $name = str_replace(' ', '-', strtolower($name));
                                    }

                                    else $name = str_replace(' ', '-', strtolower($home_ad['name']));
                                    
                                    
?>
                    <li>
                        <div class="box"> <img src="<?php echo $img; ?>"><div class="price-tag">$<?php echo $home_ad['price']; ?></div>
                            <div class="overlay">
                                <div class="detail">
                                    <a href="<?php echo base_url() . 'ad/' . $home_ad['user_name'] . '/' . $name; ?>">
                                        <i class="fa fa-eye"></i>
                                        View
                                    </a>
                                    
                                </div>
                                <!--<div class="price"><a href="#">Add To Cart</a></div>-->

                            </div>
                        </div>
                        <p><a href="<?php echo base_url() . 'ad/' . $home_ad['user_name'] . '/' . $name; ?>"><?php echo $home_ad['name']; ?></a></p>
                        <div class="person">
                            <i class="fa fa-user"></i> Added by <?php echo $home_ad['user']; ?>
                        </div>
                        <span><?php echo $home_ad['date_added']; ?></span>

                    </li>
                        <?php } 
                    } else echo 'Still there is no any sponsored ads.';?>
                    
                </ul>
            </div>
        </div>
    </div>
</section>



<!--section-->
<section class="section3">
    <div class="container">
      <div class="carousel-wrapper">
        <h2>You may like </h2>
        <?php //echo '<pre>'; print_r($link_ads);?>
         <?php
            //$k = array();
                $i = 0;
                
                $i=count($link_ads);
                
                      
                
                if($i>0){
            
            ?>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="text-slider-outer">
                    <div id="text-slider1">


                        <ul>
                            <?php  for($j=0; $j<$i; $j++){
                            if($j%3 == 0){
                                
                                $link_name = strpos($link_ads[$j]['name'], '-');
                                
                                    if($link_name == TRUE){
                                        $link_name = str_replace('-', '+', $link_ads[$j]['name']); 
                                        
                                        $link_name = str_replace(' ', '-', strtolower($link_name));
                                        }

                                    else $link_name = str_replace(' ', '-', strtolower( $link_ads[$j]['name']));
                              
                               ?>
                            <li>
                                <h3><a href="<?php echo base_url() . 'ad/' . $link_ads[$j]['user_name'] . '/' . $link_name; ?>"><?php echo $link_ads[$j]['name']; ?></a></h3>
                                <p>
                                    <?php 
                                    $string = strip_tags($link_ads[$j]['description']);

                                    if (strlen($string) > 100) {

                                        // truncate string
                                        $stringCut = substr($string, 0, 100);

                                        // make sure it ends in a word so assassinate doesn't become ass...
                                        $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... <a href="'.base_url().'ad/'.$link_ads[$j]['user_name'].'/'.$name.'">Read More </a>';
                                    }
                                    echo $string;
                                    ?>
                                <p>
                                <br> <span><?php echo $link_ads[$j]['date_added'];?></span>
                            </li>
                            <?php }} ?>

                      </ul>
                    </div>
                </div>
            </div>
            <?php if($i>1){?>
            <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="text-slider-outer">
                    <div id="text-slider2">
                      <ul>
                       <?php  for($j=0; $j<$i; $j++){
                            if($j%3 == 1){
                                
                                $link_name = strpos($link_ads[$j]['name'], '-');
                                
                                    if($link_name == TRUE){
                                        $link_name = str_replace('-', '+', $link_ads[$j]['name']); 
                                        
                                        $link_name = str_replace(' ', '-', strtolower($link_name));
                                        }

                                    else $link_name = str_replace(' ', '-', strtolower( $link_ads[$j]['name']));
                               ?>
                            <li>
                                <h3><a href="<?php echo base_url() . 'ad/' . $link_ads[$j]['user_name'] . '/' . $link_name; ?>"><?php echo $link_ads[$j]['name']; ?></a></h3>
                                <p>
                                    <?php 
                                    $string = strip_tags($link_ads[$j]['description']);

                                    if (strlen($string) > 100) {

                                        // truncate string
                                        $stringCut = substr($string, 0, 100);

                                        // make sure it ends in a word so assassinate doesn't become ass...
                                        $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... <a href="'.base_url().'ad/'.$link_ads[$j]['user_name'].'/'.$name.'">Read More </a>';
                                    }
                                    echo $string;
                                    ?>
                                <p>
                                <br> <span><?php echo $link_ads[$j]['date_added'];?></span>
                            </li>
                            <?php }} ?>
                      </ul>
                    </div>
                </div>
            </div>
            <?php } 
            if($i>2){
            ?>
            <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="text-slider-outer">
                    <div id="text-slider3">
                      <ul>
                       <?php  for($j=0; $j<$i; $j++){
                            if($j%3 == 2){
                                
                                $link_name = strpos($link_ads[$j]['name'], '-');
                                
                                    if($link_name == TRUE){
                                        $link_name = str_replace('-', '+', $link_ads[$j]['name']); 
                                        
                                        $link_name = str_replace(' ', '-', strtolower($link_name));
                                        }

                                    else $link_name = str_replace(' ', '-', strtolower( $link_ads[$j]['name']));
                            
                               ?>
                            <li>
                                <h3><a href="<?php echo base_url() . 'ad/' . $link_ads[$j]['user_name'] . '/' . $link_name; ?>"><?php echo $link_ads[$j]['name']; ?></a></h3>
                                <p>
                                    <?php 
                                    $string = strip_tags($link_ads[$j]['description']);

                                    if (strlen($string) > 100) {

                                        // truncate string
                                        $stringCut = substr($string, 0, 100);

                                        // make sure it ends in a word so assassinate doesn't become ass...
                                        $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... <a href="'.base_url().'ad/'.$link_ads[$j]['user_name'].'/'.$name.'">Read More </a>';
                                    }
                                    echo $string;
                                    ?>
                                <p>
                                <br> <span><?php echo $link_ads[$j]['date_added'];?></span>
                            </li>
                            <?php }} ?>
                      </ul>
                    </div>
                </div>
            </div>
            <?php } ?>
	</div>   
        <?php } else echo 'There is no any link ad.';?>
      </div>
  </div>
</section>
<!--/section--> 
