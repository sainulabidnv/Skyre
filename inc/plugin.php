<?php
namespace ewidget;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function widget_scripts() {
		
		wp_register_script("jquery-countdown", get_template_directory_uri()."/assets/js/vendors/jquery.countdown.min.js",array('jquery'),false,true);
		wp_enqueue_script("jquery-countdown");
		wp_register_script("sk-status", get_template_directory_uri() . '/inc/assets/js/sk-status.js',array('jquery'),false,true);
		wp_register_script("skyre-sp-player", get_template_directory_uri() . '/inc/assets/js/skyre-sp-player.js',array('jquery'),false,true);
		
		wp_register_script("sliderPro", get_template_directory_uri() . '/inc/assets/js/slider-pro/jquery.sliderPro.min.js',array('jquery'),false,true);
		wp_register_script("sliderCustom", get_template_directory_uri() . '/inc/assets/js/slider-pro/custom.js',array('jquery'),false,true);
		
		wp_register_script("skyre-posts-grid", get_template_directory_uri() . '/inc/assets/js/posts-grid.js',array('jquery'),false,true);
		
		wp_register_style("skyre-posts-grid", get_template_directory_uri() . '/inc/assets/style/elementor-posts-grid.css',array());
		wp_register_style("sliderProCSS", get_template_directory_uri() . '/inc/assets/style/slider-pro/slider-pro.min.css',array());
		wp_register_style("sliderCustomCSS", get_template_directory_uri() . '/inc/assets/style/slider-pro/custom.css',array());

		
		
		
		//newsletter-forms.js
		wp_register_script("newsletter-forms", get_template_directory_uri() . '/inc/assets/js/newsletter-forms.js',array('jquery'),false,true);
		wp_localize_script( "newsletter-forms", "contentFormsSettings", array(
			'restUrl' => esc_url_raw( rest_url() . 'rest-forms/v1/' ),
			'nonce'   => wp_create_nonce( 'wp_rest' ),
		) );
		wp_enqueue_script( 'newsletter-forms' );
		
		echo '<style type="text/css">.loading {opacity: .1;  pointer-events: none;}</style>';
	}
	
	
	
	

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function include_widgets_files() {
		require SKYRE_THEME_DIR .'inc/ewidgets/skyre-base.php' ;
		require SKYRE_THEME_DIR .'inc/ewidgets/sk-status.php' ;
		require SKYRE_THEME_DIR .'inc/ewidgets/button.php' ;
		require SKYRE_THEME_DIR .'inc/ewidgets/heading.php' ;
		require SKYRE_THEME_DIR .'inc/ewidgets/roadmap.php' ;
		require SKYRE_THEME_DIR .'inc/ewidgets/testimonial.php' ;
		require SKYRE_THEME_DIR .'inc/ewidgets/accordion.php' ;
		require SKYRE_THEME_DIR .'inc/ewidgets/posts-grid.php' ;
		require SKYRE_THEME_DIR .'inc/ewidgets/contact_form7.php' ;
		require SKYRE_THEME_DIR .'inc/ewidgets/newsletter.php' ;
		//require SKYRE_THEME_DIR .'inc/ewidgets/image-carousel.php' ;
		//require SKYRE_THEME_DIR .'inc/ewidgets/icon-box.php' ;
		require SKYRE_THEME_DIR .'inc/ewidgets/sk-slider.php' ;
		//require SKYRE_THEME_DIR .'inc/ewidgets/support/class-jet-elements-tools.php' ;
		require SKYRE_THEME_DIR .'inc/ewidgets/twitter.php' ;
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();

		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\icostatus() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Widget_Button() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Widget_Heading() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Widget_Roadmap() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Widget_Testimonial() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Widget_Accordion() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\postsGrid() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\contactForm7() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\NewsLetter() );
		//\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Image_Carousel() );
		//\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Icon_Box() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\skyreSlider() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\SkyreTwitter() );
		
		
	}
	
	/**
	 * Register Widgets for SportsPress
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_sportspress_widgets() {
		// Its is now safe to include Widgets files
		require SKYRE_THEME_DIR .'inc/ewidgets/sportspress/sp-player-list.php' ;
		require SKYRE_THEME_DIR .'inc/ewidgets/sportspress/sp-player-grid.php' ;
		require SKYRE_THEME_DIR .'inc/ewidgets/sportspress/sp-event-list.php' ;
		require SKYRE_THEME_DIR .'inc/ewidgets/sportspress/sp-event-block.php' ;
		require SKYRE_THEME_DIR .'inc/ewidgets/sportspress/sp-league-list.php' ;
		require SKYRE_THEME_DIR .'inc/ewidgets/sportspress/sk-status.php' ;

		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\spPlayers() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\spPlayerGrid() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\spEvents() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\spEventBlock() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\spLeagueList() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\spCountDown() );
		
		
		
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	 
	 
	
	public function __construct() {

		//add_action( 'rest_api_init', array( $this, 'register_routes' ) );
		require SKYRE_THEME_DIR .'inc/ewidgets/support/newsletter-rest.php' ;
		
		

		\ewidget\Widgets\RestServer::instance();
	
		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'widget_scripts' ] );
		
		

		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
		
		if ( class_exists( 'SportsPress' ) ) {
			add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_sportspress_widgets' ] );
			 }
	
		
	}
	
	
	
}

// Instantiate Plugin Class
Plugin::instance();
