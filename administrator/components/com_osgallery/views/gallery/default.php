<?php
/**
* @package OS Gallery
* @copyright 2016 OrdaSoft
* @author 2016 Andrey Kvasnevskiy(akbet@mail.ru),Roman Akoev (akoevroman@gmail.com)
* @license GNU General Public License version 2 or later;
* @description Ordasoft Image Gallery
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>

<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <ul class="main-gallery-header nav nav-tabs main-nav-tabs" style="display:none;">
        <li><a href="#gallery-main-tab"><?php echo JText::_("COM_OSGALLERY_BUTTON_MAIN")?></a></li>
        <li><a href="#gallery-settings-tab"><?php echo JText::_("COM_OSGALLERY_SETTINGS_BUTTON_MAIN")?></a></li>
    </ul>
    <div class="gallery-main-content-tab tab-content">
        <div id="gallery-main-tab" class="tab-pane fade">
            <div class="span8 os-gallery-wrapp">
                <div id="file-area">
                  <noscript>
                      <p>JavaScript disabled :(</p>
                  </noscript>
                </div>

                <ul id="osgalery-cat-tabs" class="nav cat-nav-tabs nav-tabs">
                    <?php
                    foreach($categories as $cat){ ?>
                        <li id="order-id-<?php echo $cat->id?>">
                            <a href="#cat-<?php echo $cat->id?>" data-cat-id="<?php echo $cat->id?>"><?php echo $cat->name?></a>
                            <input type="hidden" name="category_names[]" value="<?php echo $cat->id?>|+|<?php echo $cat->name?>" placeholder="">
                            <span class="edit-category-name"><i class="material-icons">mode_edit</i>edit</span>
                            <span class="delete-category"><i class="material-icons">delete</i></span>
                        </li>
                    <?php
                    } ?>
                    <span class="add-new-cat"><i class="material-icons">note_add</i> New Category</span>
                </ul>

                <div id="os-cat-tab-images" class="tab-content">
                    <?php
                    foreach($categories as $cat){
                        ?>
                        <div id="cat-<?php echo $cat->id?>" class="tab-pane fade">
                            <?php
                            if(isset($images[$cat->id])){
                                foreach($images[$cat->id] as $image){
                                    echo '<div id="img-'.$image->id.'" class="img-block" data-image-id="'.$image->id.'">'.
                                            '<span class="delete-image"><i class="material-icons">close</i></span>'.
                                            '<img src="'.JURI::root().'images/com_osgallery/gal-'.$galId.'/thumbnail/'.$image->file_name.'" alt="'.$image->file_name.'">'.
                                            '<input id="img-settings-'.$image->id.'" type="hidden" name="imgSettings['.$image->id.']" value="'.$imgParamsArray[$image->id]->params.'">'.
                                        '</div>';
                                }
                            }?>
                            <input class="cat-img-ordering" type="hidden" name="imageOrdering[<?php echo $cat->id?>]" value="">
                            <input id="cat-settings-<?php echo $cat->id;?>" type="hidden" name="catSettings[<?php echo $cat->id; ?>]" value="<?php echo $catParamsArray[$cat->id]->params;?>">
                        </div>
                    <?php
                    } ?>
                </div>
            </div>
            <!-- Options for category and each image -->
            <div class="span4">

            </div>
            <div class="category-options-block">
                    <ul class="options-header nav nav-tabs main-nav-tabs">
                        <li><a href="#img-options-block"><?php echo JText::_("COM_OSGALLERY_IMAGE_OPTION_TAB")?></a></li>
                        <li><a href="#cat-options-block"><?php echo JText::_("COM_OSGALLERY_CATEGORY_OPTION_TAB")?></a></li>
                    </ul>
        <!-- IMAGE SETTINGS BLOCK -->
                    <div class="category-options-content tab-content">
                        <div id="img-options-block" class="tab-pane fade">
                            <div>
                                <span class="cat-col-1"><?php echo JText::_("COM_OSGALLERY_IMAGE_OPTION_TITLE_LABEL")?></span>
                                <span class="cat-col-2">
                                    <input id="img-title" type="text" name="imgTitle" value="">
                                </span>
                            </div>

                            <div>
                                <span class="cat-col-1"><?php echo JText::_("COM_OSGALLERY_IMAGE_OPTION_ALIAS_LABEL")?></span>
                                <span class="cat-col-2">
                                    <input id="img-alias" type="text" name="imgAlias" value="">
                                </span>
                            </div>

                            <div>
                                <span class="cat-col-1"><?php echo JText::_("COM_OSGALLERY_IMAGE_OPTION_SHORT_DESCRIPTION_LABEL")?></span>
                                <span class="cat-col-2">
                                    <input id="img-short-description" type="text" name="imgShortDescription" value="">
                                </span>
                            </div>

                            <div>
                                <span class="cat-col-1"><?php echo JText::_("COM_OSGALLERY_IMAGE_OPTION_ALT_LABEL")?></span>
                                <span class="cat-col-2">
                                    <input id="img-alt" type="text" name="imgAlt" value="">
                                </span>
                            </div>

                            <div>
                                <span class="cat-col-1"><?php echo JText::_("COM_OSGALLERY_IMAGE_OPTION_LINK_LABEL")?></span>
                                <span class="cat-col-2">
                                    <input id="img-link" type="text" name="imgLink" value="">
                                </span>
                            </div>

                            <div>
                                <span class="cat-col-1"><?php echo JText::_("COM_OSGALLERY_IMAGE_OPTION_LINK_TARGET_LABEL")?></span>
                                <span class="cat-col-2">
                                    <select id="img-link-open" name="linkOpen">
                                        <option value="_blank"><?php echo JText::_("COM_OSGALLERY_IMAGE_OPTION_LINK_TARGET_SELECT1")?></option>
                                        <option value="_self"><?php echo JText::_("COM_OSGALLERY_IMAGE_OPTION_LINK_TARGET_SELECT2")?></option>
                                    </select>
                                </span>
                            </div>
                        </div>
    <!-- CATEGORY SETTINGS BLOCK -->
                        <div id="cat-options-block" class="tab-pane fade">
                            <div>
                                <span class="cat-col-1"><?php echo JText::_("COM_OSGALLERY_CATEGORY_OPTION_ALIAS_LABEL")?></span>
                                <span class="cat-col-2">
                                    <input id="cat-alias" type="text" name="categoryAlias" value="">
                                </span>
                            </div>

                            <div class="cat-show-title-block">
                                <span class="cat-col-1"><?php echo JText::_("COM_OSGALLERY_CATEGORY_OPTION_SHOW_TITLE_LABEL")?></span>
                                <span class="cat-col-2">
                                    <div class="os-check-box">
                                      <input type="checkbox" value="None" id="cat-show-title" name="check" checked="checked" />
                                      <label for="cat-show-title"></label>
                                    </div>
                                </span>
                            </div>

                            <div>
                                <span class="cat-col-1"><?php echo JText::_("COM_OSGALLERY_CATEGORY_OPTION_SHOW_TITLE_CAPTION_LABEL")?></span>
                                <span class="cat-col-2">
                                    <div class="os-check-box">
                                      <input type="checkbox" value="None" id="cat-show-cat-title-caption" name="check" checked="checked" />
                                      <label for="cat-show-cat-title-caption"></label>
                                    </div>
                                </span>
                            </div>

                            <div>
                                <span class="cat-col-1"><?php echo JText::_("COM_OSGALLERY_CATEGORY_OPTION_UNPUBLISH_LABEL")?></span>
                                <span class="cat-col-2">
                                    <div class="os-check-box">
                                      <input type="checkbox" value="None" id="cat-unpublish" />
                                      <label for="cat-unpublish"></label>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <!-- gallery settings tab -->
        <div id="gallery-settings-tab" class="tab-pane fade">
            <ul id="osgalery-settings-tabs" class="nav settings-nav-tabs nav-tabs">
                <li>
                    <a href="#general-settings"><?php echo JText::_("COM_OSGALLERY_SETTINGS_GENERAL_TAB_LABEL")?></a>
                </li>
                <li class="osg-pro-avaible">
                    <a href="#fancybox-settings"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_TAB_LABEL")?></a>
                </li>
                <li class="osg-pro-avaible">
                    <a href="#watermark-settings"><?php echo JText::_("COM_OSGALLERY_SETTINGS_WATEMARK_TAB_LABEL")?></a>
                </li>
            </ul>
            <div id="os-tab-settings" class="tab-content">
<!-- GENERAL settings -->
                <div id="general-settings" class="tab-pane fade">
                    <div>
                        <span class="cat-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_GENERALLAYOUT_LABEL")?></span>
                        <span class="cat-col-2">
                            <select class="gallery-layout" name="galleryLayout">
                                <option <?php echo ($gallerylayout == "defaultTabs")?'selected="selected"':''?> value="defaultTabs">Default</option>
                            </select>
                        </span>
                    </div>

                    <div class="back-button-text-block" style="display:none!important;">
                        <span class="cat-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_GENERAL_BACK_BUTTON_LABEL")?></span>
                        <span class="cat-col-2">
                            <input type="hidden" name="backButtonText" value="<?php echo $backButtonText?>">
                        </span>
                    </div>

                    <div>
                        <span class="cat-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_GENERAL_IMAGE_MARGIN_LABEL")?></span>
                        <span class="cat-col-2">
                            <input type="number" min="0" name="image_margin" value="<?php echo $imageMargin?>">
                        </span>
                    </div>

                    <div>
                        <span class="cat-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_GENERAL_IMAGE_NUM_COLUMNS_LABEL")?></span>
                        <span class="cat-col-2">
                            <input type="number" min="1" name="num_column" value="<?php echo $numColumn?>">
                        </span>
                    </div>

                    <div>
                        <span class="cat-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_GENERAL_IMAGE_DECREASE_COLUMN")?></span>
                        <span class="cat-col-2">
                            <div class="osgallery-checkboxes-block">
                                <input id="general-min-enable-yes" type="radio" name="minImgEnable" value="1" <?php echo $minImgEnable?'checked':''?>/>
                                <input id="general-min-enable-no" type="radio" name="minImgEnable" value="0" <?php echo $minImgEnable?'':'checked'?>/>
                                <label for="general-min-enable-yes" data-value="Yes">Yes</label>
                                <label for="general-min-enable-no" data-value="No">No</label>
                            </div>
                        </span>
                    </div>

                    <div>
                        <span class="cat-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_GENERAL_IMAGE_DECREASE_COLUMN_SIZE")?></span>
                        <span class="cat-col-2">
                            <input type="number" min="1" name="minImgSize" value="<?php echo $minImgSize?>">
                        </span>
                    </div>

                    <div>
                        <span class="cat-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_GENERAL_IMAGEHOVER_LABEL")?></span>
                        <span class="cat-col-2">
                            <select name="imageHover">
                                <option <?php echo ($imagehover == "dimas")?'selected="selected"':''?> value="dimas">Dimas</option>
                                <option <?php echo ($imagehover == "andrea")?'selected="selected"':''?> value="andrea">Andrea</option>
                            </select>
                        </span>
                    </div>
                </div>

                <div id="fancybox-settings" class="tab-pane fade osg-pro-avaible">
                    <div>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_BACKGROUND_COLOR_SELECT_LABEL")?></span>
                        <span class="sett-col-2">
                            <select name="fancy_box_background">
                                <option <?php echo $fancy_box_background=="gray"?'selected':''?> value="gray"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_BACKGROUND_COLOR_SELECT_OPTION1")?></option>
                                <option <?php echo $fancy_box_background=="white"?'selected':''?> value="white"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_BACKGROUND_COLOR_SELECT_OPTION2")?></option>
                                <option <?php echo $fancy_box_background=="transparent"?'selected':''?> value="transparent"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_BACKGROUND_COLOR_SELECT_OPTION3")?></option>
                            </select>
                        </span>
                    </div>

                    <div>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_CLOSE_CLICK_LABEL")?></span>
                        <span class="sett-col-2">
                            <div class="osgallery-checkboxes-block">
                                <input id="fancybox-close-yes" type="radio" name="click_close" value="1" <?php echo $click_close?'checked':''?>/>
                                <input id="fancybox-close-no" type="radio" name="click_close" value="0" <?php echo $click_close?'':'checked'?>/>
                                <label for="fancybox-close-yes" data-value="Yes">Yes</label>
                                <label for="fancybox-close-no" data-value="No">No</label>
                            </div>
                        </span>
                    </div>

                    <div>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_OPEN_CLOSE_LABEL")?></span>
                        <span class="sett-col-2">
                            <select name="open_close_effect">
                                <option <?php echo $open_close_effect=="elastic"?'selected':''?> value="elastic">Elastic</option>
                                <option <?php echo $open_close_effect=="fade"?'selected':''?> value="fade">Fade</option>
                                <option <?php echo $open_close_effect=="none"?'selected':''?> value="none">None</option>
                            </select>
                        </span>
                    </div>

                    <div>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_OPEN_CLOSE_SPEED_LABEL")?></span>
                        <span class="sett-col-2">
                            <input type="text" name="open_close_speed" value="<?php echo $open_close_speed?>"/>
                        </span>
                    </div>

                    <div>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_PREV_NEXT_EFFECT_LABEL")?></span>
                        <span class="sett-col-2">
                            <select name="prev_next_effect">
                                <option <?php echo $prev_next_effect=="elastic"?'selected':''?> value="elastic">Elastic</option>
                                <option <?php echo $prev_next_effect=="fade"?'selected':''?> value="fade">Fade</option>
                                <option <?php echo $prev_next_effect=="none"?'selected':''?> value="none">None</option>
                            </select>
                        </span>
                    </div>

                    <div>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_PREV_NEXT_SPEED_LABEL")?></span>
                        <span class="sett-col-2">
                            <input type="text" name="prev_next_speed" value="<?php echo $prev_next_speed?>"/>
                        </span>
                    </div>

                    <div>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_IMAGE_TITLE_LABEL")?></span>
                        <span class="sett-col-2">
                            <select name="img_title">
                                <option <?php echo $img_title=="float"?'selected':''?> value="float">Float</option>
                                <option <?php echo $img_title=="inside"?'selected':''?> value="inside">Inside</option>
                                <option <?php echo $img_title=="outside"?'selected':''?> value="outside">Outside</option>
                                <option <?php echo $img_title=="over"?'selected':''?> value="over">Over</option>
                                <option <?php echo $img_title=="none"?'selected':''?> value="none">None</option>
                            </select>
                        </span>
                    </div>

                    <div>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_LOOP_LABEL")?></span>
                        <span class="sett-col-2">
                            <div class="osgallery-checkboxes-block">
                                <input id="fancybox-loop-yes" type="radio" name="loop" value="1" <?php echo $loop?'checked':''?>/>
                                <input id="fancybox-loop-no" type="radio" name="loop" value="0" <?php echo $loop?'':'checked'?>/>
                                <label for="fancybox-loop-yes" data-value="Yes">Yes</label>
                                <label for="fancybox-loop-no" data-value="No">No</label>
                            </div>
                        </span>
                    </div>

                    <div>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_HELPERS_BUTTONS_LABEL")?></span>
                        <span class="sett-col-2">
                            <div class="osgallery-checkboxes-block">
                                <input id="fancybox-helpers-yes" type="radio" name="helper_buttons" value="1" <?php echo $helper_buttons?'checked':''?>/>
                                <input id="fancybox-helpers-no" type="radio" name="helper_buttons" value="0" <?php echo $helper_buttons?'':'checked'?>/>
                                <label for="fancybox-helpers-yes" data-value="Yes">Yes</label>
                                <label for="fancybox-helpers-no" data-value="No">No</label>
                            </div>
                        </span>
                    </div>

                    <div>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_HELPERS_THUMBNAIL_LABEL")?></span>
                        <span class="sett-col-2">
                            <div class="osgallery-checkboxes-block">
                                <input id="fancybox-thumbnail-yes" type="radio" name="helper_thumbnail" value="1" <?php echo $helper_thumbnail?'checked':''?>/>
                                <input id="fancybox-thumbnail-no" type="radio" name="helper_thumbnail" value="0" <?php echo $helper_thumbnail?'':'checked'?>/>
                                <label for="fancybox-thumbnail-yes" data-value="Yes">Yes</label>
                                <label for="fancybox-thumbnail-no" data-value="No">No</label>
                            </div>
                        </span>
                    </div>

                    <div class="thumbnail-help-block">
                        <div>
                            <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_HELPERS_THUMBNAIL_WIDTH_LABEL")?></span>
                            <span class="sett-col-2">
                                <input type="text" name="thumbnail_width" value="<?php echo $thumbnail_width?>"/>
                            </span>
                        </div>

                        <div>
                            <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_HELPERS_THUMBNAIL_HEIGHT_LABEL")?></span>
                            <span class="sett-col-2">
                                <input type="text" name="thumbnail_height" value="<?php echo $thumbnail_height?>"/>
                            </span>
                        </div>
                    </div>

                    <div>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_PREV_NEXT_ARROWS_LABEL")?></span>
                        <span class="sett-col-2">
                            <div class="osgallery-checkboxes-block">
                                <input id="fancybox-arrows-yes" type="radio" name="fancybox_arrows" value="1" <?php echo $fancybox_arrows?'checked':''?>/>
                                <input id="fancybox-arrows-no" type="radio" name="fancybox_arrows" value="0" <?php echo $fancybox_arrows?'':'checked'?>/>
                                <label for="fancybox-arrows-yes" data-value="Yes">Yes</label>
                                <label for="fancybox-arrows-no" data-value="No">No</label>
                            </div>
                        </span>
                    </div>

                    <div class="fancybox-arrows-pos-block" <?php echo $fancybox_arrows?'':'style="display:none;"'?>>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_PREV_NEXT_ARROWS_POSITION")?></span>
                        <span class="sett-col-2">
                            <div class="osgallery-checkboxes-block">
                                <input id="fancybox-arrows-pos-yes" type="radio" name="fancybox_arrows_pos" value="1" <?php echo $fancybox_arrows_pos?'checked':''?>/>
                                <input id="fancybox-arrows-pos-no" type="radio" name="fancybox_arrows_pos" value="0" <?php echo $fancybox_arrows_pos?'':'checked'?>/>
                                <label for="fancybox-arrows-pos-yes" data-value="Inside">Inside</label>
                                <label for="fancybox-arrows-pos-no" data-value="Outside">Outside</label>
                            </div>
                        </span>
                    </div>

                    <div>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_CLOSE_BUTTON_LABEL")?></span>
                        <span class="sett-col-2">
                            <div class="osgallery-checkboxes-block">
                                <input id="fancybox-button-yes" type="radio" name="close_button" value="1" <?php echo $close_button?'checked':''?>/>
                                <input id="fancybox-button-no" type="radio" name="close_button" value="0" <?php echo $close_button?'':'checked'?>/>
                                <label for="fancybox-button-yes" data-value="Yes">Yes</label>
                                <label for="fancybox-button-no" data-value="No">No</label>
                            </div>
                        </span>
                    </div>

                    <div>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_NEXT_CLICK_LABEL")?></span>
                        <span class="sett-col-2">
                            <div class="osgallery-checkboxes-block">
                                <input id="fancybox-next-yes" type="radio" name="next_click" value="1" <?php echo $next_click?'checked':''?>/>
                                <input id="fancybox-next-no" type="radio" name="next_click" value="0" <?php echo $next_click?'':'checked'?>/>
                                <label for="fancybox-next-yes" data-value="Yes">Yes</label>
                                <label for="fancybox-next-no" data-value="No">No</label>
                            </div>
                        </span>
                    </div>

                    <div>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_MOUSE_WHEEL_LABEL")?></span>
                        <span class="sett-col-2">
                            <div class="osgallery-checkboxes-block">
                                <input id="fancybox-mouse-yes" type="radio" name="mouse_wheel" value="1" <?php echo $mouse_wheel?'checked':''?>/>
                                <input id="fancybox-mouse-no" type="radio" name="mouse_wheel" value="0" <?php echo $mouse_wheel?'':'checked'?>/>
                                <label for="fancybox-mouse-yes" data-value="Yes">Yes</label>
                                <label for="fancybox-mouse-no" data-value="No">No</label>
                            </div>
                        </span>
                    </div>

                    <div>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_AUTOPLAY_LABEL")?></span>
                        <span class="sett-col-2">
                            <div class="osgallery-checkboxes-block">
                                <input id="fancybox-autoplay-yes" type="radio" name="fancybox_autoplay" value="1" <?php echo $fancybox_autoplay?'checked':''?>/>
                                <input id="fancybox-autoplay-no" type="radio" name="fancybox_autoplay" value="0" <?php echo $fancybox_autoplay?'':'checked'?>/>
                                <label for="fancybox-autoplay-yes" data-value="Yes">Yes</label>
                                <label for="fancybox-autoplay-no" data-value="No">No</label>
                            </div>
                        </span>
                    </div>

                    <div class="autoplay-helper-block">
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_FANCYBOX_AUTOPLAY_SPEED_LABEL")?></span>
                        <span class="sett-col-2">
                            <input type="text" name="autoplay_speed" value="<?php echo $autoplay_speed?>"/>
                        </span>
                    </div>
                </div>
    <!-- WATERMARK -->
                <div id="watermark-settings" class="tab-pane fade osg-pro-avaible">
                    <div>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_WATERMARK_ENABLE_LABEL")?></span>
                        <span class="sett-col-2">
                            <div class="osgallery-checkboxes-block">
                                <input id="fancybox-watermark-yes" type="radio" name="watermark_enable" value="1" <?php echo $watermark_enable?'checked':''?>/>
                                <input id="fancybox-watermark-no" type="radio" name="watermark_enable" value="0" <?php echo $watermark_enable?'':'checked'?>/>
                                <label for="fancybox-watermark-yes" data-value="Yes">Yes</label>
                                <label for="fancybox-watermark-no" data-value="No">No</label>
                            </div>
                        </span>
                    </div>

                    <div>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_WATERMARK_TYPE_LABEL")?></span>
                        <span class="sett-col-2">
                            <div class="osgallery-checkboxes-block">
                                <input id="fancybox-watermark-image" type="radio" name="watermark_type" value="1" <?php echo $watermark_type?'checked':''?>/>
                                <input id="fancybox-watermark-text" type="radio" name="watermark_type" value="0" <?php echo $watermark_type?'':'checked'?>/>
                                <label for="fancybox-watermark-image" data-value="Image">Image</label>
                                <label for="fancybox-watermark-text" data-value="Text">Text</label>
                            </div>
                        </span>
                    </div>

                    <div id="watermark-image-block" <?php echo $watermark_type?'':'style="display:none;"'?>>
                        <div>
                            <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_WATERMARK_SELECT_LABEL")?></span>
                            <span class="sett-col-2">
                                <div class="file-upload">
                                    <button class="file-upload-button" type="button">Select</button>
                                    <div class="none-upload"><?php echo $watermark_file?$watermark_file:'No file chosen.'?></div>
                                    <input id="watermark-input" type="file" name="watermark_file" value="">
                                    <input type="hidden" name="exist_watermark_file" value="<?php echo $watermark_file?>">
                                </div>
                            </span>
                        </div>

                        <div>
                            <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_WATERMARK_SIZE_LABEL")?></span>
                            <span class="sett-col-2">
                                <input type="number" min="5" max="100" name="watermark_size" value="<?php echo $watermark_size?>">
                            </span>
                        </div>
                    </div>
                    <div id="watermark-text-block">
                        <div>
                            <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_WATERMARK_TEXT_LABEL")?></span>
                            <span class="sett-col-2">
                                <input type="text" name="watermark_text" value="<?php echo $watermark_text?>" maxlength="50">
                                <input type="hidden" name="exist_watermark_text" value="<?php echo $exist_watermark_text?>">
                            </span>
                        </div>

                        <div>
                            <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_WATERMARK_FONT_SIZE_LABEL")?></span>
                            <span class="sett-col-2">
                                <input type="number" min="5" max="50" name="watermark_text_size" value="<?php echo $watermark_text_size?>">
                            </span>
                        </div>

                        <div>
                            <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_WATERMARK_FONT_COLOR_LABEL")?></span>
                            <span class="sett-col-2">
                                <input type="text" name="watermark_text_color" value="<?php echo $watermark_text_color?>">
                            </span>
                        </div>

                        <div>
                            <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_WATERMARK_ANGLE_LABEL")?></span>
                            <span class="sett-col-2">
                                <div class="osgallery-checkboxes-block">
                                <input id="watermark-angle-0" type="radio" name="watermark_text_angle" <?php echo(($watermark_text_angle == 0)?'checked="checked"':'')?> value="0">
                                <input id="watermark-angle-45" type="radio" name="watermark_text_angle" <?php echo(($watermark_text_angle == 45)?'checked="checked"':'')?> value="45">
                                <input id="watermark-angle-90" type="radio" name="watermark_text_angle" <?php echo(($watermark_text_angle == 90)?'checked="checked"':'')?> value="90">
                                <label for="watermark-angle-0" data-value="0">0</label>
                                <label for="watermark-angle-45" data-value="45">45</label>
                                <label for="watermark-angle-90" data-value="90">90</label>
                            </div>
                            </span>
                        </div>
                    </div>
                    <div>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_WATERMARK_POSITION_LABEL")?></span>
                        <span class="sett-col-2">
                            <select name="watermark_position">
                                <option <?php echo $watermark_position=="top_right"?'selected':''?> value="top_right">Top right</option>
                                <option <?php echo $watermark_position=="top_left"?'selected':''?> value="top_left">Top left</option>
                                <option <?php echo $watermark_position=="center"?'selected':''?> value="center">Center</option>
                                <option <?php echo $watermark_position=="bottom_right"?'selected':''?> value="bottom_right">Bottom right</option>
                                <option <?php echo $watermark_position=="bottom_left"?'selected':''?> value="bottom_left">Bottom left</option>
                            </select>
                            <input type="hidden" name="watermark_position_selected" value="<?php echo $watermark_position?>">
                        </span>
                    </div>

                    <div>
                        <span class="sett-col-1"><?php echo JText::_("COM_OSGALLERY_SETTINGS_WATERMARK_OPACITY_LABEL")?></span>
                        <span class="sett-col-2">
                            <input type="number" min="0" max="100" name="watermark_opacity" value="<?php echo $watermark_opacity?>">
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="option" value="com_osgallery"/>
    <input type="hidden" name="task" value="save_gallery"/>
    <input id="catOrderIds" type="hidden" name="catOrderIds" value=""/>
    <input id="galerryId" type="hidden" name="galId" value="<?php echo $galId?>"/>
    <input id="hidden-title" type="hidden" name="gallery_title" value="<?php echo $galeryTitle?>"/>
</form>

<script src="components/com_osgallery/assets/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="components/com_osgallery/assets/js/jquery.slider.minicolors.js" type="text/javascript"></script>
<script language="JavaScript">
    var galerryTrigger = true;

    //colorpicker
    jQuery("[name='watermark_text_color']").minicolors({
        control: "hue",
        defaultValue: "",
        format:"rgb",
        position: "top right",
        hideSpeed: 100,
        inline: false,
        theme: "bootstrap",
        change: function(value, opacity) {
          jQuery(this).attr("value",value);
        }
    });

    //fn for find position of dom obj
    function findPosY(obj) {
      var curtop = 0;
      if(obj.offsetParent){
        while(1){
          curtop+=obj.offsetTop;
          if(!obj.offsetParent){
            break;
          }
          obj=obj.offsetParent;
        }
      }else if (obj.y){
        curtop+=obj.y;
      }
      return curtop-100;
    }
  //end

    //on save
    Joomla.submitbutton = function(pressbutton) {
        if(pressbutton =='open_gallery_settings'){
            if(galerryTrigger){
                jQuery("#system-message-container").removeClass('gallery-main');
                jQuery("#system-message-container").addClass('gallery-settings');
                jQuery(".main-gallery-header a:last").tab('show');
                jQuery("#toolbar div:last button").html('Back to Gallery');
                galerryTrigger = false;
            }else{
                jQuery("#system-message-container").removeClass('gallery-settings');
                jQuery("#system-message-container").addClass('gallery-main');
                jQuery(".main-gallery-header a:first").tab('show');
                jQuery("#toolbar div:last button").html('<span class="icon-options"></span>Gallery Settings');
                galerryTrigger = true;
            }
            return;
        }else if(pressbutton!='close_gallery'){
            jQuery("#catOrderIds").val(jQuery("#osgalery-cat-tabs").sortable( "toArray" ));
            jQuery("#os-cat-tab-images div.tab-pane").each(function(index, el) {
               jQuery(this).find(".cat-img-ordering").val(jQuery(this).sortable( "toArray" ));
            });
            //check title
            if(!jQuery('#gallery-title').val()){
                window.scrollTo(0,findPosY(jQuery('#gallery-title'))-100);
                jQuery('#gallery-title').attr("placeholder", "<?php echo JText::_('Cannot be empty'); ?>");
                jQuery('#gallery-title').css("border-color","#FF0000");
                jQuery('#gallery-title').css("background","#FF0000");
                jQuery('#gallery-title').keypress(function() {
                    jQuery('#gallery-title').css("border-color","gray");
                    jQuery('#gallery-title').css("color","inherit");
                });
                return;
            }
            document.adminForm.task.value = pressbutton;
            if(pressbutton=='save_gallery'){
                if(jQuery("#new-cat-name")){
                    jQuery(".save-cat-name").trigger('click');
                }

                //grab all form data
                var formData = new FormData(jQuery("#adminForm")[0]);
                html = '<div id="gallery-waiting-spinner"><div class="gallery-wait-spinner">'+
                        'Please wait <div class="gallery-wait-bounce1"></div>'+
                        '<div class="gallery-wait-bounce2"></div>'+
                        '<div class="gallery-wait-bounce3"></div>'+
                        '</div></div>';
                jQuery("body").prepend(html);
                jQuery.ajax({
                    url: '?option=com_osgallery&task=save_gallery&format=raw',
                    type: 'POST',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        jQuery("#gallery-waiting-spinner").remove();
                        try {
                            data = window.JSON.parse(data);
                        } catch (e) {
                            data.success = false;
                        }
                        if (data.success) {
                            params = window.JSON.parse(data.params);
                            jQuery("[name='exist_watermark_file']").val(params.watermark_file);
                            html = '<div class="alert alert-success">'+
                                        '<h4 class="alert-heading">Message</h4>'+
                                        '<div class="alert-message">'+data.message+'</div>'+
                                    '</div>';
                            jQuery("#system-message-container").html(html);
                            jQuery(".category-options-block").addClass("category-options-block-message");
                            setTimeout(function(){
                                jQuery("#system-message-container").empty();
                                jQuery(".category-options-block").removeClass("category-options-block-message");
                            }, 3000);
                        }else{
                          console.log('oops');
                        }
                    }
                });
            }else{
                if(jQuery("#new-cat-name")){
                    jQuery(".save-cat-name").trigger('click');
                }
                document.adminForm.task.value = pressbutton;
                document.adminForm.submit();
            }
        }else{
            document.adminForm.task.value = pressbutton;
            document.adminForm.submit();
        }
    };

    //global counters
    var catId = <?php echo $activeIndex?>;
    var activeId = jQuery("#osgalery-cat-tabs a:first").data("cat-id");
    var galId = <?php echo $galId?>

    jQuery(".add-new-cat").click(function(event) {
        if(jQuery("#new-cat-name")){
            jQuery(".save-cat-name").trigger('click');
        }
        //native js faster
        catId++;

        //create new li
        var li = document.createElement('li');
        li.id = "order-id-"+catId;
        li.innerHTML = '<a href="#cat-'+catId+'" data-cat-id="'+catId+'">Category Title</a>'+
                        '<input type="hidden" name="category_names[]" value="'+catId+'|+|Category Title" placeholder="">'+
                        '<span class="edit-category-name"><i class="material-icons">mode_edit</i>'+
        'edit</span>'+
                        '<span class="delete-category"><i class="material-icons">delete</i></span>';
        list = document.getElementById("osgalery-cat-tabs");
        list.insertBefore(li, list.children[list.children.length-1]);

        //create new tab content
        var div = document.createElement('div');
        div.id = 'cat-'+catId;
        div.className = 'tab-pane fade';
        div.innerHTML = '<input class="cat-img-ordering" type="hidden" name="imageOrdering['+catId+']" value="">'+
                        '<input id="cat-settings-'+catId+'" type="hidden" name="catSettings['+catId+']" value="{}">';
        list = document.getElementById("os-cat-tab-images");
        list.insertBefore(div, list.children[list.children.length-1]);
        makeTabsCliked();

        //activated tab
        activeId = catId;
        jQuery("#osgalery-cat-tabs a[href='#cat-"+activeId+"'").tab('show');
        //update settings
        catSettings = window.JSON.parse('{}');
        jQuery("#cat-alias").val(catSettings.categoryAlias || '');
        jQuery("#cat-unpublish").prop("checked",catSettings.categoryUnpublish || false);
        jQuery("#cat-show-title").prop("checked",catSettings.categoryShowTitle);
        jQuery("#cat-show-cat-title-caption").prop("checked",catSettings.categoryShowTitleCaption);
        jQuery(".category-options-block a:last").tab('show');

        //update settings
        imgSettings = window.JSON.parse('{}');
        jQuery("#img-title").val(imgSettings.imgTitle || '');
        jQuery("#img-alias").val(imgSettings.imgAlias || '');
        jQuery("#img-short-description").val(imgSettings.imgShortDescription || '');
        jQuery("#img-alt").val(imgSettings.imgAlt || '');
        jQuery("#img-link").val(imgSettings.imgLink || '');
        jQuery("#img-link-open").val(imgSettings.imgLinkOpen || '_blank');

        //reload uploder params
        uploader.setParams({
            catId: activeId,
            galId: galId
        });
        makeCatSortable();
        catSettingsFunctions();
    });

    //uploader
    var uploader = new qq.FileUploader({
        element: document.getElementById('file-area'),
        action: '<?php echo JURI::current()?>?option=com_osgallery&task=upload_images',
        params: {
          catId: activeId,
          galId: galId
        },
        sizeLimit: 10 * 1024 * 1024,
        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
        debug: false,
        template:
            '<div class="qq-uploader">' +
                '<div class="qq-upload-drop-area"><p>drag and drop images here</p><span class="btnButton">Select images</span></div>' +
                '<div class="qq-upload-button"><p>drag and drop images here</p><span class="pseudo_button">Select images</span></div>' +
                '<ul class="qq-upload-list"></ul>' +
                '</div><div style="display:none;" id="my_popup"><p>Popup content</p></div>',
        onComplete: function (id, filename, responseJSON) {
            if (!responseJSON.success) {
            }else{
                //create image
                fileName = responseJSON.file;
                ext = responseJSON.ext;
                imgId = responseJSON.id;
                image = '<div id="img-'+imgId+'" class="img-block" data-image-id="'+imgId+'">'+
                          '<span class="delete-image"><i class="material-icons">close</i></span>'+
                          '<img src="<?php echo JURI::root()?>images/com_osgallery/gal-'+galId+'/thumbnail/'+fileName+ext+'" alt="'+fileName+'">'+
                          '<input id="img-settings-'+imgId+'" type="hidden" name="imgSettings['+imgId+']" value="{}">'+
                        '</div>';
                jQuery("#cat-"+activeId).append(image);
                makeDeleteImage();
                if(jQuery(".qq-upload-list li").not('.qq-upload-success').length == 0){
                    setTimeout(function(){
                        jQuery(".qq-upload-list").empty();
                    }, 5000);
                }
                makeCatSortable();
                imgSettingsFunctions();
            }
        }
    });
//end

    //some click function
    function makeTabsCliked(){
        jQuery(".main-nav-tabs a,.settings-nav-tabs a").click(function(e){
            e.preventDefault();
            jQuery(this).tab('show');
        });

        //fn-for edit cat name
        jQuery(".edit-category-name").unbind('click');
        jQuery(".edit-category-name").click(function(event){
            if(jQuery("#new-cat-name")){
                jQuery(".save-cat-name").trigger('click');
            }
            jQuery("#osgalery-cat-tabs").sortable( "disable" );
            //short selectors
            li = jQuery(this).parent();
            a = li.find("a");
            li.children().hide();

            //add some tools for type new name
            li.append('<input id="new-cat-name" class="edit-cat-name" type="text" '+
                    'name="save_image" placeholder="type smth..." value="'+a.text()+'">'+
                    '<span class="save-cat-name edit-cat-name">Save</span>');
            //focus on input last symbol
            jQuery("#new-cat-name").focus();
            temp=jQuery("#new-cat-name").val();
            jQuery("#new-cat-name").val('');
            jQuery("#new-cat-name").val(temp);

            //save new name
            jQuery(".save-cat-name").click(function(event) {
                a.text(jQuery("#new-cat-name").val());
                li.find("input:not(#new-cat-name)").val(a.data("cat-id")+'|+|'+jQuery("#new-cat-name").val());
                jQuery(".edit-cat-name").remove();
                li.children().show();
                jQuery("#osgalery-cat-tabs").sortable( "enable" );
            });

            //esc
            jQuery(document).keyup(function(e) {
                if (e.keyCode == 27) { // escape key maps to keycode `27`
                    jQuery(".edit-cat-name").remove();
                    li.children().show();
                    jQuery("#osgalery-cat-tabs").sortable( "enable" );
                }
            });

            //endter
            jQuery(document).keypress(function(e) {
                if(e.which == 13) {
                    jQuery(".save-cat-name").trigger( "click" );
                }
            });
        });

        //fn-s for delete cat with photos // we will delete photos later after save // maybe add restore button
        jQuery(".delete-category").click(function(event) {
            if(jQuery("#osgalery-cat-tabs li").length == 1){
                html = '<div class="alert alert-error">'+
                            '<h4 class="alert-heading">Message</h4>'+
                            '<div class="alert-message">You must have at list 1 category!</div>'+
                        '</div>';
                jQuery("#system-message-container").html(html)
                setTimeout(function(){
                  jQuery("#system-message-container").empty();
                }, 5000);
                return;
            }
            li = jQuery(this).parent();
            a = li.find("a");
            catId = a.data("cat-id");
            jQuery("#adminForm").append('<input type="hidden" name="deletedCatIds[]" value="'+catId+'">')
            jQuery(li).fadeOut(500, function(){ jQuery(this).remove();});
            jQuery("#cat-"+catId).fadeOut(500, function(){ jQuery(this).remove();});
            //activated 1st tab// if we delete current 1-st tab
            if(activeId == catId){
                //show first
                jQuery("#osgalery-cat-tabs a:first").tab('show');
                //get new activeId
                activeId = jQuery("#osgalery-cat-tabs a:first").data("cat-id");

                //reload uploder params
                uploader.setParams({
                    catId: activeId,
                    galId: galId
                })
            }
        });
    }

    function parceOptions(string){
        try{
            string = decodeURI(string);
            return window.JSON.parse(string);
        }catch(err){
            return window.JSON.parse('{}');
        }
    }

    //function for make category tab and images sortable
    function makeCatSortable(){
        jQuery( "#osgalery-cat-tabs" ).sortable({
            handle: 'a',
            axis: "x",
            items: "> li"
        });

        jQuery("#os-cat-tab-images div").sortable({
            cancel: null, // Cancel the default events on the controls
            helper: "clone",
            revert: true,
            tolerance: "intersect",
            handle: 'img',
            items: "> .img-block"
        });
    }
    //cat settings functions
    function catSettingsFunctions(){
        //initialise first tab settings
        var catSettings = parceOptions(jQuery("#cat-settings-"+activeId).val());
        jQuery("#cat-alias").val(catSettings.categoryAlias || '');
        jQuery("#cat-unpublish").prop("checked",catSettings.categoryUnpublish || false);
        jQuery("#cat-show-title").prop("checked",catSettings.categoryShowTitle);
        jQuery("#cat-show-cat-title-caption").prop("checked",catSettings.categoryShowTitleCaption);
        //end

        //change cat click function
        jQuery(".cat-nav-tabs a").click(function(e){
            e.preventDefault();
            jQuery(this).tab('show');
            jQuery(".category-options-block a:last").tab('show');
            activeId = jQuery(this).data("cat-id");
            //reload uploder params
            uploader.setParams({
                catId: activeId,
                galId: galId
            })

            //update settings
            catSettings = parceOptions(jQuery("#cat-settings-"+activeId).val());
            jQuery("#cat-alias").val(catSettings.categoryAlias || '');
            jQuery("#cat-unpublish").prop("checked",catSettings.categoryUnpublish || false);
            jQuery("#cat-show-title").prop("checked",catSettings.categoryShowTitle);
            jQuery("#cat-show-cat-title-caption").prop("checked",catSettings.categoryShowTitleCaption);
        });
        //end

        //change options // maybe need improve on save. // now we save every option immediately when change value
        jQuery("#cat-layout, #cat-unpublish, #cat-show-title, #cat-show-cat-title-caption,#cat-alias").on('customCat', function (e) {
            //get params from jsonString
            catSettings = parceOptions(jQuery("#cat-settings-"+activeId).val());
            catSettings.categoryAlias = checkSpecialChar(jQuery("#cat-alias").val());
            catSettings.categoryUnpublish = jQuery("#cat-unpublish").prop("checked");
            catSettings.categoryShowTitle = jQuery("#cat-show-title").prop("checked");
            catSettings.categoryShowTitleCaption = jQuery("#cat-show-cat-title-caption").prop("checked");

            //set params to Json
            jQuery("#cat-settings-"+activeId).val(encodeURI(window.JSON.stringify(catSettings)));
        });

        jQuery("#cat-layout, #cat-unpublish, #cat-show-title, #cat-show-cat-title-caption").change(function(event) {
            jQuery(this).trigger( "customCat");
        });
        jQuery("#cat-alias").on('input', function (e) {
            jQuery(this).trigger( "customCat");
        });
        //end
    }

    function checkSpecialChar(string){
        return string.replace(new RegExp('\\<', 'ig'),'').replace(new RegExp('\\>', 'ig'),'');
    }

    ///img settings function
    function imgSettingsFunctions(){
        //change img click function
        jQuery("#os-cat-tab-images div[id^='img-']").click(function(e){
            jQuery("#os-cat-tab-images div[id^='img-']").removeClass('active-img-block');
            jQuery(this).addClass('active-img-block');
            jQuery(".category-options-block a:first").tab('show');
            imageId = jQuery(this).data("image-id");

            //update settings
            imgSettings = parceOptions(jQuery("#img-settings-"+imageId).val());
            jQuery("#img-title").val(imgSettings.imgTitle || '');
            jQuery("#img-alias").val(imgSettings.imgAlias || '');
            jQuery("#img-short-description").val(imgSettings.imgShortDescription || '');
            jQuery("#img-alt").val(imgSettings.imgAlt || '');
            jQuery("#img-link").val(imgSettings.imgLink || '');
            jQuery("#img-link-open").val(imgSettings.imgLinkOpen || '_blank');

            //change options // maybe need improve on save. // now we save every option immediately when change value
            jQuery("#img-title, #img-alias, #img-short-description,"+
                    " #img-alt, #img-link, #img-link-open").on('customImg', function (e) {
                //get params from jsonString
                imgSettings = parceOptions(jQuery("#img-settings-"+imageId).val());
                imgSettings.imgTitle = checkSpecialChar(jQuery("#img-title").val());
                imgSettings.imgAlias = checkSpecialChar(jQuery("#img-alias").val());
                imgSettings.imgShortDescription = checkSpecialChar(jQuery("#img-short-description").val());
                imgSettings.imgAlt = checkSpecialChar(jQuery("#img-alt").val());
                imgSettings.imgLink = jQuery("#img-link").val();
                imgSettings.imgLinkOpen = jQuery("#img-link-open").val();

                //set params to Json
                jQuery("#img-settings-"+imageId).val(encodeURI(window.JSON.stringify(imgSettings)));
            });

            jQuery("#img-link-open").change(function(event) {
                jQuery(this).trigger( "customImg");
            });
            jQuery("#img-title, #img-alias, #img-short-description, #img-alt,#img-link").on('input', function (e) {
                jQuery(this).trigger( "customImg");
            });
            //end
        });
        //end
    }

    function optionsClickFunctions(){
        if(jQuery("input[name='watermark_type']").prop('checked')){
            jQuery("#watermark-image-block").show();
            jQuery("#watermark-text-block").hide();
        }else{
            jQuery("#watermark-image-block").hide();
            jQuery("#watermark-text-block").show();
        }
        jQuery("input[name='watermark_type']").change(function(event) {
            if(jQuery(this).val() == 1){
                jQuery("#watermark-image-block").show();
                jQuery("#watermark-text-block").hide();
            }else{
                jQuery("#watermark-image-block").hide();
                jQuery("#watermark-text-block").show();
            }
        });
        jQuery("[name='fancybox_arrows']").change(function(event) {
            if(jQuery(this).val() == 1){
                jQuery(".fancybox-arrows-pos-block").show("slow");
            }else{
                jQuery(".fancybox-arrows-pos-block").hide("slow");
            }
        });
    }

    function makeDeleteImage(){
        jQuery(".delete-image").click(function(event) {
            imgBlock = jQuery(this).parent();
            imgId = jQuery(imgBlock).data("image-id");
            jQuery(imgBlock).fadeOut(600, function(){ jQuery(this).remove();});
            jQuery("#adminForm").append('<input type="hidden" name="deletedImgIds[]" value="'+imgId+'">')
        });
    }

    jQuery(document).ready(function(){
        makeTabsCliked();
        makeCatSortable();
        makeDeleteImage();
        catSettingsFunctions();
        imgSettingsFunctions();
        optionsClickFunctions();
        jQuery("#osgalery-cat-tabs a:first,#osgalery-cat-tabs a:first,"+
                ".category-options-block a:last-child,.main-gallery-header a:first,.settings-nav-tabs a:first").tab('show');
        jQuery("#watermark-input").change(function(event) {
            var filename = jQuery('#watermark-input').val().replace(/C:\\fakepath\\/i, '')
            jQuery(".none-upload").html(filename);
        });

        if(jQuery("[name='galleryLayout']").val() != "defaultTabs"){
            jQuery(".cat-show-title-block").hide();
        }else{
            jQuery(".cat-show-title-block").show();
        }
        jQuery("[name='galleryLayout']").change(function(event) {
            if(jQuery(this).val() != "defaultTabs"){
                jQuery(".cat-show-title-block").hide();
            }else{
                jQuery(".cat-show-title-block").show();
            }
        });
        //init for free
            jQuery('.osg-pro-avaible').prop('disabled', 'disabled');
            jQuery('.osg-pro-avaible *').prop('disabled', 'disabled');
        //
        jQuery(".gallery-layout").change(function(event) {
            if(jQuery(this).val() == "albumMode"){
                jQuery(".back-button-text-block").show("slow");
            }else{
                jQuery(".back-button-text-block").hide("slow");
            }
        });
        jQuery("#system-message-container").addClass('gallery-main');
    });
    jQuery(window).scroll(function(){
        if(jQuery(window).scrollTop() >= 47) {
           jQuery(".category-options-block").addClass("category-options-block-fixed");
          } else {
           jQuery(".category-options-block").removeClass("category-options-block-fixed");
         }
    });
</script>