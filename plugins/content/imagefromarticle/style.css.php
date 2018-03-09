<?php 
/**
* @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
* @license		GNU General Public License version 3 or later; see LICENSE.txt
*/

// No direct access to this file
defined('_JEXEC') or die;

// Explicitly declare the type of content
header("Content-type: text/css; charset=UTF-8");
?>

.imagefromarticle {
	overflow: hidden;
	width: <?php echo $width; ?>px;	
	float: <?php echo $float; ?>;
		
	<?php if ($border_width > 0) : ?>
		border: <?php echo $border_width; ?>px solid <?php echo $border_color; ?>;
	<?php endif; ?>	
	
	<?php if ($border_radius > 0) : ?>
		border-radius: <?php echo $border_radius; ?>px;
		-moz-border-radius: <?php echo $border_radius; ?>px;
		-webkit-border-radius: <?php echo $border_radius; ?>px;

		-moz-background-clip: padding-box;
		-webkit-background-clip: padding-box;
		background-clip: padding-box;
		/* Use "background-clip: padding-box" when using rounded corners to avoid the gradient bleeding through the corners */
	<?php endif; ?>
	
	<?php if ($shadow_width > 0) : ?>
		box-shadow: 0 0 <?php echo $shadow_width; ?>px rgba(0, 0, 0, 0.8);
		-moz-box-shadow: 0 0 <?php echo $shadow_width; ?>px rgba(0, 0, 0, 0.8);
		-webkit-box-shadow: 0 0 <?php echo $shadow_width; ?>px rgba(0, 0, 0, 0.8);
		
		margin: <?php echo $shadow_width; ?>px;
	<?php endif; ?>	
}	
