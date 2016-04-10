<?php
/*
 * Author : Sandeep Giri <ioesandeep@gmail.com>
 * 
 * Project : grasshopit
 * 
 * File : reset.php
 * 
 * Created : Nov 9, 2014 12:10:00 AM
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
 *   get permissions from the author or the distrubutor of this code.
 * 
 *   However do not expect any help or support from the author.
 */
?>

<div class="categories clearfix">
    <div class="custom-container">
        <div class="col-sm-5 col-md-5">
            <h2 id="business-heading">Grasshopit Account Reset</h2>                  
            <?php
            if (isset($message))
            {
                ?> 
                <label><?php echo $message; ?></label>
            <?php } ?>      
            <p>Your username: <?php echo $username;?></p>
            <div class="business-left">
                <form action="<?php echo base_url();?>reset" method='post'>
                    <input type="hidden" name="username" value="<?php echo $username;?>"/>
                    <input type="hidden" name="loginType" value="<?php echo $loginType;?>"/>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password:</label>
                        <input type="password" class="form-control" name="pass_1" placeholder="Enter new password" required/>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password Again:</label>
                        <input type="password" class="form-control" name="pass_2" placeholder="Enter password again" required/>
                    </div>
                    <div id="add-bussiness">
                        <button type="submit" class="btn btn-add"><a id="add-business" >Submit now</a></button>
                    </div>  
            </div>
        </div>
    </div>
</div>