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
	class Skyre_render_html extends WP_Customize_Control {

   public $type = "skyre-render-html";
   var $content;
   
   public function render_content() {
       if(!empty($this->content)) {
       ?>
         
        <div class="inside">
            <p><?php echo wp_kses_post($this->content); ?></p>
        </div><?php
        }
    }

}

endif;
