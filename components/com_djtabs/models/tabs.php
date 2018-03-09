<?php
/**
 * @version 1.0
 * @package DJ-Tabs
 * @copyright Copyright (C) 2013 DJ-Extensions.com, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Piotr Dobrakowski - piotr.dobrakowski@design-joomla.eu
 *
 * DJ-Tabs is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-Tabs is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-Tabs. If not, see <http://www.gnu.org/licenses/>.
 *
 */

defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.modellist');
$com_path = JPATH_SITE.'/components/com_content/';
require_once (JPATH_BASE . DS . 'components' . DS . 'com_content' . DS . 'helpers' . DS . 'route.php');
require_once (JPATH_BASE . DS . 'components' . DS . 'com_djtabs' . DS . 'helpers' . DS . 'helper.php');
JModelLegacy::addIncludePath(JPATH_BASE . DS . 'components' . DS . 'com_content' . DS . 'models');
JModelLegacy::addIncludePath($com_path . '/models', 'ContentModel');
require_once(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'query.php');

class DJTabsModelTabs extends JModelList
{

 	public static function getTabs($groupid) {

        $db = JFactory::getDBO();
		
        $query = 'SELECT * FROM #__djtabs_items ' 
        		.'WHERE group_id = '.$groupid.' AND published=1 '
        		.'ORDER BY ordering ';
        $db -> setQuery($query);
        $tabs = $db -> loadObjectList();

        foreach ($tabs as $tab) {
        	    	
			$registry = new JRegistry();
            $registry -> loadString($tab -> params);
            $tab -> params = $registry ;//-> toObject();
//echo '<pre>';print_r($tab -> params);echo '</pre>';//die();
            $registry = JComponentHelper::getParams('com_djtabs'); //$app->getParams();
		   
			$param_names = array('date','date_position','title','title_link','title_char_limit','image','image_position','image_link','image_width','image_height','description','description_link','HTML_in_description','description_char_limit','readmore_button','category','category_link','author');
			
			//new 1.1.2 - date_format - global param only
			$tab->params->set('date_format',$registry->get('date_format','l, d F Y'));
			
			foreach ($param_names as $name){  //assigning global params if not numeric or not set/set global
				if (!is_numeric($tab -> params -> get($name)))
					$tab -> params -> set($name,$registry->get($name));
			}		
				
			if ($tab->params->get('readmore_text','')=='')
				$tab->params->set('readmore_text',$registry->get('readmore_text'));

            if ($tab -> type == 1)//category
                $tab->content = self::getArticleCategory($tab->params);
            else if ($tab -> type == 2)//article
                $tab->content = self::getArticle($tab->params);	
			else if ($tab -> type == 3)//module
                $tab->mod_pos = $tab->params->get('module_position');
			else if ($tab -> type == 4)//video link
                $tab->video_link = self::convertVideoLink($tab->params->get('video_link'));
			
        }

        return $tabs;
    }


    static function getArticle($tab_params) {

        $app = JFactory::getApplication();
		
        $model_article = JModelLegacy::getInstance('Article', 'ContentModel', array('ignore_request' => true));
        $model_article -> setState('params', $app -> getParams('com_content'));//merging specific srticle params into global article params
        
		$article_id = $tab_params -> get('article_id');
		$item = $model_article -> getItem($article_id);
		
        if ($item) {

            $item -> link = JRoute::_(ContentHelperRoute::getArticleRoute($item -> id, $item -> catid));			
            $item -> cat_link = JRoute::_(ContentHelperRoute::getCategoryRoute($item -> catid));
			
			self::cleanText($item->introtext);
			$item->introtext = JHTML::_('content.prepare', $item->introtext);
			
			$item->params = ($item->params ? $item->params : $app -> getParams('com_content'));//in case of not loading article params
			self::mergeArticleParams($tab_params, $item->params);
			
        }

        return $item;
    }


	static function getArticleCategory($tab_params) {

		$db = JFactory::getDbo();

		$cat_ids = $tab_params->get('category_id', 'NULL');
		$art_limit = $tab_params->get('article_limit', '');
		$art_order = $tab_params->get('articles_ordering','ordering');
		$art_order_dir = $tab_params->get('articles_ordering_direction','');
		$art_min_date = $tab_params->get('articles_min_date','');
		$art_max_date = $tab_params->get('articles_max_date','');		
		$max_cat_lvl = $tab_params->get('max_category_levels','1');
		
		$cat_ids = is_array($cat_ids) ? implode(',',$cat_ids) : $cat_ids;		
		
		if($art_order == "random") $art_order = "RAND()";
		else if($art_order == "ordering") $art_order = "i.".$art_order;
		else $art_order = "i.".$art_order." ".($art_order_dir == '-1' ? 'DESC' : 'ASC');
		
		$query="SELECT i.*, parent.title as category_title, u.name as author ".
				"FROM #__content AS i LEFT JOIN #__users u ON i.created_by=u.id, ".
				"#__categories AS node, ".
				"#__categories AS parent ".
				"WHERE node.lft BETWEEN parent.lft AND parent.rgt AND node.id=i.catid ".
				"AND i.state= 1 AND now() >= i.publish_up and ( now() <= i.publish_down  or i.publish_down < i.publish_up) ".
					($art_min_date ? " AND i.created>=".$db->quote($art_min_date) : "").($art_max_date ? " AND i.created<=".$db->quote($art_max_date) : "")." ".
				"AND node.level-parent.level<".$max_cat_lvl." AND parent.id IN (".$cat_ids.") ".
				"ORDER BY ".$art_order.", i.title ".($art_limit ? "LIMIT ".$art_limit : "");	

		$db->setQuery((string)$query);
		$items = $db->loadObjectList();

		foreach($items as $item){
			
			$item -> link = JRoute::_(ContentHelperRoute::getArticleRoute($item -> id, $item -> catid));
			$item -> cat_link = JRoute::_(ContentHelperRoute::getCategoryRoute($item -> catid));
					
			self::cleanText($item->introtext);
			$item->introtext = JHTML::_('content.prepare', $item->introtext);
			
			self::setArticleCategoryParams($tab_params, $item);
			
		}        

     return $items;
	 
    }


