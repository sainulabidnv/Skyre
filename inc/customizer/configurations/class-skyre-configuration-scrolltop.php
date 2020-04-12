<?php
/**
 * Customizer Control: Scrolltop configuration.
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
 
if ( ! class_exists( 'Skyre_Configuration_Scrolltop' ) ) {

	/**
	 * Customizer configuration Initial setup
	 */
	class Skyre_Configuration_Scrolltop  {

		/**
		 * Constructor
		 */
		public function __construct() {
			//$this->register_configuration( $wp_customize);
		}
		
		public function register_configuration( $wp_customize ) {
			$wp_customize->add_section('skyre_scrolltop_options', array(
            'title' => __('Scroll to Top', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_main_options'
        ));
			
			$wp_customize->add_setting( 'skyre[scrolltop]', array(
                    'type'  => 'option',
                    'sanitize_callback' => 'skyre_sanitize_checkbox',
            ) );
            
			$wp_customize->add_control( 'skyre[scrolltop]', array(
                    'label'     => esc_html__( 'Hide Scroll to Top?', 'skyre' ),
                    'section'   => 'skyre_scrolltop_options',
                    'priority'  => 10,
                    'type'      => 'checkbox'
            ) );
			
			$wp_customize->add_setting('skyre[scrolltop_bg]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'sanitize_alpha_color'
            ));
            $wp_customize->add_control(new Skyre_Control_Color($wp_customize, 'skyre[scrolltop_bg]', array(
                'label' => __('Background', 'skyre'),
                'section' => 'skyre_scrolltop_options',
            )));
			
			$wp_customize->add_setting('skyre[scrolltop_hover_bg]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'sanitize_alpha_color'
            ));
            $wp_customize->add_control(new Skyre_Control_Color($wp_customize, 'skyre[scrolltop_hover_bg]', array(
                'label' => __('Hover background', 'skyre'),
                'section' => 'skyre_scrolltop_options',
            )));
			
			$wp_customize->add_setting('skyre[scrolltop_icon]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'sanitize_alpha_color'
            ));
            $wp_customize->add_control(new Skyre_Control_Color($wp_customize, 'skyre[scrolltop_icon]', array(
                'label' => __('Text color', 'skyre'),
                'section' => 'skyre_scrolltop_options',
            )));
			
			$wp_customize->add_setting('skyre[scrolltop_icon_hover]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'sanitize_alpha_color'
            ));
            $wp_customize->add_control(new Skyre_Control_Color($wp_customize, 'skyre[scrolltop_icon_hover]', array(
                'label' => __('Text hover color', 'skyre'),
                'section' => 'skyre_scrolltop_options',
            )));
		
		
            $wp_customize->add_setting('skyre[scrolltop_border]', array(
                'default' => '10',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_number'
            ));
			
			$wp_customize->add_control( 'skyre[scrolltop_border]', array(
			  'type' => 'range',
			  'section' => 'skyre_scrolltop_options',
			  'label' => __('Border radius', 'skyre'),
			  'input_attrs' => array(
				'min' => 0,
				'max' => 100,
				'step' => 1,
			  ),
			) );

			}
	}
}

