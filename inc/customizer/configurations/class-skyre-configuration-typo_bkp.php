<?php
/**
 * Customizer Control: Typo configuration.
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
 
if ( ! class_exists( 'Skyre_Configuration_Typo' ) ) {

	/**
	 * Customizer configuration Initial setup
	 */
	class Skyre_Configuration_Typo  {

		/**
		 * Constructor
		 */
		public function __construct() {
			//$this->register_configuration( $wp_customize);
		}
		
		public function register_configuration( $wp_customize, $options ) {
			
			 	
				$cfonts =  $this->getFonts();
				
				
				$wp_customize->add_panel('skyre_typo_options', array(
					'capability' => 'edit_theme_options',
					'theme_supports' => '',
					'title' => __('Typography', 'skyre'),
					'priority' => 10 // Mixed with top-level-section hierarchy.
				));
				
				
				
				foreach($args as $data)
				{
					// add "Content Options" section
					$wp_customize->add_section( 'skyre_'.$data['id'].'_section' , array( 'title'      => esc_html__( $data['title'], 'skyre' ), 'priority'   => 50, 'panel' => 'skyre_typo_options' ) );
					
					$wp_customize->add_setting('skyre['.$data['id'].'][color]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'skyre_sanitize_hexcolor', ));
					$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'skyre['.$data['id'].'][color]', array( 'label' => __('Font Color', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', )));
					
					$wp_customize->add_setting('skyre['.$data['id'].'][font-family]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'skyre_sanitize_fontfamily', ));
					$wp_customize->add_control('skyre['.$data['id'].'][font-family]', array( 'label' => __('Font Family', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', 'type' => 'select', 'choices' => $cfonts, ));
					
					$wp_customize->add_setting('skyre['.$data['id'].'][font-style]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'skyre_sanitize_fontstyle', ));
					$wp_customize->add_control('skyre['.$data['id'].'][font-style]', array( 'label' => __('Font Style', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', 'type' => 'select', 'choices' => skyre_get_font_styles(), ));
					
					$wp_customize->add_setting('skyre['.$data['id'].'][font-weight]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'skyre_sanitize_fontweight', ));
					$wp_customize->add_control('skyre['.$data['id'].'][font-weight]', array( 'label' => __('Font Weight', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', 'type' => 'select', 'choices' => skyre_get_font_weight(), ));
					
					$wp_customize->add_setting('skyre['.$data['id'].'][font-size]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'skyre_sanitize_number_px', ));
					$wp_customize->add_control('skyre['.$data['id'].'][font-size]', array( 'label' => __('Font size', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', 'type' => 'text', ));
					
					$wp_customize->add_setting('skyre['.$data['id'].'][line-height]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'skyre_sanitize_number_px', ));
					$wp_customize->add_control('skyre['.$data['id'].'][line-height]', array( 'label' => __('Line Height', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', 'type' => 'text',  ));
					
					$wp_customize->add_setting('skyre['.$data['id'].'][letter-spacing]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'skyre_sanitize_number_px', ));
					$wp_customize->add_control('skyre['.$data['id'].'][letter-spacing]', array( 'label' => __('Letter Spacing', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', 'type' => 'text', ));
					
					$wp_customize->add_setting('skyre['.$data['id'].'][text-align]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'skyre_sanitize_text_align', ));
					$wp_customize->add_control('skyre['.$data['id'].'][text-align]', array( 'label' => __('Text Align', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', 'type' => 'select', 'choices' => skyre_get_text_align(), ));
					
					/* Padding
					$wp_customize->add_setting('skyre['.$data['id'].'][padding-left]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'skyre_sanitize_number_px', ));
					$wp_customize->add_control('skyre['.$data['id'].'][padding-left]', array( 'label' => __('Padding left', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', 'type' => 'text', ));
					$wp_customize->add_setting('skyre['.$data['id'].'][padding-right]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'skyre_sanitize_number_px', ));
					$wp_customize->add_control('skyre['.$data['id'].'][padding-right]', array( 'label' => __('Padding right', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', 'type' => 'text', ));
					$wp_customize->add_setting('skyre['.$data['id'].'][padding-top]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'skyre_sanitize_number_px', ));
					$wp_customize->add_control('skyre['.$data['id'].'][padding-top]', array( 'label' => __('Padding top', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', 'type' => 'text', ));
					$wp_customize->add_setting('skyre['.$data['id'].'][padding-bottom]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'skyre_sanitize_number_px', ));
					$wp_customize->add_control('skyre['.$data['id'].'][padding-bottom]', array( 'label' => __('Padding bottom', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', 'type' => 'text', ));
					*/
					
					
				}
			 
			 
			
			}
			
			/**
			 * Get fonts
			 *
			 * @since 1.0.0
			 * @return array
			 */
			
				
					
				
				public function getFonts() {
					$fonts_data = array(
						'standard' => dirname( __FILE__ ) . '/assets/fonts/standard.json',
						'google'   => dirname( __FILE__ ) . '/assets/fonts/google.json',
					);
					$fonts_data = (array) $fonts_data;
					foreach ( $fonts_data as $type => $file ) {
						$data = $this->read_font_file( $file );
						$font[$type] = json_decode($data);
						foreach ( $font[$type] as $key => $value ) {
							if($type =='standard'){ 
								$fonts[$value] = $value.' [Standard]'; 
							}else {
								$fonts[$value] = $value;
								}
							
						}
					}
					asort($fonts);
					return $fonts;
				}
				
				
		
				public function read_font_file( $file ) {
		
					if ( ! file_exists( $file ) ) {
						return false;
					}
		
					// Read the file.
					$json = $this->get_file( $file );
		
					if ( ! $json ) {
						return new WP_Error( 'reading_error', 'Error when reading file' );
					}
		
					return $json;
				}
				
				/**
				 * Safely get file content.
				 *
				 * @global object $wp_filesystem
				 * @param  string $file File path.
				 * @return bool
				 */
				public function get_file( $file ) {
		
					if ( ! function_exists( 'WP_Filesystem' ) ) {
						include_once( ABSPATH . '/wp-admin/includes/file.php' );
					}
		
					WP_Filesystem();
					global $wp_filesystem;
		
					$result = '';
		
					if ( $wp_filesystem->abspath() ) {
						$result = $wp_filesystem->get_contents( $file );
					} 
		
					return $result;
				}

			
			
			
	}
}

