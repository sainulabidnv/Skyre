<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Skyre
 * @version 1.0
 */

get_header(); ?>

		<?php if(skyre_get_page_option('title_active') != 1) { ?>
         <div class="page-title">
            <div class="container<?php if(skyre_get_page_option('fullwidth') == 1) { ?>-fluid<?php } ?>">
                <h1>
				<?php if ( have_posts() ) : ?>
                        <?php printf( __( 'Search Results for: %s', 'skyre' ), '<span>' . get_search_query() . '</span>' ); ?>
                    <?php else : ?>
                       <?php _e( 'Nothing Found', 'skyre' ); ?>
                    <?php endif; ?>
            </div>
        </div>
        <?php } ?>
	</header>

<section class="page-section" >
    <div class="container<?php if(skyre_get_page_option('fullwidth') == 1) { ?>-fluid<?php } ?> ">
        <div class="row">
            <div class="<?php if(skyre_get_page_option('layout') != '2' ) { ?> col-lg-8 <?php } else {?> col-lg-12 <?php } ?>">

		<?php
		if ( have_posts() ) :
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/post/content', 'excerpt' );

			endwhile; // End of the loop.

			the_posts_pagination( array(
				'prev_text' => skyre_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'skyre' ) . '</span>',
				'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'skyre' ) . '</span>' . skyre_get_svg( array( 'icon' => 'arrow-right' ) ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'skyre' ) . ' </span>',
			) );

		else : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'skyre' ); ?></p>
			<?php
				get_search_form();

		endif;
		?>

		                


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
