<?php
/*-------------------------------------------------------------------------------
# mod_galleryaholic - GalleryAholic for Joomla 3.x v1.5.0-PRO
# -------------------------------------------------------------------------------
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.graphicaholic.com
--------------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.html.html');
jimport('joomla.form.formfield');
class JFormFieldInfo extends JFormField {
	protected $type = 'info';
	protected function getInput(){
		// Output
		return '
		<div style="font-size:12px;line-height:18px;color:#990000;padding:10px;margin:10px 0;background: #F4F4F4">
			'.JText::_($this->element['default']).'
		</div>
		';
	}
	public function getLabel() {
        return '<span style="display:none">' . parent::getLabel() . '</span>';
    }
}