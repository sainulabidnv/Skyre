<?php
/**
 * Customizer Control: Widget configuration.
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
 
if ( ! class_exists( 'Skyre_Configuration_Widget' ) ) {

	/**
	 * Customizer configuration Initial setup
	 */
	class Skyre_Configuration_Widget  {

		/**
		 * Constructor
		 */
		public function __construct() {
			//$this->register_configuration( $wp_customize);
		}
		
		public function register_configuration( $wp_customize ) {
			
			//post panel
			$wp_customize->add_panel('skyre_widget_panel', array(
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __('Sidebar settings', 'skyre'),
			'priority' => 10 // Mixed with top-level-section hierarchy.
		));
			
			
		$wp_customize->add_section('skyre_widget_layout', array(
            'title' => __('Widget style', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_widget_panel'
        ));
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_widget[bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_widget[bg_color]',
				array(
					'label' => __( 'background', 'skyre' ),
					'section' => 'skyre_widget_layout',
					
				)
			) );
			
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_widget[margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_widget[margin]',
				array(
					'label' => __( 'Margin', 'skyre' ),
					'section' => 'skyre_widget_layout',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_widget[padding]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_widget[padding]',
				array(
					'label' => __( 'Padding', 'skyre' ),
					'section' => 'skyre_widget_layout',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_widget[border]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_widget[border]',
				array(
					'label' => __( 'Border', 'skyre' ),
					'section' => 'skyre_widget_layout',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_widget[border_radius]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_widget[border_radius]',
				array(
					'label' => __( 'Border radius', 'skyre' ),
					'section' => 'skyre_widget_layout',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_widget[border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_widget[border_color]',
				array(
					'label' => __( 'Border Color', 'skyre' ),
					'section' => 'skyre_widget_layout',
					
				)
			) );
			
			
		//widget sections	
		$wp_customize->add_section('skyre_widget_section_style', array(
            'title' => __('Widget section style', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_widget_panel'
        ));
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_widget[section_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_widget[section_bg_color]',
				array(
					'label' => __( 'Section background', 'skyre' ),
					'section' => 'skyre_widget_section_style',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_widget[section_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_widget[section_margin]',
				array(
					'label' => __( 'Section margin', 'skyre' ),
					'section' => 'skyre_widget_section_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_widget[section_padding]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_widget[section_padding]',
				array(
					'label' => __( 'Section Padding', 'skyre' ),
					'section' => 'skyre_widget_section_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_widget[section_border]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_widget[section_border]',
				array(
					'label' => __( 'Section border', 'skyre' ),
					'section' => 'skyre_widget_section_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_widget[section_border_radius]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_widget[section_border_radius]',
				array(
					'label' => __( 'Section border radius', 'skyre' ),
					'section' => 'skyre_widget_section_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_widget[section_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_widget[section_border_color]',
				array(
					'label' => __( 'Section border Color', 'skyre' ),
					'section' => 'skyre_widget_section_style',
					
				)
			) );

			//widget section title	
		$wp_customize->add_section('skyre_widget_section_title', array(
            'title' => __('Section title', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_widget_panel'
        ));
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_widget[section_title_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_widget[section_title_bg_color]',
				array(
					'label' => __( 'Title background', 'skyre' ),
					'section' => 'skyre_widget_section_title',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_widget[section_title_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_widget[section_title_margin]',
				array(
					'label' => __( 'Title margin', 'skyre' ),
					'section' => 'skyre_widget_section_title',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_widget[section_title_padding]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_widget[section_title_padding]',
				array(
					'label' => __( 'Title Padding', 'skyre' ),
					'section' => 'skyre_widget_section_title',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_widget[section_title_border]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_widget[section_title_border]',
				array(
					'label' => __( 'Title border', 'skyre' ),
					'section' => 'skyre_widget_section_title',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_widget[section_title_border_radius]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_widget[section_title_border_radius]',
				array(
					'label' => __( 'Title border radius', 'skyre' ),
					'section' => 'skyre_widget_section_title',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_widget[section_title_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_widget[section_title_border_color]',
				array(
					'label' => __( 'Title border Color', 'skyre' ),
					'section' => 'skyre_widget_section_title',
					
				)
			) );
			
		//widget List style	
		$wp_customize->add_section('skyre_widget_list', array(
            'title' => __('Widget List style (li)', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_widget_panel'
        ));
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_widget[list_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_widget[list_bg_color]',
				array(
					'label' => __( 'List background', 'skyre' ),
					'section' => 'skyre_widget_list',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_widget[list_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_widget[list_margin]',
				array(
					'label' => __( 'List margin', 'skyre' ),
					'section' => 'skyre_widget_list',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_widget[list_padding]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_widget[list_padding]',
				array(
					'label' => __( 'List Padding', 'skyre' ),
					'section' => 'skyre_widget_list',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_widget[list_border]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_widget[list_border]',
				array(
					'label' => __( 'List border', 'skyre' ),
					'section' => 'skyre_widget_list',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_widget[list_border_radius]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_widget[list_border_radius]',
				array(
					'label' => __( 'List border radius', 'skyre' ),
					'section' => 'skyre_widget_list',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_widget[list_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_widget[list_border_color]',
				array(
					'label' => __( 'List border Color', 'skyre' ),
					'section' => 'skyre_widget_list',
					
				)
			) );
		
		}
	}
}

