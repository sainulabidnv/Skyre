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
 * @package     Skyre
 * @author      Skyretheme
 */
get_header(); 
$player = new SP_Player(  get_the_ID() ); 
$playerMeta = $player->data( 0 ); 

$sidebar = empty(get_option('sportspress_single_player_sidebar')) ? 'no' : get_option('sportspress_single_player_sidebar');
$mettrics = $player->metrics();
$sta = $playerMeta['-1'];
$pl_options = get_option( 'skyre' ) ;
$field1 = !empty($pl_options['sp_player_field1']) ? $pl_options['sp_player_field1']:'goals';
$fieldtitle1 = !empty($pl_options['sp_player_field_title1']) ? $pl_options['sp_player_field_title1']:'Goals';
$field2 = !empty($pl_options['sp_player_field2']) ? $pl_options['sp_player_field2']:'assist';
$fieldtitle2 = !empty($pl_options['sp_player_field_title2']) ? $pl_options['sp_player_field_title2']:'Assist';
$field3 = !empty($pl_options['sp_player_field3']) ? $pl_options['sp_player_field3']:'winratio';
$fieldtitle3 = !empty($pl_options['sp_player_field_title3']) ? $pl_options['sp_player_field_title3']:'Win Ratio';
$statistics = $player->statistics;

$countries = SP()->countries->countries;
$nationalities = $player->nationalities();
if ( $nationalities && is_array( $nationalities ) ):
    $values = array();
    foreach ( $nationalities as $nationality ):
        $country_name = sp_array_value( $countries, $nationality, null );
        $values[] = $country_name ? '<img src="' . plugin_dir_url( SP_PLUGIN_FILE ) . 'assets/images/flags/' . strtolower( $nationality ) . '.png" alt="' . $nationality . '"> '  . $country_name : '&mdash;';
    endforeach;
    $nationname = implode( '<br>', $values );
endif;  

?>
         <?php if(skyre_get_player_option('title_active') != 1 and individual_title_status() ) { ?>
         
         <div class="sk-sports sk-single-player">
             <div class="sp-page-title skpbg">
                <div class="container<?php if(skyre_get_player_option('fullwidth') == 1) { ?>-fluid<?php } ?>">
                	<div class="row">
						<div  class="col-md-6 offset-md-6">
							<?php the_title('<h1 class="skwc">', '</h1>'); ?>
                    		<div class="skwc opacity"><?php  echo !empty($nationname) ? $nationname .' | ':''; echo !empty($player->team) ? __('Team','skyre').' - ' .get_the_title($player->team) :''; ?> </div>
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
                    <li><span><?php echo !empty($sta[$field1]) ? $sta[$field1]:'0' ?></span> <?php echo esc_attr( $fieldtitle1 ); ?> </li>
                    <li><span><?php echo !empty($sta[$field2]) ? $sta[$field2]:'0' ?></span> <?php echo esc_attr( $fieldtitle2 ); ?> </li>
                    <li><span><?php echo !empty($sta[$field3]) ? $sta[$field3]:'0' ?></span> <?php echo esc_attr( $fieldtitle3 ); ?> </li>
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