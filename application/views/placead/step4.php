<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : step4.php
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

<div class="right-top"></div>
<div class="right-header dashboard">
    <h2>
        <i class="fa fa-folder-open"></i>Place Ad 
        <div class="choose-ads">
            <small>Step :: 5</small>
        </div>
    </h2>
     <?php  if(isset($flag)){ if($flag != ''){ ?>
    <div style="padding-left: 150px" class="carousel-wrapper">
        <ul class="nav nav-tabs" role="tablist">
                 
                     <li role="presentation" class="active">
                        <a href="<?php echo base_url()?>dashboard/?target=ads&action=modify&id=<?php echo $id?>" role="tab" data-toggle="" id="electronis1">
                    Product                        </a>
                    </li>
 
                    <li role="presentation" class="">
                        <a href="<?php echo base_url()?>dashboard/?target=ads&action=modify&id=<?php echo $id?>&step=2" role="tab" data-toggle="" id="food1">
                    Location                        </a>
                    </li>
 
                    <?php   if($ad_type !=1){ ?>
                    <li role="presentation" class="">
                        <a href="<?php echo base_url()?>dashboard/?target=ads&action=modify&id=<?php echo $id?>&step=3" role="tab" data-toggle="" id="pub1">
                    Media                        </a>
                    </li>
                    <?php } ?>
                    
                    <li role="presentation" class="">
                        <a href="<?php echo base_url()?>dashboard/?target=ads&action=modify&id=<?php echo $id?>&step=4" role="tab" data-toggle="" id="pub1">
                    Promotions                        </a>
                    </li>
            </ul>
    </div>
     <?php }} ?>
    <div class="down-arrow"></div>
</div>

<section class="place-ads">

    <h4><strong><?php if (isset($response['message'])) echo $response['message']; ?></strong></h4>
    
        <label class="col-lg-12 col-md-12 col-sm-12 control-label" style="text-align: left;">
            <small>
                Select any of packages offered by us that suits most for your product.
            </small>
        </label>
        <div style="clear:both;"></div> 
        <div class="social-blog clearfix">
            <div class="pricing-table clearfix">
                <div class="row">
                    <?php //echo '<pre>'; print_r($packages);
                    if(isset($packages) && is_array($packages)){
                        foreach($packages as $package) {
                        ?>
                    <form class="form-horizontal" action="?_=6" method="post">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <ul style="height: 300px">
                                <li >
                                    <div class="title">
                                        <p><?php echo ucfirst($package['name']); ?></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="price1">
                                        <p><span>$</span> <?php echo $package['price'] ; ?></p>
                                        <p><span>per month</span></p>
                                    </div>
                                </li>
                                <input type="hidden" name="package_name" value="<?php echo $package['name']?>">
                                <input type="hidden" name="package_price" value="<?php echo $package['price']?>">
                                <li>
                                    <div class="">
                                        <p><label><input type="submit" name="b1" value="Select"></label></p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </form>
                    <?php } 
                    }?>
                    
                </div>
            </div>   
        </div>
    
</section>