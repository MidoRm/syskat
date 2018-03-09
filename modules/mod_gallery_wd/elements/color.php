<?php
 
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die( 'Restricted access' );

class JFormFieldColor extends JFormFieldText
{
	protected $type = 'Color';

	public function getInput()
	{
		$document = JFactory::getDocument();
		$document->addScript(JUri::root().'modules/mod_gallery_wd_tagscloud/elements/jscolor/jscolor.js' );
		return parent::getInput();
	}

	public function setup(SimpleXMLElement $element, $value, $group = null)
	{

		$return= parent::setup($element, $value, $group);
		$this->element['class'] = $this->element['class'].' color';
		if($this->element['name']!='title_color' and $this->element['name']!='date_color')
		$this->element['onchange'] = 'document.getElementById(\'jform_params_calendar_style\').value=\'custom\'';
		return $return;
	}
}
?>