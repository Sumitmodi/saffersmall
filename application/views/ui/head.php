<?php

/*
 *   Project : Project name
 * 
 *   Author  : Sandeep Giri
 * 
 *   Contact : ioesandeep@gmail.com
 * 
 *   File    : head.php
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
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="description" content="">
<meta name="author" content="">
<title><?php echo isset($title) ? $title : DOMAIN;?></title>
<!--start of fonts-->
<link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
<!--end of fonts-->
<!--start of css-->
<link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">
<link href="<?php echo base_url();?>assets/css/flexslider.css" rel="stylesheet" type="text/css" media="all">
<link href="<?php echo base_url();?>assets/css/animate.min.css" type="text/css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" type="text/css" media="all">
<link href="<?php echo base_url();?>assets/css/responsive.css" rel="stylesheet" type="text/css" media="all">
<link href="<?php echo base_url();?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css" media="all">
<link href="<?php echo base_url();?>assets/css/selectize.css" rel="stylesheet" type="text/css" media="all">

<?php if(isset($productSlide)) { ?>
<link href="<?php echo base_url();?>assets/css/pgwslideshow.css" rel="stylesheet" type="text/css" media="all">
<?php } ?>

<style type="text/css">
body,td,th {
	font-family: "Open Sans", sans-serif;
}
</style>
<!--end of css-->

<!--start of js-->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/waypoints.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.flexslider.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/script.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/SmoothScroll.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.parallax.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/selectize.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jssor.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jssor.slider.js"></script>


<!--end of js-->

<!--start of js-->
<script type="text/javascript">
$(function() {
  $('#testform').submit(function(e){
    e.preventDefault();
  });
  
  $('#subject').selectize({create: true});
  $('#tags').selectize({    
    delimiter: ',',
    persist: true,
    create: function(input) {
      return {
        value: input,
        text: input
      }
    }
  });
});



</script>

</head>
<body>