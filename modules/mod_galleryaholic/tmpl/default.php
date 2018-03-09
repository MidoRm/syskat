<?php
/*-------------------------------------------------------------------------------
# mod_galleryaholic - GalleryAholic for Joomla 3.x v1.6.4-PRO
# -------------------------------------------------------------------------------
# author    GraphicAholic
# copyright Copyright (C) 2011-2016 GraphicAholic.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.graphicaholic.com
--------------------------------------------------------------------------------*/
// No direct access
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
$path			= $params->get('path');
$showTitle	= $params->get('showTitle', 1);
$gridLayout	= $params->get('gridLayout');
if($gridLayout == "1") $gridLayout = "grid";
if($gridLayout == "2") $gridLayout = "gridempty";
$flickrAPI	= $params->get('flickrAPI');
$flickrSecret	= $params->get('flickrSecret', '');
$flickrToken	= $params->get('flickrToken', '');
$flickrPrivate	= $params->get('flickrPrivate', 0);
$flickrSet	= $params->get('flickrSet');
$flickrNumber	= $params->get('flickrNumber', '');
$flickrThumb	= $params->get('flickrThumb');
if($flickrThumb == "1") $flickrThumb = "small";
if($flickrThumb == "2") $flickrThumb = "medium";
if($flickrThumb == "3") $flickrThumb = "large";
$flickrTitle	= $params->get('flickrTitle', 1);
$flickrDesc	= $params->get('flickrDesc', 1);
$flickrCache	= $params->get('flickrCache', 1);
$picasaUser	= $params->get('picasaUser', "");
$user_albumid	= $params->get('user_albumid');
$photoSize	= $params->get('photoSize');
$picasaPhoto	= $params->get('picasaPhoto');
$picasaTitle	= $params->get('picasaTitle', 1);
$picasaDesc	= $params->get('picasaDesc', 1);
$accessToken	= $params->get('accessToken', '');
$postCount	= $params->get('postCount', '');
$dateSuffix	= $params->get('dateSuffix', '');
$resoultion	= $params->get('resoultion', '');
$instagramLightbox	= $params->get('instagramLightbox', '');
$instagramDesc	= $params->get('instagramDesc', '');
$instagramMeta	= $params->get('instagramMeta', '');
$instagramDate	= $params->get('instagramDate', '');
$instagramiconColor	= $params->get('instagramiconColor', '');
$folderCache	= $params->get('folderCache', 0);
$downloadImage	= $params->get('downloadImage');
if($downloadImage == "0") $downloadImage = "caption";
if($downloadImage == "1") $downloadImage = "title";
$imgGrayscale	= $params->get('imgGrayscale');
if($imgGrayscale == "0") $imgGrayscale = "nograyscale";
if($imgGrayscale == "1") $imgGrayscale = "grayscale";
$lightbox		= $params->get('lightbox');
if($lightbox == "0") $lightbox = "";
if($lightbox == "1") $lightbox = "a ";
if($lightbox == "a ") $dataMine = "data-";
$fancyboxTitle = $params->get('fancyboxTitle', '');
$fancyboxDescription	= $params->get('fancyboxDescription', '');
if($fancyboxDescription == "0") $fancyboxDescription = "null";
if($fancyboxDescription == "1") $fancyboxDescription = "description";
$item_desc_display	= $params->get('item_desc_display');
$descColor	= $params->get('descColor');
$metaTag	= $params->get('metaTag');
$effectOption	= $params->get('effectOption');
$dataDuration	= $params->get('dataDuration');
$dataDelay	= $params->get('dataDelay');
$dataOffset	= $params->get('dataOffset');
$customCSS = $params->get('customCSS', '');
$index=0;
?>
<div class="ga-folder">	
<script type="text/javascript">
jQuery(document).ready(function() {
	//blocksit define
	jQuery(window).load( function() {
		jQuery('#gacontainer<?php echo $moduleID ?>').BlocksIt({
			numOfCol: <?php echo $params->get('numberCol') ?>,
			offsetX: <?php echo $params->get('LRoffset') ?>,
			offsetY: <?php echo $params->get('TBoffset') ?>,
			blockElement: '.<?php echo $gridLayout ?>'
		});
	});
	//window resize
	var currentWidth = 1100;
	jQuery(window).resize(function() {
		var winWidth = jQuery(window).width();
		var conWidth;
		if(winWidth < <?php echo $params->get('breakpointSmall') ?>) {
			conWidth = <?php echo $params->get('breakpointSmall')-20 ?>;
			col = <?php echo $params->get('smallCol') ?>;
		} 
		else if(winWidth < <?php echo $params->get('breakpointMed') ?>) {
			conWidth = <?php echo $params->get('breakpointMed')-20 ?>;
			col = <?php echo $params->get('medCol') ?>;
		} else if(winWidth < <?php echo $params->get('breakpointLarge') ?>) {
			conWidth = <?php echo $params->get('breakpointLarge')-20 ?>;
			col = <?php echo $params->get('largeCol') ?>;
		} else {
			conWidth = 1100;
			col = <?php echo $params->get('numberCol') ?>;
		}
		if(conWidth != currentWidth) {
			currentWidth = conWidth;
			jQuery('#gacontainer<?php echo $moduleID ?>').width(conWidth);
			jQuery('#gacontainer<?php echo $moduleID ?>').BlocksIt({
			numOfCol: col,
			offsetX: <?php echo $params->get('LRoffset') ?>,
			offsetY: <?php echo $params->get('TBoffset') ?>
			});
		}
	});
	//window load for small screen devices
	var currentWidth = 1100;
	jQuery(window).load(function() {
		var winWidth = jQuery(window).width();
		var conWidth;
		if(winWidth < <?php echo $params->get('breakpointSmall') ?>) {
			conWidth = <?php echo $params->get('breakpointSmall')-20 ?>;
			col = <?php echo $params->get('smallCol') ?>;
		} else if(winWidth < <?php echo $params->get('breakpointMed') ?>) {
			conWidth = <?php echo $params->get('breakpointMed')-20 ?>;
			col = <?php echo $params->get('medCol') ?>;
		} else if(winWidth < <?php echo $params->get('breakpointLarge') ?>) {
			conWidth = <?php echo $params->get('breakpointLarge')-20 ?>;
			col = <?php echo $params->get('largeCol') ?>;
		} else {
			conWidth = 1100;
			col = <?php echo $params->get('numberCol') ?>;
		}
		if(conWidth != currentWidth) {
			currentWidth = conWidth;
			jQuery('#gacontainer<?php echo $moduleID ?>').width(conWidth);
			jQuery('#gacontainer<?php echo $moduleID ?>').BlocksIt({
			numOfCol: col,
			offsetX: <?php echo $params->get('LRoffset') ?>,
			offsetY: <?php echo $params->get('TBoffset') ?>
			});
		}
	});
});
</script>
<!-- Fancybox -->
<style type="text/css">
.fancybox-container--ready .fancybox-bg {background-color: <?php echo $params->get('lightboxOverlay') ?> !important; opacity:inherit;}
.fancybox-show-infobar .fancybox-infobar {display: <?php echo $params->get('lightboxCounter') ?>;}	
.fancybox-caption-wrap {background: <?php echo $params->get('fancyboxTextOverlay') ?>; padding: 0;}	
.fancybox-caption {padding: 10px 0; border-top: none !important; text-align:<?php echo $params->get('fancyboxTextPosition') ?>; font-size: <?php echo $params->get('descfontSize') ?>; color: <?php echo $params->get('descColor') ?>; font-weight: <?php echo $params->get('descWeight') ?>;}	
div.fancybox-caption::first-line {font-size: <?php echo $params->get('fontSize') ?>; color: <?php echo $params->get('titleColor') ?> !important; font-weight: <?php echo $params->get('titleWeight') ?> !important;}	
</style>
<!-- Content -->
<style type="text/css">
<?php if ($gridLayout == "grid") : ?>
#gacontainer<?php echo $moduleID ?>{position: relative; margin-top:<?php echo $params->get('topMargin') ?> !important; margin-bottom:<?php echo $params->get('bottomMargin') ?> !important;}
.grid .overlay {background-color: <?php echo $params->get('overlayEffect') ?> !important;}
.grid {background: <?php echo $params->get('grid_Color') ?> !important; padding: <?php echo $params->get('LRoffset') ?>px;}
.grid .desc<?php echo $moduleID ?> p {font-size: <?php echo $params->get('descfontSize') ?>; font-weight: <?php echo $params->get('descWeight') ?>; color:<?php echo $params->get('descColor') ?> !important; margin-bottom: 0px;}
.grid .strong<?php echo $moduleID ?>{margin:10px 0; padding:0 0 5px; font-size:<?php echo $params->get('fontSize') ?>; font-weight: <?php echo $params->get('titleWeight') ?> !important; color:<?php echo $params->get('titleColor') ?> !important;}	
.grid .strong<?php echo $moduleID ?> a {margin:10px 0; padding:0 0 5px; font-size:<?php echo $params->get('fontSize') ?>; font-weight: <?php echo $params->get('titleWeight') ?> !important; color:<?php echo $params->get('titleColor') ?> !important;}
<?php if ($imageFeed == "7") { ?>
.grid .meta<?php echo $moduleID ?> {font-size: <?php echo $params->get('iconfontSize') ?> !important; font-weight: <?php echo $params->get('metaWeight') ?>;}
<?php }else{ ?>
.grid .meta<?php echo $moduleID ?> {border-top:1px solid #ccc; text-align: <?php echo $params->get('metaPosition') ?>; font-size: <?php echo $params->get('metafontSize') ?>; font-weight: <?php echo $params->get('metaWeight') ?>; color:<?php echo $params->get('metaColor') ?> !important;}
<?php } ?>	
@media only screen and (max-width: 660px) {
#gacontainer<?php echo $moduleID ?>,.imgholder img<?php echo $moduleID ?> {
	position: relative !important;
	max-width: 100%;
}
	float: left;
	width: auto !important;
}
<?php endif ; ?>
<?php if ($gridLayout == "gridempty") : ?>
#gacontainer<?php echo $moduleID ?>{position: relative; margin-top:<?php echo $params->get('topMargin') ?> !important; margin-bottom:<?php echo $params->get('bottomMargin') ?> !important;}
.gridempty .overlay {background-color: <?php echo $params->get('overlayEffect') ?> !important;}
.gridempty {padding: <?php echo $params->get('LRoffset') ?>px; margin: <?php echo $params->get('TBoffset') ?>px;}
.gridempty .strong<?php echo $moduleID ?>{line-height: 22px; padding:0 0 5px; font-size:<?php echo $params->get('fontSize') ?>; font-weight: <?php echo $params->get('titleWeight') ?> !important; color:<?php echo $params->get('titleColor') ?> !important;}
.gridempty .strong<?php echo $moduleID ?> a {line-height: 22px; padding:0 0 5px; font-size:<?php echo $params->get('fontSize') ?>; font-weight: <?php echo $params->get('titleWeight') ?> !important; color:<?php echo $params->get('titleColor') ?> !important;}
.gridempty .desc<?php echo $moduleID ?> p {font-size: <?php echo $params->get('descfontSize') ?>; font-weight: <?php echo $params->get('descWeight') ?>; color:<?php echo $params->get('descColor') ?> !important;}	
<?php if ($imageFeed == "7") { ?>
.gridempty .meta<?php echo $moduleID ?> {font-size: <?php echo $params->get('iconfontSize') ?> !important; font-weight: <?php echo $params->get('metaWeight') ?>;}
<?php }else{ ?>
.gridempty .meta<?php echo $moduleID ?> {text-align: <?php echo $params->get('metaPosition') ?>; font-size: <?php echo $params->get('metafontSize') ?>; font-weight: <?php echo $params->get('metaWeight') ?>; color:<?php echo $params->get('metaColor') ?> !important;}
<?php } ?>
@media only screen and (max-width: 660px) {
#gacontainer<?php echo $moduleID ?>, .imgholder img<?php echo $moduleID ?> {
	position: relative !important;
	max-width: 100% !important;
}	
	width: auto !important;
}
<?php endif ; ?>
</style>
<!-- Custom CSS -->
<?php if ($customCSS == "1") : ?>
<style>
<?php echo $params->get('cssData') ?>
</style>
<?php endif ; ?>
	<!--Flickr Photos-->
	<?php if ($imageFeed == "2"): ?>
		<div style="position:relative" id="gacontainer<?php echo $moduleID ?>">
		<?php
 		require_once("flickr/phpFlickr.php");
		if($flickrPrivate =="1") {			
 			$f = new phpFlickr("$flickrAPI", "$flickrSecret");
 			$f->setToken("$flickrToken");				
			}
		if($flickrPrivate =="0") {
 			$f = new phpFlickr("$flickrAPI");
			}
 			$ph_sets = $f->photosets_getList();
		if($flickrCache =="1") {
			$cacheFolderPath = JPATH_SITE.DS.'cache'.DS.'GalleryAholic-'.$moduleTitle.'';
			if (file_exists($cacheFolderPath) && is_dir($cacheFolderPath))
			{
			// all OK
			}
			else
			{
			mkdir($cacheFolderPath);
			}
			$lifetime = 860 * 860; // 60 * 60=One hour
			$f->enableCache("fs", "$cacheFolderPath", "$lifetime");
			}
		?>
			<?php $photos = $f->photosets_getPhotos($flickrSet, NULL, NULL, $flickrNumber); ?>
			<?php foreach ($photos['photoset']['photo'] as $photo): $d = $f->photos_getInfo($photo['id']); ?>
		<div class="<?php echo $gridLayout ?>">
			<div class="imgholder">	
			<div class="block animate" data-animate="<?php echo $effectOption ?>" data-duration="<?php echo $dataDuration ?>" data-delay="<?php echo $dataDelay ?>" data-offset="<?php echo $dataOffset ?>" style="visibility: visible;">	
			<<?php echo $lightbox; ?>class="overlay fancybox" href="<?= $f->buildPhotoURL($photo, 'large') ?>"  <?php echo $dataMine; ?>fancybox="gallery" <?php echo $params->get('fancyboxTitle') ?>caption="<?= $photo['title'] ?>"><img class="<?php echo $imgGrayscale ?>" src="<?= $f->buildPhotoURL($photo, ''.$flickrThumb.'') ?>" /></a>
			</div>
		<?php if ($flickrTitle == "1") : ?>
		<div class="strong<?php echo $moduleID ?>"><?= $photo['title'] ?></div>
		<?php elseif ($flickrTitle == "0") : ?>
		<blank></blank>
		<?php endif ; ?>
		<?php if ($flickrDesc == "1") : ?>
		<div class="desc<?php echo $moduleID ?>"><p><?= $d['photo']['description']['_content'] ?></p></div>
			<?php elseif ($flickrDesc == "0") : ?>
		<blank></blank>
		<?php endif ; ?>		
		<div class="meta<?php echo $moduleID ?>"><?php echo $params->get('flickrTag') ?></div>
		</div>
		</div>
  		<?php endforeach; ?>
		</div>
	</div>
	<?php endif ; ?>
	<!--Google+ Photos-->
	<?php if ($imageFeed == "3"): ?>
	<div style="position:relative" id="gacontainer<?php echo $moduleID ?>">
        <?php
        require_once dirname(__FILE__) . '/picasa/phpPicasahelper.php';
        $gallery=new phpPicasahelper();
        $user_picasaweb="$picasaUser";
        $useralbumid="$user_albumid";
        if (isset($_GET['pic']) AND $_GET['pic']!="") {
            echo "<img src=\"" . $_GET['pic'] . "\" alt=\"\"/>";
        }
        else {
            $albums=$gallery->getPictures($user_picasaweb,$useralbumid, "".$photoSize."".$picasaPhoto."", "".$photoSize."".$picasaPhoto."");
            foreach ($albums AS $key=>$value) {
                if ($value['title'] != "") {
                echo "<div class='<?php echo $gridLayout ?>'>";
                echo "<div class='imgholder'>";	
				echo "<div class='block animate' data-animate='$effectOption' data-duration='$dataDuration' data-delay='$dataDelay' data-offset='$dataOffset' style='visibility: visible;'>";	
                echo "<".$lightbox."class='overlay fancybox' ".$fancyboxTitle."caption='" . $value['title'] . "' ".$dataMine."fancybox='gallery' href=\"" . $value['thumbnail'] . "\" alt=\"" . $value['title'] . "\"><img class=" . $imgGrayscale . " src=\"" . $value['thumbnail'] . "\" alt=\"" . $value['title'] . "\"></a>";
            echo "</div>";
        ?>
	<?php if ($picasaTitle == "1"): ?>
            <div class="strong<?php echo $moduleID ?>"><?php echo $value['title'] ?></div>
            <?php if ($value['caption'] != "") { ?>
            <?php if ($picasaDesc == "1") { ?>
            <div class="desc<?php echo $moduleID ?>"><p><?php echo $value['caption'] ?></p></div>
            <?php } ?>
            <?php } ?>
            <div class="meta<?php echo $moduleID ?>"><?php echo $params->get('picasaTag') ?></div>
            </div>
	<?php endif ; ?>
	<?php if ($picasaTitle == "0"): ?>
            <strong></strong>
            <?php if ($value['caption'] != "") { ?>
            <?php if ($picasaDesc == "1") { ?>
            <div class="desc<?php echo $moduleID ?>"><p><?php echo $value['caption'] ?></p></div>
            <?php } ?>
            <?php } ?>
            <div class="meta<?php echo $moduleID ?>"><?php echo $params->get('picasaTag') ?></div>
            </div>	
		</div>	
	<?php endif ; ?>
        <?php
                }
            }
        }
	echo "</div>"; ?>
	</div>
	<?php endif ; ?>
	<!--Joomla Category-->
	<?php if ($imageFeed == "5"): ?>

	<?php
		if(!empty($list)){
		$readmore_display		= (int)$params->get('item_readmore_display');
	?>	
			<div style="position:relative" id="gacontainer<?php echo $moduleID ?>">
			<?php  $j= 0; 
			foreach($list as $item){  $j++;  ?>
			<div class="<?php echo $gridLayout ?>" data-size="<?php echo $item->created_by_alias; ?><?php if($item->featured) { echo $params->get('catFeatured'); } ?>">
				<div class="imgholder">	
				<div class="block animate" data-animate="<?php echo $effectOption ?>" data-duration="<?php echo $dataDuration ?>" data-delay="<?php echo $dataDelay ?>" data-offset="<?php echo $dataOffset ?>" style="visibility: visible;">	
					<?php
					$imgattr = '';
					$imgsrc = $item->image_src;
					if($imgsrc) { ?>
					<<?php echo $lightbox ?>class="overlay fancybox" class="image" href="<?php echo $imgsrc ?>" <?php echo $dataMine ?>fancybox="gallery" <?php echo $params->get('fancyboxTitle') ?>caption="<?php echo $item->title ?><br /><?php echo $item->_description ?>"> <img class="<?php echo $imgGrayscale ?>" img class="span.rollover" src="<?php echo $imgsrc ?>" alt="<?php echo $item->title ?>" <?php echo $imgattr.' '.$item->image_attr ?> /></a>
					<?php if($item->n != '' || $item->h != '') { ?>	
					</div>
						<?php } ?>
					<?php } ?>
					<?php
					$show_infor = $item->sub_title != '' ||  $item->_description != '' || $item->tags != '' || $readmore_display;
					if($show_infor) {	?>
						<?php if($item->sub_title != '') {?>
                        <div class="strong<?php echo $moduleID ?>">
							<a href="<?php echo $item->link ?>" title="<?php echo $item->title; ?>" <?php echo $item->link_target; ?>>
								<strong<?php echo $moduleID ?>><?php echo $item->sub_title; ?></strong<?php echo $moduleID ?>>
							</a>
                        </div>
						<?php }
                        if ($item_desc_display == '1') {?>
						<div class="desc<?php echo $moduleID ?>">
							<?php echo $item->_description; ?>
						</div>
						<?php }
						if($item->tag_id != ''){?>
						<div class="gridjtags">
							<?php echo $item->tag_id; ?>
						</div>	
						<?php }
						if($readmore_display){?>
						<a href="<?php echo $item->link ?>" title="<?php echo $item->title; ?>"  <?php echo $item->link_target; ?>>
							<?php echo JText::_('Read more...'); ?>
						</a>
						<?php }
						?>
						<div class="meta<?php echo $moduleID ?>">
							<?php if ($metaTag == "1") : ?>
							<?php echo $params->get('jCategoryTag') ?>
							<?php endif ; ?>
							<?php if ($metaTag == "2") : ?>
							<?php echo $params->get('prefixTag') ?>&nbsp;<?php echo $item->author; ?>
							<?php endif ; ?>
						</div>	

					<?php } ?>
					</div>
				</div>
			</div>
			 <?php
			$clear = 'clr1';
			if ($j % 2 == 0) $clear .= ' clr2';
			if ($j % 3 == 0) $clear .= ' clr3';
			if ($j % 4 == 0) $clear .= ' clr4';
			if ($j % 5 == 0) $clear .= ' clr5';
			if ($j % 6 == 0) $clear .= ' clr6';
			?>
			<div class="<?php echo $clear; ?>"></div>
			<?php } ?>
		</div>
	<?php 
	}else{
	//	Do not display this message for guest.
	$user = JFactory::getUser();
	if(	$user->id ){
		echo JText::_('WARNING_LABEL');	
	}
	} ?>
	</div>
	<?php endif ; ?>	
	<!--Joomla Folder Plus-->
	<?php if ($imageFeed == "6"): ?>	
	<div style="position:relative" id="gacontainer<?php echo $moduleID ?>">	
	<?php 
	$imagesJSON = new stdClass();
	if ($params->get('data_source.images')){
		$imagesJSON = json_decode($params->get('data_source.images'));
	}
	$folder = $params->get('data_source.folder');
	$images = array();
	foreach ($imagesJSON as $img){
		$images[$img->position] = $img;
	}
	ksort($images);
	foreach ($images as $k=>$image){	
		if ($params->get('thumbnail_mode') != 'none'){
			$imageCache = modGAprofileHelper::renderImage($folder.'/'.$image->image, $params);
		}else{
			$imageCache = JUri::base(true).'/'.$folder.'/'.$image->image;
		}		
	?>		
            <div class="<?php echo $gridLayout ?>" data-size="<?php echo $image->link; ?>">
            <div class="imgholder">	
			<div class="block animate" data-animate="<?php echo $effectOption ?>" data-duration="<?php echo $dataDuration ?>" data-delay="<?php echo $dataDelay ?>" data-offset="<?php echo $dataOffset ?>" style="visibility: visible;">	
			<?php if($image->imagelink != "") { ?>
			<a class="overlay fancybox" href="<?php echo $image->imagelink ?>" target="_<?php echo $image->gatarget ?>"><img class="<?php echo $image->gagray ?>" img src="<?php echo $imageCache ?>" alt="<?php echo $image->alttag ?>" /></a>			
			</div>	
			<?php } else { ?>
			<<?php echo $lightbox; ?>class="overlay fancybox" href="<?php echo $imageCache ?>" <?php echo $dataMine ?>fancybox="gallery" <?php echo $params->get('fancyboxTitle') ?>caption="<?php echo $image->title ?><br /><?php echo $image->$fancyboxDescription ?>"><img class="<?php echo $image->gagray ?>" img src="<?php echo $imageCache ?>" alt="<?php echo $image->alttag ?>" /></a>			
			</div>		
			<?php } ?>	
			<?php if($image->title != ""):?>	
				<div class="strong<?php echo $moduleID ?>"><?php echo $image->title; ?></div>	
				<?php endif;?>	
			<?php if($image->description != ""):?>	
		        <div class="desc<?php echo $moduleID ?>"><p><?php echo htmlspecialchars_decode($image->description);?></p></div>
				<?php endif ?>	
			<?php if($image->tag != ""):?>
            <div class="meta<?php echo $moduleID ?>"><?php echo $image->tag ?></div>
			<?php endif ?>	
            </div>	
		</div>
	<?php } ?>	
	</div>	
