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



if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // End if().

/**
 * Class Posts_Grid
 *
 * @package ThemeIsle\ElementorExtraWidgets
 */
class spPlayers extends \Elementor\Widget_Base {

	/**
	 * Widget title.
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'Player Grid/List', 'skyre' );
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
		return 'skyre-sp-player';
	}
	
	protected function get_player_list(){
	
	  $args = array('post_type' => 'sp_list', 'posts_per_page' => -1);
	  
		$catlist=[];
		
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
			
			$fields = array('Rank'=>'Rank','Name'=>'Name','Club'=>'Club','Postion'=>'Postion');
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
		 $fields = array('Rank','Name','Club','Postion');
		 if ( in_array( $name, $fields ) ){
			 if($name == 'Rank') return 'number';
			 if($name == 'Name') return 'name';
			 if($name == 'Club') return 'team';
			 if($name == 'Postion') return 'position';
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
			return $colname[0]->post_name;

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
				'type' => Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => $this->get_player_list(),
			]
		);
		
		$this->add_control(
			'list_attr', [
				'label' => __( 'Show ', 'skyre' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => [
					'photo'  => __( 'Player Photo', 'skyre' ),
					'flag'  => __( 'Flag', 'skyre' ),
					'content' => __( 'List Content', 'skyre' ),
					'image' => __( 'List Image', 'skyre' ),
				],
				'default' => ['photo'],
			]
		);
		
		$this->add_control(
			'limit', [
				'label' => __( 'Number of players to show', 'skyre' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'step' => 1,
				'default' => 10,
			]
		);
		
		$this->add_control(
			'order_by', [
				'label' => __( 'Order by', 'skyre' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => $this->get_columns_sort(),
				'default' => 'default',
			]
		);
		
		$this->add_control(
			'sort_order', [
				'label' => __( 'Sort Order', 'skyre' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
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
				'type' => Controls_Manager::SELECT2,
				'multiple' => false,
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
					[ 'column_id' => __( 'Rank', 'skyre' ), ],
					[ 'column_id' => __( 'Name', 'skyre' ), ],
					[ 'column_id' => __( 'Club', 'skyre' ), ],
					[ 'column_id' => __( 'Goals', 'skyre' ), ],
					[ 'column_id' => __( 'Assists', 'skyre' ), ],
				],
				'title_field' =>'{{{column_id}}}'/*'{{column_id}}'*/ //get_the_title('{{column_id}}') ,
			]
		);
		
		$this->end_controls_section();
		
		//====running items
		
		$this->start_controls_section(
			'sp_player_table_head',
			[
				'label' => __( 'Table Heading', 'skyre' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'table_heading_typo',
				'label' => __( 'Heading Typography', 'skyre' ),
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .sk-player-list-table th',
			]
		);
		
		$this->add_control(
			'table_heading_color',
			[
				'label' => __( 'Heading Color', 'skyre' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .sk-player-list-table th' => 'color: {{VALUE}};',
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
				'name' => 'table_heading_background',
				'label' => __( 'Heading Background', 'skyre' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .sk-player-list-table th',
			]
		);
		
		
		
		//====running items
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'running_sp_player',
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
			'pending_sp_player',
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
		$orderby = empty($settings['order_by']) ? 'default' : $settings['order_by'];
		$order = empty($settings['sort_order']) ? 'ASC' : $settings['sort_order'];
		$show_all_players_link = empty($settings['show_link']) ? false : $settings['show_link'];
		//widge settings - ws
		$ws['attr'] = $settings['list_attr'];
		/*echo '<pre>';
		print_r($columns);
		echo '</pre>';*/
		foreach($columns as $column){
			if(isset($column['column_id']) && $column['column_id'] !='') {
				$columFields[]=$this->get_colum_name($column['column_id']);
			}
			}
		if ( $id > 0 ) {
		//print_r($settings['widget_title']);
		
		$post = get_post( $id );
		
		echo  '<div class="player_list_meta"> ';
		if($widget_title) { echo '<'.$titlesize.'>'.$widget_title.'</'.$titlesize.'>'; }
		if ( in_array( 'content', $settings['list_attr'] )) { echo $post->post_content; }
		if ( in_array( 'image', $settings['list_attr'] )) { echo get_the_post_thumbnail( $post->ID ); }
		
		
		echo  '</div> ';
		sp_get_template( 'player-list.php', array( 'id' => $id,'ws'=>$ws, 'title' => $caption, 'number' => $number, 'columns' => $columFields, 'orderby' => $orderby, 'order' => $order, 'grouping' => 0, 'show_all_players_link' => $show_all_players_link ) );

		
		
         
		}
		else { echo 'Plase select a Player List';}
		
	}

	protected function bkp_content_template() {
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

