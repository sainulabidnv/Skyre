<?php
/**
 * Status widget for Elementor builder
 *
 * @link       https://skyresoft.com
 * @since      1.0.0
 *
 */
namespace ewidget\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class spCountDown extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'sk-status';
	}
	

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Count Down', 'skyre' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-date';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_script_depends() {
		return [ 'sk-status' ];
	}
	 
	public function get_categories() {
		return [ 'general' ];
    }
    
     /**
	 * Mathc List
	 *
	 * @return string
	 */

	protected function get_event_list(){
	
        $args = array(
            'post_type' => 'sp_event', 
            'numberposts' => -1,
            'posts_per_page' => -1,
            'orderby' => 'date', 
            'order'  => 'ASC',
            'post_status' => 'future'
            
        );
          $catlist=[ 1 => __( 'Custom', 'skyre' ),];
          $catlist['upcoming'] = __( 'Upcoming', 'skyre' );
          
          if( $categories = get_posts($args)){
              foreach ( $categories as $category ) {
                  (int)$catlist[$category->ID] = $category->post_title;
              }
          }
          else{
              (int)$catlist['0'] = esc_html__('No event list found', 'skyre');
          }
        return $catlist;
          
      }

     /**
	 * Upcoming Mathc List
	 *
	 * @return string
	 */

	protected function get_upcoming_event(){
	
         $args = array(
            'post_type' => 'sp_event', 
            'orderby' => 'date', 
            'order'  => 'ASC',
            'post_status' => 'future',
            'numberposts' => 1,
        );
    
        $event = get_posts($args);
        return $event[0]->ID;
     
      }
    
     /**
	 * Column name.
	 *
	 * @return string
	 */
	protected function get_columns(){ 
		$time_format = get_option( 'sportspress_event_block_time_format', 'combined' );
		$the_columns = array();
		$the_columns['Title'] = __( 'Title', 'skyre' );
		$the_columns['Counter'] = __( 'Counter', 'skyre' ); 
        $the_columns['Status'] = __( 'Status', 'skyre' ); 
        $the_columns['Content'] = __( 'Content', 'skyre' ); 
        $the_columns['Venue'] = __( 'Venue', 'skyre' );
        $the_columns['League'] = __( 'League', 'skyre' );
        $the_columns['Date'] = __( 'Date', 'skyre' );
		
		return $the_columns ;
	}
    

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.1.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		
		$css_scheme = array(
			'title' 			=> '.sk_event_title ',
			'counter' 				=> '.sk-time',
			'stage' 			=> '.progress span',
			'description' 		=> '.sk-event-desc',
            'general' 			=> '.sk-countdown',
            'date' 		=> '.sk-event-date',
            'venue' 		=> '.sk-event-venue ',
            'league' 		=> '.sk-event-league',
            'logo'          => '.sp-count-down .team-logo'
			
        );
        
        $this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'skyre' ),
			]
        );
        
        $this->add_control(
			'event_id', [
				'label' => __( 'Select Event/Match ', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->get_event_list(),
				'default' => 'upcoming',
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'skyre' ),
				'type' => Controls_Manager::TEXT,
                'default' => __( 'Event Start in', 'skyre' ),
                'condition' => [
                    'event_id' => '1',
                    
				],
			]
        );
        
        $this->add_control(
			'date',
			[
				'label' => __( 'End Date', 'skyre' ),
				'type' => Controls_Manager::DATE_TIME,
                'default' => date('Y-m-d', strtotime("+20 days")),
                'condition' => [
					'event_id' => '1',
				],
			]
        );
        
		$this->add_control(
			'header_size',
			[
				'label' => __( 'Title Tag', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'p' => 'P',
					'div' => 'Div'
				],
				'default' => 'h4',
			]
        );

        

        $this->add_control(
			'show_logos',
			array(
				'label'        => esc_html__( 'Show Logos', 'skyre' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'skyre' ),
				'label_off'    => esc_html__( 'No', 'skyre' ),
				'return_value' => 'true',
				'default'      => 'true',
				'condition' => [
					'event_id!' => '1',
				],
			)
		);
		
		$this->add_control(
			'show_team_link',
			array(
				'label'        => esc_html__( 'Link to Team/Logo', 'skyre' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'skyre' ),
				'label_off'    => esc_html__( 'No', 'skyre' ),
				'return_value' => 'true',
				'default'      => 'true',
				'condition' => [
					'event_id!' => '1',
					'show_logos' => 'true',
				],
			)
		);

		$this->add_control(
			'show_event_link',
			array(
				'label'        => esc_html__( 'Link to Event', 'skyre' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'skyre' ),
				'label_off'    => esc_html__( 'No', 'skyre' ),
				'return_value' => 'true',
				'default'      => 'true',
				'condition' => [
					'event_id!' => '1',
				],
			)
		);
		
		$this->add_control(
			'show_venue_link',
			array(
				'label'        => esc_html__( 'Link to Venue', 'skyre' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'skyre' ),
				'label_off'    => esc_html__( 'No', 'skyre' ),
				'return_value' => 'true',
				'default'      => 'true',
				'condition' => [
					'event_id!' => '1',
				],
			)
        );
        
        
        
		
		$this->end_controls_section();
        
        
        $this->start_controls_section(
			'section_progress',
			[
				'label' => __( 'Progress bar', 'skyre' ),
			]
        );
		
		$this->add_control(
			'slider_progressbar',
			array(
				'label'        => esc_html__( 'Display Progress bar?', 'sk-elements' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'sk-elements' ),
				'label_off'    => esc_html__( 'No', 'sk-elements' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);
		
		$this->add_control(
			'status_stage1_title',
			[
				'label' => __( 'Stage 1 Title', 'skyre' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Stage 1', 'skyre' ),
				'condition' => array(
					'slider_progressbar' => 'true',
				),
			]
		);
		
		$this->add_control(
			'status_stage1_position',
			[
				'label' => __( 'Stage 1 Position', 'skyre' ),
				'type' => Controls_Manager::NUMBER,
				'default' => __( '20', 'skyre' ),
				'condition' => array(
					'slider_progressbar' => 'true',
				),
			]
		);
		
		$this->add_control(
			'status_stage2_title',
			[
				'label' => __( 'Stage 2 Title', 'skyre' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Stage 2', 'skyre' ),
				'condition' => array(
					'slider_progressbar' => 'true',
				),
			]
		);
		
		$this->add_control(
			'status_stage2_position',
			[
				'label' => __( 'Stage 2 Position', 'skyre' ),
				'type' => Controls_Manager::NUMBER,
				'default' => __( '50', 'skyre' ),
				'condition' => array(
					'slider_progressbar' => 'true',
				),
			]
		);
		
		$this->add_control(
			'status_stage3_title',
			[
				'label' => __( 'Stage 3 Title', 'skyre' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Stage 3', 'skyre' ),
				'condition' => array(
					'slider_progressbar' => 'true',
				),
			]
		);
		
		$this->add_control(
			'status_stage3_position',
			[
				'label' => __( 'Stage 3 Position', 'skyre' ),
				'type' => Controls_Manager::NUMBER,
				'default' => __( '85', 'skyre' ),
				'condition' => array(
					'slider_progressbar' => 'true',
				),
			]
		);
				
		$this->add_control(
			'statusbar',
			[
				'label' => __( 'Status Bar Length', 'skyre' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 80,
				],
				'condition' => array(
					'slider_progressbar' => 'true',
				),
				
			]
		);

		$this->add_control(
			'description',
			[
				'label' => __( 'Description', 'skyre' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Dummy text', 'skyre' ),
			]
		);

        $this->end_controls_section();
        
        $repeater = new \Elementor\Repeater();

        $this->start_controls_section(
			'section_columns',
			[
				'label' => __( 'Fields', 'skyre' ),
			]
        );

        $repeater->add_control(
			'column_id', [
				'label' => __( 'Select Fields', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->get_columns(),
			]
		);
		
		$this->add_control(
			'widget_columns',
			[
				'label' => __( 'Event Fields', 'skyre' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
                    [ 'column_id' => __( 'Title', 'skyre' ), ],
                    [ 'column_id' => __( 'Counter', 'skyre' ), ],
					[ 'column_id' => __( 'Status', 'skyre' ), ],
					[ 'column_id' => __( 'Content', 'skyre' ), ],
					 
				],
				'title_field' =>'{{{column_id}}}',
			]
        );
        
        $this->end_controls_section();

		/**
		 * General Style Section
		 */
		$this->start_controls_section(
			'status_general_style',
			array(
				'label'      => esc_html__( 'General', 'sk-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'status_general_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['general'],
			)
		);
		
		$this->add_responsive_control(
			'status_general_width',
			array(
				'label' => esc_html__( 'Width(%)', 'sk-elements' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => array(
					'%', 'px',
				),
				'range' => array(
					'%' => array(
						'min' => 10,
						'max' => 100,
					),
					'px' => array(
						'min' => 200,
						'max' => 1000,
					),
				),
				'default' => array(
					'unit' => '%',
					'size' => 100,
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['general']  => 'max-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		

		$this->add_responsive_control(
			'status_general_padding',
			array(
				'label'      => __( 'Padding', 'sk-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['general'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'status_general_margin',
			array(
				'label'      => __( 'Margin', 'sk-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['general'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'status_general_border',
				'label'       => esc_html__( 'Border', 'sk-elements' ),
				'placeholder' => '1px',
				'default'     => '0px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['general'] ,
			)
		);

		$this->add_control(
			'status_general_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'sk-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['general']  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'status_general_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['general'] ,
			)
		);

		$this->end_controls_section();
		
		/**
		 * Title Style Section
		 */
		$this->start_controls_section(
			'status_title_style',
			array(
				'label'      => esc_html__( 'Title', 'sk-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'status_title_color',
			array(
				'label'  => esc_html__( 'Color', 'sk-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'].'a, {{WRAPPER}} ' . $css_scheme['title'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'status_title_hover_color',
			array(
				'label'  => esc_html__( 'Hover Color', 'sk-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'].'a:hover' => 'color: {{VALUE}}',
				),
				'condition' => [
					'section_content.show_event_link' => 'true',
				],
				
			)
		);
		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'status_title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['title'].'a, {{WRAPPER}} ' . $css_scheme['title'],
			)
        );
        
        $this->add_responsive_control(
			'status_title_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'sk-elements' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'sk-elements' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'sk-elements' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'sk-elements' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'text-align: {{VALUE}};',
				),
			)
        );

		$this->add_responsive_control(
			'status_title_padding',
			array(
				'label'      => __( 'Padding', 'sk-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'status_title_margin',
			array(
				'label'      => __( 'Margin', 'sk-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'status_title_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} ' . $css_scheme['title'],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'status_title_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['title'],
			]
		);
		
		
		$this->add_control(
			'status_title_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['title']=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'status_title_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['title'],
			]
		);
        

		$this->end_controls_section();

		/**
		 * Date Style Section
		 */
		
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Counter', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		

		$this->add_control(
			'status_date_color',
			array(
				'label'  => esc_html__( 'Date Color', 'sk-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['counter'] => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['counter'].' span' => 'color: {{VALUE}}',
				),
			)
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'date_typography',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}}' . $css_scheme['counter'],
				
			)
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'date_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['counter'],
			)
		);
		
		$this->add_responsive_control(
			'status_date_padding',
			array(
				'label'      => __( 'Padding', 'sk-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['counter'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'status_date_margin',
			array(
				'label'      => __( 'Margin', 'sk-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['counter'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		
		
		$this->add_control(
			'date_border',
			[
				'label' => __( 'Border radius', 'skyre' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 3,
				],
				'selectors' => [
					'{{WRAPPER}}' . $css_scheme['counter'] => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		/**
		 * Stage Style Section
		 */
		$this->start_controls_section(
			'status_stage_style',
			array(
				'label'      => esc_html__( 'Stages', 'sk-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'status_stage_color',
			array(
				'label'  => esc_html__( 'Color', 'sk-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['stage'] => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['stage'].':after' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'status_stage_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['stage'],
			)
		);

		$this->add_responsive_control(
			'status_stage_padding',
			array(
				'label'      => __( 'Padding', 'sk-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['stage'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'status_stage_margin',
			array(
				'label'      => __( 'Margin', 'sk-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['stage'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'status_stage_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'sk-elements' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'stage' => esc_html__( 'Left', 'sk-elements' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'stage' => esc_html__( 'Center', 'sk-elements' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'stage' => esc_html__( 'Right', 'sk-elements' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['stage'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
		
		/**
		 * Status Bar Style Section
		 */
		$this->start_controls_section(
			'status_bar_style',
			array(
				'label'      => esc_html__( 'Progress Bar', 'sk-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'status_bar_color',
			array(
				'label'  => esc_html__( 'Color', 'sk-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .progress-bar' => 'background-color: {{VALUE}}',
				),
			)
		);
		
		$this->add_control(
			'status_bar_background_color',
			array(
				'label'  => esc_html__( 'Background Color', 'sk-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .progress' => 'background-color: {{VALUE}}',
				),
			)
		);
		

		$this->end_controls_section();
		
		/**
		 * Description Style Section
		 */

		$this->start_controls_section(
			'status_description_style',
			array(
				'label'      => esc_html__( 'Description', 'sk-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'status_description_color',
			array(
				'label'  => esc_html__( 'Color', 'sk-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['description'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'status_description_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['description'],
			)
		);

		$this->add_responsive_control(
			'status_description_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'sk-elements' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'description' => esc_html__( 'Left', 'sk-elements' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'description' => esc_html__( 'Center', 'sk-elements' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'description' => esc_html__( 'Right', 'sk-elements' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['description'] => 'text-align: {{VALUE}};',
				),
			)
        );

		$this->add_responsive_control(
			'status_description_padding',
			array(
				'label'      => __( 'Padding', 'sk-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['description'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'status_description_margin',
			array(
				'label'      => __( 'Margin', 'sk-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['description'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'status_description_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} '.$css_scheme['description'],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'status_description_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} '.$css_scheme['description'],
			]
		);
		
		
		$this->add_control(
			'status_description_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} '.$css_scheme['description'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'status_description_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} '.$css_scheme['description'],
			]
        );
        
        $this->end_controls_section();
        
        /**
		 * Description Style Section
		 */
		$this->start_controls_section(
			'status_date_time_style',
			array(
				'label'      => esc_html__( 'Date', 'sk-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'status_date_time_color',
			array(
				'label'  => esc_html__( 'Color', 'sk-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['date'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'status_date_time_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['date'],
			)
		);

		$this->add_responsive_control(
			'status_date_time_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'sk-elements' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'description' => esc_html__( 'Left', 'sk-elements' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'description' => esc_html__( 'Center', 'sk-elements' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'description' => esc_html__( 'Right', 'sk-elements' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['date'] => 'text-align: {{VALUE}};',
				),
			)
        );

		$this->add_responsive_control(
			'status_date_time_padding',
			array(
				'label'      => __( 'Padding', 'sk-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['date'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'status_date_time_margin',
			array(
				'label'      => __( 'Margin', 'sk-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['date'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'status_date_time_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} '.$css_scheme['date'],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'status_date_time_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} '.$css_scheme['date'],
			]
		);
		
		
		$this->add_control(
			'status_date_time_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} '.$css_scheme['date'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'status_date_time_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} '.$css_scheme['date'],
			]
		);
        
        $this->end_controls_section();


        /**
		 * Venue Style Section
		 */
		$this->start_controls_section(
			'status_venue_style',
			array(
				'label'      => esc_html__( 'Venue', 'sk-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'status_venue_color',
			array(
				'label'  => esc_html__( 'Color', 'sk-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['venue'].'a, {{WRAPPER}} ' . $css_scheme['venue'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'status_venue_hover_color',
			array(
				'label'  => esc_html__( 'Hover Color', 'sk-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['venue'].'a:hover' => 'color: {{VALUE}}',
				),
				'condition' => [
					'section_content.show_venue_link' => 'true',
				],
				
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'status_venue_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['venue'].'a, {{WRAPPER}} ' . $css_scheme['venue'],
			)
		);

		$this->add_responsive_control(
			'status_venue_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'sk-elements' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'description' => esc_html__( 'Left', 'sk-elements' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'description' => esc_html__( 'Center', 'sk-elements' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'description' => esc_html__( 'Right', 'sk-elements' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['venue'] => 'text-align: {{VALUE}};',
				),
			)
        );

		$this->add_responsive_control(
			'status_venue_padding',
			array(
				'label'      => __( 'Padding', 'sk-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['venue'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'status_venue_margin',
			array(
				'label'      => __( 'Margin', 'sk-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['venue'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'status_venue_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} '.$css_scheme['venue'],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'status_venue_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} '.$css_scheme['venue'],
			]
		);
		
		
		$this->add_control(
			'status_venue_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} '.$css_scheme['venue'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'status_venue_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} '.$css_scheme['venue'],
			]
        );
        
        $this->end_controls_section();


        /**
		 * League Style Section
		 */
		$this->start_controls_section(
			'status_league_style',
			array(
				'label'      => esc_html__( 'League', 'sk-elements' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'status_league_color',
			array(
				'label'  => esc_html__( 'Color', 'sk-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['league'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'status_league_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['league'],
			)
		);

		$this->add_responsive_control(
			'status_league_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'sk-elements' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'description' => esc_html__( 'Left', 'sk-elements' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'description' => esc_html__( 'Center', 'sk-elements' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'description' => esc_html__( 'Right', 'sk-elements' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['league'] => 'text-align: {{VALUE}};',
				),
			)
        );

		$this->add_responsive_control(
			'status_league_padding',
			array(
				'label'      => __( 'Padding', 'sk-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['league'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'status_league_margin',
			array(
				'label'      => __( 'Margin', 'sk-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['league'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'status_league_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} '.$css_scheme['league'],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'status_league_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} '.$css_scheme['league'],
			]
		);
		
		
		$this->add_control(
			'status_league_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} '.$css_scheme['league'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'status_league_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} '.$css_scheme['league'],
			]
        );
        

        $this->end_controls_section();

        //========== Event Logo
		$this->start_controls_section(
			'sp_status_logo',
			[
				'label' => __( 'Team Logos', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'logo_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} '.$css_scheme['logo'],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'logo_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} '.$css_scheme['logo'],
			]
		);
		
		$this->add_control(
			'logo_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} '.$css_scheme['logo'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'logo_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} '.$css_scheme['logo'],
			]
		);
		
		$this->add_control(
			'logo_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} '.$css_scheme['logo'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'logo_size',
			[
				'label' => __( 'Size', 'skyre' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} '.$css_scheme['logo'] => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();

        
        

	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.1.0
	 *
	 * @access protected
	 */
	protected function render() {

        $settings = $this->get_settings_for_display();
        $id = empty($settings['event_id']) ? 0 : $settings['event_id'];
        $logos = '';
        $show_logos = empty($settings['show_logos']) ? false : $settings['show_logos'];
        $columns = empty($settings['widget_columns']) ? null : $settings['widget_columns'];
		$link_teams = empty($settings['show_team_link']) ? null : $settings['show_team_link'];
		$link_venue = empty($settings['show_venue_link']) ? null : $settings['show_venue_link'];
		$link_event = empty($settings['show_event_link']) ? null : $settings['show_event_link'];
		
		
        if($id == 'upcoming')  { $id = $this->get_upcoming_event();}
        $html ='';

        
        
        if($id == 1){
            $counter = empty($settings['date']) ? 0 : date('Y-m-d', strtotime($settings['date']));
            $eventtitle = empty($settings['title']) ? null : $settings['title'];

        }else {
            $post = get_post( $id );
            
			$counter = get_the_time( 'Y-m-d', $post );
			if ( $link_event ) {
            	$eventtitle = '<a href="' . get_post_permalink( $post->ID, false, true ) . '">' . $post->post_title . '</a>';
			}else {
				$eventtitle =  $post->post_title;
			}
            if ( $show_logos ) {
				$teams = array_unique( (array) get_post_meta( $post->ID, 'sp_team' ) );
                $i = 0;
                if ( is_array( $teams ) ) {
					foreach ( $teams as $team ) {
						$i++;
						if ( has_post_thumbnail ( $team ) ) {
							if ( $link_teams ) {
								$logos .= '<a class="team-logo logo-' . ( $i % 2 ? 'odd' : 'even' ) . '" href="' . get_post_permalink( $team ) . '" title="' . get_the_title( $team ) . '">' . get_the_post_thumbnail( $team, 'sportspress-fit-icon' ) . '</a>';
							} else {
								$logos .= get_the_post_thumbnail( $team, 'sportspress-fit-icon', array( 'class' => 'team-logo logo-' . ( $i % 2 ? 'odd' : 'even' ) ) );
							}
						}
					}
				}
            }
            
        }
        //print_r($columns);
        foreach($columns as $column){
            
            if($column['column_id'] == 'Title' ) { 
                $html .= '<div class="sp-count-down sp-event-title-wrap">';
                $html .= $logos;
                $html .= '<'.$settings['header_size'].' class="sk_event_title" >'.$eventtitle.'</'.$settings['header_size'].'>';
                $html .= '<div class="clearfix"></div> </div>';
                continue;
            }
            if($column['column_id'] == 'Counter' ) { 
                $html .= '<div class="countdown my-4">';
                $html .= '<div class="row" data-date="'.$counter.'"></div>';
                $html .= '</div>';
                continue;
            }
            if($column['column_id'] == 'Status' && $settings['slider_progressbar'] == 'true' ) { 
                
                $html .= '<div class="sk-progress"> <div class="progress">';
                $html .= '<div class="progress-bar progress-bar-striped" role="progressbar" style="width:'. $settings['statusbar']['size'].'%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>';
                if($settings['status_stage1_title']) { $html .= '<span class="level-1" style="left:'. $settings['status_stage1_position'].'%">'.$settings['status_stage1_title'].'</span>'; }
                if($settings['status_stage2_title']) { $html .= '<span class="level-2" style="left:'. $settings['status_stage2_position'].'%">'.$settings['status_stage2_title'].'</span>'; }
                if($settings['status_stage3_title']) { $html .= '<span class="level-3" style="left:'. $settings['status_stage3_position'].'%">'.$settings['status_stage3_title'].'</span>'; }
                $html .= '</div> </div>';
                continue;
            }
            if($column['column_id'] == 'Content' ) { 
                $html .= '<div class="sk-event-desc pt-2 ">';
                $html .= $settings['description'];
                $html .= '</div>';
                continue;
            }
            if($column['column_id'] == 'Venue' && $id != 1  ) { 
                $html .= '<div class="sk-event-venue pt-2 ">';
				$venues = get_the_terms( $post->ID, 'sp_venue' );
				if ( $venues ){
                    $venue_names = array();
                    foreach ( $venues as $venue ) {
						if ( $link_venue ) {
							$venue_names[] = '<a href="'.get_term_link( $venue ).'">'.$venue->name.'<a>';
						}else {
							$venue_names[] = $venue->name;
						}
                    }
                    $html .= implode( '/', $venue_names );
				 }
                
                $html .= '</div>';
                continue;
            }
            if($column['column_id'] == 'League' && $id != 1 ) { 
                $html .= '<div class="sk-event-league pt-2 ">';
                $leagues = get_the_terms( $post->ID, 'sp_league' );
                if ( $leagues ):
                    foreach( $leagues as $league ):
                        $term = get_term( $league->term_id, 'sp_league' );
                        $html .= $term->name;
                    endforeach;
                endif;

                $html .= '</div>';
                continue;
            }
            if($column['column_id'] == 'Date' && $id != 1 ) { 
                $html .= '<div class="sk-event-date pt-2 ">';
                $html .= get_the_time( get_option( 'date_format' ), $post );
                $html .= '</div>';
                continue;
            }
        }

		?>
		<!--sk-countdown--> 
        <div class="sk-countdown text-center ">
            <?php echo $html; ?>
        </div>
        <!--End sk-countdown-->
		<?php
	}

}
