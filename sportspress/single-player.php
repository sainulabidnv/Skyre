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
$sidebar = empty(get_option('sportspress_single_player_sidebar')) ? 'no' : get_option('sportspress_single_player_sidebar');
$mettrics = $player->metrics();
$sta = $playerMeta['-1'];

$statistics = $player->statistics;

//$data = apply_filters( 'sportspress_player_details', $data, $id );


?>


         <?php if(skyre_get_player_option('title_active') != 1 and individual_title_status() ) { ?>
         
         <div class="sk-sports sk-single-player">
             <div class="sp-page-title skpbg">
                <div class="container<?php if(skyre_get_player_option('fullwidth') == 1) { ?>-fluid<?php } ?>">
                	<div class="row">
						<div  class="col-md-6 offset-md-6">
							<?php the_title('<h1 class="skwc">', '</h1>'); ?>
                    		<div class="skwc opacity"><?php echo !empty($mettrics['Height']) ? __('Height','skyre').' - ' .$mettrics['Height'].' | ':''; echo !empty($mettrics['Weight']) ? __('Weight','skyre').' - ' .$mettrics['Weight']:''; ?> </div>
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
                        <span class="sktbg skpc"><?php echo esc_attr($player->number); ?></span>
                    </div>
                </div>
                <div class="col-md-7"> 
                    <ul class="player-meta">
                    <?php $pl_options = get_option( 'skyre' ) ?>
                    <li><span><?php echo !empty($sta[$pl_options['sp_player_field1']]) ? $sta[$pl_options['sp_player_field1']]:'0' ?></span> <?php _e($pl_options['sp_player_field_title1'],'skyre'); ?> </li>
                    <li><span><?php echo !empty($sta[$pl_options['sp_player_field2']]) ? $sta[$pl_options['sp_player_field2']]:'0' ?></span> <?php _e($pl_options['sp_player_field_title2'],'skyre'); ?> </li>
                    <li><span><?php echo !empty($sta[$pl_options['sp_player_field3']]) ? $sta[$pl_options['sp_player_field3']]:'0' ?></span> <?php _e($pl_options['sp_player_field_title3'],'skyre'); ?> </li>
                    
                    <div class="clearfilter"></div>  
                    
                    </ul>
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
                        <?php the_content(); ?>
                        <?php
                            wp_link_pages( array(
                                'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'skyre' ) . '</span>',
                                'after'       => '</div>',
                                'link_before' => '<span>',
                                'link_after'  => '</span>',
                                'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'skyre' ) . ' </span>%',
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