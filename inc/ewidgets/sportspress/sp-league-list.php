<?php
/**
 * League List widget for Elementor builder
 *
 * @link       https://skyretheme.com
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
 * Class LeagueList
 *
 * @package Skyre\ElementorExtraWidgets
 */
class spLeagueList extends \Elementor\Widget_Base {

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'League Table', 'skyre' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'fa fa-table';
	}

	/**
	 * Widget name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'skyre-sp-league';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'skyre' ];
	}

	  /**
	 * League List
	 *
	 * @return string
	 */

	protected function get_league_list(){
	
      $args = array('post_type' => 'sp_table', 'posts_per_page' => -1);

     
		$catlist=[ 1 => __( 'All', 'skyre' ),];
		
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
	 * Column name.
	 *
	 * @return string
	 */
	protected function get_columns(){ 
        $columns = [ 'Club' => __( 'name', 'skyre' ),];
        $columns = [ 'Pos' => __( 'pos', 'skyre' ),];
        $args = array(
            'post_type' => 'sp_column',
            'numberposts' => -1,
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );
        $the_columns = get_posts( $args );
        foreach ( $the_columns as $column ) {
            (int)$columns[$column->post_title] = $column->post_title;
        }
        return $columns;

        
    }

      /**
	 * Column name.
	 *
	 * @return string
	 */
	 
	  protected function get_colum_id($name){
        
        if($name == 'Club') return 'name'; 
        if($name == 'Pos') return 'pos';
        
               //continue;
        $args = array(
                   'post_type' => 'sp_column',
                   'numberposts' => 1,
                   'title' => $name
               );
           
           $colname = get_posts($args);
           return $colname[0]->post_name;

}

	
	
	


	

	/**
	 * Register dependent script.
	 *
	 * @return array
	 */
	
	protected function _register_controls() {
		
		$this->start_controls_section(
			'section_sp_league',
			[
				'label' => __( 'League Table', 'skyre' ),
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
			'table_style',
			[
				'label' => __( 'Table Style', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => 'None',
					'table-dark' => 'Table Dark',
					'table-striped' => 'Striped rows',
					'table-striped table-dark' => 'Striped black rows',
					'table-bordered' => 'Bordered table',
					'table-borderless' => 'Borderless table',
					'table-borderless table-dark' => 'Borderless black table',
					'table-hover' => 'Hoverable rows',
					'table-hover table-dark' => 'Hoverable black rows',
					'table-sm' => 'Small table',
					'table-sm table-dark' => 'Small black table',
				],
				'default' => '',
			]
		);
		
		$this->add_control(
			'list_id', [
				'label' => __( 'Select League/Calendar ', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->get_league_list(),
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
				'label' => __( 'Number of Teams to show', 'skyre' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'step' => 1,
				'default' => 10,
			]
		);


        $this->add_control(
			'show_link',
			[
				'label' => __( 'Display link to view all Teams', 'skyre' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'skyre' ),
				'label_off' => __( 'Hide', 'skyre' ),
				'return_value' => 'yes',
                'default' => '',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'list_id',
                            'operator' => '!in',
                            'value' => [
                                '1',
                            ],
                        ],
                    ],
                ],
                
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
				'label' => __( 'Fields', 'skyre' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[ 'column_id' => __( 'Pos', 'skyre' ), ],
					[ 'column_id' => __( 'Club', 'skyre' ), ],
					[ 'column_id' => __( 'W', 'skyre' ), ],
                    [ 'column_id' => __( 'D', 'skyre' ), ],
                    [ 'column_id' => __( 'Pts', 'skyre' ), ],
					 
				],
				'title_field' =>'{{{column_id}}}'/*'{{column_id}}'*/ //get_the_title('{{column_id}}') ,
			]
		);
		
		$this->end_controls_section();
		
		//========== List heading
		$this->start_controls_section(
			'sp_league_list_heading',
			[
				'label' => __( 'Heading', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'section_sp_league.widget_title!' => '',
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
		
		$this->add_responsive_control(
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
		
		$this->add_responsive_control(
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
			'sp_league_list_content',
			[
				'label' => __( 'Content', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'section_sp_league.list_attr' => 'content',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'list_content_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .league_list_meta p',
			]
		);
		
		$this->add_control(
			'list_content_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .league_list_meta p' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .league_list_meta p' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'list_content_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .league_list_meta p',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'list_content_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .league_list_meta p',
			]
		);
		
		$this->add_control(
			'list_content_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .league_list_meta p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'list_content_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .league_list_meta p',
			]
		);
		
		$this->add_responsive_control(
			'list_content_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .league_list_meta p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->add_responsive_control(
			'list_content_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .league_list_meta p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

        $this->end_controls_section();
		
		//========== List Image
		$this->start_controls_section(
			'sp_league_list_image',
			[
				'label' => __( 'Featured Image', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'section_sp_league.list_attr' => 'image',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'list_image_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .league_list_meta .post_image',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'list_image_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .league_list_meta .post_image',
			]
		);
		
		$this->add_control(
			'list_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .league_list_meta .post_image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'list_image_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .league_list_meta .post_image',
			]
		);
		
		$this->add_responsive_control(
			'list_image_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .league_list_meta .post_image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->add_responsive_control(
			'list_image_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .league_list_meta .post_image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

        $this->end_controls_section();
		
        //========== Leau Table
		$this->start_controls_section(
			'sp_league_table',
			[
				'label' => __( 'Table', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'table_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sk-league-table',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'table_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-league-table',
			]
		);
		
		$this->add_control(
			'table_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-league-table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'table_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-league-table',
			]
		);
		
		$this->add_control(
			'table_padding',
			[
				'label'      => __( 'Wrap Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-template-league-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
        $this->end_controls_section();
        
        //==========Table heading settings
		$this->start_controls_section(
			'sp_league_table_head',
			[
				'label' => __( 'Table Heading', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'table_heading_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .sk-league-table th',
			]
		);
		
		$this->add_control(
			'table_heading_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .sk-league-table th' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'table_heading_align',
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
					'{{WRAPPER}} .sk-league-table th' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'table_heading_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sk-league-table th',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'table_heading_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-league-table th',
			]
		);
		
		
		$this->add_control(
			'table_heading_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-league-table th' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'table_heading_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-league-table th',
			]
		);
		
		$this->add_control(
			'table_heading_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-league-table th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->end_controls_section();
		
		
		
		//==========Table column settings
		$this->start_controls_section(
			'sp_league_table_column',
			[
				'label' => __( 'Table Column', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'table_column_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .sk-league-table td, {{WRAPPER}} .sk-league-table td a',
			]
		);
		
		$this->add_control(
			'table_column_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .sk-league-table td, {{WRAPPER}} .sk-league-table td a' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'table_column_align',
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
					'{{WRAPPER}} .sk-league-table td' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'table_column_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sk-league-table td',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'table_column_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-league-table td',
			]
		);
		
		$this->add_control(
			'table_column_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-league-table td' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->add_control(
			'hrtd',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'table_column_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-league-table td',
			]
		);

		
		
		$this->add_control(
			'table_column_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-league-table td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->end_controls_section();

		//========== League Icon
		$this->start_controls_section(
			'sp_league_icon',
			[
				'label' => __( 'Team logo', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'section_sp_league.list_attr' => 'logo',
				],
			]
		);
		
		
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'icon_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .team-logo',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'icon_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .team-logo',
			]
		);
		
		$this->add_control(
			'icon_border_radius',
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
				'name' => 'icon_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .team-logo',
			]
		);
		
		$this->add_responsive_control(
			'icon_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .team-logo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->add_responsive_control(
			'icon_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .team-logo' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

        $this->end_controls_section();
		
		
		//==========view all button
		$this->start_controls_section(
			'sp_league_view_all',
			[
				'label' => __( 'View All Link', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'section_sp_league.show_link' => 'yes',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'view_all_button_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .sk-sp-view-all-link',
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

		$this->add_control(
			'view_all_button_align',
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
					'{{WRAPPER}} .sk-sp-view-all-link' => 'text-align: {{VALUE}};',
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
		
		$this->add_responsive_control(
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
		
		$this->add_responsive_control(
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

		$this->end_controls_section();

		
		
		
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
		$title = empty($settings['list_title']) ? null : $settings['list_title'];;
		$widget_title = empty($settings['widget_title']) ? null : $settings['widget_title'];
		$titlesize  = empty($settings['title_size']) ? 'h3' : $settings['title_size'];
		$number = empty($settings['limit']) ? '0' : $settings['limit'];
		$columns = empty($settings['widget_columns']) ? null : $settings['widget_columns'];
		//$orderby = empty($settings['order_by']) ? 'default' : $settings['order_by'];
		$order = empty($settings['sort_order']) ? 'ASC' : $settings['sort_order'];
		$show_full_table_link = empty($settings['show_link']) ? false : $settings['show_link'];
		$ws['table_style'] = empty($settings['table_style']) ? '' : $settings['table_style'];
        
		

		//widge settings - ws
		$ws['attr'] = $settings['list_attr'];
		
		foreach($columns as $column){
			if(isset($column['column_id']) && $column['column_id'] !='') {
				$columFields[]=$this->get_colum_id($column['column_id']);
			}
            }
            
		if ( $id > 0 ) {
		//print_r($settings['widget_title']);
		
		$post = get_post( $id );
		
		echo  '<div class="league_list_meta"> ';
		if($widget_title) { echo '<'.$titlesize.' class="sp-list-title">'.$widget_title.'</'.$titlesize.'>'; }
		if ( in_array( 'content', $settings['list_attr'] )) { echo '<p>'. $post->post_content.'</p>'; }
		if ( in_array( 'image', $settings['list_attr'] )) { echo '<div class="post_image">'.get_the_post_thumbnail( $post->ID ).'</div>'; }
		
		
		echo  '</div> ';
		//sp_get_template( 'event-list.php', array( 'id' => $id, 'ws'=>$ws, 'title' => $caption, 'status' => $status, 'date' => $date, 'date_from' => $date_from, 'date_to' => $date_to, 'date_past' => $date_past, 'date_future' => $date_future, 'date_relative' => $date_relative, 'day' => $day, 'number' => $number, 'columns' => $columFields, 'order' => $order, 'show_all_events_link' => $show_all_events_link ) );
        sp_get_template( 'league-table.php', array( 'id' => $id, 'ws'=>$ws, 'title' => $caption, 'number' => $number, 'columns' => $columFields, 'show_full_table_link' => $show_full_table_link ) );

		
         
		}
		else { echo 'Plase select a League List';}
		
	}

	


}

