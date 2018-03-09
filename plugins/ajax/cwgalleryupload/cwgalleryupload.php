<?php
/**
 * @package		CWGallery
 * @subpackage	plg_content_cwgalleryupload
 * @copyright	Copyright (C) 2015 Ing.Pavel Stary, Cesky WEB s.r.o., Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */ 

defined('_JEXEC') or die;

// Import library dependencies
jimport('joomla.plugin.plugin');

class plgAjaxCWGalleryUpload extends JPlugin
{

	function onAjaxCWGalleryUpload()
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

    //for db only relative path       
    $filepath = $params->get('path');   //2
     
    if (!empty($_FILES)) {
        //$prefix = rand();
        //set values
        $id = JRequest::getVar('id');
        $rid = md5(time().rand());//JRequest::getVar('rid');        
        $type = JRequest::getVar('type');
        $field = JRequest::getVar('field');
        $size = $_FILES['file']['size'];
        $type = $_FILES['file']['type'];  
                
        //$filepath = $filepath . $id . '/';
        
        // set prefix as ID - files will be unique across item ids, can overwrite within item ID
        $prefix = $id.'_';
        
        $tempFile = $_FILES['file']['tmp_name'];          //3             
        //$targetPath = JPATH_ROOT . DIRECTORY_SEPARATOR. 'images' . DIRECTORY_SEPARATOR . 'cwcourses' . DIRECTORY_SEPARATOR . $storeFolder . DIRECTORY_SEPARATOR;  //4     
        //for upload absolute path
        $targetPath = JPATH_ROOT . $filepath;  
          
        // import joomla's filesystem classes
        jimport('joomla.filesystem.file');
        jimport('joomla.filesystem.folder');

          JFile::copy(JPATH_ROOT. DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'index.html', $targetPath . 'index.html');

        //check if folder exist - create if needed
        if (!JFolder::exists($targetPath)) {
          JFolder::create($targetPath);
          JFile::copy(JPATH_ROOT. DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'index.html', $targetPath. 'index.html');
        }
        //copy file        
        $name = $prefix.$_FILES['file']['name'];
        $caption = $_FILES['file']['name'];

        $path_parts = pathinfo($_FILES['file']['name']); //get file parts - for getting extension
        $filename = $prefix.md5($_FILES['file']['name'].rand()).'.'.$path_parts["extension"]; //hash the filename for unique string

        $targetFile =  $targetPath. $filename;  //5
        //move_uploaded_file($tempFile,$targetFile); //6
        JFile::copy($tempFile,$targetFile);
    
        // Store in DB
        $db = JFactory::getDbo();        
        
        //get ordering number
        $query = "SELECT max(ordering) + 1 FROM #__cwgallery_files WHERE item_id = ".$db->quote($id)." LIMIT 1";
        $db->setQuery($query);
        if($ordering = $db->loadResult()){
          //is set          
        }
        else {
          $ordering = 1;
        }

        //get size
        $query = "SELECT attribs FROM #__content WHERE id = ".$db->quote($id)." LIMIT 1";
        $db->setQuery($query);

        if($attribs = $db->loadResult()){          
          $attribs = json_decode($attribs);
          $width = $attribs->cwgallery_thumb_width;          
          $height = $attribs->cwgallery_thumb_height;
        } else {
          $width = 0;
          $height = 0;
        }
                
        $query = "INSERT INTO #__cwgallery_files VALUES (null,".$id.",'".$rid."','".$field."','".$type."','".$name."','".$filepath.$filename."','".$filepath.'thumb_'.$filename."',".$size.",".$ordering.",'".$caption."','',1)";
        $db->setQuery($query);
        $db->query();     

        //create thumb
        $config = array();
        $config['thumb_width'] = (((int)$width > 0) ? $width : $params->get('thumb_width',200));
        $config['thumb_height'] = (((int)$height > 0) ? $height : $params->get('thumb_height',200));
        $config['thumb_crop'] = $params->get('thumb_crop',1);
        $config['thumb_quality'] = $params->get('thumb_quality',80);
        $config['item_id'] = $id; 
        $config['path'] = $params->get('path');       
        self::cwThumb($targetFile,$config);

        return;
        
    }
    
