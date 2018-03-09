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
jimport('joomla.application.component.view');
jimport('joomla.application.component.helper');
?>

<?php
class GalleryViewGeneral extends JViewLegacy
{
	protected $item;

	
	protected $form;

	
	protected $script;

	public function display($tpl = null)
	{
		try
		{
			
			$this->form = $this->get('Form');
			$this->item = $this->get('Item');
                        JHtml::stylesheet(Juri::root() . 'media/com_gallery/style/gallery.style.css');
			$this->addToolBar();
                        parent::display($tpl);
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
	protected function addToolBar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);
          
		//$isNew = ($this->item->id == 0);
		JToolBarHelper::title(JText::_('COM_GALLERY_MANAGER_GALLERY_GENERAL_OPTIONS'));
                JToolBarHelper::apply('general.apply1');
                JToolBarHelper::save('general.save');
		JToolBarHelper::cancel('general.cancel');
	}

}