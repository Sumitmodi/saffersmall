<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : ads.php
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
        <i class="fa fa-folder-open"></i><?php echo $title ?>
        <?php //if (isset($ads)) {
            ?>
            <div class="choose-ads">            
                <form role="form" class="form-inline">
                    <div class="form-group">
                        <small>Sort Ads by:</small>
                        <select class="form-control">
                            <option>Select Ad Type</option>
                            <option value="<?php echo base_url(); ?>dashboard/ad_list/active_ads">Active Ads</option>
                            <option value="<?php echo base_url(); ?>dashboard/ad_list/expired_ads">Expired Ads</option>
                            <option value="<?php echo base_url(); ?>dashboard/ad_list/awating_ads"> Awaiting Approval</option>
                            <option value="<?php echo base_url(); ?>dashboard/ad_list/inactive_ads"> Inactive Ads</option>
                            <option value="<?php echo base_url(); ?>dashboard/ad_list/link_ads"> Link Ads</option>
                            
                        </select>
                    </div>
                </form>
            </div>
        <!--<?php //} else { ?>
            <div class="choose-ads">    
                <?php echo "<small>{$response['message']}</small>"; ?>
            </div>
        <?php //} ?>-->
    </h2>
    <div class="down-arrow"></div>
</div>
<div>
    <?php //if(isset($this->session->userdata('ad_msg'))) 
        echo $this->session->userdata('ad_msg'); 
        $this->session->unset_userdata('ad_msg');?></div>
<div class="my-ads" >

    <?php if (!isset($ads)) { 
        if(isset($ad_list)  && $ad_list != true){
        ?>
        <div class="my-ad">
            <div class="row">
                <div class="col-lg-9 col-md-9">
                    The Boss Says :: Hello <a href="./dashboard"><?php echo $this->session->userdata('username'); ?></a>, Thanks you for choosing us for promoting your business. You are all set to place your first ad on <a href=".">saffersmall.com</a>. We are already waiting to promote your product.
                </div>
            </div>
        </div>
        <div class="my-ad">
            <div class="row">
                <div class="col-lg-9 col-md-9">
                    Have you made up your mind, Please click <a href="<?php echo base_url(); ?>dashboard/placead">Here</a> to create your first ad.
                </div>
            </div>
        </div>

        <?php
        } else { ?>
           
        <div class="my-ad">
            <div class="row">
                <div class="col-lg-9 col-md-9">
                    There is no any ad.
                </div>
            </div>
        </div>
    <?php
        }
    } else {
//        echo '<pre>';
//        print_r($ads);


        foreach ($ads as $ad) {

            $name = str_replace(' ', '-', strtolower($ad['name']));
            
            $img = explode('/', $ad['image']);
            
            $img = $img[2];
            
            
            if($img!=null || $img!= '')
                $img_url = base_url().'assets/uploads/'.$ad['image'];
            
            else 
                $img_url = base_url().'assets/img/saffersmall-logo-final.png';
            ?>


            <div class="my-ad" >
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div class="ad-img">
                            <div class="img-overlay"></div>
                            <a href="<?php echo base_url() . 'dashboard/ad/' . $ad['username'] . '/' . $name; ?>"><img src="<?php echo $img_url; ?>" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9">
                        <h3><a href="<?php echo base_url() . 'dashboard/ad/' . $ad['username'] . '/' . $name; ?>"><?php echo $ad['name']; ?></a></h3>
                        <span><strong>Posted</strong> : <em><?php echo formatTime($ad['date_added']); ?></em>   </span>	
                        <span><strong>Ad status</strong> : <em><?php echo $ad['status']; ?></em>   </span>
                        <p><?php echo $ad['description']; ?></p>
                        <a href="<?php echo base_url() ?>dashboard/?target=ads&action=remove&user=<?php echo $ad['username']?>&name=<?php echo $name; ?>" class="btn btn-danger btn-sm">Remove</a>
                        
                        <?php if($ad['status'] != 'Inactive') { ?>
                        <a href="<?php echo base_url() ?>dashboard/?target=ads&action=inactive&user=<?php echo $ad['username']?>&name=<?php echo $name; ?>" class="btn btn-warning btn-sm">Inactive</a>
                        <?php } if($ad['status'] == 'Inactive'){ ?>
                        <a href="<?php echo base_url() ?>dashboard/?target=ads&action=active&user=<?php echo $ad['username']?>&name=<?php echo $name; ?>" class="btn btn-warning btn-sm">Active</a>
                        <?php } ?>
                        <a href="<?php echo base_url() ?>dashboard/?target=ads&action=modify&id=<?php echo $ad['sno']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?php echo base_url() ?>dashboard/?target=ads&action=report&user=<?php echo $ad['username']?>&name=<?php echo $name; ?>" class="btn btn-warning btn-sm">Report</a>

                    </div>
                </div>
            </div>

        <?php
        }
    }
    ?>
    <!-- Lets implement it later
    <div class="pagination-outer">
        <ul class="pagination">
            <li><a href="#">&laquo;</a></li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">&raquo;</a></li>
        </ul>
    </div>
    -->
</div>

<script type='text/javascript'>
    $(document).ready(function () {
        $('select').on('change', function () {
            var val = $(this).val();

            if (val != '') {
                window.location.href = val;
            }
        })
    })
</script>