<?php
/**
 * Skyre: Customizer
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */
 
if ( ! function_exists( 'skyre_get_option' ) ) :
function skyre_get_option( $name, $default = false ) {

	$option_name = '';
	// Get option settings from database
	$options = get_option( 'skyre' );

	// Return specific option
	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return $default;
}
endif;


function get_background_positions(){
	$bgpostiong = array(
		'' =>  __( '--Select--', 'skyre' ),
		'left top' => __( 'Left Top', 'skyre' ),
		'left center' => __( 'Left Center', 'skyre' ),
		'left bottom' => __( 'Left bottom', 'skyre' ),
		'right top' => __( 'Right Top', 'skyre' ),
		'right center' => __( 'Right Center', 'skyre' ),
		'right bottom' => __( 'Right Bottom', 'skyre' ),
		'center top' => __( 'Center Top', 'skyre' ),
		'center center' => __( 'Center Center', 'skyre' ),
		'center bottom' => __( 'Center Bottom', 'skyre' ),

	);
	return $bgpostiong;
	}





if ( is_admin() || is_customize_preview() ) {
	add_action( 'customize_register', 'skyre_customize_register' );
	add_action( 'customize_register', 'include_coustom_control', 2 );
	add_action( 'customize_register', 'include_config_files', 3 );
}

/**
 * Include Customizer Configuration files.
 *
 * @since 1.0
 * @return void
 */
function include_config_files() {
	
		require SKYRE_THEME_DIR.'/inc/customizer/configurations/class-skyre-configuration-layout.php' ;
		
	}

