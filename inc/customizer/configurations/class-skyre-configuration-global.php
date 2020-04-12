<?php
/**
 * Customizer Control: Global configuration.
 *
 * @package     Skyre
 * @author      Skyretheme
 * @copyright   Copyright (c) 2019, Skyre
 * @link        https://skyretheme.com/sports
 * @since       1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Customizer configurations
 *
 * @since 1.0.0
 */
 
if ( ! class_exists( 'Skyre_Configuration_Global' ) ) {

	/**
	 * Customizer configuration Initial setup
	 */
	class Skyre_Configuration_Global extends WP_Customize_Control {

		/**
		 * Constructor
		 */
		public function __construct() {
			//$this->register_configuration( $wp_customize);
		}
		
		public function register_configuration( $wp_customize ) {
			// Global options
            $wp_customize->add_section('skyre_global_options', array(
				'title' => __('Body style', 'skyre'),
				'priority' => 31,
				'panel' => 'skyre_main_options'
			));
            
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre[bodybg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'skyre_sanitize_hexcolor'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre[bodybg_color]',
				array(
					'label' => __( 'Body background', 'skyre' ),
					'section' => 'skyre_global_options',
					
				)
			) );
			
			
			$wp_customize->add_setting('skyre[bodybg_image]', array(
                'default' => '',
				'type'  => 'option', 
				'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'skyre[bodybg_image]', array(
                'label' => __('Background Image', 'skyre'),
                'section' => 'skyre_global_options',
				'mime_type' => 'image',
                'settings' => 'skyre[bodybg_image]',
            )));
			
			$wp_customize->add_setting('skyre[bodybg_size]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_size',
            ));
			$wp_customize->add_control('skyre[bodybg_size]', array(
                'label' => __('Background Size', 'skyre'),
                'section' => 'skyre_global_options',
                'type' => 'select',
				'default' => '',
				'choices' => array(
					'' => __( '--Select--', 'skyre' ),
					'auto' => __( 'Auto', 'skyre' ),
					'cover' => __( 'Cover', 'skyre' ),
					'contain' => __( 'Contain', 'skyre' ),
					'100% 100%' => __( 'Full fit', 'skyre' ), ),
	  
            ));
			
			$wp_customize->add_setting('skyre[bodybg_repeat]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_repeat',
            ));
			$wp_customize->add_control('skyre[bodybg_repeat]', array(
                'label' => __('Background Repeat', 'skyre'),
                'section' => 'skyre_global_options',
                'type' => 'select',
				'choices' => array(
					'' => __( '--Select--', 'skyre' ),
					'repeat' => __( 'Repeat', 'skyre' ),
					'repeat-x' => __( 'Repeat X', 'skyre' ),
					'repeat-y' => __( 'Repeat Y', 'skyre' ),
					'no-repeat' => __( 'No Repat', 'skyre' ), ),
	  
            ));
			
			$wp_customize->add_setting('skyre[bodybg_bg_position]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_position',
            ));
			$wp_customize->add_control('skyre[bodybg_bg_position]', array(
                'label' => __('Background Positions', 'skyre'),
                'section' => 'skyre_global_options',
                'type' => 'select',
				'default' => 'repeat',
				'choices' => get_background_positions()
	  
			));
			
				/* skyre Main color Options */
				$wp_customize->add_section('skyre_main_color_options', array(
					'title' => __('Color Options', 'skyre'),
					'priority' => 31,
					'panel' => 'skyre_main_options'
				));

				//Primary Color
					$wp_customize->register_control_type( 'Skyre_Control_Color' );
					$wp_customize->add_setting( 'skyre[primary_color]',
						array(
							'default' => '#030e20',
							'type'  => 'option',
							/*'transport'   => 'postMessage', on chnage not working */
							'sanitize_callback' => 'skyre_sanitize_hexcolor'
						)
					);
					$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre[primary_color]',
						array(
							'label' => __( 'Primary Color', 'skyre' ),
							'section' => 'skyre_main_color_options',
							
						)
					) );

				//Secondary Color
					$wp_customize->register_control_type( 'Skyre_Control_Color' );
					$wp_customize->add_setting( 'skyre[secondary_color]',
						array(
							'default' => '#d7372b',
							'type'  => 'option',
							/*'transport'   => 'postMessage', on chnage not working */
							'sanitize_callback' => 'sanitize_alpha_color'
						)
					);
					$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre[secondary_color]',
						array(
							'label' => __( 'Secondary Color', 'skyre' ),
							'section' => 'skyre_main_color_options',
							
						)
					) );

				//Font Color
					$wp_customize->register_control_type( 'Skyre_Control_Color' );
					$wp_customize->add_setting( 'skyre[global_font_color]',
						array(
							'default' => '#030e20',
							'type'  => 'option',
							/*'transport'   => 'postMessage', on chnage not working */
							'sanitize_callback' => 'sanitize_alpha_color'
						)
					);
					$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre[global_font_color]',
						array(
							'label' => __( 'Font Color', 'skyre' ),
							'section' => 'skyre_main_color_options',
							
						)
					) );
					
				//Secondary Font Color
					$wp_customize->register_control_type( 'Skyre_Control_Color' );
					$wp_customize->add_setting( 'skyre[white_color]',
						array(
							'default' => '#fff',
							'type'  => 'option',
							/*'transport'   => 'postMessage', on chnage not working */
							'sanitize_callback' => 'sanitize_alpha_color'
						)
					);
					$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre[white_color]',
						array(
							'label' => __( 'Secondary Font Color', 'skyre' ),
							'section' => 'skyre_main_color_options',
							
						)
					) );

				/* skyre theme activation */
				
				
				$wp_customize->add_section('skyre_theme_activation_section', array(
					'title' => __('Theme Activation', 'skyre'),
					'priority' => 9,
					'description' =>  sprintf(
						__( 'Click on this %1$s Generate A Personal Token link %2$s and Copy the token number and paste it into the field below and click the Publish button.', 'skyre' ), '<a href="https://build.envato.com/create-token/?purchase:download=t&purchase:verify=t&purchase:list=t">', '</a>' ). '<a href="https://support.skyretheme.com/docs/skyresports/getting-started/theme-activation/"> '.__('Read Documentation','skyre').'</a>' 
				) );

					$wp_customize->add_setting('envato_market[token]', array(
						'default' => '',
						'type' => 'option',
						'sanitize_callback' => 'sanitize_text_field'
					));
					$wp_customize->add_control('envato_market[token]', array(
						'label' => __('Activation Code', 'skyre'),
						'section' => 'skyre_theme_activation_section',
						'type' => 'text'
					));

					

				
				
					
		}
	}
}
