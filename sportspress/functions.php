<?php
/**
 * Additional features to allow styling of the templates
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

if ( ! function_exists( 'skyre_get_sp_option' ) ) :
function skyre_get_sp_option( $name, $default = false ) {

	$option_name = '';
	// Get option settings from database
	$options = get_option( 'sportspress' );

	// Return specific option
	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return $default;
}
endif;

function add_player_options2( $options ) {
		$options = array_merge( $options, array(
			array(
				'title'     => __( 'Sainul', 'sportspress' ),
				'desc' 		=> __( 'Display birthday', 'sportspress' ),
				'id' 		=> 'sportspress_player_show_birthday_sainul',
				'default'	=> 'no',
				'type' 		=> 'checkbox',
				'checkboxgroup'		=> 'start',
			),

			
		) );

		return $options;
	}
add_filter( 'sportspress_player_options', 'add_player_options2'  );

function sk_player_template( $options ) {
		$options = array(
					'selector' => array(
						'title' => __( 'Dropdown', 'sportspress' ),
						'label' => __( 'Players', 'sportspress' ),
						'option' => 'sportspress_player_show_selector',
						'action' => 'sportspress_output_player_selector',
						'default' => 'yes',
					),
					'details' => array(
						'title' => __( 'Details', 'sportspress' ),
						'option' => 'sportspress_player_show_details',
						'action' => 'sportspress_output_player_details',
						'default' => 'yes',
					),
					'excerpt' => array(
						'title' => __( 'Excerpt', 'sportspress' ),
						'option' => 'sportspress_player_show_excerpt',
						'action' => 'sportspress_output_post_excerpt',
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








function skyre_sp_scripts() {
	// custom css for sportspress
	wp_enqueue_style( 'skyre-sp-style', get_template_directory_uri().'/sportspress/assets/css/style.css');
}
add_action( 'wp_enqueue_scripts', 'skyre_sp_scripts' );

//skyre_fonts_url('https://fonts.googleapis.com/css?family=Dosis:500');








