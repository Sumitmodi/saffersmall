<?php
/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : dashboard.php
 * 
 *   Project : saffersmall
 */

/*
 *   <one line to give the program's name and a brief idea of what it does.>
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
<p><?php echo isset($response['message']) ? $response['message'] : NULL; ?></p>
<script type="text/javascript">
    $(document).ready(function () {
<?php if (isset($cats)) { ?>
            var cats = <?php echo json_encode($cats); ?>
<?php } ?>
<?php if (isset($cats)) { ?>
            var lists = <?php echo json_encode($lists); ?>
<?php } ?>
    });
</script>
<table>
    <?php
    if (isset($listed)) {
        foreach ($listed as $list) {
            $list = (object) $list;
            ?>
            <tr>
                <th><?php echo $list->name; ?></th>
                <th>
            <ul>
                <?php if (!is_null($list->lists)) {
                    foreach ($list->lists as $l) { ?> 
                        <li><?php echo $l['item_name']; ?></li>
            <?php }
        } ?>
            </ul>
        </th>
        </tr>
    <?php }
}
?>
</table>