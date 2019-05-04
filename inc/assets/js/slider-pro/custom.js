/*!
*  - v1.0
* Homepage: https://skyresoft.com/
* Author: sainul
* Author URL: https://skyresoft.com/
*/

( function( $ ) {
	/**
 	 * @param $scope The Widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */ 
	var skyreSlider = function( $scope, $ ) {
		
		var $target        = $scope.find( '.sk-slider' ),
			$imagesTagList = $( '.sp-image', $target ),
			instance       = null,
			defaultSettings = {
				imageScaleMode: 'cover',
				slideDistance: { size: 10, unit: 'px' },
				slideDuration: 500,
				sliderAutoplay: true,
				sliderAutoplayDelay: 2000,
				sliderAutoplayOnHover: 'pause',
				sliderFadeMode: false,
				sliderFullScreen: true,
				sliderFullscreenIcon: 'fa fa-arrows-alt',
				sliderHeight: { size: 600, unit: 'px' },
				sliderHeightTablet: { size: 400, unit: 'px' },
				sliderHeightMobile: { size: 300, unit: 'px' },
				sliderLoop: true,
				sliderNaviOnHover: false,
				sliderNavigation: true,
				sliderNavigationIcon: 'fa fa-angle-left',
				sliderPagination: false,
				sliderShuffle: false,
				sliderWidth: { size: 100, unit: '%' },
				thumbnailWidth: 120,
				thumbnailHeight: 80,
				thumbnails: true,
				rightToLeft: false,
			},
			instanceSettings = $target.data( 'settings' ) || {},
			settings        = $.extend( {}, defaultSettings, instanceSettings );
			

		if ( ! $target.length ) { return; }
		
		$target.imagesLoaded().progress( function( instance, image ) {
			var loadedImages = null,
				progressBarWidth = null;

			if ( image.isLoaded ) {

				if ( $( image.img ).hasClass( 'sp-image' ) ) {
					$( image.img ).addClass( 'image-loaded' );
				}

				loadedImages = $( '.image-loaded', $target );
				progressBarWidth = 100 * ( loadedImages.length / $imagesTagList.length ) + '%';

				$( '.sk-slider-loader', $target ).css( { width: progressBarWidth } );
			}

		} ).done( function( instance ) {

			$( '.slider-pro', $target ).addClass( 'slider-loaded' );
			$( '.sk-slider-loader', $target ).css( { 'display': 'none' } );
		} );
		
		var tabletHeight = '' !== settings['sliderHeightTablet']['size'] ? settings['sliderHeightTablet']['size'] + settings['sliderHeightTablet']['unit'] : settings['sliderHeight']['size'] + settings['sliderHeight']['unit'];
			var mobileHeight = '' !== settings['sliderHeightMobile']['size'] ? settings['sliderHeightMobile']['size'] + settings['sliderHeightMobile']['unit'] : settings['sliderHeight']['size'] + settings['sliderHeight']['unit'];

			$( '.slider-pro', $target ).sliderPro( {
				width: settings['sliderWidth']['size'] + settings['sliderWidth']['unit'],
				height: settings['sliderHeight']['size'] + settings['sliderHeight']['unit'],
				arrows: settings['sliderNavigation'],
				fadeArrows: settings['sliderNaviOnHover'],
				buttons: settings['sliderPagination'],
				autoplay: settings['sliderAutoplay'],
				autoplayDelay: settings['sliderAutoplayDelay'],
				autoplayOnHover: settings['sliderAutoplayOnHover'],
				fullScreen: settings['sliderFullScreen'],
				shuffle: settings['sliderShuffle'],
				loop: settings['sliderLoop'],
				fade: settings['sliderFadeMode'],
				slideDistance: ( 'string' !== typeof settings['slideDistance']['size'] ) ? settings['slideDistance']['size'] : 0,
				slideAnimationDuration: +settings['slideDuration'],
				//imageScaleMode: settings['imageScaleMode'],
				imageScaleMode: 'exact',
				waitForLayers: false,
				grabCursor: false,
				thumbnailWidth: settings['thumbnailWidth'],
				thumbnailHeight: settings['thumbnailHeight'],
				rightToLeft: settings['rightToLeft'],
				init: function() {
					this.resize();

					$( '.sp-previous-arrow', $target ).append( '<i class="' + settings['sliderNavigationIcon'] + '"></i>' );
					$( '.sp-next-arrow', $target ).append( '<i class="' + settings['sliderNavigationIcon'] + '"></i>' );

					$( '.sp-full-screen-button', $target ).append( '<i class="' + settings['sliderFullscreenIcon'] + '"></i>' );
				},
				breakpoints: {
					1023: {
						height: tabletHeight
					},
					767: {
						height: mobileHeight
					}
				}
			} );
		
	};
	
	// Make sure you run this code under Elementor.
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/sk-slider.default', skyreSlider );
	} );
} )( jQuery );
