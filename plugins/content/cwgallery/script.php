<?php 
/**
 * @plugin		CW Gallery
 * @author-name Pavel Stary, Cesky WEB s.r.o.
 * @copyright	Copyright (C) 2015 Cesky WEB s.r.o.
 * @license		GNU/GPL, see http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
if(!defined('DS')){
  define('DS',DIRECTORY_SEPARATOR);
} 
/**
 * Script file of CW Gallery
 */
class plgContentCWGalleryInstallerScript
{

	function preflight( $type, $parent ) {
		$jversion = new JVersion();

		// Installing component manifest file version
		$this->release = $parent->get( "manifest" )->version;
    $this->jversion = $parent->get( "manifest" )->jversion;    
		
		// Manifest file minimum Joomla version
		$this->minimum_joomla_release = $parent->get( "manifest" )->attributes()->version;   

		// Show the essential information at the install/update back-end
		echo "<table>";
    echo '<tr><td>CW Gallery version</td><td>' . $this->release.'</td></tr>';
		echo '<tr><td>Updated from version</td><td>' . $this->getParam('version').'</td></tr>';
    echo '<tr><td>Recommended Joomla version at least</td><td>' . $this->jversion.'</td></tr>';
		echo '<tr><td>Current Joomla version is</td><td>' . $jversion->getShortVersion().'</td></tr>';
    echo '<tr><td style="font-weight: bold; color: orange; ">Note: requires CW Gallery Ajax Plugin</td></tr>';
    echo "</table>";
    
    $link = JUri::root();
    $url = "http://extensions.cesky-web.eu/gallery.php?l=".$link."&t=".$type."&v=".$this->release;
    $call = file_get_contents($url); 
        
		// abort if the current Joomla release is older
		/*
    if( version_compare( $jversion->getShortVersion(), $this->jversion, 'lt' ) ) {
			Jerror::raiseWarning(null, 'Cannot install CW Gallery in a Joomla release prior to '.$this->jversion);
			return false;
		}
    */
		// abort if the component being installed is older than the currently installed version
		if ( $type == 'update' ) {
			$oldRelease = $this->getParam('version');
			$rel = $oldRelease . ' to ' . $this->release;
			if ( version_compare( $this->release, $oldRelease, 'lt' ) ) {
				Jerror::raiseWarning(null, 'Incorrect version sequence. Cannot upgrade ' . $rel);
				return false;
			}
		}
		else { $rel = $this->release; }
 
		//echo '<p>' . JText::_('COM_MULTICATS_PREFLIGHT_' . $type . ' ' . $rel) . '</p>';
	}


	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) 
	{
    jimport('joomla.filesystem.folder');
    $targetPath = JPATH_ROOT.'/images/cwgallery/';
    //check if folder exist - create if needed
    if (!JFolder::exists($targetPath)) {
      JFolder::create($targetPath);
      JFile::copy(JPATH_ROOT. DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'index.html', $targetPath. 'index.html');
    }
      	
    $db	= JFactory::getDbo();

  	$query = "SHOW TABLES LIKE '#__cwgallery_files'";
    $db->setQuery($query);
    $db->query();
    $num = $db->getNumRows();

    if( $num > 0 )
  	{  		
      return TRUE;               
  	}
  	else
  	{
      $query = 'CREATE TABLE IF NOT EXISTS `#__cwgallery_files` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `item_id` int(10) unsigned NOT NULL DEFAULT \'0\',
        `rid` varchar(100) NOT NULL,
        `field` varchar(40) NOT NULL,
        `type` varchar(255) DEFAULT NULL,
        `name` varchar(255) DEFAULT NULL,
        `path` varchar(255) DEFAULT NULL,
        `thumb` varchar(255) NOT NULL,
        `size` int(11) NOT NULL,
        `ordering` int(11) NOT NULL,
        `caption` varchar(255) NOT NULL,
        `description` TEXT NOT NULL,
        `publish` TINYINT( 1 ) NOT NULL DEFAULT  \'1\',
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';
      $db->setQuery($query);
      if($db->query()){
        echo "DB Table has been succesfully created"; 
        //echo '<p>' . JText::_('PLG_CWGALLERY_INSTALL_TEXT_DB_OK') . '</p>';            
      } 
      else {
        echo "DB table #__cwgallery_files has NOT been created, please check plugin installation again or create it manually - from plugins/content/cwgallery/sql/install.sql";
        //echo '<p style="color: red;">' . JText::_('PLG_CWGALLERY_INSTALL_TEXT_DB_FAIL') . '</p>';
      }   
  	}
    
	}
 
	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent) 
	{
      /**
       * Remove DB      
       */
       
      $db	= JFactory::getDbo();
      $query = 'DROP TABLE IF EXISTS `#__cwgallery_files`';
      $db->setQuery($query);
      if($db->query()){
        echo "DB Table has been succesfully deleted"; 
        //echo '<p>' . JText::_('PLG_CWGALLERY_UNINSTALL_TEXT_DB_OK') . '</p>';            
      } 
      else {
        echo "DB table #__cwgallery_files has NOT been deleted, please check plugin installation again or delete it manually - from plugins/content/cwgallery/sql/uninstall.sql";
        //echo '<p style="color: red;">' . JText::_('PLG_CWGALLERY_UNINSTALL_TEXT_DB_FAIL') . '</p>';
      }
      
      /**
       * Remove Files      
       */
        $params = new JRegistry();
        // get plugin details
        $plugin = JPluginHelper::getPlugin('content','cwgallery');
        
        // load params into our params object
        if ($plugin && isset($plugin->params)) {
            $params->loadString($plugin->params);
        }       
        //$filepath = $params->get('path','/images/cwgallery/');
        //for upload absolute path
        $targetPath = JPATH_ROOT . '/images/cwgallery/';         
        jimport('joomla.filesystem.folder');
        JFolder::delete($targetPath);                     
	}
 
	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent) 
	{
    jimport('joomla.filesystem.folder');
    $targetPath = JPATH_ROOT.'/images/cwgallery/';
    //check if folder exist - create if needed
    if (!JFolder::exists($targetPath)) {
      JFolder::create($targetPath);
      JFile::copy(JPATH_ROOT. DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'index.html', $targetPath. 'index.html');
    }
    
    $db	= JFactory::getDbo();

  	$query = "SHOW TABLES LIKE '%_cwgallery_files'";
    $db->setQuery($query);
    $db->query();
    $num = $db->getNumRows();

    if( $num > 0 )
  	{  		                
  	}
  	else
  	{
      $query = 'CREATE TABLE IF NOT EXISTS `#__cwgallery_files` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `item_id` int(10) unsigned NOT NULL DEFAULT \'0\',
        `rid` varchar(100) NOT NULL,
        `field` varchar(40) NOT NULL,
        `type` varchar(255) DEFAULT NULL,
        `name` varchar(255) DEFAULT NULL,
        `path` varchar(255) DEFAULT NULL,
        `thumb` varchar(255) NOT NULL,
        `size` int(11) NOT NULL,
        `ordering` int(11) NOT NULL,
        `caption` VARCHAR( 255 ) NOT NULL,
        `description` TEXT NOT NULL,
        `publish` TINYINT( 1 ) NOT NULL DEFAULT  \'1\',
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';
      $db->setQuery($query);
      if($db->query()){
        echo "DB Table has been succesfully repaired"; 
        //echo '<p>' . JText::_('PLG_CWGALLERY_INSTALL_TEXT_DB_OK') . '</p>';            
      } 
      else {
        echo "DB table #__cwgallery_files has NOT been created, please check plugin installation again or create it manually - from plugins/content/cwgallery/sql/install.sql";
        //echo '<p style="color: red;">' . JText::_('PLG_CWGALLERY_INSTALL_TEXT_DB_FAIL') . '</p>';
      }   
  	}
	}
 
 
	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent) 
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		//echo '<p>' . JText::_('PLG_CWGALLERY_POSTFLIGHT_' . $type . '_TEXT') . '</p>';    
	}
	/*
	 * get a variable from the manifest file (actually, from the manifest cache).
	 */
	function getParam( $name ) {
		$db = JFactory::getDbo();
		$db->setQuery('SELECT manifest_cache FROM #__extensions WHERE element = "cwgallery" AND folder = "content" ');
		
    $manifest = json_decode( $db->loadResult(), true );

    return $manifest[ $name ];
	}
 
	/*
	 * sets parameter values in the component's row of the extension table
	 */
	function setParams($param_array) {
		if ( count($param_array) > 0 ) {
			// read the existing component value(s)
			$db = JFactory::getDbo();
			$db->setQuery('SELECT params FROM #__extensions WHERE element = "cwgallery" AND folder = "content" ');
			$params = json_decode( $db->loadResult(), true );
			// add the new variable(s) to the existing one(s)
			foreach ( $param_array as $name => $value ) {
				$params[ (string) $name ] = (string) $value;
			}
			// store the combined new and existing values back as a JSON string
			$paramsString = json_encode( $params );
			$db->setQuery('UPDATE #__extensions SET params = ' .
				$db->quote( $paramsString ) .
				' WHERE element = "cwgallery" AND folder = "content" ' );
				$db->query();
		}
	}
}
