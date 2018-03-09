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
      $slide_params['image_title'] = 'none';
    }
	else
	      $slide_params['image_title'] = $slide_params['image_title_show_hover'];
   
   if (!isset($slide_params['image_title'])) {
      $slide_params['image_title'] = 'none';
    }
    if (!isset($slide_params['popup_fullscreen'])) {
      $slide_params['popup_fullscreen'] = 0;
    }
    if (!isset($slide_params['popup_autoplay'])) {
      $slide_params['popup_autoplay'] = 0;
    }
    if (!isset($slide_params['order_by'])) {
      $slide_params['order_by'] = ' asc ';
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
  

	$session = JFactory::getSession();
	
$options_row = Modgallery_wdHelper::get_options_row_data_gal_alb();

      $slide_params['gallery_id'] = $slide_params['id'];
      $slide_params['images_per_page'] =$slide_params['count'];
      $slide_params['sort_by'] = (($slide_params['show'] == 'random') ? 'RAND()' : 'date');
	  $slide_params['theme_id']=$slide_params['theme_id'];
      $slide_params['image_enable_page'] = 0;
      $slide_params['image_title'] = $options_row->image_title_show_hover;
      $slide_params['thumb_height'] = $slide_params['height'];
      $slide_params['thumb_width'] = $slide_params['width'];
      $slide_params['image_column_number'] = $slide_params['count'];
      $slide_params['popup_width'] = $options_row->popup_width;
      $slide_params['popup_height'] = $options_row->popup_height;
      $slide_params['popup_type'] = $options_row->popup_type;
      $slide_params['popup_enable_filmstrip'] = $options_row->popup_enable_filmstrip;
      $slide_params['popup_filmstrip_height'] = $options_row->popup_filmstrip_height;
      $slide_params['popup_enable_ctrl_btn'] = $options_row->popup_enable_ctrl_btn;
      $slide_params['popup_enable_fullscreen'] = $options_row->popup_enable_fullscreen;
      $slide_params['popup_interval'] = $options_row->popup_interval;
      $slide_params['popup_enable_comment'] = $options_row->popup_enable_comment;
      $slide_params['popup_enable_facebook'] = $options_row->popup_enable_facebook;
      $slide_params['popup_enable_twitter'] = $options_row->popup_enable_twitter;
      $slide_params['popup_enable_google'] = $options_row->popup_enable_google;
      $slide_params['watermark_type'] = $options_row->watermark_type;
      $slide_params['watermark_link'] = $options_row->watermark_link;
      $slide_params['watermark_opacity'] = $options_row->watermark_opacity;
      $slide_params['watermark_position'] = $options_row->watermark_position;
      $slide_params['watermark_text'] = $options_row->watermark_text;
      $slide_params['watermark_font_size'] = $options_row->watermark_font_size;
      $slide_params['watermark_font'] = $options_row->watermark_font;
      $slide_params['watermark_color'] = $options_row->watermark_color;
      $slide_params['watermark_url'] = $options_row->watermark_url;
      $slide_params['watermark_width'] = $options_row->watermark_width;
      $slide_params['watermark_height'] = $options_row->watermark_height;
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
    
    $theme_row = Modgallery_wdHelper::get_theme_row_data_gal_alb($slide_params['theme_id']);
    if (!$theme_row) {
      echo WDWLibrary::message(JText::_('THERE_IS_NO_THEME'), 'error');
      return;
    }
    if (isset($slide_params['type'])) {
      $type = $slide_params['type'];
    }
    else {
      $type = "";
    }
     $gallery_row = Modgallery_wdHelper::get_gallery_row_data_gal_alb($slide_params['gallery_id']);
    if (!$gallery_row && ($type == '')) {
      echo WDWLibrary::message(JText::_('THERE_IS_NO_GALLERY'), 'error');
      return;
    }
    $image_rows = Modgallery_wdHelper::get_image_rows_data_gal_alb($slide_params['gallery_id'],  $slide_params['images_per_page'], $slide_params['sort_by'], $bwg);
	$images_count=count(  $image_rows);
    if (!$image_rows) {
      echo WDWLibrary::message(JText::_('THERE_IS_NO_IMAGE'), 'error');
    }
    if ($slide_params['image_enable_page'] && $slide_params['images_per_page']) {
      $page_nav = $this->page_nav;
    }
    $rgb_page_nav_font_color = WDWLibrary::spider_hex2rgb($theme_row->page_nav_font_color);
    $rgb_thumbs_bg_color = WDWLibrary::spider_hex2rgb($theme_row->thumbs_bg_color);

    ?>
	
    <style>
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_standart_thumbnails_<?php echo $bwg; ?> * {
        -moz-box-sizing: border-box;
        box-sizing: border-box;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_standart_thumb_spun1_<?php echo $bwg; ?> {
        -moz-box-sizing: content-box;
        box-sizing: content-box;
        background-color: #<?php echo $theme_row->thumb_bg_color; ?>;
        display: inline-block;
        height: <?php echo $slide_params['thumb_height']; ?>px;
        margin: <?php echo $theme_row->thumb_margin; ?>px;
        padding: <?php echo $theme_row->thumb_padding; ?>px;
        opacity: <?php echo $theme_row->thumb_transparent / 100; ?>;
        filter: Alpha(opacity=<?php echo $theme_row->thumb_transparent; ?>);
        text-align: center;
        vertical-align: middle;
        <?php echo ($theme_row->thumb_transition) ? 'transition: all 0.3s ease 0s;-webkit-transition: all 0.3s ease 0s;' : ''; ?>
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
        border: <?php echo $theme_row->thumb_border_width; ?>px <?php echo $theme_row->thumb_border_style; ?> #<?php echo $theme_row->thumb_border_color; ?>;
        border-radius: <?php echo $theme_row->thumb_border_radius; ?>;
        box-shadow: <?php echo $theme_row->thumb_box_shadow; ?>;
        display: inline-block;
        height: <?php echo $slide_params['thumb_height']; ?>px;
        overflow: hidden;
        width: <?php echo $slide_params['thumb_width']; ?>px;
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_standart_thumbnails_<?php echo $bwg; ?> {
        background-color: rgba(<?php echo $rgb_thumbs_bg_color['red']; ?>, <?php echo $rgb_thumbs_bg_color['green']; ?>, <?php echo $rgb_thumbs_bg_color['blue']; ?>, <?php echo $theme_row->thumb_bg_transparent / 100; ?>);
        display: inline-block;
        font-size: 0;
        max-width: <?php echo $slide_params['image_column_number'] * ($slide_params['thumb_width'] + 2 * (2 + $theme_row->thumb_margin + $theme_row->thumb_padding + $theme_row->thumb_border_width)); ?>px;
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
      if ($slide_params['image_title'] == 'show') { /* Show image title at the bottom.*/
        ?>
        #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_title_spun1_<?php echo $bwg; ?> {
          display: block;
          margin: 0 auto;
          opacity: 1;
          filter: Alpha(opacity=100);
          text-align: center;
          width: <?php echo $slide_params['thumb_width']; ?>px;
        }
        <?php
      }
      elseif ($slide_params['image_title'] == 'hover') { /* Show image title on hover.*/
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
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_standart_thumb_spun1_<?php echo $bwg; ?>:hover .bwg_title_spun1_<?php echo $bwg; ?> {
        left: <?php echo $theme_row->thumb_padding; ?>px;
        top: <?php echo $theme_row->thumb_padding; ?>px;
        opacity: 1;
        filter: Alpha(opacity=100);
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg_title_spun2_<?php echo $bwg; ?> {
        color: #<?php echo $theme_row->thumb_title_font_color; ?>;
        display: table-cell;
        font-family: <?php echo $theme_row->thumb_title_font_style; ?>;
        font-size: <?php echo $theme_row->thumb_title_font_size; ?>px;
        font-weight: <?php echo $theme_row->thumb_title_font_weight; ?>;
        height: inherit;
        padding: <?php echo $theme_row->thumb_title_margin; ?>;
        text-shadow: <?php echo $theme_row->thumb_title_shadow; ?>;
        vertical-align: middle;
        width: inherit;
        word-break: break-all;
        word-wrap: break-word;
      }
      /*pagination styles*/
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
          if ($slide_params['show_search_box']) {
            WDWLibrary::ajax_html_frontend_search_box('gal_front_form_' . $bwg, $bwg, 'bwg_standart_thumbnails_' . $bwg, $images_count, $slide_params['search_box_width']);
          }
          ?>
          <div style="background-color:rgba(0, 0, 0, 0); text-align: <?php echo $theme_row->thumb_align; ?>; width:100%; position: relative;">
            <div id="ajax_loading_<?php echo $bwg; ?>" style="position:absolute;width: 100%; z-index: 115; text-align: center; height: 100%; vertical-align: middle; display:none;">
              <div style="display: table; vertical-align: middle; width: 100%; height: 100%; background-color: #FFFFFF; opacity: 0.7; filter: Alpha(opacity=70);">
                <div style="display: table-cell; text-align: center; position: relative; vertical-align: middle;" >
                  <div id="loading_div_<?php echo $bwg; ?>" style="display: inline-block; text-align:center; position:relative; vertical-align: middle;">
                    <img src="<?php echo $WD_BWG_URL . '/images/ajax_loader.png'; ?>" class="spider_ajax_loading" style="float: none; width:50px;">
                  </div>
                </div>
              </div>
            </div>
            <?php
            if ($slide_params['image_enable_page']  && $slide_params['images_per_page'] && ($theme_row->page_nav_position == 'top')) {
              WDWLibrary::ajax_html_frontend_page_nav($theme_row, $page_nav['total'], $page_nav['limit'], 'gal_front_form_' . $bwg, $slide_params['images_per_page'], $bwg, 'bwg_standart_thumbnails_' . $bwg);
            }
            ?>
            <div id="bwg_standart_thumbnails_<?php echo $bwg; ?>" class="bwg_standart_thumbnails_<?php echo $bwg; ?>">
              <?php
              foreach ($image_rows as $image_row) {
			  	  		$image_row->thumb_url=htmlspecialchars($image_row->thumb_url);
			  $image_row->image_url=htmlspecialchars($image_row->image_url);
			  $image_row->alt=htmlspecialchars($image_row->alt);
			  $image_row->filename=htmlspecialchars($image_row->filename);
 
                $slide_params_array = array(
                  'tag_id' => (isset($slide_params['type']) ? $slide_params['gallery_id'] : 0),
                  'view' => 'GalleryBox',
                  'current_view' => $bwg,
                  'gallery_id' => $slide_params['gallery_id'],
                  'theme_id' => $slide_params['theme_id'],
                  'thumb_width' => $slide_params['thumb_width'],
                  'thumb_height' => $slide_params['thumb_height'],
                  'open_with_fullscreen' => $slide_params['popup_fullscreen'],
                  'open_with_autoplay' => $slide_params['popup_autoplay'],
                  'image_width' => $slide_params['popup_width'],
                  'image_height' => $slide_params['popup_height'],
                  'image_effect' => $slide_params['popup_type'],
                  'sort_by' => (isset($slide_params['type']) ? 'date' : (($slide_params['sort_by'] == 'RAND()') ? 'order' : $slide_params['sort_by'])),
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
                  $slide_params_array['watermark_link'] = $slide_params['watermark_link'];
                  $slide_params_array['watermark_opacity'] = $slide_params['watermark_opacity'];
                  $slide_params_array['watermark_position'] = $slide_params['watermark_position'];
                }
                if ($slide_params['watermark_type'] == 'text') {
                  $slide_params_array['watermark_text'] = $slide_params['watermark_text'];
                  $slide_params_array['watermark_font_size'] = $slide_params['watermark_font_size'];
                  $slide_params_array['watermark_font'] = $slide_params['watermark_font'];
                  $slide_params_array['watermark_color'] = $slide_params['watermark_color'];
                }
                elseif ($slide_params['watermark_type'] == 'image') {
                  $slide_params_array['watermark_url'] = $slide_params['watermark_url'];
                  $slide_params_array['watermark_width'] = $slide_params['watermark_width'];
                  $slide_params_array['watermark_height'] = $slide_params['watermark_height'];
                }
                $slide_params_array_hash = $slide_params_array;
                $slide_params_array['image_id'] = (isset($_POST['image_id']) ? esc_html($_POST['image_id']) : $image_row->id);
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
                ?>
                <a style="font-size: 0;" <?php echo ($slide_params['thumb_click_action'] == 'open_lightbox' ? ('onclick="spider_createpopup(\'' . addslashes(Modgallery_wdHelper::array_to_url_gal_alb($slide_params_array)) . '\', ' . $bwg . ', ' . $slide_params['popup_width'] . ', ' . $slide_params['popup_height'] . ', 1, \'testpopup\', 5); return false;"') : ('href="' . $image_row->redirect_url . '" target="' .  ($slide_params['thumb_link_target'] ? '_blank' : '')  . '"')) ?>>
                  <span class="bwg_standart_thumb_<?php echo $bwg; ?>">
                    <?php
                    if ($slide_params['image_title'] == 'show' and $theme_row->thumb_title_pos == 'top') {
                      ?>
                      <span class="bwg_title_spun1_<?php echo $bwg; ?>">
                        <span class="bwg_title_spun2_<?php echo $bwg; ?>">
                          <?php echo $image_row->alt; ?>
                        </span>
                      </span>
                      <?php
                    }
                    ?>
                    <span class="bwg_standart_thumb_spun1_<?php echo $bwg; ?>">
                      <span class="bwg_standart_thumb_spun2_<?php echo $bwg; ?>">
                        <img class="bwg_standart_thumb_img_<?php echo $bwg; ?>" style="max-height: none !important;  max-width: none !important; padding: 0 !important; width:<?php echo $image_thumb_width; ?>px; height:<?php echo $image_thumb_height; ?>px; margin-left: <?php echo $thumb_left; ?>px; margin-top: <?php echo $thumb_top; ?>px;" id="<?php echo $image_row->id; ?>" src="<?php echo ($is_video ? "" : JURI::root() . $WD_BWG_UPLOAD_DIR.'/') . $image_row->thumb_url; ?>" alt="<?php echo $image_row->alt; ?>" />
                        <?php
                        if ($slide_params['image_title'] == 'hover') {
                          ?>
                          <span class="bwg_title_spun1_<?php echo $bwg; ?>">
                            <span class="bwg_title_spun2_<?php echo $bwg; ?>">
                              <?php echo $image_row->alt; ?>
                            </span>
                          </span>
                          <?php
                        }
                        ?>
                      </span>
                    </span>
                    <?php
                    if ($slide_params['image_title'] == 'show' and $theme_row->thumb_title_pos == 'bottom') {
                      ?>
                      <span class="bwg_title_spun1_<?php echo $bwg; ?>">
                        <span class="bwg_title_spun2_<?php echo $bwg; ?>">
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
              ?>
            </div>
            <?php
            if ($slide_params['image_enable_page']  && $slide_params['images_per_page'] && ($theme_row->page_nav_position == 'bottom')) {
              WDWLibrary::ajax_html_frontend_page_nav($theme_row, $page_nav['total'], $page_nav['limit'], 'gal_front_form_' . $bwg, $slide_params['images_per_page'], $bwg, 'bwg_standart_thumbnails_' . $bwg);
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
        spider_createpopup('<?php echo addslashes(Modgallery_wdHelper::array_to_url_gal_alb($slide_params_array_hash)); ?>&image_id=' + bwg_hash_array[1], '<?php echo $bwg; ?>', '<?php echo $slide_params['popup_width']; ?>', '<?php echo $slide_params['popup_height']; ?>', 1, 'testpopup', 5);
      }
      <?php
      }
      ?>
    </script>