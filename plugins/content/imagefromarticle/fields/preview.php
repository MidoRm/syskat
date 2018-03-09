<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die ;

jimport('joomla.form.formfield');
jimport('joomla.plugin.helper');

jimport('syw.image');
jimport('syw.utilities');
jimport('syw.cache');

class JFormFieldPreview extends JFormField 
{		
	public $type = 'Preview';

	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	protected function getLabel() {		

		$html = '';
		
		$html .= '<div style="clear: both;"></div>';
		
		return $html;
	}

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput() {
		
		$html = '';
				
		if (!JPluginHelper::isEnabled('content', 'imagefromarticle')) {			
			
			$html .= '<div class="alert alert-warning">';			
			$html .= '<span>';
			$html .= JText::_('PLG_CONTENT_IMAGEFROMARTICLE_MESSAGE_ENABLEPLUGIN');
			$html .= '</span>';
			$html .= '</div>';
			
			return $html;
		}
		
		$app = JFactory::getApplication();
			
		$plugin = JPluginHelper::getPlugin('content', 'imagefromarticle');
		
		// get plugin parameters
		
		$plugin_params = new JRegistry();
		$plugin_params->loadString($plugin->params);	
				
		$tmp_path_param = $plugin_params->get('tmp_path', 'default');
		$tmp_path = $app->getCfg('tmp_path');
		$tmp_path_site = JURI::root().str_replace(JPATH_ROOT.'/', '', $app->getCfg('tmp_path'));
		
		if ($tmp_path_param == 'images') {
			$media_params = JComponentHelper::getParams('com_media');
			$images_path = $media_params->get('image_path', 'images');
		
			if (SYWCache::isFolderReady(JPATH_ROOT.'/'.$images_path, 'thumbnails/ifa')) {
				$tmp_path = JPATH_ROOT.'/'.$images_path.'/thumbnails/ifa';
				$tmp_path_site = JURI::root().$images_path.'/thumbnails/ifa';
			}
		} else if ($tmp_path_param == 'cache') {
			if (SYWCache::isFolderReady(JPATH_CACHE, 'plg_content_imagefromarticle')) {
				$tmp_path = JPATH_CACHE.'/plg_content_imagefromarticle';
				$tmp_path_site = JURI::root().'administrator/cache/plg_content_imagefromarticle';
			}
		}	
		
		$quality = $plugin_params->get('quality', 100);
		if ($quality > 100) {
			$quality = 100;
		}
		if ($quality < 0) {
			$quality = 0;
		}
		
		$pngQuality = ($quality - 100) / 11.111111;
		$quality = round(abs($pngQuality));
						
		$image_width = $plugin_params->get('width', 320);
		$image_height = $plugin_params->get('height', 240);	

		$configuration = $plugin_params->get('configuration', 'ltc');
		
		$credentials = trim( (string) $plugin_params->get('credentials', ''));
		if ($credentials) {
			$patterns = array();
			$patterns[0] = '/{author}/';
            $patterns[1] = '/{author_alias}/';
			$patterns[2] = '/{date_created}/';
			$patterns[3] = '/{date_modified}/';
			$patterns[4] = '/{date_published}/';
			
			$replacements = array();
			$replacements[0] = '[author name here]';
			$replacements[1] = '[author alias here]';
			$replacements[2] = '[date created]';
			$replacements[3] = '[date modified]';
			$replacements[4] = '[date published]';
			
			$credentials = preg_replace($patterns, $replacements, $credentials);
			
			$credentials = array_map('trim', (array) explode("\n", $credentials));
						
			// reverse credentials
			if ($configuration == 'ltc') {
				$credentials = array_reverse($credentials);
			}
		} else {
			$credentials = array();
		}
		
		$image_paths = array("background" => "", "logo" => "");	
		
		if ($plugin_params->get('default_bg', 'picture') != 'none') {
		
			if ($plugin_params->get('default_bg', 'picture') == 'folder') {
				
				$directory = JPATH_SITE.'/images'.$plugin_params->get('bg_folder');
				
				if (JFolder::exists($directory)) {
					
					$image_list = array();
					
					foreach(JFolder::files($directory) as $image) {
						$extension = JFile::getExt($image);
						if ($extension == 'jpg' || $extension == 'png') {
							$image_list[] = $image;
						}
					}
					
					if (count($image_list) > 0) {
						shuffle($image_list);
						$image_paths["background"] = JPATH_ROOT.'/images'.$plugin_params->get('bg_folder').'/'.$image_list[0];
					} else {
						JFactory::getApplication()->enqueueMessage(JText::_('PLG_CONTENT_IMAGEFROMARTICLE_WARNING_NOIMAGEFOUND'), 'warning');
					}
				} else {
					JFactory::getApplication()->enqueueMessage(JText::_('PLG_CONTENT_IMAGEFROMARTICLE_ERROR_WRONGFOLDER'), 'error');
				}
			} else {
				if ($plugin_params->get('bg_picture', '')) {
					$image_paths["background"] = JPATH_ROOT.'/'.$plugin_params->get('bg_picture', '');
				}
			}
		}
		
		if ($plugin_params->get('logo_picture', '')) {	
			$image_paths["logo"] = JPATH_ROOT.'/'.$plugin_params->get('logo_picture', '');
		}
		
		$colors = array("background" => "#FFFFFF", "title" => "#000000", "credentials" => "#000000");	
		$colors["background"] = $plugin_params->get('bg_color', '#FFFFFF');
		$colors["title"] = $plugin_params->get('text_color', '#000000');
		$colors["credentials"] = $plugin_params->get('credentials_color', '#000000');
		
		$text_sizes = array("title" => 35, "credentials" => 8);
		$text_sizes["title"] = $plugin_params->get('text_size', 35);
		$text_sizes["credentials"] = $plugin_params->get('credentials_size', 8);
		
		$spacings = array("top" => 8, "bottom" => 8, "left" => 8, "right" => 8, "title" => 4, "credentials" => 4);
		$spacings["top"] = $plugin_params->get('margin_top', 8);
		$spacings["bottom"] = $plugin_params->get('margin_bottom', 8);
		$spacings["left"] = $plugin_params->get('margin_left', 8);
		$spacings["right"] = $plugin_params->get('margin_right', 8);
		$spacings["title"] = $plugin_params->get('text_spacing', 4);
		$spacings["credentials"] = $plugin_params->get('credentials_spacing', 4);
		
		$font_paths = array("title" => "", "credentials" => "");
		if ($plugin_params->get('text_font', '') && JFile::exists(JPATH_ROOT.'/media/syw_imagefromarticle/fonts/'.$plugin_params->get('text_font', ''))) {
			$font_paths["title"] = JPATH_ROOT.'/media/syw_imagefromarticle/fonts/'.$plugin_params->get('text_font', '');
        } else {
			$text_sizes["title"] = 5;
		}
		if ($plugin_params->get('credentials_font', '') && JFile::exists(JPATH_ROOT.'/media/syw_imagefromarticle/fonts/'.$plugin_params->get('credentials_font', ''))) {
			$font_paths["credentials"] = JPATH_ROOT.'/media/syw_imagefromarticle/fonts/'.$plugin_params->get('credentials_font', '');
        } else {
			$text_sizes["credentials"] = 2;
		}
		
		$alignments = array("logo" => "c", "title" => "c", "credentials" => "c");
		$alignments["logo"] = $plugin_params->get('logo_align', 'c');
		//$alignments["title"] = $plugin_params->get('text_align', 'c');
		$alignments["credentials"] = $plugin_params->get('credentials_align', 'c');	

		$rules = array("logo_max_height" => 25, "text_max_height" => 50, "text_offset_y" => 0);
		$rules["logo_max_height"] = $plugin_params->get('logo_max_height', 25);	
		$rules["text_max_height"] = $plugin_params->get('text_max_height', 50);
		$rules["text_offset_y"] = $plugin_params->get('text_offset_y', 0);
		
		$text_for_preview = $plugin_params->get('text_preview', '');		
		
		// preview image creation
		
		$errors = plgImageFromArticleHelper::createImage($configuration, $tmp_path, true, 'preview', $text_for_preview, $credentials, $image_width, $image_height, $quality, $spacings, $alignments, $image_paths, $font_paths, $text_sizes, $colors, $rules);
		if (empty($errors)) {			
			ob_start();
			require_once dirname(__FILE__).'/'.strtolower($this->type).'/tmpl/default.php';
			$html .= ob_get_contents();
			ob_end_clean();
		} else {
			foreach ($errors as $error) {	
				$html .= '<div class="alert alert-error">';
				$html .= '<span>';
				$html .= $error;
				$html .= '</span>';
				$html .= '</div>';
			}
		}
		
		return $html;
	}

}
?>