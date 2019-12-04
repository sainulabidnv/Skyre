<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Skyre
 * @version 1.0
 */

?>

    <!--Footer-->
    <footer class="footer skpbg skwc">
    	<div class="footer-main">
			
            <!--Footer widget-->
            <div class="footer-widget">
            	<div class="container py-5">
                	<div class="row">
					<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
                        <div class="col-sm"> <?php dynamic_sidebar( 'sidebar-2' ); ?> </div>
                    <?php endif; ?> 
                    <?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
                        <div class="col-sm"> <?php dynamic_sidebar( 'sidebar-3' ); ?> </div>
                    <?php endif; ?> 
                    <?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
                        <div class="col-sm"> <?php dynamic_sidebar( 'sidebar-4' ); ?> </div>
                    <?php endif; ?> 
                    </div>
                </div>
			</div>
			<!--Footer Nav-->
			<?php if ( has_nav_menu( 'footer' ) || has_nav_menu( 'social_icons' ))   { ?>
			<div class="container py-5">
               <?php 
				if ( has_nav_menu( 'social_icons' ) ) {
					wp_nav_menu(
						array(
							'theme_location'  => 'social_icons',
							'container'       => 'nav',
							'container_id'    => 'social_icons',
							'container_class' => '',
							'menu_id'         => '',
							'menu_class'      => 'social-nav ',
							'depth'           => 1,
							'fallback_cb'     => '',
						/*'link_before'     => '<i class="social_icon fa"><span>',
						'link_after'      => '</span></i>'*/
						)
					);
				}
				?>
               <!--end social-->
                <div class="clearfix"></div>
                <?php 
					if ( has_nav_menu( 'footer' ) ) {
						wp_nav_menu(
							array(
								'theme_location'  => 'footer',
								'container'       => 'nav',
								'container_id'    => 'footer_menu',
								'container_class' => '',
								'menu_id'         => '',
								'menu_class'      => 'nav justify-content-center',
								'depth'           => 1,
								'fallback_cb'     => '',
							)
						);
					}
				?>
            </div>
		</div> <!--Footer Main-->
		<?php } ?>
        <?php if(skyre_get_option('custom_footer_text')) { ?>
        <div class="footer-botom py-4 text-center">
        	<div class="container"> <?php echo skyre_get_option('custom_footer_text'); ?> </div>
        </div>
        <?php } ?>
        
    </footer>
    <!--End Footer-->
	
	<!--scrollTop-->
	<?php if(skyre_get_option('scrolltop') !=1){ ?> <div id="stop" class="scrollTop"> <a href=""><i class="fas fa-angle-up"></i></a></div> <?php } ?>
	<!--End scrollTop-->
    
<?php wp_footer(); ?>

</body>
</html>
