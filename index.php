<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package     Skyre
 * @author      Skyretheme
 * @copyright   Copyright (c) 2019, Skyre
 * @link        https://skyretheme.com/sports
 * @since       1.0.0
 */
get_header(); 
do_action('skyre_index_title');
?>
</header>
<section id="primary" class="post-section">
    <div class="container<?php if(skyre_get_post_option('blog_fullwidth') == 1) { ?>-fluid<?php } ?>">
        <div class="row">
            <div class="<?php if(skyre_get_post_option('blog_layout') != '2' ) { ?> col-lg-8 <?php } else {?> col-lg-12 <?php } ?>">
                <?php
                if ( have_posts() ) :
                    ?>
                    <div class='sk-post-wrap row'>
                    <?php
        
                    /* Start the Loop */
                    while ( have_posts() ) : the_post();
        
                        /*
                            * Include the Post-Format-specific template for the content.
                            * If you want to override this in a child theme, then include a file
                            * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                            */
                        
                            get_template_part( 'template-parts/post/content', get_post_format() );
        
                    endwhile;
                    ?>
                    </div> 
                    <div class='clear'></div>
                    <?php
        
                    do_action('skyre_index_pagination');
        
                else :
        
                    get_template_part( 'template-parts/post/content', 'none' );
        
                endif;
                ?>
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