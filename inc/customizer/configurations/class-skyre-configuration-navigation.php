<?php
/**
 * Customizer Control: Nav configuration.
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
 
if ( ! class_exists( 'Skyre_Configuration_Nav' ) ) {

	/**
	 * Customizer configuration Initial setup
	 */
	class Skyre_Configuration_Nav  {

		/**
		 * Constructor
		 */
		public function __construct() {
			//$this->register_configuration( $wp_customize);
		}
		
		public function register_configuration( $wp_customize ) {
			$wp_customize->add_section('skyre_menu_options', array(
            'title' => __('Main Menu', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_main_options'
        ));
			$wp_customize->add_setting('skyre[sticky_header]', array(
                'type' => 'option',
                'sanitize_callback' => 'skyre_sanitize_checkbox'
            ));
            $wp_customize->add_control('skyre[sticky_header]', array(
                'label' => __('Disable Sticky menu', 'skyre'),
                'section' => 'skyre_menu_options',
                'type' => 'checkbox',
            ));
			
			
			$wp_customize->add_setting('skyre[box_shadow]', array(
                'type' => 'option',
                'sanitize_callback' => 'skyre_sanitize_checkbox'
            ));
            $wp_customize->add_control('skyre[box_shadow]', array(
                'label' => __('Disable Box Shadow', 'skyre'),
                'section' => 'skyre_menu_options',
                'type' => 'checkbox',
            ));
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting('skyre[mainmenu_bg]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new Skyre_Control_Color($wp_customize, 'skyre[mainmenu_bg]', array(
                'label' => __('Background', 'skyre'),
                'section' => 'skyre_menu_options',
            )));
			
        	$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting('skyre[sticky_bg]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new Skyre_Control_Color($wp_customize, 'skyre[sticky_bg]', array(
                'label' => __('Fixed menu background', 'skyre'),
                'section' => 'skyre_menu_options',
            )));

            $wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting('skyre[nav_dropdown_bg]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new Skyre_Control_Color($wp_customize, 'skyre[nav_dropdown_bg]', array(
                'label' => __('Dropdown background', 'skyre'),
                'section' => 'skyre_menu_options',
            )));

            $wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting('skyre[nav_dropdown_item]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new Skyre_Control_Color($wp_customize, 'skyre[nav_dropdown_item]', array(
                'label' => __('Dropdown menu color', 'skyre'),
                'section' => 'skyre_menu_options',
            )));

            $wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting('skyre[nav_dropdown_item_hover]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new Skyre_Control_Color($wp_customize, 'skyre[nav_dropdown_item_hover]', array(
                'label' => __('Dropdown menu hover color', 'skyre'),
                'section' => 'skyre_menu_options',
            )));

            $wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre[nav_border_height]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre[nav_border_height]',
				array(
					'label' 	=> __( 'Title Border', 'skyre' ),
					'section' 	=> 'skyre_menu_options',
					'type'    	=> 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre[nav_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre[nav_border_color]',
				array(
					'label' => __( 'Border Color', 'skyre' ),
					'section' => 'skyre_menu_options',
					
				)
			) );



			}
	}
}

