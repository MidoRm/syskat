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
jimport('joomla.application.component.controlleradmin');
class GalleryControllerGalleries extends JControllerAdmin
{
 public function add() {
       $model = $this->getModel();
       $id = $model->saveCat();
       $this->setredirect('index.php?option=com_gallery&view=gallery&layout=edit&id='. $id);
 }
function  cancel($key = NULL){
               $this->setRedirect(
            JRoute::_('index.php?option=com_gallery&view=gallerys', false));
        }
        
}