    return true;
  }
  
  /**
   * create thumbnail  
   */    
  function cwThumb($source_image, $config)
  {
    //get a filename
    $fname_array = explode('/',$source_image);
    $fname = $fname_array[count($fname_array)-1];
    $fname = "thumb_".$fname;
    
    /**
     * check if thumb exist cached
     */
    /*
    if(self::checkThumbCache($fname, $config['thumb_cache_time'])){  
		  $filepath = JUri::root().'modules/mod_cwnews/cache/'.$fname;
      return $filepath;
    }
    */
    /**
     * else create thumb
     */     
    //elseif
    if($source_image != '') {
       
    	if( ! $image_data = getimagesize( $source_image ) )
    	{
    		return false;
    	}
    
      $width = $config['thumb_width'];
      $height = $config['thumb_height'];
      $crop = $config['thumb_crop'];
      $quality = $config['thumb_quality'];
    
      $dst = JPATH_ROOT.$config['path'].$fname;
      $filepath = JUri::root().$config['path'].$fname;
        
        // import joomla's filesystem classes
        jimport('joomla.filesystem.file');
        jimport('joomla.filesystem.folder');      
        JFile::delete($dst);
        
    	switch( $image_data['mime'] )
    	{
    		case 'image/gif':
    			$get_func = 'imagecreatefromgif';
    			$suffix = ".gif";
    		break;
    		case 'image/png':
    			$get_func = 'imagecreatefrompng';
    			$suffix = ".png";
    		break;
    		case 'image/jpeg':
        default:
    			$get_func = 'imagecreatefromjpeg';
    			$suffix = ".jpg";
          
    		break;                
        
    	}
     
    	$original_image = call_user_func( $get_func, $source_image );
    	$original_width = $image_data[0];
    	$original_height = $image_data[1];
    	$thumb_width = $width;
    	$thumb_height = $height;
    	$src_x = 0;
    	$src_y = 0;
    	$current_ratio = round( $original_width / $original_height, 2 );
    	$desired_ratio_after = round( $width / $height, 2 );
    	$desired_ratio_before = round( $height / $width, 2 );
     
    	if( $original_width < $width || $original_height < $height )
    	{
    		//Thumbnail size is bigger than the original image. Leave it.
    		//return false;
    	}
     
     
    	// Crop enabled
    	if( $crop == 1 )
    	{      
    		// Create blank image for thumbnail creation
    		$thumb_image = imagecreatetruecolor( $width, $height );
     
    		// Landscape Image
    		if( $current_ratio > $desired_ratio_after )
    		{
    			$thumb_width = $original_width * $height / $original_height;
    		}
     
    		// Square-like ratio image
    		if( $current_ratio > $desired_ratio_before && $current_ratio < $desired_ratio_after )
    		{
    			if( $original_width > $original_height )
    			{
    				$thumb_height = max( $width, $height );
    				$thumb_width = $original_width * $thumb_height / $original_height;
    			}
    			else
    			{
    				$thumb_height = $original_height * $width / $original_width;
    			}
    		}
     
    		// Portrait sized image                            
    		if( $current_ratio < $desired_ratio_after  ) // was $desired_ratio_before..tried this
    		{
    			$thumb_height = $original_height * $width / $original_width;
    		}
     
    		// Get a ratio of the original/thumb to find out where to crop.
    		$width_ratio = $original_width / $thumb_width;
    		$height_ratio = $original_height / $thumb_height;
     
    		//Calculation where to crop - according on the center of the image
    		$src_x = floor( ( ( $thumb_width - $width ) / 2 ) * $width_ratio );
    		$src_y = round( ( ( $thumb_height - $height ) / 2 ) * $height_ratio );
    	}
    	// No crop, only resize with keeping aspect
    	else
    	{
    		if( $original_width > $original_height )
    		{
    			$ratio = max( $original_width, $original_height ) / max( $width, $height );
    		}else{
    			$ratio = max( $original_width, $original_height ) / min( $width, $height );
    		}
     
    		$thumb_width = $original_width / $ratio;
    		$thumb_height = $original_height / $ratio;
     
    		$thumb_image = imagecreatetruecolor( $thumb_width, $thumb_height );
    	}
     

    	// Save it as a ? File with $dst param.    
    	switch( $image_data['mime'] )
    	{
    		case 'image/png':

              // enable alpha blending on the destination image. 
              imagealphablending($thumb_image, true); 
              
              // Allocate a transparent color and fill the new image with it. 
              // Without this the image will have a black background instead of being transparent. 
              $transparent = imagecolorallocatealpha( $thumb_image, 0, 0, 0, 127 ); 
              imagefill( $thumb_image, 0, 0, $transparent ); 
    
          	  //process 
          	  imagecopyresampled( $thumb_image, $original_image, 0, 0, $src_x, $src_y, $thumb_width, $thumb_height, $original_width, $original_height );       
    
              imagealphablending($thumb_image, false); 

              // save the alpha 
              imagesavealpha($thumb_image,true); 

              imagepng( $thumb_image, $dst  );
    		break;
        
    		case 'image/jpeg':
        default:
             	//process 
            	imagecopyresampled( $thumb_image, $original_image, 0, 0, $src_x, $src_y, $thumb_width, $thumb_height, $original_width, $original_height );
         
              imagejpeg( $thumb_image, $dst, $quality  );
    		break;                        
    	}
           
      // clear memory
    	imagedestroy( $thumb_image );
    	imagedestroy( $original_image );
     
    	return true;
    }
  	else {
  		return false;
  	}    
  }
  
  /**
   * check if thumbnail exists (no use here yet)  
   */  
  /*
  function checkThumbCache($filename, $cache_time) {
		
    // cache directory
		$cache_dir = JPATH_ROOT.DS.'modules'.DS.'mod_cwnews'.DS.'cache'.DS;
		// path to file
    $filepath = $cache_dir.$filename;
		
    //check if file exists and cache time is set
    if(is_file($filepath) && (int) $cache_time > 0) {
      // decide if file cache has run out: by date of file change + cache time 
      $result = filemtime($filepath) + 60 * (int) $cache_time > time();
    } 
    else {
      $result = false;
    }
    
    return $result;
	}
  */    
  /**
   * Function for Ajax call from dropzone upload
   */     
  public static function onAjaxRemoveFile(){
    
    //set values
    $item_id = JRequest::getVar('id');
    $name = JRequest::getVar('name');
    $ordering = JRequest::getVar('ordering');

    // Get db
    $db = JFactory::getDbo();    
    $query = "SELECT id,ordering FROM #__cwgallery_files WHERE item_id = ".intval($item_id)." ORDER BY ordering";
    $db->setQuery($query);
    $rows = $db->loadObjectList();
    foreach($rows as $rkey => $row){
      if($ordering == $rkey + 1){
        $id = $row->id;
      }
    }
    
    // Get path
    $query = "SELECT id,path,thumb FROM #__cwgallery_files WHERE id = ".$db->quote($id)." AND item_id = ".$db->quote($item_id);
    $db->setQuery($query);
    $file = $db->loadObject();

    // Delete from DB      
    $query = "DELETE FROM #__cwgallery_files WHERE id = ".$db->quote($id)." AND item_id = ".$db->quote($item_id);
    $db->setQuery($query);
    $db->query();     
    
    jimport('joomla.filesystem.file');
    
    // delete file
    $file_item = JPATH_ROOT . $file->path;
    if (is_file($file_item)) {
      JFile::delete($file_item);
    }
    // delete thumb
    $file_item = JPATH_ROOT . $file->thumb;
    if (is_file($file_item)) {
      JFile::delete($file_item);
    }
            
    return true;
  }        
    
	function onAjaxCWGalleryGenerate()
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

    //for db only relative path       
    $filepath = $params->get('path');   //2
    
    // Load images from DB
    $db = JFactory::getDbo();        
    
    $id = JRequest::getVar('id');
    $query = "SELECT * FROM #__cwgallery_files WHERE item_id = '".$id."' ";
    $db->setQuery($query);

    if($images = $db->loadObjectList()){
      foreach($images as $image) {
 
        //for upload absolute path
        $targetFile = JPATH_ROOT . $image->path;  
          
        //get size
        $query = "SELECT attribs FROM #__content WHERE id = '".$id."' LIMIT 1";
        $db->setQuery($query);

        if($attribs = $db->loadResult()){          
          $attribs = json_decode($attribs);
          $width = (isset($attribs->cwgallery_thumb_width)) ? $attribs->cwgallery_thumb_width : '200';        
          $height = (isset($attribs->cwgallery_thumb_height)) ? $attribs->cwgallery_thumb_height : '160';
        } else {
          $width = 0;
          $height = 0;
        }  

        //create thumb
        $config = array();
        $config['thumb_width'] = (((int)$width > 0) ? $width : $params->get('thumb_width',200));
        $config['thumb_height'] = (((int)$height > 0) ? $height : $params->get('thumb_height',200));
        $config['thumb_crop'] = $params->get('thumb_crop',1);
        $config['thumb_quality'] = $params->get('thumb_quality',80);
        $config['item_id'] = $id; 
        $config['path'] = $params->get('path');       
        
        if(!self::cwThumb($targetFile,$config)){
          $error = true;
        }
        
      }
    }
    
    if(isset($error)){
      return false;
    }
    return true;
  }

  /**
   * Function for Ajax call from dropzone upload
   */     
  public static function onAjaxSortFiles(){
    
    //set values
    $id = JRequest::getVar('id');
    //$field = JRequest::getVar('field');
    $orderlist = JRequest::getVar('orderlist');
    
    $order = json_decode($orderlist);  
        
    if(isset($id) && isset($orderlist)){
        
      // Get db
      $db = JFactory::getDbo();    
      $query = "SELECT id,ordering FROM #__cwgallery_files WHERE item_id = ".intval($id)." ORDER BY ordering";
      $db->setQuery($query);
      $rows = $db->loadObjectList();
      foreach($rows as $rkey => $row){
        foreach($order as $ikey => $item){
          if($item->old_order == $rkey + 1){
            $item->id = $row->id;
          }
        }
      }
             
      foreach($order as $item){
        if(isset($item->order) && isset($item->name) && isset($item->old_order)){
          
          $query = "UPDATE #__cwgallery_files SET ordering = ".$db->quote($item->order)." WHERE id = ".$db->quote($item->id)." AND name = ".$db->quote($item->name)." AND item_id = ".$db->quote($id);
          $db->setQuery($query);
          $db->query();
        }
      }
      
      return true;
    } else {
      return false;
    }
  }
  
  /**
   * Function for Ajax call from dropzone rename
   */     
  public static function onAjaxRenameFile(){
    
    //set values
    $ordering = JRequest::getVar('ordering');
    $name = JRequest::getVar('name');
    $description = JRequest::getVar('description');
    $item_id = JRequest::getVar('id');
    $caption = JRequest::getVar('caption');
    
    $description = trim($description,'"');

    // Get db
    $db = JFactory::getDbo();

    $index = $ordering - 1;
    if(isset($item_id) && isset($index)){
      $query = "SELECT id FROM #__cwgallery_files WHERE item_id = ".intval($item_id)." ORDER BY ordering LIMIT ".intval($index).", 1";
      $db->setQuery($query);
      $id = $db->loadResult();
      
      if($caption == true){
        $query = "UPDATE #__cwgallery_files SET caption = ".$db->quote($name)." WHERE id = ".$db->quote($id);
      } elseif(isset($description)) {
        $query = "UPDATE #__cwgallery_files SET caption = ".$db->quote($name).", description = ".$db->quote($description)." WHERE id = ".$db->quote($id);        
      }
      $db->setQuery($query);
      $db->query();        
      
      return $id;
    }
  }

  /**
   * create thumbnail  
   */    
  function onAjaxCwJCropThumb()
  {
    jimport('joomla.application.component.helper');
    
    $array_config = json_decode($_GET['config']);
    
    if(is_array($array_config)){
      $config = $array_config[0];    
  
      //get plugin parameters    
      // generate and empty object
      $params = new JRegistry();
      // get plugin details
      $plugin = JPluginHelper::getPlugin('content','cwgallery');
      
      // load params into our params object
      if ($plugin && isset($plugin->params)) {
          $params->loadString($plugin->params);
      }
  
      //for db only relative path       
      $config->path = $params->get('path');   //2
      $config->source_image = JUri::root().substr($config->source_image,3);
      
      //get a filename
      $fname_array = explode('/',$config->source_image);
      $fname = $fname_array[count($fname_array)-1];
      $fname = "thumb_".$fname;
  
      $dst = JPATH_ROOT.$config->path.$fname;    
      
    	$jpeg_quality = 90;
      	
  //  $img_r = imagecreatefromjpeg($config->source_image);
    	if( ! $img_data = getimagesize( $config->source_image ) )
    	{
    		return false;
    	}
      
    	switch( $img_data['mime'] )
    	{
    		case 'image/gif':
    			$get_func = 'imagecreatefromgif';
    			$suffix = ".gif";
    		break;
    		case 'image/jpeg';
    			$get_func = 'imagecreatefromjpeg';
    			$suffix = ".jpg";
    		break;
    		case 'image/png':
    			$get_func = 'imagecreatefrompng';
    			$suffix = ".png";
    		break;
    	}
       
      $img_r = call_user_func( $get_func, $config->source_image );
      
      
    	$dst_r = ImageCreateTrueColor( $config->targ_w, $config->targ_h );
    
    	imagecopyresampled($dst_r,$img_r,0,0,$config->x,$config->y,
    	$config->targ_w,$config->targ_h,$config->w,$config->h);
    	
    	imagejpeg($dst_r,$dst,$jpeg_quality);  
      // clear memory
    	imagedestroy( $dst_r );
    	imagedestroy( $img_r );
      
      return $config; 
    }
    
  }
  /**
   * Function for Ajax call from dropzone publish
   */     
  public static function onAjaxPublishFile(){
    
    //set values
    $ordering = JRequest::getVar('ordering');
    $publish = JRequest::getVar('publish');
    $item_id = JRequest::getVar('id');

    // Get db
    $db = JFactory::getDbo();

    $index = $ordering - 1;
    
    if(isset($item_id) && isset($index) && isset($publish)){
      $query = "SELECT id FROM #__cwgallery_files WHERE item_id = ".intval($item_id)." ORDER BY ordering LIMIT ".intval($index).", 1";
      $db->setQuery($query);
      $id = $db->loadResult();
      
      $query = "UPDATE #__cwgallery_files SET publish = ".$db->quote($publish)." WHERE id = ".intval($id);
      $db->setQuery($query);
      $db->query();    
      
      return $id;
    } else {
      return false;
    }
  }
}
