
<div class="right-section">
    <div class="right-top"></div>
    <div class="right-header dashboard">
      <h2><i class="fa fa-folder-open"></i>Socail Links List</h2>
      <div class="down-arrow"></div>
    </div>
    <p style="padding: 20px"><?php echo isset($response['message']) ? $response['message'] : NULL;?></p>
    <section class="place-ads">
        
        <form class="form-horizontal" action="#" method="post" name="post_form" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 control-label"> Title <span>*</span>  </label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-sm-9">
                    <input type="text" class="form-control" value="<?php if(isset($result))echo $result[0]['title']; ?>" name="title" <?php if(isset($result)){ ?> readonly="" <?php }?>required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 control-label">Link </label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-sm-9">
                    <input type="text" class="form-control" value="<?php if(isset($result))echo $result[0]['link']; ?>" name="link">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 control-label"> Logo <span>*</span> </label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-sm-9">
                    <input type="file" class="form-control" name="admin_logo" required="">
                </div>
            </div>
            <?php 
            if(isset($result)){
            if($result[0]['logo'] != NULL ){?>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 control-label"> Logo <span>*</span> </label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-sm-9">
                    <?php if(isset($result)){?>
                    <a href="<?php echo base_url().'assets/uploads/logos/'.$result[0]['logo'] ?>">
                        <img src="<?php echo base_url().'assets/uploads/logos/'.$result[0]['logo'] ?>" style="width: 250px;">
                    </a>
                    <?php }?>
                </div>
            </div>
            <?php } }?>
           
            <div class="form-group">
          <div class="col-lg-offset-3 col-md-offset-3 col-lg-9 col-md-9 col-sm-9">
            <input type="submit" value="Submit">
          </div>
        </div>
        </form>
    </section>
</div>
    
</section>

