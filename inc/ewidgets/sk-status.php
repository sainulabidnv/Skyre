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
class icostatus extends Widget_Base {

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
			'title' 			=> '.sk_status_title',
			'date' 				=> '.sk-time',
			'stage' 			=> '.progress span',
			'description' 		=> '.sk-status-desc',
			'general' 			=> '.sk-countdown',
			
			
			
			
			
		);
		
		
		
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'skyre' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'skyre' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Event Start in', 'skyre' ),
			]
		);
		$this->add_control(
			'header_size',
			[
				'label' => __( 'HTML Tag', 'elementor' ),
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
			'date',
			[
				'label' => __( 'End Date', 'skyre' ),
				'type' => Controls_Manager::DATE_TIME,
				'default' => date('Y-m-d', strtotime("+20 days")),
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
				'label'  => esc_html__( 'Title Color', 'sk-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'status_title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['title'],
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

		$this->end_controls_section();

		/**
		 * Date Style Section
		 */
		
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Date', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		

		$this->add_control(
			'status_date_color',
			array(
				'label'  => esc_html__( 'Date Color', 'sk-elements' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['date'] => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['date'].' span' => 'color: {{VALUE}}',
				),
			)
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name' => 'date_typography',
				'label' => __( 'Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}}' . $css_scheme['date'],
				
			)
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'date_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['date'],
			)
		);
		
		$this->add_responsive_control(
			'status_date_padding',
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
			'status_date_margin',
			array(
				'label'      => __( 'Margin', 'sk-elements' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['date'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}}' . $css_scheme['date'] => 'border-radius: {{SIZE}}{{UNIT}};',
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

		
		//$this->add_inline_editing_attributes( 'title' );
		//$this->add_inline_editing_attributes( 'description' );
		?>
		<!--sk-countdown--> 
        <div class="sk-countdown text-center ">
            <<?php echo $settings['header_size']; ?> class="sk_status_title" ><?php echo $settings['title']; ?></<?php echo $settings['header_size'];?>>
            <div class="countdown my-4">
                <div class="row" data-date="<?php echo $settings['date']; ?>"> <!--Append timer--></div>
            </div>
            <?php if($settings['slider_progressbar'] == 'true') { ?>
            <div class="sk-progress">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: <?php echo $settings['statusbar']['size']; ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    <?php if($settings['status_stage1_title']) { ?><span class="level-1" style="left:<?php echo $settings['status_stage1_position']; ?>%"><?php echo $settings['status_stage1_title']; ?></span> <?php } ?>
                    <?php if($settings['status_stage2_title']) { ?><span class="level-2" style="left:<?php echo $settings['status_stage2_position']; ?>%"><?php echo $settings['status_stage2_title']; ?></span> <?php } ?>
                    <?php if($settings['status_stage3_title']) { ?><span class="level-3" style="left:<?php echo $settings['status_stage3_position']; ?>%"><?php echo $settings['status_stage3_title']; ?></span> <?php } ?>
                </div>
            </div>
            <?php } ?>
            <div class="sk-status-desc pt-2 "><?php echo $settings['description']; ?></div>
        </div>
        <!--End sk-countdown-->
		<?php
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.1.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
		?>
		
		<div class="sk-countdown text-center " >
            <{{{ settings.header_size }}} class="sk_status_title">{{{ settings.title }}}</{{{ settings.header_size }}}>
            <div class="countdown my-4">
                <div class="row" data-date="{{{ settings.date }}}"> <!--Append timer--></div>
            </div>
            <# if ( settings.slider_progressbar == 'true' ) { #>
            <div class="sk-progress">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{{ settings.statusbar.size }}}%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    <# if ( settings.status_stage1_title ) { #><span class="level-1" style="left:{{{ settings.status_stage1_position }}}%">{{{ settings.status_stage1_title }}}</span> <# } #>
                    <# if ( settings.status_stage2_title ) { #><span class="level-2" style="left:{{{ settings.status_stage2_position }}}%">{{{ settings.status_stage2_title }}}</span> <# } #>
                    <# if ( settings.status_stage3_title ) { #><span class="level-3" style="left:{{{ settings.status_stage3_position }}}%">{{{ settings.status_stage3_title }}}</span> <# } #>
                </div>
            </div>
            <# } #>
            <div class="sk-status-desc pt-2">{{{ settings.description }}}</div>
        </div>
       
        
		<?php
	}
}
