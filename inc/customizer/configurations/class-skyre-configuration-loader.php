<?php
/**
 * Customizer Control: Loader configuration.
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
 
if ( ! class_exists( 'Skyre_Configuration_Loader' ) ) {

	/**
	 * Customizer configuration Initial setup
	 */
	class Skyre_Configuration_Loader  {

		/**
		 * Constructor
		 */
		public function __construct() {
			//$this->register_configuration( $wp_customize);
		}
		
		public function register_configuration( $wp_customize ) {
			
			$wp_customize->add_section('skyre_loader_options', array(
            'title' => __('Preloader', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_main_options'
        ));
		
			$wp_customize->add_setting( 'skyre[loader]', array(
                    'type'  => 'option',
                    'sanitize_callback' => 'skyre_sanitize_checkbox',
            ) );
            // add checkbox control for excerpts/full posts toggle
            $wp_customize->add_control( 'skyre[loader]', array(
                    'label'     => esc_html__( 'Hide Pre Loader?', 'skyre' ),
                    'section'   => 'skyre_loader_options',
                    'priority'  => 10,
                    'type'      => 'checkbox'
            ) );
			
			$wp_customize->add_setting('skyre[loader_bg]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'sanitize_alpha_color'
            ));
            $wp_customize->add_control(new Skyre_Control_Color($wp_customize, 'skyre[loader_bg]', array(
                'label' => __('Loader Background', 'skyre'),
                'section' => 'skyre_loader_options',
            )));
			
			$wp_customize->add_setting('skyre[loader_primary]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'sanitize_alpha_color'
            ));
            $wp_customize->add_control(new Skyre_Control_Color($wp_customize, 'skyre[loader_primary]', array(
                'label' => __('Loader Primary Color', 'skyre'),
                'section' => 'skyre_loader_options',
            )));
			
			$wp_customize->add_setting('skyre[loader_secondary]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'sanitize_alpha_color'
            ));
            $wp_customize->add_control(new Skyre_Control_Color($wp_customize, 'skyre[loader_secondary]', array(
                'label' => __('Loader Secondary Color', 'skyre'),
                'section' => 'skyre_loader_options',
            )));
		
		
			
			}
	}
}

