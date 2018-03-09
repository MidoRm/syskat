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

class GalleryControllerGallery extends JControllerForm
{
   public function save ($key = null, $urlVar = null) {
        $model = $this->getModel();
        global $option;
        $id_cat = intval(JRequest::getVar('id'));
        $table = $model->getTable();
        $post = JRequest::get('post');      
        $model->save($post);
        $this->setredirect('index.php?option=com_gallery&view=gallery&id='.$id_cat,JText::_('COM_GALLERY_SETTINGS'));
}
function addProject() {
     $model = $this->getModel();    
     $id = $model->saveProject(JRequest::getVar('sel'),JRequest::getVar('parentId') );
	 $id = intval($id);
     $this->setredirect('index.php?option=com_gallery&view=gallery&layout=edit&id='. $id);
    
}
function deleteProject(){
     $model = $this->getModel();    
     $id = $model->deleteProject();
     $projectId = intval(JRequest::getVar('id'));
     echo $projectId;
	 $this->setredirect('index.php?option=com_gallery&view=gallery&layout=edit&id='.$projectId);
 }
 function  video(){
     $model = $this->getModel(); 
     $model -> video();
 }
}