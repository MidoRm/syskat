<?php
/*-------------------------------------------------------------------------------
# mod_galleryaholic - GalleryAholic for Joomla 3.x v1.6.4-PRO
# -------------------------------------------------------------------------------
# author    GraphicAholic
# copyright Copyright (C) 2011-2016 GraphicAholic.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.graphicaholic.com
--------------------------------------------------------------------------------*/
// No direct access
defined('_JEXEC') or die('Restricted access');
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
JHtml::_('bootstrap.framework');
// Import the file / foldersystem
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
$LiveSite 	= JURI::base();
$specialFX 	= $params->get('specialFX');
$document = JFactory::getDocument();
$modbase = JURI::base(true).'/modules/mod_galleryaholic/';
$document->setMetaData( 'viewport', 'width=device-width, initial-scale=1' );
$document->addScript ($modbase.'js/blocksit.min.js');
if ($specialFX == "1") {
$document->addScript ($modbase.'js/scrolla.jquery.js');
$document->addStyleSheet($modbase.'css/animate.min.css');
}
$document->addStyleSheet($modbase.'css/galleryaholic.css');
$imageFeed			= $params->get('imageFeed', 1);
$gafontAwesome 	= $params->get('gafontAwesome', '1');
$lightboxScript 	= $params->get('lightboxScript', '1');
$moduleID 	 		= $module->id;
$moduleTitle 	 	= $module->title;
if ($imageFeed == "7") {
$document->addStyleSheet($modbase.'css/ga-font-awesome.css');
}
if ($lightboxScript == "1") {
	$document->addScript ($modbase.'js/jquery.fancybox.js');
	$document->addStyleSheet($modbase.'css/jquery.fancybox.css');
}
if ($imageFeed == "4") {
require_once (dirname(__FILE__).DS.'helper.php');
$list = modGalleryAholicHelper::getimgList($params, $moduleID);
require(JModuleHelper::getLayoutPath('mod_galleryaholic'));
}
else {
require JModuleHelper::getLayoutPath('mod_galleryaholic','default',$params);
}
if ($imageFeed == "5") {
require_once dirname(__FILE__).'/helpers/helper.php';
$cacheparams->cachemode = 'id';
$cacheparams->modeparams = $cacheid;
$list = GalleryAholicHelper::getList($params, $cacheparams);
require JModuleHelper::getLayoutPath('mod_galleryaholic', $params->get('layout', 'default'));
}
if ($imageFeed == "6") {
require_once dirname(__FILE__).'/helpers/jhelpers.php';
$param = modGAprofileHelper::render($params);
}
?>