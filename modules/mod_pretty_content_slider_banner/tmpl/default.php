<?php
/*------------------------------------------------------------------------
# "Pretty Content Slider Banner" Joomla module
# Copyright (C) 2013 joombig. All Rights Reserved.
# License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
# Author: joombig.com
# Website: http://www.joombig.com
-------------------------------------------------------------------------*/
defined('_JEXEC') or die('Restricted access'); // no direct access 

?>
<script>
jQuery.noConflict(); 
</script>
<link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site; ?>/modules/mod_pretty_content_slider_banner/tmpl/pretty-content-slider-style.css" />
<style>
	#pretty-content-slider-style{
		width: <?php echo $moduleWidth;?>;
	}
	.pretty-content-rotator{
		background-color:#222;
		width: 100%;
		height:<?php echo $moduleHeight;?>px;
		margin:0 auto;
		position:relative;
		font-family:Arial,Helvetica,sans-serif;
		color:#fff;
		text-transform:uppercase;
		letter-spacing:-1px;
		overflow:hidden;
	}
	.pretty-content-rotator ul li a{
		color: <?php echo $color_title;?> !important;
		font-size:<?php echo $font_size_title;?>px !important;
		background-color:<?php echo $background_color_title;?> !important;
		border:2px solid <?php echo $boder_color_title;?> !important;
	}
	.pretty-content-rotator .description{
		background-color:<?php echo $background_color_des;?> !important;
		-moz-border-radius:0px 10px 0px 0px;
		-webkit-border-top-right-radius:10px;
		border-top-right-radius:10px;
		opacity:0.7;
		border-top:2px solid <?php echo $boder_color_des;?> !important;
		border-right:2px solid <?php echo $boder_color_des;?> !important;
	}
	.pretty-content-rotator .heading h1{
		color: <?php echo $color_desshort;?> !important;
		font-size:<?php echo $font_size_desshort;?>px !important;
	}
	.pretty-content-rotator .description p{
		color: <?php echo $color_deslong;?> !important;
		font-size:<?php echo $font_size_deslong;?>px !important;
	}
	#pretty-content-slider-style{
		-webkit-transform: skewX(<?php echo $viewstyle;?>deg);
		-moz-transform: skewX(<?php echo $viewstyle;?>deg);
		-ms-transform: skewX(<?php echo $viewstyle;?>deg);
		-o-transform: skewX(<?php echo $viewstyle;?>deg);
		transform: skewX(<?php echo $viewstyle;?>deg);
	}
</style>
<?php if($enable_border == 1){?>
	<style>
		.pretty-content-rotator{
			border:3px solid #f0f0f0;
			-moz-box-shadow:0px 0px 10px #222;
			-webkit-box-shadow:0px 0px 10px #222;
			box-shadow:0px 0px 10px #222;
		}
	</style>
<?php }?>
<div id="pretty-content-slider-style">
	<div class="pretty-content-rotator">
		<ul id="rotmenu">
		<?php for ($loop = 1; $loop <= $tabNumber; $loop += 1) { ?>
			<li>
				<a href="rot1"><?php echo $NameItem[$loop]; ?></a>
				<div style="display:none;">
					<div class="info_image"><?php echo $mosConfig_live_site; ?>/<?php echo $image[$loop]; ?></div>
					<div class="info_heading"><?php echo $DesShort[$loop]; ?></div>
					<div class="info_description">
					 <?php echo $DesLong[$loop]; ?>
						<a href="<?php echo $LinkDetail[$loop]; ?>" class="more"><?php echo $readmore[$loop]; ?></a>
					</div>
				</div>
			</li>
		<?php } ?>
		</ul>
		<div id="rot1">
			<img src="" class="bg" alt=""/>
			<div class="heading">
				<h1></h1>
			</div>
			<div class="description">
				<p></p>

			</div>    
		</div>
	</div>
</div>
<!-- The JavaScript -->
<?php if($enable_jQuery == 1){?>
	<script type="text/javascript" src="<?php echo $mosConfig_live_site; ?>/modules/mod_pretty_content_slider_banner/js/jquery.min.js"></script>
<?php }?>
<script type="text/javascript" src="<?php echo $mosConfig_live_site; ?>/modules/mod_pretty_content_slider_banner/js/jquery.easing.1.3.js"></script>
<script>
	var calWidth,calHeight,caltimespeed,calautoplay;
	var parentWidth = document.getElementById("pretty-content-slider-style").offsetWidth;
	calWidth = parentWidth;
	calHeight = <?php echo $moduleHeight;?>;
	calautoplay = <?php echo $autoplay;?>;
	caltimespeed = <?php echo $timespeed;?>;
</script>
<script type="text/javascript" src="<?php echo $mosConfig_live_site; ?>/modules/mod_pretty_content_slider_banner/js/jquery.pretty.js"></script>       
