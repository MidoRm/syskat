<?php

defined( '_JEXEC' ) or die( 'Restricted access' );
 if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
/**
*
* @package RealEstateManger
* @copyright 2016 Andrey Kvasnevskiy-OrdaSoft(akbet@mail.ru); Rob de Cleen(rob@decleen.com)
* Homepage: http://www.ordasoft.com
* @version: 2.3.1 Pro
*
**/

$path = JPATH_BASE.'/components/com_realestatemanager/functions.php';
if (!file_exists($path)){
    echo "To display the featured house You have to install RealEstateManager first<br />"; exit;
} else{
    require_once($path);
}
$database = JFactory::getDBO();
$doc = JFactory::getDocument();
$doc->addStyleSheet(JURI::base(true).'/components/com_realestatemanager/includes/realestatemanager.css');
$menu = new JSite;
$menu->getMenu();
require_once ( JPATH_BASE .'/components/com_realestatemanager/functions.php' );
$mosConfig_absolute_path = $GLOBALS['mosConfig_absolute_path'] = JPATH_SITE;
global $realestatemanager_configuration;


$database = JFactory::getDBO();


  // load language
  $languagelocale = "";
  $query = "SELECT l.title, l.lang_code, l.sef "
          . "FROM #__rem_const_languages as cl "
          . "LEFT JOIN #__rem_languages AS l ON cl.fk_languagesid=l.id "
          . "LEFT JOIN #__rem_const AS c ON cl.fk_constid=c.id "
          . "GROUP BY  l.title";
  $database->setQuery($query);
  $languages = $database->loadObjectList();
  
  $lang = JFactory::getLanguage();
  foreach ($languages as $language) {
      if ($lang->getTag() == $language->lang_code) {
          $mosConfig_lang = $language->lang_code;
          $languagelocale = $language->lang_code;
          break;
      }
  }
  
  if ($languagelocale == '') {
    foreach ($lang->getLocale() as $locale) {
        foreach ($languages as $language) {
            if (strtolower($locale) == strtolower($language->title) 
                || strtolower($locale) == strtolower($language->lang_code) 
                || strtolower($locale) == strtolower($language->sef) ) {
                $mosConfig_lang = $locale;
                $languagelocale = $language->lang_code;
                break;
            }
        }
    } 
  }
  
  
  if (isset($_REQUEST['option']) && $_REQUEST['option'] == 'com_installer')
      $languagelocale = "en-GB";
  
  if ($languagelocale == '')
      $languagelocale = "en-GB";
   
  
  $query = "SELECT c.const, cl.value_const ";
  $query .= "FROM #__rem_const_languages as cl ";
  $query .= "LEFT JOIN #__rem_languages AS l ON cl.fk_languagesid=l.id ";
  $query .= "LEFT JOIN #__rem_const AS c ON cl.fk_constid=c.id ";
  $query .= "WHERE l.lang_code = '$languagelocale'";

  $database->setQuery($query);
  $langConst = $database->loadObjectList();

        
  foreach ($langConst as $item) {
      defined($item->const) or define($item->const, $item->value_const);
  }


  $query = "SELECT l.lang_code "
          . "FROM #__languages as l " ;
  $database->setQuery($query);
  $languages = $database->loadObjectList();

 global $langContent;
 foreach ($lang->getLocale() as $locale) {

      foreach ($languages as $language) {


          if (strtolower($locale) == strtolower($language->lang_code)
              || strtolower(str_replace(array('_','-'), '', $locale)) 
              == strtolower((str_replace(array('_','-'), '', $language->lang_code)))
              
              ) {

              $langContent = $language->lang_code;


              break;
          }
      }
  }

