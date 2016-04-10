<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : payments.php
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

function getStatus($status) {

    if (strtolower($status) == "p") {
        return 'Pending';
    }
    if (strtolower($status) == "r") {
        return 'Received';
    }
    if (strtolower($status) == "c") {
        return 'Cancelled';
    }
    if (strtolower($status) == "f") {
        return 'Failed';
    }
    return 'unknown';
}
function payMethod($via){
    
    return strtolower($via) == 'paypal' ? 'Paypal' : ( strtolower($via) == 'eft' ? 'EFT' : 'unknown');
}
?>
<div class="right-top"></div>
<div class="right-header dashboard">
    <h2>
        <i class="fa fa-folder-open"></i>Your Payment Log
    </h2>
    <div class="down-arrow"></div>
</div>
<div class="control-user">
    <div id="responses"></div>

    <?php if (!isset($log)) { ?>
        <center><h3>Your payment log is empty.</h3><center>
            <?php } else { ?>
                <div class="table-responsive">        
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Reason</th>
                                <th>Paid Date</th>
                            </tr>
                        </thead> 
                        <tbody>
                            <?php
                            foreach ($log as $k => $l) {
                                $l = (object) $l;
                                if (is_null($l->received_amount)) {
                                    continue;
                                }
                                ?>
                                <tr>
                                    <th><?php echo $k + 1; ?></th>
                                    <th><?php echo $l->received_amount . (!is_null($l->gross_amount) ? ' out of ' . $l->gross_amount : NULL).' via '.payMethod($l->payment_method); ?></th>
                                    <th><?php echo getStatus($l->payment_status); ?></th>
                                    <th>
                                        <?php if (strtolower($l->payment_status) == 'r')
                                            if (!empty($l->ad_id)) {
                                                ?>
                                    <table>
                                        <tr>
                                            <th>
                                                Product promotion :: 'product here'
                                            </th>
                                        </tr>
                <?php if ($l->is_bumpup > 0) { ?>
                                            <tr>
                                                <th>
                                                    Bump Up :: <?php echo $l->is_bumpup; ?>     
                                                </th>
                                            </tr>
                                        <?php } ?>
                <?php if ($l->is_topad > 0) { ?>
                                            <tr>
                                                <th>
                                                    Bring to top :: <?php echo $l->is_topad; ?>     
                                                </th>
                                            </tr>
                                        <?php } ?>
                <?php if ($l->is_highlight > 0) { ?>
                                            <tr>
                                                <th>
                                                    Highlighted :: <?php echo $l->is_highlight; ?>     
                                                </th>
                                            </tr>
                                        <?php } ?>
                <?php if ($l->is_urgent > 0) { ?>
                                            <tr>
                                                <th>
                                                    Urgent Posting :: <?php echo $l->is_urgent; ?>     
                                                </th>
                                            </tr>
                                        <?php } ?>
                <?php if ($l->is_home > 0) { ?>
                                            <tr>
                                                <th>
                                                    Home Page :: <?php echo $l->is_home ?>     
                                                </th>
                                            </tr>
                                    <?php } ?>
                                    </table>
                                <?php } else { if($l->package_id > 0) { ?> 
                                    <?php echo 'Package fee :: ';?>
                                    <?php } ?>

            <?php } ?>
                            </th>
                            <th><?php echo formatTime($l->pay_time); ?></th>
                            </tr>
    <?php } ?>
                        </tbody>
                    </table>           
<?php } ?>
            </div>
