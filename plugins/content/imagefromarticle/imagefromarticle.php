<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
*/

// no direct access
defined( '_JEXEC' ) or die;

jimport('joomla.plugin.plugin');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

if (!JFolder::exists(JPATH_ROOT.'/libraries/syw')) {
	return;
}

jimport('syw.cache');
jimport('syw.text');

require_once (dirname(__FILE__).'/helpers/helper.php');
require_once (dirname(__FILE__).'/headerfilesmaster.php');

class plgContentImageFromArticle extends JPlugin
{	
	protected $autoloadLanguage = true;
	
	public function onContentPrepare($context, &$row, &$params, $page = 0)
	{
		$regex = '/{imagefromarticle}/i';
		
		// force on article only views
		$canProceed = ($context == 'com_content.article');
		if (!$canProceed) {
			$row->text = preg_replace($regex, '', $row->text, 1);
		}
		
		$view = JFactory::getApplication()->input->getCmd('view', '');
		if ($view == 'article') {	
		
			// find all instances of plugin and put in $matches
			preg_match_all($regex, $row->text, $matches, PREG_SET_ORDER);
		
			if ($matches) {	
				$done_once = false;
				foreach ($matches as $match) {
					if (!$done_once) {
						$row->text = preg_replace($regex, $this->_createOutputBefore($context, $row, $params, $page), $row->text, 1); // do only once
						$done_once = true;
					} else {
						$row->text = preg_replace($regex, '', $row->text, 1);
					}
				}
			}		
		}
			
		$row->text = preg_replace($regex, '', $row->text, 1);
	}
	
	public function onContentBeforeDisplay($context, &$row, &$params, $page = 0)
	{
		$html = '';
		
		$canProceed = ($context == 'com_content.article');
		if (!$canProceed) {
			return $html;
		}
		
		$view = JFactory::getApplication()->input->getCmd('view', '');
		if ($view == 'article') {	
					
			// exclude specific article		
				
			$articles_to_exclude = trim($this->params->get('ex', ''));
			if (!empty($articles_to_exclude)) {
				$article_ids = explode(',', $articles_to_exclude);
				foreach ($article_ids as $article_id) {
					if (intval($article_id) == $row->id) {
						return $html; // found article to exclude
					}
				}
			}
			
			// exclude if fulltext image exists
			
			if ($this->params->get('ex_fullimage', true)) {
				$images  = json_decode($row->images);
				if (!empty($images->image_fulltext)) {
					return $html;
				}
			}
				
			// include specific article
				
			$found_article = false;
			
			$articles_to_include = trim($this->params->get('in', ''));
			if (!empty($articles_to_include)) {
				$article_ids = explode(',', $articles_to_include);
				foreach ($article_ids as $article_id) { 
					if (intval($article_id) == $row->id) {
						$found_article = true;
					}
				}
			}
			
			// if no specific article found, look through the categories
			
			if (!$found_article) {
				if (!$this->_foundCategory($row->catid)) {
					return $html;				
				}
			}
			
			return $this->_createOutputBefore($context, $row, $params, $page);
		}
		
		return $html;
	}
	
	protected function _foundCategory($category_id) 
	{	
		static $found = array();
	
		if (isset($found[$category_id])) {
			return $found[$category_id];
		}
	
		$found[$category_id] = false;
	
		$categories_array = $this->params->get('catid', array());
			
		$array_of_category_values = array_count_values($categories_array);
		if (isset($array_of_category_values['none']) && $array_of_category_values['none'] > 0) { // 'none' was selected
			return false;
		}
		if (isset($array_of_category_values['all']) && $array_of_category_values['all'] > 0) { // 'all' was selected
			$found[$category_id] = true;
		} else {
			// sub-category inclusion
			$get_sub_categories = $this->params->get('includesubcategories', 'no');
			if ($get_sub_categories != 'no') {
				$categories_object = JCategories::getInstance('Content');
				foreach ($categories_array as $category) {
					$category_object = $categories_object->get($category); // if category unpublished, unset
					if (isset($category_object) && $category_object->hasChildren()) {
						if ($get_sub_categories == 'all') {
							$sub_categories_array = $category_object->getChildren(true); // true is for recursive
						} else {
							$sub_categories_array = $category_object->getChildren();
						}
						foreach ($sub_categories_array as $subcategory_object) {
							$categories_array[] = $subcategory_object->id;
						}
					}
				}
				$categories_array = array_unique($categories_array);
			}
	
			foreach ($categories_array as $category) {
				if ($category_id == intval($category)) {
					$found[$category_id] = true;
				}
			}
		}
	
		return $found[$category_id];
	}
	
