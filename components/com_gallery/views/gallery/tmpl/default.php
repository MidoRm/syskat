<?php 
/**
 * @package Huge IT Image Gallery
 * @author Huge-IT
 * @copyright (C) 2014 Huge IT. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @website		http://www.huge-it.com/
 **/

defined('_JEXEC') or die('Restircted access');



require_once JPATH_SITE.'/components/com_gallery/helpers/helper.php';
$id = JRequest::getVar('gallery',   $this -> gallery_id , '', 'int');
$gallery_class = new GalleriesHelper;
$gallery_class->gallery_id = $id;
$gallery_class->type = 'component';
$gallery_class->module_id =  $this -> gallery_id ;
echo $gallery_class->render_html();
