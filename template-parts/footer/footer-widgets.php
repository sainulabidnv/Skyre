<?php
/**
 * Displays footer widgets if assigned
 *
 * @package Skyre
 * @version 1.0
 */

?>

<?php
if ( is_active_sidebar( 'footer-sidebar-1' ) ||
	 is_active_sidebar( 'footer-sidebar-2' ) ) :
?>

	<aside class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Footer', 'skyre' ); ?>">
		<?php
		if ( is_active_sidebar( 'footer-sidebar-1' ) ) { ?>
			<div class="widget-column footer-widget-1">
				<?php dynamic_sidebar( 'footer-sidebar-1' ); ?>
			</div>
		<?php }
		if ( is_active_sidebar( 'footer-sidebar-2' ) ) { ?>
			<div class="widget-column footer-widget-2">
				<?php dynamic_sidebar( 'footer-sidebar-2' ); ?>
			</div>
		<?php } ?>
	</aside><!-- .widget-area -->

<?php endif; ?>
