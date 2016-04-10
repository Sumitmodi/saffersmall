<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : register.php
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

if (isset($data)) {
    $has = true;
}
?>
<section class="create_account">
    <div class="container">
        <h2>Create a Saffersmall account</h2>

        <div class="steps">

            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12"><p class="first">Step 1:<span> Register an account</span></p></div>
                <div class="col-md-4 col-sm-4  col-xs-4 visible-lg visible-md visible-sm"><p class="second">Step 2:<span> Verification of Account</span></p></div>
                <div class="col-md-4 col-sm-4  col-xs-4 visible-lg visible-md visible-sm"><p>Step 3:<span> Account recovery settings</span></p></div>
            </div>
            <div class="steps-bar"><img src="<?php echo base_url(); ?>assets/img/steps.png" alt="" /></div>
        </div>
        <form action="?type=business" method="post" class="form-horizontal">
            <?php if (isset($response['message'])) { ?>
                <div class="form-group">
                    <label class="control-label col-lg-offset-2 col-md-offset-2">
                        The boss says :: <?php echo $response['message']; ?>
                    </label>
                </div>
            <?php } ?>
            <div class="form-group">                
                <label class="col-lg-3 col-md-3 col-lg-offset-2 col-md-offset-2 control-label col-sm-4">You are<span>*</span>    </label>
                <div class="col-lg-7 col-md-7">
                    <input type="text" class="form-control" name="registrar" <?php echo $has ? "value='{$data['registrar']}'" : 'placeholder="Enter your name"'; ?> required/>
                </div>
            </div> 
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-lg-offset-2 col-md-offset-2 control-label col-sm-4">Business Name<span>*</span>    </label>
                <div class="col-lg-7 col-md-7">
                    <input type="text" class="form-control" name="business" <?php echo $has ? "value='{$data['business']}'" : 'placeholder="Your business name"'; ?> required/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-lg-offset-2 col-md-offset-2 control-label col-sm-4">Phone Number<span>*</span>    </label>
                <div class="col-lg-7 col-md-7">
                    <input type="text" class="form-control" name="phone" <?php echo $has ? "value='{$data['phone']}'" : 'placeholder="Enter Phone number"'; ?> required/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-lg-offset-2 col-md-offset-2 control-label col-sm-4">Email Address<span>*</span>    </label>
                <div class="col-lg-7 col-md-7">
                    <input type="text" class="form-control" name="email" <?php echo $has ? "value='{$data['email']}'" : 'placeholder="Enter your email address"'; ?> required/>
                </div>
            </div>
            <div class="form-group">
                <hr/>
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-lg-offset-2 col-md-offset-2 control-label col-sm-4">Username<span>*</span>    </label>
                <div class="col-lg-7 col-md-7">
                    <input type="text" class="form-control" name="username" <?php echo $has ? "value='{$data['username']}'" : 'placeholder="Enter username"'; ?>/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-lg-offset-2 col-md-offset-2 control-label col-sm-4">Password<span>*</span>    </label>
                <div class="col-lg-7 col-md-7">
                    <input type="password" class="form-control" name="pass_1" placeholder="Enter Password" required/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-lg-offset-2 col-md-offset-2 control-label col-sm-4">Confirm Password<span>*</span>    </label>
                <div class="col-lg-7 col-md-7">
                    <input type="password" class="form-control" name="pass_2" placeholder="Confirm Password" required/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-5 col-md-7 col-md-offset-5 col-sm-offset-4 col-sm-8">
                    <label class="control-label checkbox-ctrl">
                        <input type="checkbox" name="sfi" value="sfi"/>  
                        I am a SFI/TC Affiliate.
                    </label>
                </div>
            </div>
            <div class="form-group" style='display:none' id='profile'>
                <label class="col-lg-3 col-md-3 col-lg-offset-2 col-md-offset-2 control-label col-sm-4">SFI Profile Link<span>*</span>    </label>
                <div class="col-lg-7 col-md-7">
                    <input type="text" class="form-control" name="sfi_profile[]" placeholder="Enter Profile Link" required/>
                </div>
            </div>
            
            <div class="form-group" style='display:none' id='gateway'>
                <label class="col-lg-3 col-md-3 col-lg-offset-2 col-md-offset-2 control-label col-sm-4">Invitation Getway Link<span>*</span>    </label>
                <div class="col-lg-7 col-md-7">
                    <input type="text" class="form-control" name="gateway" value="http://www.sfi1.biz/12149796" readonly=""/>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-lg-offset-5 col-md-7 col-md-offset-5 col-sm-offset-4 col-sm-8">
                    <label class="control-label checkbox-ctrl">
                        <input type="checkbox" name="terms" value="accept" required/>  
                        I have read the Terms & Conditions and agree to follow the privacy policy.
                    </label>
                </div>
            </div>
            <div class="form-group">

                <div class="col-lg-offset-5 col-md-offset-5 col-lg-7 col-md-7 col-sm-offset-4 col-sm-8">
                    <input type="submit" value="Create Account"/>
                </div>
            </div>
        </form>
    </div>
</section>
<script type='text/javascript'>
    $(document).ready(function () {
        $('input[name=sfi]').click(function () {
            if ($(this).is(':checked')) {
                $('div#profile').css('display', 'block');
				$("input#sfi_profile").removeAttr('disabled');
				$('input#sfi_profile').attr('required','required');
            } else {
                $('div#profile').css('display', 'none');
				$("input#sfi_profile").removeAttr('required');
				$('input#sfi_profile').attr('disabled','disabled');
            }
        });
    })
</script>