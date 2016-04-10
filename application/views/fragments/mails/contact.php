<?php

/*
 * Author : Sandeep Giri <ioesandeep@gmail.com>
 * 
 * Project : grasshopit
 * 
 * File : contact.php
 * 
 * Created : Nov 8, 2014 11:02:35 PM
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
<html>
    <body>
        <h4>An email with the following details has been received.</h4>
        <table>
            <tr>
                <th>Name</th>
                <td><?php echo $name;?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $email;?></td>
            </tr>
            <tr>
                <th>Message</th>
                <td><?php echo $message;?></td>
            </tr>
        </table>
        <h4>Thank you,</h4>
        <p>Grasshopit.com mail engine</p>
    </body>
</html>