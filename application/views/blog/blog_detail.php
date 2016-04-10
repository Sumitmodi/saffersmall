

<section class="blog-section1">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <h2><?php echo $blogs->name; ?></h2>
                <div class="post_meta">
                    <div class="blocks_wrap">

                        <div class="meta_block">	
                            <span>Comments</span>
                            <a href="#" class="comments-link" title="Comment on Photoshoots Abroad"><?php if (isset($comment_count)) echo $comment_count;
else echo 0; ?> Comments</a>				</div>
                        <div class="meta_block">	
                            <span>Post Date</span>
<?php echo $blogs->date_added; ?>			
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="image-wrapper"><a href="#"> <img src="<?php echo base_url(); ?>assets/uploads/blogs/<?php echo $blogs->image; ?>"></a></div>
                <div class="text-wrap">


                    <p><?php echo $blogs->content; ?></p>

                    <hr>

                </div>

                <div class="tag-wrap"><h3>Comments</h3>
                    <?php
                    //echo'<pre>';                    print_r($comments);
                    $i = 0;
                    if (isset($comments) && is_array($comments)) {
                        foreach ($comments as $comment) {
                            $i = $i + 1;
                            if ($i % 2 == 0)
                                $class = 'post-box grey-box';
                            else
                                $class = 'post-box white-box'
                                ?>
                            <div class="<?php echo $class; ?>"> 
                                <div class="row">
                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                       <!-- <div class="thumb-wrap"> <img src="img/02cdeec360274d7d9f1aa85761f95dc8.jpeg" /> </div>-->
                                    </div>

                                    <div class="col-lg-10 col-md-10 col-sm-10"> <h5><?php echo $comment['date_added']; ?>| <span><?php echo $comment['blogger']; ?></span></h5>
                                        <p><?php echo $comment['comment']; ?></p></div></div>
                            </div>
                            <?php
                        }
                    }
                    ?>


                </div>

                <?php if ($this->session->userdata('login_type') != false){ ?>
                <div class="detail-form">
                    <form class="form" role="form" action="" method="post">
                        <div class="form-group">
                            <textarea class="form-control" rows="4" name="comment" placeholder="Comments..."></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Post">
                        </div>
                    </form>
                </div>
                
                <?php } ?>

            </div>

<?php //echo '<pre>';            print_r($blog_archive);   ?>

            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="box-wrapper">
                    <h3>Recent Blogs</h3>
                    <div class="recent">
                        <ul>
<?php foreach ($blog_archive as $year => $months): ?>
                                <li><?php echo $year; ?></li>
                                <ul>
    <?php foreach ($months as $month => $posts): ?>
                                        <li ><?php echo $month; ?>
                                            <ol>
                                                <?php foreach ($posts as $post): ?>
                                                    <a href="<?php echo base_url(); ?>blog/blog_detail/<?php echo $post['sno']; ?>"> <li><?php echo $post['name']; ?> </li></a><br>
        <?php endforeach; ?>
                                            </ol>
                                        </li>
                                <?php endforeach; ?>
                                </ul>
<?php endforeach; ?>

                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
