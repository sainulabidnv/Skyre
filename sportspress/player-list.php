<?php
/**
 * Player List
 *
 * @author 		Skyretheme
 * @package 	SkyreSports/Templates
 * @version   1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$defaults = array(
	'id' => get_the_ID(),
	'title' => false,
	'number' => -1,
	'grouptag' => 'h4',
	'columns' => null,
	'grouping' => null,
	'orderby' => 'default',
	'order' => 'ASC',
	'show_all_players_link' => false,
	'show_title' => get_option( 'sportspress_list_show_title', 'yes' ) == 'yes' ? true : false,
	'show_player_photo' => get_option( 'sportspress_list_show_photos', 'no' ) == 'yes' ? true : false,
	'show_player_flag' => get_option( 'sportspress_list_show_flags', 'no' ) == 'yes' ? true : false,
	'team_format' => get_option( 'sportspress_list_team_format', 'name' ),
	'link_posts' => get_option( 'sportspress_link_players', 'yes' ) == 'yes' ? true : false,
	'link_teams' => get_option( 'sportspress_link_teams', 'no' ) == 'yes' ? true : false,
	'responsive' => get_option( 'sportspress_enable_responsive_tables', 'no' ) == 'yes' ? true : false,
	'sortable' => get_option( 'sportspress_enable_sortable_tables', 'yes' ) == 'yes' ? true : false,
	'scrollable' => get_option( 'sportspress_enable_scrollable_tables', 'yes' ) == 'yes' ? true : false,
	'paginated' => get_option( 'sportspress_list_paginated', 'yes' ) == 'yes' ? true : false,
	'rows' => get_option( 'sportspress_list_rows', 10 ),
	'leagues' => null,
	'seasons' => null,
	'team' => null,
	'ws' => null,
);

extract( $defaults, EXTR_SKIP );
if(isset($ws['table_style'])){ $table_style = $ws['table_style']; } 
else {$table_style = empty(get_option('sk_sportspress_table_style')) ? 'table-borderless' : get_option('sk_sportspress_table_style');}
if(!empty($ws)) { 
	if ( in_array( 'photo', $ws['attr'] )) { $show_player_photo = true; } else {$show_player_photo = false; }
	if ( in_array( 'flag', $ws['attr'] )) { $show_player_flag = true; } else {$show_player_flag = false; }

}
//if ( in_array( 'content', $settings['list_attr'] )) {
$paginated = true;
if ( isset( $performance ) )
	$columns = $performance;

// Determine number of players to display
if ( -1 === $number ):
	$number = (int) get_post_meta( $id, 'sp_number', true );
	if ( $number <= 0 ) $number = -1;
endif;

// Explode into array
if ( null !== $columns && ! is_array( $columns ) )
	$columns = explode( ',', $columns );

$list = new SP_Player_List( $id );
if ( isset( $columns ) && null !== $columns ):
	$list->columns = $columns;
endif;

$data = $list->data( false, $leagues, $seasons, $team );


if ( isset( $columns ) && null !== $columns ):
	foreach($columns as $val) { $labels[$val] = $data[0][$val];}
	else:
	$labels = $data[0];
endif;

//Create a unique identifier based on the current time in microseconds
$identifier = uniqid( 'playerlist_' );
// If responsive tables are enabled then load the inline css code
if ( true == $responsive ){
	//sportspress_responsive_tables_css( $identifier );
}
// Remove the first row and 'head' row to leave us with the actual data
unset( $data[0] );

if ( $grouping === null || $grouping === 'default' ):
	$grouping = $list->grouping;
endif;

if ( $orderby == 'default' ):
	$orderby = $list->orderby;
	$order = $list->order;
else:
	$list->priorities = array(
		array(
			'key' => $orderby,
			'order' => $order,
		),
	);
	uasort( $data, array( $list, 'sort' ) );
endif;
$output = '';

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
	if ( $show_title && false === $title && $id ):
		$caption = $list->caption;
		if ( $caption )
			$title = $caption;
		else
			$title = get_the_title( $id );
	endif;
	if ( $title )
		$output .= '<' . $grouptag . ' class="sp-table-caption skpbg skwc">' . $title . '</' . $grouptag . '>';
	$group = new stdClass();
	$group->term_id = null;
	$group->name = null;
	$group->slug = null;
	$groups = array( $group );
endif;

foreach ( $groups as $group ):
	$i = 0;

	if ( intval( $number ) > 0 )
		$limit = $number;
	
	$thead = '<thead>' . '<tr class=" font-secondary space">';
		
	if ( ! is_array( $labels ) || array_key_exists( 'number', $labels ) ):
		if ( in_array( $orderby, array( 'number', 'name' ) ) ):
			$numthead = '<th class="data-number">#</th>';
		else:
			$numthead = '<th class="data-rank">' . __( 'Rank', 'skyre' ) . '</th>';
		endif;
	endif;

	foreach( $labels as $key => $label ):
		//if ( $key !== 'number' && ( ! is_array( $columns ) || $key == 'name' || in_array( $key, $columns ) ) )
			if ( $key == 'number') { $thead .= $numthead; continue;};
			$thead .= '<th class="data-' . $key . '">'. $label . '</th>';
	endforeach;

	$thead .= '</tr>' . '</thead>';
	
	$tbody = '';

	foreach( $data as $player_id => $row ): if ( empty( $group->term_id ) || has_term( $group->term_id, 'sp_position', $player_id ) ):

		if ( isset( $limit ) && $i >= $limit ) continue;

		$name = sp_array_value( $row, 'name', null );
		if ( ! $name ) continue;

		$tbody .= '<tr class="space ' . ( $i % 2 == 0 ? 'odd' : 'even' ) . '">';

		
		
		$name_class = '';

		if ( $show_player_photo ):
			if ( has_post_thumbnail( $player_id ) ):
				$logo = get_the_post_thumbnail( $player_id, 'sportspress-fit-icon' );
				$name = '<span class="player-photo">' . $logo . '</span>' . $name;
				$name_class .= ' has-photo';
			endif;
		endif;

		if ( $show_player_flag ):
			$player = new SP_Player( $player_id );
			$nationalities = $player->nationalities();
			if ( ! empty( $nationalities ) ):
				foreach ( $nationalities as $nationality ):
					$name = '<span class="player-flag"><img src="' . plugin_dir_url( SP_PLUGIN_FILE ) . 'assets/images/flags/' . strtolower( $nationality ) . '.png" alt="' . $nationality . '"></span>' . $name;
				endforeach;
				$name_class .= ' has-photo';
			endif;
		endif;

		if ( $link_posts ):
			$permalink = get_post_permalink( $player_id );
			$name = '<a href="' . $permalink . '">' . $name . '</a>';
		endif;


		foreach( $labels as $key => $value ):
			//if ( in_array( $key, array( 'number', 'name', 'team', 'position' ) ) )
				//continue;
			
			if ( ! is_array( $columns ) || in_array( $key, $columns ) ) {
				$label = $labels[$key];
				
				// ===================Rank or number===================
				if ($key == 'number'):
					if ( isset( $orderby ) && $orderby != 'number' ):
						$tbody .= '<td class="data-rank" data-label="'.$labels['number'].'">' . ( $i + 1 ) . '</td>';
					else:
						$tbody .= '<td class="data-number" data-label="'.$labels['number'].'">' . sp_array_value( $row, 'number', '&nbsp;' ) . '</td>';
					endif;
					 continue;
				endif;
				
				//===================Name===================
				if($key == 'name') { $tbody .= '<td class="data-name' . $name_class . '" data-label="'.$labels['name'].'">' . $name . '</td>'; continue; }
				
				//===================team/club===================
				if ($key == 'team'):
					$team = sp_array_value( $row, 'team', get_post_meta( $id, 'sp_current_team', true ) );			
					$team_name = $team ? sp_team_short_name( $team ) : '-';
					if ( $team_format == 'logo' && has_post_thumbnail( $team ) ){
						$logo = get_the_post_thumbnail( $team, 'sportspress-fit-icon', array( 'title' => ''.$team_name.'' ) );
						$team_name = '<span class="team-logo">' . $logo . '</span>';
					}
					if ( $link_teams && false !== get_post_status( $team ) ):
						$team_name = '<a href="' . get_post_permalink( $team ) . '">' . $team_name . '</a>';
					endif;
					$tbody .= '<td class="data-team" data-label="'.$labels['team'].'">' . $team_name . '</td>';
					continue;
				endif;
				
				//===================position===================
				if ($key == 'position') :
					$position = sp_array_value( $row, 'position', null );
					if ( null === $position || ! $position ):
						$positions = wp_strip_all_tags( get_the_term_list( $player_id, 'sp_position', '', ', ' ) );
					else:
						$position_term = get_term_by( 'id', $position, 'sp_position', ARRAY_A );
						$positions = sp_array_value( $position_term, 'name', '&mdash;' );
					endif;
					$tbody .= '<td class="data-position" data-label="'.$labels['position'].'">' . $positions . '</td>';
					continue;
				endif;
				
				if ( preg_match ( "/title=\"(.*?)\"/", $value, $new_label ) ) {
					$label = $new_label[1];
				}
				$tbody .= '<td class="data-' . $key . '" data-label="'.$label.'">' . sp_array_value( $row, $key, '&mdash;' ) . '</td>';
			}
		endforeach;

		$tbody .= '</tr>';

		$i++;

	endif; endforeach;
	
	if ( $i === 0 ) continue;

	$output .= '<div class="sp-template sp-template-player-list">';

	if ( ! empty( $group->name ) ):
		$output .= '<a name="group-' . $group->slug . '" id="group-' . $group->slug . '"></a>';
		$output .= '<' . $grouptag . ' class="sp-table-caption player-group-name player-list-group-name skpbg skwc">' . $group->name . '</' . $grouptag . '>';
	endif;

	$output .= '<div class="sp-table-wrapper  table-responsive">' .
		'<table class="sp-player-list sp-data-table table '.$table_style.' sk-player-list-table ' . ( $sortable ? ' sp-sortable-table' : '' ). ( $responsive ? ' sp-responsive-table '.$identifier : '' ) . ( $scrollable ? ' sp-scrollable-table' : '' ) . ( $paginated ? ' sp-paginated-table' : '' ) . '" data-sp-rows="' . $rows . '">';
	
	$output .= $thead . '<tbody>';
	
	$output .= $tbody;

	$output .= '</tbody>' . '</table>' . '</div>';

	if ( $show_all_players_link ):
		$output .= '<div class="sp-player-list-link sk-sp-view-all-link"><a href="' . get_permalink( $id ) . '">' . __( 'View all players', 'skyre' ) . '</a></div>';
	endif;

	$output .= '</div>';
endforeach;
?>
<?php echo wp_kses_post($output); ?>
