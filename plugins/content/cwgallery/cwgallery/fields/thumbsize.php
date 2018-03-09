<?php
/**
 * @package		CWGallery
 * @subpackage	plg_content_cwgallery
 * @copyright	Copyright (C) 2015 Ing.Pavel Stary, Cesky WEB s.r.o., Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */ 

defined('JPATH_BASE') or die;

/**
 * Supports a gallery for article.
 *
 * @package		Joomla.Administrator
 * @subpackage	plg_content_cwgallery
 * @since		1.6
 */
class JFormFieldThumbsize extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'CWGallery';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
/*
  protected function getLabel() {

  }
*/

  protected function getInput() {

    //get ID of item - in frontend we use w_id to avoid collision with router
    $id = (int)JRequest::getVar("w_id");
    //if no w_id, then we check also id
    /*
    if(!$id > 0){
      $id = (int)JRequest::getVar("id");
      if(!$id > 0){
        return "<span style='color: red;'>File uploader will be available after saving the article.</span>";
      }
    }
    */
    //set myId as a name of dropzone instance
    $myId = str_replace('jform_attribs_cwgallery_','',$this->id);
    
    //get plugin parameters    
    // generate and empty object
    $params = new JRegistry();
    // get plugin details
    $plugin = JPluginHelper::getPlugin('content','cwgallery');
    
    // load params into our params object
    if ($plugin && isset($plugin->params)) {
        $params->loadString($plugin->params);
    }
    //echo "<pre>".'accept'.$myId. ' *** '; print_r($params); exit;
    $size = $params->get($myId,120);

    $html[] = '<input type="text" name="'.$this->name.'" id="'.$this->id.'" value="'.( (isset($this->value) && $this->value != '') ? $this->value : $size ).'" />';    
    //$html[] = '<span style="color: red; font-weight: bold; padding: 0 20px;">SAVE the article before you will upload images or recreate thumbnails!</span>';
    return implode('',$html);

	}

}?>
