<?php
/**
 * Customizer Control: Layout configuration.
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
 
if ( ! class_exists( 'Skyre_Configuration_Layout' ) ) {

	/**
	 * Customizer configuration Initial setup
	 */
	class Skyre_Configuration_Layout  {

		/**
		 * Constructor
		 */
		public function __construct() {
			//$this->register_configuration( $wp_customize);
		}
		
		public function register_configuration( $wp_customize, $options ) {
		$default_choice = array(
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
					'sanitize_callback' => 'skyre_radio_image_sanitization'
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
	}
}

