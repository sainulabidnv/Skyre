<?php
/**
 * Customizer Control: Global configuration.
 *
 * @package     Skyre
 * @author      Skyre
 * @copyright   Copyright (c) 2019, Skyre
 * @link        https://skyresoft.com/template/skyre
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
                'type'  => 'option'
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
			}
	}
}
