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

jimport('joomla.application.component.modelitem');

class GalleryModelGallery extends JModelItem
{
	public function getTable($type = 'Gallery', $prefix = 'GalleryTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getItem($id = null)
	{
		
		$id = (!empty($id)) ? $id : (int) $this->getState('message.id');

		if ($this->_item === null)
		{
			$this->_item = array();
		}

		if (!isset($this->_item[$id]))
		{
			
			$table = $this->getTable();

			
			$table->load($id);

			
			$this->_item[$id] = $table->name;
		}

		return $this->_item[$id];
	}

        protected function populateState()
	{
		$app = JFactory::getApplication();

		
		$id = $app->input->getInt('id', 0);

		
		$this->setState('message.id', $id);

		parent::populateState();
	}
        
            public function getGalleryId(){
            $db = JFactory::getDBO();
            $id = (!empty($id)) ? $id : (int) $this->getState('message.id');
            $id = $this->setState('message.id', $id);
            return $id;
        }
   
      
     
}