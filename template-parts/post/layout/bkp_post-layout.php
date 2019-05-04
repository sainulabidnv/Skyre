<?php
/**
 * Post layout for teplate parts - post
 * @package Skyre
 * @since 1.0
 * @version 1.0
 */
	$post_format = (get_post_format())?get_post_format():'default';
	$post_option = $post_format.'_field_position';
	
	//default post item position/view
	$item_postion = array('title','image','meta','content');
	
	//set post item position/view
	if(is_single() and skyre_get_post_option('single_field_position')) { $item_postion = skyre_get_post_option('single_field_position'); }
	elseif(!is_single() and skyre_get_post_option($post_option)) {$item_postion = skyre_get_post_option($post_option);}

	foreach($item_postion as $item)
	{ 
		if(!($entry_layout =='2' and $item =='image' )  ): 
			if (function_exists('skyre_post_'.$item)) :
				add_action( 'skyre_post_template_part', 'skyre_post_'.$item);
				//$postvalue = 'skyre_post_'.$item;
				//$postvalue();
				
			endif;
		endif;	
	}
		
	
	if($entry_layout =='2') {
		?>
		<div class="row">
			<div class="col-md-5"> <?php //skyre_post_image(); ?></div>
			<div class="col-md-7"> <?php //do_action( 'skyre_post_template_part'); ?></div>
		</div>
		<?php
	 
	}else { do_action( 'skyre_post_template_part'); }
		
	 if ( is_single() ) { skyre_entry_footer(); }
          
