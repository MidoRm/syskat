/*--------------------------------------------------------------
# Copyright (C) joomla-monster.com
# License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
# Website: http://www.joomla-monster.com
# Support: info@joomla-monster.com
---------------------------------------------------------------*/

//Set Module's Height script

function setModulesHeight() {
	var regexp = new RegExp("_mod([0-9]+)$");

	var jmmodules = jQuery(document).find('.jm-module') || [];
	if (jmmodules.length) {
		jmmodules.each(function(index,element){
			var match = regexp.exec(element.className) || [];
			if (match.length > 1) {
				var modHeight = parseInt(match[1]);
				jQuery(element).find('.jm-module-in').css('height', modHeight + 'px');
			}
		});
	}
}

jQuery(document).ready(function(){
	
	setModulesHeight();

});

//search hide

jQuery(document).ready(function(){
	var djMenu = jQuery('#jm-djmenu');
	if (djMenu.length > 0) {
		
		var searchModule = djMenu.find('.search-ms');
		var searchModuleInput = djMenu.find('#mod-search-searchword');
		var searchModuleButton = searchModule.find('.button');

		if (searchModule.length > 0 && searchModuleButton.length > 0 ) {
	
	  		searchModuleButton.mouseover(function (event) {
	  	        searchModuleInput.addClass('show');
	  	        searchModuleInput.focus();  
	  	    }); 
	  	    
	        searchModuleInput.focusout(function() {
	  	    	searchModuleInput.removeClass('show');
	  	    });

		}
	}  
});