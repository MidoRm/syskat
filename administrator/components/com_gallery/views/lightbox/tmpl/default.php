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

JHtml::_('behavior.tooltip');

JHtml::_('behavior.formvalidation');
?>

<script type="text/javascript">
    Joomla.submitbutton = function (task)
    {
       
        if (task == 'lightbox.save') {
            alert("Sorry, the Lightbox Settings are disabled in this free version, please purchase the commercial version for the full features.");
            Joomla.submitform('save', document.getElementById('adminForm'));
        }
        else if (task == 'lightbox.apply1')
        {    alert("Sorry, the Lightbox Settings are disabled in this free version, please purchase the commercial version for the full features.");
        } else if (task == 'lightbox.cancel') {
            Joomla.submitform('apply1', document.getElementById('adminForm'));
        }
    }
</script>
<div style="clear: both"></div>
<div id="j-sidebar-container" class="j-sidebar-container j-sidebar-visible" style="margin: 19px 0 0 -1px;">
    <div id="j-toggle-sidebar-wrapper">
        <div id="j-toggle-sidebar-header" class="j-toggle-sidebar-header" style="padding: 10px 0 0px 20px;">
	<div id="sidebar" class="sidebar">
            <div class="sidebar-nav">
                <ul id="submenu" class="nav nav-list">
                    <li>
                            <a href="index.php?option=com_gallery">Huge-IT Gallery</a>
                    </li>
                    <li>
                            <a href="index.php?option=com_gallery&amp;view=general">General Options</a>
                    </li>
                    <li  class="active">
                            <a href="index.php?option=com_gallery&amp;view=lightbox">Lightbox Options</a>
                    </li>
                    <li>
                            <a href="index.php?option=com_gallery&amp;view=featured">Featured Products</a>
                    </li>
                </ul>
            <div>
	</div>
	<div id="j-toggle-sidebar"></div>
            </div>
		</div>
        </div>
    </div>
</div>
<div id="j-main-container" class="span10 j-toggle-main">
    <div class="wrap">
<?php $path_site2 = JUri::root()."media/com_gallery/images"; ?>
        <style>
		.free_version_banner {
			position:relative;
			display:block;
			background-image:url(<?php echo $path_site2; ?>/wp_banner_bg.jpg);
			background-position:top left;
			backround-repeat:repeat;
			overflow:hidden;
		}
		
		.free_version_banner .manual_icon {
			position:absolute;
			display:block;
			top:15px;
			left:15px;
		}
		
		.free_version_banner .usermanual_text {
                        font-weight: bold !important;
			display:block;
			float:left;
			width:270px;
			margin-left:75px;
			font-family:'Open Sans',sans-serif;
			font-size:12px;
			font-weight:300;
			font-style:italic;
			color:#ffffff;
			line-height:10px;
                        margin-top: 0;
                        padding-top: 15px;
		}
		
		.free_version_banner .usermanual_text a,
		.free_version_banner .usermanual_text a:link,
		.free_version_banner .usermanual_text a:visited {
			display:inline-block;
			font-family:'Open Sans',sans-serif;
			font-size:17px;
			font-weight:600;
			font-style:italic;
			color:#ffffff;
			line-height:30.5px;
			text-decoration:underline;
		}
		
		.free_version_banner .usermanual_text a:hover,
		.free_version_banner .usermanual_text a:focus,
		.free_version_banner .usermanual_text a:active {
			text-decoration:underline;
		}
		
		.free_version_banner .get_full_version,
		.free_version_banner .get_full_version:link,
		.free_version_banner .get_full_version:visited {
                        padding-left: 60px;
                        padding-right: 4px;
			display: inline-block;
                        position: absolute;
                        top: 15px;
                        right: calc(50% - 167px);
                        height: 38px;
                        width: 285px;
                        border: 1px solid rgba(255,255,255,.6);
                        font-family: 'Open Sans',sans-serif;
                        font-size: 23px;
                        color: #ffffff;
                        line-height: 43px;
                        text-decoration: none;
                        border-radius: 2px;
		}
		
		.free_version_banner .get_full_version:hover {
			background:#ffffff;
			color:#bf1e2e;
			text-decoration:none;
			outline:none;
		}
		
		.free_version_banner .get_full_version:focus,
		.free_version_banner .get_full_version:active {
			
		}
		
		.free_version_banner .get_full_version:before {
			content:'';
			display:block;
			position:absolute;
			width:33px;
			height:23px;
			left:25px;
			top:9px;
			background-image:url(<?php echo $path_site2; ?>/wp_shop.png);
			background-position:0px 0px;
			background-repeat:repeat;
		}
		
		.free_version_banner .get_full_version:hover:before {
			background-position:0px -27px;
		}
		
		.free_version_banner .huge_it_logo {
			float:right;
			margin:15px 15px;
		}
		
		.free_version_banner .description_text {
                        padding:0 0 13px 0;
			position:relative;
			display:block;
			width:100%;
			text-align:center;
			float:left;
			font-family:'Open Sans',sans-serif;
			color:#fffefe;
			line-height:inherit;
		}
                .free_version_banner .description_text p{
                        margin:0;
                        padding:0;
                        font-size: 14px;
                }
		</style>
	<div class="free_version_banner">
		<img class="manual_icon" src="<?php echo $path_site2; ?>/icon-user-manual.png" alt="user manual" />
		<p class="usermanual_text">If you have any difficulties in using the options, Follow the link to <a href="http://huge-it.com/joomla-gallery-user-manual/" target="_blank">User Manual</a></p>
		<a class="get_full_version" href="http://huge-it.com/joomla-gallery/" target="_blank">GET THE FULL VERSION</a>
                <a href="http://huge-it.com" target="_blank"><img class="huge_it_logo" src="<?php echo $path_site2; ?>/Huge-It-logo.png"/></a>
                <div style="clear: both;"></div>
		<div  class="description_text"><p>This is the free version of the plugin. In order to use options from this section, get the full version. We appreciate every customer.</p></div>
	</div>
        <div style="clear:both;"></div>
        <div style="color: #a00; margin-bottom: 15px;">This options are for commercial users, it includes one of Personal, Multi-Site or Developer versions.Please upgrade to use this section.
        </div>
	</div>