//Common parameters
$show_image = $params->get('image');
$image_height = $params->get('image_height');
$image_width = $params->get('image_width');
$show_hits = $params->get('hits');
$price = $params->get('price', 0);
$status = $params->get('status', 0);
$location = $params->get('location', 0 );
$featured_clicks = $params->get('featured_clicks', 0);
$features = $params->get('features', 0);
$description = $params->get('description', 0);
$view_listing = $params->get('view_listing', 0);
$categories = $params->get('categories', 0);
//Individual parameters
$count = intval($params->get('count',1));
$cat_id = $params->get('cat_id',0);
$house_id = $params->get('house_id',0);
$id = JRequest::getString('id');
//Display type
$displaytype = $params->get('displaytype', 0);
//Advanced parameters
$class_suffix = $params->get('moduleclass_sfx', 1);
$Itemid_from_params = $params->get('Itemid');
$g_words = $params->get('words','');
$sortnewby  = $params->get ('sortnewby', 0);
$image_source_type = $params->get('image_source_type');
//realestate

if (!function_exists('searchPicture_rem')){
function searchPicture_rem ($image_source_type,$imageURL){
			
	global $realestatemanager_configuration;
	
            switch ($image_source_type) {
                case "0": $img_height = $realestatemanager_configuration['fotomain']['high'];
                    $img_width = $realestatemanager_configuration['fotomain']['width'];
                    break;
                case "1": $img_height = $realestatemanager_configuration['foto']['high'];
                    $img_width = $realestatemanager_configuration['foto']['width'];
                    break;
                case "2": $img_height = $realestatemanager_configuration['fotogallery']['high'];
                    $img_width = $realestatemanager_configuration['fotogallery']['width'];
                    break;					
                default:$img_height = $realestatemanager_configuration['fotomain']['high'];
                    $img_width = $realestatemanager_configuration['fotomain']['width'];
                    break;
            }
			 
            $imageURL1 = rem_picture_thumbnail($imageURL,$img_width , $img_height);			
												
            $imageURL = "/components/com_realestatemanager/photos/" . $imageURL1;
            return $imageURL;
            
    }  
}

switch($sortnewby) {
case 0:
    $sql_orderby_query = "id"; 
    $sql_where_query =  "";  // Last Added
    break;
case 2:
    $sql_orderby_query  = "hits";     // Top (most popular)
    $sql_where_query = "";
    break;
case 3:
    $sql_orderby_query = "rand()"; // Random
    $sql_where_query = "";
break;
case 4:
    $sql_orderby_query = "rand()"; // Top (most popular)
    $sql_where_query = "";
    $similar = '';
    break;
}

if (isset($langContent)){
    // $lang = $langContent;
    // $query = "SELECT lang_code FROM #__languages WHERE sef = '$lang'";
    // $database->setQuery($query);
    // $lang = $database->loadResult();
    $lang = " and (h.language like 'all' or h.language like '' or h.language like '*' or h.language is null or h.language like '$langContent')
            AND (c.language like 'all' or c.language like '' or c.language like '*' or c.language is null or c.language like '$langContent') ";
}else{
    $lang = "";
}

$database->SetQuery("SELECT id  FROM #__menu WHERE menutype like '%menu%' AND link LIKE " . 
    "'%option=com_realestatemanager%' AND params LIKE '%back_button%' ");
$Itemid_from_db = $database->loadResult();
if ($Itemid_from_params!=''){
    $Itemid = $Itemid_from_params;
} else{
    $Itemid = $Itemid_from_db;
}

$sql_published = "published = 1";

$s = getWhereUsergroupsCondition("c");

$cat_sel = "";
$house_ids = "";
if ($cat_id != 0){
    $cat_sel = " AND c.id IN (".$cat_id.")";
} else {
    if ($house_id != 0){
        $house_ids = " AND h.id IN (".$house_id.")";
    } 
}

if ($cat_id != 0 && $house_id != 0){
  echo ('<font color="#CC0000">You input IDs of categories and houses together! Correct this mistake.</font>');
}

?>

<noscript>Javascript is required to use
 Real Estate Manager <a href="http://ordasoft.com/Real-Estate-Manager-Software-Joomla.html">
