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
JHtml::stylesheet(Juri::root() . 'media/com_gallery/style/simple-slider1.css');
JHtml::stylesheet(Juri::root() . 'media/com_gallery/style/simple-slider_sl.css');
$doc = JFactory::getDocument();
$editor = JFactory::getEditor('tinymce');
$doc->addScript(JURI::root(true) . "/media/com_gallery/js/param_block.js");
JHTML::_('behavior.modal');
?>
<script src="<?php echo JURI::root(true) ?>/media/com_gallery/js/admin.js"></script>
<script src="<?php echo JURI::root(true) ?>/media/com_gallery/js/simple-gallery.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js" ></script>
<script src="<?php echo JURI::root(true) ?>/media/media/js/mediafield-mootools.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var time = 0;
    par_images = [];
    Joomla.submitbutton = function(pressbutton)
    {
        if (document.adminForm.name.value == '' && pressbutton != 'cancel')
        {
            alert('Name is required.');
            document.adminForm.name.focus();
        }
        else
            submitform(pressbutton);
    }
</script>

<script type="text/javascript">
    var image_base_path = '<?php
	$params = JComponentHelper::getParams('com_media');
	echo $params->get('image_path', 'images');
?>/';
    function submitbutton(pressbutton)
    {
        if (!document.getElementById('name').value) {
            alert("Name is required.");
            return;
        }

        document.getElementById("adminForm").action = document.getElementById("adminForm").action + "&task=" + pressbutton;
        document.getElementById("adminForm").submit();
    }
    function change_select() {
        submitbutton('apply');
    }
    jQuery(function() {
        jQuery("#images-list").sortable({
            stop: function() {
                jQuery("#images-list > li").removeClass('has-background');
                count = jQuery("#images-list > li").length;
                for (var i = 0; i <= count; i += 2) {
                    jQuery("#images-list > li").eq(i).addClass("has-background");
                }
                jQuery("#images-list > li").each(function() {
                    jQuery(this).find('.order_by').val(count - jQuery(this).index());
                });
            },
            revert: true
        });

    });

jQuery(document).ready(function(){

    jQuery('ul.widget-images-list li a.modal').on('click',function(){
        var num = jQuery(this).data('number');
        var id = jQuery(this).data('id');
            jQuery('ul.widget-images-list li a input.edit-image').on('change',function(){
                getImage('<?php echo $_SERVER['HTTP_HOST'] . JURI::root(true) ?>',id ,num ,false,true);
            });

    })


    });

</script>


