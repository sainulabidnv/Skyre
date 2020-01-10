<?php
/**
 * Additional features to allow styling of the templates
 *
 * @package WordPress
 * @subpackage skyre
 * @since 1.0
 */
add_theme_support( 'sportspress' );
add_image_size( 'sportspress-icon', 128, 128, true ); 
add_image_size( 'sportspress-mini', 32, 32, true );
add_image_size( 'skyre-player-medium', 220, 250, true );
add_image_size( 'skyre-player-large', 440, 500, true );

if ( ! function_exists( 'skyre_get_sp_option' ) ) :
function skyre_get_sp_option( $name, $default = false ) {

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
if(!function_exists('skyre_sp_customizer_style')){
    
    function skyre_sp_customizer_style(){
		$classes = get_body_class();
		$style_css 	= '';
		if (in_array('sportspress-page',$classes)) {
		
			if(skyre_get_page_option('sp_title_bg_color') || skyre_get_page_option('sp_title_bg_image') ){
				$style_css .= '.sp-page-title {  background: url('.wp_get_attachment_image_url( skyre_get_page_option("sp_title_bg_image"),"full").') '.skyre_get_page_option("sp_title_bg_repeat").' '.skyre_get_page_option("sp_title_bg_color").' '.skyre_get_page_option("sp_title_bg_position").'; background-size: '.skyre_get_page_option("sp_title_bg_size").'; }';
			}
			$style_css .= skyre_get_dimension_style('sp_title_margin','.sp-page-title','page','margin');
			$style_css .= skyre_get_dimension_style('sp_title_padding','.sp-page-title','page','padding');
			$style_css .= skyre_get_dimension_style('sp_title_border_height','.sp-page-title h1','page','border',' solid');
			if(skyre_get_page_option('sp_title_border_color') ){ $style_css .= ' .sp-page-title h1 {  border-color: '.skyre_get_page_option('sp_title_border_color').';  }'; }
		
		}

		if(! empty($style_css)){
			echo '<style type="text/css">'.$style_css.'</style>';
		}
	}
}

add_action('wp_head', 'skyre_sp_customizer_style');

if ( !function_exists( 'sk_sp_add_link' ) ) {
	function sk_sp_add_link( $string, $link = false, $active = true ) {
		if ( empty( $link ) || ! $active ) return $string;
		return '<a href="' . $link . '" >' . $string . '</a>';
	}
}

function sk_table_style() {
	$options = array(
		'' => 'None',
		'table-dark' => 'Table Dark',
		'table-striped' => 'Striped rows',
		'table-striped table-dark' => 'Striped black rows',
		'table-bordered' => 'Bordered table',
		'table-borderless' => 'Borderless table',
		'table-borderless table-dark' => 'Borderless black table',
		'table-hover' => 'Hoverable rows',
		'table-hover table-dark' => 'Hoverable black rows',
		'table-sm' => 'Small table',
		'table-sm table-dark' => 'Small black table',
	);
	return $options;
}
//get sidebar options
function sk_sidebar_option($id) {
	return array(
		'title'     => __( 'Sidebar', 'skyre' ),
		'id' 		=> 'sportspress_single_'.$id.'_sidebar',
		'default'	=> 'no',
		'type' 		=> 'radio',
		'options' => array(
			'no'	=> __( 'No Sidebar', 'skyre' ),
			'left'	=> __( 'Left Sidebar', 'skyre' ),
			'right'	=> __( 'Right Sidebar', 'skyre' ),
		),
	);
}

function skyre_sp_scripts() {
	// custom css for sportspress
	wp_enqueue_style( 'skyre-sp-style', get_template_directory_uri().'/sportspress/assets/css/style.css');
}
add_action( 'wp_enqueue_scripts', 'skyre_sp_scripts' );

/*Add options in settins->General->Options*/
function sk_table_options( $options ) {
	$options = array_merge( $options, array(
		array(
			'title'     => __( 'Table Style', 'skyre' ),
			'id' 		=> 'sk_sportspress_table_style',
			'default'	=> 'table-borderless',
			'type' 		=> 'select',
			'options' => sk_table_style(),
		),
	) );
	return $options;
}
add_filter( 'sportspress_general_options', 'sk_table_options' );

//Add options in settins->Player->Options
function sk_player_options( $options ) {
	$options = array_merge( $options, array(
		sk_sidebar_option('player'),
		) );
		return $options;
	}
add_filter( 'sportspress_player_options', 'sk_player_options');

/*Add options in settins->Player->Options*/
function sk_player_template( $options ) {
		$options = array(
					'selector' => array(
						'title' => __( 'Dropdown', 'skyre' ),
						'label' => __( 'Players', 'skyre' ),
						'option' => 'sportspress_player_show_selector',
						'action' => 'sportspress_output_player_selector',
						'default' => 'yes',
					),
					'details' => array(
						'title' => __( 'Details', 'skyre' ),
						'option' => 'sportspress_player_show_details',
						'action' => 'sportspress_output_player_details',
						'default' => 'yes',
					),
					'excerpt' => array(
						'title' => __( 'Excerpt', 'skyre' ),
						'option' => 'sportspress_player_show_excerpt',
						'action' => 'sportspress_output_post_excerpt',
						'default' => 'yes',
					),
					/*
					'name' => array(
						'title' => __( 'sample Excerpt', 'skyre' ),
						'option' => 'sportspress_player_show_excerpt_sample',
						'action' => 'sportspress_output_post_excerpt_sample',
						'default' => 'yes',
					),
					*/
				);

		return $options;
	}

add_filter( 'sportspress_before_player_template', 'sk_player_template'  );

//Add options in settins->Evnet->Options
function sk_event_options( $options ) {
	$options = array_merge( $options, array(
		array(
			'title'     => __( 'Featured image', 'skyre' ),
			'id' 		=> 'sportspress_single_event_banner',
			'default'	=> 'no',
			'type' 		=> 'checkbox',
			'desc' 		=> __( 'Full width ?', 'skyre' ),
		),
		array(
			'title'     => __( 'Hide title', 'skyre' ),
			'id' 		=> 'sportspress_single_event_title',
			'default'	=> 'no',
			'type' 		=> 'checkbox',
			
		),
		sk_sidebar_option('event'),
	) );
	return $options;
}
add_filter( 'sportspress_event_template_options', 'sk_event_options' );

//Add options in settins->Calendar->Options
function sk_calendar_options( $options ) {
	$options = array_merge( $options, array(
		array(
			'title'     => __( 'Featured image', 'skyre' ),
			'id' 		=> 'sportspress_single_calendar_banner',
			'default'	=> 'no',
			'type' 		=> 'checkbox',
			'desc' 		=> __( 'Full width ?', 'skyre' ),
		),
		array(
			'title'     => __( 'Hide title', 'skyre' ),
			'id' 		=> 'sportspress_single_calendar_title',
			'default'	=> 'no',
			'type' 		=> 'checkbox',
			
		),
		sk_sidebar_option('calendar'),
	) );
	return $options;
}
add_filter( 'sportspress_calendar_options', 'sk_calendar_options' );

//Add options in settins->League->Options
function sk_league_options( $options ) {
	$options = array_merge( $options, array(
		array(
			'title'     => __( 'Featured image', 'skyre' ),
			'id' 		=> 'sportspress_single_league_banner',
			'default'	=> 'no',
			'type' 		=> 'checkbox',
			'desc' 		=> __( 'Full width ?', 'skyre' ),
		),
		array(
			'title'     => __( 'Hide title', 'skyre' ),
			'id' 		=> 'sportspress_single_league_title',
			'default'	=> 'no',
			'type' 		=> 'checkbox',
			
		),
		sk_sidebar_option('league'),
	) );
	return $options;
}
add_filter( 'sportspress_table_options', 'sk_league_options' );


//Add options in settins->Team->Options
function sk_team_options( $options ) {
	$options = array_merge( $options, array(
		sk_sidebar_option('team'),
	) );
	return $options;
}
add_filter( 'sportspress_team_options', 'sk_team_options' );

//Add options in settins->Staff->Options
function sk_staff_options( $options ) {
	$options = array_merge( $options, array(
		sk_sidebar_option('staff'),
	) );
	return $options;
}
add_filter( 'sportspress_staff_options', 'sk_staff_options' );

//Get saved post options
if ( ! function_exists( 'skyre_get_player_option' ) ) :
function skyre_get_player_option( $name, $default = false ) {
	$option_name = '';
	// Get option settings from database
	$options = get_option( 'skyre_player' );

	// Return specific option
	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return '';
}
endif;