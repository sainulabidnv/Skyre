<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Skyre
 * @version 1.0
 */

get_header(); 

if(skyre_get_option('errorpage')) :
	$id=skyre_get_option('errorpage'); 
	$post = get_post($id); 
	$content = apply_filters('the_content', $post->post_content); 
	echo wp_kses_post($content);
else:
?>
    
    <div class="post-title skpbg">
        <div class="container<?php if(skyre_get_post_option('blog_fullwidth') == 1) { ?>-fluid<?php } ?>">
            <h1 class="skwc"><?php _e( 'Oops! That page can&rsquo;t be found.', 'skyre' ); ?></h1>
        </div>
    </div>
</header>  
<section id="primary" class="post-section">
    <div class="container<?php if(skyre_get_post_option('blog_fullwidth') == 1) { ?>-fluid<?php } ?>">
    	<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'skyre' ); ?></p>
        <?php get_search_form(); ?>
    </di><!-- #primary -->
</section> <!-- section -->           
 

<?php endif; ?>
<?php get_footer();