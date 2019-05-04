<?php
/**
 * Customizer Control: Footer configuration.
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
 
if ( ! class_exists( 'Skyre_Configuration_Footer' ) ) {

	/**
	 * Customizer configuration Initial setup
	 */
	class Skyre_Configuration_Footer extends WP_Customize_Control {

		/**
		 * Constructor
		 */
		public function __construct() {
			//$this->register_configuration( $wp_customize);
		}
		
		public function register_configuration( $wp_customize ) {
			
			/* skyre Footer Options */
        $wp_customize->add_section('skyre_footer_main', array(
            'title' => __('Footer', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_main_options'
        ));    
			
			$wp_customize->add_setting('skyre[footer_logo]', array(
                'default' => '',
                'type'  => 'option'
            ));
            $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'skyre[footer_logo]', array(
                'label' => __('Footer Logo/Icon', 'skyre'),
                'section' => 'skyre_footer_main',
				'mime_type' => 'image',
                'settings' => 'skyre[footer_logo]',
            )));
			
			$wp_customize->add_setting('skyre[footer_menu_hidden]', array(
                'type' => 'option',
                'sanitize_callback' => 'skyre_sanitize_checkbox'
            ));
            $wp_customize->add_control('skyre[footer_menu_hidden]', array(
                'label' => __('Hide Footer Menu', 'skyre'),
                'description' => sprintf(__('Check to hide menu in footer', 'skyre')),
                'section' => 'skyre_footer_main',
                'type' => 'checkbox',
            ));
			
			$wp_customize->add_setting('skyre[footer_social_hidden]', array(
                'type' => 'option',
                'sanitize_callback' => 'skyre_sanitize_checkbox'
            ));
            $wp_customize->add_control('skyre[footer_social_hidden]', array(
                'label' => __('Hide Social Icon', 'skyre'),
                'section' => 'skyre_footer_main',
                'type' => 'checkbox',
            ));
			
			$wp_customize->add_setting('skyre[custom_footer_text]', array(
                'default' => '',
                'type' => 'option',
                'sanitize_callback' => 'skyre_sanitize_strip_slashes'
            ));
            $wp_customize->add_control('skyre[custom_footer_text]', array(
                'label' => __('Footer information', 'skyre'),
                'description' => sprintf(__('Copyright text in footer', 'skyre')),
                'section' => 'skyre_footer_main',
                'type' => 'textarea'
            ));
			
			/* skyre Footer color Options */
        $wp_customize->add_section('skyre_footer_options', array(
            'title' => __('Footer style', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_main_options'
        ));
            //footer
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre[footer_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre[footer_bg_color]',
				array(
					'label' => __( 'Background', 'skyre' ),
					'section' => 'skyre_footer_options',
					
				)
			) );
			
			$wp_customize->add_setting('skyre[footer_bg_image]', array(
                'default' => '',
                'type'  => 'option'
            ));
            $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'skyre[footer_bg_image]', array(
                'label' => __('Background Image', 'skyre'),
                'section' => 'skyre_footer_options',
				'mime_type' => 'image',
                'settings' => 'skyre[footer_bg_image]',
            )));
			
			$wp_customize->add_setting('skyre[footer_bg_size]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_size',
            ));
			$wp_customize->add_control('skyre[footer_bg_size]', array(
                'label' => __('Background Size', 'skyre'),
                'section' => 'skyre_footer_options',
                'type' => 'select',
				'default' => '',
				'choices' => array(
					'' => __( '--Select--', 'skyre' ),
					'auto' => __( 'Auto', 'skyre' ),
					'cover' => __( 'Cover', 'skyre' ),
					'contain' => __( 'Contain', 'skyre' ),
					'100% 100%' => __( 'Full fit', 'skyre' ), ),
	  
            ));
			
			
			$wp_customize->add_setting('skyre[footer_bg_repeat]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_repeat',
            ));
			$wp_customize->add_control('skyre[footer_bg_repeat]', array(
                'label' => __('Background Repeat', 'skyre'),
                'section' => 'skyre_footer_options',
                'type' => 'select',
				'default' => 'repeat',
				'choices' => array(
					'' => __( '--Select--', 'skyre' ),
					'repeat' => __( 'Repeat', 'skyre' ),
					'repeat-x' => __( 'Repeat X', 'skyre' ),
					'repeat-y' => __( 'Repeat Y', 'skyre' ),
					'no-repeat' => __( 'No Repat', 'skyre' ), ),
	  
            ));
			
			$wp_customize->add_setting('skyre[footer_bg_position]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_position',
            ));
			$wp_customize->add_control('skyre[footer_bg_position]', array(
                'label' => __('Background Positions', 'skyre'),
                'section' => 'skyre_footer_options',
                'type' => 'select',
				'default' => 'repeat',
				'choices' => get_background_positions()
	  
            ));
			
			
			//social icons
            $wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting('skyre[footer_social_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'sanitize_alpha_color'
            ));
            $wp_customize->add_control(new Skyre_Control_Color($wp_customize, 'skyre[footer_social_color]', array(
                'label' => __('Social Icon Color', 'skyre'),
                'section' => 'skyre_footer_options',
            )));

            $wp_customize->add_setting('skyre[footer_social_hover_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'sanitize_alpha_color'
            ));
            $wp_customize->add_control(new Skyre_Control_Color($wp_customize, 'skyre[footer_social_hover_color]', array(
                'label' => __('Social Icon hover color', 'skyre'),
                'section' => 'skyre_footer_options',
            )));
			
			$wp_customize->add_setting('skyre[footer_widget_bg_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'sanitize_alpha_color'
            ));
            $wp_customize->add_control(new Skyre_Control_Color($wp_customize, 'skyre[footer_widget_bg_color]', array(
                'label' => __('Footer widget area background color', 'skyre'),
                'section' => 'skyre_footer_options',
            )));

			
		}
	}
}