<div style="clear: both;"></div>
<form action="<?php echo JRoute::_('index.php?option=com_gallery&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm"  enctype="multipart/form-data">
    <div id="poststuff" >
        <div id="gallery-header">
            <ul id="gallerys-list" style="margin:0px">
                <?php
                foreach ($this->galleryParams as $rowsldires) {
                    if ($rowsldires->id != $this->item->id) {
                        ?>
                        <li>
                            <a href="#" onclick="window.location.href = 'index.php?option=com_gallery&view=gallery&layout=edit&id=<?php echo $rowsldires->id; ?>'" ><?php echo $rowsldires->name; ?></a>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li class="active" style='background-image:url("<?= JURI::root() . 'media/com_gallery/images/edit.png' ?>")'>
                            <input class="text_area" onfocus="this.style.width = ((this.value.length + 1) * 8) + 'px'" type="text" name="name" id="name" maxlength="250" value="<?php echo stripslashes($this->item->name); ?>" />
                        </li>
                        <?php
                    }
                }
                ?>
                <li class="add-new">
                    <a onclick="window.location.href = 'index.php?option=com_gallery&view=gallery&task=galleries.add'">+</a>
                </li>
            </ul>
        </div>
        <div id="post-body-wrapper" class="metabox-holder columns-2">
            <div id="post-body-heading">
                <input type="hidden" name="imagess" id="_unique_name" />
                <div class="huge-it-newuploader uploader button button-primary add-new-image">
                    <a class="modal" title="Image" href="index.php?option=com_media&view=images&tmpl=component&e_name=tempimage&amp;fieldid=_unique_name_button"  rel="{handler: 'iframe', size: {x: 800, y: 500}}">
                            <div class="button2-left" style="float: left">
							   <div class="blank">
                                <input  type="hidden" class= "btn btn-small btn-success"   name="_unique_name_button" id="_unique_name_button"
                                       onchange="getImage('<?php echo $_SERVER['HTTP_HOST'] . JURI::root(true) ?>', <?php echo JRequest::getVar('id'); ?>, null, true);"
                                />
                                <input  type="button" class="btn btn-small btn-success"   value="Add Image" />
                            </div>
                        </div>
                    </a>
					<?php

                    $prod_id = intval($_GET['id']);
                    if(!$prod_id){
                        $prod_id = 1;
                    }
                    

                    ?>

                    <a class="modal" rel="{handler: 'iframe', size: {x: 800, y: 500}}" href="index.php?option=com_gallery&view=video&tmpl=component&pid=<?php echo $prod_id; ?>" title="Image" >
                         <div class="button2-left" style="float: left;margin-left:5px;">
                                   <div class="blank">
                                <input type="button" class= "btn btn-small btn-success" class="hugeitbutton" class="button wp-media-buttons-icon"   name="_unique_name_button" id="_unique_name_button" value="Add Video" />
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="j-sidebar-container" class="j-sidebar-container j-sidebar-visible" style="border-top:1px solid #ccc;  margin: 0px 0 0 -1px;width: 18%;float: left;">
        <div id="j-toggle-sidebar-wrapper">
            <div id="j-toggle-button-wrapper" class="j-toggle-button-wrapper j-toggle-visible">
                <div id="j-toggle-sidebar-button" class="j-toggle-sidebar-button hidden-phone hasTooltip" title="" type="button" onclick="toggleSidebar(false); return false;" data-original-title="Hide the sidebar">
                </div>
	</div>
	
	<div id="sidebar" class="sidebar">
            <div class="sidebar-nav">
               <ul id="submenu" class="nav nav-list">
                    <li class="active">
                            <a href="index.php?option=com_gallery">Huge-IT Gallery</a>
                    </li>
                    <li>
                            <a href="index.php?option=com_gallery&amp;view=general">General Options</a>
                    </li>
                     <li>
                            <a href="index.php?option=com_gallery&amp;view=lightbox">Lightbox Options</a>
                    </li>
                    <li>
                            <a href="index.php?option=com_gallery&amp;view=featured">Featured Products</a>
                    </li>
                </ul>
                <div class="filter-select hidden-phone" style="margin:10px 0 0 0">
                    <h4 class="page-header" style="border-bottom: 1px solid #ccc">Select The Gallery View</h4>
                 <ul id="gallery-unique-options-list">
                        <li>
                            <label for="huge_it_sl_effects" s>Views</label>
                            <select name="huge_it_sl_effects" id="huge_it_sl_effects"  onchange="galleryView()">
                                <option <?php if ($this->item->huge_it_sl_effects == '0') {
                                                                    echo 'selected';
                                    } ?>  value="0">Gallery/Content-Popup</option>
                                                                    <option <?php if ($this->item->huge_it_sl_effects == '1') {
                                        echo 'selected';
                                    } ?>  value="1">Content Slider</option>
                                                                    <option <?php if ($this->item->huge_it_sl_effects == '5') {
                                        echo 'selected';
                                    } ?>  value="5">Lightbox-Gallery</option>
                                                                    <option <?php if ($this->item->huge_it_sl_effects == '3') {
                                        echo 'selected';
                                    } ?>  value="3">Slider</option>
                                                                    <option <?php if ($this->item->huge_it_sl_effects == '4') {
                                        echo 'selected';
                                    } ?>  value="4">Thumbnails View</option>
                                                                    <option <?php if ($this->item->huge_it_sl_effects == '6') {
                                        echo 'selected';
                                    } ?>  value="6">Justified</option>
                                                                    
                            </select>
                        </li>
                    </ul>
    <div id="gallery-current-options-3" class="gallery-current-options <?php if ($this->item->huge_it_sl_effects == 3) {
    echo ' active';
} ?>">
                  <ul id="gallery-unique-options-list" >
                                <li>
                                    <label for="sl_width">Width</label>
                                    <input type="text" name="sl_width" id="sl_width" value="<?php echo $this->item->sl_width; ?>" class="text_area" />
                                </li>
                                <li>
                                    <label for="sl_height" >Height</label>
                                    <input type="text" name="sl_height" id="sl_height" value="<?php echo $this->item->sl_height; ?>" class="text_area" />
                                </li>
                                <li>
                                    <label for="pause_on_hover">Pause on hover</label>
                                    <input type="hidden" value="off" name="pause_on_hover" />					
                                    <input type="checkbox" name="pause_on_hover"  value="on" id="pause_on_hover"  <?php if ($this->item->pause_on_hover == 'on') {
    echo 'checked="checked"';
} ?> />
                                </li>
                                <li style="margin-top:10px;">
                                    <label for="gallery_list_effects_s" >Effects</label>
                                    <select name="gallery_list_effects_s" id="gallery_list_effects_s">
                                        <option <?php if ($this->item->gallery_list_effects_s == 'none') {
    echo 'selected';
} ?>  value="none">None</option>
                                        <option <?php if ($this->item->gallery_list_effects_s == 'cubeH') {
    echo 'selected';
} ?>   value="cubeH">Cube Horizontal</option>
                                        <option <?php if ($this->item->gallery_list_effects_s == 'cubeV') {
    echo 'selected';
} ?>  value="cubeV">Cube Vertical</option>
                                        <option <?php if ($this->item->gallery_list_effects_s == 'fade') {
    echo 'selected';
} ?>  value="fade">Fade</option>
                                        <option <?php if ($this->item->gallery_list_effects_s == 'sliceH') {
    echo 'selected';
} ?>  value="sliceH">Slice Horizontal</option>
                                        <option <?php if ($this->item->gallery_list_effects_s == 'sliceV') {
    echo 'selected';
} ?>  value="sliceV">Slice Vertical</option>
                                        <option <?php if ($this->item->gallery_list_effects_s == 'slideH') {
    echo 'selected';
} ?>  value="slideH">Slide Horizontal</option>
                                        <option <?php if ($this->item->gallery_list_effects_s == 'slideV') {
    echo 'selected';
} ?>  value="slideV">Slide Vertical</option>
                                        <option <?php if ($this->item->gallery_list_effects_s == 'scaleOut') {
    echo 'selected';
} ?>  value="scaleOut">Scale Out</option>
                                        <option <?php if ($this->item->gallery_list_effects_s == 'scaleIn') {
            echo 'selected';
        } ?>  value="scaleIn">Scale In</option>
                                        <option <?php if ($this->item->gallery_list_effects_s == 'blockScale') {
            echo 'selected';
        } ?>  value="blockScale">Block Scale</option>
                                        <option <?php if ($this->item->gallery_list_effects_s == 'kaleidoscope') {
            echo 'selected';
        } ?>  value="kaleidoscope">Kaleidoscope</option>
                                        <option <?php if ($this->item->gallery_list_effects_s == 'fan') {
            echo 'selected';
        } ?>  value="fan">Fan</option>
                                        <option <?php if ($this->item->gallery_list_effects_s == 'blindH') {
            echo 'selected';
        } ?>  value="blindH">Blind Horizontal</option>
                                        <option <?php if ($this->item->gallery_list_effects_s == 'blindV') {
            echo 'selected';
        } ?>  value="blindV">Blind Vertical</option>
                                        <option <?php if ($this->item->gallery_list_effects_s == 'random') {
            echo 'selected';
        } ?>  value="random">Random</option>
                                    </select>
                                </li>

                                <li>
                                    <label for="sl_pausetime">Pause time</label>
                                    <input type="text" name="sl_pausetime" id="sl_pausetime" value="<?php echo $this->item->description; ?>" class="text_area" />
                                </li>
                                <li>
                                    <label for="sl_changespeed">Change speed</label>
                                    <input type="text" name="sl_changespeed" id="sl_changespeed" value="<?php echo $this->item->param; ?>" class="text_area" />
                                </li>
                                <li>
                                    <label for="gallery_position">Slider Position</label>
                                    <select name="sl_position" id="gallery_position">
                                        <option <?php if ($this->item->sl_position == 'left') {
            echo 'selected';
        } ?>  value="left">Left</option>
                                        <option <?php if ($this->item->sl_position == 'right') {
            echo 'selected';
        } ?>   value="right">Right</option>
                                        <option <?php if ($this->item->sl_position == 'center') {
            echo 'selected';
        } ?>  value="center">Center</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
        
                    
        <script>
            window.onload = galleryView; // 1,3
            window.onload = setOptions; 
                function galleryView() {
                    var huge_it_sl_effects = document.getElementById('huge_it_sl_effects').value;
                    var view7 = document.getElementById('view7');
                    if(huge_it_sl_effects == 1 || huge_it_sl_effects == 3) {
                        view7.style.display = "none";
                    } else {
                        view7.style.display = "block";
                    }
                }
                
                function setOptions(){   
                    var display_type = document.getElementById('display_type').value;
                    var content_per_page = document.getElementById('content_per_page');
                    
                    if(display_type != 2) {
                        
                        content_per_page.style.display = "block";
                    } else {
                        content_per_page.style.display = "none";
                    }
                }
          
        </script>

        <div class="">
        <div id="view7">
            <ul style="margin: 0px; padding:0px">				
            <li>
                <label for="display_type">Displaying Content</label>
                <select id="display_type" name="display_type" style="width: 57%" onchange="setOptions()">
                        <option <?php if($this->item->display_type == 0){ echo 'selected'; } ?>  value="0">Pagination</option>
                        <option <?php if($this->item->display_type == 1){ echo 'selected'; } ?>   value="1">Load More</option>
                        <option <?php if($this->item->display_type == 2){ echo 'selected'; } ?>   value="2">Show All</option>
                </select>
            </li>
            <li>
                <div id="content_per_page">
                <label for="content_per_page">Images Per Page</label>
                <input type="text" name="content_per_page" id="content_per_page" value="<?php echo $this->item->content_per_page; ?>" class="text_area"  style="width: 51%"/>
                </div>
            </li>
						
            </ul>
        </div>
        </div>
    </div>
    <div class="filter-select hidden-phone">
        <h4 class="page-header">Shortcodes:</h4>
            <div class="inside">
                <ul style="padding: 0px;margin:0px;">
                    <li>
                        <div class="shortcodeText"><p>Copy &amp; paste the shortcode directly into any Joomla article.</p></div>
                        <textarea class="full" readonly="readonly" style="width: 95%">[huge_it_gallery id="<?php echo $this->item->id?>"]</textarea>
                    </li>

                </ul>
                            </div>
    </div>
                 <hr class="hr-sidebar">
    <div id="catalog-shortcode-box" class="postbox shortcode ms-toggle">
        <div class="inside">
            <ul style="margin: 0 0 9px 12px;">
                <li rel="tab-1" class="selected">
                    <h4 class="page-header">Template Include</h4>
                    <div class="shortcodeText">
                    <p><?php echo "Copy & paste this code into a template file to include the gallery within your theme.";?></p>
                    <textarea class="full" readonly="readonly" style="width: 90%">&lt;?php echo huge_it_gallery_id(<?php echo $this->item->id; ?>); ?&gt;</textarea>
                    </div>
                </li>
            </ul>
        </div>
   </div>
                
    </div>
					</div>
	</div>
	<div id="j-toggle-sidebar"></div>
