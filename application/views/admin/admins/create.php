  <div class="right-section">
    <div class="right-top"></div>
    <div class="right-header dashboard">
      <h2><i class="fa fa-folder-open"></i>Admin Profile</h2>
      <div class="down-arrow"></div>
    </div>
    <p style="padding: 20px"><?php echo isset($response['message']) ? $response['message'] : NULL;?></p>
    <section class="place-ads">
        
        <form class="form-horizontal" action="#" method="post" name="add_admin">
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 control-label"> Name<span></span> </label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-sm-9">
                    <input type="text" class="form-control" value="<?php if(isset($result))echo $result->name; ?>" name="name" >
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 control-label">Username (required, at least 6 characters)<span>*</span> </label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-sm-9">
                    <input type="text" class="form-control" value="<?php if(isset($result))echo $result->username; ?>" minlength="6" name="username" required>
                </div>
            </div>
           
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 control-label"> Password (required, at least 6 characters)<span>*</span> </label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-sm-9">
                    <input type="password" class="form-control" placeholder="*******" value="" minlength="6" name="password" required>
                    <span id="change">Change Password</span>
                </div>
            </div>
            
            <div class="form-group" id="reset" <?php if(isset($result)){?>style="display: none" <?php } else { ?>style="display: block"<?php } ?> >
                <label class="col-lg-3 col-md-3 col-sm-3 control-label">Retype Password (required, at least 6 characters)<span>*</span> </label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-sm-9">
                    <input type="password" class="form-control" placeholder="*******" value="" minlength="6" name="repassword" required>
                    
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 control-label">Email<span>*</span> </label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-sm-9">
                    <input type="text" class="form-control" value="<?php if(isset($result))echo $result->email?>" name="email" required>
                </div>
            </div>
            
            <div class="form-group">
          <div class="col-lg-offset-3 col-md-offset-3 col-lg-9 col-md-9 col-sm-9">
            <input type="submit" value="<?php if(isset($result))echo 'Update'; else echo 'Submit';?>">
          </div>
        </div>
        </form>
    </section>
</div>
    
</section>
<script type="text/javascript">
$('#change').click(function(){
    $('#reset').show();
    })
    
$.validator.setDefaults({
		submitHandler: function() {
			alert("submitted!");
		}
	});
        
        $().ready(function() {
		// validate the comment form when it is submitted
		$("#add_admin").validate();
            });
</script>