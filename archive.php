<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Skyre
 * @version 1.0
 */

get_header(); ?>
	
    <?php if(skyre_get_post_option('title') != 1) : ?>
    <div class="post-title skpbg">
        <div class="container<?php if(skyre_get_post_option('blog_fullwidth') == 1) { ?>-fluid<?php } ?>">
            <?php if ( is_home() && ! is_front_page() ) : ?> 
            <h1 class="skwc"><?php single_post_title(); ?></h1>
            <?php else : ?>
            <h1 class="skwc"><?php _e( 'Posts', 'skyre' ); ?></h1>
            <?php endif; ?>
        </div>
    </div>
    <?php endif ?>
</header>

<section id="primary" class="post-section archive-post">
    <div class="container<?php if(skyre_get_post_option('blog_fullwidth') == 1) { ?>-fluid<?php } ?>">
        <div class="row">
            <div class="<?php if(skyre_get_post_option('blog_layout') != '2' ) { ?> col-lg-8 <?php } else {?> col-lg-12 <?php } ?>">
            	<div class="row">

					<?php
                    if ( have_posts() ) :
            
                        /* Start the Loop */
                        while ( have_posts() ) : the_post();
            
                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            get_template_part( 'template-parts/post/content', get_post_format() );
            
                        endwhile;
            
                        the_posts_pagination( array(
                            'prev_text' => skyre_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'skyre' ) . '</span>',
                            'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'skyre' ) . '</span>' . skyre_get_svg( array( 'icon' => 'arrow-right' ) ),
                            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'skyre' ) . ' </span>',
                        ) );
            
                    else :
            
                        get_template_part( 'template-parts/post/content', 'none' );
            
                    endif;
                    ?>
				</div>
            </div>
            <?php if(skyre_get_post_option('blog_layout') != '2' ) { ?> 
            <div class="col-lg-4 <?php if(skyre_get_post_option('blog_layout') == '1') { ?> order-first <?php } ?>">
                <div class="sidebar-section">
                    <?php get_sidebar();?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section><!-- #section -->
	

<?php get_footer();

