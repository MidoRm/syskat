<?php

/*--------------------------------------------------------------
# Copyright (C) joomla-monster.com
# License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
# Website: http://www.joomla-monster.com
# Support: info@joomla-monster.com
---------------------------------------------------------------*/

defined('_JEXEC') or die;

class JMTemplate extends JMFTemplate {
	public function postSetUp() {
		// get columns classes
		$s = $this->getLayoutConfig('#scheme','lcr');
		$l = $this->params->get('columnLeftWidth', $this->defaults->get('columnLeftWidth'));
		$r = $this->params->get('columnRightWidth', $this->defaults->get('columnRightWidth'));
				
		if ((!$this->checkModules('left-column')) && (!$this->checkModules('right-column'))) {
            $c = 12;
			$s = str_replace(array('l','r'), '', $s);
        } else if (($this->checkModules('left-column')) && (!$this->checkModules('right-column'))) {
            $c = 12 - $l;
			$s = str_replace(array('r'), '', $s);
        } else if ((!$this->checkModules('left-column')) && ($this->checkModules('right-column'))) {
            $c = 12 - $r;
			$l = $r;
			$s = str_replace(array('l'), '', $s);
        } else {
            $c = 12 - $l - $r;
        }
		
		// get classes for columns		
		$class = $this->getColumnClasses($s, $c, $l, $r);
		
		$this->params->set('class', $class);	
		
		$bootstrap_vars = array();
		
		/* Template Layout */
		//$parametr = $this->params->get('parametr', $this->defaults->get('parametr'));
		
		$templatefluidwidth = $this->params->get('JMfluidGridContainerLg', $this->defaults->get('JMfluidGridContainerLg'));
		$bootstrap_vars['JMfluidGridContainerLg'] = $templatefluidwidth;
		
		//check type
		$checkwidthtype = strstr($templatefluidwidth, '%');
		$checkwidthtypevalue = ($checkwidthtype) ? 'fluid' : 'fixed';
		$bootstrap_vars['JMtemplateWidthType'] = $checkwidthtypevalue;
		$templatewidthtype = $this->params->set('JMtemplateWidthType', $checkwidthtypevalue);
		
		$gutterwidth = $this->params->get('JMbaseSpace', $this->defaults->get('JMbaseSpace'));
		$bootstrap_vars['JMbaseSpace'] = $gutterwidth;
		
		//offcanvas
		$offcanvaswidth = $this->params->get('JMoffCanvasWidth', $this->defaults->get('JMoffCanvasWidth'));
		$bootstrap_vars['JMoffCanvasWidth'] = $offcanvaswidth;

        /* Font Modifications */
        
        //body
        
        $bodyfontsize = (int)$this->params->get('JMbaseFontSize', $this->defaults->get('JMbaseFontSize'));
		$bootstrap_vars['JMbaseFontSize'] = $bodyfontsize.'px';
		
        $bodyfonttype = $this->params->get('bodyFontType', '1');
        $bodyfontfamily = $this->params->get('bodyFontFamily', $this->defaults->get('bodyFontFamily')); 
        $bodygooglewebfontfamily = $this->params->get("bodyGoogleWebFontFamily", $this->defaults->get('bodyGoogleWebFontFamily'));
		$bodygooglewebfonturl = $this->params->get('bodyGoogleWebFontUrl');
        $generatedwebfontfamily = $this->params->get('bodyGeneratedWebFont');

        switch($bodyfonttype) {
            case "0" : {
                $bootstrap_vars['JMbaseFontFamily'] = $bodyfontfamily;
                break;    
            }
        	case "1" :{
                $bootstrap_vars['JMbaseFontFamily'] = $bodygooglewebfontfamily;
                break;
            }
            case "2" :{
            	$bootstrap_vars['JMbaseFontFamily'] = $generatedwebfontfamily;
            	break;
            }
            default: {
                $bootstrap_vars['JMbaseFontFamily'] = $this->defaults->get('bodyGoogleWebFontFamily');
                break;
            }
       	}
	   
		//top menu horizontal
		
		$djmenufontsize = (int)$this->params->get('JMtopmenuFontSize', $this->defaults->get('JMtopmenuFontSize'));
		$bootstrap_vars['JMtopmenuFontSize'] = $djmenufontsize.'px';
		
		$djmenufonttype = $this->params->get('djmenuFontType', '1');
		$djmenufontfamily = $this->params->get('djmenuFontFamily', $this->defaults->get('djmenuFontFamily'));
		$djmenugooglewebfontfamily = $this->params->get("djmenuGoogleWebFontFamily", $this->defaults->get('djmenuGoogleWebFontFamily'));
		$djmenugeneratedwebfontfamily = $this->params->get('djmenuGeneratedWebFont');
		
        switch($djmenufonttype) {
            case "0" : {
                $bootstrap_vars['JMtopmenuFontFamily'] = $djmenufontfamily;
                break;    
            }
            case "1" :{
                $bootstrap_vars['JMtopmenuFontFamily'] = $djmenugooglewebfontfamily;
                break;
            }
            case "2" :{
            	$bootstrap_vars['JMtopmenuFontFamily'] = $djmenugeneratedwebfontfamily;
            	break;
            }
            default: {
                $bootstrap_vars['JMtopmenuFontFamily'] = $this->defaults->get('djmenuGoogleWebFontFamily');
                break;
            }
       	}
       	
       	//module title
	   	
	 	$headingsfontsize = (int)$this->params->get('JMmoduleTitleFontSize', $this->defaults->get('JMmoduleTitleFontSize'));
		$bootstrap_vars['JMmoduleTitleFontSize'] = $headingsfontsize.'px';
		
		$headingsfonttype = $this->params->get('headingsFontType', '1');
		$headingsfontfamily = $this->params->get('headingsFontFamily', $this->defaults->get('headingsFontFamily')); 
		$headingsgooglewebfontfamily = $this->params->get("headingsGoogleWebFontFamily", $this->defaults->get('headingsGoogleWebFontFamily'));
		$headingsgeneratedwebfontfamily = $this->params->get('headingsGeneratedWebFont');
		
        switch($headingsfonttype) {
            case "0" : {
                $bootstrap_vars['JMmoduleTitleFontFamily'] = $headingsfontfamily;
                break;    
            }
            case "1" :{
                $bootstrap_vars['JMmoduleTitleFontFamily'] = $headingsgooglewebfontfamily;
                break;
            }
            case "2" :{
            	$bootstrap_vars['JMmoduleTitleFontFamily'] = $headingsgeneratedwebfontfamily;
            	break;
            }
            default: {
                $bootstrap_vars['JMmoduleTitleFontFamily'] = $this->defaults->get('headingsGoogleWebFontFamily');
                break;
            }
       	}
		
       	//article title
		
		$articlesfontsize = (int)$this->params->get('JMarticleTitleFontSize', $this->defaults->get('JMarticleTitleFontSize'));
		$bootstrap_vars['JMarticleTitleFontSize'] = $articlesfontsize.'px';
		
		$articlesfonttype = $this->params->get('articlesFontType', '1');
		$articlesfontfamily = $this->params->get('articlesFontFamily', $this->defaults->get('articlesFontFamily'));
		$articlesgooglewebfontfamily = $this->params->get("articlesGoogleWebFontFamily", $this->defaults->get('articlesGoogleWebFontFamily'));
		$articlesgeneratedfontfamily = $this->params->get('articlesGeneratedWebFont');
		
        switch($articlesfonttype) {
            case "0" : {
                $bootstrap_vars['JMarticleTitleFontFamily'] = $articlesfontfamily;
                break;    
            }
            case "1" :{
                $bootstrap_vars['JMarticleTitleFontFamily'] = $articlesgooglewebfontfamily;
                break;
            }
            case "2" :{
            	$bootstrap_vars['JMarticleTitleFontFamily'] = $articlesgeneratedfontfamily;
            	break;
            }
            default: {
                $bootstrap_vars['JMarticleTitleFontFamily'] = $this->defaults->get('articlesGoogleWebFontFamily');
                break;
            }
       	}
       	
       	
		
	    /* Color Modifications */
	    
	  //scheme color
      $colorversion = $this->params->get('JMcolorVersion', $this->defaults->get('JMcolorVersion')); 
		$bootstrap_vars['JMcolorVersion'] = $colorversion;

		//scheme images directory
		$imagesdir = $this->params->get('JMimagesDir', 'scheme1');
		$bootstrap_vars['JMimagesDir'] = $imagesdir;

		//custom variables
		
		// -------------------------------------
		// global
		// -------------------------------------
		
		//page background
		$JMpageBackground = $this->params->get('JMpageBackground', $this->defaults->get('JMpageBackground')); 
		$bootstrap_vars['JMpageBackground'] = $JMpageBackground;
		
		//base font color
		$bodyfontcolor = $this->params->get('JMbaseFontColor', $this->defaults->get('JMbaseFontColor')); 
		$bootstrap_vars['JMbaseFontColor'] = $bodyfontcolor;
		
		//border
		$JMborder = $this->params->get('JMborder', $this->defaults->get('JMborder')); 
		$bootstrap_vars['JMborder'] = $JMborder;
		
		//article headings
		$JMarticleTitleFontColor = $this->params->get('JMarticleTitleFontColor', $this->defaults->get('JMarticleTitleFontColor')); 
		$bootstrap_vars['JMarticleTitleFontColor'] = $JMarticleTitleFontColor;
		
		// -------------------------------------
		// topbar
		// -------------------------------------
		
		//background
		$JMtopbarBackground = $this->params->get('JMtopbarBackground', $this->defaults->get('JMtopbarBackground')); 
		$bootstrap_vars['JMtopbarBackground'] = $JMtopbarBackground;
		
		//font color
		$JMtopbarFontColor = $this->params->get('JMtopbarFontColor', $this->defaults->get('JMtopbarFontColor')); 
		$bootstrap_vars['JMtopbarFontColor'] = $JMtopbarFontColor;	
		
		//border
		$JMtopbarBorder = $this->params->get('JMtopbarBorder', $this->defaults->get('JMtopbarBorder')); 
		$bootstrap_vars['JMtopbarBorder'] = $JMtopbarBorder;	
		
		// -------------------------------------
		// bar
		// -------------------------------------
		
		//background
		$JMbarBackground = $this->params->get('JMbarBackground', $this->defaults->get('JMbarBackground')); 
		$bootstrap_vars['JMbarBackground'] = $JMbarBackground;
		
		//font color
		$JMbarFontColor = $this->params->get('JMbarFontColor', $this->defaults->get('JMbarFontColor')); 
		$bootstrap_vars['JMbarFontColor'] = $JMbarFontColor;
		
		//border
		$JMbarBorder = $this->params->get('JMbarBorder', $this->defaults->get('JMbarBorder')); 
		$bootstrap_vars['JMbarBorder'] = $JMbarBorder;	
		
		// -------------------------------------
		// dj-menu
		// -------------------------------------
		
		//font color
		$JMmegamenuFontColor = $this->params->get('JMmegamenuFontColor', $this->defaults->get('JMmegamenuFontColor')); 
		$bootstrap_vars['JMmegamenuFontColor'] = $JMmegamenuFontColor;
		
		//SUBMENU
		//background
		$JMmegamenuSubmenuBackground = $this->params->get('JMmegamenuSubmenuBackground', $this->defaults->get('JMmegamenuSubmenuBackground')); 
		$bootstrap_vars['JMmegamenuSubmenuBackground'] = $JMmegamenuSubmenuBackground;
		
		//font color
		$JMmegamenuSubmenuFontColor = $this->params->get('JMmegamenuSubmenuFontColor', $this->defaults->get('JMmegamenuSubmenuFontColor')); 
		$bootstrap_vars['JMmegamenuSubmenuFontColor'] = $JMmegamenuSubmenuFontColor;

		// -------------------------------------
		// header
		// -------------------------------------
		
		//background
		$JMheaderBackground = $this->params->get('JMheaderBackground', $this->defaults->get('JMheaderBackground')); 
		$bootstrap_vars['JMheaderBackground'] = $JMheaderBackground;
		
		//font color
		$JMheaderFontColor = $this->params->get('JMheaderFontColor', $this->defaults->get('JMheaderFontColor')); 
		$bootstrap_vars['JMheaderFontColor'] = $JMheaderFontColor;

		//module title
		$JMheaderModuleTitleFontColor = $this->params->get('JMheaderModuleTitleFontColor', $this->defaults->get('JMheaderModuleTitleFontColor')); 
		$bootstrap_vars['JMheaderModuleTitleFontColor'] = $JMheaderModuleTitleFontColor;

		// -------------------------------------
		// footer-mod
		// -------------------------------------
		
		//background
		$JMfooterBackground = $this->params->get('JMfooterBackground', $this->defaults->get('JMfooterBackground')); 
		$bootstrap_vars['JMfooterBackground'] = $JMfooterBackground;
		
		//font color
		$JMfooterFontColor = $this->params->get('JMfooterFontColor', $this->defaults->get('JMfooterFontColor')); 
		$bootstrap_vars['JMfooterFontColor'] = $JMfooterFontColor;
		
		//border
		$JMfooterBorder = $this->params->get('JMfooterBorder', $this->defaults->get('JMfooterBorder')); 
		$bootstrap_vars['JMfooterBorder'] = $JMfooterBorder;
		
		// -------------------------------------
		// copyright
		// -------------------------------------
		
		//background
		$JMcopyrightBackground = $this->params->get('JMcopyrightBackground', $this->defaults->get('JMcopyrightBackground')); 
		$bootstrap_vars['JMcopyrightBackground'] = $JMcopyrightBackground;
		
		//font color
		$JMcopyrightFontColor = $this->params->get('JMcopyrightFontColor', $this->defaults->get('JMcopyrightFontColor')); 
		$bootstrap_vars['JMcopyrightFontColor'] = $JMcopyrightFontColor;
		
		// -------------------------------------
		// modules
		// -------------------------------------

		//module title
		$JMmoduleTitleFontColor = $this->params->get('JMmoduleTitleFontColor', $this->defaults->get('JMmoduleTitleFontColor')); 
		$bootstrap_vars['JMmoduleTitleFontColor'] = $JMmoduleTitleFontColor;
		
		//color2-ms background
		$JMmoduleColor2msBackground = $this->params->get('JMmoduleColor2msBackground', $this->defaults->get('JMmoduleColor2msBackground')); 
		$bootstrap_vars['JMmoduleColor2msBackground'] = $JMmoduleColor2msBackground;
		
		//color2-ms font color
		$JMmoduleColor2msFontColor = $this->params->get('JMmoduleColor2msFontColor', $this->defaults->get('JMmoduleColor2msFontColor')); 
		$bootstrap_vars['JMmoduleColor2msFontColor'] = $JMmoduleColor2msFontColor;

		// -------------------------------------
		// offcanvas
		// -------------------------------------
		
		//background
        $JMoffCanvasBackground = $this->params->get('JMoffCanvasBackground', $this->defaults->get('JMoffCanvasBackground')); 
		$bootstrap_vars['JMoffCanvasBackground'] = $JMoffCanvasBackground;
		
		//font color
        $JMoffCanvasFontColor = $this->params->get('JMoffCanvasFontColor', $this->defaults->get('JMoffCanvasFontColor')); 
		$bootstrap_vars['JMoffCanvasFontColor'] = $JMoffCanvasFontColor;
		
		//module title
		$JMoffcanvasModuleTitle = $this->params->get('JMoffcanvasModuleTitle', $this->defaults->get('JMoffcanvasModuleTitle')); 
		$bootstrap_vars['JMoffcanvasModuleTitle'] = $JMoffcanvasModuleTitle;
		
		
		// -------------------------------------
		// extensions
		// -------------------------------------
		
		$JMmediatoolsDescriptionBackground = $this->params->get('JMmediatoolsDescriptionBackground', $this->defaults->get('JMmediatoolsDescriptionBackground')); 
		$bootstrap_vars['JMmediatoolsDescriptionBackground'] = $JMmediatoolsDescriptionBackground;
		
        $JMmediatoolsDescriptionFontColor = $this->params->get('JMmediatoolsDescriptionFontColor', $this->defaults->get('JMmediatoolsDescriptionFontColor')); 
		$bootstrap_vars['JMmediatoolsDescriptionFontColor'] = $JMmediatoolsDescriptionFontColor;
		
		$JMmediatoolsTitleFontColor = $this->params->get('JMmediatoolsTitleFontColor', $this->defaults->get('JMmediatoolsTitleFontColor')); 
		$bootstrap_vars['JMmediatoolsTitleFontColor'] = $JMmediatoolsTitleFontColor;
		
		// -------------------------------------
		// end 
		// -------------------------------------
       	$this->params->set('jm_bootstrap_variables', $bootstrap_vars);
	
		// -------------------------------------
		// compile LESS
		// -------------------------------------

		// Offline Page
		$this->CompileStyleSheet(JPath::clean(JMF_TPL_PATH.'/less/offline.less'), true);

		// DJ-Megamenu
		$djmegamenu_theme = $this->CompileStyleSheet(JPath::clean(JMF_TPL_PATH.'/less/djmegamenu.less'), true, true);
		
		// -------------------------------------
		// extensions themes
		// -------------------------------------	

        $app = JFactory::getApplication();		
		$themer = (int)$this->params->get('themermode', 0) == 1 ? true : false;
        if ($themer) { // add LESS files when Theme Customizer enabled
                
            $urlsToRemove = array(
            'templates/'.$app->getTemplate().'/css/djmegamenu.css' => array('url' => 'templates/'.$app->getTemplate().'/less/djmegamenu.less', 'type' => 'less')
            );
            $app->set('jm_remove_stylesheets', $urlsToRemove);
        } else { // add CSS files when Theme Customizer disabled 
            $urlsToRemove = array(
            'templates/'.$app->getTemplate().'/css/djmegamenu.css' => array('url' => $djmegamenu_theme, 'type' => 'css')
            );
            $app->set('jm_remove_stylesheets', $urlsToRemove);
        }
    }
}