function include_coustom_control() {
	
	//SKYRE_THEME_URI . 'inc/customizer/skyrocket/inc/custom-controls.php';
	require SKYRE_THEME_DIR.'/inc/customizer/custom-controls/link/class-skyre-control-link.php' ;
	require SKYRE_THEME_DIR.'/inc/customizer/custom-controls/radio-image/class-skyre-control-radio-image.php' ;
	require SKYRE_THEME_DIR.'/inc/customizer/custom-controls/responsive/class-skyre-control-responsive.php' ;
	require SKYRE_THEME_DIR.'/inc/customizer/custom-controls/divider/class-skyre-control-divider.php' ;
	
	
	
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function skyre_customize_register( $wp_customize ) {
	
	
	$layout_panel = new Skyre_Configuration_Layout;	

    $wp_customize->remove_section("colors");
	/* Main option Settings Panel */
    $wp_customize->add_panel('skyre_main_options', array(
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => __('General Options', 'skyre'),
        'description' => __('Panel to update skyre theme options', 'skyre'), // Include html tags such as <p>.
        'priority' => 10 // Mixed with top-level-section hierarchy.
    ));

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
			
			
			
			

			/*Layout options*/
			$layout_loption = array(
				array(
					'id' => 'page_layout',
					'title' => 'Page layout',
				), 
				array(
					'id' => 'post_layout',
					'title' => 'Post layout',
				), 
				array(
					'id' => 'single_post_layout',
					'title' => 'Single post layout',
				),
			);
			skyre_layout($wp_customize, $layout_loption);
			/*Layout options*/
			
			// Global options
            $wp_customize->add_section('skyre_global_options', array(
				'title' => __('Body style', 'skyre'),
				'priority' => 31,
				'panel' => 'skyre_main_options'
			));
            
			
			$wp_customize->add_setting('skyre[bodybg_color]', array(
                'default' => '#181449',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[bodybg_color]', array(
                'label' => __('Background Color', 'skyre'),
                'section' => 'skyre_global_options',
                'settings' => 'skyre[bodybg_color]',
            )));
			

		$wp_customize->register_control_type( 'Skyre_Control_Responsive' );
		
		$wp_customize->add_setting( 'sample_image_radio_buttonq',
			array(
				'default' => '',
				'type'  => 'option',
				'sanitize_callback' => 'sanitize_responsive_typo'
			)
		);
		$wp_customize->add_control( new Skyre_Control_Responsive( $wp_customize, 'sample_image_radio_buttonq',
			array(
				'label' => __( 'Image Radio Button Control2', 'skyrocket' ),
				'description' => esc_html__( 'Sample custom control description', 'skyrocket' ),
				'section' => 'skyre_global_options',
				'units' => array('px'=>'px','%'=>'%',),
				
			)
		) );
			/////////////////////////
			// Test of Image Radio Button Custom Control
		$wp_customize->register_control_type( 'Skyre_Control_Radio_Image' );
		
		$wp_customize->add_setting( 'page_layout',
			array(
				'default' => '',
				'type'  => 'option',
				'sanitize_callback' => 'skyrocket_radio_sanitization'
			)
		);
		$wp_customize->add_control( new Skyre_Control_Radio_Image( $wp_customize, 'page_layout',
			array(
				'label' => __( 'Image Radio Button Control', 'skyrocket' ),
				'description' => esc_html__( 'Sample custom control description', 'skyrocket' ),
				'section' => 'skyre_global_options',
				'choices' => array(
					'sidebarleft' => array(
						'path' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer/images/sidebar-left.png',
						'label' => __( 'Left Sidebar', 'skyrocket' )
					),
					'sidebarnone' => array(
						'path' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer/images/sidebar-none.png',
						'label' => __( 'No Sidebar', 'skyrocket' )
					),
					'sidebarright' => array(
						'path' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer/images/sidebar-right.png',
						'label' => __( 'Right Sidebar', 'skyrocket' )
					)
				)
			)
		) );
		
		
		
			////////////////////////////
			
			
			$wp_customize->add_setting('skyre[bodybg_image]', array(
                'default' => '',
                'type'  => 'option'
            ));
            $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'skyre[bodybg_image]', array(
                'label' => __('Background Image', 'skyre'),
                'section' => 'skyre_global_options',
				'mime_type' => 'image',
                'settings' => 'skyre[bodybg_image]',
            )));
			
			$wp_customize->add_setting('skyre[bodybg_repeat]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_repeat',
            ));
			$wp_customize->add_control('skyre[bodybg_repeat]', array(
                'label' => __('Background Repeat', 'skyre'),
                'section' => 'skyre_global_options',
                'type' => 'select',
				'choices' => array(
					'' => __( '--Select--', 'skyre' ),
					'repeat' => __( 'Repeat', 'skyre' ),
					'repeat-x' => __( 'Repeat X', 'skyre' ),
					'repeat-y' => __( 'Repeat Y', 'skyre' ),
					'no-repeat' => __( 'No Repat', 'skyre' ), ),
	  
            ));
			
			$wp_customize->add_setting('skyre[bodybg_bg_position]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_position',
            ));
			$wp_customize->add_control('skyre[bodybg_bg_position]', array(
                'label' => __('Background Positions', 'skyre'),
                'section' => 'skyre_global_options',
                'type' => 'select',
				'default' => 'repeat',
				'choices' => get_background_positions()
	  
            ));
			
			$args = array( 
				array( 'title' => 'Global Text', 'id' => 'body', 'default' => '', ),
				array( 'title' => 'Page Header', 'id' => 'page-header', 'default' => '', ),
				array( 'title' => 'Main Menu', 'id' => 'topmenu', 'default' => '', ),
				array( 'title' => 'Footer', 'id' => 'footermenu', 'default' => '', ),
				array( 'title' => 'H1', 'id' => 'h1head', 'default' => '', ),
				array( 'title' => 'H2', 'id' => 'h2head', 'default' => '', ),
				array( 'title' => 'H3', 'id' => 'h3head', 'default' => '', ),
				array( 'title' => 'H4', 'id' => 'h4head', 'default' => '', ),
				array( 'title' => 'H5', 'id' => 'h5head', 'default' => '', ),
				array( 'title' => 'H6', 'id' => 'h6head', 'default' => '', ),
				);

			
			addtypo($args,$wp_customize );
			
        /* skyre Loader Options */
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
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[loader_bg]', array(
                'label' => __('Loader Background', 'skyre'),
                'section' => 'skyre_loader_options',
            )));
			
			$wp_customize->add_setting('skyre[loader_primary]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[loader_primary]', array(
                'label' => __('Loader Primary Color', 'skyre'),
                'section' => 'skyre_loader_options',
            )));
			
			$wp_customize->add_setting('skyre[loader_secondary]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[loader_secondary]', array(
                'label' => __('Loader Secondary Color', 'skyre'),
                'section' => 'skyre_loader_options',
            )));
		
		/* skyre Header Options */
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
		/////////////////////////////////
		/* skyre Header Options */
        $wp_customize->add_section('skyre_post_options', array(
            'title' => __('Post settings', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_main_options'
        ));
        
            
			$wp_customize->add_setting( 'skyre[post_title]', array(
                    'type'  => 'option',
                    'sanitize_callback' => 'skyre_sanitize_checkbox',
            ) );
            // add checkbox control for excerpts/full posts toggle
            $wp_customize->add_control( 'skyre[post_title]', array(
                    'label'     => esc_html__( 'Disable Post title?', 'skyre' ),
                    'section'   => 'skyre_post_options',
                    'priority'  => 10,
                    'type'      => 'checkbox'
            ) );
			
			$wp_customize->add_setting('skyre[post_header_height]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_number_px'
            ));
            $wp_customize->add_control('skyre[post_header_height]', array(
                'label' => __('Hader hight', 'skyre'),
				'section' => 'skyre_post_options',
				'type' => 'text',
            ));
			
			$wp_customize->add_setting('skyre[post_header_bg_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[post_header_bg_color]', array(
                'label' => __('Header background', 'skyre'),
				'section' => 'skyre_post_options',
            )));
			
			$wp_customize->add_setting('skyre[post_header_bg_image]', array(
                'default' => '',
                'type'  => 'option'
            ));
            $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'skyre[post_header_bg_image]', array(
                'label' => __('Background Image', 'skyre'),
                'section' => 'skyre_post_options',
				'mime_type' => 'image',
                'settings' => 'skyre[post_header_bg_image]',
            )));
			
			$wp_customize->add_setting('skyre[post_header_bg_repeat]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_repeat',
            ));
			$wp_customize->add_control('skyre[post_header_bg_repeat]', array(
                'label' => __('Background Repeat', 'skyre'),
                'section' => 'skyre_post_options',
                'type' => 'select',
				'default' => 'repeat',
				'choices' => array(
					'' => __( '--Select--', 'skyre' ),
					'repeat' => __( 'Repeat', 'skyre' ),
					'repeat-x' => __( 'Repeat X', 'skyre' ),
					'repeat-y' => __( 'Repeat Y', 'skyre' ),
					'no-repeat' => __( 'No Repat', 'skyre' ), ),
	  
            ));
			
			$wp_customize->add_setting('skyre[post_header_bg_position]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_position',
            ));
			$wp_customize->add_control('skyre[post_header_bg_position]', array(
                'label' => __('Background Positions', 'skyre'),
                'section' => 'skyre_post_options',
                'type' => 'select',
				'default' => 'repeat',
				'choices' => get_background_positions()
	  
            ));
			
			$wp_customize->add_setting('skyre[post_header_padding_lr]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_number_px'
            ));
            $wp_customize->add_control('skyre[post_header_padding_lr]', array(
                'label' => __('Title padding left-right', 'skyre'),
				'section' => 'skyre_post_options',
				'type' => 'text',
            ));
			
			$wp_customize->add_setting('skyre[post_header_padding_tb]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_number_px'
            ));
            $wp_customize->add_control('skyre[post_header_padding_tb]', array(
                'label' => __('Title padding top-bottom', 'skyre'),
				'section' => 'skyre_post_options',
				'type' => 'text',
            ));
		
		//////////////////////////////////
		
		/* skyre Top Menu/Navigation Options */
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
                'label' => __('Box Shadow', 'skyre'),
                'section' => 'skyre_menu_options',
                'type' => 'checkbox',
            ));
			
			
			$wp_customize->add_setting('skyre[mainmenu_bg]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[mainmenu_bg]', array(
                'label' => __('Background', 'skyre'),
                'section' => 'skyre_menu_options',
            )));

        $wp_customize->add_setting('skyre[sticky_bg]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[sticky_bg]', array(
                'label' => __('Fixed menu background', 'skyre'),
                'section' => 'skyre_menu_options',
            )));
             
            $wp_customize->add_setting('skyre[nav_item_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[nav_item_color]', array(
                'label' => __('Menu color', 'skyre'),
                'section' => 'skyre_menu_options',
            )));

            $wp_customize->add_setting('skyre[nav_item_hover_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[nav_item_hover_color]', array(
                'label' => __('Menu hover color', 'skyre'),
                'section' => 'skyre_menu_options',
            )));

            $wp_customize->add_setting('skyre[nav_dropdown_bg]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[nav_dropdown_bg]', array(
                'label' => __('Dropdown background', 'skyre'),
                'section' => 'skyre_menu_options',
            )));

            $wp_customize->add_setting('skyre[nav_dropdown_item]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[nav_dropdown_item]', array(
                'label' => __('Dropdown menu color', 'skyre'),
                'section' => 'skyre_menu_options',
            )));

            $wp_customize->add_setting('skyre[nav_dropdown_item_hover]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[nav_dropdown_item_hover]', array(
                'label' => __('Dropdown menu hover color', 'skyre'),
                'section' => 'skyre_menu_options',
            )));

		
		$layout_panel->register_configuration( $wp_customize );
		//return apply_filters( 'skyre_customizer_configurations', array(), $wp_customize );
		
		
		

        /* skyre Footer color Options */
        $wp_customize->add_section('skyre_footer_options', array(
            'title' => __('Footer Color', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_main_options'
        ));
            //footer
			
			$wp_customize->add_setting('skyre[footer_bg_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[footer_bg_color]', array(
                'label' => __('background color', 'skyre'),
                'section' => 'skyre_footer_options',
            )));
			
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
			
			
			$wp_customize->add_setting('skyre[footer_nav_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[footer_nav_color]', array(
                'label' => __('Menu color', 'skyre'),
                'section' => 'skyre_footer_options',
            )));

            $wp_customize->add_setting('skyre[footer_nav_hover_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[footer_nav_hover_color]', array(
                'label' => __('Menu hover color', 'skyre'),
                'section' => 'skyre_footer_options',
            )));

            $wp_customize->add_setting('skyre[footer_item_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[footer_item_color]', array(
                'label' => __('Text Color', 'skyre'),
                'section' => 'skyre_footer_options',
            )));

            $wp_customize->add_setting('skyre[footer_social_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[footer_social_color]', array(
                'label' => __('Social Icon Color', 'skyre'),
                'section' => 'skyre_footer_options',
            )));

            $wp_customize->add_setting('skyre[footer_social_hover_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[footer_social_hover_color]', array(
                'label' => __('Social Icon hover color', 'skyre'),
                'section' => 'skyre_footer_options',
            )));
			
			$wp_customize->add_setting('skyre[footer_widget_bg_color]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[footer_widget_bg_color]', array(
                'label' => __('Footer widget area background color', 'skyre'),
                'section' => 'skyre_footer_options',
            )));

        /* skyre ScrollTop Options */
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
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[scrolltop_bg]', array(
                'label' => __('Background', 'skyre'),
                'section' => 'skyre_scrolltop_options',
            )));
			
			$wp_customize->add_setting('skyre[scrolltop_hover_bg]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[scrolltop_hover_bg]', array(
                'label' => __('Hover background', 'skyre'),
                'section' => 'skyre_scrolltop_options',
            )));
			
			$wp_customize->add_setting('skyre[scrolltop_icon]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[scrolltop_icon]', array(
                'label' => __('Text color', 'skyre'),
                'section' => 'skyre_scrolltop_options',
            )));
			
			$wp_customize->add_setting('skyre[scrolltop_icon_hover]', array(
                'default' => '',
                'type'  => 'option',
                'sanitize_callback' => 'skyre_sanitize_hexcolor'
            ));
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre[scrolltop_icon_hover]', array(
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
			


	
	}
