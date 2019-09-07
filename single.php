<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Skyre
 * @version 1.0
 */

get_header(); ?>

    
</header>

<section id="single" class="skyre-single sk-border-15" >
    <div class="container<?php if(skyre_get_post_option('single_blog_fullwidth') == 1) { ?>-fluid<?php } ?>">
        <div class="row">
            <div class="<?php if(skyre_get_post_option('single_blog_layout') != '2' ) { ?> col-lg-8 <?php } else {?> col-lg-12 <?php } ?>">

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/post/content', get_post_format() );
				$prev_post = get_previous_post();
				$next_post = get_next_post()
				?>
                <div class="prevnxt_nav">
                	<div class="row">
                    	<?php if ( ! empty( $prev_post ) ): ?>
                        <div class="col-md">
                            <div class="item prev-post  sk-border-15">
                                <div class="nav-title"> <i class="fas fa-angle-double-left"></i>  <?php echo __( 'Previous Post', 'skyre' ); ?> </div>
                                    <a href="<?php echo get_permalink( $prev_post->ID ); ?>">
                                        <?php echo apply_filters( 'the_title', $prev_post->post_title, 10, 2 ); 
                                        ?>
                                    </a>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ( ! empty( $next_post ) ): ?>
                        <div class="col-md">
                            <div class="item next-post  sk-border-15">
                                <div class="nav-title"><?php echo __( 'Next Post', 'skyre' ); ?> <i class="fas fa-angle-double-right"></i></div>
                                    <a href="<?php echo get_permalink( $next_post->ID ); ?>">
                                        <?php echo apply_filters( 'the_title', $next_post->post_title, 10, 2 ); ?>
                                    </a>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <?php

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

				

			endwhile; // End of the loop.
			?>
			</div><!-- #primary -->
            <?php if(skyre_get_post_option('single_blog_layout') != '2' ) { ?> 
            <div class="col-lg-4 <?php if(skyre_get_post_option('single_blog_layout') == '1') { ?> order-first <?php } ?>">
                <div class="sidebar-section">
                    <?php get_sidebar();?>
                </div>
            </div>
            <?php } ?>
		</div>
    </div><!-- .wrap -->
</section> 

<?php get_footer();
