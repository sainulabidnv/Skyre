<?php
/**
 * Elementor roadmap widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @package     Skyre
 * @author      Skyretheme
 * @copyright   Copyright (c) 2019, Skyre
 * @link        https://skyretheme.com/sports
 * @since       1.0.0
 */


namespace ewidget\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
//use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Widget_Roadmap extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve roadmap widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'roadmap';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve roadmap widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Roadmap', 'skyre' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve roadmap widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-integration';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the roadmap widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'skyre' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'roadmap', 'road map' ];
	}

	/**
	 * Register roadmap widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		
		$this->start_controls_section(
			'section_roadmap',
			[
				'label' => __( 'Road Map', 'skyre' ),
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => __( 'Layout', 'skyre' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'traditional',
				'options' => [
					'traditional' => [
						'title' => __( 'Default', 'skyre' ),
						'icon' => 'fa fa-road',
					],
					'owal' => [
						'title' => __( 'Owal', 'skyre' ),
						'icon' => 'fa fa-ellipsis-h',
					],
				],
				'render_type' => 'template',
				'classes' => 'elementor-control-start-end',
				'label_block' => false,
				'style_transfer' => true,
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
				'default' => 'h6',
			]
		);
		
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title', [
				'label' => __( 'Title', 'skyre' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Roadmap Title' , 'skyre' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'list_content', [
				'label' => __( 'Content', 'skyre' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry' , 'skyre' ),
				'show_label' => false,
			]
		);

		$repeater->add_control(
			'list_date',
			[
				'label' => __( 'Date', 'skyre' ),
				'type' => \Elementor\Controls_Manager::DATE_TIME,
				'default' => date('Y-m-d', strtotime("+20 days")),
				
			]
		);
		$repeater->add_control(
			'list_status',
			[
				'label' => __( 'Status', 'skyre' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'finished' => __( 'Finished', 'skyre' ),
					'active' => __( 'Running', 'skyre' ),
					'pending' => __( 'Pending', 'skyre' ),
				],
			]
		);
		
		

		$this->add_control(
			'list',
			[
				'label' => __( 'Roadmap Items', 'skyre' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => __( 'Roadmap Title #1', 'skyre' ),
						'list_content' => __( '1 Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry', 'skyre' ),
						'list_date' => date('Y-m-d', strtotime("-10 days")),
						'list_status' => 'finished',
					],
					[
						'list_title' => __( 'Roadmap Title #2', 'skyre' ),
						'list_content' => __( '2 Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry', 'skyre' ),
						'list_date' => date('Y-m-d', strtotime("+20 days")),
						'list_status' => 'active',
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);

		$this->end_controls_section();
		
		//====running items
		
		$this->start_controls_section(
			'actived_roadmap',
			[
				'label' => __( 'Finished Items', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'actived_title_color',
			[
				'label' => __( 'Title Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .finished .title' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);
		
		$this->add_control(
			'actived_content_color',
			[
				'label' => __( 'Title Content', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .finished .content' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);
		
		$this->add_control(
			'actived_date_color',
			[
				'label' => __( 'Date Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .finished .date' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);
		$this->add_control(
			'finished_border_color',
			[
				'label' => __( 'Border Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .finished.rmap-item, .finished .rmap-item-details, .finished .rmap-item-sets, .finished .rmap-circle, .rmap-year.finished' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .finished .rmap-circle span' => 'background-color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);
		
		//====running items
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'running_roadmap',
			[
				'label' => __( 'Running Items', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'running_title_color',
			[
				'label' => __( 'Title Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .active .title' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);
		$this->add_control(
			'running_content_color',
			[
				'label' => __( 'Title Content', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .active .content' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);
		
		$this->add_control(
			'running_date_color',
			[
				'label' => __( 'Date Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .active .date' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);
		
		$this->add_control(
			'active_border_color',
			[
				'label' => __( 'Border Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .active.rmap-item, .active .rmap-item-details, .active .rmap-item-sets, .active .rmap-circle, .rmap-year.active' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .active .rmap-circle span' => 'background-color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);
		
		
		$this->end_controls_section();
		//====finished items
		$this->start_controls_section(
			'pending_roadmap',
			[
				'label' => __( 'Pending Items', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'pending_title_color',
			[
				'label' => __( 'Title Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pending .title' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);
		$this->add_control(
			'pending_content_color',
			[
				'label' => __( 'Title Content', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pending .content' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);
		
		$this->add_control(
			'pending_date_color',
			[
				'label' => __( 'Date Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pending .date' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);
		$this->add_control(
			'pending_border_color',
			[
				'label' => __( 'Border Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pending.rmap-item, .pending .rmap-item-details, .pending .rmap-item-sets, .pending .rmap-circle, .rmap-year.pending' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .pending .rmap-circle span' => 'background-color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);
		
		$this->end_controls_section();
		$this->start_controls_section(
			'roadmap_settings',
			[
				'label' => __( 'More', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border radius', 'skyre' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '3',
				'selectors' => [
					'{{WRAPPER}} .rmap-item-details' => 'border-radius: {{VALUE}}px;',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Year Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rmap-year',
			]
		);
		$this->add_control(
			'year_color',
			[
				'label' => __( 'Year Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .rmap-year' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);
		$this->add_control(
			'endbtn_color',
			[
				'label' => __( 'End Button', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .rmap-end-btn' => 'background: {{VALUE}};',
				],
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
			]
		);
		
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$html = '';
		$year = '';
		$i = 0;
		
		
		if ( $settings['list'] ) {
		$html .= '<div class="rmap-wrap">
                	<div class="rmap-items row no-gutters ">';
		
		foreach (  $settings['list'] as $item ) {
				$cyear = date('Y',strtotime($item['list_date']) );
				$class = '';
				if($year < $cyear){
					$year = $cyear;
					$i = 0;
					$html .= '
						<div class="col-md-12 rmap-year-wrap  " > <div class="rmap-year ' . $item['list_status'] . '">' . $year . '</div> </div> ';
					}
				if ($i % 2 == 0) {$class = "";} else {$class = "rmap-right-item";}
				$html .= '
						<div class="col-md-6 '.$class.' rmap-item ' . $item['list_status'] . ' " >
							<div class="rmap-item-details row no-gutters">
								<div class="col-md"> <'. $settings['title_size'] .' class="title">' . $item['list_title'] . '</'. $settings['title_size'] .'> </div>
								<div class="col-md-5"> <span class="date"> ' . date('M, Y',strtotime($item['list_date'])) . ' </span> </div>
								<p class="small content">' . $item['list_content'] . ' </p>
								<div class="rmap-item-sets">
									<span class="rmap-circle"><span></span></span>
								</div>
							</div>
						</div><!--rmap-item-->
				';
			$i++;
			}	
         $html .= '</div><!-- End rmap-items -->
					<a href="#roadmap" class="rmap-end-btn"></a>
				</div><!--rmap-wrap-->';       
		}
		echo wp_kses_post($html);
	}

	protected function _content_template() {
		?>
        
        <# 
        var year = 0;
        var i = 0;
        var itemClass = '';
        if ( settings.list.length ) { #>
		<div class="rmap-wrap">
        	<div class="rmap-items row no-gutters ">
            
			<# _.each( settings.list, function( item ) { 
            var cdate = new Date( item.list_date )
        	var cyear = cdate.getFullYear();
            var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            var month = months[cdate.getMonth()];
            if(year < cyear) {
            i=0
            year = cyear
            
        
            #>
            	<div class="col-md-12 invisible"></div>
				<div class="col-md-12 rmap-item " > <div class="rmap-year {{ item.list_status }}">{{ year }}</div> </div>
            <#
            }
            if (i % 2 == 0) {itemClass = "";} else {itemClass = "rmap-right-item";}
            i++;
            #>
                <div class="col-md-6 {{ itemClass }} rmap-item {{ item.list_status }} " >
                    <div class="rmap-item-details row no-gutters">
                        <div class="col-md"> <{{ settings.title_size }} class="title">{{ item.list_title }} </{{ settings.title_size }}> </div>
                        <div class="col-md-5"> <span class="date"> {{ month }}, {{ cyear }} </span> </div>
                        <p class="small content"> {{ item.list_content }} </p>
                        <div class="rmap-item-sets">
                            <span class="rmap-circle"><span></span></span>
                        </div>
                    </div>
                </div>
                
			<# }); #>
			</div>
				<a href="#roadmap" class="rmap-end-btn"><i class="fas fa-angle-up"></i></a>
				</div>
		<# } #>
		<?php
	}
}
