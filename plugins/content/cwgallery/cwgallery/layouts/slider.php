<?php

/**
 * PREPARE SETTINGS 
 */

// syntax instance identification
$hash = rand(); 

/**
 * Lightbox Library
 */ 
$lightbox = $aparams->get('lightbox');
if(!$lightbox){ $lightbox = $cparams->get('lightbox','lightbox'); }

// use layout style generally
$document->addStyleSheet(JUri::root().'plugins/content/cwgallery/cwgallery/assets/css/cwgallery.css');
$document->addStyleSheet(JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/simplelightbox/style.css');

switch($lightbox) {
  case "lightbox":
      // load lightbox
      $document->addScript(JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightbox/js/lightbox.min.js');
      $document->addStyleSheet(JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightbox/css/lightbox.css');
      break;
  case "simplelightbox":
      // load simplelightbox
      $document->addScript(JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/simplelightbox/simple-lightbox.js');
      $document->addStyleSheet(JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/simplelightbox/simplelightbox.min.css');

      $document->addScriptDeclaration('
          jQuery(document).ready( function ($) {
          	var gallery = $("#cwgallery-'.$hash.'.cwgallery .calbum.horizon-swiper a").simpleLightbox();
          });  
      ');      
      
      break; 
  case "lightgallery":
      // load simplelightbox

      $document->addStyleSheet(JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/css/lightgallery.css');
      $document->addScript('https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js');
      $document->addScript(JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lightgallery.js');
      $document->addScript(JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-fullscreen.js');
      $document->addScript(JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-thumbnail.js');
      $document->addScript(JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-video.js');
      $document->addScript(JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-autoplay.js');
      $document->addScript(JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-zoom.js');
      $document->addScript(JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-hash.js');
      $document->addScript(JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-pager.js');
      $document->addScript(JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lib/jquery.mousewheel.min.js');
      
      $document->addScriptDeclaration('
          jQuery(document).ready( function ($) {
           	var gallery = $("#cwgallery-'.$hash.'.cwgallery .lightgallery").lightGallery({
              download: false,
            });
          });
      ');      
      
      break;           
}


/* Standard parameters */  
// scheme color
$caption_color = $aparams->get('caption_color');
if(!isset($caption_color)){ $caption_color = $cparams->get('caption_color','dark'); }
// caption position
$caption_position = 'overlay'; // Currently not used!

/* Advanced parameters */  
// show_desc_in_detail
$show_desc_in_detail = $aparams->get('show_desc_in_detail');
if(!isset($show_desc_in_detail)){ $show_desc_in_detail = $cparams->get('show_desc_in_detail','1'); }
// show_info_on_hover
$show_info_on_hover = $aparams->get('show_info_on_hover');
if(!isset($show_info_on_hover)){ $show_info_on_hover = $cparams->get('show_info_on_hover','1'); }
// show_caption_on_hover
$show_caption_on_hover = $aparams->get('show_caption_on_hover');
if(!isset($show_caption_on_hover)){ $show_caption_on_hover = $cparams->get('show_caption_on_hover','1'); }
// show_desc_on_hover
$show_desc_on_hover = $aparams->get('show_desc_on_hover'); 
if(!isset($show_desc_on_hover)){ $show_desc_on_hover = $cparams->get('show_desc_on_hover','1'); }



/*********************************************************
 * SLIDER LAYOUT 
 *********************************************************/

// slide speed
$slide_speed = $aparams->get('slide_speed');
if(!isset($slide_speed)){ $slide_speed = $cparams->get('slide_speed','500'); }

// load files
$document->addScript(JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/horizon/src/horizon-swiper.js');
$document->addStyleSheet(JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/horizon/dist/horizon-swiper.min.css');
$document->addStyleSheet(JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/horizon/dist/horizon-theme.min.css');


/**
 * Add special styles
 */ 
$document->addStyleDeclaration('
    #cwgallery-'.$hash.'.cwgallery .horizon-swiper button {
      margin: 0 !important;
      padding: 0 5px !important;
      min-width: initial !important;
      height: initial !important;
      border: none !important;
      
      webkit-appearance: 0px 0px 0px !important 
      -webkit-box-shadow: 0px 0px 0px !important;
      -moz-box-shadow: 0px 0px 0px !important;
      box-shadow: 0px 0px 0px !important; 
    }
    #cwgallery-'.$hash.'.cwgallery .horizon-swiper a img.cphoto { display: block; }
');
 
$imagelist .= '<!-- CWGALLERY-->
          <div class="cwgallery" id="cwgallery-'.$hash.'"> 
            <div class="calbum horizon-swiper lightgallery">

          ';
                foreach($images as $key=>$photo){
                  ($show_desc_in_detail) ? $title = $photo->caption.'<br/>'.$photo->description : $title = $photo->caption; 
                  $imagelist .= '<div class="horizon-item" data-sub-html="'.$title.'" data-src="'.JUri::root() . ltrim($photo->path,"/").'" ><a class="cimage '.$caption_position.'" href="'.JUri::root() . ltrim($photo->path,"/").'" data-lightbox="photo-'.$article->id . '-'.$hash.'" data-title="'.$title.'">';
                  $imagelist .= '   <span><img class="cphoto img-responsive" src="'.JUri::root() . ltrim($photo->thumb,"/").'" alt="" title="'.$photo->caption.'"></span>';
                  if($show_info_on_hover) {
                    $imagelist .= '   <div class="cmask '.$caption_color.'"><span class="ccaption">';
                      if($show_caption_on_hover) { $imagelist .= '     <span class="ctitle">'.$photo->caption.'</span>'; }
                      if($show_desc_on_hover) { $imagelist .= '     <span class="cdesc">'.$photo->description.'</span>'; }
                    $imagelist .= '   </span></div>';
                  }                                                                                                                  
                  $imagelist .= '</a></div>';                  
                }
                    
$imagelist .= '            
            </div>
            <div class="cleaner"></div> 
          </div>
';

$imagelist .= '
          <script>
          ( function ( $ ) {
            "use strict";
          
          	$("#cwgallery-'.$hash.'.cwgallery .horizon-swiper").horizonSwiper( {
              animationSpeed: '.$slide_speed.'
            });
           
          } )( jQuery );
          
          </script>
';


// For LightGallery
/*
if($lightbox == 'lightgallery') {
$imagelist .= '           
        <script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
        <script src="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lightgallery.js"></script>
        <script src="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-fullscreen.js"></script>
        <script src="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-thumbnail.js"></script>
        <script src="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-video.js"></script>
        <script src="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-autoplay.js"></script>
        <script src="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-zoom.js"></script>
        <script src="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-hash.js"></script>
        <script src="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-pager.js"></script>
        <script src="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lib/jquery.mousewheel.min.js"></script>                      
'; 
}
*/
?>
          

   