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
          	var gallery = $("#cwgallery-'.$hash.'.cwgallery .calbum.gallery a").simpleLightbox();
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
 * GALLERY LAYOUT 
 *********************************************************/

/* Advanced parameters */  
// columns
$columns = $aparams->get('columns');
if(!isset($columns)){ $columns = $cparams->get('columns','auto'); }
if($columns == 'auto') {}
else{ $columns = 100 / $columns; $columns .= '%'; } // recount to width

// border
$border = $aparams->get('border');
if(!isset($border)){ $border = $cparams->get('border','2'); }
// zoom
$zoom = $aparams->get('zoom');
if(!isset($zoom)){ $zoom = $cparams->get('zoom','5'); }
$zoom = (100 + $zoom) / 100; 


/**
 * Add special styles
 */ 
$document->addStyleDeclaration('
  /* column count */
  #cwgallery-'.$hash.'.cwgallery .gallery a { width: '.$columns.'; float: left !important; }
  /* zoom level */
  .cwgallery .gallery a:hover span {
    -webkit-transform: scale('.$zoom.');
    -moz-transform: scale('.$zoom.');
    -o-transform: scale('.$zoom.');
    -ms-transform: scale('.$zoom.');
    transform: scale('.$zoom.');
    z-index: 5;
  }
  #cwgallery-'.$hash.'.cwgallery .gallery a:hover .cmask {
    -webkit-transform: scale('.$zoom.');
    -moz-transform: scale('.$zoom.');
    -o-transform: scale('.$zoom.');
    -ms-transform: scale('.$zoom.');
    transform: scale('.$zoom.');
  }
  /* border */
  #cwgallery-'.$hash.'.cwgallery .gallery a > span {display: block; border: '.$border.'px solid #fff;  }
  #cwgallery-'.$hash.'.cwgallery a img { display: block; }
');     

$imagelist .= '<!-- CWGALLERY-->
          <div class="cwgallery" id="cwgallery-'.$hash.'"> 
            <div class="calbum gallery lightgallery">
          ';
                foreach($images as $key=>$photo){
                  ($show_desc_in_detail) ? $title = $photo->caption.'<br/>'.str_replace('\n','<br/>',$photo->description) : $title = $photo->caption;
                  if($lightbox == 'lightgallery'){
                    $imagelist .= '<div data-sub-html="'.$title.'" data-src="'.JUri::root() . ltrim($photo->path,"/").'">';
                  }
                  $imagelist .= '<a class="cimage '.$caption_position.'" href="'.JUri::root() . ltrim($photo->path,"/").'" data-lightbox="photo-'.$article->id . '-'.$hash.'" data-title="'.$title.'">';
                  $imagelist .= '   <span><img class="cphoto" src="'.JUri::root() . ltrim($photo->thumb,"/").'" alt="" title="'.$photo->caption.'"></span>';
                  if($show_info_on_hover) {
                    $imagelist .= '   <div class="cmask '.$caption_color.'"><span class="ccaption">';
                      if($show_caption_on_hover) { $imagelist .= '     <span class="ctitle">'.$photo->caption.'</span>'; }
                      if($show_desc_on_hover) { $imagelist .= '     <span class="cdesc">'.$photo->description.'</span>'; }
                    $imagelist .= '   </span></div>';
                  }                                                                                                                  
                  $imagelist .= '</a>'; 
                  if($lightbox == 'lightgallery'){
                    $imagelist .= '</div>';
                  }                 
                }
                    
$imagelist .= '
            </div> 
            <div class="cleaner"></div>
          </div>
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
      