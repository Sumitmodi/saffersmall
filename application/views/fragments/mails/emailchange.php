<?php

/*
 * Author   :   Sandeep Giri
 * Email    :   sandeep@nurakanbpo.com
 * Date     :   2014/08/18 3:51:27 PM
 * File     :   emailchange.php 
 * Project  :   grasshopit
 * Copyright (c) Nurakan Technologies Pvt. Ltd.
 */
?>
<html>
    <body>
        <p class="content">Dear <?php echo $user;?>,</p>
        <p class="content">
            This email has been to sent to you to verify your pending email changing request. Please click
            the verification link to verify this email.
        </p>
        <p class="content">
            Remember: Your previous email has been replaced by this email and it only needs to be verified.
        </p>
        <p class="conent">
            Here is your verification link.
            <a href="<?php echo BASE;?>verify/email/?pin=<?php echo $pin;?>">
                <?php echo BASE;?>verify/email/?pin=<?php echo $pin;?>
            </a>
        </p>
        <p class="content">
            This is an automatic email generated by <?php echo BASE;?> mail engine. Please do not 
            reply or you may not receive any response.
        </p>
        <p class="content">
            Thanks,<br/>
            <?php echo BASE;?> Mail Engine
        </p>
    </body>
</html>