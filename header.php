<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Skyre
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); 


//delete_option( 'myOptions' );
//echo '<pre>';
//print_r(get_option( 'skyre[sp_player_field_title1]' ));
//echo '</pre>';


?>
</head>
<body <?php body_class('white'); ?> >  
    <!-- Header --> 
	<!-- Preloader  -->
	<?php do_action('skyre_preloader'); ?>
    <header class="main-head">
	<?php do_action('skyre_mainmenu'); ?>	