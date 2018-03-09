<?php
/* ------------------------------------------------------------------------
 *  mod_klixo_articles_slider  - Version 1.3.6
 * 20140206
 * ------------------------------------------------------------------------
 * Copyright (C) 2011-2014 Klixo. All Rights Reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * Author: JF Thier Klixo
 * Website: http://www.Klixo.se
 * ------------------------------------------------------------------------- */

defined('_JEXEC') or die('Restricted access');

require_once JPATH_SITE . '/components/com_content/helpers/route.php';

jimport('joomla.application.component.model');

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_content/models', 'ContentModel');

abstract class modKlixoArticlesSliderHelper {

    public static function getContentList(&$params) {
        // Get an instance of the generic articles model
        $model = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));

        // Set application parameters in model
        $app = JFactory::getApplication();
        $appParams = $app->getParams();
        $model->setState('params', $appParams);

        // Set the filters based on the module params
        $model->setState('list.start', 0);
        $model->setState('list.limit', (int) $params->get('count', 5));
        $model->setState('filter.published', 1);
        $model->setState('filter.featured', $params->get('featured', "show"));

        // Access filter
        $access = !JComponentHelper::getParams('com_content')->get('show_noauth');
        $authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
        $model->setState('filter.access', $access);

        // Category filter
        $model->setState('filter.category_id', $params->get('categoryId', array()));

        // Filter by language
        $model->setState('filter.language', $app->getLanguageFilter());

        // Ordering
        $ordering = $params->get('ordering', 'a.ordering');
        $model->setState('list.ordering', $ordering);
        if (trim($ordering) == 'rand()') {
            $model->setState('list.direction', '');
        } else {
            $model->setState('list.direction', $params->get('sort_order', "ASC"));
        }

        $items = $model->getItems();

        foreach ($items as &$item) {
            $item->content = ($params->get('show_img') == '0' || $params->get('reformat_content') == '1' ) ? modKlixoArticlesSliderHelper::stripTags($item->introtext) : $item->introtext;
            $item->slug = $item->id . ':' . $item->alias;
            $item->catslug = $item->catid . ':' . $item->category_alias;

            if ($access || in_array($item->access, $authorised)) {
                // We know that user has the privilege to view the article
                $item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
            } else {
                $item->link = JRoute::_('index.php?option=com_users&view=login');
            }
            if (!isset($item->sub_title)) {
                $item->sub_title = modKlixoArticlesSliderHelper::cutStr($item->title, $params->get('limittitle', 25));
            }
            if (!isset($item->sub_content)) {

                if ($params->get('reformat_content') == 1) {
                    $item->sub_content = modKlixoArticlesSliderHelper::cutStr($item->content, $params->get('limit_description'));
                } else {
                    $item->sub_content = $item->content;
                }
            }
        }
        return $items;
    }

    function stripTags($str) {
        $regex = array("/\<img[^\>]*>/", "/<div class=\"mosimage\".*<\/div>/", "/<object[0-9 a-z_?*=\"&\;\:\-\/\.#\,<>\\n\\r\\t]+<\/object>/smi", "/<iframe[0-9 a-z_?*=\"&\;\:\-\/\.#\,<>\\n\\r\\t]+<\/iframe>/smi");
        $str = preg_replace($regex, '', $str);
        return $str;
    }

    static function cutStr($str, $number) {

        //If length of string less than $number

        $str = strip_tags($str);

        if (strlen($str) <= $number) {

            return $str;
        }

        $str = substr($str, 0, $number);
        $pos = strrpos($str, ' ');
        return substr($str, 0, $pos) . ' [...]';
    }

}

?>