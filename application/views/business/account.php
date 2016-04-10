<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : account.php
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
        <i class="fa fa-folder-open"></i>Your Accounts Dashboard
    </h2>
    <div class="down-arrow"></div>
</div>
<div class="control-user">
    <div id="responses"></div>
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th>You are</th>
                <th><?php echo $user->person_name; ?></th>
                <th><a href="<?php echo base_url() . 'dashboard/accounts/change?target=name'; ?>" class="pop">Change</a></th>
            </tr>
            <tr>
                <th>Business name</th>
                <th><?php echo $user->business_name; ?></th>
            </tr>
            <?php if ($user->is_sfi == 1) {
                $links = explode(',', $user->profile_link);
                ?> 
                <tr>
                    <th>Profile Link</th>
                    <th>
                <table>
    <?php foreach ($links as $link) { ?> 
                        <tr>
                            <th>
                                <a href='<?php echo $user->profile_link; ?>'><?php echo $user->profile_link; ?></a>
                            </th>
                        </tr>
    <?php } ?>
                </table>
                </th>
                </tr>
<?php } ?>
            <tr>
                <th>Business Address</th>
                <th><?php echo isset($user->address) ? $user->address : '<a href="' . base_url() . 'dashboard/accounts/change?target=address" class="pop">Add</a>'; ?></th>
<?php echo isset($user->address) ? '<th><a href="' . base_url() . 'dashboard/accounts/change?target=address" class="pop">Change</a></th>' : NULL; ?>
            </tr>
            <tr>
                <th>Business Email</th>
                <th><?php echo isset($user->email) ? $user->email : '<a href="#">Add</a>'; ?></th>
<?php echo isset($user->email) ? '<th><a href="' . base_url() . 'dashboard/accounts/change?target=email" class="pop">Change</a></th>' : NULL; ?>
            </tr>
            <tr>
                <th>Telephone</th>
                <th><?php echo isset($user->telephone) ? $user->telephone : '<a href="' . base_url() . 'dashboard/accounts/change?target=phone" class="pop">Add</a>'; ?></th>
<?php echo isset($user->telephone) ? '<th><a href="' . base_url() . 'dashboard/accounts/change?target=phone" class="pop">Change</a></th>' : NULL; ?>
            </tr>
            <tr>
                <th>Fax Number</th>
                <th><?php echo isset($user->fax) ? $user->fax : '<a href="' . base_url() . 'dashboard/accounts/change?target=fax" class="pop">Add</a>'; ?></th>
<?php echo isset($user->fax) ? '<th><a href="' . base_url() . 'dashboard/accounts/change?target=fax" class="pop">Change</a></th>' : NULL; ?>
            </tr>
            <tr>
                <th>Postal Code</th>
                <th><?php echo isset($user->postal_code) ? $user->postal_code : '<a href="' . base_url() . 'dashboard/accounts/change?target=postal" class="pop">Add</a>'; ?></th>
<?php echo isset($user->postal_code) ? '<th><a href="' . base_url() . 'dashboard/accounts/change?target=postal" class="pop">Change</a></th>' : NULL; ?>
            </tr>
            <tr>
                <th>Username</th>
                <th><?php echo isset($user->username) ? $user->username : '<a href="#">Add</a>'; ?></th>
                <th><?php echo isset($user->username) ? '<a href="' . base_url() . 'dashboard/accounts/change?target=username" class="pop">Change</a>' : NULL; ?></th>
            </tr>
            <tr>
                <th>Country</th>
                <th><?php echo isset($user->country) ? $user->country : '<a href="' . base_url() . 'dashboard/accounts/change?target=country" class="pop">Add</a>'; ?></th>
                <th><?php echo isset($user->country) ? '<a href="' . base_url() . 'dashboard/accounts/change?target=country" class="pop">Change</a>' : NULL; ?></th>
            </tr>
            <tr>
                <th>City</th>
                <th><?php echo isset($user->city) ? $user->city : '<a href="' . base_url() . 'dashboard/accounts/change?target=city" class="pop">Add</a>'; ?></th>
                <th><?php echo isset($user->city) ? '<a href="' . base_url() . 'dashboard/accounts/change?target=city" class="pop">Change</a>' : NULL; ?></th>
            </tr>
            <tr>
                <th>Business Logo</th>
                <th><?php echo isset($user->logo) ? '<img src="' . base_url() . '/assets/uploads/business/logo/' . $user->logo . '"/>' : '<a href="#">Add</a>'; ?></th>
<?php echo isset($user->logo) ? '<th><a href="#" class="pop">Change</a></th>' : NULL; ?>
            </tr>
        </table>
    </div>
</div>