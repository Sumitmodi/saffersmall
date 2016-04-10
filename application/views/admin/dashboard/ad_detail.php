<?php //echo '<pre>'; print_r($result);?>
<?php 
        if(isset($result)){
        foreach($result as $data){
            $images = explode(",", $data['item']['images']);
            //print_r($images);
        ?>

<section class="detail-section2">
  <div class="container content-wrap">
    <div class="row">
      <div class="col-lg-8 col-md-8 col-sm-8">
        <div class="social-blog orange">
          <div class="row"><div class="col-lg-6 col-md-6 col-sm-6"><h2><?php echo $data['item']['name'] ;?></h2></div>
          <div class="col-lg-6 col-md-6 col-sm-6">
              
          <script type="text/javascript">
              $(document).ready(function(){
                $('#fav').click(function(){
                    var url = "<?php echo base_url().'ads/favourites/'.$data['item']['sno']; ?>";
                    //alert(url);
                $.post(url,function(data){
                    if(data === false)
                        alert('This ad has been added to your favourite list!');
                    else alert('This ad has been already added to your favourite list!')
                });
                });
                  
              });
          </script>
          <?php 
          $business_id = $this->session->userdata('bid');
          if($business_id!=""){ ?>
          <div class="save" id="fav"><i class="fa fa-star"></i></div>
          <?php } else{ ?>
          <div class="save"><a href="<?php echo base_url().'dashboard'?>"><i class="fa fa-star"></i></a></div>
          <?php } ?>
          </div>
          </div>
          <div class="image-wrapper">
            <ul class="pgwSlideshow">
                <?php for($i=0;$i<count($images);$i++){
                    ?>
              <li><img src='<?php echo base_url();?>assets/uploads/products/images/<?php echo $images[$i];?>'></li>
                <?php } ?>
              
            </ul>
          </div>
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                $(document).ready(function() {
                        var pgwSlideshow = $('.pgwSlideshow').pgwSlideshow();
                        pgwSlideshow.startSlide();
                });
                });

            </script>

          <div class="clearfix"></div>
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
              
                <div class="category clearfix">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 left">
                      <p>Product Name</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 right">
                      <p><?php echo $data['item']['name'] ;?></p>
                    </div>
                  </div>
                </div> 
              
              
                <div class="category clearfix">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 left">
                      <p>Price</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 right">
                      <p><?php echo $data['item']['price'] ;?></p>
                    </div>
                  </div>
                </div> 
              
              
                <div class="category clearfix">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 left">
                      <p>Country</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 right">
                      <p><?php echo $data['item']['country'] ;?></p>
                    </div>
                  </div>
                </div> 
              
              
                <div class="category clearfix">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 left">
                      <p>City</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 right">
                      <p><?php echo $data['item']['city'] ;?></p>
                    </div>
                  </div>
                </div> 
              
            </div>
              <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="category-list">
                <div class="category clearfix">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 left">
                      <p>State</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 right">
                      <p> <?php echo $data['item']['location'] ;?></p>
                    </div>
                  </div>
                </div>
                <div class="category clearfix">
                  <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 left">
                      <p>Posted</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 right">
                      <p> <?php echo $data['item']['date_added'] ;?></p>
                    </div>
                  </div>
                </div>
                
              </div>
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="social-icon">
                    <ul>
                      <li> <a href="#"><i class="fa fa-facebook-square"></i></a> </li>
                      <li><a href="#"><i class="fa fa-flickr"></i></a></li>
                      <li><a href="#"><i class="fa fa-linkedin-square"></i></a></li>
                      <li><a href="#"><i class="fa fa-twitter-square"></i></a></li>
                      <li><a href="#"><i class="fa fa-google-plus-square"></i></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
              <div class="text-wrap" style="clear: both"> <strong>Description</strong>
              <p><?php echo $data['item']['description'];?></p>
            </div>
              <?php } }?>
                <?php echo '<pre>resultsextra';
                        //print_r($extra_result);?>
            <div class="image clearfix"><h2> Related Ads </h2>
                <?php foreach($extra_result as $extra_results){
                    $extra_images = explode(",", $extra_results['related_ads']['images']);
                    ?>
                <div class="box-wrapp">
                    <div class="box"> <img src="<?php echo base_url();?>assets/uploads/products/images/<?php echo $extra_images[0];?>" alt="">
                        <div class="price-tag"><?php echo $extra_results['related_ads']['price']?></div>
                        <div class="ribbon-wrapper-green">
                            <div class="ribbon-green">
                                <?php foreach ($extra_results['related_extra'] as $extra){
                                    //echo "here";print_r($extra); 
                                }
                                    if($extra_results['related_ads']['price']) ?>Urgent</div>
                        </div>
                        <div class="ribbon-featured-wrapper">
                            <div class="ribbon-featured">Featured</div>
                        </div>
                        <div class="overlay">
                            <div class="detail"><a href="#">Detail</a></div>
                        </div>
                    </div>
                    <p><a href="#">Dorem apsum dolora sbas ait amet, consectetur</a></p>
                    <div class="person">
                     <i class="fa fa-user"></i> Added by John 
                     </div>
                    <span>2 min ago</span>
                </div>
                <?php }?>
            </div>
            <?php 
        if(isset($result)){
        foreach($result as $data){
            $images = explode(",", $data['item']['images']);
            //print_r($images);
        ?>
  
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="box-wrapper">
          <h3>Contact John</h3>
          <div class="tag-wrap clearfix">
            <div class="img-outer"><img src="<?php echo base_url();?>assets/img/img8.jpg" alt=""></div>
            <div class="details">
              <h4><i class="fa fa-phone"></i><?php echo $data['post_man'][0]['telephone']?></h4>
              <em><?php echo $data['post_man'][0]['address']?></em>
              <p><a href="<?php echo base_url()?>dashboard/?target=active&action=user_ads&id=<?php echo $data['post_man'][0]['sno']?>">See all ads by John</a></p>
            </div>
          </div>
        </div>
        <div class="box-wrapper">
          <h3>Recent Post Ads</h3>
          <div class="recent">
            <ul>
              <li><a href="#">Lorem ipsum dolor sit ametr adipiscing elit. </a></li>
              <li><a href="#">Fusce eget lobortis lorem!</a>
              <ul>
              <li><a href="#">Lorem ipsum dolor sit ametr adipiscing elit. </a></li>
              <li><a href="#">Fusce eget lobortis lorem!</a></li>
              <li><a href="#">A vulputate justo sed vitae consectetur lacus. </a></li>
              <li><a href="#">Cras placerat suscipit elit vel ullamcorper turpis placerat.</a></li>
            </ul></li>
              <li><a href="#">A vulputate justo sed vitae consectetur lacus. </a></li>
              <li><a href="#">Cras placerat suscipit elit vel ullamcorper turpis placerat.</a></li>
            </ul>
          </div>
        </div>
<div class="box-wrapper">
               	<img src="img/2014-10-23_184251.png" alt="">

        </div>
<div class="box-wrapper">
              	<img src="img/2014-10-23_184749.png" alt="">

        </div>
      </div>
    </div>
  </div>
</section>
        <?php } }?>
