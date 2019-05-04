<?php
/**
 * Customizer Control: Comment configuration.
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
 
if ( ! class_exists( 'Skyre_Configuration_Comment' ) ) {

	/**
	 * Customizer configuration Initial setup
	 */
	class Skyre_Configuration_Comment  {

		/**
		 * Constructor
		 */
		public function __construct() {
			//$this->register_configuration( $wp_customize);
		}
		
		public function register_configuration( $wp_customize ) {
			
			//comment panel
			$wp_customize->add_panel('skyre_comment_panel', array(
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __('Comment settings', 'skyre'),
			'priority' => 10 // Mixed with top-level-section hierarchy.
		));
			
		$wp_customize->add_section('skyre_comment_layout', array(
            'title' => __('Comment style', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_comment_panel'
        ));
			
			$wp_customize->add_setting( 'skyre_post[comment_status]', array(
                    'type'  => 'option',
                    'sanitize_callback' => 'skyre_sanitize_checkbox',
            ) );
            // add checkbox control for excerpts/full posts toggle
            $wp_customize->add_control( 'skyre_post[comment_status]', array(
                    'label'     => esc_html__( 'Disable comments?', 'skyre' ),
                    'section'   => 'skyre_comment_layout',
                    'priority'  => 10,
                    'type'      => 'checkbox'
            ) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[comment_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[comment_bg_color]',
				array(
					'label' => __( 'background', 'skyre' ),
					'section' => 'skyre_comment_layout',
					
				)
			) );
			
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_margin]',
				array(
					'label' => __( 'Margin', 'skyre' ),
					'section' => 'skyre_comment_layout',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_padding]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_padding]',
				array(
					'label' => __( 'Padding', 'skyre' ),
					'section' => 'skyre_comment_layout',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_border]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_border]',
				array(
					'label' => __( 'Border', 'skyre' ),
					'section' => 'skyre_comment_layout',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_border_radius]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_border_radius]',
				array(
					'label' => __( 'Border radius', 'skyre' ),
					'section' => 'skyre_comment_layout',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[comment_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[comment_border_color]',
				array(
					'label' => __( 'Border Color', 'skyre' ),
					'section' => 'skyre_comment_layout',
					
				)
			) );
			
		//comment  title	
		$wp_customize->add_section('skyre_comment_section_title', array(
            'title' => __('Comment title', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_comment_panel'
        ));
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[comment_section_title_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[comment_section_title_bg_color]',
				array(
					'label' => __( 'Title background', 'skyre' ),
					'section' => 'skyre_comment_section_title',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_section_title_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_section_title_margin]',
				array(
					'label' => __( 'Title margin', 'skyre' ),
					'section' => 'skyre_comment_section_title',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_section_title_padding]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_section_title_padding]',
				array(
					'label' => __( 'Title Padding', 'skyre' ),
					'section' => 'skyre_comment_section_title',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_section_title_border]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_section_title_border]',
				array(
					'label' => __( 'Title border', 'skyre' ),
					'section' => 'skyre_comment_section_title',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_section_title_border_radius]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_section_title_border_radius]',
				array(
					'label' => __( 'Title border radius', 'skyre' ),
					'section' => 'skyre_comment_section_title',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[comment_section_title_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[comment_section_title_border_color]',
				array(
					'label' => __( 'Title border Color', 'skyre' ),
					'section' => 'skyre_comment_section_title',
					
				)
			) );
			
		//comment sections	
		$wp_customize->add_section('skyre_comment_section_style', array(
            'title' => __('Comment items', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_comment_panel'
        ));
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[comment_section_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[comment_section_bg_color]',
				array(
					'label' => __( 'Section background', 'skyre' ),
					'section' => 'skyre_comment_section_style',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_section_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_section_margin]',
				array(
					'label' => __( 'Section margin', 'skyre' ),
					'section' => 'skyre_comment_section_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_section_padding]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_section_padding]',
				array(
					'label' => __( 'Section Padding', 'skyre' ),
					'section' => 'skyre_comment_section_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_section_border]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_section_border]',
				array(
					'label' => __( 'Section border', 'skyre' ),
					'section' => 'skyre_comment_section_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_section_border_radius]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_section_border_radius]',
				array(
					'label' => __( 'Section border radius', 'skyre' ),
					'section' => 'skyre_comment_section_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[comment_section_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[comment_section_border_color]',
				array(
					'label' => __( 'Section border Color', 'skyre' ),
					'section' => 'skyre_comment_section_style',
					
				)
			) );

			
		//comment reply	
		$wp_customize->add_section('skyre_comment_reply', array(
            'title' => __('Comment reply/child', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_comment_panel'
        ));
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[comment_reply_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[comment_reply_bg_color]',
				array(
					'label' => __( 'Reply background', 'skyre' ),
					'section' => 'skyre_comment_reply',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_reply_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_reply_margin]',
				array(
					'label' => __( 'Reply margin', 'skyre' ),
					'section' => 'skyre_comment_reply',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_reply_padding]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_reply_padding]',
				array(
					'label' => __( 'Reply Padding', 'skyre' ),
					'section' => 'skyre_comment_reply',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_reply_border]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_reply_border]',
				array(
					'label' => __( 'Reply border', 'skyre' ),
					'section' => 'skyre_comment_reply',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_reply_border_radius]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_reply_border_radius]',
				array(
					'label' => __( 'Reply border radius', 'skyre' ),
					'section' => 'skyre_comment_reply',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[comment_reply_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[comment_reply_border_color]',
				array(
					'label' => __( 'Reply border Color', 'skyre' ),
					'section' => 'skyre_comment_reply',
					
				)
			) );
		
		//comment forms
		$wp_customize->add_section('skyre_comment_form', array(
            'title' => __('Form fields', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_comment_panel'
        ));
			
			
			$wp_customize->add_setting( 'skyre_post[comment_form_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[comment_form_color]',
				array(
					'label' => __( 'Color', 'skyre' ),
					'section' => 'skyre_comment_form',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[comment_form_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[comment_form_bg_color]',
				array(
					'label' => __( 'Form fields background', 'skyre' ),
					'section' => 'skyre_comment_form',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_form_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_form_margin]',
				array(
					'label' => __( 'Form fields margin', 'skyre' ),
					'section' => 'skyre_comment_form',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_form_padding]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_form_padding]',
				array(
					'label' => __( 'Form fields Padding', 'skyre' ),
					'section' => 'skyre_comment_form',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_form_border]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_form_border]',
				array(
					'label' => __( 'Form fields border', 'skyre' ),
					'section' => 'skyre_comment_form',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_form_border_radius]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_form_border_radius]',
				array(
					'label' => __( 'Form fields border radius', 'skyre' ),
					'section' => 'skyre_comment_form',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[comment_form_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[comment_form_border_color]',
				array(
					'label' => __( 'Form fields border Color', 'skyre' ),
					'section' => 'skyre_comment_form',
					
				)
			) );
		
		//Form button
		$wp_customize->add_section('skyre_comment_form_button', array(
            'title' => __('Form button', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_comment_panel'
        ));
			
			$wp_customize->add_setting( 'skyre_post[comment_form_button_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[comment_form_button_color]',
				array(
					'label' => __( 'Color', 'skyre' ),
					'section' => 'skyre_comment_form_button',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[comment_form_button_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[comment_form_button_bg_color]',
				array(
					'label' => __( 'Form button background', 'skyre' ),
					'section' => 'skyre_comment_form_button',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_form_button_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_form_button_margin]',
				array(
					'label' => __( 'Form button margin', 'skyre' ),
					'section' => 'skyre_comment_form_button',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_form_button_padding]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_form_button_padding]',
				array(
					'label' => __( 'Form button Padding', 'skyre' ),
					'section' => 'skyre_comment_form_button',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_form_button_border]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_form_button_border]',
				array(
					'label' => __( 'Form button border', 'skyre' ),
					'section' => 'skyre_comment_form_button',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_form_button_border_radius]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_form_button_border_radius]',
				array(
					'label' => __( 'Form button border radius', 'skyre' ),
					'section' => 'skyre_comment_form_button',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[comment_form_button_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[comment_form_button_border_color]',
				array(
					'label' => __( 'Form button border Color', 'skyre' ),
					'section' => 'skyre_comment_form_button',
					
				)
			) );
		
		//comment avatar
		$wp_customize->add_section('skyre_comment_avatar', array(
            'title' => __('Avatar', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_comment_panel'
        ));
			
			$wp_customize->add_setting( 'skyre_post[avatar_status]', array(
                    'type'  => 'option',
                    'sanitize_callback' => 'skyre_sanitize_checkbox',
            ) );
            // add checkbox control for excerpts/full posts toggle
            $wp_customize->add_control( 'skyre_post[avatar_status]', array(
                    'label'     => esc_html__( 'Disable avatar?', 'skyre' ),
                    'section'   => 'skyre_comment_avatar',
                    'priority'  => 10,
                    'type'      => 'checkbox'
            ) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[comment_avatar_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[comment_avatar_bg_color]',
				array(
					'label' => __( 'Avatar background', 'skyre' ),
					'section' => 'skyre_comment_avatar',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_avatar_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_avatar_margin]',
				array(
					'label' => __( 'Avatar margin', 'skyre' ),
					'section' => 'skyre_comment_avatar',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_avatar_padding]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_avatar_padding]',
				array(
					'label' => __( 'Avatar Padding', 'skyre' ),
					'section' => 'skyre_comment_avatar',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_avatar_border]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_avatar_border]',
				array(
					'label' => __( 'Avatar border', 'skyre' ),
					'section' => 'skyre_comment_avatar',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[comment_avatar_border_radius]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[comment_avatar_border_radius]',
				array(
					'label' => __( 'Avatar border radius', 'skyre' ),
					'section' => 'skyre_comment_avatar',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[comment_avatar_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[comment_avatar_border_color]',
				array(
					'label' => __( 'Avatar border Color', 'skyre' ),
					'section' => 'skyre_comment_avatar',
					
				)
			) );
		
		}
	}
}