</div>
	
		
<div id="j-main-container" class="span10 j-toggle-main">
	 <div id="post-body-content" >
            <ul id="images-list">
                <?php

              	function get_youtube_id_from_url($url){						
                    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
                        return $match[1];
                    }
                }
                ?>
                <?php $j = 2; ?>
                <?php foreach ($this->prop as $key => $rowimages) : ?>
                    <?php
                    if ($rowimages->sl_type == '') {
                        $rowimages->sl_type = 'image';
                    }
                    switch ($rowimages->sl_type) {
                        case 'image':
                            ?>
                            <li <?php
                            if ($j % 2 == 0) {
                                echo "class='has-background'";
                            }$j++;
                            ?>>
                                <input class="order_by" type="hidden" name="order_by_<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->ordering; ?>" />
                                <div deleteId = '1' id="sel_img<?php echo $rowimages->id; ?>" class="image-container">
                                    <ul  class="widget-images-list" style="margin: 0px"> 
                                        <?php
                                        $imgurl = $rowimages->image_url;
                                        $image = explode('/',$imgurl);
                                        if($image[0] == 'http:' || $image[0] == 'https:'){
                                            $serv = '';
                                        }
                                        else{
                                            $serv = juri::root();
                                        }
                                        $i = 1;
                                        ?>
                                        <script type="text/javascript">
                                            url = '<?php echo $_SERVER['HTTP_HOST'] . JURI::root(true) ?>';
                                            par_images[<?php echo $rowimages->id; ?>] = new Array('<?php echo $imgurl; ?>');
                                        </script>
                                        
                                        <li id = "editthisimage_<?php echo $i; ?>_<?php echo $rowimages->id; ?>" class="editthisimage<?php echo $key; ?> first" onclick="jInsertFieldValue('', 'jform_images_image_intro'); return false;">
                                            <img id="sel_img_<?php echo $i; ?>"  value="<?php echo  $imgurl; ?>" src="<?php echo  $serv.$imgurl; ?>"   title="<?php echo $rowimages->img_title; ?>" />
                                            <div  class="editimageicon" >
                                                <a class="modal"  data-number="<?php echo $i;?>"  data-id="<?php echo $rowimages->id;?>" href="index.php?option=com_media&view=images&tmpl=component&e_name=tempimage&amp;fieldid=unique_name_button<?php echo $i; ?>"  rel="{handler: 'iframe',size: {x: 800, y: 500}}">
                                                    Edit Image
                                                    <input type="hidden" class="edit-image" id="unique_name_button<?php echo $i; ?>" value="+"   />
                                                </a>
                                            </div>
                                        </li>
                                    </ul>                     
                                </div>
                              
                                
                                
                                <input hidden title = "<?php echo $rowimages->img_title; ?>"  id= "image_url<?php echo $rowimages->id; ?>" name="image_url<?php echo $rowimages->id; ?>" value='<?php echo $rowimages->image_url; ?>'/>
                                <input hidden  name="title<?php echo $rowimages->id; ?>" value='<?php echo $rowimages->img_title; ?>' id='title<?php echo $rowimages->id; ?>'/>

                                <div class="image-options">
                                    <div>
                                        <div for="titleimage<?php echo $rowimages->id; ?>" class="slidetTitle">Title:</div>
                                        <input  style="margin-left: 93px; width:83% !important" class="text_area" type="text" id="titleimage<?php echo $rowimages->id; ?>" name="titleimage<?php echo $rowimages->id; ?>" id="titleimage<?php echo $rowimages->id; ?>"  value="<?php echo $rowimages->name; ?>">
                                    </div>
                                    <div class="description-block" >
                                        <div for="im_description<?php echo $rowimages->id; ?>" class="slidetTitle">Description:</div>
                                        <textarea filter="raw" style="margin-left:55px;"  id="im_description<?php echo $rowimages->id; ?>" name="im_description<?php echo $rowimages->id; ?>" >
                                        	<?php echo $rowimages->description; ?>
                                    	</textarea>
                                    </div>
                                    <div class="link-block">
                                        <div class="slidetTitle" for="sl_url<?php echo $rowimages->id; ?>">URL:</div>
                                        <input  style="margin-left: 96px; width: 83% !important "  class="text_area url-input" type="text" id="sl_url<?php echo $rowimages->id; ?>" name="sl_url<?php echo $rowimages->id; ?>"  value="<?php echo $rowimages->sl_url; ?>" >
                                        <div class="long" for="sl_link_target<?php echo $rowimages->id; ?>">
                                            <span>Open in new tab</span>
                                            <input type="hidden" name="sl_link_target<?php echo $rowimages->id; ?>" value="" />
                                            <input  style="position: relative;top: 3px; left:30px"<?php
                                            if ($rowimages->link_target == 'on') {
                                                echo 'checked="checked"';
                                            }
                                            ?>  class="link_target" type="checkbox" id="sl_link_target<?php echo $rowimages->id; ?>" name="sl_link_target<?php echo $rowimages->id; ?>" />
                                        </div>
                                    </div>
                                    <div >
                                        <a class="button remove-image" href="index.php?option=com_gallery&view=gallery&layout=edit&id=<?php echo $this->item->id ?>&task=gallery.deleteProject&removeslide=<?php echo $rowimages->id; ?>">Remove Image</a>
                                    </div>                                      
                                </div>
                                <div class="clear"></div>
                            </li>

                            <?php break;
                        case 'video':
                            ?>
                            <li  <?php
                                if ($j % 2 == 0) {
                                    echo "class='has-background'";
                                }$j++;
                                ?>  >
                                <input class="order_by" type="hidden" name="order_by_<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->ordering; ?>" />
                                <?php
                                if (strpos($rowimages->image_url, 'youtube') !== false || strpos($rowimages->image_url, 'youtu') !== false) {
                                    $liclass = "youtube";
                                    $video_thumb_url = get_youtube_id_from_url($rowimages->image_url);
                                    $thumburl = '<img src="http://img.youtube.com/vi/' . $video_thumb_url . '/mqdefault.jpg" alt="" />';
                                } else if (strpos($rowimages->image_url, 'vimeo') !== false) {
                                    $liclass = "vimeo";
                                    $vimeo = $rowimages->image_url;
                                    $vimeo = explode("/", $vimeo);
                                    $imgid = end($vimeo);
                                    $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/" . $imgid . ".php"));
                                    $imgsrc = $hash[0]['thumbnail_large'];
                                    $thumburl = '<img src="' . $imgsrc . '" alt="" />';
                                }										
                                ?> 
            <?php if (isset($thumburl)) { ?>
                                    <div class="image-container" >	
                <?php echo $thumburl; ?>
                                        <div class="play-icon <?php echo $liclass; ?>"></div>
                                        <div>
                                            <input type="hidden" name="imagess<?php echo $rowimages->id; ?>" value="<?php echo $rowimages->image_url; ?>" />
                                        </div>
                                    </div> <?php } ?>
                                <div class="image-options">
                                    <div>
                                        <input type="hidden" value="<?= $rowimages->image_url ?>" name="videoUrl"  style="width: 10px;"/>
                                        <input hidden="" id= "image_url<?php echo $rowimages->id; ?>" name="image_url<?php echo $rowimages->id; ?>" value='<?php echo $rowimages->image_url; ?>'/>
                                        <label for="titleimage<?php echo $rowimages->id; ?>">Title:</label>
                                        <input  class="text_area" type="text" id="titleimage<?php echo $rowimages->id; ?>" name="titleimage<?php echo $rowimages->id; ?>" id="titleimage<?php echo $rowimages->id; ?>"  value="<?php echo $rowimages->name; ?>" style="width:83% !important;">
                                    </div>
                                    <div class="description-block">
                                        <label for="im_description<?php echo $rowimages->id; ?>">Description:</label>
                                        <textarea filter="raw" id="im_description<?php echo $rowimages->id; ?>" name="im_description<?php echo $rowimages->id; ?>" ><?php echo $rowimages->description; ?></textarea>
                                    </div>
                                    
                                    
                                    
                                    <div class="link-block">
                                        <label for="sl_url<?php echo $rowimages->id; ?>">URL:</label>
                                        <input class="text_area url-input" type="text" id="sl_url<?php echo $rowimages->id; ?>" name="sl_url<?php echo $rowimages->id; ?>"  value="<?php echo $rowimages->sl_url; ?>" style="width:83% !important" >
                                        <label class="long" for="sl_link_target<?php echo $rowimages->id; ?>" >
                                            <span>Open in new tab</span>
                                            <input type="hidden" name="sl_link_target<?php echo $rowimages->id; ?>" value="" />
                                            <input  <?php
                                    if ($rowimages->link_target == 'on') {
                                        echo 'checked="checked"';
                                    }
                                    ?>  class="link_target" type="checkbox" id="sl_link_target<?php echo $rowimages->id; ?>" name="sl_link_target<?php echo $rowimages->id; ?>" />
                                        </label>
                                    </div>
                                    <div class="remove-image-container">
                                        <a style = "float:right;margin-right: 55px;" class="removeVideoColor" href="index.php?option=com_gallery&view=gallery&layout=edit&id=<?php echo $this->item->id ?>&task=gallery.deleteProject&removeslide=<?php echo $rowimages->id; ?>">Remove Video</a>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </li>
            <?php
            break;
    } endforeach;
?>
            </ul>  

            <div style=" position:absolute; width:1px; height:1px; top:0px; overflow:hidden">
                <textarea id="tempimage" name="tempimage" class="mce_editable"></textarea><br />
            </div>
<?php
$editor->display('description', 'sss', '0', '0', '0', '0');
?>
        </div>	
</div>
    <div>
        <input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>
    </div>

</form>
