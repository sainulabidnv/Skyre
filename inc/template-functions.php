<?php
/**
 * Additional features to allow styling of the templates
 *
 * @package     Skyre
 * @author      Skyretheme
 * @copyright   Copyright (c) 2019, Skyre
 * @link        https://skyretheme.com/sports
 * @since       1.0.0
 */

if ( ! function_exists( 'skyre_get_option' ) ) :
function skyre_get_option( $name, $default = false ) {

	$option_name = '';
	// Get option settings from database
	$options = get_option( 'skyre' );

	// Return specific option
	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return $default;
}
endif;

//Get saved post options
if ( ! function_exists( 'skyre_get_page_option' ) ) :
function skyre_get_page_option( $name, $default = false ) {
	$option_name = '';
	// Get option settings from database
	$options = get_option( 'skyre_page' );

	// Return specific option
	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return '';
}
endif;

//Get saved post options
if ( ! function_exists( 'skyre_get_post_option' ) ) :
function skyre_get_post_option( $name, $default = false ) {
	$option_name = '';
	// Get option settings from database
	$options = get_option( 'skyre_post' );

	// Return specific option
	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return '';
}
endif;

//Get saved widget option
if ( ! function_exists( 'skyre_get_widget_option' ) ) :
function skyre_get_widget_option( $name, $default = false ) {
	$option_name = '';
	// Get option settings from database
	$options = get_option( 'skyre_widget' );

	// Return specific option
	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return '';
}
endif;


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function skyre_body_classes( $classes ) {
	// Add class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Add class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add class if we're viewing the Customizer for easier styling of theme options.
	if ( is_customize_preview() ) {
		$classes[] = 'skyre-customizer';
	}

	// Add class on front page.
	if ( is_front_page() && 'posts' !== get_option( 'show_on_front' ) ) {
		$classes[] = 'skyre-front-page';
	}
	

	// Add class if sidebar is used.
	if ( is_active_sidebar( 'sidebar-1' ) && ! is_page() ) {
		$classes[] = 'has-sidebar';
	}

	// Add class for one or two column page layouts.
	if ( is_page() || is_archive() ) {
		if ( 'one-column' === get_theme_mod( 'page_layout' ) ) {
			$classes[] = 'page-one-column';
		} else {
			$classes[] = 'page-two-column';
		}
	}

	// Add class if the site title and tagline is hidden.
	if ( 'blank' === get_header_textcolor() ) {
		$classes[] = 'title-tagline-hidden';
	}
	if ( is_home() || is_archive()  ) {
		$classes[] = 'skyre-post';
	}
	
	// Add class if the need header bg.
	if ( is_page() && !is_page_template() ) {
		$classes[] = 'skyre-page';
	}
	if ( is_single() ) {
		$classes[] = 'skyre-single-post';
	}
	
	return $classes;
}

add_action('skyre_index_pagination','skyre_pagination');
add_action('skyre_search_pagination','skyre_pagination');
add_action('skyre_archive_pagination','skyre_pagination');
add_action('skyre_page_pagination','skyre_pagination');
add_action('skyre_page_title','skyre_page_title');
add_action('comment_form_before','skyre_comment_form_before');
add_action('comment_form_after','skyre_comment_form_after');
add_action( 'save_post', 'skyre_title_status_save', 1, 2 );
add_action( 'add_meta_boxes', 'skyre_title_status_meta' );
add_action('skyre_single_header','skyre_post_modern_header');
add_action('skyre_preloader','skyre_preloader');
add_action('skyre_mainmenu','skyre_mainmenu');
add_action('skyre_index_title','skyre_index_title');
add_action('activate_elementor/elementor.php','skyre_elmentor_options');
add_action('activate_sportspress/sportspress.php','skyre_sportspress_options');

if ( ! function_exists( 'skyre_sportspress_options' ) ) :
	function skyre_sportspress_options() {
		update_option( 'elementor_disable_color_schemes', 'yes' );
		update_option( 'elementor_disable_typography_schemes', 'yes' );
	}
endif;

if ( ! function_exists( 'skyre_elmentor_options' ) ) :
	function skyre_elmentor_options() {
		update_option( 'sportspress_player_show_total', 'yes' );
		update_option( 'sportspress_player_show_career_total', 'yes' );
		update_option( 'sportspress_player_show_selector', 'no' );
		
	}
endif;


