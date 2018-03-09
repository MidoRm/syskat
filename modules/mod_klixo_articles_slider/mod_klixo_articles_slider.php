<?php
/* ------------------------------------------------------------------------
 *  mod_klixo_articles_slider  - Version 1.3.6
 * 20140227
 * ------------------------------------------------------------------------
 * Copyright (C) 2011-2014 Klixo. All Rights Reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * Author: JF Thier Klixo
 * Website: http://www.Klixo.se
 * ------------------------------------------------------------------------- */
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__) . '/helper.php');

jimport("joomla.filter.filterinput");

$jVersion = new JVersion();
$currentJoomla = $jVersion->RELEASE;

$moduleclass_sfx = $params->get("moduleclass_sfx", '');
$target = $params->get("target", '');
$jquery = $params->get("jquery", 0);
$pause = $params->get("pause", 'true');
$transition = $params->get("transition", 'fade');
$randomizeEffects = $params->get("randomizeEffects", 1);
$auto_play = $params->get("auto_play", '1');
$slideshow_speed = $params->get("slideshow_speed", 800) * 1000;
$timer_speed = $params->get("timer_speed", 4000) * 1000;
$navBarColor = $params->get("navBarColor", '');
$navBarTxtColor = $params->get("navBarTxtColor", '#64a6c9');
$navBarTxtSelectColor = $params->get("navBarTxtSelectColor", '#e62929');
$title_color = $params->get("title_color", '#FFFFFF');
$title_font_size = $params->get("title_font_size", '16');
$prenext_show = $params->get("prenext_show", '1');
$show_title = $params->get("show_title", 'true');
$show_readmore = $params->get('show_readmore', "0");
$ReadMore_font_size = $params->get('ReadMore_font_size', "14");
$description_color = $params->get('description_color', "#FFFFFF");
$content_font_size = $params->get('content_font_size', "14");
$link_title = $params->get('link_title', 1);
$button_style = $params->get('button_style', 'number');
$desc_box_width = $params->get('slideShow_width');
$slideShow_width = $params->get('slideShow_width', '600');
$slideShow_height = $params->get('slideShow_height', '300');
$slideShow_background = $params->get('slideShow_background', '');
$read_more_color = $params->get('read_more_color', '#000000');
$readmore_Btn = JText::_('MORE_INFO');
$css_Scaling = $params->get('css_scaling', '0');


$transitionList = "";
foreach ($transition as $key) {
    $transitionList == "" ? $transitionList.= $key : $transitionList.= ',' . $key;
}

$widthIe = 0;
$currentBrowser = "";



jimport('joomla.environment.browser');
$browser = JBrowser::getInstance();
$browserName = $browser->getBrowser();
$browserVersion = $browser->getMajor();

$crapIE6 = false;
if ($browserName == 'msie' && $browserVersion == 6) {
    $widthIe = 3;
    $crapIE6 = true;
}
if (!defined('KLIXO_ARTICLES_SLIDER')) {
    define('KLIXO_ARTICLES_SLIDER', 1);

    if ($jquery) {
        if ($currentJoomla < 3) {
            JHTML::script(JURI::base() . '/modules/' . $module->module . '/assets/jquery-1.8.3.min.js');
        } else {
            //For Joomla 3.x versions. Load jQuery Lib from Joomla CMS
            JHtml::_('jquery.framework');
        }
    }
    /* Add css */

    JHtml::stylesheet(JURI::base() . '/modules/' . $module->module . '/assets/style.min.css');

    if ($browserName == 'msie' && $browserVersion == 6) {
        JHtml::stylesheet(JURI::base() . '/modules/' . $module->module . '/assets/ie6.css');
    } else if ($browserName == 'msie' && $browserVersion == 7) {
        JHTML::stylesheet(JURI::base() . '/modules/' . $module->module . '/assets/ie7.css');
        $currentBrowser = 'IE7';
    }

    JHtml::script(JURI::base() . '/modules/' . $module->module . '/assets/jquery.cycle.all.min.js');

    JHtml::script(JURI::base() . '/modules/' . $module->module . '/assets/slider.min.js');
}

$GLOBALS["module"] = $module;
$items = modKlixoArticlesSliderHelper::getContentList($params);

$themePath = JModuleHelper::getLayoutPath('mod_klixo_articles_slider');

if (file_exists($themePath)) {
    require($themePath);
}
?>