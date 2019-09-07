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
/*
$defaults = array(
	'show_number' => get_option( 'sportspress_player_show_number', 'no' ) == 'yes' ? true : false,
	'show_name' => get_option( 'sportspress_player_show_name', 'no' ) == 'yes' ? true : false,
	'show_nationality' => get_option( 'sportspress_player_show_nationality', 'yes' ) == 'yes' ? true : false,
	'show_positions' => get_option( 'sportspress_player_show_positions', 'yes' ) == 'yes' ? true : false,
	'show_current_teams' => get_option( 'sportspress_player_show_current_teams', 'yes' ) == 'yes' ? true : false,
	'show_past_teams' => get_option( 'sportspress_player_show_past_teams', 'yes' ) == 'yes' ? true : false,
	'show_leagues' => get_option( 'sportspress_player_show_leagues', 'no' ) == 'yes' ? true : false,
	'show_seasons' => get_option( 'sportspress_player_show_seasons', 'no' ) == 'yes' ? true : false,
	'show_nationality_flags' => get_option( 'sportspress_player_show_flags', 'yes' ) == 'yes' ? true : false,
	'link_teams' => get_option( 'sportspress_link_teams', 'no' ) == 'yes' ? true : false,
);

extract( $defaults, EXTR_SKIP );
*/


$layout = empty(get_option('sportspress_single_player_sidebar')) ? 'no' : get_option('sportspress_single_player_sidebar');
$mettrics = $player->metrics();
$sta = $playerMeta['-1'];

$statistics = $player->statistics;

//$data = apply_filters( 'sportspress_player_details', $data, $id );

echo '<pre>';
//print_r( $player); 
echo '</pre>';
//exit;
?>


         <?php if(skyre_get_player_option('title_active') != 1 and individual_title_status() ) { ?>
         
         <div class="sk-sports">
             <div class="page-title skpbg">
                <div class="container<?php if(skyre_get_player_option('fullwidth') == 1) { ?>-fluid<?php } ?>">
                	<div class="row">
						<div  class="col-md-6 offset-md-6">
							<?php the_title('<h1 class="skwc">', '</h1>'); ?>
                    		<div class="skwc opacity"><?php echo !empty($mettrics['Height']) ? 'Height - ' .$mettrics['Height'].' | ':''; echo !empty($mettrics['Weight']) ? 'Weight - ' .$mettrics['Weight']:''; ?> </div>
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
                        <span class="sktbg skpc"><?php echo $player->number; ?></span>
                    </div>
                </div>
                <div class="col-md-7"> 
                    <ul class="player-meta">
                    <li><span><?php echo !empty($sta['goals']) ? $sta['goals']:'0' ?></span> Goals </li>
                    <li><span><?php echo !empty($sta['assists']) ? $sta['assists']:'0' ?></span> Assists </li>
                    <li><span><?php echo !empty($sta['winratio']) ? $sta['winratio']:'0' ?></span> Win Ratio </li>
                    <div class="clearfilter"></div>  
                    
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
            <div class="<?php if($layout != 'no' ) { ?> col-lg-8 sidebar <?php } else {?> col-lg-12 nosidebar <?php } ?>">
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

            <?php if($layout != 'no' ) { ?> 
            <div class="col-lg-4 <?php if($layout == 'left') { ?> order-first <?php } ?>">
                <div class="sidebar-section">
                    <?php get_sidebar();?>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>
</section>

<?php get_footer(); 