function skyre_layout($wp_customize, $options) {
	$default_choice = array(
		'sidebarleft' => array(
			'path' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer/images/sidebar-left.png',
			'label' => __( 'Left Sidebar', 'skyrocket' )
		),
		'sidebarnone' => array(
			'path' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer/images/sidebar-none.png',
			'label' => __( 'No Sidebar', 'skyrocket' )
		),
		'sidebarright' => array(
			'path' => trailingslashit( get_template_directory_uri() ) . 'inc/customizer/images/sidebar-right.png',
			'label' => __( 'Right Sidebar', 'skyrocket' )
		),
	);
	
	// Layout options
	$wp_customize->add_section('skyre_layout', array(
		'title' => __('Layout', 'skyre'),
		'priority' => 31,
		'panel' => 'skyre_main_options'
	));
	
	foreach($options as $option){
		
		if(!isset($option['choice'])){ $option['choice'] = $default_choice; }

		$wp_customize->register_control_type( 'Skyre_Control_Radio_Image' );
		$wp_customize->add_setting( 'skyre['.$option['id'].']',
			array(
				'default' => '',
				'type'  => 'option',
				'sanitize_callback' => 'skyre_layout_sanitization'
			)
		);

		$wp_customize->add_control( new Skyre_Control_Radio_Image( $wp_customize, 'skyre['.$option['id'].']',
			array(
				'label' => __( $option['title'], 'skyre' ),
				'section' => 'skyre_layout',
				'choices' => $option['choice'],
				)
		) );

		
		/* Add full width check  */
		$wp_customize->add_setting( 'skyre[fullwidth_'.$option['id'].']', array(
				'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_checkbox',
		) );
		// add checkbox control for excerpts/full posts toggle
		$wp_customize->add_control( 'skyre[fullwidth_'.$option['id'].']', array(
				'label'     => esc_html__( 'Full width ?', 'skyre' ),
				'section'   => 'skyre_layout',
				'priority'  => 10,
				'type'      => 'checkbox'
		) );
		
		/* Add divider  */
		$wp_customize->register_control_type( 'Skyre_Control_Divider' );
		
		$wp_customize->add_setting( 'divider_'.$option['id'], 
			array( 'type'  => 'option', ) 
		);
		$wp_customize->add_control( new Skyre_Control_Divider( $wp_customize, 'divider_'.$option['id'],
			array( 'section' => 'skyre_layout', )
		) );
		/* Add divider  */
		
	}
}

