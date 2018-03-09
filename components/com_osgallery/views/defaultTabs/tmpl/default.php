<?php
/**
* @package OS Gallery
* @copyright 2016 OrdaSoft
* @author 2016 Andrey Kvasnevskiy(akbet@mail.ru),Roman Akoev (akoevroman@gmail.com)
* @license GNU General Public License version 2 or later;
* @description Ordasoft Image Gallery
*/


// No direct access to this file
defined('_JEXEC') or die('Restricted access');
if(count($images)){
?>
    <div class="os-gallery-tabs-main-<?php echo $galIds[0]?>">
        <ul class="osgalery-cat-tabs">
            <?php
            foreach($images as $catId => $catImages){
                $currentCatParams = new JRegistry;
                $currentCatParams = $currentCatParams->loadString(urldecode($catParamsArray[$catId]->params));
                if($currentCatParams->get("categoryUnpublish",false))continue;
                if($currentCatParams->get("categoryAlias",'')){
                    $catName = $currentCatParams->get("categoryAlias",'');
                }else if(isset($catImages[0])){
                    $catName = $catImages[0]->cat_name;
                }else{
                    $catName = 'no name';
                }
                ?>
                <li <?php echo (!$currentCatParams->get("categoryShowTitle",true))?'style="display:none;"':''?>>
                    <a href="#cat-<?php echo $catId?>"><?php echo $catName?></a>
                </li>
            <?php
            } ?>
        </ul>

        <div class="os-cat-tab-images">
            <?php
            foreach($images as $catId => $catImages){
                $currentCatParams = new JRegistry;
                $currentCatParams = $currentCatParams->loadString(urldecode($catParamsArray[$catId]->params));
                if($currentCatParams->get("categoryUnpublish",false))continue;
                if($currentCatParams->get("categoryAlias",'')){
                    $catName = $currentCatParams->get("categoryAlias",'');
                }else if(isset($catImages[0])){
                    $catName = $catImages[0]->cat_name;
                }else{
                    $catName = 'no name';
                }
                $styleImg = 'style="margin:'.$imageMargin.'px;"';
                $styleCat = 'style="padding:'.$imageMargin.'px;display:none!important;"';
                ?>
                <!-- Simple category mode-->
                <div id="cat-<?php echo $catId?>" data-cat-id="<?php echo $catId?>" <?php echo $styleCat?> >
                    <?php
                    if($catImages){
                        foreach($catImages as $image){
                            $currentImgParams = new JRegistry;
                            $currentImgParams = $currentImgParams->loadString(urldecode($imgParamsArray[$image->id]->params));
                            $imgAlt = ($currentImgParams->get("imgAlt",''))? $currentImgParams->get("imgAlt",'') : $image->file_name;
                            $imgTitle = $currentImgParams->get("imgTitle",'');
                            $imgShortDesc = $currentImgParams->get("imgShortDescription",'');
                            if($params->get("watermark_enable",false)){
                                $imgLink = JURI::root().'images/com_osgallery/gal-'.$image->galId.'/original/watermark/'.$image->file_name;
                            }else{
                                $imgLink = JURI::root().'images/com_osgallery/gal-'.$image->galId.'/original/'.$image->file_name;
                            }
                            $imgOpen = '';
                            if($currentImgParams->get("imgLink",'')){
                                $imgLink = $currentImgParams->get("imgLink");
                                $imgOpen = $currentImgParams->get("imgLinkOpen",'_blank');
                            }
                            if($currentImgParams->get("imgAlias",'')){
                                $imgAlias = $currentImgParams->get("imgAlias",'');
                            }else{
                                $imgAlias = $image->file_name;
                            }
                            ?>
                            <div class="img-block <?php echo $imageHover ?>-effect" <?php echo $styleImg ?> >

                                <a class="fancybox-<?php echo $catId?>"
                                    rel="group"
                                    target="<?php echo $imgOpen?>"
                                    href="<?php echo $imgLink?>"
                                    data-fancybox-title="<?php echo $imgAlias?>">
                                    <div class="os-gallery-caption">
                                        <?php
                                        if($imgTitle){
                                            echo "<h3 class='os-gallery-img-title'>$imgTitle</h3>";
                                        }
                                        if($catName && $currentCatParams->get("categoryShowTitleCaption",1)){
                                            echo "<p class='os-gallery-img-category'>$catName</p>";
                                        }
                                        if($imgShortDesc){
                                            echo "<p class='os-gallery-img-desc'>$imgShortDesc</p>";
                                        }
                                        ?>
                                    </div>
                                    <img src="<?php echo JURI::root()?>images/com_osgallery/gal-<?php echo $image->galId?>/thumbnail/<?php echo $image->file_name?>" alt="<?php echo $imgAlt?>">
                                    <span class='andrea-zoom-in'></span>
                                </a>
                            </div>

                        <?php
                        }
                    }?>
                </div>
                <!-- END simple mod-->
            <?php
            } ?>
        </div>
        <script>
            (function () {
                var osGallery<?php echo $galIds[0]?> = function (container, params) {
                    if (!(this instanceof osGallery<?php echo $galIds[0]?>)) return new osGallery<?php echo $galIds[0]?>(container, params);

                    var defaults = {
                        minImgEnable : 1,
                        spaceBetween: 2.5,
                        minImgSize: 200,
                        numColumns: 3,
                        fancSettings:{
                            wrapCSS: 'os-fancybox-window',
                            openEffect: '',
                            openSpeed: 500,
                            closeEffect: '',
                            closeSpeed: 500,
                            prevEffect: '',
                            nextEffect: '',
                            nextSpeed: 800,
                            prevSpeed: 800,
                            loop: 0,
                            closeBtn: 1,
                            arrows: 1,
                            arrowsPosition: 1,
                            nextClick: 0,
                            mouseWheel: 0,
                            autoPlay: 0,
                            playSpeed: 3000
                        }
                    };

                    for (var param in defaults) {
                      if (!params[param]){
                        params[param] = defaults[param];
                      }
                    }
                    // gallery settings
                    var osg = this;
                    // Params
                    osg.params = params || defaults;

                    osg.getImgBlockWidth = function (numColumns){
                        if(typeof(numColumns) == 'undefined')numColumns = osg.params.numColumns;
                        spaceBetween = osg.params.spaceBetween*2;
                        mainBlockW = jQuerGall(container).width();
                        imgBlockW = ((((mainBlockW-(spaceBetween*numColumns))/numColumns)-1)*100)/mainBlockW;
                        if(osg.params.minImgEnable){
                            if(((imgBlockW*mainBlockW)/100) < osg.params.minImgSize){
                                numColumns--;
                                osg.getImgBlockWidth(numColumns);
                            }
                        }

                        var sizeAwesome = ((imgBlockW*mainBlockW)/100)/11+"px";
                        jQuerGall(container +" .andrea-effect .andrea-zoom-in").css({'width': sizeAwesome, 'height': sizeAwesome });

                        var fontSizetext = ((imgBlockW*mainBlockW)/100)/15+"px";
                        jQuerGall(container +" .img-block").css({'font-size': fontSizetext, 'line-height': fontSizetext });

                        return imgBlockW;
                    }

                    //initialize function
                    osg.init = function (){
                        imgBlockW = osg.getImgBlockWidth();
                        jQuerGall(container+" .img-block").css("width",imgBlockW+"%");

                        jQuerGall(container+" .os-cat-tab-images div[id^='cat-']").each(function(index, el) {
                            catId = jQuerGall(this).data("cat-id");
                            if(catId){
                                jQuerGall(this).find(".fancybox-"+catId).fancybox({
                                    beforeShow: function(){
                                        if(osg.params.fancSettings.arrows && osg.params.fancSettings.arrowsPosition == 0 
                                            && !jQuerGall(".gallery-fanc-next").length){
                                            jQuerGall(".fancybox-nav.fancybox-prev,.fancybox-nav.fancybox-next").remove();
                                            html = '<span title="Previous" class="gallery-fanc-next" href="javascript:;"><span></span></span>';
                                            html+= '<span title="Next" class="gallery-fanc-prev" href="javascript:;"><span></span></span>';
                                            jQuerGall("body").prepend(html);
                                        }
                                    },
                                    beforeClose: function(){
                                        jQuerGall(".gallery-fanc-next,.gallery-fanc-prev").remove();
                                    },
                                    wrapCSS    : osg.params.fancSettings.wrapCSS,
                                    openEffect : osg.params.fancSettings.openEffect,
                                    openSpeed  : osg.params.fancSettings.openSpeed,

                                    closeEffect : osg.params.fancSettings.closeEffect,
                                    closeSpeed  : osg.params.fancSettings.closeSpeed,

                                    prevEffect : osg.params.fancSettings.prevEffect,
                                    nextEffect : osg.params.fancSettings.nextEffect,

                                    nextSpeed: osg.params.fancSettings.nextSpeed,
                                    prevSpeed: osg.params.fancSettings.prevSpeed,

                                    loop: osg.params.fancSettings.loop,
                                    closeBtn: osg.params.fancSettings.closeBtn,
                                    arrows: osg.params.fancSettings.arrows,
                                    arrowsPosition: osg.params.fancSettings.arrowsPosition,
                                    nextClick: osg.params.fancSettings.nextClick,
                                    mouseWheel: osg.params.fancSettings.mouseWheel,
                                    autoPlay: osg.params.fancSettings.autoPlay,
                                    playSpeed: osg.params.fancSettings.playSpeed,

                                    helpers : {
                                        <?php echo $fancybox_title?>
                                        <?php echo $fancybox_background?>
                                        <?php echo $helper_buttons?>
                                        <?php echo $helper_thumbnail?>
                                    }
                                });
                            }
                        });
                        jQuerGall(container+" .os-cat-tab-images div:first-child").show();
                        jQuerGall(container+" .osgalery-cat-tabs li:first-child a").addClass("active");

                        jQuerGall(container+" .osgalery-cat-tabs a").click(function(e) {
                            e.preventDefault();
                            jQuerGall('li a').removeClass("active");
                            jQuerGall(container+" .os-cat-tab-images>div").hide();
                            jQuerGall(this).addClass("active");
                            jQuerGall(jQuerGall(this).attr("href")).fadeTo(500, 1);
                        });

                        osg.resizeGallery = function (){
                            imgBlockW = osg.getImgBlockWidth();
                            jQuerGall(container+" .img-block").css("width",imgBlockW+"%");
                        }

                        jQuerGall(window).resize(function(event) {
                            osg.resizeGallery();
                        });
                    }
                    
                    osg.init();
                }
                window.osGallery<?php echo $galIds[0]?> = osGallery<?php echo $galIds[0]?>;
            })();
            jQuery(document).ready(function($) {
                var gallery = new osGallery<?php echo $galIds[0]?>(".os-gallery-tabs-main-<?php echo $galIds[0]?>",{
                    minImgEnable : <?php echo $minImgEnable?>,
                    spaceBetween: <?php echo $imageMargin?>,
                    minImgSize: <?php echo $minImgSize?>,
                    numColumns: <?php echo $numColumns?>,
                    fancSettings:{
                        wrapCSS: 'os-fancybox-window',
                        openEffect: "<?php echo $open_close_effect?>",
                        openSpeed: <?php echo $open_close_speed?>,
                        closeEffect: "<?php echo $open_close_effect?>",
                        closeSpeed: <?php echo $open_close_speed?>,
                        prevEffect: "<?php echo $prev_next_effect?>",
                        nextEffect: "<?php echo $prev_next_effect?>",
                        nextSpeed: <?php echo $prev_next_speed?>,
                        prevSpeed: <?php echo $prev_next_speed?>,
                        loop: <?php echo $loop?>,
                        closeBtn: <?php echo $close_button?>,
                        arrows: <?php echo $fancybox_arrows?>,
                        arrowsPosition: <?php echo $fancybox_arrows_pos?>,
                        nextClick: <?php echo $next_click?>,
                        mouseWheel: <?php echo $mouse_wheel?>,
                        autoPlay: <?php echo $fancybox_autoplay?>,
                        playSpeed: <?php echo $autoplay_speed?>
                    }
                });
            });
        </script>
        <noscript>Javascript is required to use OS Responsive Image Gallery<a href="http://ordasoft.com/os-responsive-image-gallery" title="OS Responsive Image Gallery">OS Responsive Image Gallery</a> with awesome layouts and nice hover effects, Drag&Drop, Watermark and stunning Fancybox features. 
        Tags: <a
         href="http://ordasoft.com/os-responsive-image-gallery">responsive image gallery</a>, joomla gallery, joomla responsive gallery, best joomla  gallery, image joomla gallery, joomla gallery extension, image gallery module for joomla 3, gallery component for joomla
        </noscript>
        <div class="copyright-block">
          <a href="http://ordasoft.com/" class="copyright-link">&copy;2016 OrdaSoft.com All rights reserved. </a>
        </div>
    </div>
<?php
}