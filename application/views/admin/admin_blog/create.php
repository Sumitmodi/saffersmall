<script type="text/javascript" src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>  
<div class="right-section">
    <div class="right-top"></div>
    <div class="right-header dashboard">
      <h2><i class="fa fa-folder-open"></i>Add Blog</h2>
      <div class="down-arrow"></div>
    </div>
    <p style="padding: 20px"><?php echo isset($response['message']) ? $response['message'] : NULL;?></p>
    <section class="place-ads">
        
        <form class="form-horizontal" action="#" method="post" name="post_form" enctype="multipart/form-data">
            
            <input type="hidden" class="form-control" value="blog" name="title" >
                
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 control-label">Blog Name </label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-sm-9">
                    <input type="text" class="form-control" value="<?php if(isset($result))echo $result[0]['name']; ?>" name="name" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 control-label"> Content<span>*</span> </label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-sm-9">
                    <textarea  class="form-control ckeditor" name="content"><?php if(isset($result))echo $result[0]['content']; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 control-label"> Blog Image <span>*</span> </label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-sm-9">
                    <input type="file" class="form-control" name="post_image" >
                </div>
            </div>
            <?php 
            if(isset($result)){
            if($result[0]['image'] != NULL ){?>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 control-label"> Blog Image <span>*</span> </label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-sm-9">
                    <?php if(isset($result)){?>
                    <a href="<?php echo base_url().'assets/uploads/blogs/'.$result[0]['image'] ?>">
                        <img src="<?php echo base_url().'assets/uploads/blogs/'.$result[0]['image'] ?>" style="width: 250px;">
                    </a>
                    <?php }?>
                </div>
            </div>
            <?php } 
            }?>
            <div class="form-group">
          <div class="col-lg-offset-3 col-md-offset-3 col-lg-9 col-md-9 col-sm-9">
            <input type="submit" value="Submit">
          </div>
        </div>
        </form>
    </section>
</div>
    
</section>
