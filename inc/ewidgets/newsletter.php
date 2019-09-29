<?php
/**
 * Newsletter widget for Elementor builder
 *
 * @link       https://skyresoft.com
 * @since      1.0.0
 *
 */
 
namespace ewidget\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;






if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // End if().

/**
 *
 * @package ThemeIsle\ElementorExtraWidgets
 */
class NewsLetter extends \Elementor\Widget_Base {

	private $forms_config = array();
	private $config;
	private function getFormType() {
		return 'newsletter';
	}
	
	
	
	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'News Letter', 'skyre' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-call-to-action';
	}

	/**
	 * Widget name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'newsletter';
	}
	

	
	protected function _register_controls() {
		
		$this->_register_fields_controls();
		
//start of a control box
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Form Settings', 'skyre' ),   //section name for controler view
			]
		);

		$this->add_control(
			'provider',
			[
				'label' => __( 'Provider', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'mailchimp' => 'MmailChimp',
					'sendinblue' => 'Sendinblue',
				],
				'default' => 'mailchimp',
				
			]
		);
		
		$this->add_control(
			'access_key',
			[
				'label' => __( 'Access Key', 'skyre' ),
				'description' => esc_html__( 'Provide mailchimp/sendinblue access key ', 'skyre' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'input_type' => 'password'
				
			]
		);
		$this->add_control(
			'list_id',
			[
				'label' => __( 'List ID', 'skyre' ),
				'description' => esc_html__( 'The List ID (based on the seleced service) where we should subscribe the user', 'skyre' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				
			]
		);
		
		
		$this->add_control(
			'succes_message',
			[
				'label' => __( 'Success Message', 'skyre' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Success!, Email hasbeen subscribed.', 'skyre' ),
				
			]
		);
		
		$this->end_controls_section();

		$this->add_style_controls();
		
	}
	
	protected function add_style_controls() {
		$this->start_controls_section(
			'section_form_style',
			[
				'label' => __( 'Form', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'align_submit',
			[
				'label' => __( 'Alignment', 'skyre' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'toggle' => false,
				'default' => 'flex-start',
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'skyre' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'skyre' ),
						'icon' => 'fa fa-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'skyre' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .content-form.content-form-newsletter' => 'justify-content: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'column_gap',
			[
				'label' => __( 'Columns Gap', 'skyre' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-column' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
					'{{WRAPPER}} .content-form .submit-form' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
				],
			]
		);

		$this->add_control(
			'row_gap',
			[
				'label' => __( 'Rows Gap', 'skyre' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-column' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .content-form .submit-form' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'heading_label',
			[
				'label' => __( 'Label', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
			'label_spacing',
			[
				'label' => __( 'Spacing', 'skyre' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors' => [
					'body.rtl {{WRAPPER}} fieldset > label' => 'padding-left: {{SIZE}}{{UNIT}};',
					// for the label position = inline option
					'body:not(.rtl) {{WRAPPER}} fieldset > label' => 'padding-right: {{SIZE}}{{UNIT}};',
					// for the label position = inline option
					'body {{WRAPPER}} fieldset > label' => 'padding-bottom: {{SIZE}}{{UNIT}};',
					// for the label position = above option
				],
			]
		);
		$this->add_responsive_control(
			'label_width',
			[
				'label' => __( 'Width', 'skyre' ),
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
					'size' => '',
				],
				
				'selectors' => [
					'{{WRAPPER}} fieldset > label' => 'width: {{SIZE}}{{UNIT}};',
					// for the label position = above option
				],
			]
		);
		
		$this->add_control(
			'label_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} fieldset > label, {{WRAPPER}} .elementor-field-subgroup label' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_control(
			'mark_required_color',
			[
				'label' => __( 'Mark Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .required-mark' => 'color: {{COLOR}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'selector' => '{{WRAPPER}} fieldset > label',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_style',
			[
				'label' => __( 'Field', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_responsive_control(
			'field_width',
			[
				'label' => __( 'Width', 'skyre' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => '',
				],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} fieldset > input' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} fieldset > textarea' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'field_typography',
				'selector' => '{{WRAPPER}} fieldset > input, {{WRAPPER}} fieldset > textarea, {{WRAPPER}} fieldset > button',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_responsive_control(
			'align_field_text',
			[
				'label' => __( 'Text alignment', 'skyre' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'toggle' => false,
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'skyre' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'skyre' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'skyre' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} fieldset > input' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} fieldset > textarea' => 'text-align: {{VALUE}}'
				],
			]
		);

		$this->add_responsive_control(
		        'field-text-padding', [
				'label' => __( 'Text Padding', 'skyre' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} fieldset > input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} fieldset > textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

		$this->start_controls_tabs( 'tabs_field_style' );

		$this->start_controls_tab(
			'tab_field_normal',
			[
				'label' => __( 'Normal', 'skyre' ),
			]
		);

		
		
		$this->add_control(
			'field_text_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} fieldset > input' => 'color: {{VALUE}};',
					'{{WRAPPER}} fieldset > input::placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} fieldset > textarea' => 'color: {{VALUE}};',
					'{{WRAPPER}} fieldset > textarea::placeholder' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);



		$this->add_control(
			'field_background_color',
			[
				'label' => __( 'Background Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} fieldset > input' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} fieldset > textarea' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'field_border_color',
			[
				'label' => __( 'Border Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} fieldset > input' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} fieldset > textarea' => 'border-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
		        'field_border_style',
            [
				'label' => _x( 'Border Type', 'Border Control', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'None', 'skyre' ),
					'solid' => _x( 'Solid', 'Border Control', 'skyre' ),
					'double' => _x( 'Double', 'Border Control', 'skyre' ),
					'dotted' => _x( 'Dotted', 'Border Control', 'skyre' ),
					'dashed' => _x( 'Dashed', 'Border Control', 'skyre' ),
					'groove' => _x( 'Groove', 'Border Control', 'skyre' ),
				],
				'selectors' => [
					'{{WRAPPER}} fieldset > input' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} fieldset > textarea' => 'border-style: {{VALUE}};'
				],
            ]
        );

		$this->add_control(
			'field_border_width',
			[
				'label' => __( 'Border Width', 'skyre' ),
				'type' => Controls_Manager::DIMENSIONS,
				'placeholder' => '',
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} fieldset > input' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} fieldset > textarea' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'field_border_radius',
			[
				'label' => __( 'Border Radius', 'skyre' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} fieldset > input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} fieldset > textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_field_focus',
			[
				'label' => __( 'Focus', 'skyre' ),
			]
		);

		$this->add_control(
			'field_focus_text_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} fieldset > input:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} fieldset > input::placeholder:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} fieldset > textarea:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} fieldset > textarea::placeholder:focus' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_control(
			'field_focus_background_color',
			[
				'label' => __( 'Background Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} fieldset > input:focus' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} fieldset > textarea:focus' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'field_focus_border_color',
			[
				'label' => __( 'Border Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} fieldset > input:focus' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} fieldset > textarea:focus' => 'border-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'field_focus_border_style',
			[
				'label' => _x( 'Border Type', 'Border Control', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'None', 'skyre' ),
					'solid' => _x( 'Solid', 'Border Control', 'skyre' ),
					'double' => _x( 'Double', 'Border Control', 'skyre' ),
					'dotted' => _x( 'Dotted', 'Border Control', 'skyre' ),
					'dashed' => _x( 'Dashed', 'Border Control', 'skyre' ),
					'groove' => _x( 'Groove', 'Border Control', 'skyre' ),
				],
				'selectors' => [
					'{{WRAPPER}} fieldset > input:focus' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} fieldset > textarea:focus' => 'border-style: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'field_focus_border_width',
			[
				'label' => __( 'Border Width', 'skyre' ),
				'type' => Controls_Manager::DIMENSIONS,
				'placeholder' => '',
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} fieldset > input:focus' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} fieldset > textarea:focus' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'field_focus_border_radius',
			[
				'label' => __( 'Border Radius', 'skyre' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} fieldset > input:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} fieldset > textarea:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			[
				'label' => __( 'Button', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'skyre' ),
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label' => __( 'Background Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} fieldset > button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} fieldset > button' => 'color: {{VALUE}};',
				],
			]
		);
		
		
		$this->add_responsive_control(
			'button_width',
			[
				'label' => __( 'Width', 'skyre' ),
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
					'size' => '',
				],
				
				'selectors' => [
					'{{WRAPPER}} fieldset > button' => 'width: {{SIZE}}{{UNIT}};',
					// for the label position = above option
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} fieldset > button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name' => 'button_border',
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} fieldset > button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'skyre' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} fieldset > button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_text_padding',
			[
				'label' => __( 'Padding', 'skyre' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} fieldset > button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'button_text_margin',
			[
				'label' => __( 'Margin', 'skyre' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} fieldset > button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'skyre' ),
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label' => __( 'Background Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} fieldset > button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} fieldset > button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} fieldset > button:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_border_border!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		
		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_response_style',
			[
				'label' => __( 'Response/Message', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
			'success_background_color',
			[
				'label' => __( 'Success Background', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#d4edda',
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .content-form-success' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'filed_background_color',
			[
				'label' => __( 'Error Background', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f8d7da',
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .content-form-error' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'success_text_color',
			[
				'label' => __( 'Success Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#155724',
				'selectors' => [
					'{{WRAPPER}} .content-form-success' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'eror_text_color',
			[
				'label' => __( 'Error Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#721c24',
				'selectors' => [
					'{{WRAPPER}} .content-form-error' => 'color: {{VALUE}};',
				],
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'success_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selectors' => [
					'{{WRAPPER}} .content-form-error',
					'{{WRAPPER}} .content-form-success',
				],
			]
		);

		$this->add_control(
			'success_border_radius',
			[
				'label' => __( 'Border Radius', 'skyre' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				
				'selectors' => [
					'{{WRAPPER}} .content-form-error, {{WRAPPER}} .content-form-success' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'success_text_padding',
			[
				'label' => __( 'Padding', 'skyre' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .content-form-error, {{WRAPPER}} .content-form-success' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'success_text_margin',
			[
				'label' => __( 'Margin', 'skyre' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .content-form-error, {{WRAPPER}} .content-form-success' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
	}
	
	protected function _register_fields_controls() { 
	

		$this->start_controls_section(
			'newsletter_fields',
			[
				'label' => esc_html__( 'Fields', 'skyre' ),   //section name for controler view
			]
		);
		
		

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'label',
			array(
				'label'   => __( 'Label', 'skyre' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$repeater->add_control(
			'placeholder',
			array(
				'label'   => __( 'Placeholder', 'skyre' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			)
		);
		$repeater->add_control(
			'field_name',
			array(
				'label'   => __( 'Field Name', 'skyre' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => esc_html__( 'These field name must be present in your SendinBlue/mailchip account. For eg. FIRSTNAME, LASTNAME', 'skyre' ),
				
			)
		);

		$repeater->add_control(
			'requirement',
			array(
				'label'   => __( 'Required', 'skyre' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'required',
				'default' => '',
			)
		);

		$field_types = array(
			'text'     => __( 'Text', 'skyre' ),
			'password' => __( 'Password', 'skyre' ),
//			'tel'      => __( 'Tel', 'textdomain' ),
			'email'    => __( 'Email', 'skyre' ),
			'textarea' => __( 'Textarea', 'skyre' ),
//			'number'   => __( 'Number', 'textdomain' ),
//			'select'   => __( 'Select', 'textdomain' ),
//			'url'      => __( 'URL', 'textdomain' ),
		);

		$repeater->add_control(
			'type',
			array(
				'label'   => __( 'Type', 'skyre' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => $field_types,
				'default' => 'text'
			)
		);

		$repeater->add_control(
			'key',
			array(
				'label' => __( 'Key', 'skyre' ),
				'type'  => \Elementor\Controls_Manager::HIDDEN
			)
		);

		$repeater->add_responsive_control(
			'field_width',
			[
				'label' => __( 'Field Width', 'skyre' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'100' => '100%',
					'75' => '75%',
					'66' => '66%',
					'50' => '50%',
					'33' => '33%',
					'25' => '25%',
				],
				'default' => '100',
			]
		);

		
		$default = array(
				'email' => array(
					'type'        => 'email',
					'label'       => esc_html__( 'Email', 'skyre' ),
					'default'     => esc_html__( 'Email', 'skyre' ),
					'placeholder' => esc_html__( 'Email', 'skyre' ),
					'field_name'  => 'email',
					'require'     => 'required'
				)

		);
		
		

		$default_fields = array();

		foreach ( $default as $field_name => $field ) {
			$default_fields[] = array(
				'key'         => $field_name,
				'type'        => $field['type'],
				'label'       => $field['label'],
				'field_name'  => $field['field_name'],
				'requirement' => $field['require'],
				'placeholder' => isset( $field['placeholder'] ) ? $field['placeholder'] : $field['label'],
				'field_width' => '100',
			);
		}

		$this->add_control(
			'form_fields',
			array(
				'label'       => __( 'Form Fields', 'skyre' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'show_label'  => false,
				'separator'   => 'before',
				'fields'      => array_values( $repeater->get_controls() ),
				'default'     => $default_fields,
				'title_field' => '{{{ label }}}',
			)
		);

			$this->add_control(
				'button_icon',
				[
					'label' => __( 'Submit Icon', 'skyre' ),
					'type' => Controls_Manager::ICON,
					'label_block' => true,
					'default' => '',
				]
			);
			
			$this->add_control(
			'submit_label',
			[
				'label' => __( 'Submit Label', 'skyre' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Subscribe', 'skyre' ),
				
			]
		);

			$this->add_control(
				'button_icon_indent',
				[
					'label' => __( 'Icon Spacing', 'skyre' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 100,
						],
					],
					'condition' => [
						'button_icon!' => '',
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-button-icon' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: {{SIZE}}{{UNIT}};',
					],
				]
			);


		$this->end_controls_section();
	}


protected function render( $instance = array() ) {
		$form_id  = $this->get_data( 'id' );
		$settings = $this->get_settings();
		$instance = $this->get_settings();

		//$this->maybe_load_widget_style();

		if ( empty( $this->forms_config['fields'] ) ) {
			//return;
		}

		$fields = $settings['form_fields'];

		
		
		$this->render_form_header( $form_id );
		foreach ( $fields as $index => $field ) {
			$this->render_form_field( $field );
		}

		$btn_label = esc_html__( 'Submit', 'skyre' );

		if ( ! empty( $settings['submit_label'] ) ) {
			$btn_label = $this->get_settings( 'submit_label' );
		} ?>
        <fieldset class="submit-form newsletter">
            <button type="submit" name="submit" value="submit-newsletter-<?php echo esc_attr($form_id);
            ?>" class="btn btn-sk-primary <?php $this->get_render_attribute_string( 'button' ); ?>">
	            <?php echo esc_html($btn_label); ?>
                <?php if ( ! empty( $instance['button_icon'] ) ){ ?><span <?php echo esc_html($this->get_render_attribute_string( 'content-wrapper' )); // TODO: what to do about content-wrapper 
				echo esc_html($this->get_render_attribute_string( 'icon-align' )); ?>>
									<i class="<?php echo esc_attr( $instance['button_icon'] ); ?>"></i>
								</span>
							<?php }; ?>
            </button>
        </fieldset>
		<?php

		$this->render_form_footer();
	}

	/**
	 * Either enqueue the widget style registered by the library
	 * or load an inline version for the preview only
	 */
	protected function maybe_load_widget_style() {
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() === true  ) { ?>
            
			<style>
                <?php echo file_get_contents( plugin_dir_path( __FILE__ ) . '/assets/content-forms.css' ) ?>
            </style>
			<?php
		} else {
			// if `themeisle_content_forms_register_default_style` is false, the style won't be registered anyway
			wp_enqueue_script( 'content-forms' );
			wp_enqueue_style( 'content-forms' );
		}
	}

	/**
	 * Display method for the form's header
	 * It is also takes care about the form attributes and the regular hidden fields
	 *
	 * @param $id
	 */
	private function render_form_header( $id ) {
		// create an url for the form's action
		$url = admin_url( 'admin-post.php' );

		echo '<form action="' . esc_url( $url ) . '" method="post" name="content-form-' . $id . '" id="content-form-' . $id . '" class="content-form content-form-newsletter">';

		wp_nonce_field( 'content-form-' . $id, '_wpnonce_' . $this->getFormType() );

		echo '<input type="hidden" name="action" value="content_form_submit" />';
		// there could be also the possibility to submit by type
		// echo '<input type="hidden" name="action" value="content_form_{type}_submit" />';
		echo '<input type="hidden" name="form-type" value="' . $this->getFormType() . '" />';
		echo '<input type="hidden" name="form-builder" value="elementor" />';
		echo '<input type="hidden" name="post-id" value="' . get_the_ID() . '" />';
		echo '<input type="hidden" name="form-id" value="' . $id . '" />';
	}

	/**
	 * Display method for the form's footer
	 */
	private function render_form_footer() {
		echo '</form>';
	}

	/**
	 * Print the output of an individual field
	 *
	 * @param $field
	 * @param bool $is_preview
	 */
	private function render_form_field( $field, $is_preview = false ) {
		$item_index = $field['_id'];
		$key        = ! empty( $field['key'] ) ? $field['key'] : str_replace('-', '', $field['field_name']) ;
		$placeholder        = ! empty( $field['placeholder'] ) ? $field['placeholder'] : '';

		$required   = '';
		$form_id    = $this->get_data( 'id' );

		if ( $field['requirement'] === 'required' ) {
			$required = 'required';
		}

//		 in case this is a preview, we need to disable the actual inputs and transform the labels in inputs
		$disabled = '';
		if ( $is_preview ) {
			$disabled = 'disabled="disabled"';
		}

		$field_name = 'data[' . $form_id . '][' . $key . ']';

		$this->add_render_attribute( 'fieldset' . $field['_id'], 'class',  'content-form-field-' . $field['type'] );
		$this->add_render_attribute( 'fieldset' . $field['_id'], 'class', 'elementor-column elementor-col-' . $field['field_width'] );
		$this->add_render_attribute( ['icon-align' => [
			'class' => [
				empty( $instance['button_icon_align'] ) ? '' :
					'elementor-align-icon-' . $instance['button_icon_align'],
				'elementor-button-icon',
			],
		]] );

		$this->add_inline_editing_attributes( $item_index . '_label', 'none' );
		?>


        <fieldset <?php echo wp_kses_post($this->get_render_attribute_string( 'fieldset' . $field['_id'] )); ?>>

            <label for="<?php echo esc_attr($field_name) ?>"
				<?php echo esc_attr($this->get_render_attribute_string( 'label' . $item_index )); ?>>
				<?php 
				if($field['label']) {
					echo esc_html($field['label']);
					if ($field['requirement']==='required'){ ?>
						<span class="required-mark"> *</span>
					<?php }
				}
				?>
            </label>

			<?php
			switch ( $field['type'] ) {
				case 'textarea': ?>
                    <textarea class="form-control" name="<?php echo esc_attr($field_name); ?>" id="<?php echo esc_attr($field_name); ?>"
						<?php echo esc_attr($disabled); ?>
						<?php echo esc_attr($required); ?>
                              placeholder="<?php echo esc_attr ( $placeholder ); ?>"
                              cols="30" rows="5"></textarea>
					<?php break;
				case 'password': ?>
                    <input class="form-control" type="password" name="<?php echo esc_attr($field_name); ?>" id="<?php echo esc_attr($field_name); ?>"
						<?php echo esc_attr($required); ?> <?php echo esc_attr($disabled); ?>>
					<?php break;
				default: ?>
                    <input class="form-control" type="text" name="<?php echo esc_attr($field_name); ?>" id="<?php echo esc_attr($field_name); ?>"
						<?php echo esc_attr($required); ?> <?php echo esc_attr($disabled); ?> placeholder="<?php echo esc_attr ( $placeholder ); ?>">
					<?php
					break;
			} ?>
        </fieldset>
		<?php
	}


}