if ( ! function_exists( 'skyre_mainmenu' ) ) :
	function skyre_mainmenu() {
		$image = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
		?>
		<!-- Navbar -->
        <nav class="mainmenu <?php if(skyre_get_option('box_shadow') != 1 ) { ?>box-shadow <?php } ?> <?php if(skyre_get_option('sticky_header') != 1) { ?>is-sticky <?php } ?> navbar navbar-expand-lg" id="mainmenu">
            <div class="container">
                <a class="navbar-brand  animated fadeInUpShort" data-animate="fadeInDown" data-delay=".65" href="<?php  echo esc_url( home_url() ); ?>">
					<?php if ( get_theme_mod( 'custom_logo' ) ) { ?>
					<img class="logo my-1" alt="<?php echo get_bloginfo(); ?>" src="<?php echo esc_url($image[0]); ?>">
					<?php }else { echo '<p class=my-1>' . get_bloginfo( 'name' ) . '</p>'; } ?>
                </a>
                <button class="navbar-toggler skpbg skwc" type="button" data-toggle="collapse" data-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
                	<span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse  justify-content-end" id="navbarToggle">
                   <?php
						wp_nav_menu( array(
							'theme_location'  => 'primary',
							'depth'	          => '11', // 1 = no dropdowns, 2 = with dropdowns.
							'container'       => '',
							'container_class' => 'collapse navbar-collapse justify-content-end',
							'container_id'    => 'navbarToggle',
							'menu_class'      => 'navbar-nav menu-top text-uppercase',
							'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
							'walker'          => new WP_Bootstrap_Navwalker(),
						) );
					?>
                </div>
            </div> 
        </nav>
		<?php
	}
endif;

if ( ! function_exists( 'skyre_preloader' ) ) :
	function skyre_preloader() {
		//Preloader 
		if(skyre_get_option('loader') !=1){ ?>
		<div id="preloader">
				<ul class="loader">
					<li>
						<span class="cssload-loading cssload-one"></span>
						<span class="cssload-loading cssload-two"></span>
						<span class="cssload-loading-center sk-border"></span>
					</li>
				</ul>
			<div class="loader-section loader-top"></div>
			<div class="loader-section loader-bottom"></div>
		</div>
		<?php } 
		// Preloader End -->
	}
endif;

/** Add div for comment reply **/
if ( ! function_exists( 'skyre_comment_form_before' ) ) :
	function skyre_comment_form_before() {
		?> <div class="skyre-comment-respond sk-border-15"> <?php 
	}
endif;

if ( ! function_exists( 'skyre_comment_form_after' ) ) :
	function skyre_comment_form_after() {
		?> </div> <?php 
	}
endif;


/** Pagination **/
if ( ! function_exists( 'skyre_pagination' ) ) :
function skyre_pagination($prev = '', $next='', $pages='') {
	$prev = empty($prev )? '<i class="fa fa-angle-double-left"></i>': $prev ;
	$next = empty($next )? '<i class="fa fa-angle-double-right"></i>': $next ;
	
  global $wp_query, $wp_rewrite;
  $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
  if($pages==''){
    global $wp_query;
    $pages = $wp_query->max_num_pages;
    if(!$pages)
    {
      $pages = 1;
    }
  }
  $pagination = array(
    'base'          => str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
    'format'        => '',
    'current'       => max( 1, get_query_var('paged') ),
    'total'         => $pages,
    'prev_text'     => $prev,
    'next_text'     => $next,       
    'type'          => 'list',
    'end_size'      => 3,
    'mid_size'      => 3,
);
  $return =  paginate_links( $pagination );
  echo str_replace( "<ul class='page-numbers'>", '<ul class="pagination">', $return );
}
endif;



/**
 * Count our number of active panels.
 *
 * Primarily used to see if we have any panels active, duh.
 */
function skyre_panel_count() {

	$panel_count = 0;

	/**
	 * Filter number of front page sections in Skyre.
	 *
	 * @param int $num_sections Number of front page sections.
	 */
	$num_sections = apply_filters( 'skyre_front_page_sections', 4 );

	// Create a setting and control for each of the sections available in the theme.
	for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
		if ( get_theme_mod( 'panel_' . $i ) ) {
			$panel_count++;
		}
	}

	return $panel_count;
}

/**
 * Checks to see if we're on the homepage or not.
 */
function skyre_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}


function skyre_post_title(){
	if ( is_single() ) { the_title( '<h1 class="single-post-title">', '</h1>' );  }else {
		the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
	} 

}

function skyre_index_title(){
	if(skyre_get_post_option('title') != 1) : ?>
		<div class="post-title skpbg">
			<div class="container<?php if(skyre_get_post_option('blog_fullwidth') == 1) { ?>-fluid<?php } ?>">
				<?php if ( is_home() && ! is_front_page() ) : ?> 
				<h1 class="skwc"><?php single_post_title(); ?></h1>
				<?php else : ?>
				<h2 class="skwc"><?php _e( 'Posts', 'skyre' ); ?></h2>
				<?php endif; ?>
			</div>
		</div>
		<?php endif ;
}



