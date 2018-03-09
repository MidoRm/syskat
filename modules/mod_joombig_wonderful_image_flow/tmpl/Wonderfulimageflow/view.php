<?php
/**
* @title		joombig wonderful image flow
* @website		http://www.joombig.com
* @copyright	Copyright (C) 2014 joombig.com. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

    // no direct access
    defined('_JEXEC') or die;
?>
<script>
	var width,height,frontWidth,frontHeight;
	width=<?php echo $width_module;?>;
	height=<?php echo $height_module;?>;
	frontWidth=<?php echo $width_image;?>;
	frontHeight=<?php echo $height_image;?>;
	if ((screen.width <= <?php echo $screen_width1;?>)&&(screen.width > <?php echo $screen_width2;?>)){
		width=<?php echo $width_module1;?>;
		height=<?php echo $height_module1;?>;
		frontWidth=<?php echo $width_image1;?>;
		frontHeight=<?php echo $height_image1;?>;
	}
	if ((screen.width <= <?php echo $screen_width2;?>)&&(screen.width > <?php echo $screen_width3;?>)){
		width=<?php echo $width_module2;?>;
		height=<?php echo $height_module2;?>;
		frontWidth=<?php echo $width_image2;?>;
		frontHeight=<?php echo $height_image2;?>;
	}
	if ((screen.width <= <?php echo $screen_width3;?>)&&(screen.width > <?php echo $screen_width4;?>)){
		width=<?php echo $width_module3;?>;
		height=<?php echo $height_module3;?>;
		frontWidth=<?php echo $width_image3;?>;
		frontHeight=<?php echo $height_image3;?>;
	}
	if ((screen.width <= <?php echo $screen_width4;?>)&&(screen.width > <?php echo $screen_width5;?>)){
		width=<?php echo $width_module4;?>;
		height=<?php echo $height_module4;?>;
		frontWidth=<?php echo $width_image4;?>;
		frontHeight=<?php echo $height_image4;?>;
	}
	if (screen.width <= <?php echo $screen_width5;?>){
		width=<?php echo $width_module5;?>;
		height=<?php echo $height_module5;?>;
		frontWidth=<?php echo $width_image5;?>;
		frontHeight=<?php echo $height_image5;?>;
	}
</script>
<script type="text/javascript" src="<?php echo $mosConfig_live_site; ?>/modules/mod_joombig_wonderful_image_flow/tmpl/Wonderfulimageflow/js/jquery.carousel-1.1.min.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.11/jquery.mousewheel.min.js"></script>

<script type="text/javascript" src="<?php echo $mosConfig_live_site; ?>/modules/mod_joombig_wonderful_image_flow/tmpl/Wonderfulimageflow/js/sample01.js"></script>
<?php
if ($enable_jQuery == 1) {?>
	<script type="text/javascript" src="<?php echo $mosConfig_live_site; ?>/modules/mod_joombig_wonderful_image_flow/tmpl/Wonderfulimageflow/js/jquery-1.9.1.min.js"></script>
<?php }?>
<link rel="stylesheet" href="<?php echo $mosConfig_live_site; ?>/modules/mod_joombig_wonderful_image_flow/tmpl/Wonderfulimageflow/css/carousel.css" />
<link rel="stylesheet" href="<?php echo $mosConfig_live_site; ?>/modules/mod_joombig_wonderful_image_flow/tmpl/Wonderfulimageflow/css/content.css" />

<style>
	.carousel{
		width:<?php echo $width_module;?>px;
	}
	@media screen and (max-width: <?php echo $screen_width1;?>px) {
		.carousel{
			width:<?php echo $width_module1;?>px !important;
		}
	}
	@media screen and (max-width: <?php echo $screen_width2;?>px) {
		.carousel{
			width:<?php echo $width_module2;?>px !important;
		}
	}
	@media screen and (max-width: <?php echo $screen_width3;?>px) {
		.carousel{
			width:<?php echo $width_module3;?>px !important;
		}
	}
	@media screen and (max-width: <?php echo $screen_width4;?>px) {
		.carousel{
			width:<?php echo $width_module4;?>px !important;
		}
	}
	@media screen and (max-width: <?php echo $screen_width5;?>px) {
		.carousel{
			width:<?php echo $width_module5;?>px !important;
		}
	}
</style>
<div class="jb-wonderful-img-flow">
<div class="carousel">
<!-- BEGIN CONTAINER -->
<div class="slides">
	<?php 
		$count=1;
		
	foreach($data as $index=>$value) {
	?>
		   <div class="slideItem"> 
		   <a href="<?php echo $value['Link'];?>"> <img src="<?php echo $value['image'];?>"/> </a>
			</div>
	<?php $count++; }?>
</div>	
</div>
<div class="clear"></div>
</div>
	

	
