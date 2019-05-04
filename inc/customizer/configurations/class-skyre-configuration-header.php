<?php
/**
 * Customizer Control: Header configuration.
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
 
if ( ! class_exists( 'Skyre_Configuration_Header' ) ) {

	/**
	 * Customizer configuration Initial setup
	 */
	class Skyre_Configuration_Header  {

		/**
		 * Constructor
		 */
		public function __construct() {
			//$this->register_configuration( $wp_customize);
		}
		
		public function register_configuration( $wp_customize ) {
			
			        $wp_customize->add_section('skyre_header_options', array(
            'title' => __('Page Header', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_main_options'
        ));
        
            
			$wp_customize->add_setting( 'skyre[page_title]', array(
                    'type'  => 'option',
                    'sanitize_callback' => 'skyre_sanitize_checkbox',
            ) );
            // add checkbox control for excerpts/full posts toggle
            $wp_customize->add_control( 'skyre[page_title]', array(
                    'label'     => esc_html__( 'Hide Page title?', 'skyre' ),
                    'section'   => 'skyre_header_options',
                    'priority'  => 10,
                    'type'      => 'checkbox'
            ) );
			
			$wp_customize->add_setting('skyre[header_height]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_number_px'
            ));
            $wp_customize->add_control('skyre[header_height]', array(
                'label' => __('Height', 'skyre'),
				'section' => 'skyre_header_options',
				'type' => 'text',
            ));
			
			$wp_customize->add_setting('skyre[header_bg_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[header_bg_color]', array(
                'label' => __('Header background', 'skyre'),
				'description' => __('Default page header background, Onepage layout will not support', 'skyre'),
                'section' => 'skyre_header_options',
            )));
			
			$wp_customize->add_setting('skyre[header_bg_image]', array(
                'default' => '',
                'type'  => 'option'
            ));
            $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'skyre[header_bg_image]', array(
                'label' => __('Background Image', 'skyre'),
                'section' => 'skyre_header_options',
				'mime_type' => 'image',
                'settings' => 'skyre[header_bg_image]',
            )));
			
			$wp_customize->add_setting('skyre[header_bg_repeat]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_repeat',
            ));
			$wp_customize->add_control('skyre[header_bg_repeat]', array(
                'label' => __('Background Repeat', 'skyre'),
                'section' => 'skyre_header_options',
                'type' => 'select',
				'default' => 'repeat',
				'choices' => array(
					'' => __( '--Select--', 'skyre' ),
					'repeat' => __( 'Repeat', 'skyre' ),
					'repeat-x' => __( 'Repeat X', 'skyre' ),
					'repeat-y' => __( 'Repeat Y', 'skyre' ),
					'no-repeat' => __( 'No Repat', 'skyre' ), ),
	  
            ));
			
			$wp_customize->add_setting('skyre[header_bg_position]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_position',
            ));
			$wp_customize->add_control('skyre[header_bg_position]', array(
                'label' => __('Background Positions', 'skyre'),
                'section' => 'skyre_header_options',
                'type' => 'select',
				'default' => 'repeat',
				'choices' => get_background_positions()
	  
            ));
			
			$wp_customize->add_setting('skyre[header_padding_lr]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_number_px'
            ));
            $wp_customize->add_control('skyre[header_padding_lr]', array(
                'label' => __('Title padding left-right', 'skyre'),
				'section' => 'skyre_header_options',
				'type' => 'text',
            ));
			
			$wp_customize->add_setting('skyre[header_padding_tb]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_number_px'
            ));
            $wp_customize->add_control('skyre[header_padding_tb]', array(
                'label' => __('Title padding top-bottom', 'skyre'),
				'section' => 'skyre_header_options',
				'type' => 'text',
            ));

			}
	}
}

