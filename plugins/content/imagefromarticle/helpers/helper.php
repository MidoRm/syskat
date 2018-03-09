<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('syw.image');
jimport('syw.utilities');

class plgImageFromArticleHelper
{		
	static function createImage($configuration, $tmp_path, $clear_cache, $article_id, $title, $credentials = array(), $width, $height, $quality, $spacings, $alignments, $image_paths, $font_paths, $text_sizes, $colors, $rules) 
	{	
		$result = array();
		
		$extensions = get_loaded_extensions();
		if (!in_array('gd', $extensions)) { // missing gd library
			$result[] = JText::_('PLG_CONTENT_IMAGEFROMARTICLE_GD_NOTLOADED');
		} else {
				
			// step 1: get the logo image			
			
			$logo_filename = '';
			if ($image_paths["logo"]) {
				$imageext = JFile::getExt($image_paths["logo"]);			
				$logo_filename = $tmp_path.'/thumb_ifa_logo.'.$imageext;
				if (!is_file(JPATH_ROOT.'/'.$logo_filename) || $clear_cache) { // create the thumbnail
					
					// Note: the preview image file is never found because the path is wrong
					// never mind since we want to create the preview every single time, even if no clear cache 
				
					$logo_image = new SYWImage($image_paths["logo"]);
				
					if (is_null($logo_image->getImagePath())) {
						$result[] = JText::sprintf('PLG_CONTENT_IMAGEFROMARTICLE_ERROR_IMAGEFILEDOESNOTEXIST', $image_paths["logo"]);
						return $result;
					} else if (is_null($logo_image->getImageMimeType())) {
						$result[] = JText::sprintf('PLG_CONTENT_IMAGEFROMARTICLE_ERROR_UNABLETOGETIMAGEPROPERTIES', $image_paths["logo"]);
						return $result;
					} else if (is_null($logo_image->getImage()) || $logo_image->getImageWidth() == 0) {
						$result[] = JText::sprintf('PLG_CONTENT_IMAGEFROMARTICLE_ERROR_UNSUPPORTEDFILETYPE', $image_paths["logo"]);
						return $result;
					} else {
				
// 						switch ($imageext){
// 							case 'jpg': case 'jpeg': $quality = 100; break; // 0 to 100
// 							case 'png': $quality = 0; break; // compression: 0 to 9
// 							default : $quality = -1; break;
// 						}
						
						$thumb_height = $height * $rules["logo_max_height"] / 100; // the logo should take only a percentage of the height space
						if ($thumb_height > $logo_image->getImageHeight()) {
							$thumb_height = $logo_image->getImageHeight(); // we do not want to make the logo thumbnail bigger than the original 							
						}		
						$thumb_width = $logo_image->getImageWidth() * $thumb_height / $logo_image->getImageHeight();			
						
						if ($width >= $height) { // landscape or square
							// make it a thumbnail that cannot be wider than the new image height (so that when squarred, the logo still shows fully)					
							if ($thumb_width > $height) {
								$thumb_width = $height;
								$thumb_height = $logo_image->getImageHeight() * $thumb_width / $logo_image->getImageWidth();
							}
						} else { // portrait
							if ($thumb_width > ($width - $spacings["left"] - $spacings["right"])) {
								$thumb_width = $width - $spacings["left"] - $spacings["right"];
								$thumb_height = $logo_image->getImageHeight() * $thumb_width / $logo_image->getImageWidth();
							}
						}
				
						$creation_success = $logo_image->createThumbnail($thumb_width, $thumb_height, false, $quality, null, $logo_filename);
						if (!$creation_success) {
							$result[] = JText::sprintf('PLG_CONTENT_IMAGEFROMARTICLE_ERROR_THUMBNAILCREATIONFAILEDFOR', $image_paths["logo"]);
							return $result;
						}
					}
					
					$logo_image->destroy();
				}
			}
			
			$image_filename = $tmp_path.'/image_ifa_'.$article_id.'.png';
			if (!is_file(JPATH_ROOT.'/'.$image_filename) || $clear_cache) { // create the image
				
				// Note: the preview image file is never found because the path is wrong
				// never mind since we want to create the preview every single time, even if no clear cache
					
				// step 2: create an empty image with optional background image
				
				$canvas = new SYWImage($image_paths["background"], $width, $height);
				
				if (is_null($canvas->getImage())) {
					if (empty($image_paths["background"])) {
						$result[] = JText::_('PLG_CONTENT_IMAGEFROMARTICLE_ERROR_IMAGECREATIONFAILED');
						return $result;
					} else {
						$result[] = JText::sprintf('PLG_CONTENT_IMAGEFROMARTICLE_ERROR_IMAGECREATIONFAILEDFOR', $image_paths["background"]);
						return $result;
					}
				} else {
					
					// set background color if no image as background
					
					if (empty($image_paths["background"])) {
						$rgb_array = SYWUtilities::hex2RGB($colors["background"]);
						$canvas->setBackgroundColor($rgb_array['red'], $rgb_array['green'], $rgb_array['blue']);
					}
					
					// add logo
						
					if ($logo_filename) {
						$logo = new SYWImage($logo_filename);
						if (is_null($logo->getImage())) {
							$result[] = JText::sprintf('PLG_CONTENT_IMAGEFROMARTICLE_ERROR_IMAGECREATIONFAILEDFOR', $logo_filename);
							return $result;
						} else {
							
							switch ($alignments["logo"]) {
								case 'l': $x = $spacings["left"]; break;
								case 'r': $x = $canvas->getImageWidth() - $logo->getImageWidth() - $spacings["right"]; break;
								default: $x = -1; break;
							}
							
							if ($configuration == 'ltc') {
								$canvas->addImage($logo, $x, $spacings["top"]);
							} else {
								$y = $canvas->getImageHeight() - $logo->getImageHeight() - $spacings["bottom"];
								$canvas->addImage($logo, $x, $y);
							}
						}	
					}				
					
					// add title
					
					if ($width >= $height) { // landscape or square
						$max_width = $height; // keep the text in squarred image, even if the image is a rectangle
						if (($width - $max_width) < ($spacings["left"] + $spacings["right"])) {
							$max_width = $height - $spacings["left"] - $spacings["right"]; // have at least the minimal margins
						}
					} else { // portrait
						$max_width = $width - $spacings["left"] - $spacings["right"];
					}
					
					$max_height = $height * $rules["text_max_height"] / 100; // the text should not take more than a percentage height of the image
					
					$rgb_array = SYWUtilities::hex2RGB($colors["title"]);
					$canvas->addCenteredText($title, $font_paths["title"], $text_sizes["title"], $rgb_array['red'], $rgb_array['green'], $rgb_array['blue'], $max_width, $max_height, $rules["text_offset_y"], $spacings["title"]);
						
					// add credentials
						
					$rgb_array = SYWUtilities::hex2RGB($colors["credentials"]);
					$index = 0;
					foreach ($credentials as $credential) {
						
						if ($font_paths["credentials"]) {
							$text_box = imagettfbbox($text_sizes["credentials"], 0, $font_paths["credentials"], $credential);
							$text_width = $text_box[2] - $text_box[0];
							if ($configuration == 'ltc') {
								$y = $height - $spacings["bottom"] - $index * ($text_sizes["credentials"] + $spacings["credentials"]);
							} else {
								$y = $spacings["top"] + $text_sizes["credentials"] + $index * ($text_sizes["credentials"] + $spacings["credentials"]);
							}
						} else {
							$text_width = imagefontwidth($text_sizes["credentials"]) * strlen($credential);
							$text_height = imagefontheight($text_sizes["credentials"]);
							if ($configuration == 'ltc') {
								$y = $height - $spacings["bottom"] - $index * ($text_height + $spacings["credentials"]); // 8 is arbitrary
							} else {
								$y = $spacings["top"] + $text_height + $index * ($text_height + $spacings["credentials"]); // 8 is arbitrary
							}
						}
						
						switch ($alignments["credentials"]) {
							case 'l': $x = $spacings["left"]; break;
							case 'r': 								
								if ($font_paths["credentials"]) {
									$text_box = imagettfbbox($text_sizes["credentials"], 0, $font_paths["credentials"], $credential);
									$text_width = $text_box[2] - $text_box[0];
								} else {
									$text_width = imagefontwidth($text_sizes["credentials"]) * strlen($credential);
								}								
								$x = $canvas->getImageWidth() - $text_width - $spacings["right"]; 
								break;
							default: $x = -1; break;
						}
						
						$canvas->addText($credential, $font_paths["credentials"], $text_sizes["credentials"], $x, $y, $rgb_array['red'], $rgb_array['green'], $rgb_array['blue']);
						$index++;
					}
						
					// create image
						
					$creation_success = $canvas->createImage($tmp_path.'/image_ifa_'.$article_id.'.png', 'png', $quality);
					if (!$creation_success) {
						$result[] = JText::sprintf('PLG_CONTENT_IMAGEFROMARTICLE_ERROR_IMAGECREATIONFAILED');
						return $result;
					}
				}
				
				$canvas->destroy();
			}			
		}			
		
		return $result;		
	}
	
}
?>