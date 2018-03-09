<?php

 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 defined('_JEXEC') or die('Restricted access');
	
	
	class JFormFieldgetpro extends JFormField
{
	var	$_name = 'getpro';
function getInput()
{
	
        ob_start();
        static $embedded;
                if(!$embedded)
        {

            $embedded=true;

        }
$WD_BWG_URL=JURI::root().'components/com_gallery_wd';
?>

	      <div style="float: right; text-align: right; position:absolute;left:528px;">
        <a style="text-decoration: none;" target="_blank" href="https://web-dorado.com/products/joomla-gallery.html">
          <img width="215" border="0" alt="https://web-dorado.com" src="<?php echo $WD_BWG_URL . '/images/logo.png'; ?>" />
        </a>
      </div>

        <?php

        $content=ob_get_contents();

        ob_end_clean();
        return $content;

    }
	}
	
	
	
	
	
	
	?>