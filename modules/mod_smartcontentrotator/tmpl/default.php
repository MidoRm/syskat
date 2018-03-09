<?php
/*------------------------------------------------------------------------
# mod_smartcontentrotator.php - Smart Latest News (module)
# ------------------------------------------------------------------------
# version		1.0.0
# author    	Implantes en tu ciudad
# copyright 	Copyright (c) 2011 Top Position All rights reserved.
# @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website		http://mastermarketingdigital.org/open-source-joomla-extensions

Based on http://tympanus.net/codrops/2010/10/03/compact-news-previewer/ (Codrops Tutorial)
-------------------------------------------------------------------------
*/

defined('_JEXEC') or die;

$document->addStyleSheet(JURI::base().'modules/mod_smartcontentrotator/assets/css/style.css');
if($params->get('responsive',1)) $document->addStyleSheet(JURI::base().'modules/mod_smartcontentrotator/assets/css/style-responsive.css');
$document->addScript(JURI::base().'modules/mod_smartcontentrotator/assets/js/cufon-yui.js');
$document->addScript(JURI::base().'modules/mod_smartcontentrotator/assets/jquery.easing.1.3.js');

?>

<div class="cn_wrapper">
	<div id="cn_preview" class="cn_preview">
            
	<?php 
	$sw = 0;
	foreach ($list as $item) : 
		$sufix = '';
		if($sw==0) $sufix = ' style="top:5px;" ';
		$sw++;
		if($params->get('show_intro',1)) {
			$introtext = $item->introtext;
			if($params->get('strip_intro',1)) 	$introtext = strip_tags($introtext);
			if($params->get('crop_intro',1)) 	$introtext = modsmartcontentrotatorHelper::firstXChars($introtext, $params->get('crop',200));
		}
		if($params->get('show_image1',1)) $images  = json_decode($item->images);
		
 ?>
        <div class="cn_content" <?php echo $sufix; ?>>
    		<div style="background-image:url(../../../<?php echo htmlspecialchars($images->image_intro); ?>); height: 275px; background-size:cover;">
        		<div class="transparente">
					<?php if($params->get('show_header',1)) echo '<div class="smartcontentrotator-category">'.$item->category_title.'</div>'; ?>
					<h1><?php echo $item->title; ?></h1>
					<?php if($params->get('show_date',1)) echo '<div class="smartcontentrotator-date">'.strftime($params->get('date_format','%d-%m-%Y'), strtotime($item->publish_up)).'</div>'; ?>
    				<?php if($params->get('show_intro',1)) echo '<div class="smartcontentrotator-introtext">'.$introtext.'</div>'; ?>
    				<?php if($params->get('show_readmore',1)) echo '<div class="smartcontentrotator-readmore"><a href="'.$item->link.'" class="smartcontentrotator-lreadmore btn btn-info">'.$params->get('readmore_text',"Read more").'</a></div>'; ?>
        		</div>
        	</div>
		</div>
	<?php endforeach; ?>
	</div>
                       
    <div id="cn_list" class="cn_list">
		<div class="cn_page" style="display:block;">
			<?php 
            $sw = 0;
            foreach ($list as $item) : 
           		$sufix = '';
            	if($sw==0) $sufix = ' selected ';
            	$sw++;
            	?>
            	<div class="cn_item  <?php echo $sufix; ?>">
                	<h2><?php echo $item->title; ?></h2>
					<?php if(($sw % 4)==0&&$sw<count($list)) { ?>
            	</div>
            </div>
            <div class="cn_page">
            		<?php } else { ?>
            	</div>
            		<?php } ?>
            <?php endforeach; ?>
       	</div>
        <div class="cn_nav">
            <a id="cn_prev" class="cn_prev disabled"></a>
            <a id="cn_next" class="cn_next"></a>
        </div>
    </div>
    
    <div style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; font-style:italic; text-align:right; display:block; padding-right:9px;position: relative;top: 292px;"><a href="http://mastermarketingdigital.org/" style="color:#CCCCCC">Marketing digital</a></div>
                
</div>