<?php //echo '<pre>'; print_r($result);  ?>
<section class="detail-section2">
    <div class="container content-wrap">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="social-blog orange">
                    <?php 
                    if ($result != NULL) {
                        ?>
                        <div class="text-wrap">

                            <h2><?php echo $result->name; ?></h2>
                            <p></p>
                            <?php if ($result->image != NULL) { ?>
                                <div class="image-wrapper"> <img src="<?php echo base_url() ?>assets/uploads/posts/<?php echo $result->image; ?>"> </div>
                            <?php } ?>
                            <hr>
                            <div class="text-wrap">
                                <p><?php echo $result->content; ?> </p>
                            </div>
                            <!--<div class="social-icon">Share: <a href="#"><img src="<?php echo base_url(); ?>assets/img/social-icons.jpg"></a> </div>-->
                        </div>
                    <?php } else {
                        ?>
                        <div class="text-wrap">
                            <p>Sorry content has not been posted here. Please visit next time.</p>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <!--<div class="box-wrapper">
                    <div class="row">
                <?php
                if (isset($ads)) {
                    foreach ($ads as $ad) {
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
                </div>-->
                <div class="box-wrapper">
                    <h3>Users Around</h3>
                    <?php
                    if ($sfi_data != null) {
                        foreach ($sfi_data as $sfi_datas) {
                            ?>
                            <div class="recent">
                                <ul>
                                    <li><a href="#"><?php echo $sfi_datas['business_name'] ?></a></li>
                                    <?php if ($sfi_datas['profile_link'] != "") {
                                        ?>  
                                        <ul>
                                            <li><a href="<?php echo $sfi_datas['profile_link'] ?>"><?php echo $sfi_datas['profile_link'] ?> </a></li>
                                        </ul>
                                    <?php } ?>
                                </ul>
                            </div>
                                <?php
                                }
                            }
                            ?>
                </div>
                <div class="box-wrapper">
                    <h3>Offered to you</h3>
                    <?php
                    //echo '<pre>';   print_r($cat_info);
                    if (isset($cat_info)) {
                        foreach ($cat_info as $cat) {
                            ?>
                            <div class="list-items">
                                <ul>
                            <?php if ($cat['cat_ads'] != "") {
                                ?>
                                        <li><?php echo $cat['category']['category_name']; ?>
                                        <?php foreach ($cat['cat_ads'] as $cat_ad) {
                                            
                                            $name = str_replace(' ', '-', $cat_ad['name']);
                                            
                                            ?>  
                                                <ol>
                                                    <li><a href="<?php echo base_url() ?>ad/<?php echo $cat_ad['user'].'/'.$name; ?>"><?php echo $cat_ad['name'] ?> </a></li>
                                                </ol>
                                            <?php } ?>
                                        </li>
                            <?php   } ?>
                                </ul>
                            </div>
                                <?php
                                }
                            }
                            ?>
                </div>

            </div>
        </div>
    </div>
</section>
