<?php 
/**
 * @package Huge IT Gallery
 * @author Huge-IT
 * @copyright (C) 2014 Huge IT. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @website		http://www.huge-it.com/
 **/
?>
<?php defined('_JEXEC') or die('Restricted access');
abstract class GalleryHelper
{
	public static function addSubmenu($submenu)
	{
        JSubMenuHelper::addEntry(
			JText::_('Huge It Gallery'),
			'index.php?option=com_gallery&view=galleries',
			$submenu == 'galleries'
		);
			JSubMenuHelper::addEntry(
			JText::_('General Options'),
			'index.php?option=com_gallery&view=general',
			$submenu == 'general'
		);
            JSubMenuHelper::addEntry(
				JText::_('Lightbox Options'),
				'index.php?option=com_gallery&view=lightbox',
				$submenu == 'lightbox'
		);
            JSubMenuHelper::addEntry(
				JText::_('Featured Products'),
				'index.php?option=com_gallery&view=featured',
				$submenu == 'featured'
		);

	}
}
