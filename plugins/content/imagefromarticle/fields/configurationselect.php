<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
*/

// no direct access
defined( '_JEXEC' ) or die;

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

JFormHelper::loadFieldClass('dynamicsingleselect');

class JFormFieldConfigurationSelect extends JFormFieldDynamicSingleSelect
{
	public $type = 'ConfigurationSelect';

	protected function getOptions()
	{
		$options = array();

		$lang = JFactory::getLanguage();
		$lang->load('plg_content_imagefromarticle.sys', JPATH_SITE);

		$path = '/plugins/content/imagefromarticle';

		$options[] = array('ltc', JText::_('PLG_CONTENT_IMAGEFROMARTICLE_VALUE_LOGOTEXTCREDENTIALS'), '', JURI::root(true).$path.'/images/ltc.png');
		$options[] = array('ctl', JText::_('PLG_CONTENT_IMAGEFROMARTICLE_VALUE_CREDENTIALSTEXTLOGO'), '', JURI::root(true).$path.'/images/ctl.png');
		
		return $options;
	}

	public function setup(SimpleXMLElement $element, $value, $group = null)
	{
		$return = parent::setup($element, $value, $group);

		if ($return) {
			$this->width = 150;
			$this->height = 100;
		}

		return $return;
	}
}
?>