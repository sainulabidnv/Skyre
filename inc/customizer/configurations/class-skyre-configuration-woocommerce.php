<?php
/**
 * Customizer Control: Sportspress configuration.
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
 
if ( ! class_exists( 'Skyre_Configuration_Woocommerce' ) ) {

	/**
	 * Customizer configuration Initial setup
	 */
	class Skyre_Configuration_Woocommerce  {

		/**
		 * Constructor
		 */
		public function __construct() {
			//$this->register_configuration( $wp_customize);
		}
		
		public function register_configuration( $wp_customize ) {
			
			
			
			
		$wp_customize->add_section('skyre_woo_layout', array(
            'title' => __('Product Page', 'skyre'),
            'priority' => 31,
            'panel' => 'woocommerce'
        ));
		
		
		/*Page/Page archive layout*/
		$wp_customize->register_control_type( 'Skyre_Control_Radio_Image' );
		$wp_customize->add_setting( 'skyre_page[woolayout]',
			array(
				'default' => '2',
				'type'  => 'option',
				'sanitize_callback' => 'skyre_radio_image_sanitization'
			)
		);
		$wp_customize->add_control( new Skyre_Control_Radio_Image( $wp_customize, 'skyre_page[woolayout]',
			array(
				'label' => __( 'Page sidebar', 'skyre' ),
				'section' => 'skyre_woo_layout',
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
        
		
		
		}
	}
}



