<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 

defined('_JEXEC') or die('Restricted access');
 require_once JPATH_SITE.'/modules/mod_gallery_wd/helper.php';



	 $WD_BWG_DIR=JPATH_BASE.'/components/com_gallery_wd';
$WD_BWG_URL=JURI::root().'components/com_gallery_wd';	
  require_once($WD_BWG_DIR . '/framework/WDWLibrary.php');
$db		=JFactory::getDBO();
$query="SHOW TABLES LIKE '#__bwg_option'";
$db->setQuery($query);
 
 
 $db		=JFactory::getDBO();
$query="SHOW TABLES LIKE '#__bwg_option'";
$db->setQuery($query);


if ($db->query()) {

$query='SELECT images_directory FROM #__bwg_option WHERE id=1';
$db->setQuery($query);
$WD_BWG_UPLOAD_DIR=$db->loadResult() . '/com_gallery_wd/uploads';
}
else {
 
$WD_BWG_UPLOAD_DIR="administrator/components/com_gallery_wd/uploads";
}
	
$uri	= JFactory::getURI();
		$current_url=$uri->toString();
				$session = JFactory::getSession();
		$session->set('current_url',$current_url);
	
		
		
		
		 if (!isset($slide_params['image_title_show_hover'])) {
      $slide_params['image_title_show_hover'] = 'none';
    }

    if (!isset($slide_params['album_view_type'])) {
      $album_view_type = 'thumbnail';
    }
    else {
      $album_view_type = $slide_params['album_view_type'];
    } 
    if (!isset($slide_params['popup_fullscreen'])) {
      $slide_params['popup_fullscreen'] = 0;
    }
    if (!isset($slide_params['popup_autoplay'])) {
      $slide_params['popup_autoplay'] = 0;
    }
    if (!isset($slide_params['popup_enable_pinterest'])) {
      $slide_params['popup_enable_pinterest'] = 0;
    }
    if (!isset($slide_params['popup_enable_tumblr'])) {
      $slide_params['popup_enable_tumblr'] = 0;
    }
    if (!isset($slide_params['show_search_box'])) {
      $slide_params['show_search_box'] = 0;
    }
    if (!isset($slide_params['search_box_width'])) {
      $slide_params['search_box_width'] = 180;
    }
    if (!isset($slide_params['popup_enable_info'])) {
      $slide_params['popup_enable_info'] = 0;
    }
    if (!isset($slide_params['popup_info_always_show'])) {
      $slide_params['popup_info_always_show'] = 0;
    }
    if (!isset($slide_params['popup_enable_rate'])) {
      $slide_params['popup_enable_rate'] = 0;
    }
    if (!isset($slide_params['thumb_click_action']) || $slide_params['thumb_click_action'] == 'undefined') {
      $slide_params['thumb_click_action'] = 'open_lightbox';
    }
    if (!isset($slide_params['thumb_link_target'])) {
      $slide_params['thumb_link_target'] = 1;
    }
    if (!isset($slide_params['popup_hit_counter'])) {
      $slide_params['popup_hit_counter'] = 0;
    }
    if (!isset($slide_params['order_by'])) {
      $slide_params['order_by'] = ' ASC ';
    }
	 $slide_params['show_search_box'] = 0;
	
	$from = (isset($slide_params['from']) ? htmlspecialchars($slide_params['from']) : 0);
    $type = (isset($_POST['type_' . $bwg]) ? htmlspecialchars($_POST['type_' . $bwg]) : (isset($slide_params['type']) ? $slide_params['type'] : 'album'));


    if ($from === "module") {
      $options_row = Modgallery_wdHelper::get_options_row_data_gal_alb();
      $slide_params['id'] = $slide_params['id'];
      $slide_params['sort_by'] = $slide_params['show'] == 'random' ? 'RAND()' : 'order';
      $slide_params['albums_per_page'] = $slide_params['count'];
      $slide_params['album_column_number'] = $options_row->album_column_number;
      $slide_params['album_thumb_height'] = $slide_params['height'];
      $slide_params['album_thumb_width'] = $slide_params['width'];
      $slide_params['album_title_show_hover'] = $options_row->album_title_show_hover;
      $slide_params['album_enable_page'] = 0;  
      $slide_params['image_title_show_hover'] = $options_row->image_title_show_hover;
	$slide_params['thumb_width']=$options_row->thumb_width;
      $slide_params['thumb_height']=$options_row->thumb_height;
     $slide_params['popup_fullscreen']=$options_row->popup_fullscreen;
      $slide_params['popup_autoplay']=$options_row->popup_autoplay;
     $slide_params['popup_width']=$options_row->popup_width;
      $slide_params['popup_height']=$options_row->popup_height;
      $slide_params['popup_type']=$options_row->popup_type;

      $slide_params['popup_enable_filmstrip']=$options_row->popup_enable_filmstrip;
      $slide_params['popup_filmstrip_height']=$options_row->popup_filmstrip_height;
      $slide_params['popup_enable_ctrl_btn']=$options_row->popup_enable_ctrl_btn;
       $slide_params['popup_enable_fullscreen']=$options_row->popup_enable_fullscreen;
      $slide_params['popup_enable_info']=$options_row->popup_enable_info;
      $slide_params['popup_info_always_show']=$options_row->popup_info_always_show;
       $slide_params['popup_hit_counter']=$options_row->popup_hit_counter;
      $slide_params['popup_enable_rate']=$options_row->popup_enable_rate;
       $slide_params['popup_interval']=$options_row->popup_interval;
      $slide_params['popup_enable_comment']=$options_row->popup_enable_comment;
      $slide_params['popup_enable_facebook']=$options_row->popup_enable_facebook;
       $slide_params['popup_enable_twitter']=$options_row->popup_enable_twitter;
      $slide_params['popup_enable_google']=$options_row->popup_enable_google;
       $slide_params['popup_enable_pinterest']=$options_row->popup_enable_pinterest;
      $slide_params['popup_enable_tumblr']=$options_row->popup_enable_tumblr;
      $slide_params['watermark_type']=$options_row->watermark_type;	  
	  
    }

    $theme_row = Modgallery_wdHelper::get_theme_row_data_gal_alb($slide_params['theme_id']);
    if (!$theme_row) {
      echo WDWLibrary::message(JText::_('THERE_IS_NO_THEME'), 'error');
      return;
    }
    $album_gallery_id = (isset($_POST['album_gallery_id_' . $bwg]) ? htmlspecialchars($_POST['album_gallery_id_' . $bwg]) : $slide_params['id']);
    if (!$album_gallery_id) {
      echo WDWLibrary::message(JText::_('THERE_IS_NO_ALBUM'), 'error');
      return;
    }
    if ($type == 'gallery') {

      $items_per_page = $options_row->images_per_page;
      $items_col_num = $options_row->image_column_number;
      $image_rows = Modgallery_wdHelper::get_image_rows_data_gal_alb($album_gallery_id, $items_per_page, $slide_params['sort_by'], $bwg);
	  $images_count=count($image_rows);
      $page_nav = Modgallery_wdHelper::album_page_nav_gal_alb($album_gallery_id, $items_per_page, $bwg);
      $album_gallery_div_id = 'bwg_album_compact_' . $bwg;
      $album_gallery_div_class = 'bwg_standart_thumbnails_' . $bwg;
    }
    else {
      $items_per_page = $slide_params['count'];
      $items_col_num = $options_row->album_column_number;
      $album_galleries_row = Modgallery_wdHelper::get_alb_gals_row_gal_alb($album_gallery_id, $items_per_page, $slide_params['sort_by'], $bwg);
       $page_nav = Modgallery_wdHelper::album_page_nav_gal_alb($album_gallery_id, $items_per_page, $bwg);
      $album_gallery_div_id = 'bwg_album_compact_' . $bwg;
      $album_gallery_div_class = 'bwg_album_thumbnails_' . $bwg;
    }
    $bwg_previous_album_id = (isset($_POST['bwg_previous_album_id_' . $bwg]) ? htmlspecialchars($_POST['bwg_previous_album_id_' . $bwg]) : 0);
    $bwg_previous_album_page_number = (isset($_POST['bwg_previous_album_page_number_' . $bwg]) ? htmlspecialchars($_POST['bwg_previous_album_page_number_' . $bwg]) : 0);

    $rgb_page_nav_font_color = WDWLibrary::spider_hex2rgb($theme_row->page_nav_font_color);
    $rgb_album_compact_thumbs_bg_color = WDWLibrary::spider_hex2rgb($theme_row->album_compact_thumbs_bg_color);
    $rgb_thumbs_bg_color = WDWLibrary::spider_hex2rgb($theme_row->thumbs_bg_color);
	
	    if ($type == 'gallery' ) {
      if($album_view_type == 'masonry') {
          $form_child_div_style = 'background-color:rgba(0, 0, 0, 0); position:relative; text-align:' . $theme_row->masonry_thumb_align . '; width:100%;';
          $form_child_div_id = 'bwg_masonry_thumbnails_div_' . $bwg;
        $album_gallery_div_id = 'bwg_masonry_thumbnails_' . $bwg;
          $album_gallery_div_class = 'bwg_masonry_thumbnails_' . $bwg;		
      }
      else { 
        $form_child_div_style = 'background-color:rgba(0, 0, 0, 0); position:relative; text-align:' . $theme_row->thumb_align . '; width:100%;';
      $form_child_div_id = '';
      }
    }
    else {
      $form_child_div_id = '';
      $form_child_div_style = 'background-color:rgba(0, 0, 0, 0); position:relative; text-align:' . $theme_row->album_compact_thumb_align . '; width:100%;';
    }
	
	
	
		///////////////////////////////////////////////////////
	$slide_params_array = array(
      'view' => 'GalleryBox',
      'current_view' => $bwg,
      'theme_id' => $slide_params['theme_id'],
      'thumb_width' => $slide_params['thumb_width'],
      'thumb_height' => $slide_params['thumb_height'],
      'open_with_fullscreen' => $slide_params['popup_fullscreen'],
      'open_with_autoplay' => $slide_params['popup_autoplay'],
      'image_width' => $slide_params['popup_width'],
      'image_height' => $slide_params['popup_height'],
      'image_effect' => $slide_params['popup_type'],
      'sort_by' => $slide_params['sort_by'],
      'enable_image_filmstrip' => $slide_params['popup_enable_filmstrip'],
      'image_filmstrip_height' => $slide_params['popup_filmstrip_height'],
      'enable_image_ctrl_btn' => $slide_params['popup_enable_ctrl_btn'],
      'enable_image_fullscreen' => $slide_params['popup_enable_fullscreen'],
      'popup_enable_info' => $slide_params['popup_enable_info'],
      'popup_info_always_show' => $slide_params['popup_info_always_show'],
      'popup_hit_counter' => $slide_params['popup_hit_counter'],
      'popup_enable_rate' => $slide_params['popup_enable_rate'],
      'slideshow_interval' => $slide_params['popup_interval'],
      'enable_comment_social' => $slide_params['popup_enable_comment'],
      'enable_image_facebook' => $slide_params['popup_enable_facebook'],
      'enable_image_twitter' => $slide_params['popup_enable_twitter'],
      'enable_image_google' => $slide_params['popup_enable_google'],
      'enable_image_pinterest' => $slide_params['popup_enable_pinterest'],
      'enable_image_tumblr' => $slide_params['popup_enable_tumblr'],
      'watermark_type' => $slide_params['watermark_type'],
      'current_url' => Modgallery_wdHelper::bgw_url_encode_gal_alb($current_url)
    );

    if ($slide_params['watermark_type'] != 'none') {
	if(isset($slide_params['watermark_link']))
	{
      $slide_params_array['watermark_link'] = $slide_params['watermark_link'];
      $slide_params_array['watermark_opacity'] = $slide_params['watermark_opacity'];
      $slide_params_array['watermark_position'] = $slide_params['watermark_position'];
   }
   }
    if ($slide_params['watermark_type'] == 'text') {
	if(isset($slide_params['watermark_text']))
	{
      $slide_params_array['watermark_text'] = $slide_params['watermark_text'];
      $slide_params_array['watermark_font_size'] = $slide_params['watermark_font_size'];
      $slide_params_array['watermark_font'] = $slide_params['watermark_font'];
      $slide_params_array['watermark_color'] = $slide_params['watermark_color'];
	  }
    }
    elseif ($slide_params['watermark_type'] == 'image') {
	if(isset($slide_params['watermark_url']))
	{
      $slide_params_array['watermark_url'] = $slide_params['watermark_url'];
      $slide_params_array['watermark_width'] = $slide_params['watermark_width'];
      $slide_params_array['watermark_height'] = $slide_params['watermark_height'];
	 } 
    }
    $slide_params_array_hash = $slide_params_array;

	
	
    ?>
   <style>
      /* Style for masonry view.*/
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_masonry_thumbnails_<?php echo $bwg; ?> * {
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_masonry_thumb_<?php echo $bwg; ?> {
        visibility: hidden;
        text-align: center;
        display: inline-block;
        vertical-align: middle;     
        width: <?php echo $slide_params['thumb_width']; ?>px !important;
        border-radius: <?php echo $theme_row->masonry_thumb_border_radius; ?>;
        border: <?php echo $theme_row->masonry_thumb_border_width; ?>px <?php echo $theme_row->masonry_thumb_border_style; ?> #<?php echo $theme_row->masonry_thumb_border_color; ?>;
        background-color: #<?php echo $theme_row->thumb_bg_color; ?>;
        margin: 0;
        padding: <?php echo $theme_row->masonry_thumb_padding; ?>px !important;
        opacity: <?php echo $theme_row->masonry_thumb_transparent / 100; ?>;
        filter: Alpha(opacity=<?php echo $theme_row->masonry_thumb_transparent; ?>);
        <?php echo ($theme_row->masonry_thumb_transition) ? 'transition: all 0.3s ease 0s;-webkit-transition: all 0.3s ease 0s;' : ''; ?>
        z-index: 100;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_masonry_thumb_<?php echo $bwg; ?>:hover {
        opacity: 1;
        filter: Alpha(opacity=100);
        transform: <?php echo $theme_row->masonry_thumb_hover_effect; ?>(<?php echo $theme_row->masonry_thumb_hover_effect_value; ?>);
        -ms-transform: <?php echo $theme_row->masonry_thumb_hover_effect; ?>(<?php echo $theme_row->masonry_thumb_hover_effect_value; ?>);
        -webkit-transform: <?php echo $theme_row->masonry_thumb_hover_effect; ?>(<?php echo $theme_row->masonry_thumb_hover_effect_value; ?>);
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
        -moz-backface-visibility: hidden;
        -ms-backface-visibility: hidden;
        z-index: 102;
        position: absolute;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_masonry_thumbnails_<?php echo $bwg; ?> {
        -moz-box-sizing: border-box;
        background-color: rgba(<?php echo $rgb_thumbs_bg_color['red']; ?>, <?php echo $rgb_thumbs_bg_color['green']; ?>, <?php echo $rgb_thumbs_bg_color['blue']; ?>, <?php echo $theme_row->masonry_thumb_bg_transparent / 100; ?>);
        box-sizing: border-box;
        display: inline-block;
        font-size: 0;
        /*width: <?php echo $slide_params['compuct_album_image_column_number'] * ($slide_params['thumb_width'] + 2 * ($theme_row->masonry_thumb_padding + $theme_row->masonry_thumb_border_width)); ?>px;*/
        width: 100%;
        position: relative;
        text-align: <?php echo $theme_row->masonry_thumb_align; ?>;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_masonry_thumbnails_<?php echo $bwg; ?> a {
        cursor: pointer;
        text-decoration: none;
      }
      @media only screen and (max-width : <?php echo $slide_params['compuct_album_image_column_number'] * ($slide_params['thumb_width'] + 2 * ($theme_row->masonry_thumb_padding + $theme_row->masonry_thumb_border_width)); ?>px) {
        #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_masonry_thumbnails_<?php echo $bwg; ?> {
          width: inherit;
        }
      }	  	  
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> #spider_popup_overlay_<?php echo $bwg; ?> {
        background-color: #<?php echo $theme_row->lightbox_overlay_bg_color; ?>;
        opacity: <?php echo $theme_row->lightbox_overlay_bg_transparent / 100; ?>;
        filter: Alpha(opacity=<?php echo $theme_row->lightbox_overlay_bg_transparent; ?>);
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_masonry_thumb_spun_<?php echo $bwg; ?> {
        position: absolute;
      }
      /* Style for thumbnail view.*/
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_album_thumb_<?php echo $bwg; ?> {
        display: inline-block;
        text-align: center;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .<?php echo $album_gallery_div_class; ?> * {
        -moz-box-sizing: content-box;
        box-sizing: content-box;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_album_thumb_spun1_<?php echo $bwg; ?> {
        background-color: #<?php echo $theme_row->album_compact_thumb_bg_color; ?>;
        display: inline-block;
        height: <?php echo $slide_params['album_thumb_height']; ?>px;
        margin: <?php echo $theme_row->album_compact_thumb_margin; ?>px;
        opacity: <?php echo $theme_row->album_compact_thumb_transparent / 100; ?>;
        filter: Alpha(opacity=<?php echo $theme_row->album_compact_thumb_transparent; ?>);
        <?php echo ($theme_row->album_compact_thumb_transition) ? 'transition: all 0.3s ease 0s;-webkit-transition: all 0.3s ease 0s;' : ''; ?>
        padding: <?php echo $theme_row->album_compact_thumb_padding; ?>px;
        text-align: center;
        vertical-align: middle;
        width: <?php echo $slide_params['album_thumb_width']; ?>px;
        z-index: 100;
        -webkit-backface-visibility: visible;
        -ms-backface-visibility: visible;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_album_thumb_spun1_<?php echo $bwg; ?>:hover {
        opacity: 1;
        filter: Alpha(opacity=100);
        transform: <?php echo $theme_row->album_compact_thumb_hover_effect; ?>(<?php echo $theme_row->album_compact_thumb_hover_effect_value; ?>);
        -ms-transform: <?php echo $theme_row->album_compact_thumb_hover_effect; ?>(<?php echo $theme_row->album_compact_thumb_hover_effect_value; ?>);
        -webkit-transform: <?php echo $theme_row->album_compact_thumb_hover_effect; ?>(<?php echo $theme_row->album_compact_thumb_hover_effect_value; ?>);
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
        -moz-backface-visibility: hidden;
        -ms-backface-visibility: hidden;
        z-index: 102;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_album_thumb_spun2_<?php echo $bwg; ?> {
        border-radius: <?php echo $theme_row->album_compact_thumb_border_radius; ?>;
        border: <?php echo $theme_row->album_compact_thumb_border_width; ?>px <?php echo $theme_row->album_compact_thumb_border_style; ?> #<?php echo $theme_row->album_compact_thumb_border_color; ?>;
        box-shadow: <?php echo $theme_row->album_compact_thumb_box_shadow; ?>;
        display: inline-block;
        height: <?php echo $slide_params['album_thumb_height']; ?>px;
        overflow: hidden;
        width: <?php echo $slide_params['album_thumb_width']; ?>px;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_album_thumbnails_<?php echo $bwg; ?> {
        display: inline-block;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        background-color: rgba(<?php echo $rgb_album_compact_thumbs_bg_color['red']; ?>, <?php echo $rgb_album_compact_thumbs_bg_color['green']; ?>, <?php echo $rgb_album_compact_thumbs_bg_color['blue']; ?>, <?php echo $theme_row->album_compact_thumb_bg_transparent / 100; ?>);
        font-size: 0;
        text-align: <?php echo $theme_row->album_compact_thumb_align; ?>;
        max-width: <?php echo $items_col_num * ($slide_params['album_thumb_width'] + 2 * (2 + $theme_row->album_compact_thumb_margin + $theme_row->album_compact_thumb_padding + $theme_row->album_compact_thumb_border_width)); ?>px;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_album_thumbnails_<?php echo $bwg; ?> a {
        cursor: pointer;
        text-decoration: none;
      }
      <?php
      if ($slide_params['album_title_show_hover'] == 'show') { /* Show album/gallery title at the bottom.*/
        ?>
        #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_title_spun1_<?php echo $bwg; ?> {
          display: block;
          opacity: 1;
          filter: Alpha(opacity=100);
          text-align: center;
          width: <?php echo $slide_params['album_thumb_width']; ?>px;
        }
        <?php
      }
      elseif ($slide_params['album_title_show_hover'] == 'hover') { /* Show album/gallery title on hover.*/
        ?>
        #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_title_spun1_<?php echo $bwg; ?> {
          display: table;
          height: inherit;
          left: -3000px;
          opacity: 0;
          filter: Alpha(opacity=0);
          position: absolute;
          top: 0px;
          width: inherit;
        }
        <?php
      }
      ?>
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_album_thumb_spun1_<?php echo $bwg; ?>:hover .bwg_title_spun1_<?php echo $bwg; ?> {
        left: <?php echo $theme_row->album_compact_thumb_padding; ?>px;
        top: <?php echo $theme_row->album_compact_thumb_padding; ?>px;
        opacity: 1;
        filter: Alpha(opacity=100);
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_title_spun2_<?php echo $bwg; ?> {
        color: #<?php echo $theme_row->album_compact_title_font_color; ?>;
        display: table-cell;
        font-family: <?php echo $theme_row->album_compact_title_font_style; ?>;
        font-size: <?php echo $theme_row->album_compact_title_font_size; ?>px;
        font-weight: <?php echo $theme_row->album_compact_title_font_weight; ?>;
        height: inherit;
        padding: <?php echo $theme_row->album_compact_title_margin; ?>;
        text-shadow: <?php echo $theme_row->album_compact_title_shadow; ?>;
        vertical-align: middle;
        width: inherit;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_album_thumbnails_<?php echo $bwg; ?> {
        display: inline-block;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        background-color: rgba(<?php echo $rgb_album_compact_thumbs_bg_color['red']; ?>, <?php echo $rgb_album_compact_thumbs_bg_color['green']; ?>, <?php echo $rgb_album_compact_thumbs_bg_color['blue']; ?>, <?php echo $theme_row->album_compact_thumb_bg_transparent / 100; ?>);
        font-size: 0;
        text-align: <?php echo $theme_row->album_compact_thumb_align; ?>;
        max-width: <?php echo $items_col_num * ($slide_params['album_thumb_width'] + 2 * (2 + $theme_row->album_compact_thumb_margin + $theme_row->album_compact_thumb_padding + $theme_row->album_compact_thumb_border_width)); ?>px;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_album_thumbnails_<?php echo $bwg; ?> a {
        cursor: pointer;
        text-decoration: none;
      }
      /*Image thumbs styles.*/
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_standart_thumb_spun1_<?php echo $bwg; ?> {
        background-color: #<?php echo $theme_row->thumb_bg_color; ?>;
        display: inline-block;
        height: <?php echo $slide_params['thumb_height']; ?>px;
        margin: <?php echo $theme_row->thumb_margin; ?>px;
        opacity: <?php echo $theme_row->thumb_transparent / 100; ?>;
        filter: Alpha(opacity=<?php echo $theme_row->thumb_transparent; ?>);
        <?php echo ($theme_row->thumb_transition) ? 'transition: all 0.3s ease 0s;-webkit-transition: all 0.3s ease 0s;' : ''; ?>
        padding: <?php echo $theme_row->thumb_padding; ?>px;
        text-align: center;
        vertical-align: middle;
        width: <?php echo $slide_params['thumb_width']; ?>px;
        z-index: 100;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_standart_thumb_spun1_<?php echo $bwg; ?>:hover {
        -ms-transform: <?php echo $theme_row->thumb_hover_effect; ?>(<?php echo $theme_row->thumb_hover_effect_value; ?>);
        -webkit-transform: <?php echo $theme_row->thumb_hover_effect; ?>(<?php echo $theme_row->thumb_hover_effect_value; ?>);
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
        -moz-backface-visibility: hidden;
        -ms-backface-visibility: hidden;
        opacity: 1;
        filter: Alpha(opacity=100);
        transform: <?php echo $theme_row->thumb_hover_effect; ?>(<?php echo $theme_row->thumb_hover_effect_value; ?>);
        z-index: 102;
        position: relative;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_standart_thumb_spun2_<?php echo $bwg; ?> {
        border-radius: <?php echo $theme_row->thumb_border_radius; ?>;
        border: <?php echo $theme_row->thumb_border_width; ?>px <?php echo $theme_row->thumb_border_style; ?> #<?php echo $theme_row->thumb_border_color; ?>;
        box-shadow: <?php echo $theme_row->thumb_box_shadow; ?>;
        display: inline-block;
        height: <?php echo $slide_params['thumb_height']; ?>px;
        overflow: hidden;
        width: <?php echo $slide_params['thumb_width']; ?>px;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_standart_thumbnails_<?php echo $bwg; ?> {
        -moz-box-sizing: border-box;
        display: inline-block;
        background-color: rgba(<?php echo $rgb_thumbs_bg_color['red']; ?>, <?php echo $rgb_thumbs_bg_color['green']; ?>, <?php echo $rgb_thumbs_bg_color['blue']; ?>, <?php echo $theme_row->thumb_bg_transparent / 100; ?>);
        box-sizing: border-box;
        font-size: 0;
        max-width: <?php echo $slide_params['compuct_album_image_column_number'] * ($slide_params['thumb_width'] + 2 * (2 + $theme_row->thumb_margin + $theme_row->thumb_padding + $theme_row->thumb_border_width)); ?>px;
        text-align: <?php echo $theme_row->thumb_align; ?>;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_standart_thumbnails_<?php echo $bwg; ?> a {
        cursor: pointer;
        text-decoration: none;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_standart_thumb_<?php echo $bwg; ?> {
        display: inline-block;
        text-align: center;
      }
      <?php
      if ($slide_params['image_title_show_hover'] == 'show') { /* Show image title at the bottom.*/
        ?>
        #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_image_title_spun1_<?php echo $bwg; ?> {
          display: block;
          margin: 0 auto;
          opacity: 1;
          filter: Alpha(opacity=100);
          text-align: center;
          width: <?php echo $slide_params['thumb_width']; ?>px;
        }
        <?php
      }
      elseif ($slide_params['image_title_show_hover'] == 'hover') { /* Show image title on hover.*/
        ?>
        #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_image_title_spun1_<?php echo $bwg; ?> {
          display: table;
          height: inherit;
          left: -3000px;
          opacity: 0;
          filter: Alpha(opacity=0);
          position: absolute;
          top: 0px;
          width: inherit;
        }
        <?php
      }
      ?>
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_standart_thumb_spun1_<?php echo $bwg; ?>:hover .bwg_image_title_spun1_<?php echo $bwg; ?> {
        left: <?php echo $theme_row->thumb_padding; ?>px;
        top: <?php echo $theme_row->thumb_padding; ?>px;
        opacity: 1;
        filter: Alpha(opacity=100);
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_image_title_spun2_<?php echo $bwg; ?> {
        color: #<?php echo $theme_row->thumb_title_font_color; ?>;
        display: table-cell;
        font-family: <?php echo $theme_row->thumb_title_font_style; ?>;
        font-size: <?php echo $theme_row->thumb_title_font_size; ?>px;
        font-weight: <?php echo $theme_row->thumb_title_font_weight; ?>;
        height: inherit;
        margin: <?php echo $theme_row->thumb_title_margin; ?>;
        text-shadow: <?php echo $theme_row->thumb_title_shadow; ?>;
        vertical-align: middle;
        width: inherit;
        word-break: break-all;
        word-wrap: break-word;
      }
      /*Pagination styles.*/
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .tablenav-pages_<?php echo $bwg; ?> {
        text-align: <?php echo $theme_row->page_nav_align; ?>;
        font-size: <?php echo $theme_row->page_nav_font_size; ?>px;
        font-family: <?php echo $theme_row->page_nav_font_style; ?>;
        font-weight: <?php echo $theme_row->page_nav_font_weight; ?>;
        color: #<?php echo $theme_row->page_nav_font_color; ?>;
        margin: 6px 0 4px;
        display: block;
        height: 30px;
        line-height: 30px;
      }
      @media only screen and (max-width : 320px) {
        #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .displaying-num_<?php echo $bwg; ?> {
          display: none;
        }
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .displaying-num_<?php echo $bwg; ?> {
        font-size: <?php echo $theme_row->page_nav_font_size; ?>px;
        font-family: <?php echo $theme_row->page_nav_font_style; ?>;
        font-weight: <?php echo $theme_row->page_nav_font_weight; ?>;
        color: #<?php echo $theme_row->page_nav_font_color; ?>;
        margin-right: 10px;
        vertical-align: middle;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .paging-input_<?php echo $bwg; ?> {
        font-size: <?php echo $theme_row->page_nav_font_size; ?>px;
        font-family: <?php echo $theme_row->page_nav_font_style; ?>;
        font-weight: <?php echo $theme_row->page_nav_font_weight; ?>;
        color: #<?php echo $theme_row->page_nav_font_color; ?>;
        vertical-align: middle;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .tablenav-pages_<?php echo $bwg; ?> a.disabled,
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .tablenav-pages_<?php echo $bwg; ?> a.disabled:hover,
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .tablenav-pages_<?php echo $bwg; ?> a.disabled:focus {
        cursor: default;
        color: rgba(<?php echo $rgb_page_nav_font_color['red']; ?>, <?php echo $rgb_page_nav_font_color['green']; ?>, <?php echo $rgb_page_nav_font_color['blue']; ?>, 0.5);
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .tablenav-pages_<?php echo $bwg; ?> a {
        cursor: pointer;
        font-size: <?php echo $theme_row->page_nav_font_size; ?>px;
        font-family: <?php echo $theme_row->page_nav_font_style; ?>;
        font-weight: <?php echo $theme_row->page_nav_font_weight; ?>;
        color: #<?php echo $theme_row->page_nav_font_color; ?>;
        text-decoration: none;
        padding: <?php echo $theme_row->page_nav_padding; ?>;
        margin: <?php echo $theme_row->page_nav_margin; ?>;
        border-radius: <?php echo $theme_row->page_nav_border_radius; ?>;
        border-style: <?php echo $theme_row->page_nav_border_style; ?>;
        border-width: <?php echo $theme_row->page_nav_border_width; ?>px;
        border-color: #<?php echo $theme_row->page_nav_border_color; ?>;
        background-color: #<?php echo $theme_row->page_nav_button_bg_color; ?>;
        opacity: <?php echo $theme_row->page_nav_button_bg_transparent / 100; ?>;
        filter: Alpha(opacity=<?php echo $theme_row->page_nav_button_bg_transparent; ?>);
        box-shadow: <?php echo $theme_row->page_nav_box_shadow; ?>;
        <?php echo ($theme_row->page_nav_button_transition ) ? 'transition: all 0.3s ease 0s;-webkit-transition: all 0.3s ease 0s;' : ''; ?>
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_back_<?php echo $bwg; ?> {
        background-color: rgba(0, 0, 0, 0);
        color: #<?php echo $theme_row->album_compact_back_font_color; ?> !important;
        cursor: pointer;
        display: block;
        font-family: <?php echo $theme_row->album_compact_back_font_style; ?>;
        font-size: <?php echo $theme_row->album_compact_back_font_size; ?>px;
        font-weight: <?php echo $theme_row->album_compact_back_font_weight; ?>;
        text-decoration: none;
        padding: <?php echo $theme_row->album_compact_back_padding; ?>;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> #spider_popup_overlay_<?php echo $bwg; ?> {
        background-color: #<?php echo $theme_row->lightbox_overlay_bg_color; ?>;
        opacity: <?php echo $theme_row->lightbox_overlay_bg_transparent / 100; ?>;
        filter: Alpha(opacity=<?php echo $theme_row->lightbox_overlay_bg_transparent; ?>);
      }
    </style>

    <div id="bwg_container1_<?php echo $bwg; ?>">
      <div id="bwg_container2_<?php echo $bwg; ?>">
        <form id="gal_front_form_<?php echo $bwg; ?>" method="post" action="#">
          <?php
          if ($slide_params['show_search_box'] && $type == 'gallery') {
            WDWLibrary::ajax_html_frontend_search_box('gal_front_form_' . $bwg, $bwg, $album_gallery_div_id, $images_count, $slide_params['search_box_width']);
          }
          ?>
          <div id="<?php echo $form_child_div_id; ?>" style="<?php echo $form_child_div_style; ?>">
            <div id="ajax_loading_<?php echo $bwg; ?>" style="position:absolute;width: 100%; z-index: 115; text-align: center; height: 100%; vertical-align: middle; display: none;">
              <div style="display: table; vertical-align: middle; width: 100%; height: 100%; background-color: #FFFFFF; opacity: 0.7; filter: Alpha(opacity=70);">
                <div style="display: table-cell; text-align: center; position: relative; vertical-align: middle;" >
                  <div id="loading_div_<?php echo $bwg; ?>" style="display: inline-block; text-align:center; position:relative; vertical-align:middle;">
                    <img src="<?php echo $WD_BWG_URL . '/images/ajax_loader.png'; ?>" class="spider_ajax_loading" style="float: none; width:50px;">
                  </div>
                </div>
              </div>
            </div>
            <?php
            if ($slide_params['album_enable_page'] && $items_per_page && ($theme_row->page_nav_position == 'top') && $page_nav['total']) {
              WDWLibrary::ajax_html_frontend_page_nav($theme_row, $page_nav['total'], $page_nav['limit'], 'gal_front_form_' . $bwg, $items_per_page, $bwg, $album_gallery_div_id, $slide_params['id'], $type);
            }
            if ($bwg_previous_album_id) {
              ?>
              <a class="bwg_back_<?php echo $bwg; ?>" onclick="spider_frontend_ajax('gal_front_form_<?php echo $bwg; ?>', '<?php echo $bwg; ?>', '<?php echo $album_gallery_div_id; ?>', 'back')"><?php echo JText::_('BACK'); ?></a>
              <?php
            }
            ?>
            <div id="<?php echo $album_gallery_div_id; ?>" class="<?php echo $album_gallery_div_class; ?>" >
              <input type="hidden" id="bwg_previous_album_id_<?php echo $bwg; ?>" name="bwg_previous_album_id_<?php echo $bwg; ?>" value="<?php echo $bwg_previous_album_id; ?>" />
              <input type="hidden" id="bwg_previous_album_page_number_<?php echo $bwg; ?>" name="bwg_previous_album_page_number_<?php echo $bwg; ?>" value="<?php echo $bwg_previous_album_page_number; ?>" />
              <?php
              if ($type != 'gallery') {
                if (!$page_nav['total']) {
                  ?>
                  <span class="bwg_back_<?php echo $bwg; ?>"><?php echo JText::_('EMPTY_ALBUM'); ?></span>
                  <?php
                }
                foreach ($album_galleries_row as $album_galallery_row) {
                  if ($album_galallery_row->is_album) {
                    $album_row =Modgallery_wdHelper::get_album_row_data_gal_alb($album_galallery_row->alb_gal_id);
                    if (!$album_row) {
                      continue;
                    }
                    $preview_image = $album_row->preview_image;
                    if (!$preview_image) {
                      $preview_image = $album_row->random_preview_image;
                    }
                    $def_type = 'album';
                    $title = $album_row->name;
                    $permalink ='';// $album_row->permalink;
                  }
                  else {
                    $gallery_row = Modgallery_wdHelper::get_gallery_row_data_gal_alb($album_galallery_row->alb_gal_id);
                    if (!$gallery_row) {
                      continue;
                    }
                    $preview_image = $gallery_row->preview_image;
                    if (!$preview_image) {
                      $preview_image = $gallery_row->random_preview_image;
                    }
                    $def_type = 'gallery';
                    $title = $gallery_row->name;
                $permalink ='';// $gallery_row->permalink;
                  }
                  if (!$preview_image) {
                    $preview_url = $WD_BWG_URL . '/images/no-image.png';
                    $preview_path = $WD_BWG_DIR . '/images/no-image.png';
                  }
                  else {
                    $preview_url = JURI::root().$WD_BWG_UPLOAD_DIR.'/'. $preview_image;
                    $preview_path = JPATH_SITE.'/' . $WD_BWG_UPLOAD_DIR.'/' . $preview_image;
                  }
				  				  $preview_url=htmlspecialchars($preview_url);
				  $preview_path=htmlspecialchars($preview_path);

                  list($image_thumb_width, $image_thumb_height) = getimagesize(htmlspecialchars_decode($preview_path, ENT_COMPAT | ENT_QUOTES));
                  $scale = max($slide_params['album_thumb_width'] / $image_thumb_width, $slide_params['album_thumb_height'] / $image_thumb_height);
                  $image_thumb_width *= $scale;
                  $image_thumb_height *= $scale;
                  $thumb_left = ($slide_params['album_thumb_width'] - $image_thumb_width) / 2;
                  $thumb_top = ($slide_params['album_thumb_height'] - $image_thumb_height) / 2;
                  if ($type != 'gallery') {
                    ?>
                    <a style="font-size: 0;" <?php echo ($from !== "widget" ? "onclick=\"spider_frontend_ajax('gal_front_form_" . $bwg . "', '" . $bwg . "', 'bwg_album_compact_" . $bwg . "', '" . $album_galallery_row->alb_gal_id . "', '" . $album_gallery_id . "', '" . $def_type . "')\"" : "href='" . $permalink . "'") ?>>
                      <span class="bwg_album_thumb_<?php echo $bwg; ?>">
                        <?php
                        if ($slide_params['album_title_show_hover'] == 'show' && $theme_row->album_compact_thumb_title_pos == 'top') {
                          ?>
                          <span class="bwg_title_spun1_<?php echo $bwg; ?>">
                            <span class="bwg_title_spun2_<?php echo $bwg; ?>">
                              <?php echo $title; ?>
                            </span>
                          </span>
                          <?php
                        }
                        ?>
                        <span class="bwg_album_thumb_spun1_<?php echo $bwg; ?>">
                          <span class="bwg_album_thumb_spun2_<?php echo $bwg; ?>">
                            <img style="padding: 0 !important; max-height: none !important; max-width: none !important; width: <?php echo $image_thumb_width; ?>px; height:<?php echo $image_thumb_height; ?>px; margin-left: <?php echo $thumb_left; ?>px; margin-top: <?php echo $thumb_top; ?>px;" src="<?php echo $preview_url; ?>" alt="<?php echo $title; ?>" />
                            <?php
                            if ($slide_params['album_title_show_hover'] == 'hover') {
                              ?>
                              <span class="bwg_title_spun1_<?php echo $bwg; ?>">
                                <span class="bwg_title_spun2_<?php echo $bwg; ?>">
                                  <?php echo $title; ?>
                                </span>
                              </span>
                              <?php
                            }
                            ?>
                          </span>
                        </span>
                        <?php
                        if ($slide_params['album_title_show_hover'] == 'show' && $theme_row->album_compact_thumb_title_pos == 'bottom') {
                          ?>
                          <span class="bwg_title_spun1_<?php echo $bwg; ?>">
                            <span class="bwg_title_spun2_<?php echo $bwg; ?>">
                              <?php echo $title; ?>
                            </span>
                          </span>
                          <?php
                        }
                        ?>
                      </span>
                    </a>
                    <?php
                  }
                }
              }
              elseif ($type == 'gallery') {

                
                foreach ($image_rows as $image_row) {
					  		$image_row->thumb_url=htmlspecialchars($image_row->thumb_url);
			  $image_row->image_url=htmlspecialchars($image_row->image_url);
			  $image_row->alt=htmlspecialchars($image_row->alt);
			  $image_row->filename=htmlspecialchars($image_row->filename);
 
                  $slide_params_array['image_id'] = (isset($_POST['image_id']) ? esc_html($_POST['image_id']) : $image_row->id);
                  $slide_params_array['gallery_id'] = $album_gallery_id;
                  $is_video = $image_row->filetype == "YOUTUBE" || $image_row->filetype == "VIMEO";
                  if (!$is_video) {
                    list($image_thumb_width, $image_thumb_height) = getimagesize(htmlspecialchars_decode(JPATH_SITE.'/' . $WD_BWG_UPLOAD_DIR.'/' . $image_row->thumb_url, ENT_COMPAT | ENT_QUOTES));
                  }
                  else {
                    $image_thumb_width = $slide_params['thumb_width'];
                    $image_thumb_height = $slide_params['thumb_height'];
                  }
                  $scale = max($slide_params['thumb_width'] / $image_thumb_width, $slide_params['thumb_height'] / $image_thumb_height);
                  $image_thumb_width *= $scale;
                  $image_thumb_height *= $scale;
                  $thumb_left = ($slide_params['thumb_width'] - $image_thumb_width) / 2;
                  $thumb_top = ($slide_params['thumb_height'] - $image_thumb_height) / 2;
                  if ($album_view_type == 'thumbnail') {
                    ?>
                  <a style="font-size: 0;" <?php echo ($slide_params['thumb_click_action'] == 'open_lightbox' ? ('onclick="spider_createpopup(\'' . addslashes(Modgallery_wdHelper::array_to_url_gal_alb($slide_params_array)) . '\', ' . $bwg . ', ' . $slide_params['popup_width'] . ', ' . $slide_params['popup_height'] . ', 1, \'testpopup\', 5); return false;"') : ('href="' . $image_row->redirect_url . '" target="' .  ($slide_params['thumb_link_target'] ? '_blank' : '')  . '"')) ?>>
                    <span class="bwg_standart_thumb_<?php echo $bwg; ?>">
                      <?php
                      if ($slide_params['image_title_show_hover'] == 'show' && $theme_row->album_compact_thumb_title_pos == 'top') {
                        ?>
                        <span class="bwg_image_title_spun1_<?php echo $bwg; ?>">
                          <span class="bwg_image_title_spun2_<?php echo $bwg; ?>">
                            <?php echo $image_row->alt; ?>
                          </span>
                        </span>
                        <?php
                      }
                      ?>
                      <span class="bwg_standart_thumb_spun1_<?php echo $bwg; ?>">
                        <span class="bwg_standart_thumb_spun2_<?php echo $bwg; ?>">
                          <img style="max-height:none; max-width:none; width:<?php echo $image_thumb_width; ?>px; height:<?php echo $image_thumb_height; ?>px; margin-left: <?php echo $thumb_left; ?>px; margin-top: <?php echo $thumb_top; ?>px;" id="<?php echo $image_row->id; ?>" src="<?php echo ($is_video ? "" : JURI::root().$WD_BWG_UPLOAD_DIR.'/') . $image_row->thumb_url; ?>" alt="<?php echo $image_row->alt; ?>" />
                          <?php
                          if ($slide_params['image_title_show_hover'] == 'hover') {
                            ?>
                            <span class="bwg_image_title_spun1_<?php echo $bwg; ?>">
                              <span class="bwg_image_title_spun2_<?php echo $bwg; ?>">
                                <?php echo $image_row->alt; ?>
                              </span>
                            </span>
                            <?php
                          }
                          ?>
                        </span>
                      </span>
                      <?php
                      if ($slide_params['image_title_show_hover'] == 'show' && $theme_row->album_compact_thumb_title_pos == 'bottom') {
                        ?>
                        <span class="bwg_image_title_spun1_<?php echo $bwg; ?>">
                          <span class="bwg_image_title_spun2_<?php echo $bwg; ?>">
                            <?php echo $image_row->alt; ?>
                          </span>
                        </span>
                        <?php
                      }
                      ?>
                    </span>
                  </a>
                    <?php
                  }
                  else {
                    ?>
                  <span class="bwg_masonry_thumb_spun_<?php echo $bwg; ?>">
                    <a style="font-size: 0;" <?php echo ($slide_params['thumb_click_action'] == 'open_lightbox' ? ('onclick="spider_createpopup(\'' . addslashes(Modgallery_wdHelper::array_to_url_gal_alb($slide_params_array)) . '\', ' . $bwg . ', ' . $slide_params['popup_width'] . ', ' . $slide_params['popup_height'] . ', 1, \'testpopup\', 5); return false;"') : ('href="' . $image_row->redirect_url . '" target="' .  ($slide_params['thumb_link_target'] ? '_blank' : '')  . '"')) ?>>
                      <img class="bwg_masonry_thumb_<?php echo $bwg; ?>" id="<?php echo $image_row->id; ?>" src="<?php echo ($is_video ? "" : JURI::root() . $WD_BWG_UPLOAD_DIR.'/') . $image_row->thumb_url; ?>" alt="<?php echo $image_row->alt; ?>" style="max-height: none !important;  max-width: none !important;" />
                    </a>
                  </span>
                    <?php
                  }
                }
              }
              ?>
            </div>
            <?php 
            if ($album_view_type == 'masonry' && $type == 'gallery' ) {
              ?>
              <script>
                function bwg_masonry_<?php echo $bwg; ?>() { 
                  var image_width = <?php echo $slide_params['thumb_width']; ?>;
                  var cont_div_width = <?php echo $slide_params['compuct_album_image_column_number'] * ($slide_params['thumb_width'] + 2 * ($theme_row->thumb_padding + $theme_row->thumb_border_width)); ?>;
                  if (cont_div_width > jQuery("#bwg_masonry_thumbnails_div_<?php echo $bwg; ?>").width()) {
                    cont_div_width = jQuery("#bwg_masonry_thumbnails_div_<?php echo $bwg; ?>").width();
                  }
                  var col_count = parseInt(cont_div_width / image_width);
                  if (!col_count) {
                    col_count = 1;
                  }
                  var top = new Array();
                  var left = new Array();
                  for (var i = 0; i < col_count; i++) {
                    top[i] = 0;
                    left[i] = i * image_width;
                  }
                  var div_width = col_count * image_width;
                  if (div_width > jQuery(window).width()) {
                    div_width = jQuery(window).width();
                    jQuery(".bwg_masonry_thumb_<?php echo $bwg; ?>").attr("style", "max-width: " + div_width + "px");
                  }
                  else {
                    div_width = col_count * image_width;
                  }
                  jQuery(".bwg_masonry_thumb_spun_<?php echo $bwg; ?>").each(function() {
                    min_top = Math.min.apply(Math, top);
                    index_min_top = jQuery.inArray(min_top, top);
                    jQuery(this).css({left: left[index_min_top], top: top[index_min_top]});
                    top[index_min_top] += jQuery(this).height();
                  });
                  jQuery(".bwg_masonry_thumbnails_<?php echo $bwg; ?>").width(div_width);
                  jQuery(".bwg_masonry_thumbnails_<?php echo $bwg; ?>").height(Math.max.apply(Math, top));
                  jQuery(".bwg_masonry_thumb_<?php echo $bwg; ?>").css({visibility: 'visible'});
                }
                jQuery(window).load(function() {
                  bwg_masonry_<?php echo $bwg; ?>();
                });
                jQuery(window).resize(function() {
                  bwg_masonry_<?php echo $bwg; ?>();
                });
              </script>
              <?php
            }
            if ($slide_params['album_enable_page'] && $items_per_page && ($theme_row->page_nav_position == 'bottom') && $page_nav['total']) {
              WDWLibrary::ajax_html_frontend_page_nav($theme_row, $page_nav['total'], $page_nav['limit'], 'gal_front_form_' . $bwg, $items_per_page, $bwg, $album_gallery_div_id, $slide_params['id'], $type);
            }
            ?>
          </div>
        </form>
        <div id="spider_popup_loading_<?php echo $bwg; ?>" class="spider_popup_loading"></div>
        <div id="spider_popup_overlay_<?php echo $bwg; ?>" class="spider_popup_overlay" onclick="spider_destroypopup(1000)"></div>
      </div>
    </div>
    <script>
      var bwg_current_url = '<?php echo $current_url; ?>';
      <?php
      if (isset($slide_params_array_hash)) {
      ?>
      var bwg_hash = window.location.hash.substring(1);
      if (bwg_hash && bwg_hash.indexOf("bwg") != "-1") {
        bwg_hash_array = bwg_hash.replace("bwg", "").split("/");
        spider_createpopup('<?php echo addslashes(Modgallery_wdHelper::array_to_url_gal_alb($slide_params_array_hash)); ?>&gallery_id=' + bwg_hash_array[0] + '&image_id=' + bwg_hash_array[1], '<?php echo $bwg; ?>', '<?php echo $slide_params['popup_width']; ?>', '<?php echo $slide_params['popup_height']; ?>', 1, 'testpopup', 5);
      }
      <?php
      }
      ?>
    </script>