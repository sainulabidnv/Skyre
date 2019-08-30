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

$player = new SP_Player(  get_the_ID() ); $playerMeta = $player->data( 0 ); 
//echo '<pre>';
//print_r();
?>


         <?php if(skyre_get_player_option('title_active') != 1 and individual_title_status() ) { ?>
         
         <div class="sk-sports">
             <div class="page-title skpbg">
                <div class="container<?php if(skyre_get_player_option('fullwidth') == 1) { ?>-fluid<?php } ?>">
                	<div class="row">
						<div  class="col-lg-6 offset-md-6">
							<?php the_title('<h1 class="skwc">', '</h1>'); ?>
                    		<p> Age - 34  | Height - 165 cm |  Date of Birth - 05 February 1985 </p>
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
                <div class="col-lg-5">
                    <div class="profile">
                        <div class="player-pic"> <img src="<?php echo get_template_directory_uri().'/assets/img/prof-pic.jpg'; ?>" /> </div>
                        <span>13</span>
                    </div>
                </div>
                <div class="col-lg-7"> 
                    <ul class="player-meta">
                        <li><span>16</span> Gols </li>
                        <li><span>66.7</span> Win Ratio </li>
                        <li><span>16</span> Gols </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    
    <!--<section class="player-content" >
        <div class="container<?php if(skyre_get_player_option('fullwidth') == 1) { ?>-fluid<?php } ?> ">
            <div class="row">
                <div class="<?php if(skyre_get_player_option('layout') != '2' ) { ?> col-lg-8 <?php } else {?> col-lg-12 <?php } ?>">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="content">
                                <?php echo $player->post->post_content; ?>
                            </div>
                        </div>
                        <div class="col-lg-5"> 
                            <div class="sk-datatable">
                                <?php sportspress_output_player_details(); ?>
                            </div>
                        </div>
                        <div> <?php sportspress_output_player_statistics(); ?> </div>
                    </div>
                </div>
            </div>
        </div>
    </section>-->
 
<section class="page-section" >
    <div class="container<?php if(skyre_get_player_option('fullwidth') == 1) { ?>-fluid<?php } ?> ">
        <div class="row">
            <div class="<?php if(skyre_get_player_option('layout') != '2' ) { ?> col-lg-8 <?php } else {?> col-lg-12 <?php } ?>">
                <div class="blog-list page-content">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php //$player->player_content(); //the_post_thumbnail() ?>
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

            <?php if(skyre_get_player_option('layout') != '2' ) { ?> 
            <div class="col-lg-4 <?php if(skyre_get_player_option('layout') == '1') { ?> order-first <?php } ?>">
                <div class="sidebar-section">
                    <?php get_sidebar();?>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>
</section>

<?php get_footer(); 