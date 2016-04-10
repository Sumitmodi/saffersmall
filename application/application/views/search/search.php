<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : search.php
 * 
 *   Project : saffersmall
 */

/*
 *   <Saffersmall :: Online Ads and Marketing Directory.>
 *   Copyright (C) <2014>  <Sandeep Giri>

 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.

 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.

 *   You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.

 *   This program comes with ABSOLUTELY NO WARRANTY.
 *   This is free software, and you are welcome to redistribute it only if you 
 *   get permissions from the author or the distributor of this code.
 * 
 *   However do not expect any help or support from the author.
 */
?>
<section class="search-section1">
    <div class="container content-wrap">

        <section>
            <?php
            if (isset($nores))
            {
                ?> 
                                <p>Sorry we could not find anything related.<!-- to <?php $this->input->get('query'); ?>.--></p>
        </div>
    </section>        
    <?php
    return;
}
?>
<style type="text/css">
    div.thumb-wrap img{
        height: auto;
        max-height: 150px;
        width: 100%;
    }
</style>
<p>Found <?php echo $total; ?> results in <?php echo number_format((float) $time, 4); ?> secs.</p>
<p>Showing <?php echo $from; ?> - <?php echo $to; ?> of <?php echo $total; ?> results.</p>
</section>
<div class="search-form">
    <form class="form-inline" role="form">
        <div class="form-group">
            <label for="exampleInputEmail2"><i class="fa fa-sort"></i> Sort by</label>
            <select class="form-control">
                <option>Newest items</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail2"><i class="fa fa-eye"></i> View</label>
            <select class="form-control" onchange ="location = this.options[this.selectedIndex].value;">
                <option>Goto Page</option>
                <?php
                for ($i = 1; $i <= $pages; $i++)
                {
                    ?> 
                    <option value="<?php echo $url . '&_=' . $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
            </select>
        </div>
    </form>
    <a href="#"><img src="<?php echo base_url(); ?>assets/img/ads.png" alt="" /></a> 
</div>
<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8">
        <div class="content-wrap clearfix">
            <div class="row">

                <?php
                $social = array();
                foreach ($result as $r)
                {
                    $r = (object) $r;

                    $extra = isset($r->extra) ? $r->extra : new stdClass();

                    $feats = isset($r->feats) ? $r->feats : array();

                    $extras = array();

                    foreach ($feats as $f)
                    {
                        $f = (object) $f;
                        if ($f->list_name == 'facebook' ||
                                $f->list_name == 'google' ||
                                $f->list_name == 'youtube' ||
                                $f->list_name == 'pininterest' ||
                                $f->list_name == 'twitter')
                        {
                            $extras[$f->list_name] = $f->list_value;
                        }
                    }
                    $loc = !empty($r->user->address) ? ($r->user->address . ',' . $r->user->country) : ($r->user->country);

                    $link = base_url() . 'ad/' . $r->user->username . '/' . str_replace(' ', '-', strtolower($r->name));

                    $img = explode(',', $r->images);

                    $img = base_url() . 'assets/uploads/products/images/' . $img[rand(0, count($img) - 1)];
                    ?>

                    <div class="box-wrap <?php isset($extra->is_highlight) ? 'hlted' : NULL; ?> clearfix">
                        <?php
                        if (isset($extra->is_urgent) && @$extra->is_urgent == 1)
                        {
                            ?>
                            <div class="ribbon-wrapper-green">
                                <div class="ribbon-green">Urgent</div>                                
                            </div>
                        <?php } ?>
                        <div class="col-lg-4 col-md-4">
                            <div class="thumb-wrap">
                                <a href="<?php echo $link; ?>"> 
                                    <img src="<?php echo $img; ?>" /> 
                                </a>
                                <div class="social-icon">
                                    <ul>
                                        <?php
                                        if (in_array('facebook', $extras))
                                        {
                                            ?>
                                            <li> 
                                                <a href="<?php $extras['facebook']; ?>"><i class="fa fa-facebook-square"></i></a> 
                                            </li>
                                        <?php } ?>
                                        <?php
                                        if (in_array('flicker', $extras))
                                        {
                                            ?>
                                            <li> 
                                                <a href="<?php $extras['flicker']; ?>"><i class="fa fa-flicker"></i></a> 
                                            </li>
                                        <?php } ?>
                                        <?php
                                        if (in_array('linkedin', $extras))
                                        {
                                            ?>
                                            <li> 
                                                <a href="<?php $extras['linkedin']; ?>"><i class="fa fa-linkedin-square"></i></a> 
                                            </li>
                                        <?php } ?>
                                        <?php
                                        if (in_array('twitter', $extras))
                                        {
                                            ?>
                                            <li> 
                                                <a href="<?php $extras['twitter']; ?>"><i class="fa fa-twitter-square"></i></a> 
                                            </li>
                                        <?php } ?>
                                        <?php
                                        if (in_array('google', $extras))
                                        {
                                            ?>
                                            <li> 
                                                <a href="<?php $extras['google']; ?>"><i class="fa fa-google-plus-square"></i></a> 
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8">
                            <div class="price-wrap">
                                <p> &dollar;<?php echo $r->price; ?></p>
                                <br />
                                <em><?php echo formatTime($r->date_added); ?></em> </div>
                            <h3><a href="<?php echo $link; ?>"><?php echo ucwords($r->name); ?></a></h3>
                            <div class="other-info"> 
                                <i class="fa fa-map-marker"></i> <em><?php echo $loc; ?>.</em> &nbsp;&nbsp;&nbsp;   <i class="fa fa-eye"></i> <em><?php echo $r->views; ?> Views</em> </div>
                            <p><?php echo implode('.', getArray(explode('.', strip_tags($r->description)), 0, 2)); ?>.</p>
                            <a href="<?php echo $link; ?>" class="btn btn-primary btn-sm">Details</a>
                            <!--<a href="#" class="btn btn-primary btn-sm">Add to Cart <i class="fa fa-shopping-cart"></i></a>-->

                            <!--<br />-->
                        </div>
                    </div>

                <?php } ?>



                <div class="pagination-outer">
                    <ul class="pagination">
                        <li><a href="<?php echo $url . '&_=' . $prevpage; ?>">&laquo;</a></li>
                        <?php
                        for ($i = 1; $i <= $pages; $i++)
                        {
                            ?> 
                            <li>
                                <a href="<?php echo $url . '&_=' . $i; ?>" title="Page <?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php } ?>
                        <li><a href="<?php echo $url . '&_=' . $nextpage; ?>">&raquo;</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="box-wrapper">
            <div class="row">
                <?php
                if (isset($sidetop))
                {
                    foreach ($sidetop as $s)
                    {
                        $link = base_url() . 'ad/' . $r->user . '/' . str_replace(' ', '-', strtolower($s->name));
                        ?>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <a href="<?php echo $link;?>">
                                <img src="<?php echo base_url(); ?>assets/img/2014-10-23_184251.png" alt="" />
                            </a>
                        </div>
                        <?php
                    }
                    ?> 
                <?php
                } else
                { //just for some days. will be removed as site goes live or progresses
                    ?> 
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <img src="<?php echo base_url(); ?>assets/img/2014-10-23_184251.png" alt="" />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <img src="<?php echo base_url(); ?>assets/img/2014-10-23_184251.png" alt="" />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <img src="<?php echo base_url(); ?>assets/img/2014-10-23_184251.png" alt="" />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <img src="<?php echo base_url(); ?>assets/img/2014-10-23_184251.png" alt="" />
                    </div>
<?php } ?>
            </div>
        </div>
        <div class="box-wrapper">
            <!--<h3></h3>-->
            <div class="recent">
                <ul>
                    <?php foreach($catads as $cat)
                        { 
                        $search = base_url().'search?cat='.$cat['category']->category_name;
                    ?> 
                    <li>
                        <a href="<?php echo $search;?>"><?php echo ucwords($cat['category']->category_name);?></a>
                        <?php if(count($cat['ads']) > 0 ){
                        ?>
                        <ul>
                        <?php
                            foreach($cat['ads'] as $ad){
                                $url = base_url().'ad/'.$ad->user.'/'.str_replace(' ','-',strtolower($ad->name));
                        ?>
                            <li>
                                <a href="<?php echo $url;?>"><?php echo ucwords($ad->name);?></a>
                            </li>
                        <?php
                            }
                        ?>
                        </ul>    
                        <?php
                        }?>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="box-wrapper">
            
                <?php
                if (isset($sidebot))
                {
                    foreach ($sidebot as $s)
                    {
                        $link = base_url() . 'ad/' . $r->user . '/' . str_replace(' ', '-', strtolower($s->name));
                        ?>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <a href="<?php echo $link;?>">
                                <img src="<?php echo base_url(); ?>assets/uploads/products/images/"<?php echo $s->image;?> alt="" />
                            </a>
                        </div>
                        <?php
                    }
                    ?> 
                <?php
                } else
                { //just for some days. will be removed as site goes live or progresses
                    ?> 
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <img src="<?php echo base_url(); ?>assets/img/2014-10-23_184251.png" alt="" />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <img src="<?php echo base_url(); ?>assets/img/2014-10-23_184251.png" alt="" />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <img src="<?php echo base_url(); ?>assets/img/2014-10-23_184251.png" alt="" />
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <img src="<?php echo base_url(); ?>assets/img/2014-10-23_184251.png" alt="" />
                    </div>
<?php } ?>
        </div>
    </div>
</div>
</div>
</div>
</section>
<!--/solution-section--> 
