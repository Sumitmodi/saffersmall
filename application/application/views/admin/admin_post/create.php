<script type="text/javascript" src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>  
<div class="right-section">
    <div class="right-top"></div>
    <div class="right-header dashboard">
      <h2><i class="fa fa-folder-open"></i>User List</h2>
      <div class="down-arrow"></div>
    </div>
    <p style="padding: 20px"><?php echo isset($response['message']) ? $response['message'] : NULL;?></p>
    <section class="place-ads">
        
        <form class="form-horizontal" action="#" method="post" name="post_form" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 control-label"> Post Title <span>*</span>  </label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-sm-9">
                    <input type="text" class="form-control" value="<?php if(isset($result))echo $result[0]['title']; ?>" name="title" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 control-label">Post Name </label>
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
                <label class="col-lg-3 col-md-3 col-sm-3 control-label"> Post Image <span>*</span> </label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-sm-9">
                    <input type="file" class="form-control" name="post_image" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3 control-label"> Post Image <span>*</span> </label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-sm-9">
                    <?php if(isset($result)){?>
                    <a href="<?php echo base_url().'assets/uploads/posts/'.$result[0]['image'] ?>">
                        <img src="<?php echo base_url().'assets/uploads/posts/'.$result[0]['image'] ?>" style="width: 250px;">
                    </a>
                    <?php }?>
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
<script type="text/javascript">
    var i = 0;
    var j = 0;
    var k = 0;
    var l = 0;
    var x = 0;
function submit_cat(){
   
   var category = $('#category').val();
   if(category != ""){
       $("#item").show();
       k = $('#hidden').val();
       x = parseInt(k,10);
       
       $('#add').click(function(){ //alert(i);
           i = i+1;
           j= i+1;
           l = x;
              x = x+1;
              alert('x:'+x); alert('i:'+i); alert('j:'+j);
           if(k>0){
              
              alert('here');
              $('#item'+l).after('<br/><input type="text" name="item'+x+'" placeholder="Enter category name" id="item'+x+'"/> <p id="cancel'+x+'" onclick="delete_row('+x+')">X</p>')
           }
        else
           $('#item'+i).after('<br/><input type="text" name="item'+j+'" placeholder="Enter category name" id="item'+j+'"/><p id="cancel'+j+'" onclick="delete_row('+j+')">X</p>')
       });
       
       $('#submit').click(function(){//alert("here");
           if(k>0){ //alert(x);
               $('#item1').after('<br/><input type="hidden" name="size" value="'+x+'"/>')
           }
           else
           $('#item1').after('<br/><input type="hidden" name="size" value="'+j+'"/>')
           $('#cat_form').submit();
       })
       
   }
   else
       $('#msg').html("category field should not be empty!");
}

</script>
<script type="text/javascript">
    var y = 0;
function delete_row(y){;
    $('#item'+y).remove();    
    $('#cancel'+y).remove();
    x = x-1;
    j = j-1;
    i = i-1;
    
}
</script>
