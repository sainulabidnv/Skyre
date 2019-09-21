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
	//wp_enqueue_style( 'skyre-woo-style', get_template_directory_uri().'/woocommerce/style.css');
}
add_action( 'wp_enqueue_scripts', 'skyre_woo_scripts' );
function clearo(){
	echo '<div class="clear"> dfsd </div>';
}
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 10 );
//add_action( 'woocommerce_cart_collaterals', 'clearo' );
add_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals' );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' );




