<?php 
  
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 

defined('_JEXEC') or die('Restricted access');

class JFormFieldAlbumselect extends JFormField
{

	var	$_name = 'Albumselect';

	function getInput()
	{
		
		        static $embedded;
                if(!$embedded)
        {

            $embedded=true;

        }
		$db =JFactory::getDBO();

		$query = 'SELECT id, name FROM #__bwg_album WHERE published=1';
		$db->setQuery( $query );
		$options = $db->loadObjectList();
        $name = $this->name;
		$value = $this->value;
		$node =  $this->element;
		$control_name = $this->options['name'];
		$id=  $this->id;
		        ob_start();

		?>
		<div id="finder"></div>
		<style>
		#jform_params_number
		{
		width:25px;
		}
		</style>

		<?php
		
		array_unshift($options, JHTML::_('select.option', '-1', ''.JText::_('Select Album').'', 'id', 'name', $disable=true ));
		echo  JHTML::_('select.genericlist', $options, $this->name, $control_name, 'id', 'name', $this->value );
		
		        
				
				$content=ob_get_contents();

        ob_end_clean();
		        return $content;
		

		
	
	}
}
?>