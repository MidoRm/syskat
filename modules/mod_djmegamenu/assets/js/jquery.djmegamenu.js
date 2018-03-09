/**
 * @version $Id: jquery.djmegamenu.js 26 2014-12-02 02:21:41Z szymon $
 * @package DJ-MegaMenu
 * @copyright Copyright (C) 2013 DJ-Extensions.com, All rights reserved.
 * @license DJ-Extensions.com Proprietary Use License
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Szymon Woronowski - szymon.woronowski@design-joomla.eu
 */
(function($){

var DJMegaMenu = this.DJMegaMenu = function(menu, options){
	
	this.options = {
		delay: 500,						// delay before close submenu
		animIn: 'fadeIn',
		animOut: 'fadeOut',
		animSpeed: 'normal',
		duration: 450,		// depends on speed: normal - 450, fast - 250, slow - 650
		wrap: null,
		direction: 'ltr',
		event: 'mouseenter',
		touch: (('ontouchstart' in window) || (navigator.MaxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0)) // touch screens detection
	};
	
	this.init(menu, options);
};
	
DJMegaMenu.prototype.init = function(menu,options){
		
	var self = this;
	
	jQuery.extend(self.options, options);
		
	if(!menu.length) return;
		
	self.options.direction = window.getComputedStyle(document.body).getPropertyValue('direction');
	
	switch(self.options.animSpeed) {
		case 'fast': self.options.duration = 250; break;
		case 'slow': self.options.duration = 650; break;
	}
	
	menu.addClass(self.options.animSpeed);
	
	var kids = menu.find('li.dj-up');
	self.kids = [];
	
	if(!self.options.wrap) self.options.wrap = menu;
	else self.options.wrap = $('#'+self.options.wrap);
	
	kids.each(function(index){
		var kid = $(this);
		self.kids[index] = new DJMMenuItem(kid,0,self,self.options);
	});
	
	if(self.options.fixed && !self.options.touch) {
		$(window).load(self.makeSticky.bind(self, menu));
	}
	
};
	
DJMegaMenu.prototype.makeSticky = function(menu){
	
	var self = this;
	
	self.sticky = false;
	var wrapper = $('<div id="'+ menu.attr('id')+'sticky"></div>');
	wrapper.addClass('dj-megamenu');
	wrapper.addClass('dj-megamenu-'+self.options.theme);
	wrapper.addClass('dj-megamenu-sticky');
	wrapper.css({ position: 'fixed', top: self.options.offset, left: 0, width: '100%' });
	var step = menu.offset().top - self.options.offset;
	var placeholder = menu.clone();
	placeholder.attr('id', menu.attr('id')+'placeholder');
	placeholder.css('opacity', 0);
	var direction = self.options.direction == 'rtl' ? 'right' : 'left';
	$(window).scroll(self.scroll.bind(self, wrapper, menu, placeholder, step, direction, false));		
	$(window).resize(self.scroll.bind(self, wrapper, menu, placeholder, step, direction, true));
	
};
	
DJMegaMenu.prototype.scroll = function(wrapper, menu, placeholder, step, direction, resize){
	
	var self = this;
	
	if($(window).scrollTop() > step) {
		
		if(!self.sticky) {
			var coord = menu.offset();
			var position = direction=='left' ? coord.left : $(window).width() - coord.left - menu.outerWidth();
			menu.css(direction, position);
			placeholder.insertBefore(menu);
			menu.wrap(wrapper);
			self.sticky = true;
		} else if(resize) {
			var coord = placeholder.offset();
			var position = direction=='left' ? coord.left : $(window).width() - coord.left - menu.outerWidth();
			menu.css(direction, position);
		}
		
	} else if(self.sticky) {
		menu.unwrap();
		placeholder.detach();
		menu.css(direction, '');
		self.sticky = false;
	}
	
};

/* DJMenuItem private constructor class */
var DJMMenuItem = function(menu,level,parent,options){
	
	this.options = {};
	this.init(menu,level,parent,options);
};

DJMMenuItem.prototype.init = function(menu,level,parent,options){
    	
	var self = this;
	
	jQuery.extend(self.options, options);
		
	self.menu = menu;
	self.level = level;
	self.parent = parent;

	self.timer = null;
	self.sub = menu.find('> .dj-subwrap').first();
		
	var event = 'mouseenter';
	if(self.options.touch || self.options.event=='click_all') {
		event = 'click';
		var anchor = menu.find('> a').first();
		if(anchor.length) {
			if(menu.hasClass('separator')) anchor.css('cursor','pointer');
			anchor.on('click',function(e){
				if(self.sub.length && !self.menu.hasClass('hover')) e.preventDefault();
			});
		}
	} else if(self.options.event=='click' && menu.hasClass('separator')) {
		var anchor = menu.find('> a').first();
		if(anchor.length) anchor.css('cursor','pointer');
		event = 'click';
	}
	//console.log(event);
	self.menu.on(event,self.showSub.bind(self));
	self.menu.on('mouseleave',self.hideSub.bind(self));
	
	if(self.sub.length) {
		self.kids = [];
		self.initKids();
	}
};

DJMMenuItem.prototype.showSub = function(){
	
	var self = this;
	
	clearTimeout(self.timer);
	
	if(self.menu.hasClass('hover') && !self.sub.hasClass(self.options.animOut)) {
		return; // do nothing if menu is open
	}
	
	clearTimeout(self.animTimer);
	
	self.menu.addClass('hover');
	if (self.sub.length && !self.DirDone) self.checkDir();
	self.hideOther(); // hide other submenus at the same level
	if(self.sub.length) {
		self.sub.removeClass(self.options.animOut);
		self.sub.addClass(self.options.animIn);
	}
	
};

DJMMenuItem.prototype.hideSub = function(){
	
	var self = this;
	
	if(self.sub.length){		
		self.timer = setTimeout(function(){			
			self.sub.removeClass(self.options.animIn);
			self.sub.addClass(self.options.animOut);
			self.animTimer = setTimeout(function(){
				self.menu.removeClass('hover');
			}, self.options.duration);
		}, self.options.delay);
	} else {
		self.menu.removeClass('hover');
	}
	
};

DJMMenuItem.prototype.checkDir = function(){
	
	var self = this;
	self.DirDone = true;
	var sub = self.sub.offset();
	var wrap = self.options.wrap.offset();
	
	if(self.options.wrap.hasClass('dj-megamenu')) { // fix wrapper position for sticky menu
		var placeholder = $('#'+self.options.wrap.get('id')+'placeholder');
		if(placeholder.length) wrap = placeholder.offset();
	}
	
	if (self.options.direction == 'ltr') {
		var offset = sub.left + self.sub.outerWidth() - self.options.wrap.outerWidth() - wrap.left;
		if (offset > 0 || self.sub.hasClass('open-left')) {
			if(self.level) {
				self.sub.css('right', self.menu.outerWidth());
				self.sub.css('left', 'auto');
			} else {
				if(self.sub.hasClass('open-left')) {
					self.sub.css('right', self.menu.css('left'));
					self.sub.css('left', 'auto');
				} else {
					self.sub.css('margin-left', -offset);
				}
			}
		}
	} else if (self.options.direction == 'rtl') {
		var offset = sub.left - wrap.left;
		if (offset < 0 || self.sub.hasClass('open-right')) {
			if(self.level) {
				self.sub.css('left', self.menu.outerWidth());
				self.sub.css('right', 'auto');
			} else {
				if(self.sub.hasClass('open-right')) {
					self.sub.css('left', self.menu.css('right'));
					self.sub.css('right', 'auto');
				} else {
					self.sub.css('margin-right', offset);
				}
			}
		}
	}
};

DJMMenuItem.prototype.initKids = function(){
	
	var self = this;
	
	var kids = self.sub.find('> .dj-subwrap-in > .dj-subcol > ul.dj-submenu > li');
	//var sub_options = {h: self.options.hs, w: self.options.ws, o: self.options.os};
	//var cloneOptions = Object.clone(self.options);
	//sub_options = Object.merge(cloneOptions, sub_options);
	kids.each(function(index){
		var kid = $(this);
		self.kids[index] = new DJMMenuItem(kid,self.level + 1,self,self.options);
	});
};

DJMMenuItem.prototype.hideOther = function(){
	
	var self = this;
	
	$.each(self.parent.kids, function(index, kid){
		
		if(kid.menu.hasClass('hover') && kid != self) {
			
			if(kid.sub.length) {
				kid.hideOtherSub(); // hide next levels immediately
				
				kid.sub.removeClass(kid.options.animIn);
				kid.sub.addClass(kid.options.animOut);
				kid.animTimer = setTimeout(function(){
					kid.menu.removeClass('hover');
					//if((afterDJMenuHide)) afterDJMenuHide();
				}, self.options.duration);
			} else {
				kid.menu.removeClass('hover');
			}
		}
	});
};

DJMMenuItem.prototype.hideOtherSub = function(){
	
	var self = this;
	
	$.each(self.kids, function(index, kid){
		if(kid.sub.length) {
			kid.hideOtherSub();
			kid.sub.removeClass(kid.options.animIn);
			kid.sub.removeClass(kid.options.animOut);
		}
		kid.menu.removeClass('hover');
	});
};

})(jQuery);
