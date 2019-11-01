<?php
/**
 * Customizer Control: Page configuration.
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
 
if ( ! class_exists( 'Skyre_Configuration_Page' ) ) {

	/**
	 * Customizer configuration Initial setup
	 */
	class Skyre_Configuration_Page  {

		/**
		 * Constructor
		 */
		public function __construct() {
			//$this->register_configuration( $wp_customize);
		}
		
		public function register_configuration( $wp_customize ) {
			
			//post panel
			$wp_customize->add_panel('skyre_page_panel', array(
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __('Page Options', 'skyre'),
			'priority' => 10 // Mixed with top-level-section hierarchy.
		));
			
		/*Page Typo*/	
		$fontargs = array( 
			array( 'title' => 'Page/ title', 'id' => 'post-title', 'default' => '' ),
			
			);
		addtypo( $fontargs, $wp_customize );
        
			
		$wp_customize->add_section('skyre_page_layout', array(
            'title' => __('Page settings', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_page_panel'
        ));
			
			$wp_customize->add_setting( 'skyre_page[fullwidth]', array(
                    'type'  => 'option',
                    'sanitize_callback' => 'skyre_sanitize_checkbox',
            ) );
            // add checkbox control for excerpts/full posts toggle
            $wp_customize->add_control( 'skyre_page[fullwidth]', array(
                    'label'     => esc_html__( 'Enable full width?', 'skyre' ),
                    'section'   => 'skyre_page_layout',
                    'priority'  => 10,
                    'type'      => 'checkbox'
            ) );
			
			/*Page/Page archive layout*/
			$wp_customize->register_control_type( 'Skyre_Control_Radio_Image' );
			$wp_customize->add_setting( 'skyre_page[layout]',
				array(
					'default' => '3',
					'type'  => 'option',
					'sanitize_callback' => 'skyre_radio_image_sanitization'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Radio_Image( $wp_customize, 'skyre_page[layout]',
				array(
					'label' => __( 'Page sidebar', 'skyre' ),
					'section' => 'skyre_page_layout',
					'choices' => array(
						'1' => array(
							'path' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer/images/sidebar-left.png',
							'label' => __( 'Left Sidebar', 'skyre' )
						),
						'2' => array(
							'path' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer/images/sidebar-none.png',
							'label' => __( 'No Sidebar', 'skyre' )
						),
						'3' => array(
							'path' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer/images/sidebar-right.png',
							'label' => __( 'Right Sidebar', 'skyre' )
						)
					)
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_page[margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_page[margin]',
				array(
					'label' => __( 'Margin', 'skyre' ),
					'section' => 'skyre_page_layout',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_page[padding]',
				array(
					'default' => array(
						'desktop'      => array(
							'top'  => '80',
						),),
					
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_page[padding]',
				array(
					'label' => __( 'Padding', 'skyre' ),
					'section' => 'skyre_page_layout',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_page[bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_page[bg_color]',
				array(
					'label' => __( 'background', 'skyre' ),
					'section' => 'skyre_page_layout',
					
				)
			) );
			
			$wp_customize->add_setting('skyre_page[bg_image]', array(
                'default' => '',
				'type'  => 'option', 
				'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'skyre_page[bg_image]', array(
                'label' => __('Background Image', 'skyre'),
                'section' => 'skyre_page_layout',
				'mime_type' => 'image',
                'settings' => 'skyre_page[bg_image]',
            )));
			
			$wp_customize->add_setting('skyre_page[bg_size]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_size',
            ));
			$wp_customize->add_control('skyre_page[bg_size]', array(
                'label' => __('Background Size', 'skyre'),
                'section' => 'skyre_page_layout',
                'type' => 'select',
				'default' => '',
				'choices' => array(
					'' => __( '--Select--', 'skyre' ),
					'auto' => __( 'Auto', 'skyre' ),
					'cover' => __( 'Cover', 'skyre' ),
					'contain' => __( 'Contain', 'skyre' ),
					'100% 100%' => __( 'Full fit', 'skyre' ), ),
	  
            ));
			
			
			$wp_customize->add_setting('skyre_page[bg_repeat]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_repeat',
            ));
			$wp_customize->add_control('skyre_page[bg_repeat]', array(
                'label' => __('Background Repeat', 'skyre'),
                'section' => 'skyre_page_layout',
                'type' => 'select',
				'default' => 'repeat',
				'choices' => array(
					'' => __( '--Select--', 'skyre' ),
					'repeat' => __( 'Repeat', 'skyre' ),
					'repeat-x' => __( 'Repeat X', 'skyre' ),
					'repeat-y' => __( 'Repeat Y', 'skyre' ),
					'no-repeat' => __( 'No Repat', 'skyre' ), ),
	  
            ));
			
			$wp_customize->add_setting('skyre_page[bg_position]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_position',
            ));
			$wp_customize->add_control('skyre_page[bg_position]', array(
                'label' => __('Background Positions', 'skyre'),
                'section' => 'skyre_page_layout',
                'type' => 'select',
				'default' => 'repeat',
				'choices' => get_background_positions()
	  
            ));
			
		
        $wp_customize->add_section('skyre_page_heading', array(
            'title' => __('Page Title', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_page_panel'
        ));    
			$wp_customize->add_setting( 'skyre_page[title_active]', array(
                    'type'  => 'option',
                    'sanitize_callback' => 'skyre_sanitize_checkbox',
            ) );
            // add checkbox control for excerpts/full posts toggle
            $wp_customize->add_control( 'skyre_page[title_active]', array(
                    'label'     => esc_html__( 'Disable Page title?', 'skyre' ),
                    'section'   => 'skyre_page_heading',
                    'priority'  => 10,
                    'type'      => 'checkbox'
            ) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_page[title_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_page[title_bg_color]',
				array(
					'label' => __( 'Title background', 'skyre' ),
					'section' => 'skyre_page_heading',
					
				)
			) );
			
			$wp_customize->add_setting('skyre_page[title_bg_image]', array(
                'default' => '',
				'type'  => 'option', 
				'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'skyre_page[title_bg_image]', array(
                'label' => __('Background Image', 'skyre'),
                'section' => 'skyre_page_heading',
				'mime_type' => 'image',
                'settings' => 'skyre_page[title_bg_image]',
            )));
			
			$wp_customize->add_setting('skyre_page[title_bg_size]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_size',
            ));
			$wp_customize->add_control('skyre_page[title_bg_size]', array(
                'label' => __('Background Size', 'skyre'),
                'section' => 'skyre_page_heading',
                'type' => 'select',
				'default' => '',
				'choices' => array(
					'' => __( '--Select--', 'skyre' ),
					'auto' => __( 'Auto', 'skyre' ),
					'cover' => __( 'Cover', 'skyre' ),
					'contain' => __( 'Contain', 'skyre' ),
					'100% 100%' => __( 'Full fit', 'skyre' ), ),
	  
            ));
			
			
			$wp_customize->add_setting('skyre_page[title_bg_repeat]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_repeat',
            ));
			$wp_customize->add_control('skyre_page[title_bg_repeat]', array(
                'label' => __('Background Repeat', 'skyre'),
                'section' => 'skyre_page_heading',
                'type' => 'select',
				'default' => 'repeat',
				'choices' => array(
					'' => __( '--Select--', 'skyre' ),
					'repeat' => __( 'Repeat', 'skyre' ),
					'repeat-x' => __( 'Repeat X', 'skyre' ),
					'repeat-y' => __( 'Repeat Y', 'skyre' ),
					'no-repeat' => __( 'No Repat', 'skyre' ), ),
	  
            ));
			
			$wp_customize->add_setting('skyre_page[title_bg_position]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_position',
            ));
			$wp_customize->add_control('skyre_page[title_bg_position]', array(
                'label' => __('Background Positions', 'skyre'),
                'section' => 'skyre_page_heading',
                'type' => 'select',
				'default' => 'repeat',
				'choices' => get_background_positions()
	  
            ));
			
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_page[title_padding]',
				array(
					'default' => array(
						'desktop'      => array(
							'top'  => '20',
							'right'  => '',
							'bottom'  => '20',
							'left'  => '',
						),),
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_page[title_padding]',
				array(
					'label' 	=> __( 'Title padding', 'skyre' ),
					'section' 	=> 'skyre_page_heading',
					'type'    	=> 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_page[title_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_page[title_margin]',
				array(
					'label' 	=> __( 'Title margin', 'skyre' ),
					'section' 	=> 'skyre_page_heading',
					'type'    	=> 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_page[title_border_height]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_page[title_border_height]',
				array(
					'label' 	=> __( 'Title Border', 'skyre' ),
					'section' 	=> 'skyre_page_heading',
					'type'    	=> 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_page[title_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_page[title_border_color]',
				array(
					'label' => __( 'Border Color', 'skyre' ),
					'section' => 'skyre_page_heading',
					
				)
			) );
			
		
		
		}
	}
}

