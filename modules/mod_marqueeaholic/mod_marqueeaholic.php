<?php
/*-------------------------------------------------------------------------------
# MarqueeAholic - Marquee module for Joomla 3.x v1.4.1
# -------------------------------------------------------------------------------
# author    GraphicAholic
# copyright Copyright (C) 2011 GraphicAholic.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.graphicaholic.com
--------------------------------------------------------------------------------*/
// No direct access
defined('_JEXEC') or die('Restricted access');
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
$moduleclass_sfx = $params->get('moduleclass_sfx');
JHtml::_('bootstrap.framework');
// Import the file / foldersystem
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
$LiveSite 	= JURI::base();
$document = JFactory::getDocument();
$modbase = JURI::base(true).'/modules/mod_marqueeaholic/';
$document->addScript ($modbase.'js/jquery.marquee.min.js');
$document->addScript ($modbase.'js/jquery.pause.js');
$document->addScript ($modbase.'js/jquery.easing.min.js');
$document->addStyleSheet($modbase.'css/marquee.css');
$marqueeDuplication	= $params->get('marqueeDuplication');
if($marqueeDuplication == "0") $marqueeDuplication = "false";
if($marqueeDuplication == "1") $marqueeDuplication = "true";
$marqueePause	= $params->get('marqueePause');
if($marqueePause == "0") $marqueePause = "false";
if($marqueePause == "1") $marqueePause = "true";
$marqueeURL	= $params->get('marqueeURL');
$outsideSource	= $params->get('outsideSource');
$externalURL	= $params->get('externalURL');
$wordCount	= $params->get('wordCount');
$feedCount	= $params->get('feedCount');
$linkWindow	= $params->get('linkWindow');
$rssDisplay	= $params->get('rssDisplay');
$moduleID = $module->id;
?>

<script type="text/javascript">
			jQuery(function(){
				var $mwo = jQuery('.marquee-with-options-<?php echo $moduleID; ?>');
				jQuery('.marquee').marquee ();
				jQuery('.marquee-with-options-<?php echo $moduleID; ?>').marquee ({
					speed: <?php echo $params->get('marqueeSpeed') ?>, //speed in milliseconds of the marquee
					gap: <?php echo $params->get('marqueeGap') ?>, //gap in pixels between the tickers
					delayBeforeStart: <?php echo $params->get('marqueeDelay') ?>, //gap in pixels between the tickers
					direction: '<?php echo $params->get('marqueeDirection') ?>', //'left' or 'right'
					duplicated: <?php echo $marqueeDuplication ?>, //true or false - should the marquee be duplicated to show an effect of continues flow
					pauseOnHover: <?php echo $marqueePause ?>, //on hover pause the marquee
					pauseOnCycle: false //on cycle pause the marquee
				});
			});
</script>

<style type="text/css">
.marquee-with-options-<?php echo $moduleID; ?> {overflow: hidden !important; color: #<?php echo $params->get('marqueeFontColor') ?>; font-family:<?php echo $params->get('marqueeFontFamily') ?>; font-size: <?php echo $params->get('marqueeFontSize') ?>; line-height: <?php echo $params->get('marqueeHeight') ?>; width: <?php echo $params->get('marqueeWidth') ?>; background: #<?php echo $params->get('marqueeBackground') ?> !important; border: <?php echo $params->get('marqueeBorder') ?> <?php echo $params->get('marqueeBorderStyle') ?> #<?php echo $params->get('marqueeBorderColor') ?>; margin-bottom: <?php echo $params->get('marqueeBottomMargin') ?>; text-decoration: none;}
</style>

<?php if ($outsideSource == "0"): ?>	
	<?php if ($marqueeURL == "1"): ?>	
		<div class='marquee-with-options-<?php echo $moduleID; ?>'><a href="<?php echo $params->get('hyperLink') ?>" target="_<?php echo $params->get('linkWindow') ?>"> <?php echo $params->get('marqueeText') ?></a></div>
<?php endif ; ?>
<?php if ($marqueeURL == "0"): ?>	
	<div class='marquee-with-options-<?php echo $moduleID; ?>'><?php echo $params->get('marqueeText') ?></div>	
	<?php endif ; ?>
<?php endif ; ?>	
<?php if ($outsideSource == "1"): ?>	
	<div class='marquee-with-options-<?php echo $moduleID; ?> <?php echo $moduleclass_sfx;?>'><?php echo file_get_contents("$externalURL", NULL, NULL, NULL, $wordCount); ?></div>	
<?php endif ; ?>
<?php if ($outsideSource == "2"): ?>
	<div class="marquee-with-options-<?php echo $moduleID; ?> <?php echo $moduleclass_sfx;?>">
		<?php {
			$rss = new DOMDocument();
			$rss->load(''.$externalURL.'');
			$feed = array();
		foreach ($rss->getElementsByTagName('item') as $node)
		{
			$item = array (
				'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
				'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
				'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
				'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
			);
	array_push($feed, $item);
		}
	$descCount = $wordCount;
	$limit = $feedCount;
	for($x=0;$x<$limit;$x++)
		{
			$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
			$link = $feed[$x]['link'];
			$description = substr($feed[$x]['desc'], 0, $descCount );
			$date = date('l F d, Y', strtotime($feed[$x]['date']));
if ($rssDisplay == "3") {
	echo '<strong>&#187;<a href="'.$link.'" target="_'.$linkWindow.'" title="'.$title.'">'.$title.'</a></strong>&nbsp;<span style="font-size: x-small;opacity: 0.5;">[<em>Posted on '.$date.'</em>]</span>&nbsp;'.$description.'&nbsp;&nbsp;';
		}
elseif ($rssDisplay == "2") {
	echo '<strong>&#187;<a href="'.$link.'" target="_'.$linkWindow.'" title="'.$title.'">'.$title.'</a></strong>&nbsp;|&nbsp;'.$description.'&nbsp;&nbsp;';
		}
elseif ($rssDisplay == "1") {
	echo '<strong>&#187;<a href="'.$link.'" target="_'.$linkWindow.'" title="'.$title.'">'.$title.'</a></strong>&nbsp;<span style="font-size: x-small;opacity: 0.5;">[<em>Posted on '.$date.'</em>]</span>&nbsp;&nbsp;';
		}
elseif ($rssDisplay == "0") {
	echo '<strong>&#187;<a href="'.$link.'" target="_'.$linkWindow.'" title="'.$title.'">'.$title.'</a></strong>&nbsp;&nbsp;';
		}
	}
}
?>
</div>
<?php endif ; ?>	