Real estate manager Joomla extension for Real Estate Brokers, Real Estate Companies and 
other Enterprises selling Real estate
</a>, <a href="http://ordasoft.com/Real-Estate-Manager-Software-Joomla.html">
Real Estate Manager create own real estate web portal for sell, rent,  buy real 
estate and property</a></noscript>
<?php



if(isset($similar) ){

    
if($id == '') return;


    $query = "SELECT h.htitle, h.id, h.image_link, h.hits,  c.id AS catid, ".
          " c.title AS cattitle, h.price, h.published, h.priceunit, ".
          "  h.hlocation, h.featured_clicks, h.featured_shows, h.rooms, ".
          " h.year, h.bedrooms, h.house_size, h.description, h.listing_type".

            ' FROM #__rem_houses AS h, #__rem_main_categories AS c , #__rem_categories AS vc ' .
            ' WHERE h.id <> '.(int) $id." and c.section='com_realestatemanager' ".
              " AND c.published='1' ".
              " AND vc.iditem=h.id ".
              " AND vc.idcat = c.id ".
              " AND h.published='1' ".
              $lang .
              " AND h.approved='1' " ;
        $query_flag = true;

        if($params->get('optBedrooms')==0)    $query .= ' and h.bedrooms =(select bedrooms from #__rem_houses t where t.id = '.(int) $id . ')';
        if($params->get('optCategory')==0) $query .= ' and vc.idcat in (select idcat from #__rem_categories t2 where t2.iditem = '.(int) $id . ')';
        if($params->get('optCity')==0) $query .= ' and h.hcity =(select hcity from #__rem_houses t3 where t3.id = '.(int) $id . ')';



    
}
else
{

        $query = "SELECT h.htitle, h.id, h.image_link, h.hits,  c.id AS catid, ".
      " c.title AS cattitle, h.price, h.published, h.priceunit, ".
      "  h.hlocation, h.featured_clicks, h.featured_shows, h.rooms, ".
      " h.year, h.bedrooms, h.house_size, h.description, h.listing_type
      
            \n FROM #__rem_houses AS h
            \n LEFT JOIN #__rem_categories AS hc ON hc.iditem=h.id
            \n LEFT JOIN #__rem_main_categories AS c ON c.id=hc.idcat
            \n WHERE (" . $s . ") $lang " . $sql_where_query . "";


    $query_flag = true;
    if ((isset($count) AND $count > 0) AND $cat_sel == "" AND $sql_published == "" AND $house_ids != "") {
        $house_ids = " AND " . $house_ids;
    } elseif ((isset($count) AND $count > 0) AND $cat_sel == "" AND $sql_published != "" AND $house_ids != "") {
        $query.= " AND c." . $sql_published . " AND h." . $sql_published;
    } elseif ((isset($count) AND $count > 0) AND $cat_sel != "" AND $sql_published == "" AND $house_ids == "") {
        $cat_sel = " AND " . $cat_sel;
    } elseif ((isset($count) AND $count > 0) AND $cat_sel != "" AND $sql_published != "" AND $house_ids == "") {
        $query.= " AND c." . $sql_published . " AND h." . $sql_published;
    } elseif ((isset($count) AND $count > 0) AND $cat_sel == "" AND $sql_published != "" AND $house_ids == "") {
        $query.= " AND c." . $sql_published . " AND h." . $sql_published;
    }

}


$query .= $cat_sel.$house_ids." AND h.approved=1 GROUP BY h.id ORDER BY ".$sql_orderby_query." DESC LIMIT 0 , ".$count.";";  
        
if ($query_flag){
    $database->setQuery($query);
    $houses= $database->loadObjectList();
}

if($houses!=="" && $houses!==Null && count($houses)>0){
  require JModuleHelper::getLayoutPath('mod_realestatemanager_featured_free_j3', $params->get('layout'));
}

?>
