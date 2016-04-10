
<div class="right-section">
    <div class="right-top"></div>
    <div class="right-header dashboard">
      <h2><i class="fa fa-folder-open"></i>Add Link</h2>
      <div class="down-arrow"></div>
    </div>
    <p style="padding: 20px"><?php echo isset($response['message']) ? $response['message'] : NULL;?></p>
    <section class="place-ads">
        
        <form class="form-horizontal" action="#" method="post" name="post_form" enctype="multipart/form-data">
            
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 control-label">Link <span>*</span> </label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-sm-9">
                    <input type="text" class="form-control" value="<?php if(isset($result))echo $result[0]['link']; ?>" name="link" required>
                </div>
            </div>
           
            <div class="form-group">
          <div class="col-lg-offset-3 col-md-offset-3 col-lg-9 col-md-9 col-sm-9">
            <input type="submit" value="Submit">
          </div>
        </div>
        </form>
    </section>
</div>
    
</section>

