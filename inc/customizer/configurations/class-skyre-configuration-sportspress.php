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
 
if ( ! class_exists( 'Skyre_Configuration_Sportspress' ) ) {

	/**
	 * Customizer configuration Initial setup
	 */
	class Skyre_Configuration_Sportspress  {

		/**
		 * Constructor
		 */
		public function __construct() {
			//$this->register_configuration( $wp_customize);
		}
		
		public function register_configuration( $wp_customize ) {
			
			//post panel
			$wp_customize->add_panel('skyre_sportspress_panel', array(
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __('Sportspress Options', 'skyre'),
			'priority' => 10 // Mixed with top-level-section hierarchy.
		));
			
			
		$wp_customize->add_section('skyre_sportspress_layout', array(
            'title' => __('Sportspress settings', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_sportspress_panel'
        ));
			
		
            $wp_customize->add_setting('skyre_page[settings_links]', array(
              'sanitize_callback' => 'esc_html'
			));
			$doclink = new Skyre_render_html(
				$wp_customize,
					'skyre_page[settings_links]', array(
					'section' => 'skyre_sportspress_layout',
					'type' => 'skyre-render-html'
					));
					$doclink->content = '<a href="'.admin_url('admin.php?page=sportspress&tab=general').'"> '.__('Sportspress Settings','skyre').'</a>';
            $wp_customize->add_control($doclink);
		
        $wp_customize->add_section('skyre_sportspress_heading', array(
            'title' => __('Sportspress Title', 'skyre'),
            'priority' => 31,
            'panel' => 'skyre_sportspress_panel'
        ));    
			
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_page[sp_title_bg_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_page[sp_title_bg_color]',
				array(
					'label' => __( 'Title background', 'skyre' ),
					'section' => 'skyre_sportspress_heading',
					
				)
			) );
			
			$wp_customize->add_setting('skyre_page[sp_title_bg_image]', array(
                'default' => '',
				'type'  => 'option', 
				'sanitize_callback' => 'absint'
            ));
            $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'skyre_page[sp_title_bg_image]', array(
                'label' => __('Background Image', 'skyre'),
                'section' => 'skyre_sportspress_heading',
				'mime_type' => 'image',
                'settings' => 'skyre_page[sp_title_bg_image]',
            )));
			
			$wp_customize->add_setting('skyre_page[sp_title_bg_size]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_size',
            ));
			$wp_customize->add_control('skyre_page[sp_title_bg_size]', array(
                'label' => __('Background Size', 'skyre'),
                'section' => 'skyre_sportspress_heading',
                'type' => 'select',
				'default' => '',
				'choices' => array(
					'' => __( '--Select--', 'skyre' ),
					'auto' => __( 'Auto', 'skyre' ),
					'cover' => __( 'Cover', 'skyre' ),
					'contain' => __( 'Contain', 'skyre' ),
					'100% 100%' => __( 'Full fit', 'skyre' ), ),
	  
            ));
			
			
			$wp_customize->add_setting('skyre_page[sp_title_bg_repeat]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_repeat',
            ));
			$wp_customize->add_control('skyre_page[sp_title_bg_repeat]', array(
                'label' => __('Background Repeat', 'skyre'),
                'section' => 'skyre_sportspress_heading',
                'type' => 'select',
				'default' => 'repeat',
				'choices' => array(
					'' => __( '--Select--', 'skyre' ),
					'repeat' => __( 'Repeat', 'skyre' ),
					'repeat-x' => __( 'Repeat X', 'skyre' ),
					'repeat-y' => __( 'Repeat Y', 'skyre' ),
					'no-repeat' => __( 'No Repat', 'skyre' ), ),
	  
            ));
			
			$wp_customize->add_setting('skyre_page[sp_title_bg_position]', array(
                'default' => '',
                'type'  => 'option',
				'sanitize_callback' => 'skyre_sanitize_bg_position',
            ));
			$wp_customize->add_control('skyre_page[sp_title_bg_position]', array(
                'label' => __('Background Positions', 'skyre'),
                'section' => 'skyre_sportspress_heading',
                'type' => 'select',
				'default' => 'repeat',
				'choices' => get_background_positions()
	  
            ));
			
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_page[sp_title_padding]',
				array(
					
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_page[sp_title_padding]',
				array(
					'label' 	=> __( 'Title padding', 'skyre' ),
					'section' 	=> 'skyre_sportspress_heading',
					'type'    	=> 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_page[sp_title_margin]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_page[sp_title_margin]',
				array(
					'label' 	=> __( 'Title margin', 'skyre' ),
					'section' 	=> 'skyre_sportspress_heading',
					'type'    	=> 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Dimension' );
			$wp_customize->add_setting( 'skyre_page[sp_title_border_height]',
				array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_responsive_dimension',
				)
			);
			$wp_customize->add_control( new Skyre_Control_Dimension( $wp_customize, 'skyre_page[sp_title_border_height]',
				array(
					'label' 	=> __( 'Title Border', 'skyre' ),
					'section' 	=> 'skyre_sportspress_heading',
					'type'    	=> 'skyre-dimension'
					
				)
			) );
			
			$wp_customize->register_control_type( 'Skyre_Control_Color' );
			$wp_customize->add_setting( 'skyre_page[sp_title_border_color]',
				array(
					'default' => '',
					'type'  => 'option',
					/*'transport'   => 'postMessage', on chnage not working */
					'sanitize_callback' => 'sanitize_alpha_color'
				)
			);
			$wp_customize->add_control( new Skyre_Control_Color( $wp_customize, 'skyre_page[sp_title_border_color]',
				array(
					'label' => __( 'Border Color', 'skyre' ),
					'section' => 'skyre_sportspress_heading',
					
				)
			) );

			

			$wp_customize->add_section('skyre_sportspress_player', array(
				'title' => __('Player Featured Perfomance', 'skyre'),
				'priority' => 31,
				'panel' => 'skyre_sportspress_panel'
			)); 
				$wp_customize->add_setting( 'skyre[sp_player_field_title1]', array(
					'default' => 'Goals',
					'type' => 'option',
					'sanitize_callback' => 'sanitize_text_field',
				) );
				
				$wp_customize->add_control( 'skyre[sp_player_field_title1]', array(
					'section' => 'skyre_sportspress_player',
					'label' => __( 'Field 1 title', 'skyre' ),
					'type'  => 'text',
				) );

				$wp_customize->add_setting( 'skyre[sp_player_field1]', array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_text_field',
				) );
				
				$wp_customize->add_control( 'skyre[sp_player_field1]', array(
					'section' => 'skyre_sportspress_player',
					'label' => __( 'Field 1 variable', 'skyre' ),
					'description' => __( 'Write performance variable (Configure->player->perfomance). Eg:- goals ', 'skyre' ),
					'type'  => 'text',
				) );

				$wp_customize->add_setting( 'skyre[sp_player_field_title2]', array(
					'default' => 'Assists',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_text_field',
				) );
				
				$wp_customize->add_control( 'skyre[sp_player_field_title2]', array(
					'section' => 'skyre_sportspress_player',
					'label' => __( 'Field 2 title', 'skyre' ),
					'type'  => 'text',
				) );

				$wp_customize->add_setting( 'skyre[sp_player_field2]', array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_text_field',
				) );
				
				$wp_customize->add_control( 'skyre[sp_player_field2]', array(
					'section' => 'skyre_sportspress_player',
					'label' => __( 'Field 2 variable', 'skyre' ),
					'type'  => 'text',
				) );

				$wp_customize->add_setting( 'skyre[sp_player_field_title3]', array(
					'default' => 'Win Ratio',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_text_field',
				) );
				
				$wp_customize->add_control( 'skyre[sp_player_field_title3]', array(
					'section' => 'skyre_sportspress_player',
					'label' => __( 'Field 3 title', 'skyre' ),
					'type'  => 'text',
				) );

				$wp_customize->add_setting( 'skyre[sp_player_field3]', array(
					'default' => '',
					'type'  => 'option',
					'sanitize_callback' => 'sanitize_text_field',
				) );
				
				$wp_customize->add_control( 'skyre[sp_player_field3]', array(
					'section' => 'skyre_sportspress_player',
					'label' => __( 'Field 3 variable', 'skyre' ),
					'type'  => 'text',
				) );
			

				
		
		
		}
	}
}



