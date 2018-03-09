<?php

 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');
	
	
	class JFormFieldDimensions extends JFormField
{
	var	$_name = 'Dimensions';
function getInput()
{
	
        ob_start();
        static $embedded;
                if(!$embedded)
        {

            $embedded=true;

        }

/*$this->name
*/
$dimensions=explode('x',$this->value);

$tag_width=$dimensions[0];
$tag_height=$dimensions[1];



            ?>
	<input id="tag_width" value="<?php echo $tag_width  ?>" type="text" style="width:50px" /> x <input  value="<?php echo $tag_height  ?>" id="tag_height" type="text" style="width:50px" />
	
	<input name="<?php echo $this->name;?>" id="<?php echo $this->id ?>" type="hidden" value="<?php echo $this->value  ?>" width="50" />
   
   <script type="text/javascript">
	
	jQuery('#tag_width, #tag_height').on('change',function()
			{
			jQuery('#<?php echo $this->id ?>').val(jQuery('#tag_width').val()+'x'+jQuery('#tag_height').val())
			
			}
		)
	
	
    </script>

        <?php

        $content=ob_get_contents();

        ob_end_clean();
        return $content;

    }
	}
	
	
	
	
	
	
	?>