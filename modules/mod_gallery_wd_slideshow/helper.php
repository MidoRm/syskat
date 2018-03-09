<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 

defined('_JEXEC') or die('Restricted access');


class Modgallery_wdSlideShowHelper
{
	
 public static function get_options_row_data_slide() {
     $db =JFactory::getDBO();
	 $query="SELECT * FROM #__bwg_option WHERE id=1";
	 $db->setQuery($query);
	$row = $db->loadObject();
	return $row;
  }
   
   public static function get_theme_row_data_slide($id) {
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
 
 
 	public static function array_to_url_slide($array)
	{
	$url='index.php?option=com_gallery_wd&';
	foreach($array as $key=>$params_value)
	{
	$url.=$key.'='.$params_value.'&';
	}
	
	return (substr($url,0,-1));
	}
	
	 public static function get_gallery_row_data_slide($id) {
     $db =JFactory::getDBO(); 
	 $query="SELECT * FROM #__bwg_gallery WHERE published=1 AND id=".$db->escape($id);
	 $db->setQuery($query);
     $row = $db->loadObject();

    return $row;
  }

  public static function get_image_rows_data_slide($id, $images_per_page, $sort_by, $bwg, $type='') {
     $db =JFactory::getDBO();   
	 if ($sort_by == 'size' || $sort_by == 'resolution') {
      $sort_by = ' CAST(' . $sort_by . ' AS SIGNED) ';
    }
    elseif (($sort_by != 'alt') && ($sort_by != 'date') && ($sort_by != 'filetype')) {
      $sort_by = '`order`';
    }
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
 
}
