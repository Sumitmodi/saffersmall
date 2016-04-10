<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : main.php
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
 *   get permissions from the author or the distrubutor of this code.
 * 
 *   However do not expect any help or support from the author.
 */

require_once VIEWDIR . DS . 'includes' . DS . 'head.php';
require_once VIEWDIR . DS . 'includes' . DS . 'header.php';
require_once VIEWDIR . DS . 'common' . DS . 'functions.php';
?>

<script type='text/javascript'>
    var xhr;
    var made = true;
    var backup = false;
    var long = false;
    function updateCss(parent, spinner) {
        var av = {width: $(window).width(), height: $(window).height()};
        $(parent).css('padding', '50px 35px');
        var taken = parseInt($(parent).width()) + 74;
        var left = av.width - taken;
        $(parent).css('left', left / 2);
    }
    function showPop() {
        var div = $('div.layer-last');
        var parent = $(div).children('div.layer-cen:first');
        var dataHolder = $(parent).children('div.layer-data');
        var spinner = $('div#bowlG');
        $('div.right').html('');
        $(div).css('display', 'block');
        $(dataHolder).html($('div.spinner').html());
        updateCss(parent);
        $(spinner).css('top', '20%');
        $(spinner).children('div#bowl_ringG').css('left', '49%');
        mainHeightUpdate();
    }
    function hidePop() {
        $('a.close').trigger('click');
    }

    function form(data, url) {
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            contentType: false,
            processData: false,
            success: function (data) {
                $('div#responses').html(data);
                hidePop();
            },
            complete: function (XMLHttpRequest, textStatus) {
                fill(XMLHttpRequest.responseText);
                return false;
            }
        });
        return false;
    }

    function sleep(length) {
        var start = new Date().getTime();
        for (var i = 0; i < 1e7; i++) {
            if ((new Date().getTime() - start) > length) {
                break;
            }
        }
    }

    function fill(data) {
        $('div.layer-data').html(data);
        $('form').unbind('submit');
        $('a.pop').unbind('click');
        ajaxListener();
        linkListener();
    }
    function link(url) {
        //window.history.pushState('', '', url);
        showPop();
        $.ajax({
            url: url,
            type: 'POST',
            success: function (data) {
                fill(data);
                return false;
            },
            failure: function (data) {
                fill(data);
                return false;
            }
        });
        return false;
    }
    function ajaxListener() {
        $('form').submit(function (e) {
            e.preventDefault();
            var data = new FormData(this);
            var url = $(this).attr('action');
            if (url == '') {
                url = document.URL;
            }
            form(data, url);
            return false;
        });
    }
    function linkListener() {
        $('a.pop').click(function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            if (url == document.URL) {
                return false;
            }
            link(url);
            return false;
        });
    }
    function mainHeightUpdate() {
        $('div.dashboard').height(document.height);
    }
    function popLink() {
        $('a.pop').click(function () {
            showPop();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('div.layer-data').html(data);
                }
            });
            return false;
        });
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('a.close').click(function (e) {
            $('div.layer-last').css('display', 'none');
            $('body').css('overflow-y', 'scroll');       
            //linkListener();
            return false;
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('a.pop').click(function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            console.log(url);
            if (url == document.URL) {
                return false;
            }
            link(url);
            return false;
        });
    })
</script>
<?php require_once VIEWDIR . DS . $page . EXT; ?>

<?php

require_once VIEWDIR . DS . 'includes' . DS . 'footer.php';
?>