</div>	
	<?php endif ; ?>		
	<!--Instagram Gallery-->
	<?php if ($imageFeed == "7"): ?>
	<script type="text/javascript">
	jQuery("[data-fancybox]").fancybox({
	iframe : {
		
	}
	
});
	</script>
	<style>
	.fancybox-slide--iframe .fancybox-content {
	width  : 600px !important;
	height : 'auto' !important;
	max-width  : 80% !important;
	max-height : 90% !important;
	margin: 0;
}
</style>
	
	<div style="position:relative" id="gacontainer<?php echo $moduleID ?>">
	<?php	
	$access_token="$accessToken";
	$photo_count=$postCount;     
	$json_link="https://api.instagram.com/v1/users/self/media/recent/?";
	$json_link.="access_token={$access_token}&count={$photo_count}";
	?>
	<?php
		$json = file_get_contents($json_link);
		$obj = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);
		foreach ($obj['data'] as $post) {     
		$pic_text=$post['caption']['text'];
		$pic_link=$post['link'];
		$pic_like_count=$post['likes']['count'];
		$pic_comment_count=$post['comments']['count'];
	if ($resoultion == "0") {
		$pic_src=str_replace("http://", "https://", $post['images']['thumbnail']['url']);
	}
	if ($resoultion == "1") {
		$pic_src=str_replace("http://", "https://", $post['images']['standard_resolution']['url']);
	}
		$pic_created_time=date("F j, Y", $post['caption']['created_time']);
		$pic_created_time=date("F j, Y", strtotime($pic_created_time . " +1 days"));        
	echo "<div class='$gridLayout'>";
	echo "<div class='imgholder'>";  
	echo "<div class='block animate' data-animate='$effectOption' data-duration='$dataDuration' data-delay='$dataDelay' data-offset='$dataOffset' style='visibility: visible;'>";	
	if ($instagramLightbox == "0") {
        	echo "<a class='overlay fancybox' href='{$pic_link}' target='_blank'>";
    }
    if ($instagramLightbox == "1") {
        	echo "<a class='overlay fancybox' data-fancybox='images' data-type='iframe' href='{$pic_link}embed'>";
        	//echo "<a class='overlay fancybox' data-fancybox href='{$pic_link}embed'>";
    }
            echo "<img class='img-responsive photo-thumb $imgGrayscale' src='{$pic_src}' alt='{$pic_text}'>";
        echo "</a>";
	echo "</div>";			
	if ($instagramMeta == "1") {
	echo "<div class='meta$moduleID'>";
		echo "<i class='fa fa-gaheart' style='color:$instagramiconColor;'></i>&nbsp;&nbsp;{$pic_like_count}<span style='padding-left:40px;'></span><i class='fa fa-gacomment' style='color:$instagramiconColor;'>&nbsp;&nbsp;</i>{$pic_comment_count}";
	echo "</div>";
	}	
    if ($instagramDesc == "1") {
	echo "<div class='desc$moduleID'>";
            echo "<p>{$pic_text}</p>";
	echo "</div>";
	}
	if ($instagramDate == "1") {
	echo "<div style='color:$descColor'>";
		echo "$dateSuffix&nbsp;{$pic_created_time}";
	echo "</div>";
	}
	echo "</div>";
echo "</div>";	
	}	
	?>	
		</div>	
	</div>	
	<?php endif ; ?>
	<?php if ($specialFX == "1"): ?>
<script type="text/javascript">
		jQuery('.animate').scrolla({
		  mobile: false,
			once: <?php echo $params->get('repeatFX') ?>
		});
		</script>
	<?php endif ; ?>
<?php if ($lightbox == "a "): ?>
<script type="text/javascript">	
		jQuery( '[data-fancybox]' ).fancybox({
			buttons : <?php echo $params->get('lightboxButtons') ?>,
			slideShow : <?php echo $params->get('lightboxButtonsSlideshow') ?>,
			fullScreen : <?php echo $params->get('lightboxButtonsFullScreen') ?>,
			thumbs : <?php echo $params->get('lightboxButtonsThumbs') ?>,
			closeBtn : <?php echo $params->get('lightboxButtonsClose') ?>,
			touch : <?php echo $params->get('lightboxTouch') ?>,
			keyboard : <?php echo $params->get('lightboxKeyboard') ?>,
			speed : <?php echo $params->get('lightboxButtonsSpeed') ?>,
			loop : <?php echo $params->get('lightboxButtonsLoop') ?>,	
	});
</script>
<?php endif ; ?>