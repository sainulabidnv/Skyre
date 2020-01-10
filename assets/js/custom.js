// JavaScript Document

/* Template	:	Skyre v1.0 */



(function ($) {
	'use strict';
	var $w = $(window), headerFixed = false, $body = $('body'), $navbar = $('.navbar');
	function wWidth() {
		return $w.width();
	}
	var wNow = wWidth();
	
	menuReposition(wNow);
	$w.on('resize', function () {
		wNow = wWidth();
		menuReposition(wNow);

	});

	/**
	 * Reposition dropdowns if they are out of screen.
	 * 
	 */
	function menuReposition(wm){
		if (wm > 991) {
			var dropdowns = $('.dropdown-menu');
			dropdowns.show();
			if (dropdowns.length > 1) {
				//Loop dropdowns and move them if needed.
				$.each(dropdowns, function (key, dropdown) {
					var windowWidth = wm;
					var submenu = $(dropdown);
					var bounding = submenu.offset().left;
					if (/webkit.*mobile/i.test(navigator.userAgent)) {
						bounding -= window.scrollX;
					}
					var dropdownWidth = submenu.outerWidth();
					if (bounding + dropdownWidth >= windowWidth) {
						$(dropdown).css({ 'right': '100%', 'left': 'auto' });
					} else{
						$(dropdown).css({ 'right': '', 'left': '' });
					}
				});
			}
			dropdowns.hide();
		}
	}
	
	
	
	  $( '.dropdown-toggle, .dropdown-item' ).on( 'click', function ( e ) {
		if ($w.width() < 992) {
			//e.preventDefault();
			e.stopPropagation();
			var menuItem = $( this ).parent( 'li' );
			$(menuItem).find('.dropdown-menu').toggle();
			$(menuItem).find('ul ul').hide();


		}
	  });
	  $( '.dropdown-itdem' ).on( 'touchstart click', function ( e ) {
		if ($w.width() < 992) {
			e.preventDefault();
			e.stopPropagation();
			var menuItem = $( this ).closest( 'ul' );
			$(menuItem).find('.child').toggle();
			$(menuItem).find('.child ul').hide();

		}
	  });


	// Active page menu when click
	var CurURL = window.location.href, urlSplit = CurURL.split("#");
	var $nav_link = $(".mainmenu li a");
	if ($nav_link.length > 0) {
		$nav_link.each(function () {
			if (CurURL === (this.href) && (urlSplit[1] !== "")) {
				$(this).closest("li").addClass("active").parent().closest("li").addClass("active");
			}
		});
	}

	// Sticky Menu
	var $is_sticky = $('.is-sticky');
	if ($is_sticky.length > 0) {
		var $mmenu = $('#mainmenu').offset();
		$w.scroll(function () {
			var $scroll = $w.scrollTop();
			if ($w.width() > 991) {
				if ($scroll > $mmenu.top) {
					if (!$is_sticky.hasClass('has-fixed')) { $is_sticky.addClass('has-fixed'); }
				} else {
					if ($is_sticky.hasClass('has-fixed')) { $is_sticky.removeClass('has-fixed'); }
				}
			} else {
				if ($is_sticky.hasClass('has-fixed')) { $is_sticky.removeClass('has-fixed'); }
			}
		});
	}

	// OnePage Scrolling
	$('a.nav-link[href*="#"]:not([href="#"])').on("click", function () {
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
	$w.scroll(function () {
		// declare variable
		var topPos = $(this).scrollTop();
		// if user scrolls down - show scroll to top button
		if (topPos > 100) { $(scrollTop).css("opacity", "1"); } else { $(scrollTop).css("opacity", "0"); }
	});
	$(scrollTop).click(function () { $('html, body').animate({ scrollTop: 0 }, 800); return false; });
	// - to top btn


	// Preloader
	var $preload = $('#preloader'), $loader = $('.loader');
	if ($preload.length > 0) {
		$w.on('load', function () {
			$loader.fadeOut(100);
			$preload.addClass("loaded");
			$preload.delay(100).fadeOut(300);
		});
	}


})(jQuery);




