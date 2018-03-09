<?php
/**
* @title		banner slider images scroll
* @website		http://www.joombig.com
* @copyright	Copyright (C) 2014 joombig.com. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<link rel="stylesheet" href="<?php echo $mosConfig_live_site; ?>/modules/mod_banner_slider_images_scroll/assets/css/smoothDivScroll.css" type="text/css" />
<?php
if ($enable_jQuery == 1) {?>
	<script src="<?php echo $mosConfig_live_site; ?>/modules/mod_banner_slider_images_scroll/assets/js/jquery.min.js" type="text/javascript"></script>
<?php }?>
<script src="<?php echo $mosConfig_live_site; ?>/modules/mod_banner_slider_images_scroll/assets/js/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
<script src="<?php echo $mosConfig_live_site; ?>/modules/mod_banner_slider_images_scroll/assets/js/jquery.mousewheel.js" type="text/javascript"></script>

<script src="<?php echo $mosConfig_live_site; ?>/modules/mod_banner_slider_images_scroll/assets/js/jquery.kinetic.js" type="text/javascript"></script>
<script src="<?php echo $mosConfig_live_site; ?>/modules/mod_banner_slider_images_scroll/assets/js/jquery.smoothDivScroll-1.3.js" type="text/javascript"></script>

<style type="text/css">

	#makeMeScrollable
	{
		width:<?php echo $width;?>;
		height: <?php echo $height;?>;
		position: relative;
		margin:0 auto;
	}
	
	/* Replace the last selector for the type of element you have in
	   your scroller. If you have div's use #makeMeScrollable div.scrollableArea div,
	   if you have links use #makeMeScrollable div.scrollableArea a and so on. */
	#makeMeScrollable div.scrollableArea img
	{
		position: relative;
		float: left;
		margin: 0;
		padding: 0;
		/* If you don't want the images in the scroller to be selectable, try the following
		   block of code. It's just a nice feature that prevent the images from
		   accidentally becoming selected/inverted when the user interacts with the scroller. */
		-webkit-user-select: none;
		-khtml-user-select: none;
		-moz-user-select: none;
		-o-user-select: none;
		user-select: none;
	}
</style>

	<div id="makeMeScrollable">
		<?php foreach($lists as $item) { ?>
			<img src="<?php echo $item->image ?>" alt="scroll image" id="<?php echo $item->title ?>" />
		<?php } ?>	
	</div>