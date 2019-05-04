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
//delete_option( 'skyre_post' );
?>
</head>
<body <?php body_class('white'); ?> >  
    <!-- Header --> 
	<?php $image = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );  ?>
    <!-- Preloader  -->
	<?php if(skyre_get_option('loader') !=1){ ?>
    <div id="preloader">
			<ul class="loader">
				<li>
					<span class="cssload-loading cssload-one"></span>
					<span class="cssload-loading cssload-two"></span>
					<span class="cssload-loading-center"></span>
				</li>
			</ul>
		<div class="loader-section loader-top"></div>
   		<div class="loader-section loader-bottom"></div>
	</div>
    <?php } ?>
	<!-- Preloader End -->
    
    <header class="main-head">
    	<!--<div id="particles-js" class="particles-js"></div>-->
		<!-- Navbar -->
        <nav class="mainmenu <?php if(skyre_get_option('box_shadow')) { ?>box-shadow <?php } ?> <?php if(skyre_get_option('sticky_header') != 1) { ?>is-sticky <?php } ?> navbar navbar-expand-lg" id="mainmenu">
            <div class="container">
                <a class="navbar-brand  animated fadeInUpShort" data-animate="fadeInDown" data-delay=".65" href="<?php echo bloginfo( 'url' ); ?>">
                	<img class="logo logo-dark" alt="<?php echo get_bloginfo(); ?>" src="<?php echo $image[0]; ?>">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
                	<span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse  justify-content-end" id="navbarToggle">
                   <?php
						wp_nav_menu( array(
							'theme_location'  => 'primary',
							'depth'	          => 2, // 1 = no dropdowns, 2 = with dropdowns.
							'container'       => '',
							'container_class' => 'collapse navbar-collapse justify-content-end',
							'container_id'    => 'navbarToggle',
							'menu_class'      => 'navbar-nav menu-top text-uppercase',
							'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
							'walker'          => new WP_Bootstrap_Navwalker(),
						) );
					?>
                </div>
            </div> 
        </nav>
        
        
       
        

