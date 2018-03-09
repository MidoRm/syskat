<?php
/**
 * @package		CWGallery
 * @subpackage	plg_content_cwgallery
 * @copyright	Copyright (C) 2015 Ing.Pavel Stary, Cesky WEB s.r.o., Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */ 

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
if(!defined('DS')){
  define('DS',DIRECTORY_SEPARATOR);
} 

jimport( 'joomla.event.plugin' );
jimport('joomla.html.parameter'); 

class  plgContentCWGallery extends JPlugin{

  /**
   * Load the language file on instantiation.
   * Note this is only available in Joomla 3.1 and higher.
   * If you want to support 3.0 series you must override the constructor
   *
   * @var boolean
   * @since 3.1
   */
    
  protected $autoloadLanguage = true;
    
  function onContentPrepareForm($form, $data){
      //$app = JFactory::getApplication();
      if ($form->getName()=='com_content.article'){
          
          // for joomla 3.0
          $lang = JFactory::getLanguage();
  		    $lang->load('plg_content_cwgallery');
          
          JForm::addFormPath(JPATH_PLUGINS.DS.'content'.DS.'cwgallery'.DS.'cwgallery');
          $form->loadFile(JPATH_PLUGINS.DS.'content'.DS.'cwgallery'.DS.'cwgallery'.DS.'fields.xml', false);    
      }
  }

	/**
	 * Example after save content method
	 * Article is passed by reference, but after the save, so no changes will be saved.
	 * Method is called right after the content is saved
	 *
	 * @param	string		The context of the content passed to the plugin (added in 1.6)
	 * @param	object		A JTableContent object
	 * @param	bool		If the content is just about to be created
	 *
	 */

	public function onContentAfterSave($context, $article, $isNew)
	{

		return true;
	}

	public function onContentBeforeDelete($context, $article)
	{
    jimport('joomla.application.component.helper');
 
    //get plugin parameters    
    // generate and empty object
    $params = new JRegistry();
    // get plugin details
    $plugin = JPluginHelper::getPlugin('content','cwgallery');
    
    // load params into our params object
    if ($plugin && isset($plugin->params)) {
        $params->loadString($plugin->params);
    } 
    
    jimport('joomla.filesystem.folder');
 
    $files = plgContentCWGallery::getFiles($article->id);

    foreach($files as $file){
      JFile::delete( JPATH_ROOT . '' . $file->path);
      JFile::delete( JPATH_ROOT . '' . $file->thumb);
      plgContentCWGallery::deleteFile($file->id);
    }
    
		return true;
	}
  
  //public function onContentPrepare( $context, $article, &$params, $page = 0 ) {

