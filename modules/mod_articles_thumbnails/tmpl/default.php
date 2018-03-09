<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_thumbnails
 *
 * @copyright	Copyright © 2016 - All rights reserved.
 * @license		GNU General Public License v2.0
 * @author 		Sergio Iglesias (@sergiois)
 */
 
defined('_JEXEC') or die;
$span = 4;
switch($params->get('count'))
{
    case 1: $span = 12; break;
    case 2: $span = 6; break;
    case 3: $span = 4; break;
    case 4: $span = 3; break;
    default: $span = 4;
}
?>

<div class="row-fluid">
<ul class="thumbnails row-fluid <?php echo $moduleclass_sfx; ?>">
<?php foreach ($items as $item) : ?>
	<li class="span<?php echo $span; ?>" itemscope itemtype="https://schema.org/Article">
        <div class="thumbnail">
            <?php if($params->get('show_image') != 'off'): ?>
                <?php
                $images = json_decode($item->images);
                $image = $images->image_intro;
                $alt = $images->image_intro_alt ? $images->image_intro_alt : $item->title;
                if($params->get('show_image') == 'fulltext')
                {
                    $image = $images->image_fulltext;
                    $alt = $images->image_fulltext_alt ? $images->image_fulltext_alt : $item->title;
                }
                ?>
                <?php if($params->get('link_image')): ?>
                    <a href="<?php echo $item->link; ?>" itemprop="url" target="<?php echo $params->get('open_link', '_self'); ?>">
                        <img data-src="<?php echo $image; ?>" src="<?php echo $image; ?>" alt="<?php echo $alt; ?>">
                    </a>
                <?php else: ?>
                    <img data-src="<?php echo $image; ?>" src="<?php echo $image; ?>" alt="<?php echo $alt; ?>">
                <?php endif; ?>
            <?php endif; ?>
            
            
            <?php if($params->get('show_title')): ?>
                <h3 itemprop="name">
                    <?php if($params->get('link_title')): ?>
                        <a href="<?php echo $item->link; ?>" itemprop="url" target="<?php echo $params->get('open_link', '_self'); ?>">
                    <?php endif; ?>
                    <?php echo $item->title; ?>
                    <?php if($params->get('link_title')): ?>
                        </a>
                    <?php endif; ?>
                </h3>
            <?php endif; ?>

            <?php if($params->get('show_category')): ?>
                <small class="<?php echo $params->get('design_category'); ?>">
                    <?php echo $item->category_title; ?>
                </small>
            <?php endif; ?>

            <?php if($params->get('show_date')): ?>
                <small class="<?php echo $params->get('design_date'); ?>">
                <?php
                    $dateformat = 'DATE_FORMAT_LC';
                    switch((int)$params->get('date_format')){
                        case 0: $dateformat = 'DATE_FORMAT_LC'; break;
                        case 1: $dateformat = 'DATE_FORMAT_LC1'; break;
                        case 2: $dateformat = 'DATE_FORMAT_LC2'; break;
                        case 3: $dateformat = 'DATE_FORMAT_LC3'; break;
                        case 4: $dateformat = 'DATE_FORMAT_LC4'; break;
                        case 5: $dateformat = 'DATE_FORMAT_LC5'; break;
                        case 6: $dateformat = $params->get('date_custom_format'); break;
                        default: $dateformat = 'DATE_FORMAT_LC';
                    }
                    echo JHtml::_('date', $item->publish_up, JText::_($dateformat));
                ?>
                </small>
            <?php endif; ?>

            <?php if($params->get('show_content') != 'offc'): ?>
                <?php
                if($params->get('show_content') == 'partc'):
                    $cleanText = filter_var($item->introtext, FILTER_SANITIZE_STRING);
                    $introCleanText = strip_tags($cleanText);
                    if (strlen($introCleanText) > $params->get('tam_content', 200))
                    {
                        $introtext = substr($introCleanText,0,strrpos(substr($introCleanText,0,$params->get('tam_content', 200))," ")).'...';
                    }
                    else
                    {
                        $introtext = $introCleanText;
                    }
                    echo '<p>'.$introtext.'</p>';
                else:
                    echo $item->introtext;
                endif;
                ?>
            <?php endif; ?>
            
            <?php if($params->get('show_readmore')): ?>
            <p class="text-right">
                <a href="<?php echo $item->link; ?>" class="btn btn-primary" target="<?php echo $params->get('open_link', '_self', '_self'); ?>"><?php echo $params->get('readmore_text') ? $params->get('readmore_text') : JText::_('MOD_ARTICLES_THUMBNAILS_FIELD_READMORE_TEXT'); ?></a>
            </p>
            <?php endif; ?>
        </div>
	</li>
<?php endforeach; ?>
</ul>
</div>