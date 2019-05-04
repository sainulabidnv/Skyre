// JavaScript Document

/* Template	:	Skyre v1.0 */
(function($){
	'use strict';
	var $w = $(window), headerFixed = false, $body = $('body'), $navbar = $('.navbar');
	function wWidth () {
		return $w.width();
	}
	var wNow = wWidth();
	$w.on('resize', function () { 
		wNow = wWidth(); 
	});
	
	//=========== Dropdown Menu =============
	$('.mainmenu li.dropdown').hover(function() {
	  if ($w.width() > 991) {
	  	$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(300); }
	}, function() {
		if ($w.width() > 991) {
	  		$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(300);
		}
	});
	
	
	// Active page menu when click
	var CurURL = window.location.href, urlSplit = CurURL.split("#");
	var $nav_link = $(".mainmenu li a");
	if ($nav_link.length > 0) {
		$nav_link.each(function() {
			if (CurURL === (this.href) && (urlSplit[1]!=="")) {
				$(this).closest("li").addClass("active").parent().closest("li").addClass("active");
			}
		});
	}
	
		// Sticky Menu
	var $is_sticky = $('.is-sticky');
	if ($is_sticky.length > 0 ) {
		var $mmenu = $('#mainmenu').offset();
		$w.scroll(function(){
			var $scroll = $w.scrollTop();
			if ($w.width() > 991) {
				if($scroll > $mmenu.top ){
					if(!$is_sticky.hasClass('has-fixed')) {$is_sticky.addClass('has-fixed');}
				} else {
					if($is_sticky.hasClass('has-fixed')) {$is_sticky.removeClass('has-fixed');}
				}
			} else {
				if($is_sticky.hasClass('has-fixed')) {$is_sticky.removeClass('has-fixed');}
			}
		});
	}
	
	// OnePage Scrolling
	$('a.nav-link[href*="#"]:not([href="#"])').on("click", function() {
		if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
			var toHash = $(this.hash), toHashN = (this.hash.slice(1)) ? $('[name=' + this.hash.slice(1) + ']') : false, nbar = (wNow >= 992) ? $navbar.height() - 1 : 0;

			toHash = toHash.length ? toHash : toHashN;
			if (toHash.length) {
				$('html, body').animate({
					scrollTop: (toHash.offset().top - nbar)
				}, 1000, "easeInOutExpo");
				return false;
			}
		}
	});
	
		

	// + to top btn
	var scrollTop = $(".scrollTop");
	$w.scroll(function() {
		// declare variable
		var topPos = $(this).scrollTop();
		// if user scrolls down - show scroll to top button
		if (topPos > 100) {  $(scrollTop).css("opacity", "1"); } else { $(scrollTop).css("opacity", "0"); }
  });
  $(scrollTop).click(function() {  $('html, body').animate({ scrollTop: 0 }, 800); return false;  }); 
	// - to top btn
	

	// Preloader
	var $preload = $('#preloader'), $loader = $('.loader');
	if ($preload.length > 0) {
		$w.on('load', function() {
			$loader.fadeOut(300);
			$preload.addClass("loaded");
			$preload.delay(100).fadeOut(300);
		});
	}


})(jQuery);




