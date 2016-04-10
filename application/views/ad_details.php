<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : ad_details.php
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pgwslideshow.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $(document).ready(function () {
            var pgwSlideshow = $('.pgwSlideshow').pgwSlideshow();
            pgwSlideshow.startSlide();
        });
    });

</script>

<div class="inner-banner"> </div>
<section class="detail-section2">
    <div class="container content-wrap">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="social-blog orange">
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-9">
                            <h2><?php echo ucwords($result['item']->name); ?></h2>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <div class="save"><a href="#"><i class="fa fa-star"></i></a></div>
                        </div>
                    </div>
                    <?php
                    $imgs = $result['item']->images;
                    $images = array();
                    if (!empty($imgs))
                    {
                        $imgs = explode(',', $imgs);

                        foreach ($imgs as $img)
                        {
                            $images[] = base_url() . 'assets/uploads/products/images/' . $img;
                        }
                    }
                    if (count($images) > 0)
                    {
                        ?>
                        <div class="image-wrapper">
                            <ul class="pgwSlideshow">
                                <?php
                                foreach ($images as $i)
                                {
                                    ?> 
                                    <li style="max-height: 480px;"><img src="<?php echo $i; ?>" style="max-height: 480px;"/></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="category-list">
                                <div class="category clearfix">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 left">
                                            <p>Product Name</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 right">
                                            <p><?php echo $result['item']->name; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="category clearfix">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 left">
                                            <p>Price</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 right">
                                            <p>&dollar;<?php echo $result['item']->price; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if (!empty($result['item']->country))
                                {
                                    ?>
                                    <div class="category clearfix">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 left">
                                                <p>Country</p>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 right">
                                                <p> <?php echo ucfirst($result['item']->country); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php
                                if (!empty($result['item']->city))
                                {
                                    ?>
                                    <div class="category clearfix">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 left">
                                                <p>City</p>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 right">
                                                <p> <?php echo ucfirst($result['item']->city); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php
                                if (!empty($result['item']->location))
                                {
                                    ?>
                                    <div class="category clearfix">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 left">
                                                <p>State</p>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 right">
                                                <p> <?php echo ucfirst($result['item']->location); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="category-list">
                                <div class="category clearfix">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 left">
                                            <p>Posted</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 right">
                                            <p><?php echo formatTime($result['item']->date_added); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="category clearfix">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 left">
                                            <p>Liked by</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 right">
                                            <p><?php echo!empty($added) ? intval($added) : 'Be the first to like'; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="category clearfix">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 left">
                                            <p>Approved</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 right">
                                            <p>Yes</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="category clearfix">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 left">
                                            <p>Views</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 right">
                                            <p><?php echo $views; ?> times</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="social-icon">
                                        <ul>
                                            <li> <a href="#"><i class="fa fa-facebook-square"></i></a> </li>
                                            <li><a href="#"><i class="fa fa-flickr"></i></a></li>
                                            <li><a href="#"><i class="fa fa-linkedin-square"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter-square"></i></a></li>
                                            <li><a href="#"><i class="fa fa-google-plus-square"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-wrap"> <strong>Description</strong>
                            <p><?php echo ucfirst($result['item']->description); ?></p>
                        </div>
                        <div class="image clearfix">
                            <h2>You might be interested</h2>
                            <?php
                            foreach ($extra_result as $rel)
                            {
                                $now = (object) $rel['related_ads'];
                                $user = (object) $rel['business_man'];
                                $extra = (object) $rel['related_extra'];
                                $img = explode(',', $now->images);
                                $image = base_url() . 'assets/uploads/products/images/' . $img[rand(0, count($img) - 1)];
                                ?>
                                <div class="box-wrapp">
                                    <div class="box"> 
                                        <img src="<?php echo $image; ?>" alt="<?php echo $now->name; ?>" title="<?php echo $now->name; ?>">
                                        <div class="price-tag">&dollar;<?php echo $now->price; ?></div>
                                        <!--<div class="ribbon-wrapper-green">
                                            <div class="ribbon-green">Urgent</div>                                            
                                        </div>
                                        <div class="ribbon-featured-wrapper">
                                            <div class="ribbon-featured">Featured</div>                                            
                                        </div>-->
                                        <div class="overlay">
                                            <div class="detail">
                                                <a href="<?php echo base_url() . 'ad/' . $user->username . '/' . str_replace(' ', '-', strtolower($now->name)); ?>">
                                                    <i class="fa fa-eye"></i>View
                                                </a>
                                            </div>
                                            <!--<div class="price"><a href="#">Add To Cart</a></div>-->
                                        </div>
                                    </div>
                                    <p>
                                                <a href="<?php echo base_url() . 'ad/' . $user->username . '/' . str_replace(' ', '-', strtolower($now->name)); ?>"><?php echo ucwords($now->name); ?></a></p>
                                    <div class="person">
                                        <i class="fa fa-user"></i> Added by 
                                        <a href="<?php echo base_url().'ads/'.$user->username;?>"><?php echo ucwords($user->person_name); ?>
                                        </a>
                                    </div>
                                    <span><?php echo formatTime($now->date_added); ?></span>
                                </div>
                            <?php }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="box-wrapper">
                    <h3>Contact <?php echo $result['user']->person_name; ?></h3>
                    <div class="tag-wrap clearfix">
                        <?php
                        $image = $result['user']->image;
                        if (empty($image))
                        {
                            $image = base_url() . 'assets/img/logo_short.png';
                        } else
                        {
                            $image = base_url() . 'assets/user/' . $image;
                        }
                        ?>
                        <div class="img-outer">
                            <img src="<?php echo $image; ?>" alt="">
                        </div>
                        <div class="details">
                            <h4><i class="fa fa-phone"></i> <?php echo $result['user']->telephone; ?></h4>
                            <em><?php echo $result['user']->address; ?></em>
                            <p><a href="<?php echo base_url(); ?>ads/<?php echo $result['user']->username; ?>">See all ads by <?php echo $result['user']->person_name; ?></a></p>
                        </div>
                    </div>
                </div>
                <?php
                if (isset($topbar))
                {
                    ?>
                    <div class="box-wrapper">
                        <div class="row">
                            <?php
                            foreach ($topbar as $tb)
                            {
                                $t = (object) $tb['related_ads'];
                                $img = explode(',', $t->images);
                                $image = base_url() . 'assets/uploads/products/images/' . $img[rand(0, count($img) - 1)];
                                $u = $tb['business_man'];
                                ?>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <a href="<?php echo base_url().'ad/'.$u->username.'/'.str_replace(' ','-',strtolower($t->name));?>">
                                        <img alt="" src="<?php echo $image; ?>">
                                    </a>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                <?php } ?>
                <div class="box-wrapper">
                    <h3>More to Fascinate you</h3>
                    <div class="recent">
                        <ul>
                            <?php
                            if(isset($catads)){
                                foreach ($catads as $cat)
                                {
                                $search = base_url() . 'search?cat=' . $cat['category']->category_name;
                                ?> 
                                <li>
                                    <a href="<?php echo $search; ?>"><?php echo ucwords($cat['category']->category_name); ?></a>
                                    <?php if (count($cat['ads']) > 0)
                                    {
                                        ?>
                                        <ul>
                                            <?php
                                            foreach ($cat['ads'] as $ad)
                                            {
                                                $url = base_url() . 'ad/' . $ad->user . '/' . str_replace(' ', '-', strtolower($ad->name));
                                                ?>
                                                <li>
                                                    <a href="<?php echo $url; ?>"><?php echo ucwords($ad->name); ?></a>
                                                </li>
                                            <?php
                                        }
                                        ?>
                                        </ul>    
                                    <?php }
                                ?>
                                </li>
                        <?php } 
                        }?>
                        </ul>
                    </div>
                </div>
                <?php
                if (isset($botbar))
                {
                    ?>
                    <div class="box-wrapper">
                        <div class="row">
                            <?php
                            foreach ($botbar as $t)
                            {
                                $t = (object) $t['related_ads'];
                                $img = explode(',', $t->images);
                                $image = base_url() . 'assets/uploads/products/images/' . $img[rand(0, count($img) - 1)];
                                ?>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <img alt="" src="<?php echo $image; ?>">
                                </div>
                    <?php } ?>
                        </div>

                    </div>
<?php } ?>
            </div>
        </div>
    </div>
</section>