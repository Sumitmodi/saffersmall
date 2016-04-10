<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : step3.php
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

<style type="text/css">
    fieldset{
        padding: 15px 0 15px 15px;
        margin: 20px 0 0;
    }
    p.gallery_preview{
        width:100%;
        overflow:hidden;
    }
    img{
        float:left;
        width:100%;
        max-height:350px;
        max-width:350px;
        overfloaw:hidden;
        padding:10px 5px;
        border:1px solid #eee;
        text-align:left;
        margin:5px;
        float:left;
        opacity: 0.7;
    }
    img:hover{
        -webkit-transition: opacity 2s;
        transition: opacity 2s;
        opacity: 1;
        -webkit-transition: opacity 2s;
        transition: opacity 2s;
    }
</style>
<div class="right-top"></div>
<div class="right-header dashboard">
    <h2>
        <i class="fa fa-folder-open"></i>Place Ad 
        <div class="choose-ads">
            <small>Step :: 3</small>
        </div>
    </h2>
    <div class="down-arrow"></div>
</div>

<section class="place-ads">

    <h4><strong><?php if (isset($response['message'])) echo $response['message']; ?></strong></h4>
    <form class="form-horizontal" action="?_=4" method="post" enctype="multipart/form-data">
        <label class="col-lg-12 col-md-12 col-sm-12 control-label" style="text-align: left;">
            <small>Please select at least one image for your product. Images highly attract eyes than text. Add as many images you like.</small>
        </label>
        <div style="clear:both;"></div> 
        <div class="form-group">
            <label class="col-lg-3 col-md-3 col-sm-3  control-label">Product Images</label>
            <div class="col-lg-9 col-md-9 col-sm-9">
                <input type="file" name="images[]" multiple="multiple" class="images">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 col-md-3 col-sm-3  control-label"> Add a video </label>
            <div class="col-lg-9 col-md-9 col-sm-9">
                <input type="file" name="video">
            </div>
        </div>
        <div class="social-links">
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3  control-label"> Video Link  </label>
                <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="icon-fb"><i class="fa fa-youtube-play"></i></div>
                    <input type="text" name='url' placeholder="Add youtube link to your video" class="form-control">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-3 col-md-offset-3 col-lg-9 col-md-9 col-sm-9">
                <input type="submit" value="Next Step">
            </div>
        </div>        
    </form>    
</section>

<section class="place-ads">
    <fieldset>
        <legend id="gallery">Images Will be displayed here</legend>
        <p class="gallery_preview"></p>
    </fieldset>
</section>

<script type="text/javascript">
    function readFile(a) {
        var reader = new FileReader();
        var img = new Image();
        reader.onload = function () {
            var dataURL = reader.result;
            img.src = dataURL;
        };
        reader.readAsDataURL(a);
        return img;
    }
    $(document).ready(function () {
        $('input.images').change(function (e) {
            var img = e.target.files;
            $('legend#gallery').html('Currently selected images');
            $('p.gallery_preview').html('');
            var last;
            $(img).each(function (i) {
                last = readFile(img[i]);
                if (last) {
                    $('p.gallery_preview').append(last);
                }
            });
        });
    });
</script>