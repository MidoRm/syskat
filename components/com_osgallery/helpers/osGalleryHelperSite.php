<?php
/**
* @package OS Gallery
* @copyright 2016 OrdaSoft
* @author 2016 Andrey Kvasnevskiy(akbet@mail.ru),Roman Akoev (akoevroman@gmail.com)
* @license GNU General Public License version 2 or later;
* @description Ordasoft Image Gallery
*/


// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class osGalleryHelperSite{

    static function displayView($galIds = array()){
        $db = JFactory::getDBO();
        $app = JFactory::getApplication();
        $input = $app->input;
        $menu = $app->getMenu()->getActive();
        $params = new JRegistry;
        $menuParams = new JRegistry;

        //include css
        $document = JFactory::getDocument();
        $document->addStyleSheet(JURI::base() . "components/com_osgallery/assets/css/os-gallery.css");
        $document->addStyleSheet(JURI::base() . "components/com_osgallery/assets/css/font-awesome.min.css");
        $document->addStyleSheet(JURI::base() . "components/com_osgallery/assets/libraries/fancybox/jquery.fancyboxGall.css");

        //js
        $document->addScript(JURI::base() . "components/com_osgallery/assets/libraries/jQuery/jQuerGall-2.2.4.js");
        $document->addScriptDeclaration("jQuerGall=jQuerGall.noConflict();");
        $document->addScript(JURI::base() . "components/com_osgallery/assets/libraries/fancybox/jquery.fancyboxGall.js");

        $menuParams = $menu->params;
        $itemId = $menu->id;
        if($galIds){
        }else{
            $galIds = $menuParams->get("gallery_list",array());
        }
        foreach ($galIds as $galId) {
            if($galId){
                //load params
                $query = "SELECT params FROM #__os_gallery WHERE id=$galId";
                $db->setQuery($query);
                $paramsString = $db->loadResult();
                if($paramsString){
                    $params->loadString($paramsString);
                }
            }

            if($galId){
                //getting Images
                $query = "SELECT gim.* , gc.fk_cat_id, cat.name as cat_name, gal.id as galId FROM #__os_gallery_img as gim ".
                        "\n LEFT JOIN #__os_gallery_connect as gc ON gim.id=gc.fk_gal_img_id".
                        "\n LEFT JOIN #__os_gallery_categories as cat ON cat.id=gc.fk_cat_id ".
                        "\n LEFT JOIN #__os_gallery as gal ON gal.id=cat.fk_gal_id ".
                        "\n WHERE cat.fk_gal_id =$galId AND gal.published".
                        "\n ORDER BY cat.ordering ASC";
                $db->setQuery($query);
                $result =$db->loadObjectList();
                if($result){
                    $images = array();
                    foreach ($result as $image) {
                        if(!isset($images[$image->fk_cat_id])){
                           $images[$image->fk_cat_id] = array();
                        }
                        $images[$image->fk_cat_id][] = $image;
                    }
                    //ordering images

                    foreach ($images as $key => $imageArr) {
                        usort($imageArr, "self::sortByOrdering");
                        $images[$key] = $imageArr;
                    }

                    //get cat params array
                    $query = "SELECT DISTINCT id,params FROM #__os_gallery_categories".
                            "\n WHERE fk_gal_id =$galId";
                    $db->setQuery($query);
                    $catParamsArray = $db->loadObjectList('id');

                    //get cat params array
                    $query = "SELECT DISTINCT galImg.id,galImg.params FROM #__os_gallery_img as galImg".
                            "\n LEFT JOIN #__os_gallery_connect as galCon ON galCon.fk_gal_img_id = galImg.id".
                            "\n LEFT JOIN #__os_gallery_categories as cat ON cat.id = galCon.fk_cat_id".
                            "\n WHERE cat.fk_gal_id =$galId";
                    $db->setQuery($query);
                    $imgParamsArray = $db->loadObjectList('id');
                }else{
                    $images = array();
                    $imgParamsArray = array("1"=>(object) array("params"=>'{}'));
                    $catParamsArray = array("1"=>(object) array("params"=>'{}'));
                }
            }else{
                $app->enqueueMessage("Select gallery for menu(".$itemId.").", 'error');
                return;
            }

            //setup some variables
            $click_close = $params->get("click_close",1);
            $fancybox_background = $params->get("fancy_box_background","");
            if($params->get("img_title") == 'none'){
                $fancybox_title = "title : null,";
            }else{
                $fancybox_title = "title : {type : '".$params->get("img_title")."'},";
            }

            $fancybox_background = "overlay : {locked: false,closeClick : ".$click_close.",css : {'background' : 'rgba(0, 0, 0, 0.75)'}}";

            $helper_buttons = '';
            if($params->get("helper_buttons")){
                $helper_buttons = ",buttons : {}";
            }
            $helper_thumbnail = '';
            if($params->get("helper_thumbnail")){
                $helper_thumbnail = ',thumbs : {width  : '.$params->get("thumbnail_width").
                                                ',height : '.$params->get("thumbnail_height").'}';
            }

            $open_close_effect = $params->get("open_close_effect","");
            $open_close_speed = $params->get("open_close_speed",500);
            $prev_next_effect = $params->get("prev_next_effect","");
            $prev_next_speed = $params->get("prev_next_speed",800);
            $loop = $params->get("loop",0);
            $fancybox_arrows = $params->get("fancybox_arrows",1);
            $fancybox_arrows_pos = $params->get("fancybox_arrows_pos",1);
            $close_button = $params->get("close_button",1);
            $next_click = $params->get("next_click",0);
            $mouse_wheel = $params->get("mouse_wheel",0);
            $fancybox_autoplay = $params->get("fancybox_autoplay",0);
            $autoplay_speed = $params->get("autoplay_speed",3000);
            $backText = $params->get("backButtonText",'back');
            $numColumns = $params->get("num_column",4);
            $minImgEnable = $params->get("minImgEnable",1);
            $minImgSize = $params->get("minImgSize",225);
            $imageMargin = $params->get("image_margin")/2;
            $imageHover = $params->get("imageHover", "dimas");
            $galleryLayout = $params->get("galleryLayout", "defaultTabs");

            require self::findView($galleryLayout);
        }
    }

    static function sortByOrdering($a,$b) {
        return $a->ordering>$b->ordering;
    }

    protected static function findView($view){
        $Path = JPATH_SITE . '/components/com_osgallery/views/'.$view.'/tmpl/default.php';

        if (file_exists($Path)){
          return $Path;
        } else {
          echo "Bad layout path to view->".$view.", please write to admin";
          exit;
        }
    }
}