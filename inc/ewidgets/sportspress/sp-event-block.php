<?php
/**
 * Post Grid widget for Elementor builder
 *
 * @link       https://skyresoft.com
 * @since      1.0.0
 *
 */
 
namespace ewidget\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;



if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // End if().

/**
 * Class EventBlock
 *
 * @package ThemeIsle\ElementorExtraWidgets
 */
class spEventBlock extends \Elementor\Widget_Base {

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'Event Block', 'skyre' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-post-list';
	}

	/**
	 * Widget name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'skyre-sp-event-block';
	}

	
	protected function get_event_block(){
	
	  $args = array('post_type' => 'sp_calendar', 'posts_per_page' => -1);
	  
		$catlist=[ 1 => __( 'All', 'skyre' ),];
		
		if( $categories = get_posts($args)){
			foreach ( $categories as $category ) {
				(int)$catlist[$category->ID] = $category->post_title;
			}
		}
		else{
			(int)$catlist['0'] = esc_html__('No event block found', 'skyre');
		}
	  return $catlist;
	  }
	  
	  /**
	 * Column name.
	 *
	 * @return string
	 */
	protected function get_columns(){ 
		$time_format = get_option( 'sportspress_event_block_time_format', 'combined' );
		$the_columns = array();
		$the_columns['date'] = __( 'Date', 'skyre' );
        $the_columns['event'] = __( 'Event', 'skyre' );

		if ( 'combined' === $time_format ) {

			$the_columns['time'] = __( 'Time/Results', 'skyre' );

		} else {

			if ( in_array( $time_format, array( 'time', 'separate' ) ) ) {
				$the_columns['time'] = __( 'Time', 'skyre' );
			}

			if ( in_array( $time_format, array( 'results', 'separate' ) ) ) {
				$the_columns['results'] = __( 'Results', 'skyre' );
			}
		}

        $the_columns['venue'] = __( 'Venue', 'skyre' );
		$the_columns['league'] = __( 'League', 'skyre' ); 
		$the_columns['day'] = __( 'Match Day', 'skyre' ); 
		
		return $the_columns ;
	}

	  /**
	 * Date.
	 *
	 * @return string
	 */
	protected function get_event_dates(){ 
	
		$dates = apply_filters( 'sportspress_dates', array(
			0 => __( 'All', 'skyre' ),
			'-day' => __( 'Yesterday', 'skyre' ),
			'day' => __( 'Today', 'skyre' ),
			'+day' => __( 'Tomorrow', 'skyre' ),
			'-w' => __( 'Last week', 'skyre' ),
			'w' => __( 'This week', 'skyre' ),
			'+w' => __( 'Next week', 'skyre' ),
			'range' => __( 'Date range:', 'skyre' ),
		));
		return $dates ;
	}

	
	



	/**
	 * Register dependent script.
	 *
	 * @return array
	 */
	
	protected function _register_controls() {
		
		$this->start_controls_section(
			'section_sp_event_block',
			[
				'label' => __( 'Event Block', 'skyre' ),
			]
		);

		
		$this->add_control(
			'widget_title', [
				'label' => __( 'Title', 'skyre' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => null,
				'label_block' => true,
			]
		);

		$this->add_control(
			'widget_style',
			[
				'label' => __( 'Style', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => 'None',
					'1' => 'Style 1',
				],
				'default' => '',
			]
		);
		
		$this->add_control(
			'title_size',
			[
				'label' => __( 'Title Tag', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h3',
			]
		);

		$this->add_control(
			'list_id', [
				'label' => __( 'Select Event/Calendar ', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->get_event_block(),
				'default' => 1,
			]
		);
		
		$this->add_control(
			'list_attr', [
				'label' => __( 'Show ', 'skyre' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => [
					'logo'  => __( 'Team Logo', 'skyre' ),
					'content' => __( 'List Content', 'skyre' ),
					'image' => __( 'List Image', 'skyre' ),
				],
				'default' => ['logo'],
			]
		);
		
		$this->add_control(
			'limit', [
				'label' => __( 'Number of Events to show', 'skyre' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'step' => 1,
				'default' => 10,
			]
		);

		$this->add_control(
			'widget_columncount', [
				'label' => __( 'Number of Columns', 'skyre' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'step' => 1,
				'default' => 4,
				'min' => 1,
				'max' => 12,
			]
		);

		$this->add_control(
			'status', [
				'label' => __( 'Status ', 'skyre' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'default' => __( 'Default', 'skyre' ),
					'any' => __( 'All', 'skyre' ),
					'publish' => __( 'Published', 'skyre' ),
					'future' => __( 'Scheduled', 'skyre' ),
				],
				'default' => 'default',
			]
		);
		$this->add_control(
			'date', [
				'label' => __( 'Date ', 'skyre' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'multiple' => false,
				'options' => $this->get_event_dates(),
				'default' => 0,
			]
		);

		

		$this->add_control(
			'date_from',
			[
				'label' => __( 'Date from', 'skyre' ),
				'type' => \Elementor\Controls_Manager::DATE_TIME,
				'picker_options' => ['enableTime'=>'false'],
				'condition' => [
					'date' => 'range',
				],
			]
		);

		$this->add_control(
			'date_to',
			[
				'label' => __( 'Date To', 'skyre' ),
				'type' => \Elementor\Controls_Manager::DATE_TIME,
				'picker_options' => ['enableTime'=>'false'],
				'condition' => [
					'date' => 'range',
				],
			]
		);

		$this->add_control(
			'date_past',
			[
				'label' => __( 'Past', 'skyre' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '7',
			]
		);
		$this->add_control(
			'date_future',
			[
				'label' => __( 'Next', 'skyre' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '7',
			]
		);

		$this->add_control(
			'date_relative',
			[
				'label' => __( 'Relative', 'skyre' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'skyre' ),
				'label_off' => __( 'Hide', 'skyre' ),
				'return_value' => '1',
				'default' => '',
			]
		);
		
		
		$this->add_control(
			'sort_order', [
				'label' => __( 'Sort Order', 'skyre' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'multiple' => false,
				'options' => [
					'ASC'  => __( 'Ascending', 'skyre' ),
					'DESC'  => __( 'Descending', 'skyre' ),
				],
				'default' => ['ASC'],
			]
		);
		
		
		
		$this->add_control(
			'show_link',
			[
				'label' => __( 'Display link to view all Events', 'skyre' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'skyre' ),
				'label_off' => __( 'Hide', 'skyre' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
		
		$this->add_control(
			'hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'column_id', [
				'label' => __( 'Select Column', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->get_columns(),
			]
		);
		
		$repeater->add_control(
			'column_color',
			[
				'label' => __( 'Color', 'skyre' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'widget_columns',
			[
				'label' => __( 'Event Fields', 'skyre' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
                    [ 'column_id' => __( 'league', 'skyre' ), ],
                    [ 'column_id' => __( 'event', 'skyre' ), ],
					[ 'column_id' => __( 'time', 'skyre' ), ],
					[ 'column_id' => __( 'date', 'skyre' ), ],
					[ 'column_id' => __( 'venue', 'skyre' ), ],
					 
				],
				'title_field' =>'{{{column_id}}}'/*'{{column_id}}'*/ //get_the_title('{{column_id}}') ,
			]
		);
		
		$this->end_controls_section();
		
		//========== List heading
		$this->start_controls_section(
			'sp_event_block_heading',
			[
				'label' => __( 'Heading', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'section_sp_event_block.widget_title!' => '',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'list_heading_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .sp-list-title',
				'default' => '',
			]
		);
		
		$this->add_control(
			'list_heading_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .sp-list-title' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'list_heading_align',
			[
				'label' => __( 'Text alignment', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => 'None',
					'left' => 'Left',
					'right' => 'Right',
					'center' => 'Center',
				],
				'default' => 'none',
				'selectors' => [
					'{{WRAPPER}} .sp-list-title' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'list_heading_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sp-list-title',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'list_heading_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-list-title',
			]
		);
		
		$this->add_control(
			'list_heading_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-list-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'list_heading_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-list-title',
			]
		);
		
		$this->add_control(
			'list_heading_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-list-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->add_control(
			'list_heading_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-list-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->end_controls_section();
		
		//========== List Content
		$this->start_controls_section(
			'sp_event_block_content',
			[
				'label' => __( 'Content', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'section_sp_event_block.list_attr' => 'content',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'list_content_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .event_block_meta p',
			]
		);
		
		$this->add_control(
			'list_content_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .event_block_meta p' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'list_content_align',
			[
				'label' => __( 'Text alignment', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => 'None',
					'left' => 'Left',
					'right' => 'Right',
					'center' => 'Center',
				],
				'default' => 'none',
				'selectors' => [
					'{{WRAPPER}} .event_block_meta p' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'list_content_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .event_block_meta p',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'list_content_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .event_block_meta p',
			]
		);
		
		$this->add_control(
			'list_content_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .event_block_meta p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'list_content_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .event_block_meta p',
			]
		);
		
		$this->add_control(
			'list_content_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .event_block_meta p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->add_control(
			'list_content_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .event_block_meta p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

        $this->end_controls_section();
		
		//========== List Image
		$this->start_controls_section(
			'sp_event_block_image',
			[
				'label' => __( 'Featured Image', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'section_sp_event_block.list_attr' => 'image',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'list_image_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .event_block_meta .post_image',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'list_image_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .event_block_meta .post_image',
			]
		);
		
		$this->add_control(
			'list_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .event_block_meta .post_image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'list_image_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .event_block_meta .post_image',
			]
		);
		
		$this->add_control(
			'list_image_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .event_block_meta .post_image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->add_control(
			'list_image_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .event_block_meta .post_image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

        $this->end_controls_section();
		
		
        //==========Group heading settings
		$this->start_controls_section(
			'sp_event_group_head',
			[
				'label' => __( 'Group Heading', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'group_heading_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .sp-event-group-name',
			]
		);
		
		$this->add_control(
			'group_heading_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .sp-event-group-name' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'group_heading_align',
			[
				'label' => __( 'Text alignment', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => 'None',
					'left' => 'Left',
					'right' => 'Right',
					'center' => 'Center',
				],
				'default' => 'none',
				'selectors' => [
					'{{WRAPPER}} .sp-event-group-name' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'group_heading_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sp-event-group-name',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'group_heading_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-event-group-name',
			]
		);
		
		
		$this->add_control(
			'group_heading_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-group-name' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'group_heading_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-event-group-name',
			]
		);
		
		$this->add_control(
			'group_heading_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-group-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'group_heading_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-group-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->end_controls_section();
		
		
		
		//========== columns settings
		$this->start_controls_section(
			'sp_event_block_column',
			[
				'label' => __( 'Columns', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'event_column_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sp-event-block-item',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'event_column_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-event-block-item',
			]
		);
		
		$this->add_control(
			'event_column_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-block-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'event_column_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-event-block-item',
			]
		);

		
		
		$this->add_control(
			'event_column_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-block-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'event_column_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-block-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->end_controls_section();

		//==========Event Name settings
		$this->start_controls_section(
			'sp_event_name',
			[
				'label' => __( 'Event Title', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'event_title_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .sp-event-title a, {{WRAPPER}} .sp-event-title',
			]
		);
		
		$this->add_control(
			'event_title_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .sp-event-title a, {{WRAPPER}} .sp-event-title' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'event_title_align',
			[
				'label' => __( 'Text alignment', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => 'None',
					'left' => 'Left',
					'right' => 'Right',
					'center' => 'Center',
				],
				'default'=>'none',
				'selectors' => [
					'{{WRAPPER}} .sp-event-title' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'event_title_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sp-event-title',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'event_title_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-event-title',
			]
		);
		
		
		$this->add_control(
			'event_title_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'event_title_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-event-title',
			]
		);
		
		$this->add_control(
			'event_title_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'event_title_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->end_controls_section();

		//==========Event Date settings
		$this->start_controls_section(
			'sp_event_date_',
			[
				'label' => __( 'Event Date', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'sp_event_date_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .sp-event-date a, {{WRAPPER}} .sp-event-date',
			]
		);
		
		$this->add_control(
			'sp_event_date_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .sp-event-date a, {{WRAPPER}} .sp-event-date' => 'color: {{VALUE}};',
					
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'sp_event_date_align',
			[
				'label' => __( 'Text alignment', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => 'None',
					'left' => 'Left',
					'right' => 'Right',
					'center' => 'Center',
				],
				'default' => 'none',
				'selectors' => [
					'{{WRAPPER}} .sp-event-date' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'sp_event_date_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sp-event-date',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'sp_event_date_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-event-date',
			]
		);
		
		
		$this->add_control(
			'sp_event_date_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-date' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'sp_event_date_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-event-date',
			]
		);
		
		$this->add_control(
			'sp_event_date_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'sp_event_date_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->end_controls_section();
		
		//==========Event time settings
		$this->start_controls_section(
			'sp_event_time',
			[
				'label' => __( 'Time', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'event_time_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .sp-event-results a, {{WRAPPER}} .sp-event-results.completed a',
			]
		);
		
		$this->add_control(
			'event_time_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .sp-event-results a' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'event_time_align',
			[
				'label' => __( 'Text alignment', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => 'None',
					'left' => 'Left',
					'right' => 'Right',
					'center' => 'Center',
				],
				'default' => 'none',
				'selectors' => [
					'{{WRAPPER}} .sp-event-results a' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'event_time_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sp-event-results a',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'event_time_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-event-results a',
			]
		);
		
		
		$this->add_control(
			'event_time_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-results a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'event_time_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-event-results a',
			]
		);
		
		$this->add_control(
			'event_time_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-results a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'event_time_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-results a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
        $this->end_controls_section();
        
        //==========Event Venue settings
		$this->start_controls_section(
			'sp_event_venue',
			[
				'label' => __( 'Venue', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'event_venue_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .sp-event-venue a, {{WRAPPER}} .sp-event-venue',
			]
		);
		
		$this->add_control(
			'event_venue_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .sp-event-venue a, {{WRAPPER}} .sp-event-venue' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'event_venue_align',
			[
				'label' => __( 'Text alignment', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => 'None',
					'left' => 'Left',
					'right' => 'Right',
					'center' => 'Center',
				],
				'default'=>'none',
				'selectors' => [
					'{{WRAPPER}} .sp-event-venue' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'event_venue_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sp-event-venue',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'event_venue_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-event-venue',
			]
		);
		
		
		$this->add_control(
			'event_venue_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-venue' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'event_venue_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-event-venue',
			]
		);
		
		$this->add_control(
			'event_venue_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-venue' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'event_venue_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-venue' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
        $this->end_controls_section();
        
        //==========Event League settings
		$this->start_controls_section(
			'sp_event_league',
			[
				'label' => __( 'League', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'event_league_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .sp-event-league a, {{WRAPPER}} .sp-event-league',
			]
		);
		
		$this->add_control(
			'event_league_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .sp-event-league a, {{WRAPPER}} .sp-event-league' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'event_league_align',
			[
				'label' => __( 'Text alignment', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => 'None',
					'left' => 'Left',
					'right' => 'Right',
					'center' => 'Center',
				],
				'default'=>'none',
				'selectors' => [
					'{{WRAPPER}} .sp-event-league' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'event_league_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sp-event-league',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'event_league_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-event-league',
			]
		);
		
		
		$this->add_control(
			'event_league_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-league' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'event_league_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-event-league',
			]
		);
		
		$this->add_control(
			'event_league_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-league' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'event_league_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-league' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
        $this->end_controls_section();
        
        //==========Event Match day settings
		$this->start_controls_section(
			'sp_event_match_day',
			[
				'label' => __( 'Match Day', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'event_match_day_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .sp-event-matchday',
			]
		);
		
		$this->add_control(
			'event_match_day_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .sp-event-matchday' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'event_match_day_align',
			[
				'label' => __( 'Text alignment', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => 'None',
					'left' => 'Left',
					'right' => 'Right',
					'center' => 'Center',
				],
				'default'=>'none',
				'selectors' => [
					'{{WRAPPER}} .sp-event-matchday' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'event_match_day_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sp-event-matchday',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'event_match_day_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-event-matchday',
			]
		);
		
		
		$this->add_control(
			'event_match_day_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-matchday' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'event_match_day_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-event-matchday',
			]
		);
		
		$this->add_control(
			'event_match_day_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-matchday' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'event_match_day_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-event-matchday' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->end_controls_section();
		

		//========== Event Logo
		$this->start_controls_section(
			'sp_event_logo',
			[
				'label' => __( 'Team Logos', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'section_sp_event_block.list_attr' => 'logo',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'logo_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .team-logo',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'logo_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .team-logo',
			]
		);
		
		$this->add_control(
			'logo_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .team-logo' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'logo_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .team-logo',
			]
		);
		
		$this->add_control(
			'logo_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .team-logo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'logo_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px','%' ],
				'selectors'  => [
					'{{WRAPPER}} .team-logo' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .team-logo' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();


		//==========view all button
		$this->start_controls_section(
			'sp_event_view_all',
			[
				'label' => __( 'View All Link', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'section_sp_event_block.show_link' => 'yes',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'view_all_button_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .sk-sp-view-all-link a',
			]
		);
		
		$this->add_control(
			'view_all_button_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .sk-sp-view-all-link a' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'view_all_button_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sk-sp-view-all-link',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'view_all_button_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-sp-view-all-link',
			]
		);
		
		$this->add_control(
			'view_all_button_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-sp-view-all-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->add_control(
			'thhr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'view_all_button_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-sp-view-all-link',
			]
		);
		
		$this->add_control(
			'view_all_button_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-sp-view-all-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->add_control(
			'view_all_button_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-sp-view-all-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->add_responsive_control(
			'view_all_button_width',
			[
				'label'     => __( 'Width', 'skyre' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				
				'range'     => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sk-sp-view-all-link'   => 'max-width: {{SIZE}}%',
				],
			]
		);

		
		
		
		
		
		
		
	}

	protected function render() {
		
		$settings = $this->get_settings_for_display();
		$html = '';
		$year = '';
		$i = 0;
		$columFields = null;
		$caption = null;
		$ws = array();
		//$settings['columns'] = array( 'number', 'position', 'team' );
		
		$id = empty($settings['list_id']) ? 0 : $settings['list_id'];
		$style = empty($settings['widget_style']) ? '' : 'event-block-style-'.$settings['list_id'];
		
		$title = empty($settings['list_title']) ? null : $settings['list_title'];
		$widget_title = empty($settings['widget_title']) ? null : $settings['widget_title'];
		$titlesize  = empty($settings['title_size']) ? 'h3' : $settings['title_size'];
		$number = empty($settings['limit']) ? '0' : $settings['limit'];
		$columns = empty($settings['widget_columns']) ? null : $settings['widget_columns'];
		$columncount = empty($settings['widget_columncount']) ? null : $settings['widget_columncount'];
		//$orderby = empty($settings['order_by']) ? 'default' : $settings['order_by'];
		$order = empty($settings['sort_order']) ? 'ASC' : $settings['sort_order'];
		$show_all_events_link = empty($settings['show_link']) ? false : $settings['show_link'];
		
		$status = empty($settings['status']) ? 'default' : $settings['status'];
		$date = empty($settings['date']) ? 'default' : $settings['date'];
		$date_from = empty($settings['date_from']) ? 'default' : $settings['date_from'];
		$date_to = empty($settings['date_to']) ? 'default' : $settings['date_to'];
		$date_past = empty($settings['date_past']) ? 'default' : $settings['date_past'];
		$date_future = empty($settings['date_future']) ? 'default' : $settings['date_future'];
		$date_relative = empty($settings['date_relative']) ? 'default' : $settings['date_relative'];
		$day = empty($settings['day']) ? 'default' : $settings['day'];

		//widge settings - ws
		$ws['attr'] = $settings['list_attr'];
		
		foreach($columns as $column){
			if(isset($column['column_id']) && $column['column_id'] !='') {
				$columFields[]=$column['column_id'];
			}
			}
		if ( $id > 0 ) {
		//print_r($settings['widget_title']);
		
		$post = get_post( $id );
		
		echo  '<div class="event-block-widget '.$style.'"> ';
			echo  '<div class="event_block_meta"> ';
			if($widget_title) { echo '<'.$titlesize.' class="sp-list-title">'.$widget_title.'</'.$titlesize.'>'; }
			if ( in_array( 'content', $settings['list_attr'] )) { echo '<p>'. $post->post_content.'</p>'; }
			if ( in_array( 'image', $settings['list_attr'] )) { echo '<div class="post_image">'.get_the_post_thumbnail( $post->ID ).'</div>'; }
			echo  '</div> ';
			sp_get_template( 'event-blocks.php', array( 'id' => $id, 'ws'=>$ws, 'title' => $caption, 'status' => $status, 'date' => $date, 'date_from' => $date_from, 'date_to' => $date_to, 'date_past' => $date_past, 'date_future' => $date_future, 'date_relative' => $date_relative, 'day' => $day, 'number' => $number, 'columncount' =>$columncount, 'columns' => $columFields, 'order' => $order, 'show_all_events_link' => $show_all_events_link ) );
			echo  '</div> ';
		}
		else { echo 'Plase select an Event Block';}
		
	}

	


}

