<?php 
//Custom Style Frontend
function hextorgb($color){
	if (strpos($color, 'rgba') !== false) {
		return $color;
	}
	
	$color = substr( $color, 1 );
	$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	$rgb =  array_map('hexdec', $hex);
	return 'rgba('.implode(",",$rgb).', 1)';
}
if(!function_exists('skyre_custom_frontend_style')){
    
    function skyre_custom_frontend_style(){
		$style_css 	= '';
		$is_shop = 0;
		if ( class_exists( 'WooCommerce' ) ) { 
			if(is_shop() || is_archive() || is_single()) { $is_shop = 1;}
			
		}
	

		require SKYRE_THEME_DIR.'/inc/customizer/configurations/class-skyre-configuration-typo.php' ;
		$typo_panel = new Skyre_Configuration_Typo;
		$style_css .= typostyle($typo_panel->typoSettings());
		
		
		//global
		if(skyre_get_option('bodybg_image') || skyre_get_option('bodybg_color')){
			$style_css .= 'body {  background: url('.wp_get_attachment_image_url( skyre_get_option("bodybg_image"),"full").') '.skyre_get_option("bodybg_repeat").' '.skyre_get_option("bodybg_color").' '.skyre_get_option("bodybg_bg_position").'; background-size: '.skyre_get_option("bodybg_size").'; }';
			$style_css .= '.sp-list-wrapper dt, .sp-list-wrapper dd {  background-color:'.skyre_get_option("bodybg_color").';}';
			
		}
		//Primary Color
		
		if(skyre_get_option('primary_color') ){
			$color = hextorgb(skyre_get_option("primary_color"));
			$larray = explode(",", $color);
			$light = $larray[0].','.$larray[1].','.$larray[2].',.15)';
			$dark = $larray[0].','.$larray[1].','.$larray[2].',.5)';
			$style_css .= '.skpc, a.sksc:hover, .sksc a:hover { color:'.$color.'; }';
			$style_css .= '.skpc-5 { color:'.$dark.'; }';
			$style_css .= '.skpbg, a.sksbg:hover, .has-fixed.navbar, .btn-skyre:hover { background-color:'.$color.'; }';
			$style_css .= '.skpbg5 { background-color:'.$dark.' ; }';
			$style_css .= '.skpbg15 { background-color:'.$light.' ; }';
			$style_css .= '.sk-border-15, .widget li{ border-color:'.$light.' ; }';
			$style_css .= '.form-control { border-color:'.$dark.' ; }';
			$style_css .= '.sk-border { border-color:'.$color.'; }';
			$style_css .= '.sk-light-bg, .widget_search .search-field { background-color:'.$light.'; }';
			$style_css .= '.scrollTop:hover { background:'.$color.'; }';
			
			if ( class_exists( 'WooCommerce' ) ) {
				$style_css .= '.button, button { background-color:'.$color.'  !important; }';
				$style_css .= '.woocommerce-tabs .tabs li.active { background-color:'.$color.' !important; }';
				$style_css .= '.woocommerce-tabs .tabs li { background-color:'.$light.' !important; }';
				$style_css .= '.woocommerce form.checkout_coupon, .woocommerce form.login, .woocommerce form.register { border-color:'.$light.'; }';
			  }
		}
		//Secondary Color
		if(skyre_get_option('secondary_color') ){
			$color = skyre_get_option("secondary_color");
			$style_css .= 'a:hover, .active > a, .current-menu-item a, .sksc, .sksc a, a.skpc:hover, .skwc a:hover, .skpc a:hover, .has-fixed a:hover, .current, .post-content a, .page-content a, .tags-links a, .dropdown-menu a:hover, .dropdown-menu .active a { color:'.$color.'; }';
			$style_css .= '.sksbg, a.skpbg:hover, .scrollTop, .pagination a.current, .pagination span.current, .cat-links a, .btn-skyre { background-color:'.$color.'; }';
			$style_css .= '.cssload-loading:after, .cssload-loading:before { border:solid 1px '.$color.' ; }';
			if ( class_exists( 'WooCommerce' ) ) {
				$style_css .= '.button:hover, button:hover, .woocommerce .onsale, .woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle { background-color:'.$color.'  !important; }';
				$style_css .= '.woocommerce-message { border-top-color:'.$color.'  !important; }';
				$style_css .= '.woocommerce ul.products li.product .price, .woocommerce div.product p.price, .woocommerce div.product span.price { color:'.$color.' ; }';
				
			  }
		}
		//Font Color
		if(skyre_get_option('global_font_color') ){
			$color = hextorgb(skyre_get_option("global_font_color"));
			$larray = explode(",", $color);
			$light = $larray[0].','.$larray[1].','.$larray[2].',.15)';
			$dark = $larray[0].','.$larray[1].','.$larray[2].',.5)';
			$style_css .= 'body, a,  .widget_search .search-field, .dropdown-menu a, .form-control { color:'.$color.'; }';
			$style_css .= '.meta span, .meta a, .meta time,  { color:'.$dark.' ; }';
			if ( class_exists( 'WooCommerce' ) ) {
				$style_css .= '.woocommerce ul.products li.product .woocommerce-loop-product__title { color:'.$color.'  !important; }';
			  }
		}
		//Secondary Font Color
		if(skyre_get_option('white_color') ){
			$color = skyre_get_option("white_color");
			$style_css .= '.skwc, .skwc a, a.skpc:hover, .scrollTop a, .btn-skyre, .has-fixed .nav-link, .pagination a.current, .pagination span.current { color:'.$color.'; }';
			$style_css .= '.skwc .meta span, .skwc .meta a, .skwc .meta time, .skwc input,  .skwc select, .skwc optgroup, .skwc textarea { color:'.$color.' ; }';
			if ( class_exists( 'WooCommerce' ) ) {
				$style_css .= '.button, a.button { color:'.$color.'  !important; }';
				$style_css .= '.woocommerce-tabs .tabs li a { color:'.$color.' !important; }';
			  }
		}
		
		if(skyre_get_option('loader_bg')){
			$style_css .= '.loader-section { background:'.skyre_get_option("loader_bg").'; }';
		}
		if(skyre_get_option('loader_primary')){
			$style_css .= '.cssload-loading-center { border-color:'.skyre_get_option("loader_primary").'; }';
		}
		if(skyre_get_option('loader_secondary')){
			$style_css .= '.cssload-loading:after, .cssload-loading:before { border-color:'.skyre_get_option("loader_secondary").'; }';
		}
		
		//page
		if ( (is_page() || $is_shop ==1 ) && !is_page_template() )  : 
		
			if(has_post_thumbnail()){ $style_css .= '.skyre-page-header header {  background-image: url('.wp_get_attachment_image_url( get_post_thumbnail_id(),"full").')}'; }
		else if(skyre_get_page_option('bg_color') || skyre_get_page_option('bg_image') ){
				$style_css .= '.page-section {  background: url('.wp_get_attachment_image_url( skyre_get_page_option("bg_image"),"full").') '.skyre_get_page_option("bg_repeat").' '.skyre_get_page_option("bg_color").' '.skyre_get_page_option("bg_position").'; background-size: '.skyre_get_page_option("bg_size").'; }';
			}
			$style_css .= skyre_get_dimension_style('margin','.page-section','page','margin');
			$style_css .= skyre_get_dimension_style('padding','.page-section','page','padding');
			if(skyre_get_page_option('title_bg_color') || skyre_get_page_option('title_bg_image') ){
				$style_css .= '.page-title {  background: url('.wp_get_attachment_image_url( skyre_get_page_option("title_bg_image"),"full").') '.skyre_get_page_option("title_bg_repeat").' '.skyre_get_page_option("title_bg_color").' '.skyre_get_page_option("title_bg_position").'; background-size: '.skyre_get_page_option("title_bg_size").'; }';
			}
			$style_css .= skyre_get_dimension_style('title_margin','.page-title','page','margin');
			$style_css .= skyre_get_dimension_style('title_padding','.page-title','page','padding');
			$style_css .= skyre_get_dimension_style('title_border_height','.page-title h1','page','border',' solid');
			if(skyre_get_page_option('title_border_color') ){ $style_css .= ' .page-title h1 {  border-color: '.skyre_get_page_option('title_border_color').';  }'; }
		endif;

		if (  is_home() ) : 
			if(skyre_get_post_option('bg_color')){ $style_css .= '.skyre-post #primary {  background-color: '.skyre_get_post_option("bg_color").'; }'; }
			$style_css .= skyre_get_dimension_style('margin','.skyre-post #primary','post','margin');
			$style_css .= skyre_get_dimension_style('paddings','.skyre-post #primary','post','padding');
  		
			//post header/settings
			if(skyre_get_post_option('title_bg_color') || skyre_get_post_option('title_bg_image') ){
				$style_css .= '.post-title {  background: url('.wp_get_attachment_image_url( skyre_get_post_option("title_bg_image"),"full").') '.skyre_get_post_option("title_bg_repeat").' '.skyre_get_post_option("title_bg_color").' '.skyre_get_post_option("title_bg_position").'; background-size: '.skyre_get_post_option("title_bg_size").'; }';
			}
			if(skyre_get_post_option('title_color')){
				$style_css .= '.post-title {  background-color: '.skyre_get_post_option("title_color").'; }';
			}

			$style_css .= skyre_get_dimension_style('title_margin','.post-title','post','margin');
			$style_css .= skyre_get_dimension_style('title_padding','.post-title','post','padding');
			$style_css .= skyre_get_dimension_style('title_border_height','.post-title h1','post','border',' solid');
			if(skyre_get_post_option('title_border_color') ){ $style_css .= ' .post-title h1 {  border-color: '.skyre_get_post_option('title_border_color').';  }'; }
			
			//post item styles
			if(skyre_get_post_option('list_bg_color')){ $style_css .= ' .skyre-post-item article {  background-color: '.skyre_get_post_option('list_bg_color').'; }'; }
			$style_css .= skyre_get_dimension_style('list_padding','.skyre-post-item article','post','padding');
			$style_css .= skyre_get_dimension_style('list_margin','.skyre-post-item article','post','margin');
			$style_css .= skyre_get_dimension_style('list_border','.skyre-post-item article','post','border',' solid');
			$style_css .= skyre_get_dimension_style('list_border_radius','.skyre-post-item article','post','border-radius');
			
			if(skyre_get_post_option('list_border_color') ){ $style_css .= ' .skyre-post-item article {  border-color: '.skyre_get_post_option('list_border_color').';  }'; }
			
			
			$style_css .= skyre_get_dimension_style('blog_title_margin','.skyre-post-item article .entry-title','post','margin');
			$style_css .= skyre_get_dimension_style('blog_img_margin','.skyre-post-item article .post-image','post','margin');
			$style_css .= skyre_get_dimension_style('blog_meta_margin','.skyre-post-item article .post-meta','post','margin');
			$style_css .= skyre_get_dimension_style('blog_content_margin','.skyre-post-item article .post-content','post','margin');
			$style_css .= skyre_get_dimension_style('blog_read_margin','.skyre-post-item article .post-readmore','post','margin');
		endif;
		
		//single post
		
		if ( is_single()  ) :
			if(skyre_get_post_option('single_bg_color')){ $style_css .= '.skyre-single {  background-color: '.skyre_get_post_option("single_bg_color").'; }'; }
			if(skyre_get_post_option('single_title_bg_color') ){ $style_css .= '.single-post-title {  background-color: '.skyre_get_post_option("single_title_bg_color").'; }'; }
			$style_css .= skyre_get_dimension_style('single_margin','.skyre-single','post','margin');
			$style_css .= skyre_get_dimension_style('single_padding','.skyre-single','post','padding');
			$style_css .= skyre_get_dimension_style('single_border_height','.skyre-single','post','border',' solid');
			if(skyre_get_post_option('single_border_color') ){ $style_css .= ' .skyre-single {  border-color: '.skyre_get_post_option('single_border_color').';  }'; }
			
			
			$style_css .= skyre_get_dimension_style('single_title_margin',' .single-post-title','post','margin');
			$style_css .= skyre_get_dimension_style('single_title_padding',' .single-post-title','post','padding');
			$style_css .= skyre_get_dimension_style('single_title_border_height','.single-post-title','post','border',' solid');
			if(skyre_get_post_option('single_title_border_color') ){ $style_css .= ' .single-post-title {  border-color: '.skyre_get_post_option('single_title_border_color').';  }'; }
			
			$style_css .= skyre_get_dimension_style('single_blog_image_margin',' .skyre-single .post-image','post','margin');
			$style_css .= skyre_get_dimension_style('single_blog_meta_margin',' .skyre-single .post-meta','post','margin');
			$style_css .= skyre_get_dimension_style('single_blog_content_margin',' .skyre-single .post-content','margin');
			
			//Post next preview button
			if(skyre_get_post_option('nextprev_bg_color')){ $style_css .= '.prevnxt_nav .item {  background-color: '.skyre_get_post_option("nextprev_bg_color").'; }'; }
			if(skyre_get_post_option('nextprev_text_color')){ $style_css .= '.prevnxt_nav .item {  color: '.skyre_get_post_option("nextprev_text_color").'; }'; }
			if(skyre_get_post_option('nextprev_link_color')){ $style_css .= '.prevnxt_nav .item a {  color: '.skyre_get_post_option("nextprev_link_color").'; }'; }
			if(skyre_get_post_option('nextprev_link_hover_color')){ $style_css .= '.prevnxt_nav .item a:hover {  color: '.skyre_get_post_option("nextprev_link_hover_color").'; }'; }
			
			$style_css .= skyre_get_dimension_style('nextprev_margin','.prevnxt_nav .item','post','margin');
			$style_css .= skyre_get_dimension_style('nextprev_padding','.prevnxt_nav .item','post','padding');
			$style_css .= skyre_get_dimension_style('nextprev_border_radius','.prevnxt_nav .item','post','border-radius');
			$style_css .= skyre_get_dimension_style('nextprev_border','.prevnxt_nav .item','post','border',' solid');
			if(skyre_get_post_option('nextprev_border_color') ){ $style_css .= '.prevnxt_nav .item {  border-color: '.skyre_get_post_option('nextprev_border_color').';  }'; }
			
		
		
		endif;
		//main menu
		if(skyre_get_option('mainmenu_bg') ){
			$style_css .= 'nav.mainmenu {  background-color: '.skyre_get_option("mainmenu_bg").' }';
		}
		if(skyre_get_option('nav_dropdown_item') ){
			$style_css .= 'nav.mainmenu a.dropdown-item {  color: '.skyre_get_option("nav_dropdown_item").' !important}';
		}
		if(skyre_get_option('nav_dropdown_item_hover') ){
			$style_css .= 'nav.mainmenu a.dropdown-item:hover, nav.mainmenu .active > a.dropdown-item  {  color: '.skyre_get_option("nav_dropdown_item_hover").' !important }';
		}
		if(skyre_get_option('nav_dropdown_bg') ){
			$style_css .= 'nav.mainmenu .dropdown-menu {  background-color: '.skyre_get_option("nav_dropdown_bg").' }';
		}
		if(skyre_get_option('sticky_bg')  ){
			$style_css .= 'nav.mainmenu.has-fixed {  background: '.skyre_get_option("sticky_bg").'}';
		}
		$style_css .= skyre_get_dimension_style('nav_border_height','nav.mainmenu ','','border',' solid');
		if(skyre_get_option('nav_border_color') ){ $style_css .= ' nav.mainmenu {  border-color: '.skyre_get_option('nav_border_color').';  }'; }
			
		
		//footer
		
		if(skyre_get_option('footer_bg_color') || skyre_get_option('footer_bg_image') ){
				$style_css .= '.footer {  background: url('.wp_get_attachment_image_url( skyre_get_option("footer_bg_image"),"full").') '.skyre_get_option("footer_bg_repeat").' '.skyre_get_option("footer_bg_color").' '.skyre_get_option("footer_bg_position").'; background-size: '.skyre_get_option("footer_bg_size").'; }';
			}

		if(skyre_get_option('footer_social_color') ){
			$style_css .= '.footer .social-nav a {  color: '.skyre_get_option("footer_social_color").' !important}';
		}
		if(skyre_get_option('footer_social_hover_color') ){
			$style_css .= '.footer .social-nav a:hover, .footer .social-nav .current-menu-item a  {  color: '.skyre_get_option("footer_social_hover_color").' !important}';
		}
		if(skyre_get_option('footer_widget_bg_color') ){
			$style_css .= '.footer-widget  {  background-color: '.skyre_get_option("footer_widget_bg_color").' }';
		}
		if(skyre_get_option('footer_bottom_bg_color') ){
			$style_css .= '.footer-botom  {  background-color: '.skyre_get_option("footer_bottom_bg_color").' }';
		}
		
		
		//scrollTop
		if(skyre_get_option('scrolltop_bg') ){
			$style_css .= '.scrollTop {  background-color: '.skyre_get_option("scrolltop_bg").' }';
		}
		if(skyre_get_option('scrolltop_hover_bg') ){
			$style_css .= '.scrollTop:hover {  background-color: '.skyre_get_option("scrolltop_hover_bg").' }';
		}
		if(skyre_get_option('scrolltop_icon') ){
			$style_css .= '.scrollTop i {  color: '.skyre_get_option("scrolltop_icon").' }';
		}
		if(skyre_get_option('scrolltop_icon_hover') ){
			$style_css .= '.scrollTop i:hover {  color: '.skyre_get_option("scrolltop_icon_hover").' }';
		}
		if(skyre_get_option('scrolltop_border') ){
			$style_css .= '.scrollTop {  border-radius: '.skyre_get_option("scrolltop_border").'% }';
		}
		
		//form field
		if(skyre_get_option('form_color')){ $style_css .= ' .sk-form, input,  select, optgroup, textarea {  color: '.skyre_get_option("form_color").'; }'; }
		if(skyre_get_option('form_bg_color')){ $style_css .= ' .sk-form, input,  select, optgroup, textarea {  background-color: '.skyre_get_option("form_bg_color").'; }'; }
		$style_css .= skyre_get_dimension_style('form_margin',' .sk-form, ','','margin');
		$style_css .= skyre_get_dimension_style('form_padding',' .sk-form','','padding');
		$style_css .= skyre_get_dimension_style('form_border_radius',' .sk-form','','border-radius');
		$style_css .= skyre_get_dimension_style('form_border',' .sk-form','','border',' solid');
		if(skyre_get_option('form_border_color') ){ $style_css .= '  .sk-form, input,  select, optgroup, textarea {  border-color: '.skyre_get_option('form_border_color').';  }'; }
		
		//form button
		if(skyre_get_option('form_button_color')){ $style_css .= ' .btn-skyre, button, submit {  color: '.skyre_get_option("form_button_color").'; }'; }
		if(skyre_get_option('form_button_bg_color')){ $style_css .= ' .btn.btn-skyre, button, submit {  background-color: '.skyre_get_option("form_button_bg_color").' !important; }'; }
		$style_css .= skyre_get_dimension_style('form_button_margin',' .btn-skyre','','margin');
		$style_css .= skyre_get_dimension_style('form_button_padding',' .btn-skyre','','padding');
		$style_css .= skyre_get_dimension_style('form_button_border_radius',' .btn-skyre','','border-radius');
		$style_css .= skyre_get_dimension_style('form_button_border',' .btn-skyre','','border',' solid');
		if(skyre_get_option('form_button_border_color') ){ $style_css .= ' .btn-skyre, button, submit {  border-color: '.skyre_get_option('form_button_border_color').';  }'; }
		
		

		//custom css
        $style_css .= skyre_get_option('custom_css');

        if(! empty($style_css)){
			echo '<style type="text/css">'.$style_css.'</style>';
		}
    }
}
add_action('wp_head', 'skyre_custom_frontend_style');

