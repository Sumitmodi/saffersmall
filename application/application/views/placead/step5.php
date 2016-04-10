<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : step5.php
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
    <h2>
        <i class="fa fa-folder-open"></i>Place Ad 
        <div class="choose-ads">
            <small>Step :: 6</small>
        </div>
    </h2>
    <div class="down-arrow"></div>
</div>



<section class="place-ads">

    <h4><strong><?php if (isset($response['message'])) echo $response['message']; ?></strong></h4>
    <form class="form-horizontal" action="?_=7" method="post">
        <label class="col-lg-12 col-md-12 col-sm-12 control-label" style="text-align: left;">
            <small>
                Bring your ad on the top.
            </small>
        </label>
        <div style="clear:both;"></div> 

        <div class="form-group">
            <p class="col-lg-12 col-md-12 col-sm-12">
                <input type="checkbox" name="bump" value="29">
                Bump your ad to the top of page 1 <span style="color:#f35656">(R 29)</span>
            </p>
        </div>

        <div class="form-group">
            <p class="col-lg-12 col-md-12 col-sm-12">
                <input type="checkbox" name="top" value="169">
                Show your ad on rotation at the top of page 1 for the category 
                <span style="color:#f35656">(R 169 for 7 days)</span> 
            </p>
        </div>

        <div class="form-group">
            <p class="col-lg-12 col-md-12 col-sm-12">
                <input type="checkbox" name="highlight" value="39">
                Highlight your ad to gain visibility and stand out from the crowd 
                <span style="color:#f35656">(R 39 for 7 days)</span> 
            </p>
        </div>

        <div class="form-group">
            <p class="col-lg-12 col-md-12 col-sm-12">
                <input type="checkbox" name="urgent" value="59">
                Let buyers know you want to sell quickly with an Urgent label <span style="color:#f35656">(R 59 for 7 days)</span>
            </p>
        </div>

        <div class="form-group">
            <p class="col-lg-12 col-md-12 col-sm-12">
                <input type="checkbox" name="home" value="339">
                <b>*Most visibility*</b> 
                Show your ad to millions of people on the Saffersmall Home page! <span style="color:#f35656">(R 339 for 7 days)</span> 
            </p>
        </div>
        <div class="form-group">
            <p class="col-lg-12 col-md-12 col-sm-12">
                Current sum : R <span style="color:#f35656;" class="sum">0</span>/-
            </p>
        </div>
        <div class="form-group">
            <input type="submit"  value="submit">
        </div>
    </form>
</section>
<script type="text/javascript">
    $(document).ready(function () {
        $('input[type=checkbox]').click(function () {
          
                var sum = 0;
            $('input[type=checkbox]').each(function (i) {
                var cur = $('input[type=checkbox]').eq(i);
                console.log(i);
                if ($(cur).is(':checked')) {
                    sum = sum + parseInt($(cur).val());
                }
                $('span.sum').html(sum);

            });
            
            return true;
        });
    });
</script>