function divider($id, $wp_customize){
	$wp_customize->register_control_type( 'Skyre_Control_Divider' );
	$wp_customize->add_setting( 'divider', 
		array( 'type'  => 'option', ) 
	);
	$wp_customize->add_control( new Skyre_Control_Divider( $wp_customize, 'divider',
		array( 'section' => $id, )
	) );
}


/**
 * Sanitzie checkbox for WordPress customizer
 */
function skyre_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}
/**
 * Adds sanitization callback function: colors
 * @package skyre
 */
function skyre_sanitize_hexcolor($color) {
    if ($unhashed = sanitize_hex_color_no_hash($color))
        return '#' . $unhashed;
    return $color;
}

/**
 * Adds sanitization callback function: Nohtml
 * @package skyre
 */
function skyre_sanitize_nohtml($input) {
    return wp_filter_nohtml_kses($input);
}

/**
 * Adds sanitization callback function: Number
 * @package skyre
 */
function skyre_sanitize_number($input) {
    if ( isset( $input ) && is_numeric( $input ) ) {
        return $input;
    }
}

/**
 * Adds sanitization callback function: Number px
 * @package skyre
 */
function skyre_sanitize_number_px($input) {
    if ( isset( $input ) && is_numeric( $input ) ) {
        return $input.'px';
    }
}

