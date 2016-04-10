    <div class="right-section">
        <div class="right-top"></div>
        <div class="right-header dashboard">
            <h2><i class="fa fa-folder-open"></i>
                <?php echo isset($response['message']) ? $response['message'] : NULL; ?>
            </h2>
            <div class="down-arrow"></div>
        </div>
        <div class="control-user">
            <div class="table-responsive">
                <?php
                if (isset($result))
                {
                    $i = 1;
                    ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>S. No.</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Account Status</th>
                                <th>Activate/Block</th>    
                                <th>Registered</th>                              
                            </tr>
                        </thead>
                        <?php
                        foreach ($result as $data)
                        {
                            ?> 
                            <tbody>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo ucwords($data['business_name']); ?></td> 
                                    <td><?php echo empty($data['address']) ? '-' : $data['address']; ?></td> 
                                    <td>
                                        <?php
                                        if (strtoupper($data['status']) == 'A')
                                        {
                                            echo 'Active';
                                        } elseif (strtoupper($data['status']) == 'B')
                                        {
                                            echo 'Blocked';
                                        } else
                                        {
                                            echo 'Waiting';
                                        }
                                        ?></td> 
                                    <?php
                                    if ($data['status'] == 'A')
                                    {
                                        ?>
                                        <td>
                                            <a href="<?php echo base_url(); ?>admin/control_business/?target=active&action=inactive_user&id=<?php echo $data['sno']; ?>" class="btn btn-xs btn-warning">Inactivate</a>

                                            <a href="<?php echo base_url(); ?>admin/control_business/?target=active&action=block_user&id=<?php echo $data['sno']; ?>" class="btn btn-xs btn-danger">Block</a>
                                            <a href="<?php echo base_url(); ?>admin/control_business/?target=active&action=user_ads&id=<?php echo $data['sno']; ?>" class="btn btn-xs btn-success">View Ads</a>
                                        </td>
                                        <?php
                                    } else
                                    {
                                        ?>
                                        <td>
                                            <a class="btn btn-xs btn-success" href="<?php echo base_url(); ?>admin/control_business/?target=active&action=active_user&id=<?php echo $data['sno']; ?>">Approve</a>
                                            <a href="<?php echo base_url(); ?>admin/control_business/?target=active&action=block_user&id=<?php echo $data['sno']; ?>" class="btn btn-xs btn-danger">Block</a>
                                            <a href="<?php echo base_url(); ?>admin/control_business/?target=active&action=user_ads&id=<?php echo $data['sno']; ?>" class="btn btn-xs btn-success">View Ads</a>
                                        </td>
                                    <?php } ?>

                                    <td> 
                                        <?php echo formatTime($data['date_added']); ?> (<?php echo date('Y/m/d', strtotime($data['date_added'])); ?>)
                                    </td> 
                                </tr>

                            </tbody>
                            <?php
                            $i = $i + 1;
                        }
                        ?>
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
            <?php
        } else
        {
            ?>
            <div class="col-lg-9 col-md-9">
                <p>No businesses in this category.</p>
            </div>    
        <?php } ?>

    </div>
</section>