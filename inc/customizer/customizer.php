<?php
/**
 * Skyre: Customizer
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */
 

/*//Get saved post responsive count
if ( ! function_exists( 'skyre_get_post_res_count' ) ) :
function skyre_get_post_res_count( $name, $device ) {

	$option_name = '';
	// Get option settings from database
	$options = get_option( 'skyre_post' );

	// Return specific option
	if ( isset( $options[$name][$device] ) ) {
		$value = $options[$name][$device];
		$med = $options[$name][$device.'-unit'];
		return $value.$med;
	}
	

	return '';
}
endif;*/


if ( ! function_exists( 'skyre_get_res_count' ) ) :
function skyre_get_res_count( $name, $device ) {

	$option_name = '';
	// Get option settings from database
	$options = get_option( 'skyre' );

	// Return specific option
	if ( isset( $options[$name][$device] ) ) {
		$value = $options[$name][$device];
		$med = $options[$name][$device.'-unit'];
		return $value.$med;
	}
	return '';
}
endif;

//get saved deimension option

if ( ! function_exists( 'skyre_get_dimension' ) ) :
function skyre_get_dimension( $name, $device, $type='', $position='' ) {

	$value = '';
	if($type != '') $type = '_'.$type;
	$option_name = '';
	// Get option settings from database
	$options = get_option( 'skyre'.$type );
	// Return specific option
	if ( isset( $options[$name][$device] ) ) {
		if($position == ''){
		$value .= $options[$name][$device]['top'].'px ';
		$value .= $options[$name][$device]['right'].'px ';
		$value .= $options[$name][$device]['bottom'].'px ';
		$value .= $options[$name][$device]['left'].'px ';
		}else { 
			$value = ($options[$name][$device][$position])? $options[$name][$device][$position].'px ':''; 
		}
		//$med = 'px';
		return $value;
	}
	return '';
}
endif;

//get margin or padding css from dimension. 
if ( ! function_exists( 'skyre_get_dimension_style' ) ) :
function skyre_get_dimension_style($id,$class,$type='',$prefix='',$suffix='' ) {
	//array for border radius property
	$radius = array('top'=>'top-left', 'right'=>'top-right','bottom'=>'bottom-right', 'left'=>'bottom-left');
	
	$style = '';
	$media_style = '';
	if($prefix ==''){ $prefix = 'margin';}
	if($type != '') $type = '_'.$type;
	//$values = skyre_get_post_option($id);
	$options = get_option( 'skyre'.$type );
	// Return specific option
	if ( isset( $options[$id] ) and is_array( $options[$id]) ) { $values = $options[$id]; } else return '';
	
	foreach($values as $device => $property){
		
		if (array_filter($property)) {
			$pre_style = '';
			if($device == 'tablet' ){ $media_style ='@media (max-width: 767.98px) {';  }
			if($device == 'mobile' ) { $media_style ='@media (max-width: 575.98px) {';  }
				//print_r($media_style);
				foreach($property as $key=>$value) {
					if($value !='') {
						if($prefix=='border-radius') {
							$pre_style .='border-'.$radius[$key].'-radius:'.$value.'px'.$suffix.'; ';
						}else{
							$pre_style .=$prefix.'-'.$key.':'.$value.'px'.$suffix.'; ';
						}
						}
					}
			if($media_style !='') { $style .= $media_style;}
			if($pre_style !=''){ $style .= $class.'{'.$pre_style.'}'; }
			if($media_style !='') { $style .='}';  }
		}
	}
	return $style;
	
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
	
		require SKYRE_THEME_DIR.'/inc/customizer/configurations/class-skyre-configuration-footer.php' ;
		require SKYRE_THEME_DIR.'/inc/customizer/configurations/class-skyre-configuration-global.php' ;
		require SKYRE_THEME_DIR.'/inc/customizer/configurations/class-skyre-configuration-typo.php' ;
		require SKYRE_THEME_DIR.'/inc/customizer/configurations/class-skyre-configuration-loader.php' ;
		require SKYRE_THEME_DIR.'/inc/customizer/configurations/class-skyre-configuration-header.php' ;
		require SKYRE_THEME_DIR.'/inc/customizer/configurations/class-skyre-configuration-page.php' ;
		require SKYRE_THEME_DIR.'/inc/customizer/configurations/class-skyre-configuration-sportspress.php' ;
		require SKYRE_THEME_DIR.'/inc/customizer/configurations/class-skyre-configuration-post.php' ;
		require SKYRE_THEME_DIR.'/inc/customizer/configurations/class-skyre-configuration-widget.php' ;
		require SKYRE_THEME_DIR.'/inc/customizer/configurations/class-skyre-configuration-comment.php' ;
		require SKYRE_THEME_DIR.'/inc/customizer/configurations/class-skyre-configuration-navigation.php' ;
		require SKYRE_THEME_DIR.'/inc/customizer/configurations/class-skyre-configuration-scrolltop.php' ;
		require SKYRE_THEME_DIR.'/inc/customizer/configurations/class-skyre-configuration-miscellaneous.php' ;
		
	}

