<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');


class Modgallery_wdHelper
{
	
   public static function page_nav_gal_alb($id, $images_per_page, $bwg, $type='') {
     $db =JFactory::getDBO();  
	if ($type == 'tag') {
      $query = 'SELECT COUNT(*) FROM #__bwg_image as image INNER JOIN #__bwg_image_tag as tag ON image.id=tag.image_id WHERE image.published=1 AND tag.tag_id='.$db->escape($id) ;
    }
	else
	{
    $query="SELECT COUNT(*) FROM #__bwg_image WHERE published=1 AND gallery_id=".$db->escape($id) ;
	}
	$db->setQuery($query);
	$total = $db->loadResult();
    $page_nav['total'] = $total;
    if (isset($_POST['page_number_' . $bwg]) && $_POST['page_number_' . $bwg]) {
      $limit = ((int) $_POST['page_number_' . $bwg] - 1) * $images_per_page;
    }
    else {
      $limit = 0;
    }
    if ($images_per_page) {
      $page_nav['limit'] = (int) ($limit / $images_per_page + 1);
    }
    return $page_nav;
  }
 
  public static function album_page_nav_gal_alb($id, $albums_per_page, $bwg) {
    $db =JFactory::getDBO(); 
	$query="SELECT COUNT(*) FROM #__bwg_album_gallery LEFT JOIN #__bwg_gallery ON #__bwg_album_gallery.alb_gal_id=#__bwg_gallery.id
	WHERE  album_id=".$db->escape($id)." AND published=1";
	$db->setQuery($query);
	$total=$db->loadResult();
    $page_nav['total'] = $total;
    if (isset($_POST['page_number_' . $bwg]) && $_POST['page_number_' . $bwg]) {
      $limit = ((int) $_POST['page_number_' . $bwg] - 1) * $albums_per_page;
    }
    else {
      $limit = 0;
    }
    if ($albums_per_page) {
      $page_nav['limit'] = (int) ($limit / $albums_per_page + 1);
    }
    return $page_nav;
  }
 
    public static function get_options_row_data_gal_alb() {
     $db =JFactory::getDBO();
	 $query="SELECT * FROM #__bwg_option WHERE id=1";
	 $db->setQuery($query);
	$row = $db->loadObject();
	return $row;
  }
   
   public static function get_theme_row_data_gal_alb($id) {
	$db =JFactory::getDBO();
	   if ($id) {
	$query="SELECT * FROM #__bwg_theme WHERE id=".$db->escape($id);
	}
	else
	{
	$query="SELECT * FROM #__bwg_theme WHERE default_theme=1";

	}
	$db->setQuery($query);
    $row = $db->loadObject();
    return $row;
  }
 
 
 	public static function array_to_url_gal_alb($array)
	{
	$url='index.php?option=com_gallery_wd&';
	foreach($array as $key=>$params_value)
	{
	$url.=$key.'='.$params_value.'&';
	}
	
	return (substr($url,0,-1));
	}
	
	 public static function get_gallery_row_data_gal_alb($id) {
     $db =JFactory::getDBO(); 
	 $query="SELECT * FROM #__bwg_gallery WHERE published=1 AND id=".$db->escape($id);
	 $db->setQuery($query);
     $row = $db->loadObject();

    return $row;
  }

  public static function get_image_rows_data_gal_alb($id, $images_per_page, $sort_by, $bwg, $type='') {
     $db =JFactory::getDBO();   

    if (isset($_POST['page_number_' . $bwg]) && $_POST['page_number_' . $bwg]) {
      $limit = ((int) $_POST['page_number_' . $bwg] - 1) * $images_per_page;
    }
    else {
      $limit = 0;
    }
    if ($images_per_page) {
      $limit_str = 'LIMIT ' . $limit . ',' . $images_per_page;
    }
    else {
      $limit_str = '';
    }
	
	
	if($type == 'tag') {
      $query = 'SELECT image.* FROM #__bwg_image as image INNER JOIN #__bwg_image_tag as tag ON image.id=tag.image_id WHERE image.published=1 AND tag.tag_id='.$db->escape($id).' ORDER BY ' . $sort_by . ' ASC';      
    }
	else
	{
	$query='SELECT * FROM #__bwg_image WHERE published=1 AND gallery_id='.$db->escape($id).' ORDER BY ' . $sort_by . ' ASC ' . $limit_str;
	}
	

	$db->setQuery($query);
    $row = $db->loadObjectList();
    return $row;
  }
  
  
   public static function get_alb_gals_row_gal_alb($id, $albums_per_page, $sort_by, $bwg) {
     $db =JFactory::getDBO(); 
    if (isset($_POST['page_number_' . $bwg]) && $_POST['page_number_' . $bwg]) {
      $limit = ((int) $_POST['page_number_' . $bwg] - 1) * $albums_per_page;
    }
    else {
      $limit = 0;
    }
    if ($albums_per_page) {
      $limit_str = 'LIMIT ' . $limit . ',' . $albums_per_page;
    }
    else {
      $limit_str = '';
    }
$query='SELECT #__bwg_album_gallery.*,#__bwg_gallery.published as published FROM #__bwg_album_gallery 
LEFT JOIN #__bwg_gallery ON #__bwg_album_gallery.alb_gal_id=#__bwg_gallery.id

	 WHERE album_id='.$db->escape($id).' ORDER BY ' . ($sort_by == "RAND()" ? '' : '`') . $sort_by . ($sort_by == "RAND()" ? '' : '`') . ' ASC ' . $limit_str;    $db->setQuery($query);
	$row = $db->loadObjectList();
    return $row;
  }
  
  
     public static function get_album_row_data_gal_alb($id) {
     $db =JFactory::getDBO(); 
	 
	 $query="SELECT * FROM #__bwg_album WHERE published=1 AND id=".$db->escape($id);
	 $db->setQuery($query);
    $row =$db->loadObject();
    //$row->permalink = $this->bwg_create_post($row->name, $row->slug, "album", $id);
    return $row;
  }
  
  
public static  function bgw_url_encode_gal_alb($url)
{
$url=str_replace(':','bwg_dots',$url);
$url=str_replace('/','bwg_slash',$url);
$url=str_replace('=','bwg_equal',$url);
$url=str_replace('&','bwg_amp',$url);
$url=str_replace('#','bwg_sharp',$url);
$url=str_replace('?','bwg_quest',$url);
return $url;

}

public static function bgw_url_decode_gal_alb($url)
{
$url=str_replace('bwg_dots',':',$url);
$url=str_replace('bwg_slash','/',$url);
$url=str_replace('bwg_equal','=',$url);
$url=str_replace('bwg_amp','&',$url);
$url=str_replace('bwg_sharp','#',$url);
$url=str_replace('bwg_quest','?',$url);
return $url;

}
  
}
