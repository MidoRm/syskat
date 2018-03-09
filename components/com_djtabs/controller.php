<?php
/**
 * @version 1.0
 * @package DJ-Tabs
 * @copyright Copyright (C) 2013 DJ-Extensions.com, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Piotr Dobrakowski - piotr.dobrakowski@design-joomla.eu
 *
 * DJ-Tabs is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-Tabs is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-Tabs. If not, see <http://www.gnu.org/licenses/>.
 *
 */
 
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class DJTabsController extends JControllerLegacy
{
	
	public function display($cachable = true, $urlparams = false)
	{

		//$vName	= JRequest::getCmd('view', 'tabs'); ??
		//JRequest::setVar('view', $vName); ??

		$document= JFactory::getDocument();
		$document->addScript('components/com_djtabs/assets/script.js');
		
		//$version = new JVersion;
		//if (version_compare($version->getShortVersion(), '3.0.0', '<'))
		$document->addStyleSheet('components/com_djtabs/assets/icons.css');
		
		
		return parent::display($cachable, $urlparams);
		
	}
	/*
	public function getCSS(){

		$document = JFactory::getDocument();
		$document->setMimeEncoding('text/css');

		// Get the css file path.

		$p = explode(',', base64_decode(JRequest::getVar('params')));
		if($p) foreach($p as $param) {
			$param = explode('=', $param);
			$_GET[$param[0]] = isset($param[1]) ? $param[1] : '';
			//if ($param[0]=='theme')
				//$theme = $param[1];
		}

		$file_name = ($_GET['custom']=='1') ? 'custom.css.php' : 'theme.css.php';
		$path = JPATH_ROOT.DS.'components'.DS.'com_djtabs'.DS.'assets'.DS.$file_name;
		
		include($path);	
	}
	*/
}

