<?php
/**
 * Customizer Control: Miscellaneous configuration.
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
 
if ( ! class_exists( 'Skyre_Configuration_Miscellaneous' ) ) {

	/**
	 * Customizer configuration Initial setup
	 */
	class Skyre_Configuration_Miscellaneous  {

		/**
		 * Constructor
		 */
		public function __construct() {
			//$this->register_configuration( $wp_customize);
		}
		
		public function register_configuration( $wp_customize ) {
			
			/* 404 Options */
        $wp_customize->add_section('skyre_404', array(
            'title' => __('404 error page', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_main_options'
        ));
			
			$wp_customize->add_setting( 'skyre[errorpage]', array(
                    'type'  => 'option',
                    'sanitize_callback' => 'absint',
            ) );
            
			$wp_customize->add_control( 'skyre[errorpage]', array(
                    'label'     => esc_html__( 'Select page', 'skyre' ),
                    'section'   => 'skyre_404',
                    'priority'  => 10,
                    'type'      => 'dropdown-pages'
            ) );
	   
	   //comment forms
		$wp_customize->add_section('skyre_form', array(
            'title' => __('Form fields', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_main_options'
        ));
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre[form_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre[form_color]',
				array(
					'label' => __( 'Color', 'skyre' ),
					'section' => 'skyre_form',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre[form_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre[form_bg_color]',
				array(
					'label' => __( 'Form fields background', 'skyre' ),
					'section' => 'skyre_form',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre[form_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre[form_margin]',
				array(
					'label' => __( 'Form fields margin', 'skyre' ),
					'section' => 'skyre_form',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre[form_padding]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre[form_padding]',
				array(
					'label' => __( 'Form fields Padding', 'skyre' ),
					'section' => 'skyre_form',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre[form_border]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre[form_border]',
				array(
					'label' => __( 'Form fields border', 'skyre' ),
					'section' => 'skyre_form',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre[form_border_radius]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre[form_border_radius]',
				array(
					'label' => __( 'Form fields border radius', 'skyre' ),
					'section' => 'skyre_form',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre[form_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre[form_border_color]',
				array(
					'label' => __( 'Form fields border Color', 'skyre' ),
					'section' => 'skyre_form',
					
				)
			) );
		
		//Form button
		$wp_customize->add_section('skyre_form_button', array(
            'title' => __('Form button', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_main_options'
        ));
			
			$wp_customize->add_setting( 'skyre[form_button_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre[form_button_color]',
				array(
					'label' => __( 'Color', 'skyre' ),
					'section' => 'skyre_form_button',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre[form_button_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre[form_button_bg_color]',
				array(
					'label' => __( 'Form button background', 'skyre' ),
					'section' => 'skyre_form_button',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre[form_button_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre[form_button_margin]',
				array(
					'label' => __( 'Form button margin', 'skyre' ),
					'section' => 'skyre_form_button',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre[form_button_padding]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre[form_button_padding]',
				array(
					'label' => __( 'Form button Padding', 'skyre' ),
					'section' => 'skyre_form_button',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre[form_button_border]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre[form_button_border]',
				array(
					'label' => __( 'Form button border', 'skyre' ),
					'section' => 'skyre_form_button',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre[form_button_border_radius]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre[form_button_border_radius]',
				array(
					'label' => __( 'Form button border radius', 'skyre' ),
					'section' => 'skyre_form_button',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre[form_button_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre[form_button_border_color]',
				array(
					'label' => __( 'Form button border Color', 'skyre' ),
					'section' => 'skyre_form_button',
					
				)
			) );
	   
	    /* skyre Other Options */
        $wp_customize->add_section('skyre_other_options', array(
            'title' => __('Custom CSS', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_main_options'
        ));
            $wp_customize->add_setting('skyre[custom_css]', array(
                'default' => '',
                'type' => 'option',
                'sanitize_callback' => 'skyre_sanitize_textarea'
            ));
            $wp_customize->add_control('skyre[custom_css]', array(
                'label' => __('Custom CSS', 'skyre'),
                'description' => sprintf(__('Additional CSS', 'skyre')),
                'section' => 'skyre_other_options',
                'type' => 'textarea'
            ));

        /* skyre Contact Options */
		$wp_customize->add_section('skyre_important_links', array(
            'priority' => 5,
            'title' => __('Support and Documentation', 'skyre')
        ));
            $wp_customize->add_setting('skyre[imp_links]', array(
              'sanitize_callback' => 'esc_url_raw'
            ));
            $wp_customize->add_control(
            new Cryptic_Control_link(
            $wp_customize,
                'skyre[imp_links]', array(
                'section' => 'skyre_important_links',
                'type' => 'skyre-control-links'
            )));
		
		// add "Content Options" section
        $wp_customize->add_section( 'skyre_content_section' , array(
                'title'      => esc_html__( 'Content Options', 'skyre' ),
                'priority'   => 50,
                'panel' => 'skyre_main_options'
        ) );
            // add setting for excerpts/full posts toggle
            $wp_customize->add_setting( 'skyre_excerpts', array(
                    'default'           => 1,
                    'sanitize_callback' => 'skyre_sanitize_checkbox',
            ) );
            // add checkbox control for excerpts/full posts toggle
            $wp_customize->add_control( 'skyre_excerpts', array(
                    'label'     => esc_html__( 'Show post excerpts?', 'skyre' ),
                    'section'   => 'skyre_content_section',
                    'priority'  => 10,
                    'type'      => 'checkbox'
            ) );

            $wp_customize->add_setting( 'skyre_page_comments', array(
                    'default' => 1,
                    'sanitize_callback' => 'skyre_sanitize_checkbox',
            ) );
            $wp_customize->add_control( 'skyre_page_comments', array(
                    'label'		=> esc_html__( 'Display Comments on Static Pages?', 'skyre' ),
                    'section'	=> 'skyre_content_section',
                    'priority'	=> 20,
                    'type'      => 'checkbox',
            ) );
			
			
			}
	}
}

