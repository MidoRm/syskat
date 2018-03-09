<?php
/**
 * @package		CWGallery
 * @subpackage	plg_content_cwgallery
 * @copyright	Copyright (C) 2015 Ing.Pavel Stary, Cesky WEB s.r.o., Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */ 

defined('JPATH_BASE') or die;

/**
 * Supports a gallery for article.
 *
 * @package		Joomla.Administrator
 * @subpackage	plg_content_cwgallery
 * @since		1.6
 */
class JFormFieldCWGallery extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'CWGallery';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
/*
  protected function getLabel() {

  }
*/

  protected function checkTable()
  {
  	$db	= JFactory::getDbo();

  	$query = "SHOW TABLES LIKE '#__cwgallery_files'";
    $db->setQuery($query);
    $db->query();
    $num = $db->getNumRows();

    if( $num > 0 )
  	{  		
      return TRUE;               
  	}
  	else
  	{
      $query = 'CREATE TABLE IF NOT EXISTS `#__cwgallery_files` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `item_id` int(10) unsigned NOT NULL DEFAULT \'0\',
        `rid` varchar(100) NOT NULL,
        `field` varchar(40) NOT NULL,
        `type` varchar(255) DEFAULT NULL,
        `name` varchar(255) DEFAULT NULL,
        `path` varchar(255) DEFAULT NULL,
        `thumb` varchar(255) NOT NULL,
        `size` int(11) NOT NULL,
        `ordering` int(11) NOT NULL,  
        `caption` varchar(255) NOT NULL,
        `description` TEXT,   
        `publish` TINYINT( 1 ) NOT NULL DEFAULT  \'1\',             
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';
      $db->setQuery($query);
      if($db->query()){
        return TRUE;
      } 
      else {
        return FALSE;
      }   
  	}
  }
  
  protected function getInput() {
    
    //get ID of item - in frontend we use a_id to avoid collision with router
    $id = (int)JRequest::getVar("a_id");
    //if no a_id, then we check also id
    if(!$id > 0){
      $id = (int)JRequest::getVar("id");
      if(!$id > 0){
        return "<span style='color: red;'>".JText::_('PLG_CWGALLERY_UPLOADER')."</span>";
      }
    }

    //set myId as a name of dropzone instance
    $myId = str_replace('jform_attribs_','',$this->id);
    
    //get plugin parameters    
    // generate and empty object
    $params = new JRegistry();
    // get plugin details
    $plugin = JPluginHelper::getPlugin('content','cwgallery');
    
    // load params into our params object
    if ($plugin && isset($plugin->params)) {
        $params->loadString($plugin->params);
    }
    //echo "<pre>".'accept'.$myId. ' *** '; print_r($params); exit;
    $limit = $params->get('limits_'.$myId,3);
    $acceptedFiles = implode(',',$params->get('accept_'.$myId,array()));

    //get article attribs
    $db = JFactory::getDbo();
    $query = "SELECT attribs FROM #__content WHERE id = ".(int)$id;
    $db->setQuery($query);
    $item = $db->loadObject();
    // generate and empty object
    $attribs = new JRegistry();
    $attribs->loadString($item->attribs);

    if( (int) $attribs->get('cwgallery_thumb_width') == 0){
      $thumb_width = (int) $params->get('thumb_width');
    } else {
      $thumb_width = (int) $attribs->get('cwgallery_thumb_width');
    }   
    if( (int) $attribs->get('cwgallery_thumb_height') == 0){
      $thumb_height = (int) $params->get('thumb_height');
    } else {
      $thumb_height = (int) $attribs->get('cwgallery_thumb_height');
    }

    // define preview dimensions
    $preview_w = 150;
    $preview_h = $thumb_height / $thumb_width * $preview_w;

    $preview_h_ui = $preview_h + 60;

          
    /**
     * Check DB table and create if not exists
     */         
    //$db = JFactory::getDbo();
    if(self::checkTable() == false){
      return "DB table #__cwgallery_files doesnt exist, please check plugin installation or create it manually - from plugins/content/cwgallery/sql/install.sql";   
    }
   
    //get list of already uploaded files    
    $query = "SELECT * FROM #__cwgallery_files WHERE item_id > 0 AND item_id = ". (int)$id ." AND field = '".$myId."' ORDER BY ordering";
    $db->setQuery($query);
    $files = $db->loadObjectlist();
    
    // this is to remove id prefix from name, because it will be added inside dropzone script
    // because of new added files, and these old loaded files will have 2x id prefix then    
    $session = JFactory::getSession(); //load session for ID to pass for download
    
    foreach($files as $file){
      $arr = explode('_',$file->name);
      unset($arr[0]);
      $file->name = implode('_',$arr);
      $file->level = "old";
      
      $file->md5 = md5($file->id);
      $file->sid = md5($session->getId());  
    }
                                   
    //get json data of stored files - to use in JS dropzone
    $mocks = json_encode($files);
    
    
    //html structure of a field
    $html = array();
    //$html[] = '<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>';  
    /*
    $html[] = '
      <script src="//code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
      <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    ';
    */  
    $doc = JFactory::getDocument();
    $doc->addScript(JUri::root().'plugins/content/cwgallery/cwgallery/assets/js/jquery-ui-1.10.4.custom.min.js');
    $doc->addScript(JUri::root().'plugins/content/cwgallery/cwgallery/assets/js/jquery.jeditable.js');
    $doc->addStylesheet(JUri::root().'plugins/content/cwgallery/cwgallery/assets/js/jquery-ui.css');

    // MODAL
    /*
    $doc->addStylesheet("http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css");
    $doc->addScript("https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js");
    $doc->addScript("http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js");
    */    
    // CROP
    //$doc->addScript(JUri::root().'plugins/content/cwgallery/cwgallery/assets/jcrop/js/jquery.min.js');
    $doc->addScript(JUri::root().'plugins/content/cwgallery/cwgallery/assets/jcrop/js/jquery.Jcrop.js');
    $doc->addStylesheet(JUri::root().'plugins/content/cwgallery/cwgallery/assets/jcrop/css/jquery.Jcrop.css');

    $doc->addStyleDeclaration('
        #target {
          background-color: #ccc;
          width: 500px;
          height: 330px;
          font-size: 24px;
          display: block;
         }  
        .cwpreview {
        	max-width: initial !important; 
        	vertical-align: initial !important;
        	border: 0;
        	-ms-interpolation-mode: bicubic;
        }           
    ');
    
    $doc->addScriptDeclaration("
      jQuery(function($){



      });
       
    ");



    /*
    $html[] = '
      <script src="'.JUri::root().'plugins/content/cwgallery/assets/js/jquery-ui-1.10.4.custom.min.js"></script>
      <link rel="stylesheet" href="'.JUri::root().'plugins/content/cwgallery/assets/js/jquery-ui.css">
    ';*/
    $html[] = "<div style='margin-bottom: 10px;'><span class='btn btn-warning cwhide'><span>".JText::_('PLG_CWGALLERY_HIDE')."</span><span class='hideme'>".JText::_('PLG_CWGALLERY_SHOW')."</span> ".JText::_('PLG_CWGALLERY_UNPUBLISHED')."</span></div>";   
    $html[] = "<div>";
    $html[] = '<link href="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/dropzone/css/dropzone.css" type="text/css" rel="stylesheet" />';
    $html[] = '<script src="'.JUri::root().'plugins/content/cwgallery/cwgallery/assets/dropzone/dropzone.js"></script>';
    $html[] = '<span class="thumbnote">'.JText::_('PLG_CWGALLERY_THUMBNAIL_SIZE_CHANGE_NOTE').'</span>';
    $html[] = "<div class='cwcontrols'>";
    $html[] = ' <a class="btn btn-large fleft" id="cwgen" href="javascript:void(0);">'.JText::_('PLG_CWGALLERY_RECREATE_THUMBNAILS').'</a>';
    $html[] = ' <div class="cwgen_msg"></div>';
    $html[] = " <div class='cleaner'></div>";
    $html[] = ' <div class="cwnote">Thumbnails here are displayed in aspect ratio to width 150px. They are displayed in correct dimensions on frontend though.</div>';
    $html[] = ' <div class="cwnotefree"><span>FREE VERSION HAS LIMIT OF 3 IMAGES</span><a target="_blank" class="btn btn-primary" href="http://extensions.cesky-web.eu/buy-cwarticle-gallery/levels">GET A PRO VERSION HERE</a> .</div>';
    $html[] = "</div>";    
    
    $html[] = '<div class="dropzone dropzone-previews" id="'.$myId.'" style=""><div id="dmask_'.$myId.'" class="dmask"></div></div>';
    //$html[] = '<div class="dropzone-previews" style="border: 5px solid #d5d5d5; width: 500px; height: 500px; display: block;"></div>';    
    $html[] = '<input type="hidden" id="cwgallery_thumb_width" name="cwgallery_thumb_width" value=""/>';
    $html[] = '<input type="hidden" id="cwgallery_thumb_height" name="cwgallery_thumb_height" value=""/>';
    $html[] = "<script>";
    
    $html[] = '
          
          //set RID for delete instead of ID, as before save there is NO ID!
          //var rid = jQuery("#jform_rid").val();
          
          //var preview_w = 150;
          //var preview_h = ( thumb_h /  thumb_w) * 150;
          
          Dropzone.autoDiscover = false;
          // myDropzone is the configuration for the element that has an id attribute
          // with the value my-dropzone (or myDropzone)
          Dropzone.options.'.$myId.' = {
            acceptedFiles: "'.$acceptedFiles.'",
            accept: function(file, done) {
              //console.log("uploaded");
              done();
            },
            thumbnailWidth: '.$preview_w.',       
            thumbnailHeight: '.$preview_h.',          
            init: function() {
                this.on("removedfile", function(file) {
                    //console.log(file);      
                    if(file.level == "old"){                    
                      '.$myId.'.options.maxFiles = '.$myId.'.options.maxFiles + 1;
                    }
                    //console.log('.$myId.'.options.maxFiles);
                });
                this.on("addedfile", function(file) {
                    //console.log('.$myId.'.options.maxFiles);
                    //to set the item id prefix for filename
                    //var prefix = Math.round(+new Date()/1000); // for unique stamp but problem with passing it to php for store
                    //file.name = "'.$id.'_"+file.name;
                    //console.log(file);
                    
                    // Create the remove button
                    var removeButton = Dropzone.createElement("<span class=\"btn btn-del\" title=\"'.JText::_('PLG_CWGALLERY_DELETE').'\"></span>");
         
                    // Capture the Dropzone instance as closure.
                    var _this = this;
            
                    // Listen to the click event
                    removeButton.addEventListener("click", function(e) {
                      // Make sure the button click doesnt submit the form:
                      e.preventDefault();
                      e.stopPropagation();
    
                      var preview = jQuery(this).closest(".dz-preview");
                      var index = jQuery(preview).closest("#'.$myId.'").find(".dz-preview").index(preview);
                      ordering = index + 1;
                      //console.log(ordering); 
                      //console.log('.$id.'); 
                                       
                      if (confirm(\'Are you sure you want to delete this?\')) {
                        // Remove the file preview.
                        _this.removeFile(file);
                        // If you want to the delete the file on the server as well,
                        // you can do the AJAX request here.
                        //var id = '.$id.';


    
                                                    
                                                
                        jQuery.ajax({
                              type: "GET",                        
                              //url:"'.JUri::root().'index.php?option=com_cwcourses&task=ajaxCall&format=raw",
                              url: "'.JUri::root().'index.php?option=com_ajax&plugin=removefile&format=json&name="+file.name+"&ordering="+ordering+"&id='.$id.'",
                              //data: "function=removeFile&name="+file.name+"&rid="+rid,
                              success:function(results){
                                  //alert(results);
                              }
                        }); 
                      }                    
                    });
                               
                    if(file.publish == 0) {
                      file.previewElement.className += " inactive";
                    }
                    
                    // set download icon
                    var link = "'.JUri::root().'plugins/content/cwgallery/cwgallery/helpers/download.php?id="+file.md5+"&sid="+file.sid;
                    var downloadIcon = Dropzone.createElement("<a href=\""+link+"\"><span class=\'btn-dwn\' title=\'Download\'></span></a>");
                    // Add the button to the file preview element.
                    file.previewElement.getElementsByClassName("dz-tool")[0].appendChild(downloadIcon);

                    // Add the button to the file preview element.
                    file.previewElement.getElementsByClassName("dz-tool")[0].appendChild(removeButton);                                        

                                                 
                });
                
                /*
                // reached max limit
                this.on("maxfilesexceeded", function(file) {
                    //this.removeFile(file);  //prevent to show file upload thumb over maxlimit count 
                    alert("Files limit has been reached!");
                });
                */
                 
            }
          };
     
     
     // Settings
      var func = "uploadFiles";
      var id = '.$id.'; 
      //var rid = jQuery("#jform_rid").val();

      var '.$myId.' = new Dropzone("div#'.$myId.'", {
        //url: "'.JUri::root().'index.php?option=com_cwcourses&task=ajaxCall&function="+func+"&id="+id+"&field='.$myId.'&rid="+rid, 
        url: "'.JUri::root().'index.php?option=com_ajax&plugin=cwgalleryupload&format=json&id="+id+"&field='.$myId.'",
      });

      
      // Create the mock file:
      var mockArray = '.$mocks.';
      for(var i=0;i<mockArray.length;i++){
          var mockFile = mockArray[i];
          // Call the default addedfile event handler
          '.$myId.'.emit("addedfile", mockFile);      
          // And optionally show the thumbnail of the file:
            // set thumb path
            var thumb = "'.JUri::root().'"+mockFile.path;
            // parse type set - if it is image type, no matter jpg,png,...
            var type = mockFile.type.split("/");
            // if image, set thumbnail
            if(type[0] == "image"){
              '.$myId.'.emit("thumbnail", mockFile, thumb);
            }

      }     
      
      // If you use the maxFiles option, make sure you adjust it to the correct amount:
      '.$myId.'.options.maxFiles = '.$limit.';
      var existingFileCount = '.(count($files)).'; // The number of files already uploaded
      '.$myId.'.options.maxFiles = '.$myId.'.options.maxFiles - existingFileCount;
      ';
       
      $html[] = '
        jQuery(document).ready( function(){
          jQuery(function() {
            jQuery( "#'.$myId.'" ).sortable({
              items:\'.dz-preview\',
              placeholder: "ui-state-highlight",
              cursor: \'move\',
              opacity: 0.5,
              containment: \'#'.$myId.'\',
              distance: 20,
              tolerance: \'pointer\',
              start: function (event, ui) {
                      jQuery("#'.$myId.' .dz-preview").each(function(i, el){
                          //var index = jQuery(el).index() - 1;
                          var index = jQuery(el).closest("#'.$myId.'").find(".dz-preview").index(el);
                          ordering = index + 1;
                          jQuery(this).attr("data-index",ordering);  
                                                  
                      });

                  },
              stop: function (event, ui) {
                      var databank = [];
                      jQuery("#'.$myId.' .dz-preview").each(function(i, el){
                          var p = jQuery(el).find(".dz-filename span[data-dz-name]").text();
                          var data = {};
                          data.name = id+"_"+p;
                          // new index
                          var index = jQuery(el).index() - 1;
                          data.order = index;
                          // stored index
                          var old_order = jQuery(el).attr("data-index");
                          data.old_order = old_order;
                          
                          databank.push(data);
                      });
                      json_order = JSON.stringify(databank);
                      //console.log(json_order);
                      var func = "sortFiles";
                      jQuery("#dmask_'.$myId.'").fadeIn(); 
                      jQuery.ajax({
                            type: "POST",                        
                            url: "'.JUri::root().'index.php?option=com_ajax&plugin=sortfiles&format=json",
                            data: "field='.$myId.'&id="+'.$id.'+"&orderlist="+json_order,
                            success:function(results){
                              //alert(results);
                              jQuery("#dmask_'.$myId.'").fadeOut();
                            }
                        });                                
                    }                       
            });
            jQuery( "#'.$myId.'" ).disableSelection();
          });            
        });
        
        jQuery(document).ready( function(){
          
          
          jQuery("#cwgen").click( function() { 
            jQuery("#dmask_'.$myId.'").fadeIn(); 
            jQuery.ajax({
                type: "GET",                        
                url: "'.JUri::root().'index.php?option=com_ajax&plugin=cwgallerygenerate&format=raw&field='.$myId.'&id='.$id.'",
                success:function(result){
                  //alert(result);
                  //console.log(result);
                  if(result == 1){
                    // show a message about Success
                    jQuery(".cwgen_msg").addClass("cw_ok");
                    jQuery(".cwgen_msg").removeClass("cw_fail");
                    jQuery(".cwgen_msg").html("'.JText::_('PLG_CWGALLERY_THUMBNAIL_REGENERATE_OK').' - Reload Page to refresh thumbnails");
                  }
                  else {
                    // show a message about Fail
                    jQuery(".cwgen_msg").addClass("cw_fail");
                    jQuery(".cwgen_msg").removeClass("cw_ok");
                    jQuery(".cwgen_msg").html("'.JText::_('PLG_CWGALLERY_THUMBNAIL_REGENERATE_FAIL').'");
                  }                  
                  jQuery("#dmask_'.$myId.'").fadeOut();
                  jQuery(".cwgen_msg").fadeIn().delay(5000).fadeOut();
                }
              });
            });
            
            jQuery("#jform_attribs_cwgallery_thumb_width").on(\'keyup\', function() {
              jQuery(".thumbnote").css("display", "block");
            });                                
            jQuery("#jform_attribs_cwgallery_thumb_height").on(\'keyup\', function() {
              jQuery(".thumbnote").css("display", "block");
            }); 
        });        
           
            
      ';

$html[] = '
        (function($){
            $.fn.maxlength = function(){
                $(\'textarea[maxlength]\').keypress(function(event){
                    var key = event.which;
                    //all keys including return.
                    if(key >= 33 || key == 13) {
                        var maxLength = $(this).attr(\'maxlength\');
                        var length = this.value.length;
                        if(length >= maxLength) {
                            event.preventDefault();
                        }
                    }
                });
            };
        })(jQuery);

        jQuery(document).ready( function($){
        
          var switchToInputCWG = function () {
              var $input = $("<input>", {
                  val: $(this).text(),
                  type: "text",
                  maxlength: "100"                  
              });
              $input.addClass("editableCWG");
              $(this).replaceWith($input);
              
              $input.parent().find(\'.btn-cwg\').remove(); // remove old button if it stayed - f.e. double click
              var butt = "<a class=\'btn btn-cwg\'>Save</a>";
              $input.parent().append(butt);
              
              /**
               * Cover different events
               */                             
              // Standard Blur
              $input.on("blur", switchToSpan);              
              
              // Hit enter              
              $input.keyup(function(event){
                  if(event.keyCode == 13){
                      $input.parent().find(\'.btn-cwg\').trigger(\'click\');                      
                  }
              });              
              
              // Hit Save Button
              $input.parent().find(\'.btn-cwg\').click( function(){
                      $input.trigger(\'focusout\'); 
              });
              
              // focusOut
              $input.on("focusout", function() {
                //console.log($input.val());
                $input.parent().find(\'.btn-cwg\').remove();
                
                var $span = $("<span>", {
                  text: $(this).val()
                });
                
                // Ajax save here
                var name = $(this).val();
                var lindex = $input.parent().parent().parent().index();
                lindex = lindex - 1;
                $input.parent().parent().parent().find(".ddmask").fadeIn();

                $span.addClass("editableCWG");
                $(this).replaceWith($span);
                $span.on("click", switchToInputCWG);
                
                jQuery.ajax({
                      type: "GET",                        
                      url: "'.JUri::root().'index.php?option=com_ajax&plugin=renameFile&format=json&name="+name+"&caption=true&ordering="+lindex+"&id='.$id.'",
                      success:function(results){
                          //console.log($input);
                          $span.parent().parent().parent().find(".dz-config input[data-dz-config-caption]").val(name); // change caption elsewhere
                          $span.parent().parent().parent().find(".ddmask").fadeOut();

                      }
                });

                

              }); 
                            
              $input.select();
          };
          
          var switchToSpan = function () {
              var $span = $("<span>", {
                  text: $(this).val()
              });
              
              $span.addClass("editableCWG");
              $(this).replaceWith($span);
              $span.on("click", switchToInputCWG);
              
          };
          // standard binding
          $(".editableCWG").on("click", switchToInputCWG);          
          // for covering dynamically created items
          $(document).on("click", \'.editableCWG\', switchToInputCWG);
        });        


      ';

$html[] = '
        jQuery(document).ready( function($){
          //prepare crop dimensions
          //var thumb_w = $("#jform_attribs_cwgallery_thumb_width").val();
          //var thumb_h = $("#jform_attribs_cwgallery_thumb_height").val();
          $("#jform_attribs_cwgallery_thumb_width").val('.$thumb_width.');
          $("#jform_attribs_cwgallery_thumb_height").val('.$thumb_height.');          
          var thumb_w = '.$thumb_width.';
          var thumb_h = '.$thumb_height.';
          
          var preview_w = 150;
          var preview_h = ( thumb_h /  thumb_w) * 150;
          
          $("#cwgallery_thumb_width").val( thumb_w );
          $("#cwgallery_thumb_height").val( thumb_h );
          
          $(".dropzone .dz-preview .dz-details, .dropzone-previews .dz-preview .dz-details, .dropzone-previews .dz-preview .dz-details img").css("width",preview_w);
          $(".dropzone .dz-preview .dz-details, .dropzone-previews .dz-preview .dz-details, .dropzone-previews .dz-preview .dz-details img").css("height",preview_h);
                    
          var jcrop_api;
        
          // **************************************************
          // CROP FUNCS
          function getRandom() {
            var dim = jcrop_api.getBounds();
            return [
              Math.round(Math.random() * dim[0]),
              Math.round(Math.random() * dim[1]),
              Math.round(Math.random() * dim[0]),
              Math.round(Math.random() * dim[1])
            ];
          };
          
          function initJcrop(target)
          {      
            // var image = target.parent().find(".dz-details img").attr("src"); //this is not good for freshly uploaded images
            var image = target.parent().find("[data-dz-config-path]").val(); // cant use image src as there is thumb, we need original 

            // set image for crop source
            target.parent().find(".dz-config .cropbox").attr("src",image);          
            target.parent().find(".dz-config .cwpreview").attr("src",image);
            
            // get original dimensions
            var ow = target.parent().find(".dz-config .cropbox").get(0).width;
            var oh = target.parent().find(".dz-config .cropbox").get(0).height;
            
            // set new dimensions in aspect ratio
            var crop_w = 400;
            var crop_h = (crop_w / ow) * oh;
            
            // set css for img
            target.parent().find(".dz-config .cropbox").attr("width", crop_w);
            target.parent().find(".dz-config .cropbox").attr("height", crop_h);            
                        
            //console.log(crop_w + " " + crop_h);
            
            target.find(".cropbox").Jcrop({
          		onChange: showPreview,
          		onSelect: showPreview,
          		//aspectRatio: 1
            },function(){
              jcrop_api = this;
              
              var dw = jQuery("#cwgallery_thumb_width").val();
              var dh = jQuery("#cwgallery_thumb_height").val();
              
              jcrop_api.setOptions({
                minSize: [ 150, 150 ],
                aspectRatio: dw/dh
              });
        
              jcrop_api.release();
              jcrop_api.animateTo([0,0,150,150]); // preselect crop area
              //jcrop_api.animateTo(getRandom());
                            
              // this would not change preview image, only main
            	//var image = target.parent().find(".dz-details img").attr("src");
              //jcrop_api.setImage(image);

            });
            
          }
          function showPreview(coords)
          {
            var dw = jQuery("#cwgallery_thumb_width").val();
            var dh = jQuery("#cwgallery_thumb_height").val();
            
          	var rx = 100 / coords.w;
          	var ry = (100 * dh/dw) / coords.h;  //for keeping aspect ration in thumb preview 
          
            var ow = $(".jcrop-holder img").width();
            var oh = $(".jcrop-holder img").height();
    
          	$(".cwpreview").css({
          		width: Math.round(rx * ow) + "px",
          		height: Math.round(ry * oh) + "px",
          		marginLeft: "-" + Math.round(rx * coords.x) + "px",
          		marginTop: "-" + Math.round(ry * coords.y) + "px"
          	});
            $(".preview_wrap").css({
              width: 100 + "px",
              height: (100 * dh/dw) + "px", 
            });
            updateCoords(coords);
            //console.log(JSON.stringify(jcrop_api.tellSelect()));
          }
          function updateCoords(c)
          {
            $("#ow").val( $(".cropbox").get(0).naturalWidth );
            $("#oh").val( $(".cropbox").get(0).naturalHeight );
            $("#rw").val( $(".cropbox").width() );
            $("#rh").val( $(".cropbox").height() );
            
            var koef = $("#ow").val() / $("#rw").val();
            
            $("#x").val(c.x * koef);
            $("#y").val(c.y * koef);
            $("#w").val(c.w * koef);
            $("#h").val(c.h * koef);
                        
          }; 
          // END CROP FUNCS
          // **************************************************


          // **************************************************
          // OPEN UPDATE MODAL
          $(document).on("click", "#attrib-cwgallery .dz-tool span[data-dz-tool-edit]", function(){
            
            var previews = $(this).parent().parent().parent().find(".dz-preview");
            previews.each(function( index ) {
              $(this).children(".dz-config").attr("id","myModal"+index);
              $(this).find("span[data-dz-tool-edit]").attr("data-target","#myModal"+index);
              //console.log($(this).find("span[data-dz-tool-edit]"));
            });
            
            //$(".modal-backdrop.fade").hide();
            var config = $(this).parent().parent().find(".dz-config");
            //console.log($(this).parent().parent());                                                 
            $(".cropbox_dummy").removeClass("cropbox");
            config.find(".cropbox_dummy").addClass("cropbox");

            
            $("#attrib-cwgallery .dz-config .modal-footer .msg2").remove(); // remove always
            var path = config.find("[data-dz-config-path]").val();
            if(path == ""){
              var msg2 = $("<span />").addClass("msg2").html("Reload page to get option for Cropping custom thumbnail");
              //var footer = config.find(".modal-footer");
              //$(".dz-config .modal-footer").prepend( msg2 );
              config.find(".preview_wrap").hide();
            } else {
              config.find(".preview_wrap").show();  
            }
            initJcrop(config); // CROP
            //$(".dmask_full").fadeIn(0);
            config.fadeIn(0);
          });
          // **************************************************

          // **************************************************
          // PUBLISH X UNPUBLISH
          $(document).on("click", "#attrib-cwgallery .dz-tool span[data-dz-tool-publish]", function(){
            var butt = $(this);
            var tool = $(this).parent();
            var lindex = tool.parent().index();
            //console.log(tool.parent());             
            var state = this.hasClass(\'active\');

            if(state == false){
              var publish = "1";
            } else {
              var publish = "0";
            }                        

            tool.parent().find(".ddmask").fadeIn(); // mask
              
            lindex = lindex - 1;

            //console.log(state);
            //console.log(publish);
            $.ajax({
                    type: "GET",                        
                    url: "'.JUri::root().'index.php?option=com_ajax&plugin=publishFile&format=json&publish="+publish+"&ordering="+lindex+"&id='.$id.'",
                    success:function(results){
                        console.log("'.JUri::root().'index.php?option=com_ajax&plugin=publishFile&format=json&publish="+publish+"&ordering="+lindex+"&id='.$id.'");
                        tool.find("span[data-dz-tool-publish]").toggleClass( "active" );
                        tool.parent().toggleClass( "inactive" );                        
                        tool.parent().find(".ddmask").fadeOut();
                    }
                    
            }); //end ajax
          }); //end onclick
          
          // **************************************************
          // SAVE UPDATE N CLOSE
          $(document).on("click", \'.cwupdate\', function(){  
              // prepare get parameters
              var config = $(this).parent().parent().parent().parent();
              var name = config.find("input[name=\'caption\']").val();
              var lindex = config.parent().index();
              var description = config.find("textarea[name=\'description\']").val();
              
              //config.fadeOut(); // hide modal              
              $(".modal-backdrop").trigger("click"); 
              
              config.parent().find(".ddmask").fadeIn(0); // mask
                            
              
              lindex = lindex - 1;
 
              description = JSON.stringify(description); // to keep new lines
                                                      
              $.ajax({
                      type: "GET",                        
                      url: "'.JUri::root().'index.php?option=com_ajax&plugin=renameFile&format=json&name="+name+"&description="+description+"&ordering="+lindex+"&id='.$id.'",
                      success:function(results){
                          //console.log("'.JUri::root().'index.php?option=com_ajax&plugin=renameFile&format=json&name="+name+"&description="+description+"&ordering="+lindex+"&id='.$id.'");
                          
                          config.parent().find(".dz-filename span.editableCWG").text(name); // change caption elsewhere
                          config.parent().find(".ddmask").fadeOut();
                          //$(".dmask_full").fadeOut();
                      }
                      
              }); //end ajax
              
          }); //end onclick
          // **************************************************
          // CLOSE MODAL MASK  
          // **************************************************
          $("body").on("click", ".dmask_full, button[data-dismiss=modal], .modal-backdrop", function () {
        		//$(".dmask_full").fadeOut();
            //$(".dz-config").fadeOut();
            // Destroy Jcrop widget, restore original state
            jcrop_api.release();
            jcrop_api.destroy();
        	});
          
          // **************************************************
          
          // CROP THUMB
          $(".cwcreatethumb").on("click", function() {
            //console.log(jQuery("#x"));
            var databank = [];
                var data = {};
                
                data.x = jQuery("#x").val();
                data.y = jQuery("#y").val();
                data.w = jQuery("#w").val();
                data.h = jQuery("#h").val();
                
                data.ow = jQuery("#ow").val();
                data.oh = jQuery("#oh").val();
                data.rw = jQuery("#rw").val();
                data.rh = jQuery("#rh").val();
                
                data.targ_w = jQuery("#cwgallery_thumb_width").val();
                data.targ_h = jQuery("#cwgallery_thumb_height").val();
                
                data.rh = jQuery("#rh").val();
                
                data.source_image = $(this).parent().parent().find("img.cropbox").attr("src");
                
                databank.push(data);
                
                var prev = $(this).parent().parent().parent().parent().parent().find(".dz-details img");
                        
            json_data = JSON.stringify(databank);
            console.log(json_data);
            $(".dmask_modal").fadeIn(); 
            $.ajax({
                  type: "GET",                        
                  url: "'.JUri::root().'index.php?option=com_ajax&plugin=CwJCropThumb&format=json&config="+json_data,
                  success:function(results){
                    //console.log(results);
                    $(".dmask_modal").fadeOut();

                    // add message
                    var msg = $("<span />").addClass("msg").html("Thumbnail has been updated");
                    $("#attrib-cwgallery .dz-config .modal-footer").prepend( msg );
                    $("#attrib-cwgallery .dz-config .modal-footer .msg").delay(5000).fadeOut(300, function() { $(this).remove(); });
                     
                    // create thumb url
                    var pieces = data.source_image.split("/");
                    pieces[pieces.length - 1] = "thumb_" + pieces[pieces.length - 1];
                    var thumbUrl = pieces.join("/");
                    d = new Date();
                                        
                    prev.attr("src",thumbUrl+"?"+d.getTime());  // thumb not original

                  }, 
                  error:function(results){
                    console.log(results);
                  }         
            }); 
                        
          }); // end Crop thumb  
                  
           
          //HIDE UNPUBLISHED
          $("#attrib-cwgallery .cwhide").on("click", function(){
              $("#attrib-cwgallery .dz-preview.inactive").fadeToggle();
              $("#attrib-cwgallery .cwhide span").toggleClass("hideme");
          });
        
        }); // End ready       


      ';
                    
    $html[] = "</script>";     
    //$html[] = '<div id="dmask_full" class="dmask_full"></div>';
    $html[] = "</div>";    


    $html[] = '
  
        <style>
        #attrib-cwgallery .dz-preview .modal-body .ccol { float: left; width: 50%; padding: 10px 20px; }
        #attrib-cwgallery .dz-preview .modal-body .ccol:last-child { border-left: 1px solid #EEEEEE; }
        #attrib-cwgallery .dz-preview .modal-footer { clear: both; }
        #attrib-cwgallery .dz-preview .dz-config .btn {
          position: relative;
          z-index: 99999;
          cursor: pointer !important;
        }    
        
        #attrib-cwgallery .dropzone .dz-details span[data-dz-name] { color: #999; font-size: 11px; font-style: italic; }
        #attrib-cwgallery .dropzone .dz-details .editableCWG { display: block; width: 100%; }
        #attrib-cwgallery .dropzone .dz-details span[data-dz-caption].editableCWG, #attrib-cwgallery .dropzone .dz-details .dz-filename span.editableCWG { min-height: 20px; background-color: rgba(255, 255, 255, 0.7); font-size: 12px; }
        #attrib-cwgallery .dropzone .dz-details:hover .editableCWG { z-index: 99999; position: relative; max-width: 100%; display: block; }
        #attrib-cwgallery .dropzone .dz-details .editableCWG:hover {text-decoration: underline;cursor: pointer !important; }        

        #attrib-cwgallery .dropzone .dmask {
          background: rgba(255,255,255,0.8) url('.JUri::root().'plugins/content/cwgallery/cwgallery/assets/images/loading.gif) no-repeat center;
          position: absolute;
          width: 100%;
          height: 100%;
          top: 0px;
          left: 0px;
          z-index: 999;
          display: none;
        }
        #attrib-cwgallery .dropzone .ddmask {
          background: rgba(255,255,255,0.8) url('.JUri::root().'plugins/content/cwgallery/cwgallery/assets/images/loading.gif) no-repeat center;
          position: absolute;
          width: 100%;
          height: 100%;
          top: 0px;
          left: 0px;
          z-index: 999;
          display: none;
        }
        #attrib-cwgallery .dropzone .dmask_modal {
          background: rgba(255,255,255,0.8) url('.JUri::root().'plugins/content/cwgallery/cwgallery/assets/images/loading.gif) no-repeat center;
          position: absolute;
          width: 100%;
          height: 100%;
          top: 0px;
          left: 0px;
          z-index: 999;
          display: none;
        }
        
        #attrib-cwgallery .dz-preview:hover,.dz-preview img:hover, .dz-preview .dz-filename { cursor: move !important; }
        #attrib-cwgallery .dz-image-preview button { cursor: pointer !important; }        
        
        #attrib-cwgallery .dz-preview > button {width: 150px; margin: 0px;}
        #attrib-cwgallery .dz-preview .modal-content button { width: auto; }
        #attrib-cwgallery .fleft { float: left; }
        #attrib-cwgallery .cwgbutton {
          
          background: #178BD0; padding: 7px 20px; color: white;
           
          float: left;
          -webkit-transition: all 500ms ease;
          -moz-transition: all 500ms ease;
          -ms-transition: all 500ms ease;
          -o-transition: all 500ms ease;
          transition: all 500ms ease;
          }
        #attrib-cwgallery .cwgbutton:hover, .cwgbutton:active, .cwgbutton:focus { text-decoration: none; color: white; background: #555; }
        #attrib-cwgallery .cwgen_msg { font-weight: bold; padding: 7px 20px; float: left; }
        #attrib-cwgallery .cw_ok { color: green; }
        #attrib-cwgallery .cw_fail { color: red; }
        #attrib-cwgallery .cwcontrols { margin-bottom: 20px; }
        #attrib-cwgallery .cwcontrols .cleaner { clear: both; }
        #attrib-cwgallery .thumbnote {color: red;font-weight: bold;padding: 5px 0 20px 0; display: none;}
        #attrib-cwgallery .cwred strong { color: orange; }
        


        #attrib-cwgallery .dmask_full {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: black;
            opacity: .70;
            -webkit-opacity: .7;
            -moz-opacity: .7;
            filter: alpha(opacity=70);
            z-index: 1000;
        }
    
        #attrib-cwgallery .dz-preview .dz-config {

            display: none;

        }

        #attrib-cwgallery .dz-preview .dz-config.active, #attrib-cwgallery .dmask_full.active {
            display: block;
        }
        
        #attrib-cwgallery .dz-preview .dz-config > * {
          /*margin-bottom: 10px;*/             
        }
        #attrib-cwgallery .dz-preview .dz-config textarea, .dz-preview .dz-config input { width: 100%; cursor: text; padding: 5px; }
        #attrib-cwgallery .dz-preview .dz-config input { height: 30px; }
        #attrib-cwgallery .dz-preview .dz-config textarea { height: 100px; }
        
        #attrib-cwgallery .dz-preview .dz-tool { position: absolute; bottom: 6px; width: 92%; }
        #attrib-cwgallery .dz-preview .dz-tool span.inactive { font-size: 10px; }
        #attrib-cwgallery .dz-preview .dz-tool span[data-dz-tool-edit] { display: none; border: none; width: 24px; height: 24px; opacity: 0.5; background: url('.JUri::root().'plugins/content/cwgallery/cwgallery/assets/images/conf.png) no-repeat; cursor: pointer; float: left;}
        #attrib-cwgallery .dz-preview .dz-tool span[data-dz-tool-publish] { display: none; border: none; width: 24px; height: 24px; opacity: 0.5; cursor: pointer; background: url('.JUri::root().'plugins/content/cwgallery/cwgallery/assets/images/cross.png) no-repeat;  float: left; margin-left: 5px;}
        #attrib-cwgallery .dz-preview .dz-tool span[data-dz-tool-publish].active { background: url('.JUri::root().'plugins/content/cwgallery/cwgallery/assets/images/check.png) no-repeat; }
        #attrib-cwgallery .dz-preview .dz-tool span:hover { opacity: 1; }          
        #attrib-cwgallery .dz-preview .dz-tool span.btn-dwn { display: none; border: none; width: 24px; height: 24px; opacity: 0.5; cursor: pointer; background: transparent url('.JUri::root().'plugins/content/cwgallery/cwgallery/assets/images/download.png) no-repeat;  float: left; margin-left: 5px;}        
        #attrib-cwgallery .dz-preview .dz-tool span.btn-dwn:hover { opacity: 1; }
        #attrib-cwgallery .dz-preview .dz-tool span.btn-del { display: none; border: none; width: 24px; height: 24px; opacity: 0.5; cursor: pointer; background: transparent url('.JUri::root().'plugins/content/cwgallery/cwgallery/assets/images/delete.png) no-repeat;  float: right; margin-left: 5px;}        
        #attrib-cwgallery .dz-preview .dz-tool span.btn-del:hover { opacity: 1; }

        
        #attrib-cwgallery .dz-preview { z-index: initial !important; }
        #attrib-cwgallery .dropzone .ui-state-highlight { max-height: 210px !important;} 
        #attrib-cwgallery .dropzone .dz-preview, .dropzone-previews .dz-preview { border-radius: 3px; } 
        #attrib-cwgallery .dropzone .dz-preview .dz-filename a.btn { position: relative; z-index: 10; cursor: pointer; }
        #attrib-cwgallery .dropzone .dz-preview > img { position: relative; z-index: 9; }
        #attrib-cwgallery .dropzone .cwupdate {  }
        
        #attrib-cwgallery .dz-preview .dz-config label { font-weight: bold; }
        #attrib-cwgallery .dz-preview .dz-config textarea, .dz-preview .dz-config input { margin-bottom: 10px; }
        #attrib-cwgallery .dz-preview .dz-config textarea { resize: vertical; }
        @media screen and (max-width: 1100px) {
            #attrib-cwgallery .dropzone .modal-body .ccol {
                width: 100%;
            }
            
            #attrib-cwgallery .dz-preview .dz-config textarea, #attrib-cwgallery .dz-preview .dz-config input { width: 60%; }
            #attrib-cwgallery .dz-preview .dz-config textarea { height: 50px; }
            #attrib-cwgallery .dz-preview .dz-config label { float: left; width: 40%; }
            #attrib-cwgallery .dropzone .modal-body { height: 400px; overflow-x: hidden; } 
            
            #attrib-cwgallery .dz-preview .modal-body .ccol:last-child { border: none; }           
        }
        @media screen and (max-width: 1454px) and (min-width: 1101px) {
            #attrib-cwgallery .dropzone .modal-body .ccol .preview_wrap  {
                margin: 10px 0 0 150px !important; 
            }
            #attrib-cwgallery .dropzone .modal-body .ccol .jcrop-holder {
                clear: both !important;
                float: none !important;
            }
        }        
        #attrib-cwgallery .dropzone .modal-body .jcrop-holder { float: left; margin-right: 10px; }
        #attrib-cwgallery .dropzone .modal span.msg { display: inline-block; color: #71BD52; font-weight: bold; float: left; line-height: 27px; }
        #attrib-cwgallery .dropzone .modal span.msg2 { display: inline-block; color: #FF5200; font-weight: bold; float: left; line-height: 27px; }
        
        #attrib-cwgallery .dropzone .dz-preview .dz-details, #attrib-cwgallery .dropzone-previews .dz-preview .dz-details { width: '.$preview_w.'px !important; height: '.$preview_h.'px !important; }      
        #attrib-cwgallery .dropzone .dz-preview .dz-progress, #attrib-cwgallery .dropzone-previews .dz-preview .dz-progress { top: '.$preview_h.'px !important; }  

        #attrib-cwgallery .dropzone .ui-state-highlight {
          webkit-box-shadow: 1px 1px 4px rgba(0,0,0,0.16);
          box-shadow: 1px 1px 4px rgba(0,0,0,0.16);
          width: 164px !important;
          height: '.$preview_h_ui.'px !important;
          margin: 17px;
          display: inline-block;
          
          -webkit-transition: all 500ms ease;
          -moz-transition: all 500ms ease;
          -ms-transition: all 500ms ease;
          -o-transition: all 500ms ease;
          transition: all 500ms ease;
          
          background: #fff;
        }
        #attrib-cwgallery .dz-preview:hover .dz-tool span:not(.inactive) { display: block; }
        #attrib-cwgallery .dz-tool span.inactive { display: none; }
        #attrib-cwgallery .dz-tool.undefined span { display: none !important; }
        #attrib-cwgallery .dz-preview:hover .dz-tool.undefined span.inactive { display: block !important; }
        
        #attrib-cwgallery .cwcontrols .cwnote { padding: 20px 0 0 0; color: #777; }
        #attrib-cwgallery .cwcontrols .cwnotefree {
          border: 2px dashed #ffffff;
          padding: 10px 10px;
          margin: 20px 0;
          background: #4f9cda;
          color: white;
          text-align: center;
        }
        #attrib-cwgallery .cwcontrols .cwnotefree span {
          margin-right: 30px;
        }
        #attrib-cwgallery .dz-preview .dz-details {}
        #attrib-cwgallery .dropzone .dz-preview .dz-details .dz-size, .dropzone-previews .dz-preview .dz-details .dz-size {position: absolute;bottom: -21px;left: 3px;height: 20px;line-height: 20px; font-size: 12px; }            
        #attrib-cwgallery .dz-preview.inactive { border-color: #d12525; -webkit-box-shadow: 1px 1px 4px rgba(209, 37, 37,0.16); box-shadow: 1px 1px 4px rgba(209, 37, 37, 0.16);}
        #attrib-cwgallery .dz-preview.inactive img[data-dz-thumbnail] { 
          filter: gray; /* IE6-9 */
          filter: grayscale(1); /* Firefox 35+ */
          -webkit-filter: grayscale(1); /* Google Chrome, Safari 6+ & Opera 15+ */
        } 
        #attrib-cwgallery .dropzone .dz-preview .dz-details, #attrib-cwgallery .dropzone-previews .dz-preview .dz-details { margin-bottom: 30px; }   
        
        #attrib-cwgallery .dz-preview .dz-tool span[data-dz-tool-edit] { background-size: contain; }

        #attrib-cwgallery .hideme {
          display: none;
        }
                              
        </style>
  			 
      <input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
      
			<input type="hidden" id="ow" name="ow" />
			<input type="hidden" id="oh" name="oh" />
			<input type="hidden" id="rw" name="rw" />
			<input type="hidden" id="rh" name="rh" />    
 
    ';

    
    //$html[] = '<input type="hidden" name="jform[rid]" id="jform_rid" value="'.( (isset($this->item->rid)) ? $this->item->rid : md5(time().rand()) ).'" />';    
    
    return implode('',$html);

	}

}?>
