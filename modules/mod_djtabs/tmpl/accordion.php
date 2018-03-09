<?php
/**
 * @version 1.0
 * @package DJ-Tabs
 * @copyright Copyright (C) 2013 DJ-Extensions.com, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Piotr Dobrakowski - piotr.dobrakowski@design-joomla.eu
 *
 * DJ-Tabs is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-Tabs is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-Tabs. If not, see <http://www.gnu.org/licenses/>.
 *
 */
 
defined ('_JEXEC') or die('Restricted access');
JHTML::_('behavior.framework','More'); 

if (isset($module))
	$mod_prefix = 'mod'.$module->id.'_';
else 
	$mod_prefix = $params->get('prefix','modArt').'_';//'modArt_';
?>

<img id="<?php echo $mod_prefix; ?>djtabs_loading" src="components/com_djtabs/assets/images/ajax-loader.gif" alt="loading..." />


<div id="<?php echo $mod_prefix; ?>djtabs" class="djtabs <?php echo ($params->get('class_theme_title')); ?> accordion" style="visibility:hidden">


		<?php    
		$tab_i = 0;
        foreach($tabs  as $tab){
        	 $tab_i++; ?>
        	 	<div class="djtabs-title-wrapper">
        	        <div id="<?php echo $mod_prefix; ?>djtab<?php echo $tab_i; ?>" class="djtabs-title djtabs-accordion <?php echo $mod_prefix; ?>djtabs_help_class">
        	        <?php $tab_custom_html = $tab->params->get('tab_custom_html','');
					if ($tab_custom_html !=''){
					?>
	                	<div class="djtab-custom-html">
	                		<?php  echo $tab_custom_html; ?>
	                	</div>
                	<?php  } ?>
                	<span class="djtab-text" title="<?php echo $tab->name; ?>">
                		<?php
                		$tab_icon = $tab->params->get('tab_icon','');
                		if ($tab_icon!=''){ ?>
                			<i class="<?php  echo $tab_icon; ?> "></i>&nbsp;
              			<?php  } ?>
                		<?php echo $tab->name; ?></span>
                	<?php /*
                	<span id="<?php echo $mod_prefix; ?>djtabs_title_img_right<?php echo $tab_i; ?>" class="djtabs-title-img-right"> </span>*/ ?></div>
                </div>	
                	<div class="djclear"></div>
					<div class="djtabs-in-border"> 
					<div class="djtabs-in">
                	
                    <div class="djtabs-body accordion-body djclear <?php switch($tab->type){
                	case 1: echo 'type-article-category'; break;
                	case 2: echo 'type-article'; break;
					case 3: echo 'type-module'; break;
					case 4: echo 'type-video'; break; 
					}?>">
                <?php   
                    if($tab->type==1){
                    	$art_display=$tab->params->get('articles_display','1');
						if ($art_display=='1')
							$accordion_classes=$mod_prefix."accordion_help_class accordion_first_out";
						else if ($art_display=='2')
							$accordion_classes=$mod_prefix."accordion_help_class accordion_all_in";
						else
							$accordion_classes="";
                    	?>
                    <div id="<?php echo $mod_prefix; ?>djtabs_accordion<?php echo $tab_i; ?>" class="<?php echo $accordion_classes; ?> djtabs-body-in">                           
                        <?php 
                        $art_i = 0;
						$art_per_row = $tab->params->get('articles_per_row','1');
						$art_per_row = (is_numeric($art_per_row) && $art_per_row !='0') ? $art_per_row : '1';
						if ($art_per_row!='1' && $art_display=='3'){
							$art_space = $tab->params->get('articles_space','0');
							$art_space = is_numeric($art_space) ? $art_space : '0';	
							$art_width = (100-(($art_per_row-1) * $art_space))/$art_per_row;
							$art_width = "width:".$art_width."%;";
							$art_space = "margin-right:".$art_space."%;";
						}
						else {
							$art_width=""; $art_space = "";
						}
                        foreach($tab->content as $con){
                        	$art_i++;
                        	?> 
                        	<div class="djtabs-article-group<?php echo (($tab->params->get('articles_display','1')==3) ? ' djtabs-article-out' : '');?>"  
                        	style="<?php echo $art_width; ?><?php if ($art_i%$art_per_row) echo $art_space; ?>">
                        	<div class="djtabs-panel">
	                            <?php          
	                        $intro_title = strip_tags($con->title);
							$intro_title_limit = $tab->params->get('title_char_limit','0');
							$intro_title_limit = is_numeric($intro_title_limit) ? $intro_title_limit : '0';
							if ($intro_title_limit!='0' && $intro_title_limit < strlen($intro_title))
								$intro_title = mb_substr($intro_title,0,$intro_title_limit).'...';                                    
	                        ?>                                                                                     
	                        <?php if($con->show_create_date && $tab->params->get('date_position','1')=='1'){ ?>
						 	<span class="djtabs-panel-date">
                            <?php echo date("y.m.d", strtotime($con->created)); ?>
                            </span>
                        	<?php } 
	                                	 if($con->show_title){ ?>
	                                	<span title="<?php echo strip_tags($con->title); ?>" class="djtabs-panel-title">
	                                <?php if($con->link_titles){                                                                                                  
	                                        echo '<a style="color:inherit" href="'.$con->link.'">';                                                                                                                   
	                                            echo $intro_title;
	                                        echo '</a>';
	                                    }else{
	                                        echo $intro_title;
	                                    } 
	                                     }?>
	                                     </span>
	                                     <?php if ($art_display!='3'){ ?>
	                                     <span class="djtabs-panel-toggler"></span>
	                                	 <?php } ?>
	                                
	                                
	                                <?php //} ?>
							</div>
	                                <div class="djtabs-article-body">

	                            <div class="djtabs-article-content">
	                            	<?php if($con->show_create_date && $tab->params->get('date_position','1')=='2'){ ?>
						 	<span class="djtabs-date-in">
                            <?php echo date($tab->params->get('date_format','l, d F Y'), strtotime($con->created)); ?>
                            </span>
	                            <?php }
                            	if($tab->params->get('image',0)){
	                            	$images = new JRegistry();
			 						$images->loadString($con->images);
									$img_w = $tab->params->get('image_width',0);
									$img_h = $tab->params->get('image_height',0);
									$image_type = $tab->params->get('image')== '2' ? 'image_fulltext' : 'image_intro';
									if($images->get($image_type)){  
									if($tab->params->get('image_link',0)){
										?> 
										<a href="<?php echo $con->link; ?>"> <?php } ?>
	
                            <img class="djtabs-article-img <?php $img_pos=$tab->params->get('image_position',1);
                            if($img_pos==1) echo "dj-img-left"; 
                            else if($img_pos==2) echo "dj-img-right";
							else echo "dj-img-top"; ?>" src="<?php echo $images->get($image_type);?>" 
                            <?php if($img_w>0) echo 'width="'.$img_w.'"';?> 
                            <?php if($img_h>0) echo 'height="'.$img_h.'"';?> alt="<?php echo $image_type;?>" />
                            
              <?php if($tab->params->get('image_link',0)){ ?> </a> <?php } ?>
                            
                            <?php    } }               	
	                      	if ($tab->params->get('HTML_in_description',1))
								$intro_desc = $con->introtext;
							else if ($tab->params->get('description_char_limit')=='')
								$intro_desc = strip_tags($con->introtext);
							else
	                      		$intro_desc = mb_substr(strip_tags($con->introtext),0,$tab->params->get('description_char_limit')).'...';        	
	                      //$intro_desc = mb_substr(strip_tags($con->introtext),0,$tab->params->get('description_char_limit','500'));
                          if($tab->params->get('description','1') && $intro_desc){ ?>
	                            <?php if($tab->params->get('description_link','1')){
	                                    echo '<a style="color:inherit" href="'.$con->link.'">';                                                                       
	                                        echo $intro_desc;
	                                    echo '</a>';
										
	                                }else{
	                                    echo $intro_desc;
	                                }
									?><?php                            
	                     if($con->show_readmore && $con->link) { ?>
								<span class="djtabs-readmore">
		<a href="<?php echo $con->link; ?>" >
			<?php echo ($tab->params->get('readmore_text',0) ? $tab->params->get('readmore_text') : JText::_('COM_DJTABS_READMORE')); ?>			
		</a>
								</span>
								 <?php 
	                        }} ?>
	                            </div>
	                        <?php if($con->show_author || $con->show_category){ ?>
	                        <div class="djtabs-article-footer">
	                        <?php   
						  if($con->show_author){ ?>
                            <div class="djtabs-article-author">
                            	<?php  echo $con->author;?>	                    
	                        </div> 
	                      <?php }
							if($con->show_category){ ?>
						 	<div class="djtabs-article-category">
                            <?php if($con->link_category){
                                    echo '<a href="'.$con->cat_link.'">';                                                                      
                                        echo $con->category_title;
                                    echo '</a>';
                                }else{
                                    echo $con->category_title;
                                } ?>
                            </div>                  
                        	<?php  }  ?>
                        	</div>
                        	<?php } ?>
	                      </div>
	                      </div>  
                       <?php }  ?> 
                        </div>                                                                                               
                    <?php
                	}else if($tab->type==2){ ?>
                        <div class="djtabs-body-in djtabs-article-body-in">
                        	<div class="djtabs-article-group djtabs-group-active">
                        	<?php if($tab->content->params->get('show_create_date','1')=='1' || $tab->content->params->get('show_title','1')=='1'){ ?>
                        	<div class="djtabs-panel djtabs-panel-active djtabs-panel-article">
                          <?php                  
                          	$intro_title = strip_tags($tab->content->title);
							$intro_title_limit = $tab->params->get('title_char_limit','0');
							$intro_title_limit = is_numeric($intro_title_limit) ? $intro_title_limit : '0';
							if ($intro_title_limit!='0' && $intro_title_limit < strlen($intro_title))
								$intro_title = mb_substr($intro_title,0,$intro_title_limit).'...';                             
                          //if(($tab->content->params->get('show_title','1') && $intro_title) || $tab->content->params->get('show_create_date','1')){ ?>
                             
                           <?php if($tab->content->params->get('show_create_date','1') && $tab->params->get('date_position','1')=='1'){ ?>
						 	<span class="djtabs-panel-date">
                            <?php echo date("y.m.d", strtotime($tab->content->created)); ?>
                            </span>
                        	<?php
						  				}
						   if($tab->content->params->get('show_title','1')){ ?>
									     <span title="<?php echo strip_tags($tab->content->title); ?>" class="djtabs-panel-title">
	                                	<?php if($tab->content->params->get('link_titles','1')){                                                                                                  
	                                        echo '<a style="color:inherit" href="'.$tab->content->link.'">';                                                                                                                   
	                                            echo $intro_title;
	                                        echo '</a>';
	                                    }else{
	                                        echo $intro_title;
	                                    } 
	                                     ?>
	                                     </span>                             
                             <?php } //}?> 
                             </div> 
                             <?php } //}?>
					 <div class="djtabs-article-content">
	                            	<?php if($tab->content->params->get('show_create_date','1') && $tab->params->get('date_position','1')=='2'){ ?>
						 	<span class="djtabs-date-in">
                            <?php echo date($tab->params->get('date_format','l, d F Y'), strtotime($tab->content->created)); ?>
                            </span>
	                            <?php }
                            	if($tab->params->get('image',0)){
	                            	$images = new JRegistry();
			 						$images->loadString($tab->content->images);
									$img_w = $tab->params->get('image_width',0);
									$img_h = $tab->params->get('image_height',0);
									$image_type = $tab->params->get('image')== '2' ? 'image_fulltext' : 'image_intro';
									if($images->get($image_type)){	  
									if($tab->params->get('image_link',0)){
										?> 
										<a href="<?php echo $tab->content->link; ?>"> <?php } ?>
	
                            <img class="djtabs-article-img <?php $img_pos=$tab->params->get('image_position',1);
                            if($img_pos==1) echo "dj-img-left"; 
                            else if($img_pos==2) echo "dj-img-right";
							else echo "dj-img-top"; ?>" src="<?php echo $images->get($image_type);?>" 
                            <?php if($img_w>0) echo 'width="'.$img_w.'"';?> 
                            <?php if($img_h>0) echo 'height="'.$img_h.'"';?> alt="<?php echo $image_type;?>" />
                            
              <?php if($tab->params->get('image_link',0)){ ?> </a> <?php } ?>
                            
                            <?php    } }   
                          //$intro_desc = mb_substr(strip_tags($tab->content->introtext),0,$tab->params->get('description_char_limit','500'));
                            if ($tab->params->get('HTML_in_description',0))
								$intro_desc = $tab->content->introtext;
							else if ($tab->params->get('description_char_limit')=='')
								$intro_desc = strip_tags($tab->content->introtext);
							else
	                      		$intro_desc = mb_substr(strip_tags($tab->content->introtext),0,$tab->params->get('description_char_limit')).'...';
                          if($tab->params->get('description','1') && $intro_desc){
                          	  if($tab->params->get('description_link','1')){
                                    echo '<a style="color:inherit" href="'.$tab->content->link.'">';                                                                      
                                        echo $intro_desc;
                                    echo '</a>';
                                }else{
                                    echo $intro_desc;
                                }
								if($tab->content->params->get('show_readmore') && $tab->content->link) { ?>
								<span class="djtabs-readmore">
		<a href="<?php echo $tab->content->link; ?>" >
			<?php echo ($tab->params->get('readmore_text',0) ? $tab->params->get('readmore_text') : JText::_('COM_DJTABS_READMORE')); ?>			
		</a>
								</span>
								 <?php 
	                        }  
                        } 
                        ?> 
                        </div>
                        <?php if($tab->content->params->get('show_author','1') || $tab->content->params->get('show_category','1')){ ?>
                        <div class="djtabs-article-footer">
                        <?php
						 if($tab->content->params->get('show_author','1')){ ?>
                            <div class="djtabs-article-author">
                            	<?php  echo $tab->content->author;?>	                    
	                        </div> 
	                      <?php }
						 if($tab->content->params->get('show_category','1')){ ?>
						 	<div class="djtabs-article-category">
                            <?php if($tab->content->params->get('link_category','1')){
                                    echo '<a href="'.$tab->content->cat_link.'">';                                                                      
                                        echo $tab->content->category_title;
                                    echo '</a>';
                                }else{
                                    echo $tab->content->category_title;
                                } 
                                 ?>
                            </div>               
                        	<?php 
						 } ?>
						 </div>
						 <?php } ?>
                    </div>
                    </div>
                    <?php } else if($tab->type==3){?> 
                    	          
                  		<div class="djtabs-body-in djtabs-module">
	                		<?php 
								echo DjTabsHelper::loadModules($tab->mod_pos);	
	                    	?>
                    	</div>                      
                 <?php } else if($tab->type==4){ 
                 	if (!$tab->video_link) echo JText::_('COM_DJTABS_VIDEO_UNSUPPORTED');
                 	else {?>            	                
                 <div class="djVideoWrapper">
				    <iframe src="<?php echo $tab->video_link; ?>" 
				    style="border:0;" allowfullscreen></iframe>
				</div>                      
                 <?php }} ?>
        	</div>
        </div>
		</div>
    <?php }   
    ?>
