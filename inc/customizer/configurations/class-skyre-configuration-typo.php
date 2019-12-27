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

		var $typoSettings;
		
		/**
		 * Constructor
		 */
		public function __construct() {
			//$this->register_configuration( $wp_customize);
		}
		
		public function typoSettings() {
				$args = array( 
					array( 'title' => 'Global Text', 'id' => 'typo_body', 'default' => '', 'class' => 'body' ),
					array( 'title' => 'Anchor', 'id' => 'typo_a', 'default' => '', 'class' => 'a' ),
					array( 'title' => 'Anchor hover/active', 'id' => 'typo_a_hover', 'default' => '', 'class' => 'a:hover, .active a' ),
					
					array( 'title' => 'h1', 'id' => 'typo_h1', 'default' => '', 'class' => 'h1' ),
					array( 'title' => 'h2', 'id' => 'typo_h2', 'default' => '', 'class' => 'h2' ),
					
					array( 'title' => 'Main Menu', 'id' => 'typo_menu', 'default' => '', 'class' => '.mainmenu a' ),
					array( 'title' => 'Sub Menu', 'id' => 'typo_submenu', 'default' => '', 'class' => '.mainmenu .dropdown-menu a' ),
					array( 'title' => 'Menu hover', 'id' => 'typo_menu_hover', 'default' => '', 'class' => '.mainmenu a:hover' ),
					
					array( 'title' => 'Page title', 'id' => 'typo_page_title', 'default' => '', 'class' => '.page-title h1' ),
					array( 'title' => 'Page content', 'id' => 'typo_page_content', 'default' => '', 'class' => '.page-content' ),
					
					array( 'title' => 'Post/Archive header', 'id' => 'typo_post_header', 'default' => '', 'class' => '.post-title h1' ),
					array( 'title' => 'Post list title', 'id' => 'typo_post_list_title', 'default' => '', 'class' => '.skyre-post-item .entry-title a' ),
					array( 'title' => 'Post list content', 'id' => 'typo_post_list_content', 'default' => '', 'class' => '.skyre-post-item .post-content' ),
					array( 'title' => 'Post list meta', 'id' => 'typo_post_list_meta', 'default' => '', 'class' => '.skyre-post-item .post-meta, .skyre-post-item .post-meta a' ),
					array( 'title' => 'Post list readmore', 'id' => 'typo_post_list_readmore', 'default' => '', 'class' => '.post-readmore' ),
					
					array( 'title' => 'Single post title', 'id' => 'typo_post_title', 'default' => '', 'class' => 'h1.single-post-title' ),
					array( 'title' => 'Post content', 'id' => 'typo_post_content', 'default' => '', 'class' => '.skyre-single-post-item .post-content' ),
					array( 'title' => 'Post meta', 'id' => 'typo_post_meta', 'default' => '', 'class' => '.skyre-single-post-item .post-meta, .skyre-single-post-item .post-meta a' ),
					
					array( 'title' => 'SportsPress title', 'id' => 'typo_sportspress_title', 'default' => '', 'class' => '.sp-page-title .skwc' ),

					array( 'title' => 'Sidebar title', 'id' => 'typo_widget_title', 'default' => '', 'class' => '.sidebar-section .widget-title' ),
					array( 'title' => 'Sidebar content', 'id' => 'typo_widget_content', 'default' => '', 'class' => '.sidebar-section' ),
					array( 'title' => 'Sidebar anchor', 'id' => 'typo_widget_anchor', 'default' => '', 'class' => '.sidebar-section a' ),
					array( 'title' => 'Sidebar meta', 'id' => 'typo_widget_meta', 'default' => '', 'class' => '.sidebar-section .meta, .sidebar-section .meta a, .sidebar-section .meta span, .sidebar-section .meta time' ),
					
					array( 'title' => 'Comment title', 'id' => 'typo_comment_title', 'default' => '', 'class' => '.comments-title' ),
					array( 'title' => 'Comment content', 'id' => 'typo_comment_content', 'default' => '', 'class' => '.comments-area' ),
					array( 'title' => 'Comment author', 'id' => 'typo_comment_author', 'default' => '', 'class' => '.comments-area .authorlink' ),
					array( 'title' => 'Comment date', 'id' => 'typo_comment_date', 'default' => '', 'class' => '.comments-area .date a, .comments-area .date' ),
					
					array( 'title' => 'Footer', 'id' => 'typo_footer', 'default' => '', 'class' => '.footer' ),
					array( 'title' => 'Footer menu', 'id' => 'typo_footermenu', 'default' => '', 'class' => '#footer_menu a' ),
					array( 'title' => 'Footer menu hover', 'id' => 'typo_footermenu_hover', 'default' => '', 'class' => '#footer_menu a:hover, #footer_menu .current-menu-item a' ),
					
					array( 'title' => 'Footer widget title', 'id' => 'typo_footer_widget_title', 'default' => '', 'class' => '.footer-widget h2' ),
					array( 'title' => 'Footer widget', 'id' => 'typo_footer_widget', 'default' => '', 'class' => '.footer-widget' ),
					);
				return $args;
			
			}
		
		public function register_configuration( $wp_customize ) {
			
			$args = $this->typoSettings();

				$cfonts =  getFonts();

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
					
					$wp_customize->register_control_type( 'Skyre_Control_Color' );
					$wp_customize->add_setting('skyre['.$data['id'].'][color]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'skyre_sanitize_hexcolor', ));
					$wp_customize->add_control(new Skyre_Control_Color($wp_customize, 'skyre['.$data['id'].'][color]', array( 'label' => __('Font Color', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', )));
					
					$wp_customize->add_setting('skyre['.$data['id'].'][font-family]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'skyre_sanitize_fontfamily', ));
					$wp_customize->add_control('skyre['.$data['id'].'][font-family]', array( 'label' => __('Font Family', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', 'type' => 'select', 'choices' => $cfonts, ));
					
					$wp_customize->add_setting('skyre['.$data['id'].'][font-style]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'skyre_sanitize_fontstyle', ));
					$wp_customize->add_control('skyre['.$data['id'].'][font-style]', array( 'label' => __('Font Style', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', 'type' => 'select', 'choices' => skyre_get_font_styles(), ));
					
					$wp_customize->add_setting('skyre['.$data['id'].'][font-weight]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'skyre_sanitize_fontweight', ));
					$wp_customize->add_control('skyre['.$data['id'].'][font-weight]', array( 'label' => __('Font Weight', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', 'type' => 'select', 'choices' => skyre_get_font_weight(), ));
					
					$wp_customize->register_control_type( 'Skyre_Control_Responsive' );
					$wp_customize->add_setting('skyre['.$data['id'].'][font-size]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'sanitize_responsive_count', ));
					$wp_customize->add_control( new Skyre_Control_Responsive( $wp_customize, 'skyre['.$data['id'].'][font-size]', array( 'label' => __('Font size', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', 'units' => array('px'=>'px','%'=>'%',), )));
					
					$wp_customize->add_setting('skyre['.$data['id'].'][line-height]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'skyre_sanitize_textarea', ));
					$wp_customize->add_control('skyre['.$data['id'].'][line-height]', array( 'label' => __('Line Height', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', 'type' => 'text',  ));
					
					$wp_customize->add_setting('skyre['.$data['id'].'][letter-spacing]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'skyre_sanitize_textarea', ));
					$wp_customize->add_control('skyre['.$data['id'].'][letter-spacing]', array( 'label' => __('Letter Spacing', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', 'type' => 'text', ));
					
					$wp_customize->add_setting('skyre['.$data['id'].'][text-align]', array( 'default' => '', 'type'  => 'option', 'sanitize_callback' => 'skyre_sanitize_text_align', ));
					$wp_customize->add_control('skyre['.$data['id'].'][text-align]', array( 'label' => __('Text Align', 'skyre'), 'section' => 'skyre_'.$data['id'].'_section', 'type' => 'select', 'choices' => skyre_get_text_align(), ));
					
					
					
					
				}
			 
			 
			
			//addtypo($args,$wp_customize );
			
			}
	}
}
