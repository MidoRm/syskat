<?php
/*
# ------------------------------------------------------------------------
# Extensions for Joomla 2.5.x - Joomla 3.x
# ------------------------------------------------------------------------
# Copyright (C) 2009-2015 za-studio.net, za-studio.ru. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: Za Studio
# Websites:  http://www.za-studio.net
# Date modified: 20/02/2015
# ------------------------------------------------------------------------
*/
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<style type="text/css">
#za-formwrapper<?php echo $uniqid ?> .morph-button-modal-2 > button,
#za-formwrapper<?php echo $uniqid ?> .morph-button-modal-2 .morph-content{
	background: <?php echo $backgr_text ?> !important;
	color: <?php echo $color_text ?> !important;
		  border: 1px solid <?php echo $color_text ?>;
	}
	#za-formwrapper<?php echo $uniqid ?> .morph-button-fixed,
#za-formwrapper<?php echo $uniqid ?> .morph-button-fixed .morph-content {
	width: <?php echo $width_button ?>px;
}

	#za-formwrapper<?php echo $uniqid ?> .icon-close {
	z-index: 100;
	display: block;
	overflow: hidden;
	width: 3em;
	height: 3em;
	text-align: center;
	line-height: 3;
	cursor: pointer;
}
#za-formwrapper<?php echo $uniqid ?> .content-style-form h2{
color: <?php echo $color_text ?>;	
	
}
#za-formwrapper<?php echo $uniqid ?> .icon:before {
	position: relative;
	display: block;
	width: 100%;
	height: 100%;
	text-transform: none;
	font-weight: normal;
	font-style: normal;
	font-variant: normal;
	font-family: 'icomoon';
	speak: none;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
}
#za-formwrapper<?php echo $uniqid ?> .icon-close::before {
	content: "\e601";
}
p.za_qc_success {color:<?php echo $color_text ?>;}
#za-formwrapper<?php echo $uniqid ?> .content-style-form label {
	color: <?php echo $hide_text ?> !important;
}
#za-formwrapper<?php echo $uniqid ?> .content-style-form input[type="text"],
#za-formwrapper<?php echo $uniqid ?> .content-style-form input[type="password"],
#za-formwrapper<?php echo $uniqid ?> .content-style-form input[type="email"],
#za-formwrapper<?php echo $uniqid ?> .content-style-form textarea{
	border: 2px solid <?php echo $hide_text ?>;
	color: <?php echo $hide_text ?> !important;
}

#za-formwrapper<?php echo $uniqid ?> .content-style-form input[type="text"]:focus,
#za-formwrapper<?php echo $uniqid ?> .content-style-form input[type="password"]:focus,
#za-formwrapper<?php echo $uniqid ?> .content-style-form input[type="email"]:focus,
#za-formwrapper<?php echo $uniqid ?> .content-style-form textarea:focus {
	border-color: <?php echo $color_text ?>;
	color: <?php echo $color_text ?> !important;
}
#za-formwrapper<?php echo $uniqid ?> .content-style-form .za_qc_submit {
	background: <?php echo $color_text ?>;
	color: <?php echo $backgr_text ?>;
}

#za-formwrapper<?php echo $uniqid ?> .content-style-form .icon-close {
	color: <?php echo $hide_text ?>;
}
#za-formwrapper<?php echo $uniqid ?> .content-style-form .icon-close:hover {
	color: <?php echo $color_text ?>;
}
#za-formwrapper<?php echo $uniqid ?> .morph-button > button {
	background-color: <?php echo $color_text ?>;
	color: <?php echo $backgr_text ?>;
}

#za-formwrapper<?php echo $uniqid ?> .morph-button-modal-1::before {
	background: <?php echo $backgr_text ?>;
}
#za-formwrapper<?php echo $uniqid ?> button, #za_quickcontact<?php echo $uniqid ?> html input[type="button"], #za_quickcontact<?php echo $uniqid ?> input[type="reset"], #za_quickcontact<?php echo $uniqid ?> input[type="submit"]{-webkit-appearance:button;cursor:pointer;}
	</style>