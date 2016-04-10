<section class="contact-section">
    <div class="container">
        <div class="social-blog clearfix">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <div class="text-wrap">

                        <h3>Stay In touch with us</h3>
                        <p><?php echo isset($response['message']) ? $response['message'] : NULL; ?></p>
                        <div class="detail-form">
                            <form class="form" action="" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="exampleInputEmail2" placeholder="You are" name="name" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="exampleInputEmail2" placeholder="Your email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="exampleInputEmail2" placeholder="Your question title" name="subject" required>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" rows="4" placeholder="Please describe what you want to say" name="comments" required></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Post">
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--<div class="ads-here"><a href="#"><img src="<?php echo base_url() ?>assets/img/ads.png" alt=""></a></div>-->
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <?php if (isset($address) && @!empty($adress->image))
                    { ?> 
                        <div class="box-wrapper">
                            <img src="<?php echo base_url() . 'assets/uploads/posts/' . $address->image; ?>"/>
                        </div>
                        <?php } ?>
                    <div class="box-wrapper">
                        <?php if (isset($address))
                        {
                            ?> 
                            <address>
                            <?php echo $address->content; ?>
                            </address>
<?php } ?>
                    </div>
                    <div class="box-wrapper">
                        <div class="row">
                            <?php
                            if (isset($ads))
                            {
                                foreach ($ads as $ad)
                                {
                                    $images = explode(",", $ad[0]['images']);
                                    ?>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <a href="<?php echo base_url() ?>ads/ad_detail/<?php echo $ad[0]['sno']; ?>">
                                            <img src="<?php echo base_url() ?>assets/uploads/products/images/<?php echo $images[0] ?>" alt="" />
                                        </a>
                                    </div>
                                <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</section>