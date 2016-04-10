    <div class="right-section">
        <div class="right-top">
        </div>
        <div class="right-header dashboard">
            <h2>
                <i class="fa fa-folder-open"></i>
                <span>
                    <?php echo isset($response['message']) ? $response['message'] : NULL; ?></span>
                <div class="choose-ads">            
                    <form role="form" class="form-inline">
                        <div class="form-group">
                            <select class="form-control">
                                <option value="">Select ad status</option>
                                <option value="<?php echo base_url(); ?>admin/dashboard">Awaiting Activation</option>
                                <option value="<?php echo base_url(); ?>admin/dashboard/active_ads">Active Ads</option>
                                <option value="<?php echo base_url(); ?>admin/dashboard/expire_ads">Expired Ads</option>
                                <option value="<?php echo base_url(); ?>admin/dashboard/block_ads">Disapproved Ads</option>
                            </select>
                        </div>
                    </form>
                </div>
            </h2>
            <div class="down-arrow"></div>
        </div>

        <div class="my-ads">
            <?php
            if (isset($result))
            {
                foreach ($result as $data)
                {
                    
                    $img = explode(',',$data['item']['images']);
                    $img = base_url().'assets/uploads/products/images/'.$img[rand(0,count($img)-1)];
                    ?>
                    <div class="my-ad">
                        <div class="row">
                            <div class="col-lg-3 col-md-3">
                                <div class="ad-img">
                                    <div class="img-overlay"></div>
                                    <a href="<?php echo base_url(); ?>ads/ad_detail/<?php echo $data['item']['sno']; ?>">
                                        <img src="<?php echo $img?>" alt=""></a>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-9">
                                <?php
                                //foreach($data['lists'] as $new_list){
                                ?>
                                <h3>    
                                    <a href="<?php echo base_url(); ?>ads/ad_detail/<?php echo $data['item']['sno']; ?>">
                                        <?php echo $data['item']['name']; ?></a>
                                </h3>

                                <span><strong>Post Date</strong> : 
                                    <em><?php echo $data['item']['date_added']; ?></em>   
                                </span>	
                                <span><strong>Ads status</strong> : 
                                    <em><?php
                                        if ($data['item']['status'] == 'W')
                                            echo 'Awaiting';

                                        //echo $data['item']['sno'];
                                        ?></em>   
                                </span>
                                <span><strong>Post By <i class="fa fa-user"></i> </strong> : 
                                    <em><?php
                                        if (!empty($data['post_man']))
                                            foreach (@$data['post_man'] as $business)
                                            {
                                                echo @$business['business_name'];
                                            }
                                        ?></em>   
                                </span>
                                <p>
                                    <?php echo $data['item']['description']; ?>
                                </p>
                                <?php
                                if ($data['item']['status'] == 'W')
                                {
                                    ?>
                                    <a href="<?php echo base_url(); ?>admin/dashboard/?target=active&action=active_ad&id=<?php echo $data['item']['sno']; ?>" class="btn btn-danger btn-sm">Active</a>
                                    <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal1">Disapprove</a>
                                    <?php
                                }
                                if ($data['item']['status'] == 'A')
                                {
                                    ?>
                                    <a href="<?php echo base_url(); ?>admin/dashboard/?target=active&action=inactive_ad&id=<?php echo $data['item']['sno']; ?>" class="btn btn-warning btn-sm">Inactive</a>
                                    <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal1">Disapprove</a>
                                    <?php
                                }
                                if ($data['item']['status'] == 'D')
                                {
                                    ?>
                                    <a href="<?php echo base_url(); ?>admin/dashboard/?target=active&action=active_ad&id=<?php echo $data['item']['sno']; ?>"class="btn btn-danger btn-sm">Active</a>

                                <?php } ?>

                                <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Suggestion</h4>
                                            </div>
                                            <div id="divID"></div>
                                            <form name="new" id="new" action="<?php echo base_url(); ?>admin/dashboard/?target=active&action=disapprove_ad&id=<?php echo $data['item']['sno']; ?>" method="post">
                                                <div class="modal-body"> 
                                                    <textarea name="suggestion" id="suggestion" style="width: 300px; height: 150px"></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" onclick="test();">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <script type="text/javascript">
                                    function test() {
                                        var data1 = document.getElementById("suggestion").value;
                                        if (data1 != "") {
                                            document.forms["new"].submit();
                                        }
                                        else {
                                            var div = document.getElementById('divID');

                                            div.innerHTML = div.innerHTML + 'The field should not be empty!';
                                        }

                                    }
                                </script>
                            </div>
                        </div>
                    </div>


                <?php } ?>

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
                    <h3>No more Awaiting Ads</h3>
                </div>    
            <?php } ?>


        </div>


    </div>

    <div id="popupContact" style="display: none">
        <!-- Contact Us Form -->

    </div>

</section>
<script type='text/javascript'>
    $(document).ready(function () {
        $('select').on('change', function () {
            var val = $(this).val();

            if (val != '') {
                window.location.href = val;
            }
        })
    })
</script>