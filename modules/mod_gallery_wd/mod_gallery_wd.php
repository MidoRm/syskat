<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 defined('_JEXEC') or die('Restricted access');
 
 require_once __DIR__ . '/helper.php';
 
$document		=JFactory::getDocument();

$document->addScript(JURI::root() . 'components/com_gallery_wd/js/bwg_frontend.js');
$document->addStyleSheet(JURI::root() .'components/com_gallery_wd/css/bwg_frontend.css" type="text/css" rel="stylesheet');
$document->addStyleSheet(JURI::root() .'components/com_gallery_wd/css/jquery.mCustomScrollbar.css" type="text/css" rel="stylesheet');
$document->addStyleSheet(JURI::root() .'components/com_gallery_wd/css/jquery-ui-1.10.3.custom.css" type="text/css" rel="stylesheet');

$document->addStyleSheet(JURI::root() .'components/com_gallery_wd/css/font-awesome-4.0.1/font-awesome.css" type="text/css" rel="stylesheet');
$document->addScript(JURI::root() . 'components/com_gallery_wd/js/jquery.js');
$document->addScript(JURI::root() . 'components/com_gallery_wd/js/jquery.ui.js');
$document->addScript(JURI::root() . 'components/com_gallery_wd/js/jquery-migrate-1.2.1.js');

$document->addScript(JURI::root() . 'components/com_gallery_wd/js/jquery.fullscreen-0.4.1.js');

$document->addScript(JURI::root() . 'components/com_gallery_wd/js/bwg_gallery_box.js');
$document->addScript(JURI::root() . 'components/com_gallery_wd/js/3DEngine/3DEngine.js');
$document->addScript(JURI::root() . 'components/com_gallery_wd/js/3DEngine/Sphere.js');
$document->addScript(JURI::root() . 'components/com_gallery_wd/js/jquery.mCustomScrollbar.concat.min.js');
echo "<script src='".JURI::root() ."components/com_gallery_wd/js/jquery.raty.js'></script>";
 
 ///////////include language/////////
$lang = JFactory::getLanguage();
$extension = 'com_gallery_wd';
$base_dir = JPATH_SITE;
$language_tag = $lang->getTag();
$reload = true;
$lang->load($extension, $base_dir, $language_tag, $reload);

///////module params//////////
$session =JFactory::getSession();

$id= $module->id;
$db =JFactory::getDBO();
$dimensions = $params->get('dimensions');
$dimensions_array=explode('x',$dimensions);
$bwg=$module->id;
	$type = $params->get('type');
    $gallery_id = $params->get('gallery_id');
    $album_id = $params->get('album_id');
    $show = $params->get('show');
    $count = $params->get('count');
    $width = $dimensions_array[0];
    $height = $dimensions_array[1];    
    $theme_id = $params->get('theme_id');	

     $slide_params = array (
        'from' => 'module',
        'gallery_type' => $type,
        'id' => ($type == 'gallery' ? $gallery_id : $album_id),
        'show' => $show,
        'count' => $count, 
        'width' => $width, 
        'height' => $height,
        'theme_id' => $theme_id);

$session = JFactory::getSession();
$session->set('show', $show);
$session->set('count', $count);
$session->set('width', $width);
$session->set('height', $height);
$uri	= JFactory::getURI();
$current_url=$uri->toString();
$session->set('current_url', $current_url);
	
	
	
	if($type=='gallery')
require JModuleHelper::getLayoutPath('mod_gallery_wd', $params->get('layout', 'gallery'));
	else
require JModuleHelper::getLayoutPath('mod_gallery_wd', $params->get('layout', 'album'));
	

  

  
  