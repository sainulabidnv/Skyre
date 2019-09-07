<?php
/**
 * Additional features to allow styling of the templates
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */
add_theme_support( 'skyre' );




add_image_size( 'sportspress-icon', 128, 128, true ); 
add_image_size( 'sportspress-mini', 32, 32, true );

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

function skyre_sp_scripts() {
	// custom css for sportspress
	wp_enqueue_style( 'skyre-sp-style', get_template_directory_uri().'/sportspress/assets/css/style.css');
}
add_action( 'wp_enqueue_scripts', 'skyre_sp_scripts' );

/*Add replace general options in settins->General->Options*/
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

function sk_player_options( $options ) {
		$options = array_merge( $options, array(
			array(
				'title'     => __( 'Sidebar', 'skyre' ),
				'id' 		=> 'sportspress_single_player_sidebar',
				'default'	=> 'no',
				'type' 		=> 'radio',
				'options' => array(
					'no'		=> __( 'No Sidebar', 'skyre' ),
					'left'	=> __( 'Left Sidebar', 'skyre' ),
					'right'	=> __( 'Right Sidebar', 'skyre' ),
				),
			),
		) );
		return $options;
	}
add_filter( 'sportspress_player_options', 'sk_player_options' );

/*Add replace options in settins->Player->Options*/
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
					'name' => array(
						'title' => __( 'Sainul Excerpt', 'skyre' ),
						'option' => 'sportspress_player_show_excerpt_sainul',
						'action' => 'sportspress_output_post_excerpt_sainul',
						'default' => 'yes',
					),
				);

		return $options;
	}

add_filter( 'sportspress_before_player_template', 'sk_player_template'  );




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

//add_options('skyre_player',array('skyre_player'=>15));


// array of options
$data_r = array('layout' => '3');
// add a new option
//update_option('skyre_player', $data_r);
// get an option

//$optionas = skyre_get_player_option( 'fullwidth' );
//print_r( $optionas );











