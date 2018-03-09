<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/**
 * Script file for the Image from Article package
 */
class pkg_imagefromarticleInstallerScript
{	
	static $version = '1.3.1';
	static $minimum_needed_library_version = '1.4.0';
	static $available_languages = array('en-GB', 'fr-FR', 'nl-NL', 'pt-BR', 'ru-RU');
	static $download_link = 'http://www.simplifyyourweb.com/downloads/syw-extension-library';
	static $changelog_link = 'http://www.simplifyyourweb.com/free-products/image-from-article/file/161-image-from-article';
	static $transifex_link = 'https://www.transifex.com/opentranslators/image-from-article';
	
	/**
	 * Called before an install/update method
	 *
	 * @return  boolean  True on success
	 */
	public function preflight($type, $parent) 
	{
		// check if syw library is present
		
		if (!JFolder::exists(JPATH_ROOT.'/libraries/syw')) {
				
			if (!$this->installOrUpdatePackage($parent, 'lib_syw')) {
				$message = JText::_('SYWLIBRARY_INSTALLFAILED').'<br /><a href="'.self::$download_link.'" target="_blank">'.JText::_('SYWLIBRARY_DOWNLOAD').'</a>';
				JFactory::getApplication()->enqueueMessage($message, 'error');
				return false;
			}
				
			JFactory::getApplication()->enqueueMessage(JText::sprintf('SYWLIBRARY_INSTALLED', self::$minimum_needed_library_version), 'message');
			
		} else {
			jimport('syw.version');		
			
			if (SYWVersion::isCompatible(self::$minimum_needed_library_version)) {
								
				JFactory::getApplication()->enqueueMessage(JText::_('SYWLIBRARY_COMPATIBLE'), 'message');
				
			} else {
				
				if (!$this->installOrUpdatePackage($parent, 'lib_syw')) {
					$message = JText::_('SYWLIBRARY_UPDATEFAILED').'<br />'.JText::_('SYWLIBRARY_UPDATE');
					JFactory::getApplication()->enqueueMessage($message, 'error');
					return false;
				}
				
				JFactory::getApplication()->enqueueMessage(JText::sprintf('SYWLIBRARY_UPDATED', self::$minimum_needed_library_version), 'message');
			}
		}
		
		return true;
	}
	
	/**
	 * Called after an install/update method
	 *
	 * @return  boolean  True on success
	 */
	public function postflight($type, $parent) 
	{				
 		echo '<p style="margin: 20px 0">';
		echo '<img src="../plugins/content/imagefromarticle/images/logo.png" />';
		echo '<br /><br /><span class="label">'.JText::sprintf('PKG_IMAGEFROMARTICLE_VERSION', self::$version).'</span>';
		echo '<br /><br />Olivier Buisard @ <a href="http://www.simplifyyourweb.com" target="_blank">Simplify Your Web</a>';
 		echo '</p>';		
		
 		// language test 			
 		
 		$current_language = JFactory::getLanguage()->getTag();
 		if (!in_array($current_language, self::$available_languages)) {
 			JFactory::getApplication()->enqueueMessage(JText::sprintf('PKG_IMAGEFROMARTICLE_INFO_LANGUAGETRANSLATE', JFactory::getLanguage()->getName(), self::$transifex_link), 'notice');
 		}			
			
 		// won't be an update on package first install, when moving from plugin to package
		if ($type == 'update') {
			
			// update warning
			
			JFactory::getApplication()->enqueueMessage(JText::sprintf('PKG_IMAGEFROMARTICLE_WARNING_RELEASENOTES', self::$changelog_link), 'warning');
			
			// delete unnecessary files			
			
			$files = array();
			
			$files[] = '/plugins/content/imagefromarticle/images/preview.png';
			$files[] = '/plugins/content/imagefromarticle/stylemaster.css.php';
			
			if (function_exists('glob')) {
				
				// remove old cached headers which may interfere with fixes, updates or new additions
				
				$filenames = glob(JPATH_SITE.'/cache/plg_content_imagefromarticle/style.css');
				if ($filenames != false) {
					$files = array_merge($files, $filenames);
				}
				
				// $filenames = glob(JPATH_CACHE.'/plg_content_imagefromarticle/*.png'); // remove preview images?
			}
			
			// from previous versions
			
			$files[] = '/plugins/content/imagefromarticle/style.css';
			
			foreach ($files as $file) {
				if (JFile::exists(JPATH_ROOT.$file) && !JFile::delete(JPATH_ROOT.$file)) {
					JFactory::getApplication()->enqueueMessage(JText::sprintf('PKG_IMAGEFROMARTICLE_ERROR_DELETINGFILEFOLDER', $file), 'warning');
				}
			}
		}
			
		// remove the old plugin update site for when it was not packaged
		
		$this->removeUpdateSite('plugin', 'imagefromarticle', 'content');
		
		return true;
	}	
	