//Custom Sidebar Style Frontend
if(!function_exists('skyre_custom_sidebar_style')){
    
    function skyre_custom_sidebar_style(){
    	$sidebar_css 	= '';
		//widget style
		if(skyre_get_widget_option('bg_color')){ $sidebar_css .= '.sidebar-section {  background-color: '.skyre_get_widget_option("bg_color").'; }'; }
		$sidebar_css .= skyre_get_dimension_style('margin','.sidebar-section','widget','margin');
		$sidebar_css .= skyre_get_dimension_style('padding','.sidebar-section','widget','padding');
		$sidebar_css .= skyre_get_dimension_style('border_radius','.sidebar-section','widget','border-radius');
		$sidebar_css .= skyre_get_dimension_style('border','.sidebar-section','widget','border',' solid');
		if(skyre_get_widget_option('border_color') ){ $sidebar_css .= ' .sidebar-section {  border-color: '.skyre_get_widget_option('border_color').';  }'; }
		
		//widget section
		if(skyre_get_widget_option('section_bg_color')){ $sidebar_css .= '.sidebar-section .widget {  background-color: '.skyre_get_widget_option("section_bg_color").'; }'; }
		$sidebar_css .= skyre_get_dimension_style('section_margin','.sidebar-section .widget','widget','margin');
		$sidebar_css .= skyre_get_dimension_style('section_padding','.sidebar-section .widget','widget','padding');
		$sidebar_css .= skyre_get_dimension_style('section_border_radius','.sidebar-section .widget','widget','border-radius');
		$sidebar_css .= skyre_get_dimension_style('section_border','.sidebar-section .widget','widget','border',' solid');
		if(skyre_get_widget_option('section_border_color') ){ $sidebar_css .= ' .sidebar-section .widget {  border-color: '.skyre_get_widget_option('section_border_color').';  }'; }
		
		//widget title section
		if(skyre_get_widget_option('section_title_bg_color')){ $sidebar_css .= '.sidebar-section .widget-title {  background-color: '.skyre_get_widget_option("section_title_bg_color").'; }'; }
		$sidebar_css .= skyre_get_dimension_style('section_title_margin','.sidebar-section .widget-title','widget','margin');
		$sidebar_css .= skyre_get_dimension_style('section_title_padding','.sidebar-section .widget-title','widget','padding');
		$sidebar_css .= skyre_get_dimension_style('section_title_border_radius','.sidebar-section .widget-title','widget','border-radius');
		$sidebar_css .= skyre_get_dimension_style('section_title_border','.sidebar-section .widget-title','widget','border',' solid');
		if(skyre_get_widget_option('section_title_border_color') ){ $sidebar_css .= ' .sidebar-section .widget-title {  border-color: '.skyre_get_widget_option('section_title_border_color').';  }'; }
		
		//widget list style (li)
		if(skyre_get_widget_option('list_bg_color')){ $sidebar_css .= '.sidebar-section .widget li {  background-color: '.skyre_get_widget_option("list_bg_color").'; }'; }
		$sidebar_css .= skyre_get_dimension_style('list_margin','.sidebar-section .widget li','widget','margin');
		$sidebar_css .= skyre_get_dimension_style('list_padding','.sidebar-section .widget li','widget','padding');
		$sidebar_css .= skyre_get_dimension_style('list_border_radius','.sidebar-section .widget li','widget','border-radius');
		$sidebar_css .= skyre_get_dimension_style('list_border','.sidebar-section .widget li','widget','border',' solid');
		if(skyre_get_widget_option('list_border_color') ){ $sidebar_css .= ' .sidebar-section .widget li {  border-color: '.skyre_get_widget_option('list_border_color').';  }'; }
		
		
		if(! empty($sidebar_css)){
			echo '<style type="text/css">'.$sidebar_css.'</style>';
		}
	}
}

