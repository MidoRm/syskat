<?php
/**
 * @package     Cwgallery
 * @subpackage  plg_content_cwgallery
 * @copyright   Copyright (C) 2015 Ing.Pavel Stary, Cesky WEB s.r.o., Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
//init Joomla Framework
  //defined('_JEXEC') or die; cant be used this way or ajax fail to load
  define( '_JEXEC', 1 );
	define( 'JPATH_BASE', realpath(dirname(__FILE__).'/../../../../..' )); // print this out or observe errors to see which directory you should be in
  if(!defined('DS')) {
    define( 'DS', DIRECTORY_SEPARATOR );
  }

	require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
	require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
	require_once( JPATH_CONFIGURATION   .DS.'configuration.php' );
	require_once ( JPATH_LIBRARIES .DS.'joomla'.DS.'database'.DS.'database.php' );
	require_once ( JPATH_LIBRARIES .DS.'joomla'.DS.'database'.DS.'database.php' );
  
$app = JFactory::getApplication('site');  

/* FUNCTIONS */

function output_file($file, $name, $mime_type='')
{
 /*
 This function takes a path to a file to output ($file),  the filename that the browser will see ($name) and  the MIME type of the file ($mime_type, optional).
 */

 //Check the file premission
 if(!is_readable($file)) die('Cannot access file!');
 
 $size = filesize($file);
 $name = rawurldecode($name);
 
 /* Detect the MIME type | Check in array */
 $known_mime_types=array(
 	"pdf" => "application/pdf",
 	"txt" => "text/plain",
 	"html" => "text/html",
 	"htm" => "text/html",
	"exe" => "application/octet-stream",
	"zip" => "application/zip",
	"doc" => "application/msword",
	"xls" => "application/vnd.ms-excel",
	"ppt" => "application/vnd.ms-powerpoint",
	"gif" => "image/gif",
	"png" => "image/png",
	"jpeg"=> "image/jpg",
	"jpg" =>  "image/jpg",
	"php" => "text/plain"
 );
 
 if($mime_type==''){
	 $file_extension = strtolower(substr(strrchr($file,"."),1));
	 if(array_key_exists($file_extension, $known_mime_types)){
		$mime_type=$known_mime_types[$file_extension];
	 } else {
		$mime_type="application/force-download";
	 };
 };
 
 //turn off output buffering to decrease cpu usage
 @ob_end_clean(); 
 
 // required for IE, otherwise Content-Disposition may be ignored
 if(ini_get('zlib.output_compression'))
  ini_set('zlib.output_compression', 'Off');
 
 header('Content-Type: ' . $mime_type);
 header('Content-Disposition: attachment; filename="'.$name.'"');
 header("Content-Transfer-Encoding: binary");
 header('Accept-Ranges: bytes');
 header("Cache-control: private");
 header('Pragma: private');
 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
 
 // multipart-download and download resuming support
 if(isset($_SERVER['HTTP_RANGE']))
 {
	list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
	list($range) = explode(",",$range,2);
	list($range, $range_end) = explode("-", $range);
	$range=intval($range);
	if(!$range_end) {
		$range_end=$size-1;
	} else {
		$range_end=intval($range_end);
	}

	$new_length = $range_end-$range+1;
	header("HTTP/1.1 206 Partial Content");
	header("Content-Length: $new_length");
	header("Content-Range: bytes $range-$range_end/$size");
 } else {
	$new_length=$size;
	header("Content-Length: ".$size);
 }
 
 /* Will output the file itself */
 $chunksize = 1*(1024*1024); //changeable
 $bytes_send = 0;
 if ($file = fopen($file, 'r'))
 {
	if(isset($_SERVER['HTTP_RANGE']))
	fseek($file, $range);
 
	while(!feof($file) && 
		(!connection_aborted()) && 
		($bytes_send<$new_length)
	      )
	{
		$buffer = fread($file, $chunksize);
		echo($buffer);
		flush();
		$bytes_send += strlen($buffer);
	}
 fclose($file);
 } else
 //If no permissiion
 die('Error - can not open file.');
 //die
die();
}

  /**
   * Method for generating download link for item
	 *
	 * @param	int	item ID
	 *
	 * @return	string    
   */ 
  function getFileLink($file_id)
  { 
    $db = JFactory::getDbo();

    //get item
    $query = "SELECT f.item_id, f.name AS file, f.path AS filename_real "
    . " FROM #__cwgallery_files AS f"
    . " WHERE MD5(f.id) = '".$file_id."'";
    $db->setQuery($query);
    $file = $db->loadObject();

    return $file;
  }
  
/* END FUNCTIONS */


/**
 * Start functionality
 */ 

  //Set the time out
  set_time_limit(0);
  $file = getFileLink($_REQUEST['id']);  
  //path to the file
  
  /**
   * Check if User has access for file
   */ 
   
	// Filter by access level.
  
  //get session
  $md5sid = JRequest::getVar('sid');
  if(isset($md5sid)){
    $db = JFactory::getDbo();
    $query = "SELECT * FROM #__session WHERE MD5(session_id) = ".$db->quote($md5sid);
    $db->setQuery($query);
    $session = $db->loadObject();

    if($session) {
        
      $user = JFactory::getUser($session->userid);
    	
      //$groups = $user->getAuthorisedViewLevels();

    //if(in_array($file->access,$groups)) {
      //Call the download function with file path,file name and file type
      
      //set real name without ID
      $name = explode('_',$file->file);
      unset($name[0]);
      $name = implode('_',$name);

      output_file( JPATH_SITE.$file->filename_real, ''.$name.'', '');
    //}
    }
    else{
      echo "Access forbidden!";
    }    
  }
  else{
    echo "Access forbidden!";
  } 
?>