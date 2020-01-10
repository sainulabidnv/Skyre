<?php
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'skyre_register_required_plugins' );
function skyre_register_required_plugins() {
    $plugins = array(
              
        array(
            'name'               => esc_html__( 'Elementor Page Builder', 'skyre' ),
            'slug'               => 'elementor',
            'required'           => true,
        ),
		array(
            'name'               => esc_html__( 'Contact Form 7', 'skyre' ),
            'slug'               => 'contact-form-7',
            'required'           => false,
        ),
        array(
            'name'               => esc_html__( 'WooCommerce', 'skyre' ),
            'slug'               => 'woocommerce',
            'required'           => false,
        ),
		array(
            'name'               => esc_html__( 'One Click Demo Import', 'skyre' ),
            'slug'               => 'one-click-demo-import',
            'required'           => false,
        ),
        array(
            'name'               => esc_html__( 'SportsPress – Sports Club & League Manager', 'skyre' ),
            'slug'               => 'sportspress',
            'required'           => true,
        ),
        
    );
    
    $config = array(
		'id'           => 'skyre',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
 		

	);

    tgmpa( $plugins, $config );
}
