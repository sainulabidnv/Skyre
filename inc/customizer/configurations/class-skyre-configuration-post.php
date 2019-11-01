<?php
/**
 * Customizer Control: Post configuration.
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
 
if ( ! class_exists( 'Skyre_Configuration_Post' ) ) {

	/**
	 * Customizer configuration Initial setup
	 */
	class Skyre_Configuration_Post  {

		/**
		 * Constructor
		 */
		public function __construct() {
			//$this->register_configuration( $wp_customize);
		}
		
		public function register_configuration( $wp_customize ) {
			
			//post panel
			$wp_customize->add_panel('skyre_post_panel', array(
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __('Post/archive Options', 'skyre'),
			'priority' => 10 // Mixed with top-level-section hierarchy.
		));
			
		
			
		$wp_customize->add_section('skyre_post_layout', array(
            'title' => __('Post settings', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_post_panel'
        ));
			
			
			
			$wp_customize->add_setting( 'skyre_post[blog_fullwidth]', array(
                    'type'  => 'option',
                    'sanitize_callback' => 'skyre_sanitize_checkbox',
            ) );
            // add checkbox control for excerpts/full posts toggle
            $wp_customize->add_control( 'skyre_post[blog_fullwidth]', array(
                    'label'     => esc_html__( 'Full width?', 'skyre' ),
                    'section'   => 'skyre_post_layout',
                    'priority'  => 10,
                    'type'      => 'checkbox'
            ) );
			
			/*Post/Post archive layout*/
			$wp_customize->register_control_type( 'Skyre_Control_Radio_Image' );
			$wp_customize->add_setting( 'skyre_post[blog_layout]',
				array(
					'default' => '3',
					'type'  => 'option',
					'sanitize_callback' => 'skyre_radio_image_sanitization'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Radio_Image( $wp_customize, 'skyre_post[blog_layout]',
				array(
					'label' => __( 'Post/Archive sidebar', 'skyre' ),
					'section' => 'skyre_post_layout',
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
			$wp_customize->add_setting( 'skyre_post[margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[margin]',
				array(
					'label' => __( 'Margin', 'skyre' ),
					'section' => 'skyre_post_layout',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[padding]',
				array(
					'default' => array(
						'desktop'      => array(
							'top'  => '80',
						),),
					
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[padding]',
				array(
					'label' => __( 'Padding', 'skyre' ),
					'section' => 'skyre_post_layout',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			/*Post grid/list*/
			$wp_customize->add_setting('skyre_post[blog_item_count]', array(
                'default' => '12',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_select',
            ));
			
			$wp_customize->add_control('skyre_post[blog_item_count]', array(
                'label' => __('Post per row', 'skyre'),
                'section' => 'skyre_post_layout',
                'type' => 'select',
				'choices' => array(
					'12' => __( '1', 'skyre' ),
					'6' => __( '2', 'skyre' ),
					'4' => __( '3', 'skyre' ),
					'3' => __( '4', 'skyre' ),
					 ),
	  
            ));
			
			/*Post grid/list*/
			$wp_customize->add_setting('skyre_post[blog_item_layout]', array(
                'default' => '2',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_select',
            ));
			
			$wp_customize->add_control('skyre_post[blog_item_layout]', array(
                'label' => __('Post list style', 'skyre'),
                'section' => 'skyre_post_layout',
                'type' => 'select',
				'choices' => array(
					'1' => __( 'Boxed/Grid', 'skyre' ),
					'2' => __( 'List', 'skyre' ),
					 ),
	  
            ));
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[bg_color]',
				array(
					'label' => __( 'background', 'skyre' ),
					'section' => 'skyre_post_layout',
					
				)
			) );
			
		$wp_customize->add_section('skyre_post_item_style', array(
            'title' => __('Post Item style', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_post_panel'
        ));
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[list_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[list_bg_color]',
				array(
					'label' => __( 'List/box background', 'skyre' ),
					'section' => 'skyre_post_item_style',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[list_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[list_margin]',
				array(
					'label' => __( 'List/box margin', 'skyre' ),
					'section' => 'skyre_post_item_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[list_padding]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[list_padding]',
				array(
					'label' => __( 'List/box Padding', 'skyre' ),
					'section' => 'skyre_post_item_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[list_border]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[list_border]',
				array(
					'label' => __( 'List/box border', 'skyre' ),
					'section' => 'skyre_post_item_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[list_border_radius]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[list_border_radius]',
				array(
					'label' => __( 'List/box border radius', 'skyre' ),
					'section' => 'skyre_post_item_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[list_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[list_border_color]',
				array(
					'label' => __( 'List/box border Color', 'skyre' ),
					'section' => 'skyre_post_item_style',
					
				)
			) );

			//Image style start
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[blog_img_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[blog_img_margin]',
				array(
					'label' => __( 'Image margin', 'skyre' ),
					'section' => 'skyre_post_item_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			//Image style end
			
			//Title style start
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[blog_title_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[blog_title_margin]',
				array(
					'label' => __( 'Title margin', 'skyre' ),
					'section' => 'skyre_post_item_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			//Title style end
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[blog_meta_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[blog_meta_margin]',
				array(
					'label' => __( 'Meta margin', 'skyre' ),
					'section' => 'skyre_post_item_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[blog_content_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[blog_content_margin]',
				array(
					'label' => __( 'Content margin', 'skyre' ),
					'section' => 'skyre_post_item_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[blog_read_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[blog_read_margin]',
				array(
					'label' => __( 'Read more margin', 'skyre' ),
					'section' => 'skyre_post_item_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
		
		//Single post style
		$wp_customize->add_section('skyre_single_post_style', array(
            'title' => __('Single Post Settings', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_post_panel'
        ));
			
			$wp_customize->add_setting( 'skyre_post[single_blog_fullwidth]', array(
                    'type'  => 'option',
                    'sanitize_callback' => 'skyre_sanitize_checkbox',
            ) );
            // add checkbox control for excerpts/full posts toggle
            $wp_customize->add_control( 'skyre_post[single_blog_fullwidth]', array(
                    'label'     => esc_html__( 'Full width?', 'skyre' ),
                    'section'   => 'skyre_single_post_style',
                    'priority'  => 10,
                    'type'      => 'checkbox'
			) );
			
			$wp_customize->add_setting( 'skyre_post[template_style]', array(
				'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_template_style',
			) );
			// add checkbox control for excerpts/full posts toggle
			$wp_customize->add_control( 'skyre_post[template_style]', array(
					'label'     => esc_html__( 'Template Style', 'skyre' ),
					'section'   => 'skyre_single_post_style',
					'priority'  => 10,
					'type' => 'select',
					'choices' => array(
						'' => __( 'Custom', 'skyre' ),
						'modern' => __( 'Modern', 'skyre' ), ),
			) );
			
			/*Post/Post archive layout*/
			$wp_customize->register_control_type( 'Skyre_Control_Radio_Image' );
			$wp_customize->add_setting( 'skyre_post[single_blog_layout]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'skyre_radio_image_sanitization'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Radio_Image( $wp_customize, 'skyre_post[single_blog_layout]',
				array(
					'label' => __( 'Single post sidebar', 'skyre' ),
					'section' => 'skyre_single_post_style',
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
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[single_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[single_bg_color]',
				array(
					'label' => __( 'background', 'skyre' ),
					'section' => 'skyre_single_post_style',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[single_padding]',
				array(
					'default' => array(
						'desktop'      => array(
							'top'  => '80',
						),),
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[single_padding]',
				array(
					'label' 	=> __( 'Padding', 'skyre' ),
					'section' 	=> 'skyre_single_post_style',
					'type'    	=> 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[single_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[single_margin]',
				array(
					'label' 	=> __( 'Margin', 'skyre' ),
					'section' 	=> 'skyre_single_post_style',
					'type'    	=> 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->add_setting( 'skyre_post[single_border_height]',
				array(
					'default' => array(
						'desktop'      => array(
							'top'  => '1',
						),),
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[single_border_height]',
				array(
					'label' 	=> __( 'Border', 'skyre' ),
					'section' 	=> 'skyre_single_post_style',
					'type'    	=> 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[single_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[single_border_color]',
				array(
					'label' => __( 'Border Color', 'skyre' ),
					'section' => 'skyre_single_post_style',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[single_title_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[single_title_bg_color]',
				array(
					'label' => __( 'Title background', 'skyre' ),
					'section' => 'skyre_single_post_style',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[single_title_padding]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[single_title_padding]',
				array(
					'label' 	=> __( 'Title padding', 'skyre' ),
					'section' 	=> 'skyre_single_post_style',
					'type'    	=> 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[single_title_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[single_title_margin]',
				array(
					'label' 	=> __( 'Title margin', 'skyre' ),
					'section' 	=> 'skyre_single_post_style',
					'type'    	=> 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[single_title_border_height]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[single_title_border_height]',
				array(
					'label' 	=> __( 'Title Border', 'skyre' ),
					'section' 	=> 'skyre_single_post_style',
					'type'    	=> 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[single_title_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[single_title_border_color]',
				array(
					'label' => __( 'Border Color', 'skyre' ),
					'section' => 'skyre_single_post_style',
					
				)
			) );



			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[single_blog_image_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[single_blog_image_margin]',
				array(
					'label' => __( 'Image margin', 'skyre' ),
					'section' => 'skyre_single_post_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[single_blog_meta_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[single_blog_meta_margin]',
				array(
					'label' => __( 'Meta margin', 'skyre' ),
					'section' => 'skyre_single_post_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[single_blog_content_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[single_blog_content_margin]',
				array(
					'label' => __( 'Content margin', 'skyre' ),
					'section' => 'skyre_single_post_style',
					'type'      => 'skyre-dimension'
					
				)
			) );
		
        $wp_customize->add_section('skyre_post_heading', array(
            'title' => __('Post Title', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_post_panel'
        ));    
			$wp_customize->add_setting( 'skyre_post[title]', array(
                    'type'  => 'option',
                    'sanitize_callback' => 'skyre_sanitize_checkbox',
            ) );
            // add checkbox control for excerpts/full posts toggle
            $wp_customize->add_control( 'skyre_post[title]', array(
                    'label'     => esc_html__( 'Disable Post title?', 'skyre' ),
                    'section'   => 'skyre_post_heading',
                    'priority'  => 10,
                    'type'      => 'checkbox'
            ) );
			
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[title_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[title_color]',
				array(
					'label' => __( 'Title color', 'skyre' ),
					'section' => 'skyre_post_heading',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[title_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[title_bg_color]',
				array(
					'label' => __( 'Title background', 'skyre' ),
					'section' => 'skyre_post_heading',
					
				)
			) );
			
			
			
			$wp_customize->add_setting('skyre_post[title_bg_image]', array(
                'default' => '',
				'type'  => 'option',
				'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'skyre_post[title_bg_image]', array(
                'label' => __('Background Image', 'skyre'),
                'section' => 'skyre_post_heading',
				'mime_type' => 'image',
                'settings' => 'skyre_post[title_bg_image]',
            )));
			
			$wp_customize->add_setting('skyre_post[title_bg_size]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_size',
            ));
			$wp_customize->add_control('skyre_post[title_bg_size]', array(
                'label' => __('Background Size', 'skyre'),
                'section' => 'skyre_post_heading',
                'type' => 'select',
				'default' => '',
				'choices' => array(
					'' => __( '--Select--', 'skyre' ),
					'auto' => __( 'Auto', 'skyre' ),
					'cover' => __( 'Cover', 'skyre' ),
					'contain' => __( 'Contain', 'skyre' ),
					'100% 100%' => __( 'Full fit', 'skyre' ), ),
	  
            ));
			
			
			$wp_customize->add_setting('skyre_post[title_bg_repeat]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_repeat',
            ));
			$wp_customize->add_control('skyre_post[title_bg_repeat]', array(
                'label' => __('Background Repeat', 'skyre'),
                'section' => 'skyre_post_heading',
                'type' => 'select',
				'default' => 'repeat',
				'choices' => array(
					'' => __( '--Select--', 'skyre' ),
					'repeat' => __( 'Repeat', 'skyre' ),
					'repeat-x' => __( 'Repeat X', 'skyre' ),
					'repeat-y' => __( 'Repeat Y', 'skyre' ),
					'no-repeat' => __( 'No Repat', 'skyre' ), ),
	  
            ));
			
			$wp_customize->add_setting('skyre_post[title_bg_position]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_position',
            ));
			$wp_customize->add_control('skyre_post[title_bg_position]', array(
                'label' => __('Background Positions', 'skyre'),
                'section' => 'skyre_post_heading',
                'type' => 'select',
				'default' => 'repeat',
				'choices' => get_background_positions()
	  
            ));
			
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[title_padding]',
				array(
					'default' => array(
						'desktop'      => array(
							'top'  => '20',
							'bottom'  => '20',
						),),
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[title_padding]',
				array(
					'label' 	=> __( 'Title padding', 'skyre' ),
					'section' 	=> 'skyre_post_heading',
					'type'    	=> 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[title_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[title_margin]',
				array(
					'label' 	=> __( 'Title margin', 'skyre' ),
					'section' 	=> 'skyre_post_heading',
					'type'    	=> 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[title_border_height]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[title_border_height]',
				array(
					'label' 	=> __( 'Title Border', 'skyre' ),
					'section' 	=> 'skyre_post_heading',
					'type'    	=> 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[title_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[title_border_color]',
				array(
					'label' => __( 'Border Color', 'skyre' ),
					'section' => 'skyre_post_heading',
					
				)
			) );
			
		$post_formats = array(
			'default'=>array(
				'title'=>'Default post',
				'choices'=>array('title','image','meta','content')),
			'gallery'=>array(
				'title'=>'Gallery post',
				'choices'=>array('title','image')), 
			'image'=>array(
				'title'=>'Image post',
				'choices'=>array('image','title')), 
			'video'=>array(
				'title'=>'Video post',
				'choices'=>array('title','content')),
			);
		
		//=======Post field view section
		$wp_customize->add_section('skyre_post_position', array(
            'title' => __('Post field position', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_post_panel'
        ));
		
		foreach($post_formats as $key => $value) {
			
			$current = skyre_get_post_option($key.'_field_position');
			$wp_customize->register_control_type( 'Skyre_Control_Sortable' );
			$wp_customize->add_setting( 'skyre_post['.$key.'_field_position]',
				array(
					'default' => $value['choices'],
					'type'  => 'option',
					/*'transport'   => 'postMessage', */
					'sanitize_callback' => 'sanitize_multi_choices'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Sortable( $wp_customize, 'skyre_post['.$key.'_field_position]',
				array(
					'label' => __( $value['title'], 'skyre' ),
					'section' => 'skyre_post_position',
					'type'      => 'skyre-sortable',
					
					'choices'  => array(
						'title' => __( 'Title', 'skyre' ),
						'image' => __( 'Image', 'skyre' ),
						'meta'   => __( 'Author, date', 'skyre' ),
						'content'     => __( 'Content', 'skyre' ),
					),
				)
			) );
		}
		
		//=======Single Post field view section
		$wp_customize->add_section('skyre_single_post_position', array(
            'title' => __('Single Post field position', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_post_panel'
        ));
		
		foreach($post_formats as $key => $value) {
			
			$wp_customize->register_control_type( 'Skyre_Control_Sortable' );
			$wp_customize->add_setting( 'skyre_post['.$key.'_single_field_position]',
				array(
					'default' => $value['choices'],
					'type'  => 'option',
					/*'transport'   => 'postMessage', */
					'sanitize_callback' => 'sanitize_multi_choices'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Sortable( $wp_customize, 'skyre_post['.$key.'_single_field_position]',
				array(
					'label' => __( $value['title'], 'skyre' ),
					'section' => 'skyre_single_post_position',
					'type'      => 'skyre-sortable',
					
					'choices'  => array(
						'title' => __( 'Title', 'skyre' ),
						'image' => __( 'Image', 'skyre' ),
						'meta'   => __( 'Author, date', 'skyre' ),
						'content'     => __( 'Content', 'skyre' ),
					),
						
					
				)
			) );
		}
		
		$wp_customize->add_section('skyre_nextprev', array(
            'title' => __('Post next/previous', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_post_panel'
        ));
			
			
			
			$wp_customize->add_setting( 'skyre_post[nextprev_status]', array(
                    'type'  => 'option',
                    'sanitize_callback' => 'skyre_sanitize_checkbox',
            ) );
            // add checkbox control for excerpts/full posts toggle
            $wp_customize->add_control( 'skyre_post[nextprev_status]', array(
                    'label'     => esc_html__( 'Disable NextPreview link?', 'skyre' ),
                    'section'   => 'skyre_nextprev',
                    'priority'  => 10,
                    'type'      => 'checkbox'
            ) );
			
			$wp_customize->add_setting( 'skyre_post[nextprev_text_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[nextprev_text_color]',
				array(
					'label' => __( 'Text color', 'skyre' ),
					'section' => 'skyre_nextprev',
					
				)
			) );
			
			$wp_customize->add_setting( 'skyre_post[nextprev_link_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[nextprev_link_color]',
				array(
					'label' => __( 'Link color', 'skyre' ),
					'section' => 'skyre_nextprev',
					
				)
			) );
			
			$wp_customize->add_setting( 'skyre_post[nextprev_link_hover_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[nextprev_link_hover_color]',
				array(
					'label' => __( 'Link hover', 'skyre' ),
					'section' => 'skyre_nextprev',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[nextprev_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[nextprev_bg_color]',
				array(
					'label' => __( 'Next/Preview background', 'skyre' ),
					'section' => 'skyre_nextprev',
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[nextprev_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[nextprev_margin]',
				array(
					'label' => __( 'Next/Preview margin', 'skyre' ),
					'section' => 'skyre_nextprev',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[nextprev_padding]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[nextprev_padding]',
				array(
					'label' => __( 'Next/Preview Padding', 'skyre' ),
					'section' => 'skyre_nextprev',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[nextprev_border]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[nextprev_border]',
				array(
					'label' => __( 'Next/Preview border', 'skyre' ),
					'section' => 'skyre_nextprev',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_post[nextprev_border_radius]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_post[nextprev_border_radius]',
				array(
					'label' => __( 'Next/Preview border radius', 'skyre' ),
					'section' => 'skyre_nextprev',
					'type'      => 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_post[nextprev_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'commentMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_post[nextprev_border_color]',
				array(
					'label' => __( 'Next/Preview border Color', 'skyre' ),
					'section' => 'skyre_nextprev',
					
				)
			) );
		
		}
	}
}

