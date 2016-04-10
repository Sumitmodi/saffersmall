<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : activate.php
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
$has = false;
if(isset($data)){
    $has = true;
}
?>

<section class="create_account">
    <div class="container">
        <h2>Saffersmall :: Create an Account</h2>

        <div class="steps">

            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12"><p class="first">Step 1:<span> Register an account</span></p></div>
                <div class="col-md-4 col-sm-4  col-xs-4 visible-lg visible-md visible-sm"><p class="second">Step 2:<span> Verification of Account</span></p></div>
                <div class="col-md-4 col-sm-4  col-xs-4 visible-lg visible-md visible-sm"><p>Step 3:<span> Account recovery settings</span></p></div>
            </div>
            <div class="steps-bar"><img src="<?php echo base_url(); ?>assets/img/steps1.png" alt="" /></div>
        </div>

        <form action="<?php echo base_url();?>account/activate" method="post" class="form-horizontal">            
            <?php if (isset($response['message'])) { ?>
                <div class="form-group">
                    <label class="control-label col-lg-offset-2 col-md-offset-2">
                        The boss says :: <?php echo $response['message']; ?>
                    </label>
                </div>
            <?php } ?>
            <?php if(isset($emailSent)) {
                if($emailSent){
            ?>
                <div class="form-group">
                    <label class="control-label col-lg-offset-2 col-md-offset-2">
                        We have sent an activation link to <?php echo $data['email'];?>. Please enter the activation pin sent to your email here. If you did not receive the email, please click <a href="<?php echo base_url();?>email/resend/<?php echo $data['token'];?>">Here.</a>
                    </label>
                </div>
            <?php
                } else {
            ?>
                <div class="form-group">
                    <label class="control-label col-lg-offset-2 col-md-offset-2">
                        we could not send activation link to your email. Please click <a href="<?php echo base_url();?>email/resend/<?php echo $data['token'];?>">Here</a> if you want us to resend the activation email.
                    </label>
                </div>
            <?php
                }
            }?>
            <div class="form-group">                
                <label class="col-lg-3 col-md-3 col-lg-offset-2 col-md-offset-2 control-label col-sm-4">Activation Pin<span>*</span>    </label>
                <div class="col-lg-7 col-md-7">
                    <input type="text" class="form-control" name="pin" placeholder="Enter pin here" required/>
                </div>
            </div> 
            <div class="form-group">

                <div class="col-lg-offset-5 col-md-offset-5 col-lg-7 col-md-7 col-sm-offset-4 col-sm-8">
                    <input type="submit" value="Activate Account"/>
                </div>
            </div>
        </form>