	private function removeUpdateSite($type, $element, $folder = '') 
	{
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
			
		$query->select('extension_id');
		$query->from('#__extensions');
		$query->where($db->quoteName('type').'='.$db->quote($type));
		$query->where($db->quoteName('element').'='.$db->quote($element));
		if ($folder) {
			$query->where($db->quoteName('folder').'='.$db->quote($folder));
		}
		
		$db->setQuery($query);		
		
		$extension_id = '';
		try {
			$extension_id = $db->loadResult();
		} catch (RuntimeException $e) {
			if ($db->getErrorNum()) {
				JFactory::getApplication()->enqueueMessage($db->getErrorMsg(), 'warning');
			} else {
				JFactory::getApplication()->enqueueMessage(JText::_('JERROR_AN_ERROR_HAS_OCCURRED'), 'error');
			}
			return false;
		}
			
		if ($extension_id) {
			
			$query->clear();
				
			$query->select('update_site_id');
			$query->from('#__update_sites_extensions');
			$query->where($db->quoteName('extension_id').'='.$db->quote($extension_id));
				
			$db->setQuery($query);
			
			$updatesite_id = '';
			try {
				$updatesite_id = $db->loadResult();
			} catch (RuntimeException $e) {
				if ($db->getErrorNum()) {
					JFactory::getApplication()->enqueueMessage($db->getErrorMsg(), 'warning');
				} else {
					JFactory::getApplication()->enqueueMessage(JText::_('JERROR_AN_ERROR_HAS_OCCURRED'), 'error');
				}
				return false;
			}
				
			if ($updatesite_id) {
				
				$query->clear();
					
				$query->delete($db->quoteName('#__update_sites'));
				$query->where($db->quoteName('update_site_id').' = '.$db->quote($updatesite_id));
				
				$db->setQuery($query);
								
				try {
					$db->execute();
				} catch (RuntimeException $e) {
					if ($db->getErrorNum()) {
						JFactory::getApplication()->enqueueMessage($db->getErrorMsg(), 'warning');
					} else {
						JFactory::getApplication()->enqueueMessage(JText::_('JERROR_AN_ERROR_HAS_OCCURRED'), 'error');
					}
					return false;
				}
			}
		}
		
		return true;
	}
	
	private function installOrUpdatePackage($parent, $package_name, $installation_type = 'install')
	{
		// Get the path to the package
	
		$sourcePath = $parent->getParent()->getPath('source');
		$sourcePackage = $sourcePath . '/packages/'.$package_name.'.zip';
	
		// Extract and install the package
	
		$package = JInstallerHelper::unpack($sourcePackage);
		$tmpInstaller = new JInstaller;
	
		try {
			if ($installation_type == 'install') {
				$installResult = $tmpInstaller->install($package['dir']);
			} else {
				$installResult = $tmpInstaller->update($package['dir']);
			}
		} catch (\Exception $e) {
			return false;
		}
	
		return true;
	}
	
	/**
	 * Called on installation
	 *
	 * @return  boolean  True on success
	 */
	public function install($parent) {}
	
	/**
	 * Called on update
	 *
	 * @return  boolean  True on success
	 */
	public function update($parent) {}
	
	/**
	 * Called on uninstallation
	 */
	public function uninstall($parent) {}
	
}
?>