add_action( 'get_sidebar', 'skyre_custom_sidebar_style' );
add_action( 'woocommerce_sidebar', 'skyre_custom_sidebar_style' );

//Custom comment Style Frontend
if(!function_exists('skyre_custom_comment_style')){
    
    function skyre_custom_comment_style(){
		$comment_css 	= '';
		
		//comment style
		if(skyre_get_post_option('comment_bg_color')){ $comment_css .= '.comments-area {  background-color: '.skyre_get_post_option("comment_bg_color").'; }'; }
		$comment_css .= skyre_get_dimension_style('comment_margin','.comments-area','post','margin');
		$comment_css .= skyre_get_dimension_style('comment_padding','.comments-area','post','padding');
		$comment_css .= skyre_get_dimension_style('comment_border_radius','.comments-area','post','border-radius');
		$comment_css .= skyre_get_dimension_style('comment_border','.comments-area','post','border',' solid');
		if(skyre_get_post_option('comment_border_color') ){ $comment_css .= ' .comments-area {  border-color: '.skyre_get_post_option('comment_border_color').';  }'; }
		
		//comment title 
		if(skyre_get_post_option('comment_section_title_bg_color')){ $comment_css .= '.comments-title {  background-color: '.skyre_get_post_option("comment_section_title_bg_color").'; }'; }
		$comment_css .= skyre_get_dimension_style('comment_section_title_margin','.comments-title','post','margin');
		$comment_css .= skyre_get_dimension_style('comment_section_title_padding','.comments-title','post','padding');
		$comment_css .= skyre_get_dimension_style('comment_section_title_border_radius','.comments-title','post','border-radius');
		$comment_css .= skyre_get_dimension_style('comment_section_title_border','.comments-title','post','border',' solid');
		if(skyre_get_post_option('comment_section_title_border_color') ){ $comment_css .= ' .comments-title {  border-color: '.skyre_get_post_option('comment_section_title_border_color').';  }'; }
		
		
		//comment item
		if(skyre_get_post_option('comment_section_bg_color')){ $comment_css .= '.comments-area .comment {  background-color: '.skyre_get_post_option("comment_section_bg_color").'; }'; }
		$comment_css .= skyre_get_dimension_style('comment_section_margin','.comments-area .comment','post','margin');
		$comment_css .= skyre_get_dimension_style('comment_section_padding','.comments-area .comment','post','padding');
		$comment_css .= skyre_get_dimension_style('comment_section_border_radius','.comments-area .comment','post','border-radius');
		$comment_css .= skyre_get_dimension_style('comment_section_border','.comments-area .comment','post','border',' solid');
		if(skyre_get_post_option('comment_section_border_color') ){ $comment_css .= ' .comments-area .comment {  border-color: '.skyre_get_post_option('comment_section_border_color').';  }'; }
		
		//comment reply 
		if(skyre_get_post_option('comment_reply_bg_color')){ $comment_css .= '.comments-area .children li {  background-color: '.skyre_get_post_option("comment_reply_bg_color").'; }'; }
		$comment_css .= skyre_get_dimension_style('reply_margin','.comments-area .children li','post','margin');
		$comment_css .= skyre_get_dimension_style('reply_padding','.comments-area .children li','post','padding');
		$comment_css .= skyre_get_dimension_style('reply_border_radius','.comments-area .children li','post','border-radius');
		$comment_css .= skyre_get_dimension_style('reply_border','.comments-area .children li','post','border',' solid');
		if(skyre_get_post_option('comment_reply_border_color') ){ $comment_css .= ' .comments-area .children li {  border-color: '.skyre_get_post_option('comment_reply_border_color').';  }'; }
		
		//form field
		if(skyre_get_post_option('comment_form_color')){ $comment_css .= '.comment-form .sk-form {  color: '.skyre_get_post_option("comment_form_color").'; }'; }
		if(skyre_get_post_option('comment_form_bg_color')){ $comment_css .= '.comment-form .sk-form {  background-color: '.skyre_get_post_option("comment_form_bg_color").'; }'; }
		$comment_css .= skyre_get_dimension_style('comment_form_margin','.comment-form .sk-form','post','margin');
		$comment_css .= skyre_get_dimension_style('comment_form_padding','.comment-form .sk-form','post','padding');
		$comment_css .= skyre_get_dimension_style('comment_form_border_radius','.comment-form .sk-form','post','border-radius');
		$comment_css .= skyre_get_dimension_style('comment_form_border','.comment-form .sk-form','post','border',' solid');
		if(skyre_get_post_option('comment_form_border_color') ){ $comment_css .= ' .comment-form .sk-form {  border-color: '.skyre_get_post_option('comment_form_border_color').';  }'; }
		
		//form button
		if(skyre_get_post_option('comment_form_button_color')){ $comment_css .= '.comment-form .btn-skyre {  color: '.skyre_get_post_option("comment_form_button_color").'; }'; }
		if(skyre_get_post_option('comment_form_button_bg_color')){ $comment_css .= '.comment-form .btn.btn-skyre {  background-color: '.skyre_get_post_option("comment_form_button_bg_color").' !important;  }'; }
		$comment_css .= skyre_get_dimension_style('comment_form_button_margin','.comment-form .btn-skyre','post','margin');
		$comment_css .= skyre_get_dimension_style('comment_form_button_padding','.comment-form .btn-skyre','post','padding');
		$comment_css .= skyre_get_dimension_style('comment_form_button_border_radius','.comment-form .btn-skyre','post','border-radius');
		$comment_css .= skyre_get_dimension_style('comment_form_button_border','.comment-form .btn-skyre','post','border',' solid');
		if(skyre_get_post_option('comment_form_button_border_color') ){ $comment_css .= ' .comment-form .btn-skyre {  border-color: '.skyre_get_post_option('comment_form_button_border_color').';  }'; }
		
		//comment avatar
		if(skyre_get_post_option('comment_avatar_bg_color')){ $comment_css .= '.avatar-wrap {  background-color: '.skyre_get_post_option("comment_avatar_bg_color").'; }'; }
		$comment_css .= skyre_get_dimension_style('comment_avatar_margin','.avatar-wrap','post','margin');
		$comment_css .= skyre_get_dimension_style('comment_avatar_padding','.avatar-wrap','post','padding');
		$comment_css .= skyre_get_dimension_style('comment_avatar_border_radius','.avatar-wrap','post','border-radius');
		$comment_css .= skyre_get_dimension_style('comment_avatar_border','.avatar-wrap','post','border',' solid');
		if(skyre_get_post_option('comment_avatar_border_color') ){ $comment_css .= ' .avatar-wrap {  border-color: '.skyre_get_post_option('comment_avatar_border_color').';  }'; }
		
		
		if(! empty($comment_css)){
			echo '<style type="text/css">'.$comment_css.'</style>';
		}
		
		}
}

add_action( 'comments_template', 'skyre_custom_comment_style' );


