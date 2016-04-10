
<section class="blog-section1">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <?php
                if (isset($blogs) && is_array($blogs)) {

                    foreach ($blogs as $k=>$blog) {
                        ?>
                        <h2><?php echo $blog['name']; ?></h2>
                        <div class="image-wrapper"><a href="#"> <img src="<?php echo base_url(); ?>assets/uploads/blogs/<?php echo $blog['image']; ?>"></a> <span><a href="#"><i class="fa fa-search-plus"></i></a></span> </div>
                        <div class="text-wrap">
                            <p>
                                <?php
                                $string = strip_tags($blog['content']);

                                if (strlen($string) > 500) {

                                    // truncate string
                                    $stringCut = substr($string, 0, 500);

                                    // make sure it ends in a word so assassinate doesn't become ass...
                                    $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '... <div class="more"><a href="'.base_url().'blog/blog_detail/'.$blog['sno'].'">Read More <i class="fa fa-angle-double-right"></i></a></div>';
                                }
                                echo $string;
                                ?>

                            <div class="post_meta">
                                <div class="blocks_wrap">
                                    <!--<div class="meta_block">
                                        <span>Category</span>
                                        Uncategorized				
                                    </div>
                                    <div class="meta_block">	
                                        <span>Author</span>
                                        <a href="#" title="Posts by Jake Caputo" rel="author">Jake Caputo</a>	
                                    </div>-->
                                    <div class="meta_block">	
                                        <span>Comments</span>
                                        <a href="<?php echo base_url()?>blog/blog_detail/<?php echo $blog['sno'];?>" class="comments-link" title="Comment on Photoshoots Abroad">
                                            <?php if(isset($comment_count[$k]) ) echo $comment_count[$k]; else echo 0?> Comments
                                        </a>	
                                    </div>
                                    <div class="meta_block">	
                                        <span>Post Date</span>
                                            <?php echo $blog['date_added']; ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <hr>

                        </div>
                        <?php }
                    }
                    ?>

            </div>
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
                                          <a href="<?php echo base_url();?>blog/blog_detail/<?php echo $post['sno'];?>"> <li><?php echo $post['name']; ?> </li></a><br>
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

<!--/solution-section--> 