function include_coustom_control() {
	
	//SKYRE_THEME_URI . 'inc/customizer/skyrocket/inc/custom-controls.php';
	require SKYRE_THEME_DIR.'/inc/customizer/custom-controls/html/class-skyre-control-html.php' ;
	require SKYRE_THEME_DIR.'/inc/customizer/custom-controls/radio-image/class-skyre-control-radio-image.php' ;
	require SKYRE_THEME_DIR.'/inc/customizer/custom-controls/responsive/class-skyre-control-responsive.php' ;
	require SKYRE_THEME_DIR.'/inc/customizer/custom-controls/divider/class-skyre-control-divider.php' ;
	require SKYRE_THEME_DIR.'/inc/customizer/custom-controls/dimension/class-skyre-control-dimension.php' ;
	require SKYRE_THEME_DIR.'/inc/customizer/custom-controls/border/class-skyre-control-border.php' ;
	require SKYRE_THEME_DIR.'/inc/customizer/custom-controls/color/class-skyre-control-color.php' ;
	require SKYRE_THEME_DIR.'/inc/customizer/custom-controls/sortable/class-skyre-control-sortable.php' ;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function skyre_customize_register( $wp_customize ) {
	
	
	$wp_customize->remove_section("colors");
	$wp_customize->remove_control("header_image");
	/* Main option Settings Panel */
    $wp_customize->add_panel('skyre_main_options', array(
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => __('General Options', 'skyre'),
        'description' => __('Panel to update skyre theme options', 'skyre'), // Include html tags such as <p>.
        'priority' => 10 // Mixed with top-level-section hierarchy.
    ));
	
	$footer_panel = new Skyre_Configuration_Footer;
	$global_panel = new Skyre_Configuration_Global;
	//$layout_panel = new Skyre_Configuration_Layout;
	$typo_panel = new Skyre_Configuration_Typo;
	$loader_panel = new Skyre_Configuration_Loader;	
	$header_panel = new Skyre_Configuration_Header;
	$page_panel = new Skyre_Configuration_Page;
	$sportspress_panel = new Skyre_Configuration_Sportspress;
	$post_panel = new Skyre_Configuration_Post;
	$widget_panel = new Skyre_Configuration_Widget;
	$comment_panel = new Skyre_Configuration_Comment;
	$nav_panel = new Skyre_Configuration_Nav;
	$scrolltop_panel = new Skyre_Configuration_Scrolltop;
	$miscellaneous_panel = new Skyre_Configuration_Miscellaneous;
	
	
	
	
		/*Layout options*/
		$global_panel->register_configuration($wp_customize);
		
		/*Typo settings*/		
		$typo_panel->register_configuration($wp_customize);
		
		/* skyre Loader Options */
		$loader_panel->register_configuration($wp_customize);	
        
		/* skyre Page Header Options */
		//$header_panel->register_configuration($wp_customize);
		
		/* skyre Page Options */
		$page_panel->register_configuration($wp_customize);

		/* Sportspress Options */
		$sportspress_panel->register_configuration($wp_customize);
		
		/* skyre Post Options */
		$post_panel->register_configuration($wp_customize);
		
		/* skyre widget/sidebar Options */
		$widget_panel->register_configuration($wp_customize);
		
		/* skyre comment Options */
		$comment_panel->register_configuration($wp_customize);

		/* skyre Top Menu/Navigation Options */
		$nav_panel->register_configuration($wp_customize);
		
		/* skyre Footer Options */
		$footer_panel->register_configuration( $wp_customize );

        /* skyre ScrollTop Options */
		$scrolltop_panel->register_configuration( $wp_customize );
		
		/* skyre Miscellaneous/More Options */
		$miscellaneous_panel->register_configuration( $wp_customize );
        
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
 * Sanitize Alpha color
 *
 * @param  string $color setting input.
 * @return string        setting input value.
 */
function sanitize_alpha_color( $color ) {

	if ( '' === $color ) {
		return '';
	}

	if ( false === strpos( $color, 'rgba' ) ) {
		/* Hex sanitize */
		return skyre_sanitize_hexcolor( $color );
	}

	/* rgba sanitize */
	$color = str_replace( ' ', '', $color );
	sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
	return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';
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
 * Sanitize the background repeat options.
 *
 * @param string $input Page layout.
 */
function skyre_sanitize_bg_size( $input ) {
	$valid = array(
		'' => __( '--Select--', 'skyre' ),
		'auto' => __( 'Auto', 'skyre' ),
		'cover' => __( 'Cover', 'skyre' ),
		'contain' => __( 'Contain', 'skyre' ),
		'100% 100%' => __( 'Full fit', 'skyre' ), 
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	}

	return '';
}

/**
 * Sanitize the select options.
 *
 * @param string $input Page layout.
 */
function skyre_sanitize_select( $input ) {
	$valid = array(
		'' => __( '--Select--', 'skyre' ),
		'1' => __( 'Option 1', 'skyre' ),
		'2' => __( 'Option 2', 'skyre' ),
		'3' => __( 'Option 3', 'skyre' ),
		'4' => __( 'Option 4', 'skyre' ),
		'5' => __( 'Option 5', 'skyre' ),
		'6' => __( 'Option 6', 'skyre' ),
		'7' => __( 'Option 7', 'skyre' ),
		'8' => __( 'Option 8', 'skyre' ),
		'9' => __( 'Option 9', 'skyre' ),
		'10' => __( 'Option 10', 'skyre' ),
		'11' => __( 'Option 11', 'skyre' ),
		'12' => __( 'Option 12', 'skyre' ),
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
function sanitize_responsive_count( $input ) {

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
 * Sanitize Responsive Dimension
 *
 * @param  array|number $val Customizer setting input number.
 * @return array        Return number.
 */
function sanitize_responsive_dimension( $input ) {

	$responsive = array(
		'desktop'      => array(
			'top'  => '',
			'right'  => '',
			'bottom'  => '',
			'left'  => '',
		),
		'tablet'       => array(
			'top'  => '',
			'right'  => '',
			'bottom'  => '',
			'left'  => '',
		),
		'mobile'       => array(
			'top'  => '',
			'right'  => '',
			'bottom'  => '',
			'left'  => '',
		),
		
	);
	if ( is_array( $input ) ) {
		foreach ($input as $devicekey => $device ){
			foreach( $device as $key => $val)
			{
				$responsive[$devicekey][$key] = is_numeric( $val ) ? $val : '';
				} 
			}
		
	} 
	//print_r($responsive);
	return $responsive;
}

/**
 * Sanitize layout
 *
 * @param  array|number $val Customizer setting input number.
 * @return array        Return number.
 */
function skyre_radio_image_sanitization( $input ) {
	$valid = array(
		'1' => __( 'Option 1', 'skyre' ),
		'2' => __( 'Option 2', 'skyre' ),
		'3' => __( 'Option 3', 'skyre' ),
		'4' => __( 'Option 4', 'skyre' ),
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	}

	return '';
	}

function sanitize_multi_choices( $input, $setting ) {

			// Get list of choices from the control
			// associated with the setting.
			$choices    = $setting->manager->get_control( $setting->id )->choices;
			$input_keys = $input;

			foreach ( $input_keys as $key => $value ) {
				if ( ! array_key_exists( $value, $choices ) ) {
					unset( $input[ $key ] );
				}
			}

			// If the input is a valid key, return it;
			// otherwise, return the default.
			return ( is_array( $input ) ? $input : $setting->default );
		}

/**
 * Sanitize layout
 *
 * @param  array|number $val Customizer setting input number.
 * @return array        Return number.
 */
/*function skyre_layout_sanitization( $input ) {
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
*/
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
	wp_enqueue_script( 'skyre-customize-preview', get_theme_file_uri( '/inc/customizer/js/customize-preview.js' ), array( 'customize-preview' ), SKYRE_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'skyre_customize_preview_js' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function skyre_panels_scripts() {
	wp_enqueue_script( 'skyre-customize-controls', get_theme_file_uri( '/inc/customizer/js/customize-controls.js' ), array(), SKYRE_THEME_VERSION, true );
	wp_enqueue_script( 'wp-color-picker-alpha', get_template_directory_uri()."/assets/js/vendors/wp-color-picker-alpha.min.js", array( 'wp-color-picker' ), SKYRE_THEME_VERSION, true );
	wp_enqueue_style( 'skyre_customizer_style', get_theme_file_uri( '/inc/customizer/css/customizer-style.css'), '', SKYRE_THEME_VERSION );
}
add_action( 'customize_controls_enqueue_scripts', 'skyre_panels_scripts' );

