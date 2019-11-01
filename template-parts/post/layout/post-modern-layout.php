<?php
/**
 * Post layout for teplate parts - post
 * @package Skyre
 * @since 1.0
 * @version 1.0
 */
	$post_format = (get_post_format())?get_post_format():'default';
	$post_option = $post_format.'_field_position';
	$single_post_option = $post_format.'_single_field_position';
	
	//default post item position/view
	
	
	if($post_format == 'default' ) { $item_postion = array('title','image','meta','content'); }
	else if($post_format == 'gallery' ) { $item_postion = array('title','image'); }
	else if($post_format == 'image' ) { $item_postion = array('image','title'); }
	else if($post_format == 'video' ) { $item_postion = array('title','content'); }
	else { $item_postion = array('title','image','meta','content'); } 
	
	
	
		
		?>
		<div class="row"> 
			<div class="modern-post-content"> <?php skyre_post_content(); ?></div>
		</div>
		<?php
	 
	
		
	 if ( is_single() ) { skyre_entry_footer(); }
          
