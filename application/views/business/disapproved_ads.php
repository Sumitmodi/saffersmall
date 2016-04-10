<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : log.php
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
        <i class="fa fa-folder-open"></i>Your Recent Notification Log
    </h2>
    <div class="down-arrow"></div>
</div>
<div class="control-user">
    <div id="responses"></div>
    <?php if (!isset($disapproved_ads)) { ?>
    <center><h3>Your notifications log is empty.</h3><center>
    <?php } else { ?>
        <div class="table-responsive">        
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Activity</th>
                        <th>Suggestion</th>
                        <th>Date</th>
                    </tr>                
                </thead>
                <tbody>
                    <?php 
                    $i=0;
                    foreach ($disapproved_ads as $k => $disapproved_ad){
                        //echo '<pre>';  print_r($notification);
                        //echo $notification[0]['sno'];
                        if($disapproved_ad[0]['action'] != ''){
                            $i= $i+1;
                    ?>
                   
                        <tr>
                            <th><?php echo $i; ?></th>
                            <th><?php echo $disapproved_ad[0]['action']; ?></th>
                            <th><?php echo $disapproved_ad[0]['suggestion']; ?></th>
                            <th><?php echo formatTime($disapproved_ad[0]['date_created']); ?></th>
                        </tr>     
                    <?php }} ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</div>    
