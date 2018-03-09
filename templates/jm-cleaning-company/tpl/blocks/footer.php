<?php
/*--------------------------------------------------------------
# Copyright (C) joomla-monster.com
# License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
# Website: http://www.joomla-monster.com
# Support: info@joomla-monster.com
---------------------------------------------------------------*/

defined('_JEXEC') or die;

//get information about 'back to top' button
$backtotop = $this->params->get('backToTop', '1');

?>

<footer id="jm-footer">
	<div class="container-fluid clearfix jm-footer">
		<div id="jm-footer-in" class="row-fluid">
			<?php if($this->checkModules('copyrights')) : ?>
			<div id="jm-footer-left" class="span4 pull-left <?php echo $this->getClass('copyrights') ?>">
				<div id="jm-copyrights">
					<jdoc:include type="modules" name="<?php echo $this->getPosition('copyrights') ?>" style="raw"/>
				</div>
			</div>
			<?php endif; ?>
			<?php if($this->checkModules('social')) : ?>
			<div id="jm-footer-center" class="span4 pull-left <?php echo $this->getClass('social') ?>">               
				<jdoc:include type="modules" name="<?php echo $this->getPosition('social') ?>" style="raw"/>
			</div>
			<?php endif; ?>
			<div id="jm-footer-right" class="span4 pull-right">
					<div id="jm-poweredby">
							<a href="http://www.joomla-monster.com" target="_blank" title="Joomla Templates">Joomla Templates</a> by Joomla-Monster.com
					</div>
			</div>
		</div>
	</div>
</footer>

<?php if($backtotop == '1') : ?>
  <p id="jm-back-top"><a id="backtotop" href="#top"><span>&nbsp;</span></a></p>
<?php endif; ?>