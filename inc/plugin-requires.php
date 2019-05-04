<?php
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'skyre_register_required_plugins' );
function skyre_register_required_plugins() {
    $protocol = is_ssl() ? 'http' : 'http';
    $plugins = array(
        // This is an example of how to include a plugin from the WordPress Plugin Repository.      
        array(
            'name'               => esc_html__( 'Elementor Page Builder', 'skyre' ),
            'slug'               => 'elementor',
            'required'           => true,
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
		
		array(
            'name'               => esc_html__( 'Contact Form 7', 'skyre' ),
            'slug'               => 'contact-form-7',
            'required'           => false,
        ),
		array(
            'name'               => esc_html__( 'One Click Demo Import', 'skyre' ),
            'slug'               => 'one-click-demo-import',
            'required'           => false,
        ),
		array(
            'name'               => esc_html__( 'GDPR Cookie Consent', 'skyre' ),
            'slug'               => 'cookie-law-info',
            'required'           => false,
        ),
		
        
    );
    $config = array(
		'id'           => 'skyre',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
    );

    tgmpa( $plugins, $config );
}
