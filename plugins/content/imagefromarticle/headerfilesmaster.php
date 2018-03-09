<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('syw.headerfilescache');

class IFA_CSSFileCache extends SYWHeaderFilesCache
{
	public function __construct($extension, $params = null)
	{
		parent::__construct($extension, $params);

		$this->extension = $extension;

		$variables = array();
		
		$width = $params->get('width', 320);
		$variables[] = 'width';
		
		$float = $params->get('imagefloat', 'right');
		$variables[] = 'float';
		
		$shadow_width = $params->get('sh_w', 0);
		$variables[] = 'shadow_width';
		
		$border_width = $params->get('border_w', 0);
		$variables[] = 'border_width';
		
		$border_color = trim($params->get('border_c', '#ffffff'));
		$variables[] = 'border_color';
		
		$border_radius = $params->get('border_r', 0);
		$variables[] = 'border_radius';
		 
		// set all necessary parameters
		$this->params = compact($variables);
	}
	
	protected function getBuffer()
	{
		// get all necessary parameters
		extract($this->params);
		
// 		if (function_exists('ob_gzhandler')) { // TODO not tested
// 			ob_start('ob_gzhandler');
// 		} else {
 			ob_start();
// 		}
		
		// set the header
		$this->sendHttpHeaders('css');
		
		include 'style.css.php';
		
		return $this->compress(ob_get_clean());
	}
	
}
