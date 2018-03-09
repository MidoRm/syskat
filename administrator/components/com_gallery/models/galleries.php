<?php 
/**
 * @package Huge IT Gallery
 * @author Huge-IT
 * @copyright (C) 2014 Huge IT. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @website		http://www.huge-it.com/
 **/
?>
<?php defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');

class GalleryModelGalleries extends JModelList {

    public function getListQuery() {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__huge_itgallery_gallerys');
        return $query;
    }

    public function getGallery() {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('#__huge_itgallery_gallerys.name, #__huge_itgallery_gallerys.id,count(*) as count');
        $query->from(array('#__huge_itgallery_gallerys' => '#__huge_itgallery_gallerys', '#__huge_itgallery_images' => '#__huge_itgallery_images'));
        $query->where('#__huge_itgallery_gallerys.id = gallery_id');
        $query->group('#__huge_itgallery_gallerys.name');
        $db->setQuery($query);
        $results = $db->loadObjectList();
        return $results;
    }

    public function getOther() {
        $db = JFactory::getDBO();
        $query2 = $db->getQuery(true);
        $query2->select('#__huge_itgallery_gallerys.name, #__huge_itgallery_gallerys.id,0 as count');
        $query2->from('#__huge_itgallery_gallerys');
        $query2->where('#__huge_itgallery_gallerys.id not in (select gallery_id from #__huge_itgallery_images)');
        $db->setQuery($query2);

        $results = $db->loadObjectList();
        return $results;
    }

}
