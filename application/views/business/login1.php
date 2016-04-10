<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : login.php
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

<div class="login-form clearfix">
    <h2><?php echo strtoupper(DOMAIN); ?> :: LOGIN</h2>
    <form action="?type=<?php echo $type; ?>" method="post">
<?php if (isset($response['message'])) { ?>
            <div class="form-group">
                <label class="control-label">
                    The Boss says :: <?php echo $response['message']; ?>
                </label>
            </div>
<?php } ?>
        <div class="form-group">
            <div class="login-icon"><i class="fa fa-user"></i></div>
            <input type="text" class="form-control" placeholder="Username" name="username">
        </div>
        <div class="form-group">
            <div class="login-icon"><i class="fa fa-key"></i></div>
            <input type="password" class="form-control" placeholder="Password" name="password">
        </div>
        <div class="form-group">
            <label class="control-label">
                <input type="checkbox" name="remember" value="remember"> Remember me
            </label>
           
        </div>
        
        <div class="form-group">
            
            <label>Trouble logging in? </label>
            <a style="color: #005702" href="<?php echo base_url() ?>forgot_password?type=business">Forgot Password</a>
            
        </div>
        
        <div class="form-group">
            <label class="control-label">
                Register you business now. <a href="register">Click here</a>
            </label>
        </div>
        <div class="form-group">
            <input type="submit" value="LOGIN">
        </div>
    </form>

</div>