<?php
/**
# "Pretty Content Slider Banner" Joomla module
# Copyright (C) 2013 joombig. All Rights Reserved.
# License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
# Author: joombig.com
# Website: http://www.joombig.com
*/

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

class JFormFieldLoader extends JFormField
{
	protected $type = 'Loader';

	function getInput(){
		$document = JFactory::getDocument();
		
		$document->addScript(JURI::root(1) . '/modules/mod_pretty_content_slider_banner/assets/color/jquery-noconflict.js');
		$header_media = $document->addScript(JURI::root(1) . '/modules/mod_pretty_content_slider_banner/assets/color/jscolor.js');
	}
}