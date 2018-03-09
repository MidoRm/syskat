<?php
/**
 * @package     CW Gallery
 * @subpackage  Editors-xtd.cwgallery
 *
 * @copyright	Copyright (C) 2015 Ing.Pavel Stary, Cesky WEB s.r.o., Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */ 

defined('_JEXEC') or die;

/**
 * Editor CWgallery buton
 */
class PlgButtonCWGallery extends JPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  3.1
	 */
	protected $autoloadLanguage = true;

	/**
	 * Readmore button
	 *
	 * @param   string  $name  The name of the button to add
	 *
	 * @return array A two element array of (imageName, textToInsert)
	 */
	public function onDisplay($name)
	{
		$doc = JFactory::getDocument();

		// Button is not active in specific content components
		$js = "
			function insertCWGallery(editor)
			{
        jInsertEditorText('{cwgallery}', editor);
			}
			";

		$doc->addScriptDeclaration($js);

		$button = new JObject;
		$button->modal = false;
		$button->class = 'btn';
		$button->onclick = 'insertCWGallery(\'' . $name . '\');return false;';
		$button->text = JText::_('CW Gallery');
		$button->name = 'picture';

		// @TODO: The button writer needs to take into account the javascript directive
		// $button->link', 'javascript:void(0)');
		$button->link = '#';

		return $button;
	}
}
