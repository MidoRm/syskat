/*--------------------------------------------------------------
# Copyright (C) joomla-monster.com
# License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
# Website: http://www.joomla-monster.com
# Support: info@joomla-monster.com
---------------------------------------------------------------*/

// Sticky Bar
var JMresizeTimer;
function JMtoolbarResize() {
	var body = jQuery('body');
	var allpage = jQuery('#jm-allpage');
		
		if(body.hasClass('sticky-bar')) {
	var bar = allpage.find('#jm-bar-wrapp');
		if (bar.length > 0) {
			var offset = bar.outerHeight();
			allpage.css('padding-top', (offset) + 'px');
		}
	}
};

jQuery(window).load(function(){   

	JMtoolbarResize();
	
	jQuery(window).resize(function() {
		clearTimeout(JMresizeTimer);
		JMresizeTimer = setTimeout(JMtoolbarResize, 30);
	});
    
  jQuery(window).scroll(function() {
		var JMresizeTimer;
		var topbar = jQuery('#jm-bar-wrapp');
		if (topbar.length > 0) {
			var scroll = jQuery(window).scrollTop();
			if (scroll >= 20) {
					topbar.addClass("scrolled");
					//clearTimeout(JMresizeTimer);
					//JMresizeTimer = setTimeout(JMtoolbarResize, 300); //0.30s delay for transition
			} else {
					topbar.removeClass("scrolled");
					//clearTimeout(JMresizeTimer);
					//JMresizeTimer = setTimeout(JMtoolbarResize, 300); //0.30s delay for transition
			}
		}
	});
});