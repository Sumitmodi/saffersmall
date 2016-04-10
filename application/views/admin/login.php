<div class="login-form clearfix">
    <h2>LOGIN</h2>
    <form action="<?php echo base_url(); ?>admin/login" method="post">
        <?php if (isset($response['message']))
        { ?>
            <div class="form-group">
                <label class="control-label">
                    The Boss says :: <?php echo $response['message']; ?>
                </label>
            </div>
<?php } ?>
        <div class="form-group">
            <div class="login-icon"><i class="fa fa-user"></i></div>
            <input type="text" class="form-control" name="uname" placeholder="Enter admin username" required>
        </div>
        <div class="form-group">
            <div class="login-icon"><i class="fa fa-key"></i></div>
            <input type="password" class="form-control" name="password" placeholder="Enter admin password" required>
        </div>
        <!--<div class="form-group">
        <label class="control-label">
            <input type="checkbox" > Remember me
        </label>
        </div>-->
        <div class="form-group">
            <input type="submit" value="LOGIN">
        </div>
    </form>

</div>