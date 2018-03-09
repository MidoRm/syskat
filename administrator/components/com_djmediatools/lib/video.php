<?php
/**
 * @version $Id: video.php 51 2015-04-02 17:21:13Z szymon $
 * @package DJ-MediaTools
 * @copyright Copyright (C) 2012 DJ-Extensions.com LTD, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Szymon Woronowski - szymon.woronowski@design-joomla.eu
 *
 * DJ-MediaTools is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-MediaTools is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-MediaTools. If not, see <http://www.gnu.org/licenses/>.
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

abstract class DJVideoHelper {
	
	private static $video = array();
	
	public static function getVideo($link) {
		
		$key = md5($link);
		
		if(!isset(self::$video[$key])) {
				
			self::$video[$key] = self::parseVideoLink($link);
				
		}
		
		return self::$video[$key];
		
	}
	
	/* Parsing the passed video url and create object with require information */
	private static function parseVideoLink($link) {
		
		// use curl to get video oembed information
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, 'http://api.embed.ly/1/oembed?url='.urlencode($link));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		
		$tmp = curl_exec($ch);
		
		curl_close($ch);
		
		//$tmp = file_get_contents('http://api.embed.ly/1/oembed?url='.urlencode($link));
		
		$video = json_decode($tmp);
		
		if(!in_array($video->type, array('video', 'rich'))) {
			$video->error = JText::_('COM_DJMEDIATOOLS_NOT_SUPPORTED_VIDEO_LINK');
		}
		
		if($video->thumbnail_url) {
			$video->thumbnail = $video->thumbnail_url;
		} else {
			$video->error = JText::_('COM_DJMEDIATOOLS_NOT_SUPPORTED_VIDEO_LINK');
		}
		
		preg_match('/<iframe [^>]*src="[^"]*src=([^&]+)&/', $video->html, $match);
		
		if($match) {
			$video->embed = str_replace('http:', '', urldecode($match[1]));
		} else if(!$video->embed) {
			$video->error = JText::_('COM_DJMEDIATOOLS_NOT_SUPPORTED_VIDEO_LINK');
		}
		
		return $video;
	}
	
}