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
$sidebar = empty(get_option('sportspress_single_staff_sidebar')) ? 'no' : get_option('sportspress_single_staff_sidebar');
$staff = new SP_Staff( get_the_ID() );
$current_teams = $staff->current_teams();
$role  = $staff->role();

?>


         <?php if(skyre_get_player_option('title_active') != 1 and individual_title_status() ) { ?>
         
         <div class="sk-sports">
             <div class="sp-page-title skpbg">
                <div class="container<?php if(skyre_get_player_option('fullwidth') == 1) { ?>-fluid<?php } ?>">
                	<div class="row">
						<div  class="col-md-6 offset-md-6">
							<?php the_title('<h1 class="skwc">', '</h1>'); ?>
                    		<div class="skwc opacity"><?php echo !empty($role->name ) ? $role->name .', ':''; echo !empty($current_teams[0]) ? sp_team_short_name( $current_teams[0] ):''; ?> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
	</header>
	<!-- End Header --> 

    <section class="player-meta" >
        <div class="container<?php if(skyre_get_player_option('fullwidth') == 1) { ?>-fluid<?php } ?> ">
             <div class="row">
                <div class="col-md-5">
                    <div class="profile">
                        <div class="player-pic" >
                            <?php 
                            if ( has_post_thumbnail() )  echo get_the_post_thumbnail( '', 'skyre-player-large' );
					        else echo '<img src="'. get_template_directory_uri().'/sportspress/assets/img/player-large.jpg"  alt="' . get_the_title(). '" />';
                            ?>  
                        </div>
                    </div>
                </div>
                <div class="col-md-7"> 
                    <p class="pt-5"> <?php echo $staff->post->post_excerpt; ?></p>
                </div>
            </div>
        </div>
    </section>
 
<section class="page-section" >
    <div class="container<?php if(skyre_get_player_option('fullwidth') == 1) { ?>-fluid<?php } ?> ">
        <div class="row">
            <div class="<?php if($sidebar != 'no' ) { ?> col-lg-8 sidebar <?php } else {?> col-lg-12 nosidebar <?php } ?>">
                <div class="blog-list page-content">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php //echo $player->post->post_content; //the_post_thumbnail() ?>
                        <?php the_content(); ?>
                        <?php
                            wp_link_pages( array(
                                'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'icos' ) . '</span>',
                                'after'       => '</div>',
                                'link_before' => '<span>',
                                'link_after'  => '</span>',
                                'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'icos' ) . ' </span>%',
                                'separator'   => '<span class="screen-reader-text">, </span>',
                            ) );
                        ?>
                        
                        <?php
                            if ( comments_open() || get_comments_number() ) :
                                comments_template();
                            endif;
                        ?>      
                    <?php endwhile; ?>
                </div>
                
                <?php echo skyre_pagination(); ?>


            </div>

            <?php if($sidebar != 'no' ) { ?> 
            <div class="col-lg-4 <?php if($sidebar == 'left') { ?> order-first <?php } ?>">
                <div class="sidebar-section">
                    <?php get_sidebar();?>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>
</section>

<?php get_footer(); 