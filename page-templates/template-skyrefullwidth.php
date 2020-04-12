<?php
/*
 * Template Name: Skyre Full Width
 * Description: A Page Template with a Page Builder design.
 * @package     Skyre
 * @author      Skyretheme
 * @copyright   Copyright (c) 2019, Skyre
 * @link        https://skyretheme.com/sports
 * @since       1.0.0
 */
get_header(); ?>
	</header>
	<!-- End Header --> 

<?php if (have_posts()){ ?>
	
		<?php while (have_posts()) : the_post()?>
			<?php the_content(); ?>
		<?php endwhile; ?>
	
	<?php }else {
		esc_html_e('Page Canvas For Page Builder', 'skyre'); 
	}?>

<?php get_footer(); ?>