	protected function _createOutputBefore($context, &$row, &$params, &$page = 0, $view = 'article')
	{
		$output = '';	

		$doc = JFactory::getDocument();
		$app = JFactory::getApplication();
		
		$db = JFactory::getDbo();
		
		$urlPath = JURI::base().'plugins/content/imagefromarticle/';
		
		// init parameters
		
		$configuration = $this->params->get('configuration', 'ltc');
		
		$subdirectory = 'thumbnails/ifa';
		if ($this->params->get('tmp_path', 'images') == 'cache') {
			$subdirectory = 'plg_content_imagefromarticle';
		}
		$tmp_path = SYWCache::getTmpPath($this->params->get('tmp_path', 'images'), $subdirectory);
		
		$clear_cache = $this->params->get('clear_cache', 0);
		
		$centered_text = $row->title;
		
		$credentials = array();
		
		$image_width = $this->params->get('width', 320);
		
		$image_height = $this->params->get('height', 240);
		
		$quality = $this->params->get('quality', 60);
		if ($quality > 100) {
			$quality = 100;
		}
		if ($quality < 0) {
			$quality = 0;
		}		
		$pngQuality = ($quality - 100) / 11.111111;
		$quality = round(abs($pngQuality));
		
		$spacings = array("top" => 8, "bottom" => 8, "left" => 8, "right" => 8,"title" => 4, "credentials" => 4);
		$spacings["top"] = $this->params->get('margin_top', 8);
		$spacings["bottom"] = $this->params->get('margin_bottom', 8);
		$spacings["left"] = $this->params->get('margin_left', 8);
		$spacings["right"] = $this->params->get('margin_right', 8);
		$spacings["title"] = $this->params->get('text_spacing', 4);
		$spacings["credentials"] = $this->params->get('credentials_spacing', 4);
		
		$alignments = array("logo" => "c", "title" => "c", "credentials" => "c");
		$alignments["logo"] = $this->params->get('logo_align', 'c');
		//$alignments["title"] = $this->params->get('text_align', 'c');
		$alignments["credentials"] = $this->params->get('credentials_align', 'c');
		
		$image_paths = array("background" => "", "logo" => "");	
		
		$font_paths = array("title" => "", "credentials" => "");
		
		$text_sizes = array("title" => 35, "credentials" => 8);
		$text_sizes["title"] = $this->params->get('text_size', 35);
		$text_sizes["credentials"] = $this->params->get('credentials_size', 8);
		
		$colors = array("background" => "#FFFFFF", "title" => "#000000", "credentials" => "#000000");
		$colors["background"] = $this->params->get('bg_color', '#FFFFFF');
		$colors["title"] = $this->params->get('text_color', '#000000');
		$colors["credentials"] = $this->params->get('credentials_color', '#000000');
		
		$rules = array("logo_max_height" => 25, "text_max_height" => 50, "text_offset_y" => 0);
		$rules["logo_max_height"] = $this->params->get('logo_max_height', 25);
		$rules["text_max_height"] = $this->params->get('text_max_height', 50);
		$rules["text_offset_y"] = $this->params->get('text_offset_y', 0);
			
		// parameters
			
		if ($clear_cache) {
			
			// fonts			
			
			if ($this->params->get('text_font', '') && JFile::exists(JPATH_ROOT.'/media/syw_imagefromarticle/fonts/'.$this->params->get('text_font', ''))) {
				$font_paths["title"] = JPATH_ROOT.'/media/syw_imagefromarticle/fonts/'.$this->params->get('text_font', '');
			} else {
				$text_sizes["title"] = 5;
			}
			if ($this->params->get('credentials_font', '') && JFile::exists(JPATH_ROOT.'/media/syw_imagefromarticle/fonts/'.$this->params->get('credentials_font', ''))) {
				$font_paths["credentials"] = JPATH_ROOT.'/media/syw_imagefromarticle/fonts/'.$this->params->get('credentials_font', '');
			} else {
				$text_sizes["credentials"] = 2;
			}
			
			// text
			
			$letter_count = trim($this->params->get('l_count'));
			$number_of_letters = -1;
			if ($letter_count != '') {
				$number_of_letters = (int)($letter_count);
			}
			
			$use_intro = false;
			$use_meta = false;
			
			$textparam = $this->params->get('text', 'title');
			
			if (substr($textparam, 0, strlen('jfield:text')) === 'jfield:text'
				|| substr($textparam, 0, strlen('jfield:textarea')) === 'jfield:textarea') {
				
				$type_temp = explode(':', $textparam); // $textparam can be jfield:textfield:fieldid or jfield:textarea:fieldid
				
				$query = $db->getQuery(true);
				
				// not using GROUP_CONCAT to make sure compatible with all databases
				$query->select($db->quoteName(array('fv.value', 'f.label'), array('value', 'label')));
				$query->from($db->quoteName('#__fields_values', 'fv'));
				$query->where($db->quoteName('fv.field_id').'= '.$type_temp[2]);
				$query->where($db->quoteName('fv.item_id').'= '.$row->id);
				//$query->where($db->quoteName('f.access').' IN ('.$groups.')');
				$query->join('LEFT', $db->quoteName('#__fields', 'f').' ON '.$db->quoteName('f.id').' = '.$db->quoteName('fv.field_id'));
				
				$db->setQuery($query);
				
				try {
					$results = $db->loadAssocList();
				} catch (RuntimeException $e) {
					//JFactory::getApplication()->enqueueMessage(JText::_('JERROR_AN_ERROR_HAS_OCCURRED'), 'error');
					$results = array();
				}
				
				if (count($results) > 0) {
					foreach ($results as $result) {
						$text_value = '';
						$text_value_array = explode("\n", $result['value']); // remove new lines in the textarea - textarea formatting is ignored (new lines are not supported in the image library)
						foreach ($text_value_array as $text_value_line) {
							$text_value .= trim($text_value_line, " \t\n\r\0\x0B").' ';
						}
						if ($text_value) {
							$centered_text = trim($text_value);
						}
					}
				}
			} else {
				switch ($textparam)	{
					case 'intrometa':
						$use_intro = (trim($row->introtext) != '') ? true : false;
						if (!$use_intro) {
							$use_meta = (trim($row->metadesc) != '') ? true : false;
						}
						break;
					case 'metaintro':
						$use_meta= (trim($row->metadesc) != '') ? true : false;
						if (!$use_meta) {
							$use_intro = (trim($row->introtext) != '') ? true : false;
						}
						break;
					case 'meta': $use_meta = (trim($row->metadesc) != '') ? true : false; break;
					case 'intro': $use_intro = (trim($row->introtext) != '') ? true : false; break;
				}
			}
			
			if ($use_intro) {
				$centered_text = SYWText::getText($row->introtext, 'html', $number_of_letters, true, '');
			} else if ($use_meta) {
				$centered_text = SYWText::getText($row->metadesc, 'txt', $number_of_letters, false, '');
			} else {
				$centered_text = SYWText::getText($centered_text, 'txt', $number_of_letters, false, '');
			}	
			
			// credentials
			
			$credentials_param = trim( (string) $this->params->get('credentials', ''));
			if ($credentials_param) {
				
				$user = JFactory::getUser($row->created_by);
				// $row->created_by can be the id of a user that does not exist anymore, resulting in warning:
				// JUser: :_load: Unable to load user with ID:
				
				$date_format = JText::_('PLG_CONTENT_IMAGEFROMARTICLE_FORMAT_DATE');
				if (empty($date_format)) {
					$date_format = $this->params->get('d_format', 'd F Y');
				}
				
				$patterns = array();
				$patterns[0] = '/{author}/';
				$patterns[1] = '/{author_alias}/';
				$patterns[2] = '/{date_created}/';
				$patterns[3] = '/{date_modified}/';
				$patterns[4] = '/{date_published}/';
				
				$replacements = array();
				$replacements[0] = htmlspecialchars($user->name);
				if (trim($row->created_by_alias) != '') {
					$replacements[1] = htmlspecialchars($row->created_by_alias);
				} else {
					$replacements[1] = $replacements[0];
				}
				$replacements[2] = '';
				if ($row->created != $db->getNullDate()) {
					$replacements[2] = JHTML::_('date', $row->created, $date_format);
				}
				$replacements[3] = '';
				if ($row->modified != $db->getNullDate()) {
					$replacements[3] = JHTML::_('date', $row->modified, $date_format);
				}
				$replacements[4] = '';
				if ($row->publish_up != $db->getNullDate()) {
					$replacements[4] = JHTML::_('date', $row->publish_up, $date_format);
				}
				
				$credentials = preg_replace($patterns, $replacements, $credentials_param);
				
				$credentials = array_map('trim', (array) explode("\n", $credentials));
				
				// reverse credentials
				if ($configuration == 'ltc') {
					$credentials = array_reverse($credentials);
				}
			} 
			
			// images			
			
			if ($this->params->get('bg_fullimage', false)) {
				$images = json_decode($row->images);
				if (!empty($images->image_fulltext)) {
					$image_paths["background"] = $images->image_fulltext;
				}
			}
			
			if (empty($image_paths["background"]) && $this->params->get('default_bg', 'picture') != 'none') {
			
				if ($this->params->get('default_bg', 'picture') == 'folder') {
					
					$directory = JPATH_SITE.'/images'.$this->params->get('bg_folder');
					
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
							$image_paths["background"] = $directory.'/'.$image_list[0];
						} else {
							JFactory::getApplication()->enqueueMessage(JText::_('PLG_CONTENT_IMAGEFROMARTICLE_WARNING_NOIMAGEFOUND'), 'warning');
						}
					} else {
						JFactory::getApplication()->enqueueMessage(JText::_('PLG_CONTENT_IMAGEFROMARTICLE_ERROR_WRONGFOLDER'), 'error');
					}
				} else {
					$image_paths["background"] = $this->params->get('bg_picture', '');
				}
			}
			
