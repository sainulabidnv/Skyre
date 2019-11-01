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
	
	
	//set post item position/view
	if(is_single() and skyre_get_post_option($single_post_option)) { $item_postion = skyre_get_post_option($single_post_option); }
	elseif(!is_single() and skyre_get_post_option($post_option)) {$item_postion = skyre_get_post_option($post_option);}

	if($entry_layout =='2' and in_array('image', $item_postion)) {
		
		//filter image for grid listing
		if (($key = array_search('image', $item_postion)) !== false) {
			unset($item_postion[$key]);
		}
		
		?>
		<div class="row">
			<?php if ( has_post_thumbnail() )  { ?>
				<div class="col-md-5"> <?php skyre_post_image(); ?></div>
				<div class="col-md-7"> <?php skyre_get_post_field($item_postion); ?></div>
			<?php } else { ?>
				<div class="col-md-12"> <?php skyre_get_post_field($item_postion); ?></div>
			<?php } ?>
			
		</div>
		<?php
	 
	}else { 
		skyre_get_post_field($item_postion); 
	}
		
	 if ( is_single() ) { skyre_entry_footer(); }
          