function skyre_post_modern_header(){
	global $post;
	if(skyre_get_post_option('template_style') == 'modern' && is_single()) :  ?>
    <div class="post-modern-title single-post-title skpbg" <?php if ( has_post_thumbnail() )  {  echo sprintf( 'style="background-image:url(%s); background-size: cover;"', get_the_post_thumbnail_url() ); } ?> > 
        <div class="container<?php if(skyre_get_post_option('blog_fullwidth') == 1) { ?>-fluid<?php } ?>">
            <h1 class="skwc"><?php the_title(); ?></h1>
            <?php 
            $byline = sprintf(
                /* translators: %s: post author */
                __( ' Publicshed By %s', 'skyre' ),
                '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( $post->post_author ) ) . '">' . get_the_author_meta( 'display_name', $post->post_author ) . '</a></span>'
            );
             echo '<div class="post-meta skwc"> <span class="byline"> ' . $byline . '</span>  <span class="posted-on">' . __(' on ','skyre').get_the_date() . '</span> </div>';
            ?>
        </div>
    </div>
    <?php endif;
}

function skyre_post_content(){
	?>
	<div class="post-content">
		<?php
		$excerpt = '';
		if(is_single() || get_post_format() =='video' || get_post_format() =='gallery') {
			 the_content(); 
		}elseif (has_excerpt()) {
		  $excerpt = wp_strip_all_tags(get_the_excerpt());
		  echo esc_html($excerpt);
		}else{
			echo wp_trim_words(get_the_content(), 20, sprintf( __( ' <a class="post-readmore" href="%s"> Read More</a>', 'skyre' ), get_the_permalink() ) );
			}

		wp_link_pages( array(
			'before'      => '<div class="page-links">' . __( 'Pages:', 'skyre' ),
			'after'       => '</div>',
			'link_before' => '<span class="page-number">',
			'link_after'  => '</span>',
		) );
		?>
	</div><!-- .entry-content -->
	<div class="clear"></div>
<?php
	
}
function skyre_get_post_field($fields){
	foreach($fields as $field)
		{ 
			if (function_exists('skyre_post_'.$field)) :
				$postvalue = 'skyre_post_'.$field;
				$postvalue();
			endif;
		}
	
	}

function skyre_page_title(){
	?>
		<div class="page-title skpbg">
            <div class="container<?php if(skyre_get_page_option('fullwidth') == 1) { ?>-fluid<?php } ?>">
                <?php the_title('<h1 class="skwc">', '</h1>'); ?>
            </div>
        </div>
	<?php
}

function skyre_post_meta(){
	?>
		<?php if ( 'post' === get_post_type() ) { ?>
			<div class="post-meta">
				<?php  skyre_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php } ?>
    <?php
}

function skyre_post_image(){
	if ( has_post_thumbnail() )  {
	 ?>
		<div class="post-image">
			<a href="<?php the_permalink(); ?>">
				<?php 
				if( is_single()) { 
					the_post_thumbnail( 'full' );
				} 
				else { 
					the_post_thumbnail( 'featuredthumb' ); 
				} 
				?>
			</a>
		</div><!-- .post-thumbnail -->
	<?php 
	}
}

//custom post comment

function skyre_comment($comment, $args, $depth) {
    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
	}
	
	?>
    <<?php echo esc_attr($tag); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>"><?php 
    if ( 'div' != $args['style'] ) { ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php
    } ?>
        <div class="row">
        	<?php if(skyre_get_post_option('avatar_status') != 1 and get_option('show_avatars') == 1 ) { ?>
            <div class="avatar-wrap"> 
				<?php if ( $args['avatar_size'] != 0 ) {
					echo get_avatar( $comment, $args['avatar_size'] ); 
				} ?>
            </div>
            <?php } ?>
            <div class="col"> 
				<div class="authorlink"> <?php printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>','skyre' ), get_comment_author_link() ); ?> </div>
                <div class="date">
                	<div class="comment-meta commentmetadata">
                        <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><?php
                            /* translators: 1: date, 2: time */
                            printf( 
                                __('%1$s at %2$s','skyre'), 
                                get_comment_date(),  
                                get_comment_time() 
                            ); ?>
                        </a><?php 
                        edit_comment_link( __( '(Edit)','skyre' ), '  ', '' ); ?>
                    </div>
                </div>
			</div>
            <div class="col-2 reply"> <?php 
                comment_reply_link( 
                    array_merge( 
                        $args, 
                        array( 
                            'add_below' => $add_below, 
                            'depth'     => $depth, 
                            'max_depth' => $args['max_depth'] 
                        ) 
                    ) 
                ); ?> 
             </div>
            
        </div>
        <div class="clearfix"></div>
        <div class="content"> <?php comment_text(); ?> </div>
        
		<?php 
        if ( $comment->comment_approved == '0' ) { ?>
            <em class="comment-awaiting-moderation"><?php __( 'Your comment is awaiting moderation.', 'skyre' ); ?></em><br/><?php 
        } ?>
        
	

        <?php 
    if ( 'div' != $args['style'] ) : ?>
        </div><?php 
    endif;
}

