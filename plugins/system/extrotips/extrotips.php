<?php

/*
# -------------------------------------------------------------------------
# plg_extrotips - eXtroTips Plugin - CSS3 Tooltips
# -------------------------------------------------------------------------
# author     eXtro-media.de
# copyright  Copyright (C) 2012 eXtro-media.de. All Rights Reserved.
# license - http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
# Websites:  http://www.eXtro-media.de
# Technical Support:  Forum - http://www.extro-media.de/en/forum.html
# -------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgSystemExtrotips extends JPlugin
{

	public function onAfterRender()
	{
		$app = JFactory::getApplication();
		if ($app->getName() == 'administrator' ) {
			return true;
		}      

    $body = JResponse::getBody();
    $pattern = '`{extrotips(.*?)}`';
    $replacement = '';

    while(preg_match($pattern,$body) == 1) {
    preg_match($pattern, $body, $matches);
    $par = substr($matches[0],11,-1);
    $par1 = explode('|',$par);
    for($x=0;$x < count($par1);$x++) { 
      $pn = strstr($par1[$x], '=',true);
      switch($pn) {
      	case 'link':
      	 $etlink = substr(strstr($par1[$x], '='),1);
      	 break;
      	case 'text':
      	 $ettext = substr(strstr($par1[$x], '='),1);
      	 break;
      	case 'tip':
      	 $ettip = substr(strstr($par1[$x], '='),1);
      	 break;
      	case 'class':
      	 $etclass = substr(strstr($par1[$x], '='),1);
      	 break;
      	case 'title':
      	 $ettitle = substr(strstr($par1[$x], '='),1);
      	 break;
      }
    }

    if($etlink == '') { $etanchor = $ettext; } else { $etanchor = '<a href="'.$etlink.'">'.$ettext.'</a>'; }
    if($ettitle != '') {$ettitle = '<p>'.$ettitle.'</p>'; }

    $replacement = '<div class="tooltips '.$etclass.' ">'.$etanchor.'<span>'.$ettitle.$ettip.'</span></div>';

    $body = str_replace($matches[0], $replacement, $body);
    $etlink = '';
    $ettext = '';
    $ettip = '';
    $etclass = '';
    $ettitle = '';
    $etanchor = '';
    }
    JResponse::setBody($body);

		return true;
	}

	public function onContentPrepare($context, &$article, &$params, $limitstart){
	 static $included_extrotips_css;
			
	 if (!$included_extrotips_css) {
		$document = JFactory::getDocument();
		$url='plugins/system/extrotips/extrotips.css';
		$document->addStyleSheet($url);	
		$document->addCustomTag( '
<!--[if lte IE 6]>
<style type="text/css">
.extrotips:hover span{ left: auto;}
.extrotips span{ left: -9999px; }
</style>
<![endif]-->
' );
	   $included_extrotips_css++;
	 }
   }

}