  public function onContentBeforeDisplay($context, $article, $params, $limitstart=0) {

    //if(!isset($article->id) OR ) return;

    /**
     * Check if it is an article detail view
     */             
    if( JRequest::getVar('view') == 'article' || (JRequest::getVar('option') == 'com_content' && (JRequest::getVar('view') == 'category' || JRequest::getVar('view') == 'featured')) ) { 
    // since 1.0.5

      /***
       * IF THERE ARE IMAGES
       */         
      //if(is_array($images)){

        // load jquery for lightbox dependency
        JHtml::_('jquery.framework');

        /**
         *  get plugin parameters
         */         
        // generate and empty object
        $cparams = new JRegistry();
        // get plugin details
        $plugin = JPluginHelper::getPlugin('content','cwgallery');
        
        // load params into our params object
        if ($plugin && isset($plugin->params)) {
            $cparams->loadString($plugin->params);
        }
        /**
         * Load article attribs
         */     
        $aparams = new JRegistry();
        // load params into our params object
        if (isset($article->attribs)) {
            $aparams->loadString($article->attribs);
        }
        
        // position of gallery
        $position = $aparams->get('cwgallery_position');
        if(!isset($position)){ $position = $cparams->get('cwgallery_position',0); }

        $blog_use = $aparams->get('blog_use');
        if(!isset($blog_use)){ $blog_use = $cparams->get('blog_use',0); }

        $syntax = $cparams->get('syntax', 'cwgallery');

        //$regex_one		= '/({cwgallery\s*)(.*?)(})/si';
    		$regex_all		= '/{'.$syntax.'\s*.*?}/si';
        
        // findout if there are syntaxes in text - then use standard gallery position
        if(!isset($article->text)){
          $article->text = $article->introtext . $article->fulltext;
        }
        $matches 		= array();
        $count_matches	= preg_match_all($regex_all,$article->text,$matches,PREG_OFFSET_CAPTURE | PREG_PATTERN_ORDER);
        
        /**
         * Change the syntax for HTML code
         */
        if($count_matches > 0){

          $article->text = preg_replace_callback($regex_all, function($match) use($context, $article, $aparams, $cparams, $syntax) {
                    
              $option = $context;
              $oid = '';
  
              // HTML output
              $imagelist = '';
              
              $document = JFactory::getDocument();
                  
              /**
               * Layout settings
               */                 
              $layout = $aparams->get('layout');
              if(!isset($layout)){ $layout = $cparams->get('layout','gallery'); }     
            
              // position of gallery
              $position = $aparams->get('cwgallery_position');
              if(!isset($position)){ $position = $cparams->get('cwgallery_position',0); }
              
              $blog_use = $aparams->get('blog_use');
              if(!isset($blog_use)){ $blog_use = $cparams->get('blog_use',0); }
              
              
                          
              /**
               * Process stuff
               */         
              $regex_one		= '/({'.$syntax.'\s*)(.*?)(})/si';
              
              // Get plugin parameters
            	$cwgallery	= $match[0];
            	preg_match($regex_one,$cwgallery,$cwgallery_parts);
            	
              $parts			= explode(";", $cwgallery_parts[2]);
            	$values_replace = array ("/^'/", "/'$/", "/^&#39;/", "/&#39;$/", "/<br \/>/");
                 
              $options = new stdClass(); // syntax options
                     				
            	foreach($parts as $key => $value) {
            
                $value = trim($value);
                $values = explode("=", $value);
           
            		foreach ($values_replace as $key2 => $values2) {
            			$values = preg_replace($values2, '', $values);
            		}
            
                // Get plugin parameters from article
                if      ($values[0]=='start')			{$options->start				= $values[1];}  
                else if ($values[0]=='count')				{$options->count				= $values[1];}
                else if ($values[0]=='layout')		{$options->layout				= $values[1];}
                else if ($values[0]=='list')				{$options->list				= $values[1];}                
                
              }
              
              // get images
              $start = (isset($options->start)) ? $options->start -1 : '';
              $count = (isset($options->count)) ? $options->count : '';
              $list = (isset($options->list)) ? explode(',',$options->list) : '';              
              $images = plgContentCWGallery::getImages($article->id, $option, $oid, $start, $count, $list); // params for possible extended usability in other components            
              /***
               * IF THERE ARE IMAGES
               */         
              if(is_array($images)){
                /**
                 * INCLUDE LAYOUT
                 */
                if( !isset($options->layout) ) { $options->layout = $layout; }               
                include('cwgallery/layouts/'.$options->layout.'.php');    
              }   
              return $imagelist;
              
          }, $article->text);



          /**
           * Blog / featured          
           */          
          $article->introtext = preg_replace_callback($regex_all, function($match) use($context, $article, $aparams, $cparams, $syntax) {
                    
              $option = $context;
              $oid = '';
  
              // HTML output
              $imagelist = '';
              
              $document = JFactory::getDocument();
                  
              /**
               * Layout settings
               */                 
              $layout = $aparams->get('layout');
              if(!isset($layout)){ $layout = $cparams->get('layout','gallery'); }     
            
              // position of gallery
              $position = $aparams->get('cwgallery_position');
              if(!isset($position)){ $position = $cparams->get('cwgallery_position',0); }
              
              $blog_use = $aparams->get('blog_use');
              if(!isset($blog_use)){ $blog_use = $cparams->get('blog_use',0); }
              
              
                          
              /**
               * Process stuff
               */         
              $regex_one		= '/({'.$syntax.'\s*)(.*?)(})/si';
              
              // Get plugin parameters
            	$cwgallery	= $match[0];
            	preg_match($regex_one,$cwgallery,$cwgallery_parts);
            	
              $parts			= explode(";", $cwgallery_parts[2]);
            	$values_replace = array ("/^'/", "/'$/", "/^&#39;/", "/&#39;$/", "/<br \/>/");
                 
              $options = new stdClass(); // syntax options
                     				
            	foreach($parts as $key => $value) {
            
                $value = trim($value);
                $values = explode("=", $value);
           
            		foreach ($values_replace as $key2 => $values2) {
            			$values = preg_replace($values2, '', $values);
            		}
            
                // Get plugin parameters from article
                if      ($values[0]=='start')			{$options->start				= $values[1];}  
                else if ($values[0]=='count')				{$options->count				= $values[1];}
                else if ($values[0]=='layout')		{$options->layout				= $values[1];}
                else if ($values[0]=='list')				{$options->list				= $values[1];}                
                
              }
              
              // get images
              $start = (isset($options->start)) ? $options->start -1 : '';
              $count = (isset($options->count)) ? $options->count : '';
              $list = (isset($options->list)) ? explode(',',$options->list) : '';              
              $images = plgContentCWGallery::getImages($article->id, $option, $oid, $start, $count, $list); // params for possible extended usability in other components            
              /***
               * IF THERE ARE IMAGES
               */         
              if(is_array($images)){
                /**
                 * INCLUDE LAYOUT
                 */
                $document = JFactory::getDocument();
                $document->addScript(JUri::root().'plugins/content/cwgallery/cwgallery/assets/js/cwgallery.js');    
                if( !isset($options->layout) ) { $options->layout = $layout; }               
                include('cwgallery/layouts/'.$options->layout.'.php');    
              }   
              return $imagelist;
              
          }, $article->introtext);           

        }
        elseif(!$count_matches > 0 && $position !== "off"){        
        /**
         * Position
         * - if there are no syntaxes, place fullgallery on predefined system position in parameteres       
         */          
            $option = $context;
            $oid = '';
            
            // get images
            $images = $this->getImages($article->id, $option, $oid); // params for possible extended usability in other components
        
            
            $imagelist = '';
            /***
             * IF THERE ARE IMAGES
             */         

            if(is_array($images)){
        
              // set OG image property for FB share
              $og_image = JUri::root() . ltrim($images[0]->path,"/");
              $doc = JFactory::getDocument();
              $doc->setMetaData( 'og:image', $og_image );

              /**
               * Load article attribs
               */     
              $aparams = new JRegistry();
              // load params into our params object
              if (isset($article->attribs)) {
                  $aparams->loadString($article->attribs);
              }
        
              $document = JFactory::getDocument();
              //$document->addStyleDeclaration('');
              $document->addScript(JUri::root().'plugins/content/cwgallery/cwgallery/assets/js/cwgallery.js');    
                              
              // load jquery for lightbox dependency
              JHtml::_('jquery.framework');
      
              /**
               * INCLUDE LAYOUT
               * todo: multiple settings         
               */               
              $layout = $aparams->get('layout');
              if(!isset($layout)){ $layout = $cparams->get('layout','gallery'); }         
              include('cwgallery/layouts/'.$layout.'.php');   

              if (!isset($article->text)) {  
          			 	if (isset($article->fulltext)) {
                    $position == 1 ? $article->fulltext = $imagelist.$article->fulltext :  $article->fulltext = $article->fulltext.$imagelist;
                  }
          			 	else {
                    $position == 1 ? $article->introtext = $imagelist.$article->introtext :  $article->introtext = $article->introtext.$imagelist;
                  }
          	  }	
              elseif (isset($article->text)) {            
                if($blog_use == 1 && (JRequest::getVar('option') == 'com_content' && (JRequest::getVar('view') == 'category' || JRequest::getVar('view') == 'featured'))){
                    $position == 1 ? $article->introtext = $imagelist.$article->introtext :  $article->introtext = $article->introtext.$imagelist;
                } elseif(JRequest::getVar('option') == 'com_content' && (JRequest::getVar('view') != 'category' && JRequest::getVar('view') != 'featured')){                
                    // For LightGallery
                    $lightbox = $aparams->get('lightbox');
                    if(!$lightbox){ $lightbox = $cparams->get('lightbox','lightbox'); }
                    
                    if($lightbox == 'lightgallery') {
                    $imagelist = '           
                            <script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
                            <script src="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lightgallery.js"></script>
                            <script src="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-fullscreen.js"></script>
                            <script src="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-thumbnail.js"></script>
                            <script src="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-video.js"></script>
                            <script src="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-autoplay.js"></script>
                            <script src="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-zoom.js"></script>
                            <script src="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-hash.js"></script>
                            <script src="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lg-pager.js"></script>
                            <script src="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/libs/lightgallery/js/lib/jquery.mousewheel.min.js"></script>                      
                      '.$imagelist; //prefix before prepared imagelist                       
                    }
                    $position == 1 ? $article->introtext = $imagelist.$article->introtext :  $article->introtext = $article->introtext.$imagelist;                
                }                
                $position == 1 ? $article->text = $imagelist.$article->text :  $article->text = $article->text.$imagelist;
              }
            } // END IF images
            
            
        } // END position         

//    } // END IF images
      
    }// end if 

  }
  
