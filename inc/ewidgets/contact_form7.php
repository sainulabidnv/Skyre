<?php
/**
 * Contactform7 widget for Elementor builder
 *
 * @link       https://skyresoft.com
 * @since      1.0.0
 *
 */
 
namespace ewidget\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;






if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // End if().

/**
 * Class Posts_Grid
 *
 * @package ThemeIsle\ElementorExtraWidgets
 */
class contactForm7 extends \Elementor\Widget_Base {

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'Contact Form7', 'skyre' );
	}

	/**
	 * Widget icon.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	/**
	 * Widget name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'contact_form7';
	}
	


	  protected function get_contact_form_7(){
	
	  $args = array('post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1);
	
		$catlist=[];
		
		if( $categories = get_posts($args)){
			foreach ( $categories as $category ) {
				(int)$catlist[$category->ID] = $category->post_title;
			}
		}
		else{
			(int)$catlist['0'] = esc_html__('No contect From 7 form found', 'skyre');
		}
	  return $catlist;
	  }
	  
	protected function get_all_pages(){

	  $args = array('post_type' => 'page', 'posts_per_page' => -1);
	
		$catlist=[];
		
		if( $categories = get_posts($args)){
		  foreach ( $categories as $category ) {
			(int)$catlist[$category->ID] = $category->post_title;
		  }
		}
		else{
			(int)$catlist['0'] = esc_html__('No Pages Found!', 'skyre');
		}
	  return $catlist;
	  }
	
	protected function _register_controls() {
		
//start of a control box
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Contact Form 7', 'skyre' ),   //section name for controler view
			]
		);

		$this->add_control(
			'cf7',
			[
				'label' => esc_html__( 'Select Contact Form', 'skyre' ),
                'description' => esc_html__('Contact form 7 - plugin must be installed and there must be some contact forms made with the contact form 7','skyre'),
				'type' => Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => $this->get_contact_form_7(),
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'cfy_color',
			[
				'label' => __( 'Contact Form', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'cfy_text_color',
			[
				'label' => __( 'Text Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} ' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'cfy_placeholder_color',
			[
				'label' => __( 'Placeholder Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} ::placeholder ' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cfy_text_typo',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'cfy_field',
			[
				'label' => __( 'Fields', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'cfy_field_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} input, {{WRAPPER}} textarea, {{WRAPPER}} select, {{WRAPPER}} checkbox, {{WRAPPER}} radio',
				
				
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'cfy_field_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} input, {{WRAPPER}} textarea, {{WRAPPER}} select, {{WRAPPER}} checkbox, {{WRAPPER}} radio',
				'separator' => 'before',
			]
		);
		
		
		$this->add_control(
			'cfy_field_border_radius',
			[
				'label' => __( 'Border Radius', 'skyre' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} input, {{WRAPPER}} textarea, {{WRAPPER}} select, {{WRAPPER}} checkbox, {{WRAPPER}} radio' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'cfy_field_margin',
			[
				'label' => __( 'Margin', 'skyre' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} input, {{WRAPPER}} textarea, {{WRAPPER}} select, {{WRAPPER}} checkbox, {{WRAPPER}} radio' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'cfy_field_padding',
			[
				'label' => __( 'Padding', 'skyre' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} input, {{WRAPPER}} textarea, {{WRAPPER}} select, {{WRAPPER}} checkbox, {{WRAPPER}} radio' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'cfy_field_size',
			[
				'label' => __( 'Field width', 'skyre' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%','px' ],
				'range' => [
					
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} input, {{WRAPPER}} textarea, {{WRAPPER}} select' => 'width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cfy_field__typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} input, {{WRAPPER}} textarea, {{WRAPPER}} select',
				'separator' => 'before',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'cfy_button',
			[
				'label' => __( 'Submit Button', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'cfy_button_background',
				'label' => __( 'Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} input[type=submit]',
				'separator' => 'after',
				
			]
		);
		$this->add_control(
			'cfy_button_hover_color',
			[
				'label' => __( 'Hover Background', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} input[type=submit]:hover' => 'background-color: {{VALUE}};',
					'separator' => 'before',
				],
			]
		);
		
		$this->add_control(
			'cfy_button_color',
			[
				'label' => __( 'Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} input[type=submit]' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'cfy_button_border',
				'label' => __( 'Border', 'skyre' ),
				'selector' => '{{WRAPPER}} input[type=submit]',
			]
		);
		
		
		$this->add_control(
			'cfy_button_border_radius',
			[
				'label' => __( 'Border Radius', 'skyre' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} input[type=submit]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

				],
			]
		);

		

		$this->end_controls_section();

		$this->start_controls_section(
			'section_stype',
			[
				'label' => esc_html__( 'Style Contact Form', 'skyre' ),   //section name for controler view
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'cf7_direct_css',
			[
				'label' => __( 'Global CSS For all fields', 'skyre' ),
				'description' => __( 'This is the global css for all fields of cf7. It will not effect the other fileds but if you want to define things such as color, background color use this.', 'skyre' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => 'color:#000;',
				'selectors' => [
					'{{VALUE}}',
				],
			]
		);

		

		$this->add_control(
			'responce',
			[
				'label' => __( 'Responce CSS', 'skyre' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => 'color:red;',
				'selectors' => [
					'{{WRAPPER}} .wpcf7-response-output' => '{{VALUE}}',
				],
			]
		);
		
		$this->end_controls_section();
		
		
		
		$this->start_controls_section(
			'section_redirect',
			[
				'label' => esc_html__( 'After Submit Redirect Setting', 'skyre' ),   //section name for controler view
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'cf7_redirect_page',
			[
				'label' => esc_html__( 'On Success Redirect To', 'skyre' ),
                'description' => esc_html__('Select a page which you want users to redirect to when the contact fom is submitted and is successful. Leave Blank to Disable','skyre'),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_all_pages(),
			]
		);

		$this->end_controls_section();
	}


	protected function render() {				//to show on the fontend 
		static $v_veriable=0;

		$settings = $this->get_settings();
        if(!empty($settings['cf7'])){
    	   echo'<div class="elementor-shortcode void-cf7-'.$v_veriable.'">';
                echo do_shortcode('[contact-form-7 id="'.$settings['cf7'].'"]');    
           echo '</div>';  
    	}

 		if(!empty($settings['cf7_redirect_page'])) {  ?>
 			<script>
 			        var theform = document.querySelector('.void-cf7-<?php echo esc_attr($v_veriable); ?>');
						theform.addEventListener( 'wpcf7mailsent', function( event ) {
					    location = '<?php echo get_permalink( $settings['cf7_redirect_page'] ); ?>';
					}, false );
			</script>

		<?php  $v_veriable++;
 		}

    }


}

