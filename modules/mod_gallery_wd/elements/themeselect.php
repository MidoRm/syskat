<?php 
  
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 

defined('_JEXEC') or die('Restricted access');

class JFormFieldThemeselect extends JFormField
{

	var	$_name = 'Themeselect';

	function getInput()
	{
		
		        static $embedded;
                if(!$embedded)
        {

            $embedded=true;

        }
		$db =JFactory::getDBO();

		$query = 'SELECT id, name FROM #__bwg_theme';
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
		#jform_params_count
		{
		width:25px;
		}
		</style>
		<script>
////////////////////////////ON_TYPE_RADIO_CHANGE
	jQuery(jQuery('#finder').parent().parent().parent().children()[2]).on('change',function(){
		if(jQuery(jQuery('#finder').parent().parent().parent().children()[2]).children().children().children()[0].checked)
		{
		jQuery(jQuery('#finder').parent().parent().parent().children()[3]).css('display','block');
		jQuery(jQuery('#finder').parent().parent().parent().children()[4]).css('display','none');
		}
		else
		{
		jQuery(jQuery('#finder').parent().parent().parent().children()[3]).css('display','none');
		jQuery(jQuery('#finder').parent().parent().parent().children()[4]).css('display','block');
		}
	})
/////////////////////////////////ONLOAD TYPE
		if(jQuery(jQuery('#finder').parent().parent().parent().children()[2]).children().children().children()[0].checked)
		{
		jQuery(jQuery('#finder').parent().parent().parent().children()[3]).css('display','block');
		jQuery(jQuery('#finder').parent().parent().parent().children()[4]).css('display','none');
		}
		else
		{
		jQuery(jQuery('#finder').parent().parent().parent().children()[3]).css('display','none');
		jQuery(jQuery('#finder').parent().parent().parent().children()[4]).css('display','block');
		}

</script>		
		<?php
		
		array_unshift($options, JHTML::_('select.option', '-1', ''.JText::_('Select Theme').'', 'id', 'name', $disable=true ));
		echo  JHTML::_('select.genericlist', $options, $this->name, $control_name, 'id', 'name', $this->value );
		
		        
				
				$content=ob_get_contents();

        ob_end_clean();
		        return $content;
		

		
	
	}
}
?>