<?php
/**
 * Additional features to allow styling of the templates
 *
 * @package Skyre
 *  
 * @since 1.0
 */
global $demooption;

//Example - urlname/?demo=post-boxed
/*
		'name' => 'Blog boxed', 
		##Post settings
		'post'=>array( 
			'blog_fullwidth' => '2',
			'blog_item_layout' => '1',
			'blog_item_count' => '6',
			),
		##Global Settings
		'default'=>array( 
			'bodybg_color' => '',
			),
		##Page Settings
		'page'=>array(
			'bodybg_color' => '',
			),
*/
$overrid = array(
	'post-list-nosidebar' => array(
		'name' => 'Blog with No sidebar',
		'post'=>array(
			'blog_layout' => '2',
			'blog_item_layout' => '2',
			'blog_item_count' => '6',
			),
	),

	'post-grid' => array(
		'name' => 'Blog boxed',
		'post'=>array(
			'blog_fullwidth' => '2',
			'blog_item_layout' => '1',
			'blog_item_count' => '6',
			),
	),
	'post-grid-nosidebar' => array(
		'name' => 'Blog with No sidebar',
		'post'=>array(
			'blog_layout' => '2',
			'blog_item_layout' => '1',
			'blog_item_count' => '4',
			'default_field_position' =>array('image','meta','title'),
			),
		
	),

	'post-grid-nosidebar-fw' => array(
		'name' => 'Blog with No sidebar',
		'post'=>array(
			'blog_layout' => '2',
			'blog_item_layout' => '1',
			'blog_item_count' => '3',
			'blog_fullwidth' => '1',
			'default_field_position' =>array('image','meta','title','content'),
			
			),
	),

	'product-layout-2' => array(
		'name' => 'Product with left sidebar',
		'page'=>array(
			'woolayout' => '3',
			
			),
	),

	'page-no-sidebar' => array(
		'name' => 'Page no sidebar',
		'page'=>array(
			'layout' => '2',
			
			),
	),
	
	
	'single-post-modern' => array(
		'name' => 'Single Blog - Right sidebar with Modern Style',
		'post'=>array(
			'single_blog_layout' => '3',
			'template_style' => 'modern',
			),
		
	),

	'single-post-modern-left' => array(
		'name' => 'Single Blog - Left sidebar with Modern Style',
		'post'=>array(
			'single_blog_layout' => '1',
			'template_style' => 'modern',
			),
		
	),

	'single-post-nosidebar-order' => array(
		'name' => 'Single Blog - No sidebar, default layout, position',
		'post'=>array(
			'single_blog_layout' => '2',
			'default_single_field_position' =>array('image','meta','title','content'),
			),
		
	),

	
);

if(isset($_GET['demo']) and isset($overrid[$_GET['demo']]) ) { 
	$demooption = $overrid[$_GET['demo']];
}

if ( ! function_exists( 'skyre_get_option' ) ) :
function skyre_get_option( $name, $default = false ) {

	global $demooption;
	$option_name = '';
	// Get option settings from database
	$options = get_option( 'skyre' );
	
	if(isset($demooption['default'])) {
		$options = wp_parse_args( $demooption['default'], $options  );
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
	global $demooption;
	$option_name = '';
	// Get option settings from database
	$options = get_option( 'skyre_page' );
	if(isset($demooption['page'])) {
		$options = wp_parse_args( $demooption['page'], $options );
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
	global $demooption;
	$option_name = '';
	// Get option settings from database
	$options = get_option( 'skyre_post' );
	if(isset($demooption['post'])) {
		$options = wp_parse_args( $demooption['post'], $options );
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

