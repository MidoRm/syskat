<?php
/*--------------------------------------------------------------
# Copyright (C) joomla-monster.com
# License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
# Website: http://www.joomla-monster.com
# Support: info@joomla-monster.com
---------------------------------------------------------------*/

defined('_JEXEC') or die;
?>

<?php if($this->countFlexiblock('bottom')) : ?>
<section id="jm-bottom" class="<?php echo $this->getClass('block#bottom'); ?>">
	<div class="container-fluid">
		<div id="jm-bottom-in">
			<?php echo $this->renderFlexiblock('bottom','jmmodule'); ?>
		</div>
	</div>
</section>
<?php endif; ?>