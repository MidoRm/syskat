<?php
/**
* @title		banner slider images scroll
* @website		http://www.joombig.com
* @copyright	Copyright (C) 2014 joombig.com. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
// Path assignments
$mosConfig_absolute_path = JPATH_SITE;
$mosConfig_live_site = JURI :: base();
if(substr($mosConfig_live_site, -1)=="/") { $mosConfig_live_site = substr($mosConfig_live_site, 0, -1); }

if (JVERSION < 3) {
	JHTML::_('behavior.mootools');
} else {
	JHtml::_('jquery.framework');        
}
// Include helper.php
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
require_once (dirname(__FILE__).DS.'helper.php');
$lists 					= modBannersliderimgscrollHelper::getList($params);
$uri 					= JURI::getInstance();
$uniqid					= $module->id;
$enable_jQuery			= $params->get('enable_jQuery', 1);
$width					= $params->get('width', "100%");
$height 				= $params->get('height', "330px");
$items					= count($lists);
$document 				= JFactory::getDocument();
require(JModuleHelper::getLayoutPath('mod_banner_slider_images_scroll'));
?>
