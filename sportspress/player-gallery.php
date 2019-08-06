<?php
/**
 * Player Gallery
 *
 * @author 		ThemeBoy
 * @package 	SportsPress/Templates
 * @version   2.5
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$html5 = current_theme_supports( 'html5', 'gallery' );
$defaults = array(
	'id' => get_the_ID(),
	'title' => false,
	'number' => -1,
	'grouping' => null,
	'orderby' => 'default',
	'order' => 'ASC',
	'itemtag' => 'div',
	'icontag' => 'div',
	'captiontag' => 'div',
	'grouptag' => 'h4',
	'columncount' => 3,
	'columns' => array('photo','name'),
	'size' => 'sportspress-crop-medium',
	'show_all_players_link' => false,
	'link_posts' => get_option( 'sportspress_link_players', 'yes' ) == 'yes' ? true : false,
	'link_teams' => get_option( 'sportspress_link_teams', 'no' ) == 'yes' ? true : false,
	'show_player_flag' => get_option( 'sportspress_list_show_flags', 'no' ) == 'yes' ? true : false,
	'show_player_rank' => true,
);

extract( $defaults, EXTR_SKIP );

if(!empty($ws)) { 
	if ( in_array( 'rank', $ws['attr'] )) { $show_player_rank = true; } else {$show_player_rank = false; }
	if ( in_array( 'flag', $ws['attr'] )) { $show_player_flag = true; } else {$show_player_flag = false; }

}

// Determine number of players to display
if ( -1 === $number ):
	$number = (int) get_post_meta( $id, 'sp_number', true );
	if ( $number <= 0 ) $number = -1;
endif;

$itemtag = tag_escape( $itemtag );
$captiontag = tag_escape( $captiontag );
$icontag = tag_escape( $icontag );
$valid_tags = wp_kses_allowed_html( 'post' );
if ( ! isset( $valid_tags[ $itemtag ] ) )
	$itemtag = 'dl';
if ( ! isset( $valid_tags[ $captiontag ] ) )
	$captiontag = 'dd';
if ( ! isset( $valid_tags[ $icontag ] ) )
	$icontag = 'dt';

$columncount = intval( $columncount );
$itemwidth = $columncount > 0 ? floor(12/$columncount) : 3;


$size = $size;
$float = is_rtl() ? 'right' : 'left';

$selector = 'sp-player-gallery-' . $id;

$list = new SP_Player_List( $id );
$data = $list->data();
$labels = $data[0];

// Remove the first row to leave us with the actual data
unset( $data[0] );

if ( $grouping === null || $grouping === 'default' ):
	$grouping = $list->grouping;
endif;

if ( $orderby == 'default' ):
	$orderby = $list->orderby;
	$order = $list->order;
elseif ( $orderby == 'rand' ):
	uasort( $data, 'sp_sort_random' );
else:
	$list->priorities = array(
		array(
			'key' => $orderby,
			'order' => $order,
		),
	);
	uasort( $data, array( $list, 'sort' ) );
endif;

if ( $title )
	echo '<h4 class="sp-table-caption">' . $title . '</h4>';

$gallery_style = $gallery_div = '';
if ( apply_filters( 'use_default_gallery_style', ! $html5 ) )
	$gallery_style = "";
$size_class = sanitize_html_class( $size );
$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columncount-{$columncount} gallery-size-{$size_class}'>";
echo apply_filters( 'gallery_style', $gallery_style . "\n\t\t" );
?>
<?php echo $gallery_div; ?>
	<?php
	if ( intval( $number ) > 0 )
		$limit = $number;

	if ( $grouping === 'position' ):
		$groups = get_terms( 'sp_position', array(
			'orderby' => 'meta_value_num',
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key' => 'sp_order',
					'compare' => 'NOT EXISTS'
				),
				array(
					'key' => 'sp_order',
					'compare' => 'EXISTS'
				),
			),
		) );
	else:
		$group = new stdClass();
		$group->term_id = null;
		$group->name = null;
		$group->slug = null;
		$groups = array( $group );
	endif;

	$j = 0;

	foreach ( $groups as $group ):
		$i = 0;

		$gallery = '';

		

		foreach( $data as $player_id => $performance ): if ( empty( $group->term_id ) || has_term( $group->term_id, 'sp_position', $player_id ) ):

			if ( isset( $limit ) && $i >= $limit ) continue;

			//echo '<pre>';
			//print_r($performance);exit;
			
			
			$gallery .= '<div class="col-md-'.$itemwidth.'">
						<div class="sk-player-grid">';

			foreach($columns as $column) {
				if($column == 'photo') { 
					if ( has_post_thumbnail( $player_id ) ) $thumbnail = get_the_post_thumbnail( $player_id, $size );
					else $thumbnail = '<img width="250" height="250" src="//www.gravatar.com/avatar/?s=150&d=mm&f=y" class="attachment-thumbnail wp-post-image">';
					$gallery .= '<div class="player-photo">'.$thumbnail;
					
					if ( $show_player_flag ):
						$player = new SP_Player( $player_id );
						$nationalities = $player->nationalities();
						if ( ! empty( $nationalities ) ):
							$gallery .= '<div class="player-flag"><img src="' . plugin_dir_url( SP_PLUGIN_FILE ) . 'assets/images/flags/' . strtolower( $nationalities[0] ) . '.png" alt="' . $nationalities[0] . '"></div>' ;
						endif;
					endif;
		
					if ( $show_player_rank  ):
						
						$gallery .= '<div class="player-rank">'.$performance['number'].'</div>' ;
						
					endif;
					
					
					
					$gallery .= '</div>';
				} 
				else if($column == 'name') { 
					$name = get_the_title( $player_id );
					$name = trim( $name );
					if ( $link_posts ):
						$permalink = get_post_permalink( $player_id );
						$name = '<a href="' . $permalink . '">' . $name . '</a>';
					endif;

					$gallery .= '<div class="player-name">'.$name.'</div>';
				}
				



				else if($column == 'team') { 
					
					$team = sp_array_value( $column, 'team', get_post_meta( $player_id, 'sp_current_team', true ) );	
							
					$team_name = $team ? sp_team_short_name( $team ) : '-';
					
					if ( $link_teams && false !== get_post_status( $team ) ):
						$team_name = '<a href="' . get_post_permalink( $team ) . '">' . $team_name . '</a>';
					endif;
					$gallery .= '<div class="player-team" >' . $team_name . '</div>';
					
				}
				else { $gallery .= '<div class="player-column">'.$labels[$column].': '.$performance[$column].'</div>';}
			}
			

			$gallery .= '</div> </div>';

			

			
			
			


			/*ob_start();

		    sp_get_template( 'player-gallery-thumbnail.php', array(
		    	'id' => $player_id,
		    	'itemtag' => $itemtag,
		    	'icontag' => $icontag,
		    	'captiontag' => $captiontag,
		    	'caption' => $caption,
		    	'size' => $size,
				'link_posts' => $link_posts,
				'ws' => $ws,
		    ) );

			$gallery .= ob_get_clean();*/

			$i++;

		endif; endforeach;

		$j++;
	
		if ( $i === 0 ) continue;

		echo '<div class="sp-template sp-template-player-gallery sp-template-gallery">';
		if ( ! empty( $group->name ) ):
			echo '<' . $grouptag . ' class="position-heading">' . $group->name . '</' . $grouptag . '>';
		endif;
		echo '<div class="sp-player-gallery-wrapper sp-gallery-wrapper row">';
		
		echo $gallery;

		if ( ! $html5 && $columncount > 0 && ++$i % $columncount == 0 ) {
			echo '<br style="clear: both" />';
		}
		
		echo '</div>';

		if ( $show_all_players_link && ( 'position' !== $grouping || $j == count( $groups ) ) ) {
			echo '<div class="sp-player-gallery-link sp-gallery-link sk-sp-view-all-link"><a href="' . get_permalink( $id ) . '">' . __( 'View all players', 'sportspress' ) . '</a></div>';
		}

		echo '</div>';

	endforeach;

	if ( ! $html5 && $columncount > 0 && ++$i % $columncount == 0 ) {
		echo '<br style="clear: both" />';
	}
		
echo "</div>\n";
?>