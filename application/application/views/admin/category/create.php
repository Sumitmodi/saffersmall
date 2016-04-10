<?php //echo '<pre>'; print_r($result);?>
<section class="body-part clearfix">
  <div class="right-section">
    <div class="right-top"></div>
    <div class="right-header dashboard">
      <h2><i class="fa fa-folder-open"></i>User List
          <div class="choose-ads">            
              <!--<form role="form" class="form-inline">
              <div class="form-group">
                <select class="form-control">
                  <option>Active Ads</option>
                  <option>Inactive Ads</option>
                  <option>Awaiting Activation</option>
                  <option>Proecessing</option>
                </select>
              </div>
            </form>
-->          </div>
      </h2>
      <div class="down-arrow"></div>
    </div>
</div>
    <div class="control-user"> 
    
    <p><?php echo isset($response['message']) ? $response['message'] : NULL;?></p>
   
    <div id="msg"></div>

    <form action="" method="post" id="cat_form">
    <p>
        <input type="text" name="name" value="<?php if(isset($result)) echo $result['cat_info'][0]['category_name'];?>" id="category"/>
        
    </p>
    <p>
        <input type="button" value="<?php if(isset($result)) echo 'Update'; else echo 'Create';?>" onclick="submit_cat()"/>
    </p>


    <div id="item" style="display: none; padding: 50px">
        <p style="padding: 10px">Enter Category Items</p>

    <p>
        <?php if(isset($result)){ $k = 0;
            foreach($result['cat_item'] as $results){
               // foreach($results as $new_results){
               $k = $k+1;
            ?>
        <br/>
        
        <input type="text" name="item<?php echo $k?>" value=" <?php echo $results['item_name']?>" id="item<?php echo $k?>"/>
    <p id="cancel<?php echo $k;?>" onclick="delete_row(<?php echo $k?>)">X</p>
        <?php }?>
        <input type="hidden" id="hidden" value="<?php echo $k?>">
        <?php    } else{ ?>
        <input type="text" name="item1" placeholder="Enter category name" id="item1"/>
        <p id="cancel1" onclick="delete_row(1)">X</p>
        <?php } ?>
    </p>
    <p>
        <input type="button" value="Add" id="add">
        <input type="submit" value="<?php if(isset($result)) echo 'Update'; else echo 'Create';?>" id="submit"/>
    </p>
    </div>
</form>
    

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
