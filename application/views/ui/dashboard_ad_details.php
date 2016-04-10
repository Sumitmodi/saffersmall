<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pgwslideshow.js"></script>
<link href="<?php echo base_url();?>assets/css/pgwslideshow.css" rel="stylesheet" type="text/css" media="all">
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $(document).ready(function () {
            var pgwSlideshow = $('.pgwSlideshow').pgwSlideshow();
            pgwSlideshow.startSlide();
        });
    });

</script>
  

<div class="social-blog orange">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <h2><?php echo $result['item']->name; ?></h2>
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
                                            <p><?php echo!empty($liked_by) ? intval($liked_by) : '0'; ?></p>
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
                                            <p><?php echo $ad_counter; ?> times</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="social-icon">
                                        <ul>
                                            <?php 
                                            if(isset($social_links)){
                                            foreach($social_links as $social_link){?>
                                            <li> <a href="http://<?php echo $social_link['link']?>" target="_blank"><i class="fa "><img src="<?php echo base_url()?>assets/uploads/posts/<?php echo $social_link['logo']?>"></i></a> </li>
                                            <?php }}?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-wrap"> <strong>Description</strong>
                            <p><?php echo ucfirst($result['item']->description); ?></p>
                        </div>
                       
                    </div>
                </div>