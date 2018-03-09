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

class GalleryViewVideo extends JViewLegacy {

    protected $item;
    protected $sliderParams;
    protected $form;
    protected $prop;
    protected $all;

    public function display($tpl = null) {
        try {
            parent::display($tpl);
        }   catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    

}
