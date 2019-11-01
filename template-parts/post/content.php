<?php
/**
 * Template part for displaying posts
 * @package Skyre
 * @since 1.0
 * @version 1.0
 */
 
  //define post item layout (grid or List)
 $entry_layout =  (skyre_get_post_option('blog_item_layout') ? skyre_get_post_option('blog_item_layout') : 2);
 
 //post list/box items per row
 $entry_count = (skyre_get_post_option('blog_item_count') ? skyre_get_post_option('blog_item_count') : 12);
 
 //reset the colum and per row for single post
 $template_style = (skyre_get_post_option('template_style')? skyre_get_post_option('template_style') : '');

 if ( is_single() ) { 
   $entry_count = 12; 
   $entry_layout = 1;
} else{
  //Default layout support only in single post
  $template_style = '';
}
 

?>
<div class="col-lg-<?php echo esc_attr($entry_count); ?><?php if(is_sticky()){ echo ' sticky-post';}; if ( is_single() ) { echo ' skyre-single-post-item';  } else { echo ' skyre-post-item';} ?>" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<article>
    <?php
    if($template_style == 'modern'){
      require SKYRE_THEME_DIR.'/template-parts/post/layout/post-modern-layout.php' ;
    }else {
      require SKYRE_THEME_DIR.'/template-parts/post/layout/post-layout.php' ;
    }
    ?>

	</article><!-- #post-## -->
</div>
