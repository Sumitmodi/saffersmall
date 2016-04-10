
  <div class="right-section">
    <div class="right-top"></div>
    <div class="right-header dashboard">
      <h2>
          <i class="fa fa-folder-open"></i>
          <?php echo isset($response['message']) ? $response['message']  : 'SFI Members list';?>
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
                	<th>Address</th>
                	<th>Account Status</th>
                        <th>Link</th>
                	<th>Register/Block</th>
                        <th>View Ads</th>
                    </tr>
                </thead>
		<?php foreach($result as $data){
            ?> 
                <tbody>
                    <tr>
                        <td><?php echo $i; ?></td>
                   	<td><?php echo $data['business_name'];?></td> 
                  	<td><?php echo $data['address'];?></td> 
                  	<td>
                            <?php if($data['status'] == 'A') echo 'Active';
                            elseif($data['status'] == 'B') echo 'Blocked';
                            else echo 'Waiting';
                        ?></td> 
                        <td>
                            <a class="" href="#"><?php echo $data['profile_link'];?></a>
                        </td>
                  	<?php if($data['status'] == 'A') {?>
                        <td>
                            <a href="<?php echo base_url();?>admin/sfi_control_business/?target=active&action=inactive_user&id=<?php echo $data['sno'];?>" class="btn btn-xs btn-danger">Inactive</a>
                            <a href="<?php echo base_url();?>admin/sfi_control_business/?target=active&action=block_user&id=<?php echo $data['sno'];?>" class="btn btn-xs btn-danger">Block</a>
                        </td>
                            <?php } 
                            else {
                            ?>
                         
                        <td>
                            <a class="btn btn-xs btn-success" href="<?php echo base_url();?>admin/sfi_control_business/?target=active&action=active_user&id=<?php echo $data['sno'];?>">Approve</a>
                            <a href="<?php echo base_url();?>admin/sfi_control_business/?target=active&action=block_user&id=<?php echo $data['sno'];?>" class="btn btn-xs btn-danger">Block</a>
                        </td>
                            <?php }?>
                         
                   	<td> 
                            <a href="<?php echo base_url();?>admin/control_business/?target=active&action=user_ads&id=<?php echo $data['sno'];?>" class="btn btn-xs btn-danger">View Ads</a>
                        </td> 
                    </tr>
                    
                </tbody>
                <?php  $i = $i+1; } ?>
            </table>
        </div>
    </div>
        <!--<div class="pagination-outer">
            <ul class="pagination">
              <li><a href="#">&laquo;</a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">4</a></li>
              <li><a href="#">5</a></li>
              <li><a href="#">&raquo;</a></li>
            </ul>
        </div>-->
       <?php }
        else {
        ?>
        <div class="col-lg-9 col-md-9">
            <p>There are not any members in the list.</p>
        </div>    
        <?php } ?>
    
  </div>
</section>