/**
 * File responsive.js
 *
 * Handles the responsive
 *
 * @package Skyre
 */

	wp.customize.controlConstructor['skyre-responsive'] = wp.customize.Control.extend({

		// When we're finished loading continue processing.
		ready: function() {

			'use strict';

			var control = this,
		    value;

			control.responsiveInit();
			
			/**
			 * Save on change / keyup / paste
			 */
			this.container.on( 'change keyup paste', 'input.skyre-responsive-input, select.skyre-responsive-select', function() {

				value = jQuery( this ).val();

				// Update value on change.
				control.updateValue();
			});

			/**
			 * Refresh preview frame on blur
			 */
			this.container.on( 'blur', 'input', function() {

				value = jQuery( this ).val() || '';

				if ( value == '' ) {
					wp.customize.previewer.refresh();
				}

			});

		},

		/**
		 * Updates the sorting list
		 */
		updateValue: function() {

			'use strict';

			var control = this,
		    newValue = {};

		    // Set the spacing container.
			control.responsiveContainer = control.container.find( '.skyre-responsive-wrapper' ).first();

			control.responsiveContainer.find( 'input.skyre-responsive-input' ).each( function() {
				var responsive_input = jQuery( this ),
				item = responsive_input.data( 'id' ),
				item_value = responsive_input.val();

				newValue[item] = item_value;

			});

			control.responsiveContainer.find( 'select.skyre-responsive-select' ).each( function() {
				var responsive_input = jQuery( this ),
				item = responsive_input.data( 'id' ),
				item_value = responsive_input.val();

				newValue[item] = item_value;
			});

			control.setting.set( newValue );
		},

		responsiveInit : function() {
			
			'use strict';
			this.container.find( '.skyre-responsive-btns button' ).on( 'click', function( event ) {

				var device = jQuery(this).attr('data-device');
				jQuery( '.wp-full-overlay-footer .devices button[data-device="' + device + '"]' ).trigger( 'click' );
			});
		},
	});
	
	jQuery(' .wp-full-overlay-footer .devices button ').on('click', function() {

		var device = jQuery(this).attr('data-device');

		jQuery( '.customize-control-skyre-responsive .input-wrapper input, .customize-control .skyre-responsive-btns > li' ).removeClass( 'active' );
		jQuery( '.customize-control-skyre-responsive .input-wrapper input.' + device + ', .customize-control .skyre-responsive-btns > li.' + device ).addClass( 'active' );
	});
