/**
 * File dimension.js
 *
 * Handles the responsive
 *
 * @package Skyre
 */

	wp.customize.controlConstructor['skyre-dimension'] = wp.customize.Control.extend({

		ready: function() {

			'use strict';

			var control = this;
			
			
			this.container.on( 'change keyup paste', 'input', function() {

				
				var newValue = {
					desktop : {},
					tablet : {},
					mobile : {},
					};
					
				control.container.find( 'input' ).each( function() {
					var input = jQuery( this );
					var id = input.data( 'id' );
					var device = input.data( 'device' );
					var item_value = input.val();
	
					newValue[device][id] = item_value;
				});
			
				control.setting.set( newValue );
				
			});
			
			this.container.on( 'click', '.rsbtn', function() {
				
				var rsbtn = jQuery( this ).data( 'id' );
				control.container.find( '.active' ).removeClass('active');
				jQuery( this ).addClass('active')
				control.container.find( '.'+rsbtn ).addClass('active');
				jQuery( '.wp-full-overlay-footer .devices button[data-device="' + rsbtn + '"]' ).trigger( 'click' );
			});
			 

			this.container.on( 'blur', 'input', function() {

				value = jQuery( this ).val() || '';
				
				if ( value == '' ) {
					wp.customize.previewer.refresh();
				}

			});
			
		}

	});
	