</div>

 <script>

	window.addEvent('resize', function() {
		resetPanelsText('<?php echo $mod_prefix; ?>');
		setPanelsText('<?php echo $mod_prefix; ?>');
	});
	
  	window.addEvent('domready', function(){
  		

	   new Fx.Accordion(document.id('<?php echo $mod_prefix; ?>djtabs'), '#<?php echo $mod_prefix; ?>djtabs .djtabs-title', '#<?php echo $mod_prefix; ?>djtabs .djtabs-in-border',
	   {
	   	initialDisplayFx: false,
	   	alwaysHide: true,
	   	<?php if ($params->get('accordion_display',1)==2) echo "display: -1,";?>
	   	onActive: function(toggler, element){
			toggler.addClass('djtabs-active');
			toggler.getParent().addClass('djtabs-active-wrapper');
		<?php if ($params->get('video_autopause',2)==1) echo "toggleVideo(element,1);";?>
		},
		onBackground: function(toggler, element){
			toggler.removeClass('djtabs-active');
			toggler.getParent().removeClass('djtabs-active-wrapper');
		<?php if ($params->get('video_autopause',2)==1 || $params->get('video_autopause',2)==2) echo "toggleVideo(element,0);";?>
		}
	   }
	   );
	   
	   var accordionsArray = $$('.<?php echo $mod_prefix; ?>accordion_help_class.accordion_first_out');
	   for (i=1; i<=accordionsArray.length; i++)
	   {
	   	   var accordion_id = accordionsArray[i-1].id;
		   new Fx.Accordion(document.id(accordion_id), '#'+accordion_id+' .djtabs-panel', '#'+accordion_id+' .djtabs-article-body',
		   {
			alwaysHide: true,
			onActive: function(toggler, element){
				toggler.addClass('djtabs-panel-active');
				toggler.getParent().addClass('djtabs-group-active');
			},
			onBackground: function(toggler, element){
				toggler.removeClass('djtabs-panel-active');
				toggler.getParent().removeClass('djtabs-group-active');
			}
			}
		   );
	  }
	  
	  var accordionsArray = $$('.<?php echo $mod_prefix; ?>accordion_help_class.accordion_all_in');
	   for (i=1; i<=accordionsArray.length; i++)
	   {
	   	   var accordion_id = accordionsArray[i-1].id;
		   new Fx.Accordion(document.id(accordion_id), '#'+accordion_id+' .djtabs-panel', '#'+accordion_id+' .djtabs-article-body',
		   {
			alwaysHide: true,
			display: -1,
			onActive: function(toggler, element){
				toggler.addClass('djtabs-panel-active');
				toggler.getParent().addClass('djtabs-group-active');
			},
			onBackground: function(toggler, element){
				toggler.removeClass('djtabs-panel-active');
				toggler.getParent().removeClass('djtabs-group-active');
			}
			}
		   );
	  }

	    setPanelsText('<?php echo $mod_prefix; ?>');
	   document.id('<?php echo $mod_prefix; ?>djtabs').setStyle('visibility','visible');
	   document.id('<?php echo $mod_prefix; ?>djtabs_loading').hide();
	});

</script>