/**
 * Adds sanitization callback function: Strip Slashes
 * @package skyre
 */
function skyre_sanitize_strip_slashes($input) {
    return wp_kses_stripslashes($input);
}

/**
 * Adds sanitization callback function: Sanitize Text area
 * @package skyre
 */
function skyre_sanitize_textarea($input) {
    return sanitize_text_field($input);
}



/**
 * Adds sanitization callback function: Sidebar Layout
 * @package skyre
 */
function skyre_sanitize_layout( $input ) {
    global $site_layout;
    if ( array_key_exists( $input, $site_layout ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Adds sanitization callback function: Typography Size
 * @package skyre
 */
function skyre_sanitize_typo_size( $input ) {
    global $typography_options, $typography_defaults;
    if ( array_key_exists( $input, $typography_options['sizes'] ) ) {
        return $input;
    } else {
        return $typography_defaults['size'];
    }
}
/**
 * Adds sanitization callback function: Typography Face
 * @package skyre
 */
function skyre_sanitize_typo_face( $input ) {
    global $typography_options, $typography_defaults;
    if ( array_key_exists( $input, $typography_options['faces'] ) ) {
        return $input;
    } else {
        return $typography_defaults['face'];
    }
}
/**
 * Adds sanitization callback function: Typography Style
 * @package skyre
 */
function skyre_sanitize_typo_style( $input ) {
    global $typography_options, $typography_defaults;
    if ( array_key_exists( $input, $typography_options['styles'] ) ) {
        return $input;
    } else {
        return $typography_defaults['style'];
    }
}




/**
 * Sanitize the page layout options.
 *
 * @param string $input Page layout.
 */
function skyre_sanitize_page_layout( $input ) {
	$valid = array(
		'one-column' => __( 'One Column', 'skyre' ),
		'two-column' => __( 'Two Column', 'skyre' ),
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	}

	return '';
}

/**
 * Sanitize the background repeat options.
 *
 * @param string $input Page layout.
 */
function skyre_sanitize_bg_repeat( $input ) {
	$valid = array(
		'' => __( '--Select--', 'skyre' ),
		'repeat' => __( 'Repeat', 'skyre' ),
		'repeat-x' => __( 'Repeat X', 'skyre' ),
		'repeat-y' => __( 'Repeat Y', 'skyre' ),
		'no-repeat' => __( 'No Repat', 'skyre' ),
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	}

	return '';
}

/**
 * Sanitize the background position options.
 *
 * @param string $input Page layout.
 */
function skyre_sanitize_bg_position( $input ) {
	$valid = get_background_positions();

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	}

	return '';
}

/**
 * Sanitize Responsive Typography
 *
 * @param  array|number $val Customizer setting input number.
 * @return array        Return number.
 */
function sanitize_responsive_typo( $val ) {

	$responsive = array(
		'desktop'      => '',
		'tablet'       => '',
		'mobile'       => '',
		'desktop-unit' => '',
		'tablet-unit'  => '',
		'mobile-unit'  => '',
	);
	if ( is_array( $input ) ) {
		$responsive['desktop']      = is_numeric( $input['desktop'] ) ? $input['desktop'] : '';
		$responsive['tablet']       = is_numeric( $input['tablet'] ) ? $input['tablet'] : '';
		$responsive['mobile']       = is_numeric( $input['mobile'] ) ? $input['mobile'] : '';
		$responsive['desktop-unit'] = in_array( $input['desktop-unit'], array( '', 'px', 'em', 'rem', '%' ) ) ? $input['desktop-unit'] : 'px';
		$responsive['tablet-unit']  = in_array( $input['tablet-unit'], array( '', 'px', 'em', 'rem', '%' ) ) ? $input['tablet-unit'] : 'px';
		$responsive['mobile-unit']  = in_array( $input['mobile-unit'], array( '', 'px', 'em', 'rem', '%' ) ) ? $input['mobile-unit'] : 'px';
	} else {
		$responsive['desktop'] = is_numeric( $input ) ? $input : '';
	}
	return $responsive;
}


/**
 * Sanitize Responsive Typography
 *
 * @param  array|number $val Customizer setting input number.
 * @return array        Return number.
 */
function skyre_layout_sanitization( $input ) {
	$valid = array(
		'sidebarleft' => __( 'Style 1', 'skyre' ),
		'sidebarnone' => __( 'Style 2', 'skyre' ),
		'sidebarright' => __( 'Style 3', 'skyre' ),
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	}

	return '';
	}

/**
 * Sanitize the page layout options.
 *
 * @param string $input Page layout.
 */
function skyre_sanitize_header_style( $input ) {
	$valid = array(
		'1' => __( 'Style 1', 'skyre' ),
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	}

	return '';
}

/**
 * Sanitize the colorscheme.
 *
 * @param string $input Color scheme.
 */
function skyre_sanitize_colorscheme( $input ) {
	$valid = array( 'light', 'dark', 'custom' );

	if ( in_array( $input, $valid, true ) ) {
		return $input;
	}

	return 'light';
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @since Skyre 1.0
 * @see skyre_customize_register()
 *
 * @return void
 */
function skyre_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Skyre 1.0
 * @see skyre_customize_register()
 *
 * @return void
 */
function skyre_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Return whether we're previewing the front page and it's a static page.
 */
function skyre_is_static_front_page() {
	return ( is_front_page() && ! is_home() );
}

/**
 * Return whether we're on a view that supports a one or two column layout.
 */
function skyre_is_view_with_layout_option() {
	// This option is available on all pages. It's also available on archives when there isn't a sidebar.
	return ( is_page() || ( is_archive() && ! is_active_sidebar( 'sidebar-1' ) ) );
}

/**
 * Bind JS handlers to instantly live-preview changes.
 */
function skyre_customize_preview_js() {
	wp_enqueue_script( 'skyre-customize-preview', get_theme_file_uri( '/assets/js/customize-preview.js' ), array( 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'skyre_customize_preview_js' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function skyre_panels_js() {
	wp_enqueue_script( 'skyre-customize-controls', get_theme_file_uri( '/assets/js/customize-controls.js' ), array(), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'skyre_panels_js' );

