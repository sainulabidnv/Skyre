<?php
/**
 * Skyre functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package     Skyre
 * @author      Skyretheme
 * @copyright   Copyright (c) 2019, Skyre
 * @link        https://skyretheme.com/sports
 * @since       1.0.0
 */
 
define( 'SKYRE_THEME_VERSION', '1.0' );
define( 'SKYRE_THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'SKYRE_THEME_URI', trailingslashit( esc_url( get_template_directory_uri() ) ) );
define( 'SKYRE_DEMO_URL',  'skyretheme.com' ) ;

/**
 * Skyre only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function skyre_setup() {
	
	
	/**
	 * Load translations for skyre
	 */
	load_theme_textdomain('skyre', get_template_directory() . '/languages');


	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'skyre-featured-image', 2000, 1200, true );

	add_image_size( 'skyre-thumbnail-avatar', 100, 100, true );

	add_image_size( 'post-medium', 700, 490, true );
	
	add_image_size( 'featuredthumb', 450, 300, true ); 
	
	add_image_size( 'widgetthumb', 55, 55, true ); 
    

	// Set the default content width.
	$GLOBALS['content_width'] = 525;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'    => __( 'Primary Menu', 'skyre' ),
		'footer'  => __( 'Footer Menu', 'skyre' ),
		'social_icons'  => __( 'Social Icons ', 'skyre' ),
	) );
	
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
	
	
	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( 'assets/style/css/editor-style.css' );

	
}
add_action( 'after_setup_theme', 'skyre_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function skyre_content_width() {

	$content_width = $GLOBALS['content_width'];

	// Get layout.
	$page_layout = get_theme_mod( 'page_layout' );

	// Check if layout is one column.
	if ( 'one-column' === $page_layout ) {
		if ( skyre_is_frontpage() ) {
			$content_width = 644;
		} elseif ( is_page() ) {
			$content_width = 740;
		}
	}

	// Check if is single post and there is no sidebar.
	if ( is_single() && ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 740;
	}

	/**
	 * Filter Skyre content width of the theme.
	 *
	 * @since Skyre 1.0
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'skyre_content_width', $content_width );
}
add_action( 'template_redirect', 'skyre_content_width', 0 );

/**
 * Register custom fonts.
 */
 
function skyre_fonts_url($url='') {
	if($url !=''){ return esc_url_raw( $url ); }
	$fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$Roboto = _x( 'on', 'Roboto font: on or off', 'skyre' );

	if ( 'off' !== $Roboto ) {
		$font_families = array();

		$font_families[] = 'Roboto:300,300i,400,400i,500,500i';

		//contensed
		$font_families[] = 'Roboto Condensed:400,700';
		

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Skyre 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function skyre_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'skyre-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'skyre_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function skyre_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Post Sidebar', 'skyre' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'skyre' ),
		'before_widget' => '<section id="%1$s" class="sk-border-15 widget  %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title sk-border-15">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'skyre' ),
		'id'            => 'footer-sidebar-1',
		'description'   => __( 'Add widgets here to appear in your footer.', 'skyre' ),
		'before_widget' => '<section id="%1$s" class="sk-border-15 widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title sk-border-15">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'skyre' ),
		'id'            => 'footer-sidebar-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'skyre' ),
		'before_widget' => '<section id="%1$s" class="sk-border-15 widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title sk-border-15">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer 3', 'skyre' ),
		'id'            => 'footer-sidebar-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'skyre' ),
		'before_widget' => '<section id="%1$s" class="sk-border-15 widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title sk-border-15">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Shop', 'skyre' ),
		'id'            => 'shop',
		'description'   => __( 'Add widgets here to appear in your Shop page.', 'skyre' ),
		'before_widget' => '<section id="%1$s" class="sk-border-15 widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title sk-border-15">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'skyre_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Skyre 1.0
 *
 * @param string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function skyre_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'skyre' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'skyre_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Skyre 1.0
 */
function skyre_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'skyre_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function skyre_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'skyre_pingback_header' );

/**
 * Display custom color CSS.
 */
function skyre_colors_css_wrap() {
	if ( 'custom' !== get_theme_mod( 'colorscheme' ) && ! is_customize_preview() ) {
		return;
	}

	require_once( get_parent_theme_file_path( '/inc/color-patterns.php' ) );
	$hue = absint( get_theme_mod( 'colorscheme_hue', 250 ) );
?>
	<style type="text/css" id="custom-theme-colors" <?php if ( is_customize_preview() ) { echo 'data-hue="' . $hue . '"'; } ?>>
		<?php echo skyre_custom_colors_css(); ?>
	</style>
<?php }
add_action( 'wp_head', 'skyre_colors_css_wrap' );

/**
 * Enqueue scripts and styles.
 */
function skyre_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'skyre-google', skyre_fonts_url(), array(), null );
	// Theme stylesheet.
	
	//wp_enqueue_style( 'main.minify', get_template_directory_uri().'/assets/style/css/main.minify.css');
	//wp_enqueue_style( 'skyre-style', get_template_directory_uri().'/assets/style/css/style.minify.css');

	wp_enqueue_style( 'main.minify', get_template_directory_uri().'/assets/style/css/main.css');
	wp_enqueue_style( 'skyre-style', get_template_directory_uri().'/assets/style/css/style.css');

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'skyre-ie9', get_theme_file_uri( '/assets/style/css/ie9.css' ), array( 'skyre-style' ), SKYRE_THEME_VERSION );
		wp_style_add_data( 'skyre-ie9', 'conditional', 'IE 9' );
	}

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'skyre-ie8', get_theme_file_uri( '/assets/style/css/ie8.css' ), array( 'skyre-style' ), SKYRE_THEME_VERSION );
	wp_style_add_data( 'skyre-ie8', 'conditional', 'lt IE 9' );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );
	
	/** All frontend js files **/
	wp_enqueue_script("popper", get_template_directory_uri()."/assets/js/vendors/popper.js",array('jquery'),false,true);
	wp_enqueue_script("bootstrap", get_template_directory_uri()."/assets/js/vendors/bootstrap.min.js",array('jquery'),false,true);
	wp_enqueue_script("jquery-easing", get_template_directory_uri()."/assets/js/vendors/jquery.easing.min.js",array('jquery'),false,true);
	wp_enqueue_script("custom", get_template_directory_uri()."/assets/js/custom.js",array('jquery'),false,true);
	
	$skyre_l10n = array(
		'quote'          => skyre_get_svg( array( 'icon' => 'quote-right' ) ),
	);

	wp_localize_script( 'skyre-skip-link-focus-fix', 'skyreScreenReaderText', $skyre_l10n );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'skyre_scripts' );


