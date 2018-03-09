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
jimport('joomla.application.component.modeladmin');
jimport('joomla.application.component.helper');

class GalleryModelGallery extends JModelAdmin {

    public function getTable($type = 'Gallery', $prefix = 'GalleryTable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true) {

        $form = $this->loadForm(
                $this->option . '.gallery', 'gallery', array('control' => 'jform', 'load_data' => $loadData)
        );

        if (empty($form)) {
            return false;
        }

        return $form;
    }

    protected function loadFormData() {
        $data = JFactory::getApplication()->getUserState($this->option . '.editgallery.data', array());
        if (empty($data)) {
            $data = $this->getItem();
        }
        return $data;
    }

    public function getGallery() {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__huge_itgallery_gallerys');
        $db->setQuery($query);
        $results = $db->loadObjectList();
        return $results;
    }

    public function getPropertie() {
        $db = JFactory::getDBO();
        $id_cat = intval(JRequest::getVar('id'));
        $query = $db->getQuery(true);
        $query->select('#__huge_itgallery_images.name as name,'
                . '#__huge_itgallery_images.id ,'
                . '#__huge_itgallery_gallerys.name as portName,'
                . 'gallery_id, #__huge_itgallery_images.description as description,image_url,sl_url,sl_type,link_target,img_title,#__huge_itgallery_images.ordering,#__huge_itgallery_images.published,published_in_sl_width');
        $query->from(array('#__huge_itgallery_gallerys' => '#__huge_itgallery_gallerys', '#__huge_itgallery_images' => '#__huge_itgallery_images'));
        $query->where('#__huge_itgallery_gallerys.id = gallery_id')->where('gallery_id=' . $id_cat);
        $query->order('ordering desc');
        $db->setQuery($query);
        $results = $db->loadObjectList();
        return $results;
    }

    public function getImageByID() {
        $db = JFactory::getDBO();
        $id_cat = intval(JRequest::getVar('id'));
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__huge_itgallery_images');
        $query->where('gallery_id=' . $id_cat);
        $db->setQuery($query);
        $results = $db->loadObjectList();
        return $results;
    }
    

   public function save($data) {
        $db = JFactory::getDBO();       
        $result = $this->getPropertie();
        $this->updarteGallery();
        $this->selectStyle();
        foreach ($result as $key => $value) {
            $imageId = intval($value->id);
            $titleimage = htmlspecialchars($data['titleimage' . $imageId]);
            $im_description1 = $data['im_description'. $imageId];
            $im_description = preg_quote($im_description1,'"');
            $sl_url = htmlspecialchars($data['sl_url'. $imageId]);
            $sl_link_target = htmlspecialchars($data['sl_link_target'. $imageId]);
            $ordering = $data['order_by_'. $imageId];
            $image_url = htmlspecialchars($data['image_url'. $imageId]);
            $query = $db->getQuery(true);
            $query->update('#__huge_itgallery_images')->set('name="' . $titleimage . '"')->set('description="' . $im_description . '"')
                    ->set('sl_url="' . $sl_url . '"')->set('link_target="' . $sl_link_target . '"')
                    ->set('ordering="' . $ordering . '"')->set('image_url="' . $image_url . '"')->where('id="' . $imageId . '"') ;
            $db->setQuery($query);
            $db->execute();
            
        }      
        
    }

    function updarteGallery() {
        $db = JFactory::getDBO();
        $data = JRequest::get('post');
        $name = htmlspecialchars($data['name']);
        $huge_it_sl_effects = $data['huge_it_sl_effects'];
        $sl_width = (isset($data['sl_width']) ? $data['sl_width'] : "");
        $sl_height = (isset($data['sl_height']) ? $data['sl_height'] : "");
        $pause_on_hover = (isset($data['pause_on_hover']) ? $data['pause_on_hover'] : "");
        $sl_pausetime = (isset($data['sl_pausetime']) ? $data['sl_pausetime'] : "" );
        $sl_changespeed = (isset($data['sl_changespeed']) ? $data['sl_changespeed'] : "");
        $sl_position = (isset($data['sl_position']) ? $sl_position = $data['sl_position'] : $sl_position = "");
        $gallery_list_effects_s = (isset($data['gallery_list_effects_s']) ? $gallery_list_effects_s = $data['gallery_list_effects_s'] : $gallery_list_effects_s = "");
        $display_type = $data['display_type'];
        $content_per_page = $data['content_per_page'];
        $id_cat = intval(JRequest::getVar('id'));

        $query = $db->getQuery(true);
        $query->update('#__huge_itgallery_gallerys')->set('name ="' . $name . '"')
                ->set('sl_width ="' . $sl_width . '"')
                ->set('sl_height ="' . $sl_height . '"')
                ->set('pause_on_hover ="' . $pause_on_hover . '"')
                ->set('description ="' . $sl_pausetime . '"')
                ->set('param ="' . $sl_changespeed . '"')
                ->set('sl_position ="' . $sl_position . '"')
                ->set('huge_it_sl_effects="' . $huge_it_sl_effects . '"')
                ->set('gallery_list_effects_s="' . $gallery_list_effects_s . '"')
                ->set('display_type="' . $display_type . '"')
                ->set('content_per_page="' . $content_per_page . '"')
                ->where('id="' . $id_cat . '"');
        $db->setQuery($query);
        $db->execute();
    }

    function selectStyle() {
        $db = JFactory::getDBO();
        $data = JRequest::get('post');
        $styleName = $data['gallery_list_effects_s'];
        $id_cat = intval(JRequest::getVar('id'));
        $query = $db->getQuery(true);
        $query->update('#__huge_itgallery_gallerys')->set('gallery_list_effects_s ="' . $styleName . '"')->where('id="' . $id_cat . '"');
        $db->setQuery($query);
        $db->execute();
    }

       public function saveCat() {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->insert('#__huge_itgallery_gallerys', 'id')->set('name = "New Gallery"')
                ->set('sl_height = 375')
                ->set('sl_width = 600')
                ->set('pause_on_hover = "on"')
                ->set('gallery_list_effects_s = "cubeH"')
                ->set('description=4000')
                ->set('param = 1000')
                ->set('sl_position = "left"');
        $db->setQuery($query);
        $db->execute();
        return $db->insertid();
    }
    
       private function getNumber($galleryId) {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('max(ordering) as maximum');
        $query->from('#__huge_itgallery_images');
        $query->where('gallery_id=' . $galleryId);
        $db->setQuery($query);
        $results = $db->loadResult();
        return $results;        
    }
    function saveProject($imageUrl, $galleryId) {
        $imageUrl = htmlspecialchars($imageUrl);
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $ordering = $this->getNumber($galleryId) + 1;
        $query->insert('#__huge_itgallery_images', 'id')->set('gallery_id = "' . $galleryId . '"')
                ->set('image_url= "' . $imageUrl . '"')
                ->set('sl_type= "image"')
                ->set('ordering= "'.$ordering.'"');
        $db->setQuery($query);
        $db->execute();
        return $galleryId;
    }

    public function deleteProject() {
        $id_cat = intval(JRequest::getVar('removeslide'));
        $id = intval(JRequest::getVar('id'));
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->delete('#__huge_itgallery_images')->where('id =' . $id_cat);
        $db->setQuery($query);
        $db->execute();
        return;
    }
}
