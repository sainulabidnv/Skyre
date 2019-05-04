<?php
/**
 * Additional features to allow styling of the templates
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */
global $cryptoption;

$overrid = array(
	'post-boxed' => array(
		'name' => 'Blog boxed',
		'post'=>array(
			'blog_fullwidth' => '2',
			'blog_item_layout' => '1',
			'blog_item_count' => '6',
			),
		'default'=>array(
			'bodybg_color' => '',
			),
	),
	'post-grid-nosidebar' => array(
		'name' => 'Blog with No sidebar',
		'post'=>array(
			'blog_layout' => '2',
			'blog_item_layout' => '1',
			'blog_item_count' => '4',
			),
		'default'=>array(
			'bodybg_color' => '',
			),
	),
	'post-list-nosidebar' => array(
		'name' => 'Blog with No sidebar',
		'post'=>array(
			'blog_layout' => '2',
			'blog_item_layout' => '2',
			'blog_item_count' => '6',
			),
		'default'=>array(
			'bodybg_color' => '',
			),
	),
);

if(isset($_GET['demo']) and isset($overrid[$_GET['demo']]) ) { 
	$cryptoption = $overrid[$_GET['demo']];
}

if ( ! function_exists( 'skyre_get_option' ) ) :
function skyre_get_option( $name, $default = false ) {

	global $cryptoption;
	$option_name = '';
	// Get option settings from database
	$options = get_option( 'skyre' );
	
	if(isset($cryptoption['default'])) {
		$options = wp_parse_args( $options, $cryptoption['default'] );
		}
	// Return specific option
	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return $default;
}
endif;

//Get saved post options
if ( ! function_exists( 'skyre_get_page_option' ) ) :
function skyre_get_page_option( $name, $default = false ) {
	global $cryptoption;
	$option_name = '';
	// Get option settings from database
	$options = get_option( 'skyre_page' );
	if(isset($cryptoption['page'])) {
		$options = wp_parse_args( $options, $cryptoption['page'] );
		}

	// Return specific option
	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return '';
}
endif;

//Get saved post options
if ( ! function_exists( 'skyre_get_post_option' ) ) :
function skyre_get_post_option( $name, $default = false ) {
	global $cryptoption;
	$option_name = '';
	// Get option settings from database
	$options = get_option( 'skyre_post' );
	if(isset($cryptoption['post'])) {
		$options = wp_parse_args( $options, $cryptoption['post'] );
		}

	// Return specific option
	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return '';
}
endif;

//Get saved widget option
if ( ! function_exists( 'skyre_get_widget_option' ) ) :
function skyre_get_widget_option( $name, $default = false ) {
	$option_name = '';
	// Get option settings from database
	$options = get_option( 'skyre_widget' );

	// Return specific option
	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return '';
}
endif;

