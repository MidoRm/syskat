<?php 
/* 
* @author Henry Hyde
* Email : geniusextensions@yahoo.com
* URL : www.geniusextensions.com
* Description : This module displays icon links to your social media profiles.
* Copyright (c) 2013 Genius Extensions
* License GNU GPL
***/

// no direct access
defined('_JEXEC') or die;
 
$document =& JFactory::getDocument();
$mod = JURI::base() . 'modules/mod_socialmedialinksgenius/';
$document->addStyleSheet(JURI::base() . 'modules/mod_socialmedialinksgenius/assets/font-awesome.css');
$document->addStyleSheet(JURI::base() . 'modules/mod_socialmedialinksgenius/assets/style.css');

// Get Basic Module Parameters 
	$moduleclass_sfx 	= $params->get('moduleclass_sfx','');
	$target 			= $params->get('target','_blank');
	$size 			    = $params->get('size');
	$margin 			= $params->get('margin');
	$color 			    = $params->get('color');
	$background 		= $params->get('background');
	$padding 			= $params->get('padding');
	$radius 			= $params->get('radius');
	$effect 			= $params->get('effect');
	

// Get Icon Parameters
$ic   = $params->get('icon1'); 
$ic2  = $params->get('icon2');
$ic3  = $params->get('icon3');
$ic4  = $params->get('icon4');
$ic5  = $params->get('icon5');
$ic6  = $params->get('icon6');
$ic7  = $params->get('icon7');
$ic8  = $params->get('icon8');
$ic9  = $params->get('icon9');
$ic10 = $params->get('icon10');
$ic11 = $params->get('icon11');
$ic12 = $params->get('icon12');
$ic13 = $params->get('icon13');
$ic14 = $params->get('icon14');
$ic15 = $params->get('icon15');
$ic16 = $params->get('icon16');
$ic17 = $params->get('icon17');
$ic18 = $params->get('icon18');
$ic19 = $params->get('icon19');
$ic20 = $params->get('icon20');
$ic21 = $params->get('icon21');
$ic22 = $params->get('icon22');
$ic23 = $params->get('icon23');
$ic24 = $params->get('icon24');
$ic25 = $params->get('icon25');

 
	
$url  =  $params->get('url1');
$url2 = $params->get('url2');
$url3 =	$params->get('url3');
$url4 =	$params->get('url4');
$url5 =	$params->get('url5');
$url6 =	$params->get('url6');
$url7 =	$params->get('url7');
$url8 =	$params->get('url8');
$url9 =	$params->get('url9');
$url10=$params->get('url10');
$url11=$params->get('url11');
$url12=$params->get('url12');
$url13=$params->get('url13');
$url14=$params->get('url14');
$url15=$params->get('url15');
$url16=$params->get('url16');
$url17=$params->get('url17');
$url18=$params->get('url18');
$url19=$params->get('url19');
$url20=$params->get('url20');
$url21=$params->get('url21');
$url22=$params->get('url22');
$url23=$params->get('url23');
$url24=$params->get('url24');
$url25=$params->get('url25');

	
 
?>

<style type="text/css">
   ul.genius li {
    display: inline-block;
    margin-right: <?php echo $margin;?>px;
    background:<?php echo $background;?> ;
    padding: <?php echo $padding;?>px;
    border-radius:<?php echo $radius;?>px;
     transition: transform 1s ;
    
}
  ul.genius li a{
  	color:<?php echo $color;?>
  }
    ul.genius li:hover{
   	 transform: scale(1.5);
   }
</style>
   <div class="mod_sociallinksgenius <?php echo $moduleclass_sfx;?>">
     <ul class="genius">
     	 <?php if($ic=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url;?>"   target="<?php echo $target;?>"><i class="<?php echo $ic.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic2=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url2;?>"  target="<?php echo $target;?>"><i class="<?php echo $ic2.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic3=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url3;?>"  target="<?php echo $target;?>"><i class="<?php echo $ic3.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic4=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url4;?>"  target="<?php echo $target;?>"><i class="<?php echo $ic4.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic5=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url5;?>"  target="<?php echo $target;?>"><i class="<?php echo $ic5.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic6=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url6;?>"  target="<?php echo $target;?>"><i class="<?php echo $ic6.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic7=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url7;?>"  target="<?php echo $target;?>"><i class="<?php echo $ic7.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic8=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url8;?>"  target="<?php echo $target;?>"><i class="<?php echo $ic8.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic9=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url9;?>"  target="<?php echo $target;?>"><i class="<?php echo $ic9.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic10=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url10;?>" target="<?php echo $target;?>"><i class="<?php echo $ic10.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic11=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url11;?>" target="<?php echo $target;?>"><i class="<?php echo $ic11.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic12=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url12;?>" target="<?php echo $target;?>"><i class="<?php echo $ic12.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic13=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url13;?>" target="<?php echo $target;?>"><i class="<?php echo $ic13.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic14=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url14;?>" target="<?php echo $target;?>"><i class="<?php echo $ic14.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic15=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url15;?>" target="<?php echo $target;?>"><i class="<?php echo $ic15.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic16=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url16;?>" target="<?php echo $target;?>"><i class="<?php echo $ic16.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic17=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url17;?>" target="<?php echo $target;?>"><i class="<?php echo $ic17.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic18=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url18;?>" target="<?php echo $target;?>"><i class="<?php echo $ic18.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic19=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url19;?>" target="<?php echo $target;?>"><i class="<?php echo $ic19.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic20=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url20;?>" target="<?php echo $target;?>"><i class="<?php echo $ic20.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic21=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url21;?>" target="<?php echo $target;?>"><i class="<?php echo $ic21.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic22=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url22;?>" target="<?php echo $target;?>"><i class="<?php echo $ic22.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic23=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url23;?>" target="<?php echo $target;?>"><i class="<?php echo $ic23.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic24=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url24;?>" target="<?php echo $target;?>"><i class="<?php echo $ic24.' '.$size;?>";?></i></a></li>
         <?php } ?>
         <?php if($ic25=="none") {?>
         <?php } else { ?>
         <li><a href="<?php echo $url25;?>" target="<?php echo $target;?>"><i class="<?php echo $ic25.' '.$size;?>";?></i></a></li>
         <?php } ?>
     </ul>
   </div>

	
<?php	 
echo '<div style="clear: both;"></div>';
echo '<div style="margin-left: 10px; text-align: center; font-size: 10px; color: #999999;">';

echo '<div style="font-size: 9px; color: #808080; font-weight: normal; font-family: tahoma,verdana,arial,sans-serif; line-height: 1.28; text-align: right; direction: ltr;"><a href="https://www.nationalcprassociation.com/" target="_blank" style="color: #808080;" title="www.nationalcprassociation.com">National CPR association</a></div>';


echo '</div>';

?>
	
