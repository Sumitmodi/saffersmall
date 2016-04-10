  <div class="right-section">
    <div class="right-top"></div>
    <div class="right-header dashboard">
      <h2><i class="fa fa-users"></i>Users Details
          <div class="choose-ads">            <form role="form" class="form-inline">
              <div class="form-group">
                <select class="form-control">
                  <option>Active Business</option>
                  <option>Awaiting Activation</option>
                  <option>Disabled</option>
                </select>
              </div>
            </form>
        </div>
      </h2>
      <div class="down-arrow"></div>
    </div>
    
       <div class="control-user">
    	<div class="table-responsive">
            <?php if(isset($result)){
                $i = 1;?>
            <table class="table table-striped">
            	<thead>
                    <tr>
                        <th>S. No.</th>
                	<th>Name</th>
                	<th>Address</th>
                	<th>Account Status</th>
                	<th>Register/Block</th>
                    </tr>
                </thead>
		 <?php 
            //echo count($result);
            
                foreach($result as $data){
            ?>
                <tbody>
                    <tr>
                        <td><?php echo $i; ?></td>
                   	<td><?php echo $data['name'];?></td> 
                  	<td><?php echo $data['email'];?></td> 
                  	<td>
                            <?php if($data['status'] == 'A') echo 'Active';
                            elseif($data['status'] == 'B') echo 'Blocked';
                            else echo 'Waiting';
                        ?></td> 
                  	<?php if($data['status'] == 'A') {?>
                        <td>
                            <a href="<?php echo base_url();?>admin/control_user/?target=active&action=inactive_user&id=<?php echo $data['sno'];?>" class="btn btn-xs btn-danger">Inactive</a>
                        </td>
                        <td>
                            <a href="<?php echo base_url();?>admin/control_user/?target=active&action=block_user&id=<?php echo $data['sno'];?>" class="btn btn-xs btn-danger">Block</a>
                        </td>
                            <?php } 
                            else {
                            ?>
                        <td>
                            <a class="btn btn-xs btn-success" href="<?php echo base_url();?>admin/control_user/?target=active&action=active_user&id=<?php echo $data['sno'];?>">Approve</a>
                        </td>
                        <td>
                            <a href="<?php echo base_url();?>admin/control_user/?target=active&action=block_user&id=<?php echo $data['sno'];?>" class="btn btn-xs btn-danger">Block</a>
                        </td>
                            <?php }?>
                         
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
            <p>There are no any users.</p>
        </div>    
        <?php } ?>
  
</section>