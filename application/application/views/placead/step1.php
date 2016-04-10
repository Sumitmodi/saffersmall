<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : part1.php
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

<div class="right-top"></div>
<div class="right-header dashboard">
    <h2><i class="fa fa-folder-open"></i>Place Ad 
        <div class="choose-ads">
            <small>Step :: 1</small>
        </div>
    </h2>
    <div class="down-arrow"></div>
</div>
<script type="text/javascript">
    var items = <?php echo $items; ?>;
    var cats = <?php echo $cats; ?>;
    $(document).ready(function () {
        $('select[name=category]').on('change', function () {
            var val = $(this).val();
            $('div.more-feats').html('');
            for (cat in items) {
                var cur = items[cat];
                if (cur.cat.toLowerCase() === val.toLowerCase()) {
                    if (cur.lists.length == 0) {
                        return;
                    }
                    $('div.more-feats').html('<div class="row"><div class="col-lg-offset-3 col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9"><h4>More Features of your product</h4></div></div>');

                    for (i = 0; i < cur.lists.length; i++) {
                        inp = '<div class="form-group"><label class="col-lg-3 col-md-3 col-sm-3 control-label">';
                        inp = inp + cur.lists[i].replace(/\b[a-z]/g, function (letter) {
                            return letter.toUpperCase()
                        }) + '</label><div class="col-lg-9 col-md-9 col-sm-9 col-sm-9">';
                        inp = inp + '<input type="text" name="' + cur.lists[i].toLowerCase() + '" class="form-control"';
                        inp = inp + 'placeholder="' + cur.lists[i].replace(/\b[a-z]/g, function (letter) {
                            return letter.toUpperCase()
                        }) + '"/><div></div>'
                        //inp = '<li><input type="text" name="' + cur.lists[i].toLowerCase() + '" placeholder="' + cur.lists[i] + '"/></li>';
                        $('div.more-feats').append(inp);
                    }
                }
            }
        });
    });
</script>
<script src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>
<section class="place-ads">
    <h4><strong><?php if (isset($response['message'])) echo ucwords($response['message']); ?></strong></h4>


    <form class="form-horizontal" action="?_=2" method="post">
        <label class="col-lg-9 col-md-9 col-sm-9 control-label" style="text-align: left;">
            <small> Fields marked <span>*</span> are compulsory.</small>
        </label>
        <div style="clear:both;"></div>
        <div class="form-group">
            <label class="col-lg-3 col-md-3 col-sm-3 control-label"> Product Name <span>*</span> </label>
            <div class="col-lg-9 col-md-9 col-sm-9 col-sm-9">
                <input type="text" class="form-control" name="name" placeholder="Product Name" required="required">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 col-md-3 col-sm-3  control-label"> Product Category <span>*</span> </label>
            <div class="col-lg-4 col-md-4 col-sm-9">
                <select class="form-control" required="required" name="category">
                    <option>Select a category</option>
                    <?php
                    $cats = json_decode($cats);
                    foreach ($cats as $c)
                    {
                        ?>
                        <option value="<?php echo strtolower($c); ?>"><?php echo strtoupper($c); ?></option>
<?php } ?>
                </select>
            </div>
        </div>
        <div class="more-feats">

        </div>
        <div class="form-group">
            <label class="col-lg-3 col-md-3 col-sm-3 control-label"> Ads Price <span>*</span></label>
            <div class="col-lg-4 col-md-4 col-sm-9">
                <input type="text" class="form-control" name="price" placeholder="$00" required="required">
            </div>
        </div>
        <?php if($this->session->userdata('is_sfi') == 1) { ?>
        <div class="form-group">
            <label class="col-lg-3 col-md-3 col-sm-3 control-label"> SFI Product link</label>
            <div class="col-lg-4 col-md-4 col-sm-9">
                <input type="text" class="form-control" name="website" placeholder="Your SFI product link">
            </div>
        </div>
        <?php } ?>
        <div class="form-group">
            <label class="col-lg-3 col-md-3 col-sm-3  control-label"> Ads Description </label>
            <div class="col-lg-9 col-md-9 col-sm-9">
                <textarea rows="5" name="description" class="form-control ckeditor" placeholder="Enter detailed description of your product"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-offset-3 col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9">
                <h4>Product Social Links</h4>
            </div>
        </div>
        <div class="social-links">
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3  control-label"> Facebook Link : </label>
                <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="icon-fb"><i class="fa fa-facebook"></i></div>
                    <input type="text" name="facebook" class="form-control social" placeholder="http://facebook.com/">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3  control-label"> Twitter Link : </label>
                <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="icon-fb"><i class="fa fa-twitter"></i></div>
                    <input type="text" name="twitter" class="form-control social" placeholder="http://twitter.com/">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3  control-label"> Google plus Link : </label>
                <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="icon-fb"><i class="fa fa-google-plus"></i></div>
                    <input type="text" name="twitter" class="form-control social" placeholder="http://plus.google.com/">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3  control-label"> Pinterest Link : </label>
                <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="icon-fb"><i class="fa fa-pinterest"></i></div>
                    <input type="text" name="pininterest" class="form-control social" placeholder="http://pinterest.com/">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 col-md-3 col-sm-3  control-label"> Instagram Link : </label>
                <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="icon-fb"><i class="fa fa-instagram"></i></div>
                    <input type="text" name="instagram" class="form-control social" placeholder="http://instagram.com/">
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
<Script type="text/javascript">
    $(document).ready(function () {
        $('input.social').focus(function () {
            $(this).val($(this).attr('placeholder'));
            return false;
        });
        $('input.social').focusout(function () {
            if ($(this).val() == $(this).attr('placeholder') || $(this).val() == '') {
                $(this).removeAttr('value');
            }
            return false;
        });
    });
</script>