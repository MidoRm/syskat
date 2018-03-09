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
JHtml::stylesheet(Juri::root() . 'media/com_gallery/style/admin.style.css');
$doc = JFactory::getDocument();
$doc->addScript("http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js");
$doc->addScript("http://code.jquery.com/ui/1.10.4/jquery-ui.js");
JHtml::script(Juri::root() . "/media/com_gallery/js/admin.js");
JHtml::script(Juri::root() . "/media/com_gallery/js/simple-slider.js");
$doc->addScript(JURI::root(true) . "/media/com_gallery/elements/jscolor/jscolor.js");
JHtml::stylesheet('media/com_gallery/style/simple-gallery.css');
?>
<style>
    html.wp-toolbar {
        padding:0px !important;
    }
    #wpadminbar,#adminmenuback,#screen-meta, .update-nag,#dolly {
        display:none;
    }
    #wpbody-content {
        padding-bottom:30px;
    }
    #adminmenuwrap {display:none !important;}
    .auto-fold #wpcontent, .auto-fold #wpfooter {
        margin-left: 0px;
    }
    #wpfooter {display:none;}
    iframe {height:250px !important;}
    #TB_window {height:250px !important;}
</style>
<script type="text/javascript">
    jQuery(document).ready(function() {

        jQuery('.huge-it-insert-post-button').on('click', function() {
            var ID1 = jQuery('#huge_it_add_video_input').val();
            if (ID1 == "") {
                alert("Please copy and past url form YouTube or Vimeo to insert into gallery.");
                return false;
            }

            window.parent.uploadID.val(ID1);

            tb_remove();
            $("#save-buttom").click();
        });

        jQuery('#huge_it_add_video_input').change(function() {

            if (jQuery(this).val().indexOf("youtube") >= 0) {
                jQuery('#add-video-popup-options > div').removeClass('active');
                jQuery('#add-video-popup-options  .youtube').addClass('active');
                jQuery('#isYoutube').val(true);
            } else if (jQuery(this).val().indexOf("vimeo") >= 0) {
                jQuery('#add-video-popup-options > div').removeClass('active');
                jQuery('#add-video-popup-options  .vimeo').addClass('active');
                jQuery('#isYoutube').val(false);
            } else {
                jQuery('#add-video-popup-options > div').removeClass('active');
                jQuery('#add-video-popup-options  .error-message').addClass('active');
                jQuery('#isYoutube').val('');
            }
        })

        jQuery('.updated').css({"display": "none"});
<?php if (@$_GET["closepop"] == 1) { ?>
            $("#closepopup").click();
            self.parent.location.reload();
<?php } ?>

    });

</script>
<div class="slider-options-head">
<div style="float: left;">
    <div><a href="http://huge-it.com/joomla-extensions-gallery-user-manual/" target="_blank">User Manual</a></div>
    <div>This feature is available in Pro version. To use it <a href="http://huge-it.com/joomla-gallery/" target="_blank">get Full version.</a></div>
</div>
</div>
<div style="clear: both;"></div>
<a id="closepopup"  onclick=" parent.eval('tb_remove()')" style="display:none;" > [X] </a>

<div id="huge_it_slider_add_videos">
    <div id="huge_it_slider_add_videos_wrap">
        <h2 style="color: #5bb75b">Add Video URL From YouTube or Vimeo</h2>
        <div class="control-panel">
            <form action="<?php echo JRoute::_('index.php?option=com_gallery&view=video&task=video.save&id=' . $_GET['pid']) ?>" method="post" name="adminForm" id="adminForm"   enctype="multipart/form-data">
                <input type="text" id="huge_it_add_video_input" name="huge_it_add_video_input" />
                <div class="button2-left" style="margin: 0 0 0 10px;float: left;">
<div class="blank">
  <button class='btn btn-large btn-success' id='huge-it-insert-video-button' onClick="alert('Sorry, Add Video feature is disabled in free version, please purchase the commercial version to use it.');window.parent.location.reload();"  >Insert Video </button>
</div>
</div>				<div id="add-video-popup-options">
                <div>
                    <div>
                        <label for="show_title">Title:</label>	
                        <div>
                            <input name="show_title" value="" type="text" />
                        </div>
                    </div>
                    <div>
                        <label for="show_description">Description:</label>
                        <textarea id="show_description" name="show_description"></textarea>
                    </div>
                    <div>
                        <label for="show_url">Url:</label>
                        <input type="text" name="show_url" value="" />	
                    </div>
                </div>
                </div>
            <input type="hidden" id ="isYoutube" name="isYoutube" value="">

            </form>
        </div>
    </div>	
</div>