/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Skyre 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function skyre_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_archive() || is_search() || is_home() || is_page() ) {
		if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
			 $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'skyre_content_image_sizes_attr', 10, 2 );

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since Skyre 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function skyre_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'skyre_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Skyre 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return array The filtered attributes for the image markup.
 */
function skyre_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} 

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'skyre_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Skyre 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function skyre_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'skyre_front_page_template' );

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since Skyre 1.4
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function skyre_widget_tag_cloud_args( $args ) {
	$args['largest']  = 1;
	$args['smallest'] = 1;
	$args['unit']     = 'em';
	$args['format']   = 'list';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'skyre_widget_tag_cloud_args' );

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );
/**
 * bootstrap nva walker additions.
 */
require get_parent_theme_file_path( '/inc/class-wp-bootstrap-navwalker.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer/customizer.php' );

/**
 * Style additions.
 */
require get_parent_theme_file_path( '/inc/style.php' );

require get_parent_theme_file_path( '/inc/typo.php' );


/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );

/**
 * Requred plugins.
 */
require get_parent_theme_file_path( '/inc/plugin-requires.php' );
require get_parent_theme_file_path( '/inc/widget.php' );

/**
 * SportsPress function.
 */
if ( class_exists( 'sportspress' ) ) {
	require get_parent_theme_file_path( '/sportspress/functions.php' );
}

/**
 * WooCommerce function.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_parent_theme_file_path( '/woocommerce/functions.php' );
}