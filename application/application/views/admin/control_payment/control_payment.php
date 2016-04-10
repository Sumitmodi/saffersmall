  <div class="right-section">
    <div class="right-top"></div>
    <div class="right-header dashboard">
      <h2><i class="fa fa-folder-open"></i>
          <?php echo isset($response['message']) ? $response['message'] : NULL;?>
      </h2>
      <div class="down-arrow"></div>
    </div>
    <?php if(isset($result)){
                $i = 1;?>
    <div class="control-user">
    	<div class="table-responsive">
            
            <table class="table table-striped">
            	<thead>
                    <tr>
                        <th>S. No.</th>
                	<th>Payment By</th>
                	<th>Address</th>
                	<th>Paid Date</th>
                	<th>Payment Type</th>
                        <th>Amount Received</th>
                    </tr>
                </thead>
	
                <?php 
            //echo count($result);
            
                foreach($result as $data){
            ?>
                <tbody>
                    <tr>
                        <td><?php echo $i; ?></td>
                        
                   	<td><?php echo $data['lists'][0]['business_name'];?></td> 
                  	<td><?php echo $data['lists'][0]['address'];?></td> 
                  	<td><?php echo $data['tran']['pay_time'];?></td> 
                  	<td><?php echo $data['tran']['payment_method']; ?></td>
                        <td><?php echo $data['tran']['received_amount']; ?></td>
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
            <p>Data have not been recorded for <?php echo $title;?>.</p>
        </div>    
        <?php } ?>
    
  </div>
</section>