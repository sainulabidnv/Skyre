<?php
/**
 * Additional features to allow styling of the templates
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
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
	// if ( is_page_template( array( 'page-templates/template-leftsidebar.php', 'page-templates/template-fullwidth.php',  '' ) ) ) {
	if ( is_page() && !is_page_template() ) {
		$classes[] = 'skyre-page';
	}
	if ( is_single() ) {
		$classes[] = 'skyre-single-post';
	}
	
	// Get the colorscheme or the default if there isn't one.
	//$colors = skyre_sanitize_colorscheme( get_theme_mod( 'colorscheme', 'light' ) );
	//$classes[] = 'colors-' . $colors;

	return $classes;
}
add_filter( 'body_class', 'skyre_body_classes' );

/** Pagination **/
if ( ! function_exists( 'skyre_pagination' ) ) :
function skyre_pagination($prev = '<i class="fa fa-angle-double-left"></i>', $next = '<i class="fa fa-angle-double-right"></i>', $pages='') {
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
	 * @since Skyre 1.0
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
function skyre_post_content(){
	?>
	<div class="post-content">
		<?php
		$excerpt = '';
		if(is_single() || get_post_format() =='video' || get_post_format() =='gallery') {
			 the_content(); 
		}elseif (has_excerpt()) {
		  echo  $excerpt = wp_strip_all_tags(get_the_excerpt());
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


function skyre_post_meta(){
	?>
		<?php if ( 'post' === get_post_type() ) { ?>
			<div class="post-meta">
				<?php if ( is_single() ) { skyre_posted_on(); } else { echo skyre_time_link(); skyre_edit_link(); }; ?>
			</div><!-- .entry-meta -->
		<?php } ?>
    <?php
}

function skyre_post_image(){
	 ?>
		<div class="post-image">
			<a href="<?php the_permalink(); ?>">
				<?php 
				if ( has_post_thumbnail() )  {
					if( is_single()) { the_post_thumbnail( 'full' );} 
					else { the_post_thumbnail( 'featuredthumb' ); } 
				}else if( !is_single()) echo '<img height="300" width="450" src="'.SKYRE_THEME_URI.'assets/img/place-holder.svg">';
				?>
			</a>
		</div><!-- .post-thumbnail -->
	<?php 
}

//custom post comment

function skyre_comment($comment, $args, $depth) {
    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }?>
    <<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>"><?php 
    if ( 'div' != $args['style'] ) { ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php
    } ?>
        <div class="row">
        	<?php if(skyre_get_post_option('avatar_status') != 1) { ?>
            <div class="avatar-wrap"> 
				<?php if ( $args['avatar_size'] != 0 ) {
					echo get_avatar( $comment, $args['avatar_size'] ); 
				} ?>
            </div>
            <?php } ?>
            <div class="col"> 
				<div class="authorlink"> <?php printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>' ), get_comment_author_link() ); ?> </div>
                <div class="date">
                	<div class="comment-meta commentmetadata">
                        <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><?php
                            /* translators: 1: date, 2: time */
                            printf( 
                                __('%1$s at %2$s'), 
                                get_comment_date(),  
                                get_comment_time() 
                            ); ?>
                        </a><?php 
                        edit_comment_link( __( '(Edit)' ), '  ', '' ); ?>
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
            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em><br/><?php 
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
add_action( 'add_meta_boxes', 'skyre_title_status_meta' );

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
add_action( 'save_post', 'skyre_title_status_save', 1, 2 );

//check individual page/post title status

function individual_title_status(){
	$val = 0;
	global $post; // Get the current post data
	$val = get_post_meta( $post->ID, 'skyre_title_status_meta', true ); // Get the saved values
	if($val !=1) { return true;}
	
	}

//============= end metabox ===============

//add_action( 'skyre_post_template_part', 'skyre_post_title', 2 );
//add_action( 'skyre_post_template_part', 'skyre_post_description', 1 );

function skyre_import_files() {
  return array(
    array(
      'import_file_name'             => 'Demo Import [Dark]',
      'categories'                   => array( ),
      'local_import_file'            => SKYRE_THEME_DIR . 'inc/data/dark/demo-content.xml',
      'local_import_widget_file'     => SKYRE_THEME_DIR . 'inc/data/dark/widgets.wie',
      'local_import_customizer_file' => SKYRE_THEME_DIR . 'inc/data/dark/customizer.dat',
      'local_import_redux'           => array( ),
      'import_preview_image_url'     => SKYRE_THEME_URI . 'screenshot.png',
      'import_notice'                => __( 'After you import this demo, you will have to setup menu separately.', 'skyre' ),
      'preview_url'                  => 'http://www.your_domain.com/my-demo-1',
    ),
    array(
      'import_file_name'             => 'Demo Import [Dark Animate]',
      'categories'                   => array( ),
      'local_import_file'            => SKYRE_THEME_DIR . 'inc/data/dark/demo-content.xml',
      'local_import_widget_file'     => SKYRE_THEME_DIR . 'inc/data/dark/widgets.wie',
      'local_import_customizer_file' => SKYRE_THEME_DIR . 'inc/data/dark/customizer.dat',
      'local_import_redux'           => array( ),
      'import_preview_image_url'     => SKYRE_THEME_URI . 'screenshot.png',
      'import_notice'                => __( 'After you import this demo, you will have to setup the menu separately.', 'skyre' ),
      'preview_url'                  => 'http://www.your_domain.com/my-demo-1',
    ),
  );
}
add_filter( 'pt-ocdi/import_files', 'skyre_import_files' );

/*-----------------------------------------------------------------------------------*/
/*	Load Widgets
/*-----------------------------------------------------------------------------------*/
//include(SKYRE_THEME_DIR."inc/widgets/widget-popular-posts.php"); // Popular Posts
//include(SKYRE_THEME_DIR."inc/widgets/widget-random-posts.php"); // Random Posts
include(SKYRE_THEME_DIR."inc/widgets/widget-recent-posts.php"); // Recent Posts
//include(SKYRE_THEME_DIR."inc/widgets/widget-tabs.php"); // Tabs Widget
//include(SKYRE_THEME_DIR."inc/widgets/widget-video.php"); // Video Widget
/*-----------------------------------------------------------------------------------*/
/*	Exceprt Length
/*-----------------------------------------------------------------------------------*/