//============= metabox ===============
function skyre_title_status_meta() {

	add_meta_box( 'skyre_title_status_meta', 'Title Status', 'skyre_title_status_render', 'page', 'side', 'default'  );
}
/**
 * Render the metabox markup
 * This is the function called in `_namespace_create_metabox()`
 */
function skyre_title_status_render() {
	global $post; // Get the current post data
	$val = get_post_meta( $post->ID, 'skyre_title_status_meta', true ); // Get the saved values
	?>
		<fieldset>
			<div>
				<label for="_namespace_custom_metabox">
					<?php
						// This runs the text through a translation and echoes it (for internationalization)
						_e( 'Disable Title?', 'skyre' );
					?>
				</label>
				<input type="checkbox" name="skyre_title_status_meta" id="skyre_title_status_meta" value="1"  <?php if( esc_attr( $val ) == 1) {?> checked <?php } ?>   >
                
                
			</div>
		</fieldset>
	<?php
	wp_nonce_field( 'skyre_title_status_nonce', 'skyre_title_status_process' );
}

function skyre_title_status_save( $post_id, $post ) {

	// Verify that our security field exists. If not, bail.
	if ( !isset( $_POST['skyre_title_status_process'] ) ) return;

	// Verify data came from edit/dashboard screen
	if ( !wp_verify_nonce( $_POST['skyre_title_status_process'], 'skyre_title_status_nonce' ) ) {
		return $post->ID;
	}
	// Verify user has permission to edit post
	if ( !current_user_can( 'edit_post', $post->ID )) {
		return $post->ID;
	}
	if ( isset( $_POST['skyre_title_status_meta'] ) ) {
		update_post_meta( $post->ID, 'skyre_title_status_meta', '1' );
	}else { update_post_meta( $post->ID, 'skyre_title_status_meta', '0' );}
	
}

//check individual page/post title status

function individual_title_status(){
	$val = 0;
	global $post; // Get the current post data
	$val = get_post_meta( $post->ID, 'skyre_title_status_meta', true ); // Get the saved values
	if($val !=1) { return true;}
	
	}

//============= end metabox ===============

function skyre_import_files() {
  
	$args = array();
	$defaults = array(
		'headers' => array(
			'Authorization' => 'Bearer '. skyre_get_token(),
			'User-Agent' => 'WordPress - Skyre',
		),
		'filter_by' => 'wordpress-themes',
		'timeout' => 20,
	);
	$args = wp_parse_args($args, $defaults);

	$url = 'https://data.'.SKYRE_DEMO_URL.'/demo/?key='.skyre_get_token();

	$response = wp_remote_get(esc_url_raw($url), $args);
	$response_code = wp_remote_retrieve_response_code($response);

	if ($response_code == '200') {
		$return = json_decode(wp_remote_retrieve_body($response), true);
	}
	else{
		$return = '';
	}
	return $return;

}

add_filter( 'pt-ocdi/import_files', 'skyre_import_files' );

if ( ! function_exists( 'skyre_get_token' ) ) :
	function skyre_get_token()
	{
		$token = get_option('envato_market', array());
		$return_token = '';
		if (!empty($token['token'])) {
			$return_token = $token['token'];
		}
		
		return $return_token;
	}
endif;

if ( ! function_exists( 'skyre_set_token' ) ) :
	function skyre_set_token()
	{
		if (isset($_POST['stm_registration'])) {
			if (isset($_POST['stm_registration']['token'])) {
				delete_site_transient('stm_theme_token_added');
				$token = array();
				$token['token'] = sanitize_text_field($_POST['stm_registration']['token']);
				update_option('envato_market', $token);
			}
		}
	}
endif;

/*-----------------------------------------------------------------------------------*/
/*	Load Widgets
/*-----------------------------------------------------------------------------------*/
require SKYRE_THEME_DIR."inc/widgets/widget-recent-posts.php"; // Recent Posts
/*-----------------------------------------------------------------------------------*/
/*	Exceprt Length
/*-----------------------------------------------------------------------------------*/