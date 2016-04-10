<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : add.php
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
?>
<script type="text/javascript">
    $(document).ready(function(e) {
            var cl = '<span class="tagRemove"><a href="#">&Chi;</a></span>';
            var timer;
            var ip = $("#tags");
            var checkSpace;
            var update;
            function addTag(tagItem){
                var filter = tagItem.replace(" ", "")
                filter = filter.replace('-', ' ');
                if (filter != ""){
                    var tag = $("ul.tags");
                    var insert = "<li><input type='hidden' name='list_name[]' value='" + tagItem + "'/><span class='tags tagItem'>" + filter.charAt(0).toUpperCase() + filter.slice(1) + cl + "</span></li>";
                    tag.append(insert);
                    ip.val('');
                }
            }
            $(document).on('focus', '#tags', function(){
                var currentVal = ip.val();
                $(document).keypress(function(event){
                    if (String.fromCharCode(event.which) == " "){
                    addTag(ip.val());
                    };
                })

            });
            $(document).on('click', '.tagItem:not(.tagRemove)', function(e){
                addTag($(ip).val())
                var elem = $(this).prev('input').val();
                $(ip).val(elem);
                $(this).parent('li').remove();
                $(ip).trigger('focus');
                return false;
            });
            $(document).on('click', '.tagRemove', function(e){
                addTag(ip.val());
                e.target.parentNode.parentNode.parentNode.remove();
                if ($('ul.tags').children('li').length == 0)
                    $(ip).trigger('focus');
                return false;
            });
    });
</script>
<?php if(isset($response['message'])) echo '<p>'.$response['message'].'</p>'; ?>
<?php if(isset($added)) { echo '<ul'; foreach($added as $a){ echo '<li>'.$a.'</li>';}echo '</ul>';} ?>
<form action="" method="post">
    <p>
        <select name="cats[]" multiple="multiple">
            <option>Select a category</option>
            <?php foreach ($cats as $c) {
                $c = (object) $c;
                ?>
                <option value="<?php echo $c->sno; ?>"><?php echo $c->category_name; ?></option>   
<?php } ?>
        </select>
    </p>
    <p>
        <input type="text" name="tagsearch" id="tags" class="text" data-type="string" placeholder="Tags e.g. Tuition Language Computer" required/>
        <span class="required hide message">*</span>
    </p>                    
    <ul class="tags"></ul>
    <p>
        Please make sure the list values are not default values. The following are default items in the list:
    </p>
    <p>
        <input type="submit" value="add"/>
    </p>
    <ul>
        <li>Name</li>
        <li>Price</li>
        <li>Description</li>
    </ul>
</form>