			if ($this->params->get('logo_picture', '')) {
				$image_paths["logo"] = $this->params->get('logo_picture', '');
			}
		}
			
		// image creation
		
		$create_only = $this->params->get('create_only', 0);
		
		$errors = plgImageFromArticleHelper::createImage($configuration, $tmp_path, $clear_cache, $row->id, $centered_text, $credentials, $image_width, $image_height, $quality, $spacings, $alignments, $image_paths, $font_paths, $text_sizes, $colors, $rules);
		if (empty($errors)) {
			if (!$create_only) {
				$output .= '<div class="imagefromarticle">';
				$output .= '<img src="'.$tmp_path.'/image_ifa_'.$row->id.'.png" width="'.$image_width.'" height="'.$image_height.'" alt="'.htmlspecialchars($row->title).'" />';
				$output .= '</div>';
			}
		} else {
			foreach ($errors as $error) {
				$app->enqueueMessage($error, 'error');
				return $output;
			}
		}
			
		// add styles
		
		if (!$create_only) {
		
			$user_styles = trim($this->params->get('styles', ''));
			if (!empty($user_styles)) {
				$user_styles = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $user_styles); // minify the CSS code
			}
			
			$cache_css = new IFA_CSSFileCache('plg_content_imagefromarticle', $this->params);
			$cache_css->addDeclaration($user_styles);
			$result = $cache_css->cache('style.css', $this->params->get('clear_header_files_cache', true));
			
			if ($result) {
				$doc->addStyleSheet(JURI::base(true).'/cache/plg_content_imagefromarticle/style.css');
			}
		}
				
		// Open Graph Protocol meta tags	
					
		// $doc->setMetaData('og:title', 'My Webpage Title'); // problem: uses 'name' instead of 'property' -> cannot use
		
		//if ($this->params->get('og_sitename', false)) {
			// <meta property="og:site_name" content=""/>
		//}
		
		if ($this->params->get('twitter_cards', false)) {
			$doc->addCustomTag('<meta name="twitter:card" content="summary" />');
		
			if ($this->params->get('twitter_site', false) && trim($this->params->get('twitter_site_profile', '')) != '') {
				$doc->addCustomTag('<meta name="twitter:site" content="@'.$this->params->get('twitter_site_profile', '').'" />');
			}
			
			if ($this->params->get('twitter_image', false)) {
				$doc->addCustomTag('<meta name="twitter:image" content="'.JURI::base().$tmp_path.'/image_ifa_'.$row->id.'.png" />');
			}
		}
				
		if ($this->params->get('og_title', false)) {
			$doc->addCustomTag('<meta property="og:title" content="'.htmlspecialchars($row->title).'" />');
		}
		
		if ($this->params->get('og_description', false)) {
			if (!empty($row->metadesc)) {
				$doc->addCustomTag('<meta property="og:description" content="'.htmlspecialchars($row->metadesc).'"/>');
			}
		}
		
		if ($this->params->get('og_type', false)) {
			$doc->addCustomTag('<meta property="og:type" content="article" />');
		}
		
		if ($this->params->get('og_url', false)) {
			$doc->addCustomTag('<meta property="og:url" content="'.JURI::current().'"/>');
		}
			
		if ($this->params->get('og_image', false)) {
			$image_width_og = $this->params->get('og_imagewidth', 1200);
			$image_height_og = $this->params->get('og_imageheight', 627);
			$errors = plgImageFromArticleHelper::createImage($configuration, $tmp_path, $clear_cache, $row->id.'_og', $centered_text, $credentials, $image_width_og, $image_height_og, $quality, $spacings, $alignments, $image_paths, $font_paths, $text_sizes, $colors, $rules);
			if (empty($errors)) {				
				$doc->addCustomTag('<meta property="og:image" content="'.JURI::base().$tmp_path.'/image_ifa_'.$row->id.'_og.png" />');
				// <meta property="og:image:secure_url" content="https://secure.example.com/ogp.jpg" />
				$doc->addCustomTag('<meta property="og:image:type" content="image/png" />');
				$doc->addCustomTag('<meta property="og:image:width" content="'.$image_width_og.'" />');
				$doc->addCustomTag('<meta property="og:image:height" content="'.$image_height_og.'" />');
			} else {
				foreach ($errors as $error) {
					$app->enqueueMessage($error, 'error');
					return $output;
				}
			}
		}
		
		return $output;
	}
}
?>