	static function mergeArticleParams($tab_params, &$article_params) {

		if ($tab_params->get('author')!='')
			$article_params -> set('show_author',$tab_params->get('author'));
		if ($tab_params->get('title')!='')
			$article_params -> set('show_title',$tab_params->get('title'));
		if ($tab_params->get('title_link')!='')
			$article_params -> set('link_titles',$tab_params->get('title_link'));
		if ($tab_params->get('category')!='')
			$article_params -> set('show_category',$tab_params->get('category'));
		if ($tab_params->get('category_link')!='')
			$article_params -> set('link_category',$tab_params->get('category_link'));
		if ($tab_params->get('date')!='')
			$article_params -> set('show_create_date',$tab_params->get('date'));
		if ($tab_params->get('readmore_button')!='')
			$article_params -> set('show_readmore',$tab_params->get('readmore_button'));

	}
	
	
	static function setArticleCategoryParams($tab_params, &$item) {

		$app = JFactory::getApplication();
        $article_params = $app->getParams('com_content');
		
		$item->show_author = ($tab_params->get('author')!='') ? $tab_params->get('author') : $article_params -> get('show_author',0);
		$item->show_title = ($tab_params->get('title')!='') ? $tab_params->get('title') : $article_params -> get('show_title',0);
		$item->link_titles = ($tab_params->get('title_link')!='') ? $tab_params->get('title_link') : $article_params -> get('link_titles',0);
		$item->show_category = ($tab_params->get('category')!='') ? $tab_params->get('category') : $article_params -> get('show_category',0);
		$item->link_category = ($tab_params->get('category_link')!='') ? $tab_params->get('category_link') : $article_params -> get('link_category',0);
		$item->show_create_date = ($tab_params->get('date')!='') ? $tab_params->get('date') : $article_params -> get('show_create_date',0);
		$item->show_readmore = ($tab_params->get('readmore_button')!='') ? $tab_params->get('readmore_button') : $article_params -> get('show_readmore',0);

	}

	static function cleanText(&$text) {
		
		$text = preg_replace('/{loadposition\s+(.*?)}/i', '', $text);
		$text = preg_replace('/{loadmodule\s+(.*?)}/i', '', $text);
		$text = preg_replace('/{djmedia\s*(\d*)}/i', '', $text);
		$text = preg_replace('/{djsuggester\s+(.*?)}/i', '', $text);
		$text = preg_replace('/{djtabs\s*(\d*)\s*(\-?\d*)\s*(\w*)}/i', '', $text);
		$text = preg_replace('/<img [^>]*alt="djtabs:(\d*),(\-?\d*),(\w*)"[^>]*>/i', '<div style="text-align:center;font-style:italic;color:white;background:tomato;border-radius:5px;">&nbsp;DJ-Tabs within DJ-Tabs not allowed&nbsp;</div>', $text);
		//return $text;
	}

	function getParams() {

		if (!isset($this->_params)) {
			//$params = JComponentHelper::getParams('com_djtabs');	
			$app = JFactory::getApplication();
			$mparams = $app->getParams(); 
			//$params->merge($mparams);
			$this->_params = $mparams;
		}

		return $this->_params;
	
	}
	
	static function convertVideoLink($link){
		
		if($_link=stristr($link,'youtube')){
			$_link = '//www.youtube.com/embed/'.str_replace('youtube.com/watch?v=','',$_link).'?wmode=opaque&amp;rel=0&amp;enablejsapi=1';
		}
		else if($_link=stristr($link,'youtu.be')){
			$_link = '//www.youtube.com/embed/'.str_replace('youtu.be/','',$_link).'?wmode=opaque&amp;rel=0&amp;enablejsapi=1';
		}
		else if($_link=stristr($link,'vimeo')){
			$_link = '//player.vimeo.com/video/'.str_replace('vimeo.com/','',$_link);
		}
		
		return $_link;
		
	}

}
