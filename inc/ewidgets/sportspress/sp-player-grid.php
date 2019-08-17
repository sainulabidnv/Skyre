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
 * Class Posts_Grid
 *
 * @package ThemeIsle\ElementorExtraWidgets
 */
class spPlayerGrid extends \Elementor\Widget_Base {

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'Player Grid', 'skyre' );
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
		return 'skyre-sp-player-grid';
	}
	
	protected function get_player_list(){
	
	  $args = array('post_type' => 'sp_list', 'posts_per_page' => -1);
	  
		$catlist=[ 1 => __( 'All', 'skyre' ),];
		
		if( $categories = get_posts($args)){
			foreach ( $categories as $category ) {
				(int)$catlist[$category->ID] = $category->post_title;
			}
		}
		else{
			(int)$catlist['0'] = esc_html__('No player list found', 'skyre');
		}
	  return $catlist;
	  }
	  
	  /**
	 * Column name.
	 *
	 * @return string
	 */
	 
	  protected function get_columns(){
		 $args = array(
					'post_type' => array( 'sp_metric', 'sp_performance', 'sp_statistic' ),
					'numberposts' => -1,
					'posts_per_page' => -1,
					'orderby' => 'menu_order',
					'order' => 'ASC'
				);
			
			$fields = array('Photo'=>'Photo','Name'=>'Name','Club'=>'Club','Postion'=>'Postion');
			if( $columns = get_posts($args)){
			foreach ( $columns as $column ) {
				(int)$fields[$column->post_title] = $column->post_title;
			}
		}
		else{
			(int)$fields['0'] = esc_html__('No player list found', 'skyre');
		}
	  return $fields;
			

}
	  /**
	 * Column for sorting.
	 *
	 * @return string
	 */
	 
	  protected function get_columns_sort(){
		 $args = array(
					'post_type' => array( 'sp_metric', 'sp_performance', 'sp_statistic' ),
					'numberposts' => -1,
					'posts_per_page' => -1,
					'orderby' => 'menu_order',
					'order' => 'ASC'
				);
			
			$fields = array(
				'default' => __( 'Default', 'sportspress' ),
				'number' => __( 'Number', 'sportspress' ),
				'name' => __( 'Name', 'sportspress' ),
				'eventsplayed' => __( 'Played', 'sportspress' )
				);
			if( $columns = get_posts($args)){
			foreach ( $columns as $column ) {
				(int)$fields[$column->post_name] = $column->post_title;
			}
		}
		else{
			(int)$fields['0'] = esc_html__('No player list found', 'skyre');
		}
	  return $fields;
			

}
	  /**
	 * Column name.
	 *
	 * @return string
	 */
	 
	  protected function get_colum_name($name){
		 $fields = array('Photo','Name','Club','Postion');
		 if ( in_array( $name, $fields ) ){
			 if($name == 'Name') return 'name';
			 if($name == 'Club') return 'team';
			 if($name == 'Postion') return 'position';
			 if($name == 'Photo') return 'photo';
			 }
				//continue;
		 $args = array(
					'post_type' => array( 'sp_metric', 'sp_performance', 'sp_statistic' ),
					'numberposts' => -1,
					'posts_per_page' => -1,
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'title' => $name
				);
			
			$colname = get_posts($args);
			if( $colname) return $colname[0]->post_name;

}

	/**
	 * Register dependent script.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return [ 'skyre-sp-player' ];
	}
	
		protected function _register_controls() {
		
		$this->start_controls_section(
			'section_sp_player',
			[
				'label' => __( 'Player List', 'skyre' ),
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
			'list_id', [
				'label' => __( 'Select Player List', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->get_player_list(),
				'default' => 1,
			]
		);
		
		$this->add_control(
			'list_attr', [
				'label' => __( 'Show ', 'skyre' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => [
					'rank' => __( 'Rank', 'skyre' ),
					'flag' => __( 'Flag', 'skyre' ),
					'content' => __( 'List Content', 'skyre' ),
					'image' => __( 'List Image', 'skyre' ),
				],
				'default' => ['rank'],
			]
		);
		
		$this->add_control(
			'limit', [
				'label' => __( 'Number of players to show', 'skyre' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'step' => 1,
				'default' => 4,
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
			'group_by', [
				'label' => __( 'Group by ', 'skyre' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'position' => __( 'Position', 'skyre' ),
					'1' => __( 'None', 'skyre' ),
				],
				'default' => ['1'],
			]
		);
		
		$this->add_control(
			'order_by', [
				'label' => __( 'Order by', 'skyre' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $this->get_columns_sort(),
				'default' => 'default',
			]
		);
		
		$this->add_control(
			'sort_order', [
				'label' => __( 'Sort Order', 'skyre' ),
				'type' => \Elementor\Controls_Manager::SELECT,
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
				'label' => __( 'Display link to view all players', 'skyre' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'skyre' ),
				'label_off' => __( 'Hide', 'skyre' ),
				'return_value' => 'yes',
				'default' => 'yes',
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
				'label' => __( 'Player Fields', 'skyre' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[ 'column_id' => __( 'Photo', 'skyre' ), ],
					[ 'column_id' => __( 'Name', 'skyre' ), ],
					[ 'column_id' => __( 'Club', 'skyre' ), ],
				],
				'title_field' =>'{{{column_id}}}'/*'{{column_id}}'*/ //get_the_title('{{column_id}}') ,
			]
		);
		
		$this->end_controls_section();
		
		//========== List heading
		$this->start_controls_section(
			'sp_player_list_heading',
			[
				'label' => __( 'Heading', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'skyre-sp-player.widget_title!' => '',
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

		// alignment.
		$this->add_responsive_control(
			'list_heading_alignment',
			[
				'label'          =>  __( 'Alignment', 'skyre' ),
				'type'           => \Elementor\Controls_Manager::CHOOSE,
				'options'        => [
					'left'   => [
						'title' => __( 'Left', 'skyre' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'skyre' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'skyre' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .sp-list-title' => 'text-align: {{VALUE}};',
				],
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
			'sp_player_list_content',
			[
				'label' => __( 'Content', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'skyre-sp-player.list_attr' => 'content',
				],

			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'list_content_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .sp-post-content',
			]
		);

		// alignment.
		$this->add_responsive_control(
			'list_content_alignment',
			[
				'label'          =>  __( 'Alignment', 'skyre' ),
				'type'           => \Elementor\Controls_Manager::CHOOSE,
				'options'        => [
					'left'   => [
						'title' => __( 'Left', 'skyre' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'skyre' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'skyre' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .sp-post-content' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'list_content_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sp-post-content' => 'color: {{VALUE}};',
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
				'name' => 'list_content_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sp-post-content',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'list_content_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-post-content',
			]
		);
		
		$this->add_control(
			'list_content_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-post-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'list_content_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sp-post-content',
			]
		);
		
		$this->add_control(
			'list_content_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sp-post-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .sp-post-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

        $this->end_controls_section();
		
		//========== List Image
		$this->start_controls_section(
			'sp_player_list_image',
			[
				'label' => __( 'Featured Image', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'skyre-sp-player.list_attr' => 'image',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'list_image_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .player_grid .post_image',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'list_image_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .player_grid .post_image',
			]
		);
		
		$this->add_control(
			'list_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .player_grid .post_image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'list_image_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .player_grid .post_image',
			]
		);
		
		$this->add_control(
			'list_image_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .player_grid .post_image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .player_grid .post_image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

        $this->end_controls_section();
		
		//==========Position heading settings
		$this->start_controls_section(
			'sp_player_table_head',
			[
				'label' => __( 'Positions Heading', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'section_sp_player.group_by' => 'position',
				],
			]
		);
		
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'table_heading_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .position-heading',
			]
		);

		$this->add_control(
			'table_heading_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .position-heading' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .position-heading' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'table_heading_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .position-heading',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'table_heading_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .position-heading',
			]
		);
		
		
		$this->add_control(
			'table_heading_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .position-heading' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'table_heading_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .position-heading',
			]
		);
		
		$this->add_control(
			'table_heading_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .position-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'table_heading_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .position-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->end_controls_section();
		
		
		
		//========== columns settings
		$this->start_controls_section(
			'sp_player_grid_column',
			[
				'label' => __( 'Columns', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'table_column_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sk-player-grid .player-photo',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'table_column_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-player-grid .player-photo',
			]
		);
		
		$this->add_control(
			'table_column_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-player-grid .player-photo' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'table_column_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-player-grid .player-photo',
			]
		);

		
		
		$this->add_control(
			'table_column_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-player-grid .player-photo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'table_column_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-player-grid .player-photo' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->end_controls_section();

		//==========Player Name settings
		$this->start_controls_section(
			'sp_player_name',
			[
				'label' => __( 'Name Field', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'name_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .sk-player-grid .player-name a, {{WRAPPER}} .sk-player-grid .player-name',
			]
		);
		

		// alignment.
		$this->add_responsive_control(
			'name_alignment',
			[
				'label'          =>  __( 'Alignment', 'skyre' ),
				'type'           => \Elementor\Controls_Manager::CHOOSE,
				'options'        => [
					'left'   => [
						'title' => __( 'Left', 'skyre' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'skyre' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'skyre' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .sk-player-grid .player-name a, {{WRAPPER}} .sk-player-grid .player-name' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'name_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .sk-player-grid .player-name a, {{WRAPPER}} .sk-player-grid .player-name' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'name_align',
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
					'{{WRAPPER}} .sk-player-grid .player-name' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'name_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sk-player-grid .player-name',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'name_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-player-grid .player-name',
			]
		);
		
		
		$this->add_control(
			'name_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-player-grid .player-name' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'name_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-player-grid .player-name',
			]
		);
		
		$this->add_control(
			'name_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-player-grid .player-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'name_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-player-grid .player-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->end_controls_section();

		//==========Player team settings
		$this->start_controls_section(
			'sp_player_team',
			[
				'label' => __( 'Team Field', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'team_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .sk-player-grid .player-team a, {{WRAPPER}} .sk-player-grid .player-team',
			]
		);

		// alignment.
		$this->add_responsive_control(
			'team_alignment',
			[
				'label'          =>  __( 'Alignment', 'skyre' ),
				'type'           => \Elementor\Controls_Manager::CHOOSE,
				'options'        => [
					'left'   => [
						'title' => __( 'Left', 'skyre' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'skyre' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'skyre' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .sk-player-grid .player-team a, {{WRAPPER}} .sk-player-grid .player-team' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'team_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .sk-player-grid .player-team a, {{WRAPPER}} .sk-player-grid .player-team' => 'color: {{VALUE}};',
					
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'team_align',
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
					'{{WRAPPER}} .sk-player-grid .player-team' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'team_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sk-player-grid .player-team',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'team_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-player-grid .player-team',
			]
		);
		
		
		$this->add_control(
			'team_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-player-grid .player-team' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'team_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-player-grid .player-team',
			]
		);
		
		$this->add_control(
			'team_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-player-grid .player-team' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'team_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-player-grid .player-team' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->end_controls_section();
		
		//==========Player Other Field settings
		$this->start_controls_section(
			'sp_player_more_fields',
			[
				'label' => __( 'More Fields', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'more_fields_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .sk-player-grid .player-column',
			]
		);

		// alignment.
		$this->add_responsive_control(
			'more_fields_alignment',
			[
				'label'          =>  __( 'Alignment', 'skyre' ),
				'type'           => \Elementor\Controls_Manager::CHOOSE,
				'options'        => [
					'left'   => [
						'title' => __( 'Left', 'skyre' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'skyre' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'skyre' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .sk-player-grid .player-column' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'more_fields_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .sk-player-grid .player-column' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'more_fields_align',
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
					'{{WRAPPER}} .sk-player-grid .player-column' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'more_fields_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sk-player-grid .player-column',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'more_fields_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-player-grid .player-column',
			]
		);
		
		
		$this->add_control(
			'more_fields_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-player-grid .player-column' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'more_fields_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-player-grid .player-column',
			]
		);
		
		$this->add_control(
			'more_fields_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-player-grid .player-column' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'more_fields_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-player-grid .player-column' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->end_controls_section();
		
		


		//========== Player Flag
		$this->start_controls_section(
			'sp_player_flag',
			[
				'label' => __( 'Flag', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'skyre-sp-player.list_attr' => 'flag',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'flag_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sk-player-grid .player-flag',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'flag_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-player-grid .player-flag',
			]
		);
		
		$this->add_control(
			'flag_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-player-grid .player-flag' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'flag_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-player-grid .player-flag',
			]
		);
		
		$this->add_control(
			'flag_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-player-grid .player-flag' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'flag_size',
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
					'{{WRAPPER}} .sk-player-grid .player-flag' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'flag_horizontal',
			[
				'label' => __( 'Horizontal Position', 'skyre' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -10,
						'max' => 500,
					],
					'%' => [
						'min' => -10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sk-player-grid .player-flag' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'flag_vertical',
			[
				'label' => __( 'Vertical Position', 'skyre' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -10,
						'max' => 500,
					],
					'%' => [
						'min' => -10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sk-player-grid .player-flag' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
		
		//==========Rank settings
		$this->start_controls_section(
			'sp_player_grid_rank',
			[
				'label' => __( 'Rank', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'skyre-sp-player.list_attr' => 'rank',
				],
			]
		);
		
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'rank_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .sk-player-grid .player-rank ',
			]
		);
		
		$this->add_control(
			'rank_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .sk-player-grid .player-rank ' => 'color: {{VALUE}};',
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
				'name' => 'rank_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sk-player-grid .player-rank ',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'rank_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-player-grid .player-rank ',
			]
		);
		
		
		$this->add_control(
			'rank_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-player-grid .player-rank ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'rank_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .sk-player-grid .player-rank ',
			]
		);
		
		$this->add_control(
			'rank_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sk-player-grid .player-rank ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'rank_size',
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
					'{{WRAPPER}} .sk-player-grid .player-rank' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'rank_horizontal',
			[
				'label' => __( 'Horizontal Position', 'skyre' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -10,
						'max' => 500,
					],
					'%' => [
						'min' => -10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sk-player-grid .player-rank' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'rank_vertical',
			[
				'label' => __( 'Vertical Position', 'skyre' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -10,
						'max' => 500,
					],
					'%' => [
						'min' => -10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .sk-player-grid .player-rank' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();

		//==========view all button
		$this->start_controls_section(
			'sp_player_view_all',
			[
				'label' => __( 'View All Link', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'skyre-sp-player.show_link' => 'yes',
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

		// alignment.
		$this->add_responsive_control(
			'view_all_button_alignment',
			[
				'label'          =>  __( 'Alignment', 'skyre' ),
				'type'           => \Elementor\Controls_Manager::CHOOSE,
				'options'        => [
					'left'   => [
						'title' => __( 'Left', 'skyre' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'skyre' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'skyre' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .sk-sp-view-all-link a' => 'text-align: {{VALUE}};',
				],
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

		$this->end_controls_section();
		
		
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$html = '';
		$year = '';
		$i = 0;
		$columFields = null;
		$caption = null;
		$widget_settings = '';
		//$settings['columns'] = array( 'number', 'position', 'team' );
		
		$id = empty($settings['list_id']) ? 0 : $settings['list_id'];
		$title = empty($settings['list_title']) ? null : $settings['list_title'];;
		$widget_title = empty($settings['widget_title']) ? null : $settings['widget_title'];
		$titlesize  = empty($settings['title_size']) ? 'h3' : $settings['title_size'];
		$number = empty($settings['limit']) ? '0' : $settings['limit'];
		$columns = empty($settings['widget_columns']) ? null : $settings['widget_columns'];
		$columncount = empty($settings['widget_columncount']) ? null : $settings['widget_columncount'];
		$orderby = empty($settings['order_by']) ? 'default' : $settings['order_by'];
		$order = empty($settings['sort_order']) ? 'ASC' : $settings['sort_order'];
		$show_all_players_link = empty($settings['show_link']) ? false : $settings['show_link'];
		$grouping = empty($settings['group_by']) ? null : $settings['group_by'];
		//widge settings - ws
		$ws['attr'] = $settings['list_attr'];
		
		foreach($columns as $column){
			if(isset($column['column_id']) && $column['column_id'] !='') {
				$columFields[]=$this->get_colum_name($column['column_id']);
			}
			}
		if ( $id > 0 ) {
		//print_r($settings['widget_title']);
		
		$post = get_post( $id );
		
		echo  '<div class="player_grid"> ';
		if($widget_title) { echo '<'.$titlesize.' class="sp-list-title">'.$widget_title.'</'.$titlesize.'>'; }
		if ( in_array( 'content', $settings['list_attr'] )) { echo '<div class="sp-post-content">'. $post->post_content.'</div>'; }
		if ( in_array( 'image', $settings['list_attr'] )) { echo '<div class="post_image">'.get_the_post_thumbnail( $post->ID ).'</div>'; }
		
		
		echo  '</div> ';
		//sp_get_template( 'player-list.php', array( 'id' => $id,'ws'=>$ws, 'title' => $caption, 'number' => $number, 'columns' => $columFields, 'orderby' => $orderby, 'order' => $order, 'grouping' => 0, 'show_all_players_link' => $show_all_players_link ) );
		sp_get_template( 'player-gallery.php', array( 'id' => $id,'ws'=>$ws, 'title' => $caption, 'number' => $number, 'columncount' =>$columncount, 'columns' => $columFields, 'orderby' => $orderby , 'order' => $order, 'grouping' => $grouping, 'show_all_players_link' => $show_all_players_link ) );
		
		
         
		}
		else { echo 'Plase select a Player List';}
		
	}

	


}

