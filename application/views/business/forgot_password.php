<section style="min-height: 200px" class="main">
    <div style="width: 100%;text-align: center;margin-top: 10%" class="info-wrapper">
        <h4>Please provide your <?php echo strtoupper($_GET['type']) ?> Account Email address that you registered with us.</h4><br />
        <p><?php echo isset($message) ? $message : NULL; ?></p>
        <form action="" method="post" class="loginform contactform">
            <label for="email">Your Email :  </label>&nbsp;&nbsp;<input class="input-xlarge input-active" style="border: 1px solid #aaa;width: 300px" type="email" required="" name="email">
            <input class="btn btn-primary" type="submit" value="Confirm">
        </form>
    </div>
</section>