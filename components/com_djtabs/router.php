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

function DJTabsBuildRoute(&$query)
{
	$segments = array();

	$app		= JFactory::getApplication();
	$menu		= $app->getMenu('site');
	if (empty($query['Itemid'])) {
		$menuItem = $menu->getActive();
	} else {
		$menuItem = $menu->getItem($query['Itemid']);
	}
	$mView	= (empty($menuItem->query['view'])) ? null : $menuItem->query['view'];
	$mId	= (empty($menuItem->query['id'])) ? null : $menuItem->query['id'];
	
	if(isset($query['view'])) {
		switch ($query['view']) {
			case 'category': {
				if ($mView && $query['view'] == $mView && isset($query['id'])) {
						
					unset($query['view']);
					
					if (intval($query['id']) == $mId) {
						unset($query['id']);
					} else {
						$segments[] = $query['id'];
						unset($query['id']);
					}
					
				} else {
											
					$segments[] = $query['view'];
					$segments[] = $query['id'];
					unset($query['view']);
					unset($query['id']);						
				}
				
				break;
			}
			case 'categories': {
				if ($query['view'] == $mView && isset($query['id'])) {
					
					unset($query['view']);
					
					if (intval($query['id']) == $mId) {
						unset($query['id']);						
					} else {
						$segments[] = $query['id'] ? $query['id'] : 'all';
						unset($query['id']);
					}
				}
				else {
					$segments[] = $query['view'];
					$segments[] = $query['id'] ? $query['id'] : 'all';
					unset($query['view']);
					unset($query['id']);					
				}
				break;
			}
		}
	}
	
	return $segments;
}

function DJTabsParseRoute($segments) {
	
	$app	= JFactory::getApplication();
	$menu	= $app->getMenu();
	$activemenu = $menu->getActive();
	$db = JFactory::getDBO();
	
	//$app->enqueueMessage(print_r($segments, true));
	$query=array();
	if (isset($segments[0])) {
		switch($segments[0]) {
			case 'categories': {
				$query['view'] = 'categories';
				if (isset($segments[1])) {
					$query['id'] = ($segments[1] == 'all') ? 0 : $segments[1];
				} 
				break;
			}
			case 'category': {
				$query['view'] = 'category';
				if (isset($segments[1])) {
					$query['id']= $segments[1];
				} 
				break;
			}
			default: {
				
				$query['view'] = 'category';
				if (isset($segments[0])) {
					$query['id']= $segments[0];
				} 
				
				break;
			}
		}
	}

	return $query;
}
