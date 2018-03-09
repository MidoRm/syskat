<?php
defined('_JEXEC') or die;

class PlgSystemBruteforceblocker extends JPlugin
{

	public function onAfterInitialise() {
        // Get the application object.
        $app = JFactory::getApplication();
        
        $user = $app->input->getString('username');
        $option = $app->input->getCmd('option');
        
        if ($user == 'admin' && $option='com_users') {
        	die('no!');
        }       
        
	}
}
