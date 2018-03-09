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

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
jimport('joomla.filesystem.file');
$com_path = JPATH_SITE.'/components/com_content/';
require_once (JPATH_ROOT . DS . 'components' . DS . 'com_content' . DS . 'helpers' . DS . 'route.php');
JModelLegacy::addIncludePath(JPATH_ROOT . DS . 'components' . DS . 'com_content' . DS . 'models');
JModelLegacy::addIncludePath($com_path . '/models', 'ContentModel');

class DjTabsHelper{
	
	private static $modules = null;
	
	public static function addThemeCSS(&$params){
		
		$document= JFactory::getDocument();
		$db = JFactory::getDBO();
		
		$theme_id = $params->get('theme',0);
		//die($theme_id);
		if ($theme_id==0) //random theme
			$query = 'SELECT * FROM #__djtabs_themes '
					.'WHERE id!='.$theme_id.' and published=1 AND random=1 ORDER BY RAND() LIMIT 1';
		elseif ($theme_id>0)
        	$query = 'SELECT * FROM #__djtabs_themes ' 
        			.'WHERE id = '.$theme_id;
		
		if ($theme_id>=0){
	        $db -> setQuery($query);
	        $theme = $db -> loadObject();
			
			$css_params = new JRegistry();
			$css_params->loadString($theme->params);
				
		}
		
		if ($theme_id==0) 
			$theme_id = $theme->id;
		
		if($theme_id==-1){	//default-theme	
			$theme_title = 'default-theme';
			$file = 'components/com_djtabs/assets/css/default/'.$theme_title.'.css';
			$document->addStyleSheet($file);
		}
		elseif($theme->custom==0){ //solid theme
			$theme_title = str_replace(' ','-',$theme->title);
			$file1 = 'components/com_djtabs/assets/css/default/solid-theme.css';
			$file2 = 'components/com_djtabs/assets/css/default/'.$theme_title.'.css';
			$document->addStyleSheet($file1);
			$document->addStyleSheet($file2);
			$theme_title = 'solid-theme '.$theme_title;
		}
		else{
			$theme_title = str_replace(' ','-',$theme->title);
			$file = 'components/com_djtabs/assets/css/'.$theme_title.'.css';
			$path = JPATH_ROOT.'/'.$file;
			if(file_exists($path)){
				$document->addStyleSheet($file);
			}		
			else {
				self::generateThemeCSS($theme_id);
				$document->addStyleSheet($file);
			}
		}
		
		$params->set('class_theme_title',$theme_title);

	}

	public static function generateThemeCSS($theme_id){
		
		$db = JFactory::getDBO();
		
    	$query = 'SELECT * FROM #__djtabs_themes ' 
    			.'WHERE id = '.$theme_id;
					
        $db -> setQuery($query);
        $theme = $db -> loadObject();
		
		$css_params = new JRegistry();
		$css_params->loadString($theme->params);
		$theme_title = str_replace(' ','-',$theme->title);
		if (!$theme_title) $theme_title = 'default-theme';
		
		$file = JPATH_ROOT.DS.'components'.DS.'com_djtabs'.DS.'assets'.DS.'css'.DS.$theme_title.'.css';
		$path = JPATH_ROOT.DS.'components'.DS.'com_djtabs'.DS.'assets'.DS.'custom.css.php';
		
		ob_start();		
			include($path);		
		$buffer = ob_get_clean();
		
		JFile::write($file, $buffer);
		
	}
		
	public static function loadModules($position, $style = 'xhtml')
	{
		if (!isset(self::$modules[$position])) {
			self::$modules[$position] = '';
			$document	= JFactory::getDocument();
			$renderer	= $document->loadRenderer('module');
			$modules	= JModuleHelper::getModules($position);
			$params		= array('style' => $style);
			ob_start();
			
			foreach ($modules as $module) {
				echo $renderer->render($module, $params);
			}
	
			self::$modules[$position] = ob_get_clean();
		}
		return self::$modules[$position];
	}
	
}

?>

