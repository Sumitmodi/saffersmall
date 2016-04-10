<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : step5.php
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
            <small>Step :: 6</small>
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
 
                    <?php  if($ad_type !=1){ ?>
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
    <?php } }?>
    <div class="down-arrow"></div>
</div>



<section class="place-ads">

    <h4><strong><?php if (isset($response['message'])) echo $response['message']; ?></strong></h4>
    <?php if (isset($flag))
        $action = "?target=ads&action=modify&id=$id&step=5";
    else
        $action = '?_=7';
    
    ?>
    <form class="form-horizontal" action="<?php echo $action; ?>" method="post" id="package_form">
        <div id="pay"></div>
        <label class="col-lg-12 col-md-12 col-sm-12 control-label" style="text-align: left;">
            <small>
                Bring your ad on the top.
            </small>
        </label>
        <div style="clear:both;"></div> 
         <?php //echo '<pre>'; print_r($extra);?>
        <div class="form-group">
            <p class="col-lg-12 col-md-12 col-sm-12">
                <input type="checkbox" name="bump" value="<?php echo $bumpup_price; ?>" <?php if(isset($extra) && $extra->is_bumpup == 1){?>checked=""<?php } ?> >
                Bump your ad to the top of page 1 <span style="color:#f35656">($ <?php echo $bumpup_price;?> per month)</span>
            </p>
        </div>

        <div class="form-group">
            <p class="col-lg-12 col-md-12 col-sm-12">
                <input type="checkbox" name="top" value="<?php echo $top_price; ?>" <?php if(isset($extra) && $extra->is_topad == 1){?>checked=""<?php } ?>>
                Show your ad on rotation at the top of page 1 for the category 
                <span style="color:#f35656">($ <?php echo $top_price; ?> per month)</span> 
            </p>
        </div>

        <div class="form-group">
            <p class="col-lg-12 col-md-12 col-sm-12">
                <input type="checkbox" name="highlight" value="<?php echo $highlight_price; ?>" <?php if(isset($extra) && $extra->is_highlight == 1){?>checked=""<?php } ?>>
                Highlight your ad to gain visibility and stand out from the crowd 
                <span style="color:#f35656">($ <?php echo $highlight_price; ?> per month)</span> 
            </p>
        </div>

        <div class="form-group">
            <p class="col-lg-12 col-md-12 col-sm-12">
                <input type="checkbox" name="urgent" value="<?php echo $urgent_price; ?>" <?php if(isset($extra) && $extra->is_urgent == 1){?>checked=""<?php } ?>>
                Let buyers know you want to sell quickly with an Urgent label <span style="color:#f35656">($ <?php echo $urgent_price; ?> per month)</span>
            </p>
        </div>

        <div class="form-group">
            <p class="col-lg-12 col-md-12 col-sm-12">
                <input type="checkbox" name="home" value="<?php echo $home_price; ?>" <?php if(isset($extra) && $extra->is_home == 1){?>checked=""<?php } ?>>
                <b>*Most visibility*</b> 
                Show your ad to millions of people on the Saffersmall Home page! <span style="color:#f35656">($ <?php echo $home_price; ?> per month)</span> 
            </p>
        </div>
        
        <div class="form-group">
            <p class="col-lg-12 col-md-12 col-sm-12">
                Payment Type
                <input type="radio" name="payment" value="paypal"> 
                <b>Paypal</b> 
                <input type="radio" name="payment" value="eft"> 
                <b>Eft Payment</b> 
                
                
            </p>
        </div>
        <div class="form-group">
            <p class="col-lg-12 col-md-12 col-sm-12">
                Current sum : $ <span style="color:#f35656;" class="sum">0</span>/-
            </p>
        </div>
        <div class="form-group">
            <?php if ($this->session->userdata('is_sfi') == 1) { ?>
            <input type="button"  value="Pay Later" id="pay_later">
            <?php } ?>
            <input type="submit"  value="submit">
            <?php if(isset($flag)) {?>
                <input type="button" value="Cancel" id="cancel">
                <?php }?>
        </div>
      
    </form>
</section>
<script type="text/javascript">
    $(document).ready(function () {
        
        $('#cancel').click(function(){
            window.location.replace("<?php echo base_url()?>dashboard");
        })
        
        $('#pay_later').click(function(){
           $('#pay').html('<input type="text" value="later" name="later" style="display: none">')
           $('#package_form').submit();
        })
        
        $('input[type=checkbox]').click(function () {
          
                var sum = 0;
            $('input[type=checkbox]').each(function (i) {
                var cur = $('input[type=checkbox]').eq(i);
                console.log(i);
                if ($(cur).is(':checked')) {
                    sum = sum + parseFloat($(cur).val());
                }
                $('span.sum').html(sum);

            });
            
            return true;
        });
    });
</script>
