<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package icos
 */
get_header(); 
?>


         <?php if(skyre_get_page_option('title_active') != 1 and individual_title_status() ) { ?>
         
         <div class="page-title skpbg">
            <div class="container<?php if(skyre_get_page_option('fullwidth') == 1) { ?>-fluid<?php } ?>">
                <?php the_title('<h1 class="skwc">', '</h1>'); ?>
            </div>
        </div>
        <?php } ?>
	</header>
	<!-- End Header --> 


 
<section class="page-section" >
    <div class="container<?php if(skyre_get_page_option('fullwidth') == 1) { ?>-fluid<?php } ?> ">
        <div class="row">
            <div class="<?php if(skyre_get_page_option('layout') != '2' ) { ?> col-lg-8 <?php } else {?> col-lg-12 <?php } ?>">
            

                <div class="blog-list page-content">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php the_post_thumbnail() ?>
                        <?php the_content(); ?>
                        <div class="clear"></div> 
                        <?php
                            wp_link_pages( array(
                                'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'skyre' ) . '</span>',
                                'after'       => '</div> <div class="clear"></div> ',
                                'link_before' => '<span>',
                                'link_after'  => '</span>',
                                'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'skyre' ) . ' </span>%',
                                'separator'   => '<span class="screen-reader-text">, </span>',
                            ) );
                        ?>
                        
                        <?php
                            if ( comments_open() || get_comments_number() ) :
                                comments_template();
                            endif;
                        ?>      
                    <?php endwhile; ?>
                </div>
                <div class="clear"></div>
                
                <?php echo skyre_pagination(); ?>


            </div>

            <?php if(skyre_get_page_option('layout') != '2' ) { ?> 
            <div class="col-lg-4 <?php if(skyre_get_page_option('layout') == '1') { ?> order-first <?php } ?>">
                <div class="sidebar-section">
                    <?php get_sidebar();?>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>
</section>

<?php get_footer(); 