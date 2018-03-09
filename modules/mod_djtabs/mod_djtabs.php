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
defined ('_JEXEC') or die('Restricted access');
 
if(!defined('DS')){
define('DS',DIRECTORY_SEPARATOR);
} 
require_once (JPATH_BASE . DS . 'components' . DS . 'com_djtabs' . DS . 'helpers' . DS . 'helper.php');
require_once (JPATH_BASE . DS . 'components' . DS . 'com_djtabs' . DS . 'models' . DS . 'tabs.php');
//require_once (dirname(__FILE__).DS.'helper.php');


$groupid = $params->get('group_id',0);
    if(!$groupid){
        return false;
    }

	//$params = DJTabsModelTabs::getParams();
	//assignRef('params',$params);
$tabs=DJTabsModelTabs::getTabs($groupid);

$document= JFactory::getDocument();
$document->addScript('components/com_djtabs/assets/script.js');

		$version = new JVersion;
		//if (version_compare($version->getShortVersion(), '3.0.0', '<'))
		$document->addStyleSheet('components/com_djtabs/assets/icons.css');


DjTabsHelper::addThemeCSS($params);
//DjTabsHelper::addThemeCSS($params->get('theme',0), $module->id);


//$layout = 'accordion';
//$layout = '';
$layout = $params->get('layout','tabs');

require(JModuleHelper::getLayoutPath('mod_djtabs',$layout));
 
?>
