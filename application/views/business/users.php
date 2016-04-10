<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : users.php
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
        <i class="fa fa-folder-open"></i>Active Members Around you
    </h2>
    <div class="down-arrow"></div>
</div>
<div class="myads">
    <?php if (!isset($sfis)) { ?> 
        <div class="my-ad">
            <div class="row">
                <div class="col-lg-9 col-md-9">
                    The Boss Says :: There are not any active members registered around you. Perhaps, you will see some around the next time you login. Good Luck !
                </div>
            </div>
        </div>
    <?php } else {
        foreach ($sfis as $s) {  ?>

            <section class="">
                <div class="">
                    <div class="">
                        <div class="">
                            <div class="social-blog orange">
                                <h2><strong><?php echo $s['person_name'];?></strong></h2>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="category-list">
                                            <div class="category clearfix">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 left">
                                                        <p>Business Name</p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 right">
                                                        <p><strong><?php echo $s['business_name'];?></strong></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="category clearfix">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 left">
                                                        <p>Address</p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 right">
                                                        <p><strong><?php echo $s['address'];?></strong></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="category clearfix">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 left">
                                                        <p>State</p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 right">
                                                        <p><strong><?php echo $s['state'];?></strong></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="category clearfix">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 left">
                                                        <p>City</p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 right">
                                                        <p><strong><?php echo $s['city'];?></strong></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($s['is_sfi'] == 1) { 
                                                $profs = explode(',',$s['profile_link']);                                                
                                            ?>   
                                            <div class="category clearfix">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 left">
                                                        <p>Profile Link</p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 right">
                                                        <?php foreach($profs as $p) { ?>
                                                        <p>
                                                            <strong>
                                                                <a href="<?php echo $p;?>"><?php echo $p;?></a>
                                                            </strong>
                                                        </p>
                                                        <?php } ?>
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
                                                        <p>Telephone</p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 right">
                                                        <p> <strong><?php echo $s['telephone'];?></strong></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="category clearfix">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 left">
                                                        <p>Postal Code</p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 right">
                                                        <p><strong><?php echo $s['postal_code'];?></strong></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="category clearfix">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 left">
                                                        <p>Fax</p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 right">
                                                        <p><strong><?php echo $s['fax'];?></strong></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="category clearfix">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 left">
                                                        <p>Email</p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 right">
                                                        <p><strong><?php echo $s['email'];?></strong></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="category clearfix">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 left">
                                                        <p>
                                                            <a href='<?php echo base_url();?>ads/<?php echo $s['username'];?>'>
                                                                View ads by <?php echo $s['person_name'];?>
                                                            </a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    <hr/>
        <?php } ?> 
<?php } ?>
</div>
