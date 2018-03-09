<?php
/**
* @Copyright Copyright (C) 2012- adxmlgallery 1.7 by Smallirons
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once (dirname(__FILE__).DS.'noimage_functions.php');
if(!defined('DS')){
define('DS',DIRECTORY_SEPARATOR);
}


if (!function_exists('GetHColor')) {
function GetHColor($params, $tag_name, $curr_h_val = 'FFFFFF', $curr_h_sym = '0x')
{
	$curr_pinput = $params->get($tag_name, $curr_h_sym . $curr_h_val);
	if (strtolower(substr($curr_pinput, 0, 2)) == '0x') {
		$curr_hex = substr($curr_pinput, 2);
	} elseif (substr($curr_pinput, 0, 1) == '#') {
		$curr_hex = substr($curr_pinput, 1);
	} else {
		$curr_hex = $curr_pinput;
	}
	if (strspn($curr_hex, "0123456789abcdefABCDEF") == 6 && strlen($curr_hex) == 6) {
		$curr_pinput = $curr_h_sym . $curr_hex;
	} else {
		$curr_pinput = $curr_h_sym . $curr_h_val;
	}
	return $curr_pinput;
}
}
$moduleclass         =  trim($params->get( 'moduleclass_sfx', 'adxm' ));
$module_path = dirname(__FILE__).DS;
$intDir = $module_path . $moduleclass;
if (is_dir($intDir)) {
} else {
	mkdir($intDir, 0755);
}

$paramxml            =  $moduleclass . '/slideShowV2Settings.xml';
$dockHeight          = trim($params->get( 'dockHeight', '110' ));
$thumbWidth          = trim($params->get( 'thumbWidth', '50' ));
$thumbHeight         = trim($params->get( 'thumbHeight', '50' ));
$thumbdistance       = trim($params->get( 'thumbdistance', '12' ));
$thumbborder         = trim($params->get( 'thumbborder', '1' ));
$thumbborcolor       = GetHColor($params, 'thumbborcolor', 'FFFFFF');
$dockscalefactor     = trim($params->get( 'dockscalefactor', '1.4' ));
$borderbigimage      = trim($params->get( 'borderbigimage', '4' ));
$bgcolor             = GetHColor($params, 'bgcolor', '2C2C2C');
$dockbgcolor         = GetHColor($params, 'dockbgcolor', '111111');
$borderbigimagecolor = GetHColor($params, 'borderbigimagecolor', 'FFFFFF');
$arrowcolor          = GetHColor($params, 'arrowcolor', 'FFFFFF');
if ($params->get('show_arrow', 'yes') == 'yes') {
				$showarrow .= 'true';
		}else{
				$showarrow .= 'false';
}
if ($params->get('show_fullscr', 'yes') == 'yes') {
				$showfull .= 'true';
		}else{
				$showfull .= 'false';
}
if ($params->get('show_desc', 'yes') == 'yes') {
				$showdescr .= 'true';
		}else{
				$showdescr .= 'false';
}

$autoplay            = trim($params->get( 'autoplay', '6' ));
if ($params->get('loop', 'yes') == 'yes') {
				$loop .= 'true';
		}else{
				$loop .= 'false';
}

$catppv_id = '';
$xml_param_data .= '<?xml version="1.0" encoding="utf-8"?>
<playersettings>
	<record>	
		<!-- gallery dimensions -->
		<galleryWidth>100%</galleryWidth>
		<galleryHeight>100%</galleryHeight>
		
		<!-- dock dimenisions -->
		<dockHeight>' . trim($dockHeight) .'</dockHeight>
		
		<!-- path to other configuration files -->
		<cssStylesPath>slideShowStyles.css</cssStylesPath>
		<imagesPath>playlist.xml</imagesPath>

		<!-- background color -->
		<bgColor>' . trim($bgcolor) .'</bgColor>
		<bgTransparency>100</bgTransparency>
		<dockBgColor>' . trim($dockbgcolor) .'</dockBgColor>
		<dockBgTransparency>100</dockBgTransparency>
		<controllersBgColor>0x000000</controllersBgColor>
		<controllersBgTransparency>100</controllersBgTransparency>		

		<!-- thumb settings -->
		<thumbWidth>' . trim($thumbWidth) .'</thumbWidth>
		<thumbHeight>' . trim($thumbHeight) .'</thumbHeight>
		<thumbDistance>' . trim($thumbdistance) .'</thumbDistance>
		<borderThumb>' . trim($thumbborder) .'</borderThumb>
		<borderThumbColor>' . trim($thumbborcolor) .'</borderThumbColor>
		<borderThumbColorTransparency>100</borderThumbColorTransparency>
		<borderThumbColorOver>0x849ef3</borderThumbColorOver>
		<borderThumbColorOverTransparency>100</borderThumbColorOverTransparency>

		<dockScaleFactor>' . trim($dockscalefactor) .'</dockScaleFactor>
		<randomize>false</randomize>
		<dropShadowOnZoom>true</dropShadowOnZoom>


		
		
		<!-- BORDER BIG IMAGE -->
		<borderBigImage>' . trim($borderbigimage) .'</borderBigImage>
		<borderBigImageColor>' . trim($borderbigimagecolor) .'</borderBigImageColor>
		<borderBigImageAlpha>100</borderBigImageAlpha>			
		
		
		<!-- navigation arrows settings -->
		<showArrows>' . trim($showarrow) .'</showArrows>
		<navigationArrowsColor>' . trim($arrowcolor) .'</navigationArrowsColor>
		<navigationArrowsTransparency>50</navigationArrowsTransparency>		
		
		<!-- under text descrition -->
		<showDescription>' . trim($showdescr) .'</showDescription>
		<underTextColor>0x000000</underTextColor>
		<underTextTransparency>50</underTextTransparency>
		
		<!-- big image transition duration -->
		<transitionDuration>1.5</transitionDuration>
		
		
		<showFullScreenBut>' . trim($showfull) .'</showFullScreenBut>
		<autoPlay>' . trim($autoplay) .'</autoPlay>
		<loop>' . trim($loop) .'</loop>		
		<target>_blank</target>
	</record>	
</playersettings>
';

$module_path = dirname(__FILE__).DS;
$catppv_id .= md5($xml_param_data);
$xml_data_filename = $module_path.$catppv_id.'.xml';

if (!file_exists($xml_data_filename)) {
	$xml_prodgallery_file = fopen($xml_data_filename,'w');
	fwrite($xml_prodgallery_file, $xml_param_data);

	///////// set chmod 0777 for creating .xml file  if server is not windows
	$os_string = php_uname('s');
	$cnt = substr_count($os_string, 'Windows');
	if($cnt ==0){
		@chmod($xml_data_filename, 0777);
	}

	fclose($xml_prodgallery_file);
	
}
copy($module_path . $catppv_id . '.xml', $module_path . $paramxml);
unlink($xml_data_filename);




$bannerWidth           = trim($params->get( 'bannerWidth', '100%' ));
$bannerHeight          = intval($params->get( 'bannerHeight', 500 ));

$contentxml   = 'playlist.xml';


$catppv_id = '';

$module_path = dirname(__FILE__).DS;

$imgdir          = trim($params->get('imgdir', '' )); 
$thudir          = trim($params->get('thudir', '' )); 

$imgsrc          = trim($params->get('imgsrc', '' )); 
$imgsrc_arr      = explode("|",$imgsrc);


$imgdesc         = trim($params->get('imgdsc', '' )); 
$imgdsc_arr      = explode("|",$imgdesc);


$xml_data_data .= '
<?xml version="1.0" encoding="utf-8" ?>
<gallerylist>

';


////////// start : noimage code //////////////

$exist_url = JURI::root();
$server_path = getCurUrl($exist_url);
//////////////////////////////////////////



foreach ($imgsrc_arr as $ik=>$curr_isrc) {
	$xml_data_data .= '<record> ';

if (false === strpos($curr_isrc, '://')) {
		$xml_data_data .= ' <img>' . trim($server_path.$thudir) . '/' . trim($curr_isrc) . '</img>';
		$xml_data_data .= ' <bigpicture>' . trim($server_path.$imgdir) . '/' . trim($curr_isrc) . '</bigpicture> ';
		if ($params->get('show_desc', 'yes') == 'yes') {
				$xml_data_data .= '<desc><![CDATA[<span class="reg">'.trim($imgdsc_arr[$ik]).'</span>]]></desc>';
		}else{
				$xml_data_data .= '<desc><![CDATA[]]></desc>';
		}
}else{
		$xml_data_data .= ' <img>' . trim($thudir) . '/' . trim($curr_isrc) . '</img>';
		$xml_data_data .= ' <bigpicture>' . trim($imgdir) . '/' . trim($curr_isrc) . '</bigpicture> ';
		if ($params->get('show_desc', 'yes') == 'yes') {
				$xml_data_data .= '<desc><![CDATA[<span class="reg">'.trim($imgdsc_arr[$ik]).'</span>]]></desc>';
		}else{
				$xml_data_data .= '<desc><![CDATA[]]></desc>';
		}

}


$xml_data_data .= '
           </record>';

/////////////////// END ////////////////////////////
}

$xml_data_data .= '
	
</gallerylist>
';


$catppv_id .= md5($xml_data_data);


$xml_data_filename = $module_path.$catppv_id.'.xml';



if (!file_exists($xml_data_filename)) {
	$xml_prodgallery_file = fopen($xml_data_filename,'w');
	fwrite($xml_prodgallery_file, $xml_data_data);

	///////// set chmod 0777 for creating .xml file  if server is not windows
	$os_string = php_uname('s');
	$cnt = substr_count($os_string, 'Windows');
	if($cnt ==0){
		@chmod($xml_data_filename, 0777);
	}

	fclose($xml_prodgallery_file);
	
}
copy($module_path . $catppv_id . '.xml', $module_path . $moduleclass . '/' .$contentxml);
unlink($xml_data_filename);


$exist_url = JURI::root();
$server_path = getCurUrl($exist_url);

/////////////////// HTML begin ////////////////////////////
$filehtml   =  $moduleclass . '/adxmlgalleryok.html';
$htm_data_data .= '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>slideShow_v2</title>
<script language="javascript">AC_FL_RunContent = 0;</script>
<script src="AC_RunActiveContent.js" language="javascript"></script>
</head>
<body bgcolor="#' . substr($bgcolor, 2, 6) .'" marginheight="0" marginwidth="0" leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">
	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle">
<!--urls used in the movie-->
<!--text used in the movie-->
<!-- saved from url=(0013)about:internet -->
<script language="javascript">
	if (AC_FL_RunContent == 0) {
		alert("This page requires AC_RunActiveContent.js.");
	} else {
		AC_FL_RunContent(
';
$htm_data_data .= "		
			'codebase', '../../../download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
			'width', '100%',
			'height', '100%',
			'src', 'slideShow_v2',
			'quality', 'high',
			'pluginspage', '../../../www.macromedia.com/go/getflashplayer',
			'align', 'middle',
			'play', 'true',
			'loop', 'true',
			'scale', 'showall',
			'wmode', 'transparent',
			'devicefont', 'false',
			'id', 'slideShow_v2',
";
$htm_data_data .= "
            'bgcolor', '#" .substr($bgcolor, 2, 6) . "',"; 			
$htm_data_data .= "			
			'name', 'slideShow_v2',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','sameDomain',
			'movie', 'slideShow_v2',
			'salign', ''
			); //end AC code
	}
</script>
";
$htm_data_data .= '	
<noscript>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="../../../download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="100%" height="100%" id="slideShow_v2" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
	<param name="movie" value="slideShow_v2.swf" />
	<param name="quality" value="high" />
	<embed src="slideShow_v2.swf" quality="high" width="100%" height="100%" name="slideShow_v2" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
</noscript>
    </td>
  </tr>
</table>
</body>
</html>
';

$module_path = dirname(__FILE__).DS;
$catppv_id .= md5($htm_data_data);
$htm_data_filename = $module_path.$catppv_id.'.html';

if (!file_exists($htm_data_filename)) {
	$htm_prodgallery_file = fopen($htm_data_filename,'w');
	fwrite($htm_prodgallery_file, $htm_data_data);

	///////// set chmod 0777 for creating .xml file  if server is not windows
	$os_string = php_uname('s');
	$cnt = substr_count($os_string, 'Windows');
	if($cnt ==0){
		@chmod($htm_data_filename, 0777);
	}

	fclose($htm_prodgallery_file);
	
}
copy($module_path . $catppv_id . '.html', $module_path . $filehtml);
unlink($htm_data_filename);




$source_file = $module_path . 'AC_RunActiveContent.js';
$dest_file   = $module_path . $moduleclass . '/' . 'AC_RunActiveContent.js';
copy($source_file, $dest_file);

$source_file = $module_path . 'slideShow_v2.swf';
$dest_file   = $module_path . $moduleclass . '/' . 'slideShow_v2.swf';
copy($source_file, $dest_file);

$source_file = $module_path . 'slideShowStyles.css';
$dest_file   = $module_path . $moduleclass . '/' . 'slideShowStyles.css';
copy($source_file, $dest_file);

?>



<iframe id="adxmlgal"
	name=""
	src="<?php echo $server_path; ?>modules/mod_adxmlgallery/<?php echo $filehtml; ?>"
	width="<?php echo $bannerWidth; ?>"
	height="<?php echo $bannerHeight; ?>"
	scrolling="no"
	align="top"
	frameborder="0"
	class="wrappernuw">
	No Iframes</iframe>
<div style=clear:both;></div>
