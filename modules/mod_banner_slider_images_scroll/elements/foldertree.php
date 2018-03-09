<?php
/**
* @title		banner slider images scroll
* @website		http://www.joombig.com
* @copyright	Copyright (C) 2014 joombig.com. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.form.formfield');
jimport( 'joomla.filesystem.folder' );

class JFormFieldFolderTree extends JFormField
{
	protected $type = 'FolderTree';

	protected function getInput()
	{
		$options = array();
		// path to images directory
		if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
		$path		= JPATH_ROOT.DS.$this->element['directory'];
		$filter		= $this->element['filter'];
		$folders	= JFolder::listFolderTree($path, $filter);
		foreach ($folders as $folder)
		{
			$options[] = JHtml::_('select.option', str_replace(DS,"/",$folder['relname']), str_replace(DS,"/",substr($folder['relname'], 1)));
		}

		return JHtml::_('select.genericlist', $options, $this->name, '', 'value', 'text', $this->value);
	}
}
