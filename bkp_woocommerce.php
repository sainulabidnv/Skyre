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
	</header>

	<!-- End Header --> 
<section class="woo-skyre" >
    <div class="container<?php if(skyre_get_page_option('fullwidth') == 1) { ?>-fluid<?php } ?> ">
        <div class="row">
            <div class="col-lg-12">
                 <div class="blog-list page-content">
                <?php woocommerce_content(); ?>
                </div>
                
            </div>
        </div>
    </div>
</section>
<?php get_footer(); 