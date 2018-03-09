<?php
/*
# ------------------------------------------------------------------------
# Extensions for Joomla 2.5.x - Joomla 3.x
# ------------------------------------------------------------------------
# Copyright (C) 2009-2015 za-studio.net, za-studio.ru. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: Za Studio
# Websites:  http://www.za-studio.net
# Date modified: 20/11/2015
# ------------------------------------------------------------------------
*/
defined('_JEXEC') or die;

// Include the syndicate functions only once
JHtml::_('jquery.framework');

$uniqid				= $module->id;
$name_text			= JText::_('NAME');
$email_text			= JText::_('EMAIL');
$subject_text		= JText::_('SUBJECT');
$msg_text			= JText::_('MESSAGE');
$send_msg			= JText::_('SEND_MESSAGE');

$formcaptcha		= $params->get('formcaptcha', 1);
$captcha_question	= $params->get('captcha_question');
$captcha_answer		= $params->get('captcha_answer');
$label_text	= $params->get('label_text');
$login_text	= $params->get('login_text');
$color_text	= $params->get('color_text');
$backgr_text	= $params->get('backgr_text');
$hide_text	= $params->get('hide_text');
$width_button	= $params->get('width_button');

$document 			= JFactory::getDocument();
$document->addStylesheet(JURI::base(true) . '/modules/mod_za_contactform/assets/css/style.css');

// Include the helper.
require_once __DIR__ . '/helper.php';

require JModuleHelper::getLayoutPath('mod_za_contactform', $params->get('layout', 'default'));