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
class postsGrid extends \Elementor\Widget_Base {

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'Post Grid/List', 'skyre' );
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
		return 'skyre-posts-grid';
	}

	/**
	 * Register dependent script.
	 *
	 * @return array
	 */
	public function get_script_depends() {
		return [ 'skyre-grid-js' ];
	}

	/**
	 * Widget Category.
	 *
	 * @return array
	 */
/*	public function get_categories() {
		$category_args = apply_filters( 'elementor_extra_widgets_category_args', array() );
		$slug          = isset( $category_args['slug'] ) ? $category_args['slug'] : 'skyre-elementor-widgets';

		return [ $slug ];
	}
*/
	/**
	 * Get post types.
	 */
	private function grid_get_all_post_types() {
		$options = array();
		$exclude = array( 'attachment', 'elementor_library' ); // excluded post types

		$args = array(
			'public' => true,
		);

		foreach ( get_post_types( $args, 'objects' ) as $post_type ) {
			// Check if post type name exists.
			if ( ! isset( $post_type->name ) ) {
				continue;
			}

			// Check if post type label exists.
			if ( ! isset( $post_type->label ) ) {
				continue;
			}

			// Check if post type is excluded.
			if ( in_array( $post_type->name, $exclude ) === true ) {
				continue;
			}

			$options[ $post_type->name ] = $post_type->label;
		}

		return $options;
	}

	/**
	 * Get post types.
	 */
	private function get_columns() {
		$the_columns = array();
		$the_columns['Image'] = __( 'Image', 'skyre' );
		$the_columns['Title'] = __( 'Title', 'skyre' ); 
        $the_columns['Meta'] = __( 'Meta', 'skyre' ); 
		$the_columns['Content'] = __( 'Content', 'skyre' ); 
		$the_columns['Button'] = __( 'Button', 'skyre' );
		if ( class_exists( 'WooCommerce' ) ) {
			$the_columns['Price'] = __( 'Price', 'skyre' );
		 }
 		return $the_columns ;
	}
	

	/**
	 * Get post type categories.
	 */
	private function grid_get_all_post_type_categories( $post_type ) {
		$options = array();

		$options[0] = 'All';
		if ( $post_type == 'post' ) {
			$taxonomy = 'category';
		} elseif ( $post_type == 'product' ) {
			$taxonomy = 'product_cat';
		}

		if ( ! empty( $taxonomy ) ) {
			// Get categories for post type.
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				)
			);
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( isset( $term ) ) {
						if ( isset( $term->slug ) && isset( $term->name ) ) {
							$options[ $term->slug ] = $term->name;
						}
					}
				}
			}
		}

		return $options;
	}

	/**
	 * Register Elementor Controls.
	 */
	protected function _register_controls() {
		// Content.
		$this->grid_options_section();
		$this->grid_field_section();
		$this->grid_image_section();
		$this->grid_meta_section();
		
		$this->grid_content_section();
		$this->grid_title_section();
		// Style.
		$this->grid_options_style_section();
		$this->grid_image_style_section();
		$this->grid_title_style_section();
		$this->grid_meta_style_section();
		$this->grid_content_style_section();
		$this->grid_content_style_button();
		$this->grid_content_style_addtocartbutton();
		$this->grid_content_style_sales_label();
		$this->grid_pagination_style_section();
	}

	/**
	 * Content > Grid.
	 */
	private function grid_options_section() {
		$this->start_controls_section(
			'section_grid',
			[
				'label' => __( 'Grid Options', 'skyre' ),
			]
		);

		// Post type.
		$this->add_control(
			'grid_post_type',
			[
				'type'    => \Elementor\Controls_Manager::SELECT,
				'label'   => '<i class="fa fa-tag"></i> ' . __( 'Post Type', 'skyre' ),
				'default' => 'post',
				'options' => $this->grid_get_all_post_types(),
			]
		);

		$this->add_control(
			'grid_post_filter',
			[
				'label' => esc_html__( 'Filter By', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'recent',
				'options' => [
					'recent' => esc_html__( 'Recent Products', 'skyre' ),
					'featured' => esc_html__( 'Featured Products', 'skyre' ),
					'best_selling' => esc_html__( 'Best Selling Products', 'skyre' ),
					'sale' => esc_html__( 'Sale Products', 'skyre' ),
					'top_rated' => esc_html__( 'Top Rated Products', 'skyre' ),
					'mixed_order' => esc_html__( 'Mixed order Products', 'skyre' ),
				],
				'condition' => [
					'grid_post_type' => 'product',
				],
			]
		);

		// Post categories.
		$this->add_control(
			'grid_post_categories',
			[
				'type'      => \Elementor\Controls_Manager::SELECT,
				'label'     => '<i class="fa fa-folder"></i> ' . __( 'Category', 'skyre' ),
				'options'   => $this->grid_get_all_post_type_categories( 'post' ),
				'default'	=> 0,
				'condition' => [
					'grid_post_type' => 'post',
				],
			]
		);

		// Product categories.
		$this->add_control(
			'grid_product_categories',
			[
				'type'      => \Elementor\Controls_Manager::SELECT,
				'label'     => '<i class="fa fa-tag"></i> ' . __( 'Category', 'skyre' ),
				'options'   => $this->grid_get_all_post_type_categories( 'product' ),
				'condition' => [
					'grid_post_type' => 'product',
				],
			]
		);

		// Layout.
		$this->add_control(
			'grid_style',
			[
				'type'    => \Elementor\Controls_Manager::SELECT,
				'label'   => '<i class="fa fa-paint-brush"></i> ' . __( 'Layout', 'skyre' ),
				'default' => 'grid',
				'options' => [
					'grid' => __( 'Grid', 'skyre' ),
					'list' => __( 'List', 'skyre' ),
					'grid2' => __( 'Grid 2', 'skyre' ),
				],
			]
		);

		// Image width.
		$this->add_control(
			'grid_image_width',
			[
				'label'     => '<i class="fa fa-arrows-h"></i> ' . __( 'Image width', 'skyre' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'condition' => [
					'grid_style' => 'list',
				],
				'selectors' => [
					'{{WRAPPER}} .skyre-widget-post-left' => 'width: {{SIZE}}%;',
					'{{WRAPPER}} .skyre-widget-post-right' => 'width: {{SIZE-100-3}}%;',
				],
			]
		);

		// Items.
		$this->add_control(
			'grid_items',
			[
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'label'       => '<i class="fa fa-th-large"></i> ' . __( 'Items', 'skyre' ),
				'placeholder' => __( 'How many items?', 'skyre' ),
				'default'     => 6,
			]
		);

		// Columns.
		$this->add_responsive_control(
			'grid_columns',
			[
				'type'           => \Elementor\Controls_Manager::SELECT,
				'label'          => '<i class="fa fa-columns"></i> ' . __( 'Columns', 'skyre' ),
				'default'        => 3,
				'tablet_default' => 6,
				'mobile_default' => 12,
				'options'        => [
					12 => 1,
					6 => 2,
					4 => 3,
					3 => 4,
					2 => 6,
				],
			]
		);

		// Order by.
		$this->add_control(
			'grid_order_by',
			[
				'type'    => \Elementor\Controls_Manager::SELECT,
				'label'   => '<i class="fa fa-sort"></i> ' . __( 'Order by', 'skyre' ),
				'default' => 'date',
				'options' => [
					'date'          => __( 'Date', 'skyre' ),
					'title'         => __( 'Title', 'skyre' ),
					'modified'      => __( 'Modified date', 'skyre' ),
					'comment_count' => __( 'Comment count', 'skyre' ),
					'rand'          => __( 'Random', 'skyre' ),
				],
			]
		);

		// Display pagination.
		$this->add_control(
			'grid_pagination',
			[
				'label'   => '<i class="fa fa-arrow-circle-right"></i> ' . __( 'Pagination', 'skyre' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		$this->end_controls_section();

		//Grid 2 Settings
		$this->start_controls_section(
			'section_grid_style_2',
			[
				'label' => __( 'Grid 2 Settings', 'skyre' ),
				'condition' => [
					'grid_style' => 'grid2',
				],
			]
		);

		// Display pagination.
		$this->add_control(
			'grid_style_2_show',
			[
				'label'   => __( 'Show hover content', 'skyre' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => '1',
				'default' => '0',
				'selectors' => [
					'{{WRAPPER}} .grid2 .content-wrap'       => 'opacity: {{VALUE}};',
					'{{WRAPPER}} .grid2 .skyre-widget-post-content'       => 'opacity: {{VALUE}};',
					
				],
			]
		);

		// Hover color.
		$this->add_control(
			'grid_style_2_background',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Background', 'skyre' ),
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .grid2 .skyre-widget-post-content'       => 'background-color: {{VALUE}};',
				],
			]
		);

		// Hover color.
		$this->add_control(
			'grid_style_2_background_hover',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Hover Background', 'skyre' ),
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .grid2 .post-item-inner:hover .skyre-widget-post-content'       => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'grid_style_2_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .grid2 .skyre-widget-post-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		$this->add_control(
			'grid_style_2_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .grid2 .skyre-widget-post-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);


		$this->end_controls_section();
	}

	/**
	 * Content > Grid Field.
	 */
	private function grid_field_section() {
		$this->start_controls_section(
			'section_grid_field',
			[
				'label' => __( 'Fields', 'skyre' ),
			]
		);

		$repeater = new \Elementor\Repeater();

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
				'label' => __( 'Fields', 'skyre' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
                    [ 'column_id' => __( 'Image', 'skyre' ), ],
                    [ 'column_id' => __( 'Title', 'skyre' ), ],
					[ 'column_id' => __( 'Meta', 'skyre' ), ],
					[ 'column_id' => __( 'Content', 'skyre' ), ],
					[ 'column_id' => __( 'Price', 'skyre' ), ],
					[ 'column_id' => __( 'Button', 'skyre' ), ],
					 
				],
				'title_field' =>'{{{column_id}}}',
			]
		);
		
		$this->end_controls_section();
	}

	



	/**
	 * Content > Image Options.
	 */
	private function grid_image_section() {
		$this->start_controls_section(
			'section_grid_image',
			[
				'label' => __( 'Image', 'skyre' ),
			]
		);

		

		

		// Image link.
		$this->add_control(
			'grid_image_link',
			[
				'label'   => '<i class="fa fa-link"></i> ' . __( 'Link', 'skyre' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content > Title Options.
	 */
	private function grid_title_section() {
		$this->start_controls_section(
			'section_grid_title',
			[
				'label' => __( 'Title', 'skyre' ),
			]
		);

		
		// Title tag.
		$this->add_control(
			'grid_title_tag',
			[
				'type'    => \Elementor\Controls_Manager::SELECT,
				'label'   => '<i class="fa fa-code"></i> ' . __( 'Tag', 'skyre' ),
				'default' => 'h2',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'span' => 'span',
					'p'    => 'p',
					'div'  => 'div',
				],
			]
		);

		// Title link.
		$this->add_control(
			'grid_title_link',
			[
				'label'   => '<i class="fa fa-link"></i> ' . __( 'Link', 'skyre' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content > Meta Options.
	 */
	private function grid_meta_section() {
		$this->start_controls_section(
			'section_grid_meta',
			[
				'label' => __( 'Meta', 'skyre' ),
			]
		);

		
		// Meta.
		$this->add_control(
			'grid_meta_display',
			[
				'label'       => '<i class="fa fa-info-circle"></i> ' . __( 'Display', 'skyre' ),
				'label_block' => true,
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'default'     => [ 'author', 'date' ],
				'multiple'    => true,
				'options'     => [
					'author'   => __( 'Author', 'skyre' ),
					'date'     => __( 'Date', 'skyre' ),
					'category' => __( 'Category', 'skyre' ),
					'tags'     => __( 'Tags', 'skyre' ),
					'comments' => __( 'Comments', 'skyre' ),
				],
			]
		);

		// No. of Categories.
		$this->add_control(
			'grid_meta_categories_max',
			[
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'label'       => __( 'No. of Categories', 'skyre' ),
				'placeholder' => __( 'How many categories to display?', 'skyre' ),
				'default'     => __( '1', 'skyre' ),
				'condition'   => [
					'grid_meta_display' => 'category',
				],
				
				
			]
		);

		// No. of Tags.
		$this->add_control(
			'grid_meta_tags_max',
			[
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'label'       => __( 'No. of Tags', 'skyre' ),
				'placeholder' => __( 'How many tags to display?', 'skyre' ),
				'condition'   => [
					'grid_meta_display' => 'tags',
				],
			]
		);

		// Remove meta icons.
		$this->add_control(
			'grid_meta_remove_icons',
			[
				'label'   => '<i class="fa fa-minus-circle"></i> ' . __( 'Remove icons', 'skyre' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content > Content Options.
	 */
	private function grid_content_section() {
		$this->start_controls_section(
			'section_grid_content',
			[
				'label' => __( 'Content', 'skyre' ),
			]
		);

		

		// Show full content.
		$this->add_control(
			'grid_content_full_post',
			[
				'label'   => __( 'Show full content', 'skyre' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		// Length.
		$this->add_control(
			'grid_content_length',
			[
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'label'       => '<i class="fa fa-arrows-h"></i> ' . __( 'Length (words)', 'skyre' ),
				'placeholder' => __( 'Length of content (words)', 'skyre' ),
				'default'     => 30,
				'condition'   => [
						'grid_content_full_post!' => 'yes'
				]
			]
		);

		

		// Read more button hide.
		$this->add_control(
			'grid_content_default_btn',
			[
				'label'     => '<i class="fa fa-check-square"></i> ' . __( 'Read more Button', 'skyre' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'default'   => 'yes',
				
			]
		);

		// Default button text.
		$this->add_control(
			'grid_content_default_btn_text',
			[
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label'       => __( 'Button text', 'skyre' ),
				'placeholder' => __( 'Read more', 'skyre' ),
				'default'     => __( 'Read more', 'skyre' ),
				'condition'   => [
					'grid_content_default_btn!'    => '',
				],
			]
		);

		// Sales button hide.
		$this->add_control(
			'grid_content_sale_btn',
			[
				'label'     => '<i class="fa fa-check-square"></i> ' . __( 'Sales Button', 'skyre' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'default'   => 'yes',
				
			]
		);

		// Sales button text.
		$this->add_control(
			'grid_content_sale_btn_text',
			[
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label'       => __( 'Sales Label text', 'skyre' ),
				'placeholder' => __( 'Sale!', 'skyre' ),
				'default'     => __( 'Sale!', 'skyre' ),
				'condition'   => [
					'grid_content_sale_btn!'    => '',
				],
			]
		);

		// Add to cart button hide.
		$this->add_control(
			'grid_content_product_btn',
			[
				'label'     => '<i class="fa fa-check-square"></i> ' . __( 'Add to Cart Button', 'skyre' ),
				'type'      => \Elementor\Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => [
					'section_grid.grid_post_type' => 'product',
				],
			]
		);

		$this->end_controls_section();
	}

	
	/**
	 * Style > Grid options.
	 */
	private function grid_options_style_section() {
		// Tab.
		$this->start_controls_section(
			'section_grid_style',
			[
				'label' => __( 'Grid Options', 'skyre' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Content alignment.
		$this->add_responsive_control(
			'grid_content_alignment',
			[
				'label'          => '<i class="fa fa-align-right"></i> ' . __( 'Alignment', 'skyre' ),
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
				'default'        => 'left',
				'tablet_default' => 'left',
				'mobile_default' => 'center',
				'selectors'      => [
					'{{WRAPPER}} .skyre-widget-post-item' => 'text-align: {{VALUE}};',
				],
			]
		);

		

		// Columns padding.
		$this->add_control(
			'grid_content_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-widget-post-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		// Columns margin.
		$this->add_control(
			'grid_content_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-widget-post-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		// item padding.
		$this->add_control(
			'grid_content_item_padding',
			[
				'label'      => __( 'Item Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-widget-post-item .post-item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		// Background.
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'grid_style_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .skyre-widget-post-item .post-item-inner',
			]
		);

		// Items options.
		$this->add_control(
			'grid_items_style_heading',
			[
				'label'     => __( 'Items', 'skyre' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'grid_items_style_border',
				'selector' => '{{WRAPPER}} .skyre-widget-post-item .post-item-inner',
				'label' => __( 'Border', 'skyre' ),
			]
		);

		// Items border radius.
		$this->add_control(
			'grid_items_style_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-widget-post-item .post-item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Items box shadow.
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_items_style_box_shadow',
				'selector'  => '{{WRAPPER}} .skyre-widget-post-item .post-item-inner',
				'separator' => '',
			]
		);

		

		$this->end_controls_section();
	}

	/**
	 * Style > Image.
	 */
	private function grid_image_style_section() {
		// Tab.
		$this->start_controls_section(
			'section_grid_image_style',
			[
				'label'     => __( 'Image', 'skyre' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				
			]
		);

		$this->add_control(
			'grid_image_style_height',
			[
				'label' => __( 'Imase Height', 'skyre' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .skyre-grid-col-image' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Image border radius.
		$this->add_control(
			'grid_image_style_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-grid-col-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		// Image box shadow.
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_image_style_box_shadow',
				'selector'  => '{{WRAPPER}} .skyre-grid-col-image',
				'separator' => '',
				
			]
		);

		// Image margin.
		$this->add_responsive_control(
			'grid_image_style_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-grid-col-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Title.
	 */
	private function grid_title_style_section() {
		// Tab.
		$this->start_controls_section(
			'section_grid_title_style',
			[
				'label'     => __( 'Title', 'skyre' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				
			]
		);

		// Title typography.
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_title_style_typography',
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .skyre-grid-title, {{WRAPPER}} .skyre-grid-title > a',
			]
		);

		// Content alignment.
		$this->add_responsive_control(
			'grid_title_style_alignment',
			[
				'label'          => '<i class="fa fa-align-right"></i> ' . __( 'Alignment', 'skyre' ),
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
					'{{WRAPPER}} .skyre-grid-title a, {{WRAPPER}} .skyre-grid-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		// Hover color.
		$this->add_control(
			'grid_title_style_hover_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Hover Color', 'skyre' ),
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .skyre-grid-title:hover'       => 'color: {{VALUE}};',
					'{{WRAPPER}} .skyre-grid-title > a:hover'   => 'color: {{VALUE}};',
				],
			]
		);
		
		// Title color.
		$this->add_control(
			'grid_title_style_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Color', 'skyre' ),
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .skyre-grid-title'       => 'color: {{VALUE}};',
					'{{WRAPPER}} .skyre-grid-title > a'   => 'color: {{VALUE}};',
				],
			]
		);

		// Title margin.
		$this->add_responsive_control(
			'grid_title_style_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-grid-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Title margin.
		$this->add_responsive_control(
			'grid_title_style_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-grid-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'grid_title_style_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .skyre-grid-title',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Meta.
	 */
	private function grid_meta_style_section() {
		// Tab.
		$this->start_controls_section(
			'section_grid_meta_style',
			[
				'label'     => __( 'Meta', 'skyre' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				
			]
		);

		// Meta typography.
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_meta_style_typography',
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .skyre-grid-meta, {{WRAPPER}} .skyre-grid-meta  a',
			]
		);

		// Content alignment.
		$this->add_responsive_control(
			'grid_meta_style_alignment',
			[
				'label'          => '<i class="fa fa-align-right"></i> ' . __( 'Alignment', 'skyre' ),
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
				'default'        => 'left',
				'tablet_default' => 'left',
				'mobile_default' => 'center',
				'selectors'      => [
					'{{WRAPPER}} .skyre-grid-meta a, {{WRAPPER}} .skyre-grid-meta' => 'text-align: {{VALUE}};',
				],
			]
		);

		// Hover color.
		$this->add_control(
			'grid_meta_style_hover_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Hover Color', 'skyre' ),
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .skyre-grid-meta  a:hover'   => 'color: {{VALUE}};',
				],
			]
		);
		
		// Meta color.
		$this->add_control(
			'grid_meta_style_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Color', 'skyre' ),
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .skyre-grid-meta'       => 'color: {{VALUE}};',
					'{{WRAPPER}} .skyre-grid-meta  a'   => 'color: {{VALUE}};',
				],
			]
		);

		// Meta margin.
		$this->add_responsive_control(
			'grid_meta_style_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-grid-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Meta padding.
		$this->add_responsive_control(
			'grid_meta_style_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-grid-meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'grid_meta_style_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .skyre-grid-meta',
			]
		);

        // Meta margin.
		$this->add_responsive_control(
			'grid_meta_itme_style_margin',
			[
				'label'      => __( 'Item Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-grid-meta span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Meta padding.
		$this->add_responsive_control(
			'grid_meta_itme_style_padding',
			[
				'label'      => __( 'Item Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-grid-meta span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'grid_meta_itme_style_background',
				'label' => __( 'Item Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .skyre-grid-meta span',
			]
		);

        $this->add_control(
			'grid_meta_itme_style_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}}  .skyre-grid-meta span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->end_controls_section();

		//Price section
		$this->start_controls_section(
			'section_grid_price_style',
			[
				'label'     => __( 'Price', 'skyre' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'section_grid.grid_post_type' => 'product',
				],
				
			]
		);

		// Price typography.
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_price_style_typography',
				'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .skyre-grid-price',
			]
		);

 
		// Price alignment.
		$this->add_responsive_control(
			'grid_price_style_alignment',
			[
				'label'          => '<i class="fa fa-align-right"></i> ' . __( 'Alignment', 'skyre' ),
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
				'default'        => 'left',
				'tablet_default' => 'left',
				'mobile_default' => 'center',
				'selectors'      => [
					'{{WRAPPER}} .skyre-grid-price' => 'text-align: {{VALUE}};',
				],
			]
		);

		// Hover color.
		$this->add_control(
			'grid_price_style_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Offer Price Color', 'skyre' ),
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .skyre-grid-price del span'       => 'color: {{VALUE}};',
				],
			]
		);
		
		// Price color.
		$this->add_control(
			'grid_price_style_offer_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Color', 'skyre' ),
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .skyre-grid-price span'       => 'color: {{VALUE}};',
				],
			]
		);

		// Price margin.
		$this->add_responsive_control(
			'grid_price_style_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-grid-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Price padding.
		$this->add_responsive_control(
			'grid_price_style_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-grid-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'grid_price_style_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .skyre-grid-price',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Content.
	 */
	private function grid_content_style_section() {
		// Tab.
		$this->start_controls_section(
			'section_grid_content_style',
			[
				'label' => __( 'Content', 'skyre' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Content typography.
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'grid_content_style_typography',
				'scheme'    => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .skyre-grid-content',
				
			]
		);

	
		// Content color.
		$this->add_control(
			'grid_content_style_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Color', 'skyre' ),
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .skyre-grid-content' => 'color: {{VALUE}};',
				],
				
			]
		);

		// Content margin
		$this->add_responsive_control(
			'grid_content_style_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-grid-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Tabs for the Style > Button section.
	 */
	private function grid_content_style_button() {
		// Tab.
		$this->start_controls_section(
			'section_grid_button_style',
			[
				'label' => __( 'Read More Button', 'skyre' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
				],
			]
		);
		
		// Content typography.
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'grid_button_style_typography',
				'scheme'    => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .skyre-grid-read-btn a',
				
			]
		);

		// button alignment.
		$this->add_responsive_control(
			'grid_cart_cart_button_style_alignment',
			[
				'label'          => '<i class="fa fa-align-right"></i> ' . __( 'Alignment', 'skyre' ),
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
				'default'        => 'left',
				'tablet_default' => 'left',
				'mobile_default' => 'center',
				'selectors'      => [
					'{{WRAPPER}} .skyre-grid-read-btn' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'grid_button_style' );

		// Normal tab.
		$this->start_controls_tab(
			'grid_button_style_normal',
			[
				'label'     => __( 'Normal', 'skyre' ),
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		// Normal text color.
		$this->add_control(
			'grid_button_style_normal_text_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Text Color', 'skyre' ),
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .skyre-grid-read-btn a' => 'color: {{VALUE}};',
				],
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		// Normal background color.
		$this->add_control(
			'grid_button_style_normal_bg_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'skyre' ),
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .skyre-grid-read-btn a' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		// Normal box shadow.
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_button_style_normal_box_shadow',
				'selector'  => '{{WRAPPER}} .skyre-grid-read-btn a',
				'separator' => '',
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'grid_button_style_hover',
			[
				'label'     => __( 'Hover', 'skyre' ),
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		// Hover text color.
		$this->add_control(
			'grid_button_style_hover_text_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Text Color', 'skyre' ),
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .skyre-grid-read-btn a:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		// Hover background color.
		$this->add_control(
			'grid_button_style_hover_bg_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'skyre' ),
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .skyre-grid-read-btn a:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		// Hover box shadow.
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_button_style_hover_box_shadow',
				'selector'  => '{{WRAPPER}} .skyre-grid-read-btn a:hover',
				'separator' => '',
				'condition' => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Button padding.
		$this->add_control(
			'grid_button_style_padding',
			[
				'label'      => __( 'Button padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-grid-read-btn a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		// Button border radius.
		$this->add_control(
			'grid_button_style_border_radius',
			[
				'label'      => __( 'Button border radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-grid-read-btn a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'section_grid_content.grid_content_default_btn!' => '',
					'section_grid_content.grid_content_product_btn!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'grid_button_style_width',
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
					'{{WRAPPER}} .skyre-grid-read-btn a'   => 'width: {{SIZE}}%',
				],
			]
		);

		$this->end_controls_section();
	}

    /**
	 * Tabs for the Style > Add to Cart Button section.
	 */
	private function grid_content_style_addtocartbutton() {
		// Tab.
		$this->start_controls_section(
			'section_grid_cart_button_style',
			[
				'label' => __( 'Add to Cart Button', 'skyre' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'section_grid_content.grid_content_product_btn!' => '',
                    'section_grid.grid_post_type' => 'product',
				],
			]
		);
        
		// Add to cart button typography.
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'grid_cart_button_style_typography',
				'scheme'    => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .skyre-grid-addtocart  a',
				
			]
		);

		// button alignment.
		$this->add_responsive_control(
			'grid_cart_button_style_alignment',
			[
				'label'          => '<i class="fa fa-align-right"></i> ' . __( 'Alignment', 'skyre' ),
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
				'default'        => 'left',
				'tablet_default' => 'left',
				'mobile_default' => 'center',
				'selectors'      => [
					'{{WRAPPER}} .skyre-grid-addtocart' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'grid_cart_button_style' );

		// Normal tab.
		$this->start_controls_tab(
			'grid_cart_button_style_normal',
			[
				'label'     => __( 'Normal', 'skyre' ),
				
			]
		);

		// Normal text color.
		$this->add_control(
			'grid_cart_button_style_normal_text_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Text Color', 'skyre' ),
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .skyre-grid-addtocart  a' => 'color: {{VALUE}};',
				],
				
			]
		);

		// Normal background color.
		$this->add_control(
			'grid_cart_button_style_normal_bg_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'skyre' ),
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .skyre-grid-addtocart  a' => 'background-color: {{VALUE}};',
				],
				
			]
		);

		// Normal box shadow.
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_cart_button_style_normal_box_shadow',
				'selector'  => '{{WRAPPER}} .skyre-grid-addtocart  a',
				'separator' => '',
				
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'grid_cart_button_style_hover',
			[
				'label'     => __( 'Hover', 'skyre' ),
				
			]
		);

		// Hover text color.
		$this->add_control(
			'grid_cart_button_style_hover_text_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Text Color', 'skyre' ),
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .skyre-grid-addtocart  a:hover' => 'color: {{VALUE}};',
				],
				
			]
		);

		// Hover background color.
		$this->add_control(
			'grid_cart_button_style_hover_bg_color',
			[
				'type'      => \Elementor\Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'skyre' ),
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .skyre-grid-addtocart  a:hover' => 'background-color: {{VALUE}};',
				],
				
			]
		);

		// Hover box shadow.
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_cart_button_style_hover_box_shadow',
				'selector'  => '{{WRAPPER}} .skyre-grid-addtocart  a:hover',
				'separator' => '',
				
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Button padding.
		$this->add_control(
			'grid_cart_button_style_padding',
			[
				'label'      => __( 'Button padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-grid-addtocart  a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
				
			);

		// Button border radius.
		$this->add_control(
			'grid_cart_button_style_border_radius',
			[
				'label'      => __( 'Button border radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-grid-addtocart  a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);

		$this->add_responsive_control(
			'grid_cart_button_style_width',
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
					'{{WRAPPER}} .skyre-grid-addtocart  a'   => 'width: {{SIZE}}%',
				],
			]
		);


		$this->end_controls_section();
	}

	 /**
	 * Tabs for the Style > Sales label section.
	 */
	private function grid_content_style_sales_label() {
		// Tab.
		$this->start_controls_section(
			'section_grid_sales_label_style',
			[
				'label' => __( 'Sales Label', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'section_grid_content.grid_content_sale_btn!' => '',
                    'section_grid.grid_post_type' => 'product',
				],
			]
		);
		
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'sales_lable_typo',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .onsale ',
			]
		);
		
		$this->add_control(
			'sales_lable_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .onsale ' => 'color: {{VALUE}};',
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
				'name' => 'sales_lable_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .onsale ',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'sales_lable_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} .onsale ',
			]
		);
		
		
		$this->add_control(
			'sales_lable_border_radius',
			[
				'label'      => __( 'Border Radius', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px','%' ],
				'selectors'  => [
					'{{WRAPPER}} .onsale ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'sales_lable_box_shadow',
				'label' => __( 'Box Shadow', 'skyre' ),
				'selector' => '{{WRAPPER}} .onsale ',
			]
		);
		
		$this->add_control(
			'sales_lable_padding',
			[
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .onsale ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'sales_lable_size',
			[
				'label' => __( 'width', 'skyre' ),
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
					'{{WRAPPER}} .onsale' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'sales_lable_height',
			[
				'label' => __( 'Height', 'skyre' ),
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
					'{{WRAPPER}} .onsale' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'sales_lable_horizontal',
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
					'{{WRAPPER}} .onsale' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'sales_lable_vertical',
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
					'{{WRAPPER}} .onsale' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
	}

	/**
	 * Style > Pagination.
	 */
	private function grid_pagination_style_section() {
		// Tab.
		$this->start_controls_section(
			'section_grid_pagination_style',
			[
				'label'     => __( 'Pagination', 'skyre' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'section_grid.grid_pagination' => 'yes',
				],
			]
		);

		// Pagination alignment.
		$this->add_responsive_control(
			'grid_pagination_alignment',
			[
				'label'          => __( 'Alignment', 'skyre' ),
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
				'default'        => 'center',
				'tablet_default' => 'center',
				'mobile_default' => 'center',
				'selectors'      => [
					'{{WRAPPER}} .skyre-grid-pagination .pagination' => 'justify-content: {{VALUE}};',
				],
			]
		);
		// margin.
		$this->add_responsive_control(
			'grid_pagination_style_margin',
			[
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .skyre-grid-pagination .pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render function to output the post type grid.
	 */
	protected function render() {
		// Get settings.
		$settings = $this->get_settings();
		$this->load_widget_style();
		// ensure the needed scripts


		// Output.
		echo '<div class="skyre-widget-post-container '. ( ! empty( $settings['grid_style'] ) && $settings['grid_style'] == 'list' ? ' skyre-grid-style-' . $settings['grid_style'] : '' ).' ">';
		echo '<div class="row">';
		
		// Arguments for query.
		$args = array();

		// Display only published posts.
		$args['post_status'] = 'publish';

		// Ignore sticky posts.
		$args['ignore_sticky_posts'] = 1;

		// Check if post type exists.
		if ( ! empty( $settings['grid_post_type'] ) && post_type_exists( $settings['grid_post_type'] ) ) {
			$args['post_type'] = $settings['grid_post_type'];
		}

		// Display posts in category.
		if ( ! empty( $settings['grid_post_categories'] ) && $settings['grid_post_type'] == 'post' ) {
			$args['category_name'] = $settings['grid_post_categories'];
		}

		
		// Display products type.
		if ( ! empty( $settings['grid_post_filter'] ) && $settings['grid_post_type'] == 'product' ) {
			
			switch( $settings['grid_post_filter']){

				case 'sale':
					$args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
				break;
	
				case 'featured':
					$args['tax_query'][] = array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
						'operator' => 'IN',
					);
				break;
	
				case 'best_selling':
					$args['meta_key']   = 'total_sales';
					$args['orderby']    = 'meta_value_num';
					$args['order']      = 'desc';
				break;
	
				case 'top_rated': 
					$args['meta_key']   = '_wc_average_rating';
					$args['orderby']    = 'meta_value_num';
					$args['order']      = 'desc';          
				break;
	
				case 'mixed_order':
					$args['orderby']    = 'rand';
				break;
	
				default: /* Recent */
					$args['orderby']    = 'date';
					$args['order']      = 'desc';
				break;
			}
		}

		// Display products in category.
		if ( ! empty( $settings['grid_product_categories'] ) && $settings['grid_post_type'] == 'product' ) {
			$args['tax_query'] = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => $settings['grid_product_categories'],
				),
			);
		}

		// Items to display.
		if ( ! empty( $settings['grid_items'] ) && intval( $settings['grid_items'] ) == $settings['grid_items'] ) {
			$args['posts_per_page'] = $settings['grid_items'];
		}

		// Order by.
		if ( ! empty( $settings['grid_order_by'] ) ) {
			$args['orderby'] = $settings['grid_order_by'];
		}

		// Pagination.
		if ( ! empty( $settings['grid_pagination'] ) ) {
			$paged         = get_query_var( 'paged' );
			if ( empty( $paged ) ) {
				$paged         = get_query_var( 'page' );
			}
			$args['paged'] = $paged;
		}

		$grid_style = empty($settings['grid_style']) ? '' : $settings['grid_style'];

		// Query.
		$query = new \WP_Query( $args );
		

		
		// Query results.
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();

				echo '<div class="skyre-widget-post-item '  .$grid_style.' '. ( ! empty( $settings['grid_columns_mobile'] ) ? ' col-xs-' . $settings['grid_columns_mobile'] : '' ) . ( ! empty( $settings['grid_columns_tablet'] ) ? ' col-md-' . $settings['grid_columns_tablet'] : '' ) . ( ! empty( $settings['grid_columns'] ) ? ' col-lg-' . $settings['grid_columns'] : '' ) . '">';
		
				echo '<div class="post-item-inner' . ( ! has_post_thumbnail() ? ' skyre-no-image' : '' ) . '">';
				if($grid_style == 'list'){
					echo '<div class="skyre-widget-post-left">';
					$this->renderImage(); 
					echo '</div> <div class="skyre-widget-post-right">';
					foreach($settings['widget_columns'] as $column){
						if($column['column_id'] == 'Title' ) { $this->renderTitle(); continue; }
						if($column['column_id'] == 'Meta' ) { $this->renderMeta(); continue; }
						if($column['column_id'] == 'Content' ) { $this->renderContent(); continue; }
						if ( class_exists( 'WooCommerce' ) && $column['column_id'] == 'Price' ) { $this->renderPrice(); continue; }
						if($column['column_id'] == 'Button' ) { $this->renderButton(); continue; }
					}
					echo '</div><div class="clearfix"></div>';
				} elseif($grid_style == 'grid2'){
					echo '<div class="skyre-widget-post-img">';
					$this->renderImage(); 
					echo '</div> <div class="skyre-widget-post-content skpbg5 skwc"> <div class="content-wrap"> ';
					foreach($settings['widget_columns'] as $column){
						if($column['column_id'] == 'Title' ) { $this->renderTitle(); continue; }
						if($column['column_id'] == 'Meta' ) { $this->renderMeta(); continue; }
						if($column['column_id'] == 'Content' ) { $this->renderContent(); continue; }
						if ( class_exists( 'WooCommerce' ) && $column['column_id'] == 'Price' ) { $this->renderPrice(); continue; }
						if($column['column_id'] == 'Button' ) { $this->renderButton(); continue; }
					}
					echo '</div></div>';
				} else {
					foreach($settings['widget_columns'] as $column){
						if($column['column_id'] == 'Image' ) { $this->renderImage(); continue; }
						if($column['column_id'] == 'Title' ) { $this->renderTitle(); continue; }
						if($column['column_id'] == 'Meta' ) { $this->renderMeta(); continue; }
						if($column['column_id'] == 'Content' ) { $this->renderContent(); continue; }
						if ( class_exists( 'WooCommerce' ) && $column['column_id'] == 'Price' ) { $this->renderPrice(); continue; }
						if($column['column_id'] == 'Button' ) { $this->renderButton(); continue; }
					}
				}
				//echo '</div><!-- .skyre-grid-col-content -->';
				echo '</div>';
				echo '</div>';

			} // End while().
			echo '<div class="clearfix"></div>';

			// Pagination.
			if ( ! empty( $settings['grid_pagination'] ) ) { ?>
				<div class="skyre-grid-pagination">
					<?php
					$big           = 999999999;
					$totalpages    = $query->max_num_pages;
					$current       = max( 1, $paged );
					$paginate_args = array(
						'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'    => '?paged=%#%',
						'current'   => $current,
						'total'     => $totalpages,
						'show_all'  => false,
						'end_size'  => 1,
						'mid_size'  => 3,
						'prev_next' => true,
						'prev_text' => esc_html__( 'Previous', 'skyre' ),
						'next_text' => esc_html__( 'Next', 'skyre' ),
						'type'      => 'plain',
						'add_args'  => false,
					);

					$pagination = paginate_links( $paginate_args ); ?>
					<nav class="pagination">
						<?php echo $pagination; ?>
					</nav>
				</div>
				<?php
			}
		} // End if().

		// Restore original data.
		wp_reset_postdata();

		echo '</div><!-- .skyre-grid-container -->';

		echo '</div><!-- .skyre-grid -->';
	}

	/**
	 * Render image of post type.
	 */
	protected function renderImage() {
		$settings = $this->get_settings();

		// Only in editor.
		
		// Check if post type has featured image.
		if ( has_post_thumbnail() ) {

			if ( $settings['grid_image_link'] == 'yes' ) {
				?>
				<div class="skyre-grid-col-image">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php
						the_post_thumbnail(
							'full', array(
								'class' => 'img-responsive',
								'alt'   => get_the_title( get_post_thumbnail_id() ),
							)
						); ?>
					</a>
				</div>
			<?php } else { ?>
				<div class="skyre-grid-col-image">
					<?php
					the_post_thumbnail(
						'full', array(
							'class' => 'img-responsive',
							'alt'   => get_the_title( get_post_thumbnail_id() ),
						)
					); ?>
				</div>
				<?php
			}
		}
		
	}

	/**
	 * Render title of post type.
	 */
	protected function renderTitle() {
		$settings = $this->get_settings();

		?>
		<<?php echo $settings['grid_title_tag']; ?> class=" skyre-grid-title">
		<?php if ( $settings['grid_title_link'] == 'yes' ) { ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php the_title(); ?>
			</a>
			<?php
		} else {
			the_title();
		} ?>
		</<?php echo $settings['grid_title_tag']; ?>>
		<?php
		
	}

	/**
	 * Render meta of post type.
	 */
	protected function renderMeta() {
		$settings = $this->get_settings();
		
		if ( ! empty( $settings['grid_meta_display'] ) ) { ?>
			<div class="entry-meta skyre-grid-meta">

				<?php
				foreach ( $settings['grid_meta_display'] as $meta ) {

					switch ( $meta ) :
						// Author
						case 'author': ?>
							<span class="skyre-grid-author">
								<?php
								echo ( $settings['grid_meta_remove_icons'] == '' ) ? '<i class="fa fa-user"></i>' : '';

								echo get_the_author(); ?>
							</span>
							<?php
							// Date
							break;
						case 'date': ?>
							<span class="skyre-grid-date">
								<?php
								echo ( $settings['grid_meta_remove_icons'] == '' ) ? '<i class="fa fa-calendar"></i>' : '';
								echo get_the_date(); ?>
							</span>
							<?php
							// Category
							break;
						case 'category':
							$this->renderMetaGridCategories();

							// Tags
							break;
						case 'tags':
							$this->renderMetaGridTags();

							// Comments/Reviews
							break;
						case 'comments': ?>
							
								<?php
								

								if ( $settings['grid_post_type'] == 'product' ) {
									$product  = wc_get_product( get_the_ID() );
?>
									<span class="woocommerce">
										<?php if ($average = $product->get_average_rating()) : ?>
										<?php echo '<span class="star-rating" title="'.sprintf(__( 'Rated %s out of 5', 'woocommerce' ), $average).'"><span style="width:'.( ( $average / 5 ) * 100 ) . '%">  &nbsp;</span> </span>'; ?>
										<?php endif; ?>
								</span> 
<?php
									//echo comments_number( __( 'No reviews', 'skyre' ), __( '1 review', 'skyre' ), __( '% reviews', 'skyre' ) );
								} else {
									echo '<span class="skyre-grid-comments">';
									echo ( $settings['grid_meta_remove_icons'] == '' ) ? '<i class="fa fa-comment"></i>' : '';
									echo comments_number( __( 'No comments', 'skyre' ), __( '1 comment', 'skyre' ), __( '% comments', 'skyre' ) );
									echo '</span>';
								} ?>
							
							<?php
							break;
					endswitch;
				} // End foreach().?>

			</div>
			<?php
		}// End if().
	}

	/**
	 * Display price if post type is product.
	 */
	protected function renderPrice() {

		if ( ! function_exists( 'wc_get_product' ) ) {
			return null;
		}

		$settings = $this->get_settings();
		$product  = wc_get_product( get_the_ID() );

		if ( $settings['grid_post_type'] == 'product')  { ?>
			<div class="skyre-grid-price">
				<?php
				$price = $product->get_price_html();
				if ( ! empty( $price ) ) {
					echo wp_kses(
						$price, array(
							'span' => array(
								'class' => array(),
							),
							'del'  => array(),
						)
					);
				} ?>
			</div>
			<?php
		}
	}

	/**
	 * Display Add to Cart button.
	 */
	protected function renderAddToCart() {

		if ( ! function_exists( 'wc_get_product' ) ) {
			return null;
		}

		$product = wc_get_product( get_the_ID() );

		echo apply_filters(
			'woocommerce_loop_add_to_cart_link',
			sprintf(
				'<a href="%s" title="%s" rel="nofollow">%s</a>',
				esc_url( $product->add_to_cart_url() ),
				esc_attr( $product->add_to_cart_text() ),
				esc_html( $product->add_to_cart_text() )
			), $product
		);
	}

	/**
	 * Display Add to Cart button.
	 */
	protected function renderSaleButton() {

		if ( ! function_exists( 'wc_get_product' ) ) {
			return null;
		}
		$settings = $this->get_settings();
		$product  = wc_get_product( get_the_ID() );
		if ( $settings['grid_post_type'] == 'product' && $settings['grid_content_sale_btn'] == 'yes' &&  $product->is_on_sale() ) {
			echo '<span class="onsale sksbg skwc"> '.$settings['grid_content_sale_btn_text'].'</span>';
		}

		
	}

	

	/**
	 * Render content of post type.
	 */
	protected function renderContent() {
		$settings = $this->get_settings();
		 ?>
		<div class="entry-content skyre-grid-content">
			<?php
			if( $settings['grid_content_full_post'] === 'yes' ) {
				the_content();
			} else {
				if ( empty( $settings['grid_content_length'] ) ) {
					the_excerpt();
				} else {
					echo wp_trim_words( get_the_excerpt(), $settings['grid_content_length'] );
				}
			}?>
		</div>
		<?php
		
	}

	/**
	 * Render button of post type.
	 */
	protected function renderButton() {
		$settings = $this->get_settings();

		$this->renderSaleButton();

		if ( $settings['grid_post_type'] == 'product' && $settings['grid_content_product_btn'] == 'yes' ) { ?>
			<div class="skyre-grid-addtocart ">
				<?php $this->renderAddToCart(); ?>
			</div>
		<?php }
		if ( $settings['grid_content_default_btn'] == 'yes' && ! empty( $settings['grid_content_default_btn_text'] ) ) { ?>
			<div class="skyre-grid-read-btn">
				<a href="<?php echo get_the_permalink(); ?>"
				   title="<?php echo $settings['grid_content_default_btn_text']; ?>"><?php echo $settings['grid_content_default_btn_text']; ?></a>
			</div>
			<?php
		}
	}

	/**
	 * Display categories in meta section.
	 */
	protected function renderMetaGridCategories() {
		$settings           = $this->get_settings();
		 
		 
		 if ( $settings['grid_post_type'] == 'product'){
			$pid = get_the_ID();
		 	$post_type_category = get_the_terms ( $pid, 'product_cat' );
		 }else { $post_type_category = get_the_category(); }
		
		//print_r( $terms);
		
		 $maxCategories      = $settings['grid_meta_categories_max'] ? $settings['grid_meta_categories_max'] : '-1';
		$i                  = 0; // counter

		if ( $post_type_category ) { ?>
			<span class="skyre-grid-categories">
				<?php
				echo ( $settings['grid_meta_remove_icons'] == '' ) ? '<i class="fa fa-bookmark"></i>' : '';

				foreach ( $post_type_category as $category ) {
					if ( $i == $maxCategories ) {
						break;
					} ?>
					<span class="skyre-grid-categories-item">
						<a href="<?php echo get_category_link( $category->term_id ); ?>"
						   title="<?php echo $category->name; ?>">
							<?php echo $category->name; ?>
						</a>
					</span>
					<?php
					$i ++;
				} ?>
			</span>
			<?php
		}
	}

	/**
	 * Display tags in meta section.
	 */
	protected function renderMetaGridTags() {
		$settings       = $this->get_settings();
		
		if ( $settings['grid_post_type'] == 'product'){
			$pid = get_the_ID();
		 	$post_type_tags = get_the_terms ( $pid, 'product_tag' );
		 }else { $post_type_tags = get_the_tags(); }
		

		$maxTags        = $settings['grid_meta_tags_max'] ? $settings['grid_meta_tags_max'] : '-1';
		$i              = 0; // counter
		if ( $post_type_tags ) { ?>
			<span class="skyre-grid-tags">
				<?php
				echo ( $settings['grid_meta_remove_icons'] == '' ) ? '<i class="fa fa-tags"></i>' : '';

				foreach ( $post_type_tags as $tag ) {
					if ( $i == $maxTags ) {
						break;
					} ?>
					<span class="skyre-grid-tags-item">
						<a href="<?php echo get_tag_link( $tag->term_id ); ?>" title="<?php echo $tag->name; ?>">
							<?php echo $tag->name; ?>
						</a>
					</span>
					<?php
					$i ++;
				} ?>
			</span>
			<?php
		}
	}

	/**
	 * Load the widget style dynamically if it is a widget preview
	 * or enqueue style and scripts if not
	 *
	 * This way we are sure that the assets files are loaded only when this block is present in page.
	 */
	protected function load_widget_style() {
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() === true ) { ?>
			<style>
				<?php echo file_get_contents( get_template_directory_uri() . '/inc/assets/style/elementor-posts-grid.css' ) ?>
			</style>
			<?php
		} else {
			wp_enqueue_script( 'skyre-posts-grid' );
			wp_enqueue_style( 'skyre-posts-grid' );
		}
	
		
			
		
	}
}

