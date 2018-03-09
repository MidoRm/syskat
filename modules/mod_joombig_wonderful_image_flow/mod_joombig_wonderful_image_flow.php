<?php
/**
* @title		joombig wonderful image flow
* @website		http://www.joombig.com
* @copyright	Copyright (C) 2014 joombig.com. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/
    // no direct access
    defined('_JEXEC') or die('Restricted access');
	$mosConfig_absolute_path = JPATH_SITE;
	$mosConfig_live_site = JURI :: base();
	if(substr($mosConfig_live_site, -1)=="/") { $mosConfig_live_site = substr($mosConfig_live_site, 0, -1); }

    $module_name             = basename(dirname(__FILE__));
    $module_dir              = dirname(__FILE__);
    $module_id               = $module->id;
    $document                = JFactory::getDocument();
    $style                   = $params->get('sp_style');

    if( empty($style) )
    {
        JFactory::getApplication()->enqueueMessage( 'Slider style no declared. Check joombig wonderful image flow configuration and save again from admin panel' , 'error');
        return;
    }

    $layoutoverwritepath     = JURI::base(true) . '/templates/'.$document->template.'/html/'. $module_name. '/tmpl/'.$style;
    $document                = JFactory::getDocument();
    require_once $module_dir.'/helper.php';
    $helper = new mod_Wonderfulimageflow($params, $module_id);
    $data = (array) $helper->display();
	$enable_jQuery				= $params->get('enable_jQuery', 1);
	$width_module				= $params->get('width_module', "930");
	$height_module 				= $params->get('height_module', "360");
	$left_module 				= $params->get('left_module', "0");
	$width_image				= $params->get('width_image','400');
	$height_image				= $params->get('height_image','300');
	$top_module					= $params->get('top_module','150');
	
	$screen_width1				= $params->get('screen_width1',"0");
	$width_module1				= $params->get('width_module1',"0");
	$height_module1				= $params->get('height_module1',"0");
	$width_image1				= $params->get('width_image1',"0");
	$height_image1				= $params->get('height_image1',"0");
	
	$screen_width2				= $params->get('screen_width2',"0");
	$width_module2				= $params->get('width_module2',"0");
	$height_module2				= $params->get('height_module2',"0");
	$width_image2				= $params->get('width_image2',"0");
	$height_image2				= $params->get('height_image2',"0");
	
	$screen_width3				= $params->get('screen_width3',"0");
	$width_module3				= $params->get('width_module3',"0");
	$height_module3				= $params->get('height_module3',"0");
	$width_image3				= $params->get('width_image3',"0");
	$height_image3				= $params->get('height_image3',"0");
	
	$screen_width4				= $params->get('screen_width4',"0");
	$width_module4				= $params->get('width_module4',"0");
	$height_module4				= $params->get('height_module4',"0");
	$width_image4				= $params->get('width_image4',"0");
	$height_image4				= $params->get('height_image4',"0");
	
	$screen_width5				= $params->get('screen_width5',"0");
	$width_module5				= $params->get('width_module5',"0");
	$height_module5				= $params->get('height_module5',"0");
	$width_image5				= $params->get('width_image5',"0");
	$height_image5				= $params->get('height_image5',"0");
    //$option = (array) $params->get('animation')->$style;
    if(  is_array( $helper->error() )  )
    {
        JFactory::getApplication()->enqueueMessage( implode('<br /><br />', $helper->error()) , 'error');
    } else {
        if( file_exists($layoutoverwritepath.'/view.php') )
        {
            require(JModuleHelper::getLayoutPath($module_name, $layoutoverwritepath.'/view.php') );   
        } else {
            require(JModuleHelper::getLayoutPath($module_name, $style.'/view') );   
        }

        $helper->setAssets($document, $style);
}