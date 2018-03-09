<?php

/*-------------------------------------------------------------------------------
# MarqueeAholic - Marquee module for Joomla 2.5 v1.0.0
# -------------------------------------------------------------------------------
# author    GraphicAholic
# copyright Copyright (C) 2011 GraphicAholic.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.graphicaholic.com
--------------------------------------------------------------------------------*/

/**
* @id $Id$
* @author  GraphicAholic.com (c) 2013
* @license  GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
*/
// no direct access
defined( '_JEXEC' ) or die;

jimport('joomla.form.formfield');
JHtml::_('jquery.framework');

class JFormFieldColorinput extends JFormField {

	protected	$_name = 'Colorinput';

	protected function getInput()	{

		$LiveSite = JURI::base();
		$document = JFactory::getDocument();

		$dirname = basename(dirname(dirname(__FILE__)));

		$document->addStyleSheet($LiveSite."../modules/$dirname/css/colorpicker.css");
		$document->addScript($LiveSite."../modules/$dirname/js/colorpicker.js");

		$onfocus = "jQuery.noConflict(); jQuery(this).ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				hex=hex.toUpperCase();
				jQuery(el).val(hex);
				jQuery(el).ColorPickerHide();
				document.getElementById('".$this->id."COLORBOX').style.backgroundColor = '#'+hex;
			},
			onBeforeShow: function () {
				jQuery(this).ColorPickerSetColor(this.value);
			}
		})";

		$output = '<div class="input-append">
		<input id="'.$this->id.'" class="input-medium" name="'.$this->name.'" type="text" value="'.$this->value.'" onfocus="'.$onfocus.'"/>
		<span id="'.$this->id.'COLORBOX" class="add-on hasTip" title="Click on field to change color" style="background-color:#'.$this->value.'">&nbsp;&nbsp;&nbsp;</span>
		</div>';
	return $output;
	}
}
?>