  /**
   * Method to get image list for the article 
   */       
	function getImages($id, $option, $oid=null, $start=0, $count=99999999999999, $list = '' )
	{
		$db = JFactory::getDBO();

    if(!is_numeric($start)) { $start = 0; }
    if(!is_numeric($count)) { $count = 99999999999999; }
    
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('`#__cwgallery_files`');
		$query->where('`item_id`='.$db->quote($id));
    $query->where('publish = 1');
    $query->order('ordering ASC');    
		if($list == '') { $db->setQuery($query, $start, $count); }
    else {$db->setQuery($query);}
    
    if($images = $db->loadObjectList()){
      //filter $images by index
      if($list != '') {
        foreach($images as $key => $file){
          if(!in_array( ($key+1) , $list )){
            unset($images[$key]);
          }
        }
      }   
      return $images; 
    }    
    else {
      return false;
    }
	}

  function getFiles($item_id)
  { 
    $db = JFactory::getDbo();

    //get item
    $query = "SELECT f.* "
    . " FROM #__cwgallery_files AS f"
    . " WHERE f.item_id = '".$item_id."'";
    $db->setQuery($query);
    $files = $db->loadObjectList();

    return $files;
  }
  
  function deleteFile($id)
  { 
    $db = JFactory::getDbo();

    //get item
    $query = "DELETE "
    . " FROM #__cwgallery_files "
    . " WHERE id = '".$id."'";
    $db->setQuery($query);
    $db->query();

    return;
  }
         
}
?>