<?php
/**
 * Displays footer site info
 *
 * @package     Skyre
 * @author      Skyretheme
 * @copyright   Copyright (c) 2019, Skyre
 * @link        https://skyretheme.com/sports
 * @since       1.0.0
 */

?>
<div class="site-info">
	<?php
	if ( function_exists( 'the_privacy_policy_link' ) ) {
		the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span>' );
	}
	?>
	<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'skyre' ) ); ?>" class="imprint">
		<?php printf( __( 'Proudly powered by %s', 'skyre' ), 'WordPress' ); ?>
	</a>
</div><!-- .site-info -->
