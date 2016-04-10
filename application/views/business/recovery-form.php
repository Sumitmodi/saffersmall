<?php
/*
 * Author : Sandeep Giri <ioesandeep@gmail.com>
 * 
 * Project : grasshopit
 * 
 * File : recovery-form.php
 * 
 * Created : Nov 8, 2014 11:58:23 PM
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
 *   This is free software, and you are welcome t
 * */
?> 
<div class="categories clearfix">
    <div class="custom-container">
        <div class="col-sm-5 col-md-5">
            <h2 id="business-heading">Saffersmall Account Recovery</h2>                  
            <?php 
            if (isset($message))
            {
                ?> 
                <label><?php echo $message; ?></label>
<?php } ?>      

            <div class="business-left">
                <form action="<?php echo base_url(); ?>reset" method='post'>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Pin:</label>
                        <input type="text" class="form-control" name="pin" placeholder="Enter pin here" required/>
                    </div>
<?php if (isset($email))
{ ?> 
                        <input type="hidden" name="email" value="<?php echo $email; ?>"/>
                        <input type="hidden" name="username" value="<?php echo $username; ?>"/>
                        <input type="hidden" name="loginType" value="<?php echo $loginType; ?>"/>
<?php } ?>
                    <div id="add-bussiness">
                        <button type="submit" class="btn btn-add"><a id="add-business" >Submit now</a></button>
                    </div>  
            </div>
        </div>
    </div>
</div>