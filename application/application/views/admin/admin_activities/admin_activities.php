  <div class="right-section">
    <div class="right-top"></div>
    <div class="right-header dashboard">
      <h2><i class="fa fa-folder-open"></i>Admin Activities
          <div class="choose-ads">  
                  <p class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal1">clear log</p>
              <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">Clear log</h4>
                              </div>
                                <div id="divID"></div>
                                <form name="new" id="new" action="" method="post">
                                    <div class="modal-body"> 
                                        <input type="radio" name="radios" value="day">Clear one day log. <br>
                                        <input type="radio" name="radios" value="week">Clear one week log. <br>
                                        <input type="radio" name="radios" value="month">Clear one month log. <br>
                                        <input type="radio" name="radios" value="all">Clear all log. <br>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" onclick="test();">Submit</button>
                                    </div>
                                </form>
                            </div>
                          </div>
                    </div>
                    
                    <script type="text/javascript">
                    function test(){ //alert("HI");
                        var test = document.getElementsByName('radios');
                            var sizes = test.length;
                            //alert(sizes);
                            for (i=0; i < sizes; i++) {
                                    if (test[i].checked==true) {
                                    //alert(test[i].value + ' you got a value');     
                                    var data = test[i].value;
                                }
                            }
                            if(data != ""){
                            document.forms["new"].submit();
                        }
                        else{
                            var div = document.getElementById('divID');

                            div.innerHTML = div.innerHTML + 'The field should not be empty!';
                        } 
                        
                    }
                    </script>
                
<!--              <form class="form-inline" action="" method="post">
                  <div class="form-group">
                      <select class="form-control" id="log" name="log">
                          <option value="day">Clear one day log</option>
                          <option value="week">Clear one week log</option>
                          <option value="month">Clear one month log</option>
                          <option value="all">Clear all</option>
                </select>
              </div> 
            </form>-->
          </div>
      </h2>
        <script type="text/javascript">
$(document).ready(function(){
    $('select#log').on('change',function() { 
       var cntr = $("#log option:selected").val();
       //alert(cntr);
       this.form.submit();
    });
    //console.log('ffff');
});
</script>

      <div class="down-arrow"></div>
    </div>
    <div class="control-user">
    	<div class="table-responsive">
            <?php 
            //echo count($result);
            if(isset($result)){
                $i = 1;
                ?>
            <table class="table table-striped">
            	<thead>
                    <tr>
                        <th>S. No.</th>
                	<th>Activities</th>
                	<th>Date</th>
                    </tr>
                </thead>
		<?php foreach($result as $data){
            ?> 
                <tbody>
                    <tr>
                        <td><?php echo $i; ?></td>
                   	<td><?php echo $data['activity'];?></td> 
                  	<td><?php echo $data['date_added'];?></td> 
                  	<td>  </td> 
                    </tr>
                    
                </tbody>
                <?php  $i = $i+1; } ?>
            </table>
        </div>
    </div>
        <div class="pagination-outer">
            <ul class="pagination">
              <li><a href="#">&laquo;</a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">4</a></li>
              <li><a href="#">5</a></li>
              <li><a href="#">&raquo;</a></li>
            </ul>
        </div>
       <?php }
        else {
        ?>
        <div class="col-lg-9 col-md-9">
            <p>There are no any waiting ads.</p>
        </div>    
        <?php } ?>
    
  </div>
</section>