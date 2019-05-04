<?php
/**
 * Template for displaying search forms in Skyre
 *
 * @package Skyre
 * @version 1.0
 */

?>

<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo $unique_id; ?>">
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'skyre' ); ?></span>
	</label>
	<p> <input type="search" id="<?php echo $unique_id; ?>" class="form-control sk-form search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'skyre' ); ?>" value="<?php echo get_search_query(); ?>" name="s" /></p>
	<p class="search-button"> <button type="submit" class="search-submit btn btn-skyre"><?php echo _x( ' &nbsp; Search &nbsp; ', 'submit button', 'skyre' ); ?></button></p>
</form>
