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
                                <th>Username</th>
                                <th>Address</th>
                                <th>Privilage</th>
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
                                    <td><?php echo ucwords($data['name']); ?></td> 
                                    <td><?php echo $data['username']; ?></td> 
                                    <td><?php echo empty($data['email']) ? '-' : $data['email']; ?></td>
                                    <td>
                                        <?php if (strtoupper($data['previlages']) == 'A')
                                        {
                                            echo 'Active';
                                        } elseif (strtoupper($data['previlages']) == 'B')
                                        {
                                            echo 'Blocked';
                                        }
                                        ?>
                                    </td>
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
                <p>No Previlaged admins.</p>
            </div>    
        <?php } ?>

    </div>
</section>