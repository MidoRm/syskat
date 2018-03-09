<?php
/**
 * @version 1.0
 * @package DJ-Tabs
 * @copyright Copyright (C) 2013 DJ-Extensions.com, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Piotr Dobrakowski - piotr.dobrakowski@design-joomla.eu
 *
 * DJ-Tabs is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-Tabs is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-Tabs. If not, see <http://www.gnu.org/licenses/>.
 *
 */

// No direct access.
defined('_JEXEC') or die;

$fieldSets = $this->form->getFieldsets('params');
foreach ($fieldSets as $name => $fieldSet) :
	?>
	<div class="tab-pane" id="<?php echo $name;?>_params">
	<?php
	if (isset($fieldSet->description) && trim($fieldSet->description)) :
		echo '<p class="alert alert-info">'.$this->escape(JText::_($fieldSet->description)).'</p>';
	endif;
	?>
			<?php foreach ($this->form->getFieldset($name) as $field) : ?>
				
			<?php 
			$pre='jform_params_'; 
			$fields = array($pre.'module_position',$pre.'video_link',$pre.'article_id',$pre.'category_id',$pre.'myspacer5');
			if (in_array($field->id,$fields))
				continue;
			?>
			
				<div class="control-group">
					<div class="control-label"><?php echo $field->label; ?></div>
					<div class="controls">
						<?php if ($field->id=="jform_params_tab_custom_html") : ?> 
							<input name="tab_custom_html_chx" id="tab_custom_html_chx" value="your_value" type="checkbox">
						<?php endif;?>
					<?php echo $field->input; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
<?php endforeach; ?>	

<script type="text/javascript">

	window.addEvent('domready', function(){
        
        var custom_html_area = $('jform_params_tab_custom_html');
        var chx = $('tab_custom_html_chx'); 

        if (custom_html_area.value.length==1)
        	custom_html_area.getParent().hide();
        else
        	chx.checked = true;
        
        chx.onclick = customHTMLToggle;
   
	});
	
	function customHTMLToggle(){
		
		var chx = $('tab_custom_html_chx');
		var custom_html_area = $('jform_params_tab_custom_html');
		
		if(chx.checked==true)
			custom_html_area.getParent().show();
		else
			custom_html_area.getParent().hide();
	}
	
</script>			