<form action="<?php echo JRoute::_('index.php?option=com_gallery&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
    <div class="tab-content">
        <div class="span10" style="width: 100%">
        <div class="back"><fieldset class="form-horizontal">
                <legend class="legend"><?php echo JText::_('Internationalization'); ?></legend>
                        <?php foreach ($this->form->getFieldset('Internationalization') as $field) : ?>
				 <div class="control-group">
                              <?php echo "<div class='control-label'>".$field->label."</div>";
                                    echo "<div class='controls'>".$field->input."</div>";
                                ?>
                                  </div>
			<?php endforeach; ?>
		
            </fieldset></div>
             <div class="back"><fieldset class="form-horizontal">
		<legend class="legend"><?php echo JText::_('Positioning'); ?></legend>
		
			<?php foreach ($this->form->getFieldset('Positioning') as $field) : ?>
				 <div class="control-group">
                              <?php echo "<div class='control-label'>".$field->label."</div>";
                                    echo "<div class='controls'>".$field->input."</div>";
                                ?>
                                </div>
			<?php endforeach; ?>
		
                 </fieldset></div>
       
            <div class="back"><fieldset class="form-horizontal">
		<legend class="legend"><?php echo JText::_('Dimensions'); ?></legend>
		
			<?php foreach ($this->form->getFieldset('Dimensions') as $field) : ?>
				 <div class="control-group">
                              <?php echo "<div class='control-label'>".$field->label."</div>";
                                    echo "<div class='controls'>".$field->input."</div>";
                                ?>
                    </div>
			<?php endforeach; ?>
		
                </fieldset></div>
              <div class="back"><fieldset class="form-horizontal">
		<legend class="legend"><?php echo JText::_('Slideshow'); ?></legend>
		
			<?php foreach ($this->form->getFieldset('Slideshow') as $field) : ?>
				 <div class="control-group">
                              <?php echo "<div class='control-label'>".$field->label."</div>";
                                    echo "<div class='controls'>".$field->input."</div>";
                                ?>
                    </div>
			<?php endforeach; ?>
		
                  </fieldset></div>
        </div>
	<div>
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
    </div>
</form>
</div>