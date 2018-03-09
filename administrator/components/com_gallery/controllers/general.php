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
jimport('joomla.application.component.controllerform');

class GalleryControllerGeneral extends JControllerForm
{
    function save($key = null, $urlVar = null) {
            $model = $this->getModel('General');
            $item=$model->save($key);
            $this->setRedirect(JRoute::_('index.php?option=com_gallery&view=galleries', false),JText::_('COM_GALLERY_SETTINGS'));
    }

     function  cancel($key = NULL){
               $this->setRedirect(
			   JRoute::_('index.php?option=com_gallery&view=galleries', false));
        }
        
        function apply1(){
             $model = $this->getModel('General');
             $item=$model->save('');
             $this->setRedirect(JRoute::_('index.php?option=com_gallery&view=general', false), JText::_('COM_GALLERY_SETTINGS'));
        }
}
