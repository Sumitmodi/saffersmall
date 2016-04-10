<?php //echo '<pre>'; print_r($result);?>
<section class="body-part clearfix">
  <div class="right-section">
    <div class="right-top"></div>
    <div class="right-header dashboard">
      <h2><i class="fa fa-folder-open"></i>User List
          <div class="choose-ads">            <form role="form" class="form-inline">
              <div class="form-group">
                <select class="form-control">
                  <option>Active Ads</option>
                  <option>Inactive Ads</option>
                  <option>Awaiting Activation</option>
                  <option>Proecessing</option>
                </select>
              </div>
            </form>
          </div>
      </h2>
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
                	<th>Name</th>
                        <th>Added Date</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
		<?php foreach($result as $data){
            ?> 
                <tbody>
                    <tr>
                        <td><?php echo $i; ?></td>
                   	<td><?php echo $data['category_name'];?></td> 
                        <td><?php echo $data['date_added'];?></td> 
                  	<td>
                            <a class="btn btn-xs btn-success" href="<?php echo base_url();?>admin/category/?target=edit&id=<?php echo $data['sno'];?>">Edit</a>
                        </td>
                        <td>
                            <a href="<?php echo base_url();?>admin/category/?target=delete&id=<?php echo $data['sno'];?>" class="btn btn-xs btn-danger">Delete</a></td> 
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