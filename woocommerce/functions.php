<?php
/**
 * Woocommerce functions
 *
 * @package Skyre
 * @version 1.0
 */

add_action( 'after_setup_theme', 'splash_woocommerce_support' );
function splash_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

function skyre_woo_scripts() {
	// custom css for woocommerce
	wp_enqueue_style( 'skyre-woo-style', get_template_directory_uri().'/woocommerce/style.css');
}
add_action( 'wp_enqueue_scripts', 'skyre_woo_scripts' );
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 10 );
add_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals' );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' );
add_action( 'skyre_woo_page_title', 'skyre_woo_page_title' );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10); 
add_action( 'woocommerce_sidebar', 'skyre_woo_sidebar'); 
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'skyre_shop_breadcrumb', 'woocommerce_breadcrumb');


//add_action( 'woocommerce_breadcrumb', 'doactiontester'); 

function doactiontester(){
	?>
	<div> Do action TEST </div>
	<?php
}

function skyre_woo_page_title(){
	 if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		 <div class="page-title skpbg">
            <div class="container<?php if(skyre_get_page_option('fullwidth') == 1) { ?>-fluid<?php } ?>">
			<?php if ( is_single() ) : ?> 
				<h1 class="skwc"><?php single_post_title(); ?></h1>
				<?php else : ?>  
				<h1 class="woocommerce-products-header__title skwc"><?php woocommerce_page_title(); ?></h1>
				<?php endif; ?>
			
			  
            </div>
        </div>
	<?php endif;
}

function skyre_woo_sidebar(){
	if (  is_active_sidebar( 'shop' ) ) : ?>
		<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Post Sidebar', 'skyre' ); ?>">
			<?php dynamic_sidebar( 'shop' ); ?>
		</aside><!-- #secondary -->

   <?php endif;
}



