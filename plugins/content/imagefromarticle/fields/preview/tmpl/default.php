<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined( '_JEXEC' ) or die;
?>
<style>
	.ifa_preview {
		overflow: hidden;
	}
	
	.ifa_preview img {
		-webkit-box-shadow: 0 0 8px 4px #ccc;
		box-shadow: 0 0 8px 4px #ccc;
		float: none!important;
		margin: 15px!important;
	}
</style>

<div class="ifa_preview">
	<img src="<?php echo $tmp_path_site; ?>/image_ifa_preview.png" />
</div>	
