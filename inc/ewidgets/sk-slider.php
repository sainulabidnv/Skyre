<?php
/**
 * Slider widget for Elementor builder
 *
 * @package     Skyre
 * @author      Skyretheme
 * @copyright   Copyright (c) 2019, Skyre
 * @link        https://skyretheme.com/sports
 * @since       1.0.0
 *
 */

namespace ewidget\Widgets;

use Elementor\Skyre_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class skyreSlider extends Skyre_Base {

	
	public function get_name() {
		return 'sk-slider';
	}

	public function get_title() {
		return esc_html__( 'Slider', 'skyre' );
	}

	public function get_icon() {
		return 'eicon-post-slider';
	}

	public function get_categories() {
		return array( 'skyre' );
	}

	public function get_script_depends() {
		return array( 'imagesloaded', 'sliderPro', 'sliderCustom' );
	}

	
	/**
	 * Return availbale arrows list
	 * @return [type] [description]
	 */
	public function get_slider_arrows_list() {

		return apply_filters(
			'slider_arrows_list',
			array(
				'fa fa-angle-left'          => __( 'Angle', 'skyre' ),
				'fa fa-chevron-left'        => __( 'Chevron', 'skyre' ),
				'fa fa-angle-double-left'   => __( 'Angle Double', 'skyre' ),
				'fa fa-arrow-left'          => __( 'Arrow', 'skyre' ),
				'fa fa-caret-left'          => __( 'Caret', 'skyre' ),
				'fa fa-long-arrow-left'     => __( 'Long Arrow', 'skyre' ),
				'fa fa-arrow-circle-left'   => __( 'Arrow Circle', 'skyre' ),
				'fa fa-chevron-circle-left' => __( 'Chevron Circle', 'skyre' ),
				'fa fa-caret-square-o-left' => __( 'Caret Square', 'skyre' ),
			)
		);

	}

	protected function _register_controls() {

		$css_scheme = array(
				'instance'            => '.sk-slider',
				'content_wrapper'     => '.sk-slider__content',
				'content_item'        => '.sk-slider__content-item',
				'content_inner'       => '.sk-slider__content-inner',
				'secContent_wrapper'     => '.sk-slider__secContent',
				'secContent_item'        => '.sk-slider__secContent-item',
				'secContent_inner'       => '.sk-slider__secContent-inner',
				'instance_slider'     => '.sk-slider .slider-pro',
				'navigation'          => '.sk-slider .sp-arrows',
				'pagination'          => '.sk-slider .sp-buttons',
				'icon'                => '.sk-slider__icon',
				'title'               => '.sk-slider__title',
				'subtitle'            => '.sk-slider__subtitle',
				'desc'                => '.sk-slider__desc',
				'buttons_wrapper'     => '.sk-slider__button-wrapper',
				'primary_button'      => '.sk-slider__button--primary',
				'secondary_button'    => '.sk-slider__button--secondary',
				'overlay'             => '.sk-slider .sp-image-container:after',
				'fullscreen'          => '.sk-slider .sp-full-screen-button',
				'thumbnails'          => '.sk-slider .sp-thumbnails-container',
				'thumbnail_container' => '.sk-slider .sp-thumbnail-container',
			
		);

		$this->start_controls_section(
			'section_items_data',
			array(
				'label' => esc_html__( 'Items', 'skyre' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_image',
			array(
				'label'   => esc_html__( 'Image', 'skyre' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'dynamic' => array( 'active' => true ),
			)
		);
		$repeater->add_control(
			'second_content',
			array(
				'label'   => esc_html__( 'Secondary Content', 'skyre' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => '',
			)
		);

		$repeater->add_control(
			'item_icon',
			array(
				'label'       => esc_html__( 'Icon', 'skyre' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'file'        => '',
			)
		);

		$repeater->add_control(
			'item_title',
			array(
				'label'   => esc_html__( 'Title', 'skyre' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'item_subtitle',
			array(
				'label'   => esc_html__( 'Subtitle', 'skyre' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array( 'active' => true ),
			)
		);


		$repeater->add_control(
			'item_desc',
			array(
				'label'   => esc_html__( 'Description', 'skyre' ),
				'type'    => Controls_Manager::TEXTAREA,
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'item_button_primary_url',
			array(
				'label'   => esc_html__( 'Primary Button URL', 'skyre' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => array(
					'active' => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
			)
		);

		$repeater->add_control(
			'item_button_primary_text',
			array(
				'label'   => esc_html__( 'Primary Button Text', 'skyre' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'More', 'skyre' ),
			)
		);

		$repeater->add_control(
			'item_button_secondary_url',
			array(
				'label'   => esc_html__( 'Secondary Button URL', 'skyre' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => array(
					'active' => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
			)
		);

		$repeater->add_control(
			'item_button_secondary_text',
			array(
				'label'   => esc_html__( 'Secondary Button Text', 'skyre' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$this->add_control(
			'item_list',
			array(
				'type'        => Controls_Manager::REPEATER,
				'fields'      => array_values( $repeater->get_controls() ),
				'default'     => array(
					array(
						'item_image'                 => array(
							'url' => Utils::get_placeholder_image_src(),
						),
						'item_title'                 => esc_html__( 'Slide #1', 'skyre' ),
						'item_subtitle'              => esc_html__( 'SubTitle', 'skyre' ),
						'item_desc'                  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'skyre' ),
						'item_button_primary_url'    => '#',
						'item_button_primary_text'   => esc_html__( 'Button #1', 'skyre' ),
						'item_button_secondary_ulr'  => '#',
						'item_button_secondary_text' => esc_html__( 'Button #2', 'skyre' ),
						),
					array(
						'item_image'                 => array(
							'url' => Utils::get_placeholder_image_src(),
						),
						'item_title'                 => esc_html__( 'Slide #2', 'skyre' ),
						'item_subtitle'              => esc_html__( 'SubTitle', 'skyre' ),
						'item_desc'                  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'skyre' ),
						'item_button_primary_url'    => '#',
						'item_button_primary_text'   => esc_html__( 'Button #1', 'skyre' ),
						'item_button_secondary_ulr'  => '#',
						'item_button_secondary_text' => esc_html__( 'Button #2', 'skyre' ),
					),
					array(
						'item_image'                 => array(
							'url' => Utils::get_placeholder_image_src(),
						),
						'item_title'                 => esc_html__( 'Slide #3', 'skyre' ),
						'item_subtitle'              => esc_html__( 'SubTitle', 'skyre' ),
						'item_desc'                  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'skyre' ),
						'item_button_primary_url'    => '#',
						'item_button_primary_text'   => esc_html__( 'Button #1', 'skyre' ),
						'item_button_secondary_ulr'  => '#',
						'item_button_secondary_text' => esc_html__( 'Button #2', 'skyre' ),
					),

				),
				'title_field' => '{{{ item_title }}}',
			)
		);
		

		$this->end_controls_section();

		$this->start_controls_section(
			'section_settings',
			array(
				'label' => esc_html__( 'Settings', 'skyre' ),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'    => 'slider_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
				'default' => 'full',
			)
		);

		$this->add_control(
			'slider_navigation',
			array(
				'label'        => esc_html__( 'Use navigation?', 'skyre' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'skyre' ),
				'label_off'    => esc_html__( 'No', 'skyre' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'slider_navigation_on_hover',
			array(
				'label'        => esc_html__( 'Indicates whether the arrows will fade in only on hover', 'skyre' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'skyre' ),
				'label_off'    => esc_html__( 'No', 'skyre' ),
				'return_value' => 'true',
				'default'      => 'false',
				'condition' => array(
					'slider_navigation' => 'true',
				),
			)
		);

		$this->add_control(
			'slider_pagination',
			array(
				'label'        => esc_html__( 'Use pagination?', 'skyre' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'skyre' ),
				'label_off'    => esc_html__( 'No', 'skyre' ),
				'return_value' => 'true',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'slider_autoplay',
			array(
				'label'        => esc_html__( 'Use autoplay?', 'skyre' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'skyre' ),
				'label_off'    => esc_html__( 'No', 'skyre' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'slider_autoplay_delay',
			array(
				'label'   => esc_html__( 'Autoplay delay(ms)', 'skyre' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5000,
				'min'     => 2000,
				'max'     => 10000,
				'step'    => 100,
				'condition' => array(
					'slider_autoplay' => 'true',
				),
			)
		);

		$this->add_control(
			'slide_autoplay_on_hover',
			array(
				'label'   => esc_html__( 'Autoplay On Hover', 'skyre' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'pause',
				'options' => array(
					'none'  => esc_html__( 'None', 'skyre' ),
					'pause' => esc_html__( 'Pause', 'skyre' ),
					'stop'  => esc_html__( 'Stop', 'skyre' ),
				),
			)
		);

		$this->add_control(
			'slider_fullScreen',
			array(
				'label'        => esc_html__( 'Display fullScreen button?', 'skyre' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'skyre' ),
				'label_off'    => esc_html__( 'No', 'skyre' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'slider_shuffle',
			array(
				'label'        => esc_html__( 'Indicates if the slides will be shuffled', 'skyre' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'skyre' ),
				'label_off'    => esc_html__( 'No', 'skyre' ),
				'return_value' => 'true',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'slider_loop',
			array(
				'label'        => esc_html__( 'Indicates if the slides will be looped', 'skyre' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'skyre' ),
				'label_off'    => esc_html__( 'No', 'skyre' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'slider_fade_mode',
			array(
				'label'        => esc_html__( 'Use fade effect?', 'skyre' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'skyre' ),
				'label_off'    => esc_html__( 'No', 'skyre' ),
				'return_value' => 'true',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'slide_distance',
			array(
				'label' => esc_html__( ' Between Slides Distance', 'skyre' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default' => array(
					'unit' => 'px',
					'size' => 10,
				),
			)
		);

		$this->add_control(
			'slide_duration',
			array(
				'label'   => esc_html__( 'Slide Duration(ms)', 'skyre' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 500,
				'min'     => 100,
				'max'     => 5000,
				'step'    => 100,
			)
		);

		$this->add_control(
			'thumbnails',
			array(
				'label'        => esc_html__( 'Display thumbnails?', 'skyre' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'skyre' ),
				'label_off'    => esc_html__( 'No', 'skyre' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'thumbnail_width',
			array(
				'label'   => esc_html__( 'Thumbnail width(px)', 'skyre' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 120,
				'min'     => 20,
				'max'     => 200,
				'step'    => 1,
				'condition' => array(
					'thumbnails' => 'true',
				),
			)
		);

		$this->add_control(
			'thumbnail_height',
			array(
				'label'   => esc_html__( 'Thumbnail height(px)', 'skyre' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 80,
				'min'     => 20,
				'max'     => 200,
				'step'    => 1,
				'condition' => array(
					'thumbnails' => 'true',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * General Style Section
		 */
		$this->start_controls_section(
			'section_slider_general_style',
			array(
				'label'      => esc_html__( 'General', 'skyre' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'slider_width',
			array(
				'label' => esc_html__( 'Slider Width(%)', 'skyre' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => array(
					'%' => array(
						'min' => 50,
						'max' => 100,
					),
				),
				'default' => array(
					'unit' => '%',
					'size' => 100,
				),
			)
		);

		$this->add_responsive_control(
			'slider_height',
			array(
				'label' => esc_html__( 'Slider Height(px)', 'skyre' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'vh',
				),
				'range' => array(
					'px' => array(
						'min' => 300,
						'max' => 1000,
					),
					'vh' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'default' => array(
					'unit' => 'px',
					'size' => 600,
				),
			)
		);

		$this->add_responsive_control(
			'slider_container_width',
			array(
				'label' => esc_html__( 'Slider Container Width(%)', 'skyre' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => array(
					'%', 'px',
				),
				'range' => array(
					'%' => array(
						'min' => 20,
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
					'{{WRAPPER}} ' . $css_scheme['instance_slider']  => 'max-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} ' . $css_scheme['pagination'] => 'max-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'slide_image_scale_mode',
			array(
				'label'   => esc_html__( 'Image Scale Mode', 'skyre' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'exact',
				'options' => array(
					'exact'   => esc_html__( 'Cover', 'skyre' ),
					'contain' => esc_html__( 'Contain', 'skyre' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'slider_background',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_2,
						),
					),
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance_slider'] . ' .sk-slider__item',
				'condition' => array(
					'slide_image_scale_mode' => 'contain',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Container Style Section
		 */
		$this->start_controls_section(
			'section_slider_container_style',
			array(
				'label'      => esc_html__( 'Container', 'skyre' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'container_padding',
			array(
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'container_margin',
			array(
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'container_border',
				'label'       => esc_html__( 'Border', 'skyre' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['instance'],
			)
		);

		$this->add_control(
			'container_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] . ' .sk-slider__item'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'container_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance'],
			)
		);

		$this->end_controls_section();

		/**
		 * Content Slider Section
		 */
		$this->start_controls_section(
			'section_content_slider_style',
			array(
				'label'      => esc_html__( 'Content', 'skyre' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'slider_content_width',
			array(
				'label'      => esc_html__( 'Width', 'skyre' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
				),
				'range'      => array(
					'%' => array(
						'min' => 1,
						'max' => 100,

					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['content_inner']  => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);
		
		$this->add_responsive_control(
			'slider_content_horizontal_alignment',
			array(
				'label'   => esc_html__( 'Horizontal Alignment', 'skyre' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'flex-start' => array(
						'title' => esc_html__( 'Start', 'skyre' ),
						'icon'  => ! is_rtl() ? 'eicon-h-align-left' : 'eicon-h-align-right',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'skyre' ),
						'icon'  => 'eicon-h-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'End', 'skyre' ),
						'icon'  => ! is_rtl() ? 'eicon-h-align-right' : 'eicon-h-align-left',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['content_item'] => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_content_vertical_alignment',
			array(
				'label'   => esc_html__( 'Vertical Alignment', 'skyre' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'flex-start' => array(
						'title' => esc_html__( 'Top', 'skyre' ),
						'icon'  => 'eicon-v-align-top',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'skyre' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Bottom', 'skyre' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['content_wrapper'] => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'slider_content_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['content_inner'],
			)
		);

		$this->add_responsive_control(
			'slider_content_padding',
			array(
				'label'      => esc_html__( 'Padding', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['content_inner'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_content_margin',
			array(
				'label'      => esc_html__( 'Margin', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['content_inner'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'slider_content_border',
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['content_inner'],
			)
		);

		$this->add_control(
			'slider_content_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['content_inner'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'slider_content_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['content_inner'],
			)
		);
		
		$this->add_control(
			'slider_content_animation',
			array(
				'label'   => esc_html__( 'Animation', 'skyre' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''  => esc_html__( 'None', 'skyre' ),
					'left' => esc_html__( 'Left', 'skyre' ),
					'right' => esc_html__( 'Right', 'skyre' ),
					'up' => esc_html__( 'Up', 'skyre' ),
					'down' => esc_html__( 'Down', 'skyre' ),
					'inf-upDown' => esc_html__( 'Infinit Up Down', 'skyre' ),
					'inf-scale' => esc_html__( 'Infinit Scaling', 'skyre' ),
					
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Secondary Image Slider Section
		 */
		$this->start_controls_section(
			'section_secContent_slider_style',
			array(
				'label'      => esc_html__( 'Secondary Content', 'skyre' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'slider_secContent_width',
			array(
				'label'      => esc_html__( 'Box Width', 'skyre' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'%', 'em', 'px',
				),
				'range'      => array(
					'%' => array(
						'min' => 1,
						'max' => 100,

					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['secContent_inner']  => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);
		
		$this->add_responsive_control(
			'slider_secContent_height',
			array(
				'label'      => esc_html__( 'Box Height', 'skyre' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'%', 'em', 'px',
				),
				'range'      => array(
					'%' => array(
						'min' => 1,
						'max' => 100,

					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['secContent_inner']  => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);
		
		/*$this->add_responsive_control(
			'slider_secContent_text_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'skyre' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left' => array(
						'title' => esc_html__( 'Left', 'skyre' ),
						'icon'  => ! is_rtl() ? 'eicon-h-align-left' : 'eicon-h-align-right',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'skyre' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'skyre' ),
						'icon'  => ! is_rtl() ? 'eicon-h-align-right' : 'eicon-h-align-left',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['secContent_inner'].' p' => 'text-align: {{VALUE}};',
				),
			)
		);*/
		
		$this->add_responsive_control(
			'slider_secContent_horizontal_alignment',
			array(
				'label'   => esc_html__( 'Horizontal Alignment', 'skyre' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'flex-start' => array(
						'title' => esc_html__( 'Start', 'skyre' ),
						'icon'  => ! is_rtl() ? 'eicon-h-align-left' : 'eicon-h-align-right',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'skyre' ),
						'icon'  => 'eicon-h-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'End', 'skyre' ),
						'icon'  => ! is_rtl() ? 'eicon-h-align-right' : 'eicon-h-align-left',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['secContent_item'] => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_secContent_vertical_alignment',
			array(
				'label'   => esc_html__( 'Vertical Alignment', 'skyre' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'flex-start' => array(
						'title' => esc_html__( 'Top', 'skyre' ),
						'icon'  => 'eicon-v-align-top',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'skyre' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Bottom', 'skyre' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['secContent_wrapper'] => 'justify-content: {{VALUE}};',
				),
			)
		);
		
		
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'slider_secContent_typo',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['secContent_inner'],
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'slider_secContent_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['secContent_inner'],
			)
		);

		$this->add_responsive_control(
			'slider_secContent_padding',
			array(
				'label'      => esc_html__( 'Padding', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['secContent_inner'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_secContent_margin',
			array(
				'label'      => esc_html__( 'Margin', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['secContent_inner'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'slider_secContent_border',
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['secContent_inner'],
			)
		);

		$this->add_control(
			'slider_secContent_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['secContent_inner'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(

			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'slider_secContent_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['secContent_inner'],
			)
		);
		
		$this->add_control(
			'slider_secContent_animation',
			array(
				'label'   => esc_html__( 'Animation', 'skyre' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''  => esc_html__( 'None', 'skyre' ),
					'left' => esc_html__( 'Left', 'skyre' ),
					'right' => esc_html__( 'Right', 'skyre' ),
					'up' => esc_html__( 'Up', 'skyre' ),
					'down' => esc_html__( 'Down', 'skyre' ),
					'inf-upDown' => esc_html__( 'Infinit Up Down', 'skyre' ),
					'inf-scale' => esc_html__( 'Infinit Scaling', 'skyre' ),
					
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Overlay Style Section
		 */
		$this->start_controls_section(
			'section_images_layout_overlay_style',
			array(
				'label'      => esc_html__( 'Overlay', 'skyre' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'overlay_background',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_2,
						),
					),
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['overlay'],
			)
		);

		$this->add_control(
			'overlay_opacity',
			array(
				'label'    => esc_html__( 'Opacity', 'skyre' ),
				'type'     => Controls_Manager::NUMBER,
				'default'  => 0.2,
				'min'      => 0,
				'max'      => 1,
				'step'     => 0.1,
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['overlay'] => 'opacity: {{VALUE}};',
				),

			)
		);

		$this->end_controls_section();
		
		/**
		 * Navigation Style Section
		 */
		$this->start_controls_section(
			'section_slider_navigation_style',
			array(
				'label'      => esc_html__( 'Navigation', 'skyre' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'slider_navigation_icon_arrow',
			array(
				'label'   => esc_html__( 'Arrow Icon', 'skyre' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'fa fa-angle-left',
				'options' => $this->get_slider_arrows_list(),
				'condition' => array(
					'slider_navigation' => 'true',
				),
			)
		);

		$this->start_controls_tabs( 'navigation_style_tabs' );

		$this->start_controls_tab(
			'tab_normal_navigation_styles',
			array(
				'label' => esc_html__( 'Normal', 'skyre' ),
			)
		);

		$this->add_control(
			'normal_navigation_color',
			array(
				'label' => esc_html__( 'Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['navigation'] . ' .sp-arrow i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'normal_navigation_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['navigation'] . ' .sp-arrow' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'normal_navigation_font_size',
			array(
				'label'      => esc_html__( 'Font Size', 'skyre' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', 'rem',
				),
				'range'      => array(
					'px' => array(
						'min' => 18,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['navigation'] . ' .sp-arrow i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'normal_navigation_size',
			array(
				'label'      => esc_html__( 'Box Size', 'skyre' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 18,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['navigation'] . ' .sp-arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'normal_navigation_border',
				'label'       => esc_html__( 'Border', 'skyre' ),
				'placeholder' => '1px',
				'default'     => '0px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['navigation'] . ' .sp-arrow',
			)
		);

		$this->add_control(
			'normal_navigation_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['navigation'] . ' .sp-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'normal_navigation_box_margin',
			array(
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['navigation']. ' .sp-arrow' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'normal_navigation_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['navigation'] . ' .sp-arrow',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_hover_navigation_styles',
			array(
				'label' => esc_html__( 'Hover', 'skyre' ),
			)
		);

		$this->add_control(
			'hover_navigation_color',
			array(
				'label' => esc_html__( 'Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['navigation'] . ' .sp-arrow:hover i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'hover_navigation_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['navigation'] . ' .sp-arrow:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'hover_navigation_font_size',
			array(
				'label'      => esc_html__( 'Font Size', 'skyre' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', 'rem',
				),
				'range'      => array(
					'px' => array(
						'min' => 18,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['navigation'] . ' .sp-arrow:hover i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'hover_navigation_size',
			array(
				'label'      => esc_html__( 'Box Size', 'skyre' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 18,
						'max' => 200,

					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['navigation'] . ' .sp-arrow:hover' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'hover_navigation_border',
				'label'       => esc_html__( 'Border', 'skyre' ),
				'placeholder' => '1px',
				'default'     => '0px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['navigation'] . ' .sp-arrow:hover',
			)
		);

		$this->add_control(
			'hover_navigation_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['navigation'] . ' .sp-arrow:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'hover_navigation_box_margin',
			array(
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['navigation']. ' .sp-arrow:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'hover_navigation_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['navigation'] . ' .sp-arrow:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Pagination Style Section
		 */
		$this->start_controls_section(
			'section_pagination_style',
			array(
				'label'      => esc_html__( 'Pagination', 'skyre' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		

		$this->add_responsive_control(
			'pagination_padding',
			array(
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['pagination'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'pagination_dots_margin',
			array(
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['pagination'] . ' .sp-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'pagination_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'skyre' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left' => array(
						'title' => esc_html__( 'Left', 'skyre' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'skyre' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'skyre' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['pagination'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'pagination_container_offset',
			array(
				'label'   => esc_html__( 'Pagination Container Offset', 'skyre' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => -500,
				'max'     => 500,
				'step'    => 1,
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['pagination'] => 'margin-top: {{VALUE}}px;',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Thumbnails Style Section
		 */
		$this->start_controls_section(
			'section_thumbnails_style',
			array(
				'label'      => esc_html__( 'Thumbnails', 'skyre' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'thumbnail_item_margin',
			array(
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumbnail_container'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'   => 'before',
				'render_type' => 'template',
			)
		);

		$this->add_control(
			'thumbnails_container_offset',
			array(
				'label'   => esc_html__( 'Thumbnails Container Offset', 'skyre' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => -500,
				'max'     => 500,
				'step'    => 1,
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumbnails'] => 'margin-top: {{VALUE}}px;',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_thumbnails_style' );

		$this->start_controls_tab(
			'tab_thumbnails_normal',
			array(
				'label' => esc_html__( 'Normal', 'skyre' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'thumbnails_normal_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['thumbnail_container'] . ':before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'thumbnails_normal_border',
				'label'       => esc_html__( 'Border', 'skyre' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['thumbnail_container'] . ':before',
				'fields_options' => array(
					'border' => array(
						'default' => '',
					),
					'width' => array(
						'default' => array(
							'top'      => '2',
							'right'    => '2',
							'bottom'   => '2',
							'left'     => '2',
							'isLinked' => true,
						),
					),
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_1,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_thumbnails_hover',
			array(
				'label' => esc_html__( 'Hover', 'skyre' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'thumbnails_hover_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['thumbnail_container'] . ':hover:before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'thumbnails_hover_border',
				'label'       => esc_html__( 'Border', 'skyre' ),
				'placeholder' => '2px',
				'default'     => '2px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['thumbnail_container'] . ':hover:before',
				'fields_options' => array(
					'border' => array(
						'default' => 'solid',
					),
					'width' => array(
						'default' => array(
							'top'      => '2',
							'right'    => '2',
							'bottom'   => '2',
							'left'     => '2',
							'isLinked' => true,
						),
					),
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_2,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_thumbnails_active',
			array(
				'label' => esc_html__( 'Active', 'skyre' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'thumbnails_active_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['thumbnail_container'] . '.sp-selected-thumbnail:before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'thumbnails_active_border',
				'label'       => esc_html__( 'Border', 'skyre' ),
				'placeholder' => '2px',
				'default'     => '2px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['thumbnail_container'] . '.sp-selected-thumbnail:before',
				'fields_options' => array(
					'border' => array(
						'default' => 'solid',
					),
					'width' => array(
						'default' => array(
							'top'      => '2',
							'right'    => '2',
							'bottom'   => '2',
							'left'     => '2',
							'isLinked' => true,
						),
					),
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_1,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Fullscreen Style Section
		 */
		$this->start_controls_section(
			'section_slider_fullscreen_style',
			array(
				'label'      => esc_html__( 'Fullscreen', 'skyre' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'slider_fullscreen_icon',
			array(
				'label'       => esc_html__( 'Icon', 'skyre' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'file'        => '',
				'default'     => 'fa fa-arrows-alt',
			)
		);

		$this->add_control(
			'fullscreen_icon_color',
			array(
				'label' => esc_html__( 'Icon Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['fullscreen'] . ' i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'fullscreen_icon_bg_color',
			array(
				'label' => esc_html__( 'Icon Background Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['fullscreen'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'fullscreen_icon_font_size',
			array(
				'label'      => esc_html__( 'Icon Font Size', 'skyre' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', 'rem',
				),
				'range'      => array(
					'px' => array(
						'min' => 18,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['fullscreen'] . ' i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'fullscreen_icon_size',
			array(
				'label'      => esc_html__( 'Icon Box Size', 'skyre' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 18,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['fullscreen'] => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'fullscreen_icon_border',
				'label'       => esc_html__( 'Border', 'skyre' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['fullscreen'],
			)
		);

		$this->add_control(
			'fullscreen_icon_box_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['fullscreen'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'fullscreen_icon_box_margin',
			array(
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['fullscreen'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'fullscreen_icon_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['fullscreen'],
			)
		);

		$this->end_controls_section();

		/**
		 * Icon Style Section
		 */
		$this->start_controls_section(
			'section_slider_icon_style',
			array(
				'label'      => esc_html__( 'Icon', 'skyre' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label' => esc_html__( 'Icon Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'icon_bg_color',
			array(
				'label' => esc_html__( 'Icon Background Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' .sk-slider-icon-inner' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'icon_font_size',
			array(
				'label'      => esc_html__( 'Icon Font Size', 'skyre' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', 'rem',
				),
				'range'      => array(
					'px' => array(
						'min' => 18,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'      => esc_html__( 'Icon Box Size', 'skyre' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 18,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' .sk-slider-icon-inner' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'icon_border',
				'label'       => esc_html__( 'Border', 'skyre' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['icon'] . ' .sk-slider-icon-inner',
			)
		);

		$this->add_control(
			'icon_box_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' .sk-slider-icon-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_box_margin',
			array(
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' .sk-slider-icon-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'icon_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['icon'] . ' .sk-slider-icon-inner',
			)
		);

		$this->add_responsive_control(
			'icon_box_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'skyre' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
						'title' => esc_html__( 'Left', 'skyre' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'skyre' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Right', 'skyre' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Title Style Section
		 */
		$this->start_controls_section(
			'section_slider_title_style',
			array(
				'label'      => esc_html__( 'Title', 'skyre' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'slider_title_color',
			array(
				'label'  => esc_html__( 'Title Color', 'skyre' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'slider_title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['title'],
			)
		);

		$this->add_responsive_control(
			'slider_title_padding',
			array(
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_title_margin',
			array(
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'slider_title_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['title'],
			)
		);

		$this->add_responsive_control(
			'slider_title_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'skyre' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'skyre' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'skyre' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'skyre' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * SubTitle Style Section
		 */
		$this->start_controls_section(
			'section_slider_subtitle_style',
			array(
				'label'      => esc_html__( 'Subtitle', 'skyre' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'slider_subtitle_color',
			array(
				'label'  => esc_html__( 'Subtitle Color', 'skyre' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['subtitle'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'slider_subtitle_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['subtitle'],
			)
		);

		$this->add_responsive_control(
			'slider_subtitle_padding',
			array(
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['subtitle'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_subtitle_margin',
			array(
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['subtitle'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'slider_subtitle_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['subtitle'],
			)
		);

		$this->add_responsive_control(
			'slider_subtitle_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'skyre' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'skyre' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'skyre' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'skyre' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['subtitle'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Desc Style Section
		 */
		$this->start_controls_section(
			'section_slider_desc_style',
			array(
				'label'      => esc_html__( 'Description', 'skyre' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'slider_desc_color',
			array(
				'label'  => esc_html__( 'Description Color', 'skyre' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'slider_desc_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['desc'],
			)
		);

		$this->add_responsive_control(
			'slider_desc_padding',
			array(
				'label'      => __( 'Padding', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_desc_margin',
			array(
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_desc_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'skyre' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'skyre' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'skyre' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'skyre' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_desc_container_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'skyre' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
						'title' => esc_html__( 'Left', 'skyre' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'skyre' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Right', 'skyre' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_desc_wax_width',
			array(
				'label' => esc_html__( 'Max Width', 'skyre' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range' => array(
					'%' => array(
						'min' => 20,
						'max' => 100,
					),
					'px' => array(
						'min' => 300,
						'max' => 1000,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Action Button #1 Style Section
		 */
		$this->start_controls_section(
			'section_action_button_style',
			array(
				'label'      => esc_html__( 'Action Button', 'skyre' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'slider_action_button_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'skyre' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'skyre' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'skyre' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'skyre' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['buttons_wrapper'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'section_action_primary_button_heading',
			array(
				'label'     => esc_html__( 'Action Button #1', 'skyre' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'tabs_primary_button_style' );

		$this->start_controls_tab(
			'tab_primary_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'skyre' ),
			)
		);

		$this->add_control(
			'primary_button_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['primary_button'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'primary_button_color',
			array(
				'label'     => esc_html__( 'Text Color', 'skyre' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['primary_button'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'primary_button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['primary_button'],
			)
		);

		$this->add_responsive_control(
			'primary_button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['primary_button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'primary_button_margin',
			array(
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['primary_button'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'primary_button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['primary_button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'primary_button_border',
				'label'       => esc_html__( 'Border', 'skyre' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['primary_button'],
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'primary_button_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['primary_button'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_primary_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'skyre' ),
			)
		);

		$this->add_control(
			'primary_button_hover_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'skyre' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['primary_button'] . ':hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'primary_button_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'skyre' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['primary_button'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'primary_button_hover_typography',
				'selector' => '{{WRAPPER}}  ' . $css_scheme['primary_button'] . ':hover',
			)
		);

		$this->add_responsive_control(
			'primary_button_hover_padding',
			array(
				'label'      => esc_html__( 'Padding', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['primary_button'] . ':hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'primary_button_hover_margin',
			array(
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['primary_button'] . ':hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'primary_button_hover_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['primary_button'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'primary_button_hover_border',
				'label'       => esc_html__( 'Border', 'skyre' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['primary_button'] . ':hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'primary_button_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['primary_button'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'section_action_secondary_button_heading',
			array(
				'label'     => esc_html__( 'Action Button #2', 'skyre' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'tabs_secondary_button_style' );

		$this->start_controls_tab(
			'tab_secondary_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'skyre' ),
			)
		);

		$this->add_control(
			'secondary_button_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['secondary_button'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'secondary_button_color',
			array(
				'label'     => esc_html__( 'Text Color', 'skyre' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['secondary_button'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'secondary_button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['secondary_button'],
			)
		);

		$this->add_responsive_control(
			'secondary_button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['secondary_button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'secondary_button_margin',
			array(
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['secondary_button'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'secondary_button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['secondary_button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'secondary_button_border',
				'label'       => esc_html__( 'Border', 'skyre' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['secondary_button'],
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'secondary_button_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['secondary_button'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_secondary_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'skyre' ),
			)
		);

		$this->add_control(
			'secondary_button_hover_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'skyre' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['secondary_button'] . ':hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'secondary_button_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'skyre' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['secondary_button'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'secondary_button_hover_typography',
				'selector' => '{{WRAPPER}}  ' . $css_scheme['secondary_button'] . ':hover',
			)
		);

		$this->add_responsive_control(
			'secondary_button_hover_padding',
			array(
				'label'      => esc_html__( 'Padding', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['secondary_button'] . ':hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'secondary_button_hover_margin',
			array(
				'label'      => __( 'Margin', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['secondary_button'] . ':hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'secondary_button_hover_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'skyre' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['secondary_button'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'secondary_button_hover_border',
				'label'       => esc_html__( 'Border', 'skyre' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['secondary_button'] . ':hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'secondary_button_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['secondary_button'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Generate setting json
	 *
	 * @return string
	 */
	public function generate_setting_json() {
		$module_settings = $this->get_settings();

		$settings = array(
			'sliderWidth'           => $module_settings['slider_width'],
			'sliderHeight'          => $module_settings['slider_height'],
			'sliderHeightTablet'    => $module_settings['slider_height_tablet'],
			'sliderHeightMobile'    => $module_settings['slider_height_mobile'],
			'sliderNavigation'      => filter_var( $module_settings['slider_navigation'], FILTER_VALIDATE_BOOLEAN ),
			'sliderNavigationIcon'  => $module_settings['slider_navigation_icon_arrow'],
			'sliderNaviOnHover'     => filter_var( $module_settings['slider_navigation_on_hover'], FILTER_VALIDATE_BOOLEAN ),
			'sliderPagination'      => filter_var( $module_settings['slider_pagination'], FILTER_VALIDATE_BOOLEAN ),
			'sliderAutoplay'        => filter_var( $module_settings['slider_autoplay'], FILTER_VALIDATE_BOOLEAN ),
			'sliderAutoplayDelay'   => $module_settings['slider_autoplay_delay'],
			'sliderAutoplayOnHover' => $module_settings['slide_autoplay_on_hover'],
			'sliderFullScreen'      => filter_var( $module_settings['slider_fullScreen'], FILTER_VALIDATE_BOOLEAN ),
			'sliderFullscreenIcon'  => $module_settings['slider_fullscreen_icon'],
			'sliderShuffle'         => filter_var( $module_settings['slider_shuffle'], FILTER_VALIDATE_BOOLEAN ),
			'sliderLoop'            => filter_var( $module_settings['slider_loop'], FILTER_VALIDATE_BOOLEAN ),
			'sliderFadeMode'        => filter_var( $module_settings['slider_fade_mode'], FILTER_VALIDATE_BOOLEAN ),
			'slideDistance'         => $module_settings['slide_distance'],
			'slideDuration'         => $module_settings['slide_duration'],
			'imageScaleMode'        => $module_settings['slide_image_scale_mode'],
			'thumbnails'            => filter_var( $module_settings['thumbnails'], FILTER_VALIDATE_BOOLEAN ),
			'thumbnailWidth'        => $module_settings['thumbnail_width'],
			'thumbnailHeight'       => $module_settings['thumbnail_height'],
			'rightToLeft'           => is_rtl(),
		);

		$settings = json_encode( $settings );

		return sprintf( 'data-settings=\'%1$s\'', $settings );
	}

	/**
	 * [__loop_button_item description]
	 * @param  array  $keys   [description]
	 * @param  string $format [description]
	 * @return [type]         [description]
	 */
	protected function __loop_button_item( $keys = array(), $format = '%s' ) {
		$item = $this->__processed_item;
		$params = [];

		foreach ( $keys as $key => $value ) {

			if ( ! array_key_exists( $value, $item ) ) {
				return false;
			}

			if ( empty( $item[$value] ) ) {
				return false;
			}

			$params[] = $item[ $value ];
		}

		return vsprintf( $format, $params );
	}


	/**
	 * [render description]
	 * @return [type] [description]
	 */
	protected function render() {
		$this->maybe_load_widget_style();
		$sliderImg = '';
		$thumbImg = '';
		
		$settings = $this->get_settings_for_display();
		$items = $settings['item_list'];
		$data_settings = $this->generate_setting_json();
		$classes_list[] = 'sk-slider';
		$classes_list[] = 'sk-slider__image-' . $settings['slide_image_scale_mode'];
		$classes1 = implode( ' ', $classes_list );
		$class_array[] = 'sk-slider__items';
		$class_array[] = 'sp-slides';
		$classes2 = implode( ' ', $class_array );
		?>
		<div class="<?php echo esc_attr($classes1); ?>" <?php echo wp_kses_post($data_settings); ?>>
           <span class="sk-slider-loader"></span>
             <div class="slider-pro">
                <div class="<?php echo esc_attr($classes2); ?>">
                <!--loop start-->
                <?php foreach ($items as $item) { 
				$image = $item['item_image'];
				$alt = empty($item['item_title']) ? __('No Image','skyre') : $item['item_title'];
				if ( empty( $image['id'] ) ) {
					$sliderImg = sprintf( '<img class="sp-image" src="%s" alt="%s">', Utils::get_placeholder_image_src(), $alt  );
				} else {
				$image_sizes = get_intermediate_image_sizes();
				$slider_image_size = $this->get_settings_for_display( 'slider_image_size' );
				$slider_image_size = ! empty( $slider_image_size ) ? $slider_image_size : 'full';
				$image_attr = array(
					'class' => 'sp-image',
				);
				$sliderImg = wp_get_attachment_image( $image['id'], $slider_image_size, false, $image_attr );
				}
				?>
                <div class="sk-slider__item sp-slide">
                    <?php
                        echo wp_kses_post($sliderImg);
						if ( filter_var( $settings['thumbnails'], FILTER_VALIDATE_BOOLEAN ) ) {
							if ( $settings['thumbnails'] ) { echo sprintf( '<img class="sp-thumbnail" src="%s" alt=%s"">',$image['url'], $alt ); }
						}
 					$animationData_cnt = '';
					$infClass_cnt = '';
					$animation_cnt = $settings['slider_content_animation'];
					if ( $animation_cnt == 'inf-upDown' || $animation_cnt == 'inf-scale' ) { $infClass_cnt = $animation_cnt;} 
					else if ( $animation_cnt !='' ) { $animationData_cnt = 'data-show-transition='.$animation_cnt;}
					?>
                    <?php 
					if ( $item['second_content'] ) {
					$animationData = '';
					$infClass = '';
					$animation = $settings['slider_secContent_animation'];
					if ( $animation == 'inf-upDown' || $animation == 'inf-scale' ) { $infClass = $animation;} 
					else if ( $animation !='' ) { $animationData = 'data-show-transition="'.$animation.'"';}
					?> 
                    <div class="sp-layer sk-slider__secContent <?php echo esc_attr($infClass); ?>" data-width="100%" data-height="100%"  <?php echo wp_kses_post($animationData); ?> data-hide-transition="up" data-show-duration="400" data-show-delay="400">
                    	<div class="sk-slider__secContent-item">
                            <div class="sk-slider__secContent-inner">
                        		<?php echo wp_kses_post($item['second_content']);  ?>
                            </div>
                        </div>
                    </div>
                   <?php } ?>
				   
					<div class="sk-slider__content sp-layer <?php echo esc_attr($infClass_cnt); ?>" data-position="centerCenter" data-width="100%" data-height="100%" data-horizontal="0%" <?php echo esc_html($animationData_cnt); ?> data-show-duration="400" data-show-delay="400">
                        <div class="sk-slider__content-item">
                            <div class="sk-slider__content-inner">
                                <?php
                                    if ( $item['item_icon'] ) { echo sprintf( '<div class="sk-slider__icon"><div class="sk-slider-icon-inner"><i class="%s"></i></div></div>',$item['item_icon'] ); }
									if ( $item['item_title'] ) { echo sprintf( '<h5 class="sk-slider__title">%s</h5>',$item['item_title'] ); }
									if ( $item['item_subtitle'] ) { echo sprintf( '<h5 class="sk-slider__subtitle">%s</h5>',$item['item_subtitle'] ); }
									if ( $item['item_desc'] ) { echo html_entity_decode (sprintf( '<div  data-show-transition="up" data-hide-transition="down" data-show-duration="1000" data-show-delay="1000" class="sk-slider__desc">%s</div>',$item['item_desc'] )); }
                                ?>
                                <div class="sk-slider__button-wrapper"><?php
                                   if ( $item['item_button_primary_text'] ) { echo sprintf( '<a class="btn btn-primary sk-slider__button sk-slider__button--primary" href="%1$s">%2$s</a>',$item['item_button_primary_url'],$item['item_button_primary_text'] ); }
								   if ( $item['item_button_secondary_text'] ) { echo sprintf( '<a class="btn btn-primary sk-slider__button sk-slider__button--primary" href="%1$s">%2$s</a>',$item['item_button_secondary_url'],$item['item_button_secondary_text'] ); }
								    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
               </div>
                <!--loop end-->
                <?php } ?>
                </div>
			</div>
		</div>
		<?php
		
	
	}
	/**
	 * Load the widget style dynamically if it is a widget preview
	 * or enqueue style and scripts if not
	 *
	 * This way we are sure that the assets files are loaded only when this block is present in page.
	 */
	protected function maybe_load_widget_style() {
		
		WP_Filesystem();
		global $wp_filesystem;
		$style ='';
		
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() === true ) {
			$style .= $wp_filesystem->get_contents( get_template_directory_uri() . '/inc/assets/style/slider-pro/slider-pro.css' );
			$style .= $wp_filesystem->get_contents( get_template_directory_uri() . '/inc/assets/style/slider-pro/custom.css' );
			?>
			<style>
				<?php echo esc_html($style);  ?>
			</style>
            
			<?php
		} else {
			wp_enqueue_style( 'sliderProCSS' );
			wp_enqueue_style( 'sliderCustomCSS' );
			
		}
		
	}

	protected function _content_template() {}
}
