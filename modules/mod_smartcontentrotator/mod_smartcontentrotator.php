<?php
/*------------------------------------------------------------------------
# mod_smartcontentrotator.php - Smart Latest News (module)
# ------------------------------------------------------------------------
# version		1.0.0
# author    	Implantes en tu ciudad
# copyright 	Copyright (c) 2011 Top Position All rights reserved.
# @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website		http://mastermarketingdigital.org/open-source-joomla-extensions

Based on http://tympanus.net/codrops/2010/10/03/compact-news-previewer/ (Codrops Tutorial)
-------------------------------------------------------------------------
*/
// no direct access
defined('_JEXEC') or die;
$document = JFactory::getDocument();

require_once (dirname(__FILE__).'/helper.php');
$list = modsmartcontentrotatorHelper::getList($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require(JModuleHelper::getLayoutPath('mod_smartcontentrotator', $params->get('layout', 'default')));

?>