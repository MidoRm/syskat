<?php
/**
 * @version		$Id$
 * @author		NooTheme
 * @modified	GraphicAholic
 * @package		Joomla.Site
 * @subpackage	mod_noo_gallery and mod_graphicaholic
 * @copyright	Copyright (C) 2013 NooTheme. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
 */
// no direct access
defined('_JEXEC') or die('Restricted access'); 
abstract class modGAprofileHelper {
	public static function render(&$params)
	{
		// Read our Parameters
		return $params;
	}
}
if (!class_exists('gaImageHelper')){
	if (!defined('DS'))
		define('DS',DIRECTORY_SEPARATOR);
	 jimport('joomla.filesystem.file');
	 jimport('joomla.filesystem.folder');
	class gaImageHelper {
	/**
         * Identifier of the cache path.
         *
         * @access private
         * @param string $_cachePath
         */
        var $_cachePath;
        /**
         * Identifier of the path of source.
         *
         * @access private
         * @param string $_imageBase
         */
        var $_imageBase;
        /**
         * Identifier of the image's extensions
         *
         * @access public
         * @param array $types
         */
        var $types = array();
        /**
         * Identifier of the quantity of thumnail image.
         *
         * @access public
         * @param string $_quality
         */
        var $_quality = 90;
        /**
         * Identifier of the url of folder cache.
         *
         * @access public
         * @param string $_cacheURL
         */
        var $_cacheURL;
        /**
         * constructor
         */
        function __construct($config = array())
        {
            $this->types = array(1 => "gif", "jpeg", "png", "swf", "psd", "wbmp");
            $this->_imageBase = JPATH_SITE . DS .'/images' . DS;
            $this->_cachePath = $this->_imageBase . 'resized' . DS;
            $this->_cacheURL = 'images/resized/';
        }
        /**
         * check the folder is existed, if not make a directory and set permission is 755
         *
         *
         * @param array $path
         * @access public,
         * @return boolean.
         */
        function makeDir($path)
        {
            $folders = explode('/', ($path));
            $tmppath = $this->_cachePath;
            for ($i = 0; $i < count($folders) - 1; $i++) {
                if (!file_exists($tmppath . $folders[$i]) && !JFolder::create($tmppath . $folders[$i], 0755)) {
                    return false;
                }
                $tmppath = $tmppath . $folders[$i] . DS;
            }
            return true;
        }
        /**
         * process render image
         *
         * @param string $imageSource is path of the image source.
         * @param stdClass $src the setting of image source
         * @param stdClass $dst the setting of image dts
         * @param string $imageCache path of image cache ( it's thumnail).
         * @access public,
         */
        function _resizeImage($imageSource, $src, $dst, $size, $imageCache)
        {
            // create image from source.
            $extension = $this->types[$size[2]];
            $image = call_user_func("imagecreatefrom" . $extension, $imageSource);
            if (function_exists("imagecreatetruecolor") && ($newimage = imagecreatetruecolor($dst->w, $dst->h))) {
                if ($extension == 'gif' || $extension == 'png') {
                    imagealphablending($newimage, false);
                    imagesavealpha($newimage, true);
                    $transparent = imagecolorallocatealpha($newimage, 255, 255, 255, 127);
                    imagefilledrectangle($newimage, 0, 0, $dst->w, $dst->h, $transparent);
                }
                imagecopyresampled($newimage, $image, $dst->x, $dst->y, $src->x, $src->y, $dst->w, $dst->h, $src->w, $src->h);
            } else {
                $newimage = imagecreate($src->w, $src->h);
                imagecopyresized($newimage, $image, $dst->x, $dst->y, $src->x, $src->y, $dst->w, $dst->h, $size[0], $size[1]);
            }
            switch ($extension) {
                case 'jpeg':
                    call_user_func('image' . $extension, $newimage, $imageCache, $this->_quality);
                    break;
                default:
                    call_user_func('image' . $extension, $newimage, $imageCache);
                    break;
            }
        }
        /**
         * set quality image will render.
         */
        function setQuality($number = 9)
        {
            $this->_quality = $number;
        }
        /**
         * check the file is a image type ?
         *
         * @param string $ext
         * @return boolean.
         */
        function isImage($ext = '')
        {
            return in_array($ext, $this->types);
        }
	}
}