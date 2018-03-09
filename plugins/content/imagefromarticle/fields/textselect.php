<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
*/

// no direct access
defined( '_JEXEC' ) or die;

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

JFormHelper::loadFieldClass('list');

class JFormFieldTextSelect extends JFormFieldList
{
	public $type = 'TextSelect';
	
	static $core_fields = null;	
	
	static function getCoreFields($allowed_types = array())
	{
		if (!isset(self::$core_fields)) {
			JLoader::register('FieldsHelper', JPATH_ADMINISTRATOR . '/components/com_fields/helpers/fields.php');
			$fields = FieldsHelper::getFields('com_content.article');
			
			self::$core_fields = array();
			
			if (!empty($fields)) {
				foreach ($fields as $field) {					
					if (!empty($allowed_types) && !in_array($field->type, $allowed_types)) {
						continue;
					}					
					self::$core_fields[] = $field;
				}
			}
		}
		
		return self::$core_fields;
	}

	protected function getOptions() 
	{	
		$options = array();
		
		// get Joomla! fields
		// test the fields folder first to avoid message warning that the component is missing
		if (JFolder::exists(JPATH_ADMINISTRATOR . '/components/com_fields') && JComponentHelper::isEnabled('com_fields') && JComponentHelper::getParams('com_content')->get('custom_fields_enable', '1')) {

			// get the custom fields
			$fields = self::getCoreFields(array('text', 'textarea'));
						
			// organize the fields according to their group
				
			$fieldsPerGroup = array(
				0 => array()
			);
				
			$groupTitles = array(
				0 => JText::_('PLG_CONTENT_IMAGEFROMARTICLE_VALUE_NOGROUPFIELD')
			);
				
			$fields_exist = false;
			foreach ($fields as $field) {
					
				if (!array_key_exists($field->group_id, $fieldsPerGroup)) {
					$fieldsPerGroup[$field->group_id] = array();
					$groupTitles[$field->group_id] = $field->group_title;
				}
					
				$fieldsPerGroup[$field->group_id][] = $field;
				$fields_exist = true;
			}
				
			// loop trough the groups
			
			if ($fields_exist) {
				$options[] = JHtml::_('select.optgroup', JText::_('PLG_CONTENT_IMAGEFROMARTICLE_VALUE_JOOMLAFIELDS'));
			
				foreach ($fieldsPerGroup as $group_id => $groupFields) {
			
					if (!$groupFields) {
						continue;
					}
			
					foreach ($groupFields as $field) {
						$options[] = JHTML::_('select.option', 'jfield:'.$field->type.':'.$field->id, $groupTitles[$group_id].': '.$field->title, 'value', 'text', $disable = false);
					}
				}
			
				$options[] = JHtml::_('select.optgroup', JText::_('PLG_CONTENT_IMAGEFROMARTICLE_VALUE_JOOMLAFIELDS'));
			}
		}
		
		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);
		
		return $options;
	}
}
?>