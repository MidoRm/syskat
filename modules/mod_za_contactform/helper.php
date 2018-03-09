<?php
/*
# ------------------------------------------------------------------------
# Extensions for Joomla 2.5.x - Joomla 3.x
# ------------------------------------------------------------------------
# Copyright (C) 2009-2015 za-studio.net, za-studio.ru. All Rights Reserved.
# @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Author: Za Studio
# Websites:  http://www.za-studio.net
# Date modified: 20/02/2015
# ------------------------------------------------------------------------
*/
defined('_JEXEC') or die;
class modZaContactFormHelper
{
	public static function getAjax()
	{
		jimport('joomla.application.module.helper');
		$input  			= JFactory::getApplication()->input;
		$module 			= JModuleHelper::getModule('za_contactform');
		$params 			= new JRegistry();
		$params->loadString($module->params);

		$mail 				= JFactory::getMailer();

		$success 			= $params->get('success');
		$failed 			= $params->get('failed');
		$recipient 			= $params->get('email');
		$failed_captcha 	= $params->get('failed_captcha');

		$formcaptcha		= $params->get('formcaptcha', 1);
		$captcha_question	= $params->get('captcha_question');
		$captcha_answer		= $params->get('captcha_answer');

		//inputs
		$inputs 			= $input->get('data', array(), 'ARRAY');

		foreach ($inputs as $input) {
			
			if( $input['name'] == 'email' )
			{
				$email 			= $input['value'];
			}

			if( $input['name'] == 'name' )
			{
				$name 			= $input['value'];
			}

			if( $input['name'] == 'subject' )
			{
				$subject 			= $input['value'];
			}

			if( $input['name'] == 'message' )
			{
				$message 			= nl2br( $input['value'] );
			}

			if($formcaptcha) {
				if( $input['name'] == 'sccaptcha' )
				{
					$sccaptcha 		= $input['value'];
				}
			}

		}

		if($formcaptcha) {
			if ($sccaptcha != $captcha_answer) {
				return '<p class="za_qc_warn">' . $failed_captcha . '</p>';
			}
		}

		$sender 		= array($email, $name);	
		$mail->setSender($sender);
		$mail->addRecipient($recipient);
		$mail->setSubject($subject);
		$mail->isHTML(true);
		$mail->Encoding = 'base64';	
		$mail->setBody($message);

		if ($mail->Send()) {
			return '<p class="za_qc_success">' . $success . '</p>';
		} else {
			return '<p class="za_qc_warn">' . $failed . '</p>';
		}
	}
}