<?php
/**
 * Customizer Control: responsive spacing
 *
 * @package     Astra
 * @author      Astra
 * @copyright   Copyright (c) 2019, Astra
 * @link        https://wpastra.com/
 * @since       1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Field overrides.
 */
if ( ! class_exists( 'Cryptic_Control_link' ) && class_exists( 'WP_Customize_Control' ) ) :


	/**
	 * Border control.
	 */
	class Cryptic_Control_link extends WP_Customize_Control {

   public $type = "skyre-control-links";

   public function render_content() {?>
         
        <div class="inside">
            
            <p><b><a href="<?php echo esc_url( 'http://templates.96h.in/skyre/wp/documentation/index.html' ); ?>"><?php esc_html_e('Documentation','skyre'); ?></a></b></p>
            
            
        </div><?php
   }

}

endif;
