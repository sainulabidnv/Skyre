<?php
/**
 * Customizer Control: dimension.
 *
 * @package     Skyre
 * @author      Skyretheme
 * @copyright   Copyright (c) 2019, Skyre
 * @link        https://skyretheme.com/sports
 * @since       1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A text control with validation for CSS units.
 */
class Skyre_Control_Dimension extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'skyre-dimension';


	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {

		$css_uri = SKYRE_THEME_URI . 'inc/customizer/custom-controls/dimension/';
		$js_uri  = SKYRE_THEME_URI . 'inc/customizer/custom-controls/dimension/';

		wp_enqueue_script( 'skyre-dimension', $js_uri . 'dimension.js', array( 'jquery', 'customize-base' ), SKYRE_THEME_VERSION, true );
		wp_enqueue_style( 'skyre-dimension-css', $css_uri . 'dimension.css', null, SKYRE_THEME_VERSION );

	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		$this->json['default'] = $this->setting->default;
		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}
		$this->json['value']  = $this->value();
		$this->json['id']     = $this->id;
		$this->json['label']  = esc_html( $this->label );
		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}


	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>


		<label class="customizer-text" for="" >
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>

				
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } 
            
            
            value_desktop = {};
			value_tablet  = {};
			value_mobile  = {};

			if ( data.value.desktop ) { 
				value_desktop = data.value.desktop;
			} 
            if ( data.value.tablet ) { 
				value_tablet = data.value.tablet;
			} 
            if ( data.value.mobile ) { 
				value_mobile = data.value.mobile;
			} 
            
            
            
            
            var newVal = {
					desktop : {},
					tablet : {},
					mobile : {},
					};
            
			 #>

			<div id="skyre-dimension" class="cutomizer-dimension">
                <div class="buttons">
                <span data-id='desktop' class="rsbtn active"> <i class="dashicons dashicons-desktop"></i></span>
                <span data-id='tablet' class="rsbtn"> <i class="dashicons dashicons-tablet"></i></span>
                <span data-id='mobile' class="rsbtn"> <i class="dashicons dashicons-smartphone"></i></span>
            </div>
            <div class="inputfields">
					
                    <input {{{ data.inputAttrs }}}  type="text" placeholder="0px" data-id="top" data-device="desktop" name="{{ data.id }}['desktop']['top']" class="desktop active" value="{{ value_desktop.top }}"/>
                    <input {{{ data.inputAttrs }}}  type="text" placeholder="0px" data-id="right" data-device="desktop" name="{{ data.id }}['desktop']['right']" class="desktop active" value="{{ value_desktop.right }}"/>
                    <input {{{ data.inputAttrs }}}  type="text" placeholder="0px" data-id="bottom" data-device="desktop" name="{{ data.id }}['desktop']['bottom']" class="desktop active" value="{{ value_desktop.bottom }}"/>
                    <input {{{ data.inputAttrs }}}  type="text" placeholder="0px" data-id="left" data-device="desktop" name="{{ data.id }}['desktop']['left']" class="desktop active" value="{{ value_desktop.left }}"/>
                   	
                    <input {{{ data.inputAttrs }}}  type="text" placeholder="0px" data-id="top" data-device="tablet" name="{{ data.id }}['tablet']['top']" class="tablet" value="{{ value_tablet.top }}"/>
                    <input {{{ data.inputAttrs }}}  type="text" placeholder="0px" data-id="right" data-device="tablet" name="{{ data.id }}['tablet']['right']" class="tablet" value="{{ value_tablet.right }}"/>
                    <input {{{ data.inputAttrs }}}  type="text" placeholder="0px" data-id="bottom" data-device="tablet" name="{{ data.id }}['tablet']['bottom']" class="tablet" value="{{ value_tablet.bottom }}"/>
                    <input {{{ data.inputAttrs }}}  type="text" placeholder="0px" data-id="left" data-device="tablet" name="{{ data.id }}['tablet']['left']" class="tablet" value="{{ value_tablet.left }}"/>
                   	
                    <input {{{ data.inputAttrs }}}  type="text" placeholder="0px" data-id="top" data-device="mobile" name="{{ data.id }}['mobile']['top']" class="mobile" value="{{ value_mobile.top }}"/>
                    <input {{{ data.inputAttrs }}}  type="text" placeholder="0px" data-id="right" data-device="mobile" name="{{ data.id }}['mobile']['right']" class="mobile" value="{{ value_mobile.right }}"/>
                    <input {{{ data.inputAttrs }}}  type="text" placeholder="0px" data-id="bottom" data-device="mobile" name="{{ data.id }}['mobile']['bottom']" class="mobile" value="{{ value_mobile.bottom }}"/>
                    <input {{{ data.inputAttrs }}}  type="text" placeholder="0px" data-id="left" data-device="mobile" name="{{ data.id }}['mobile']['left']" class="mobile" value="{{ value_mobile.left }}"/>
                   	<div class="clearfix"></div>
           </div>         
					
			</div>
		</label>
		<?php
	}

	/**
	 * Render the control's content.
	 *
	 * @see WP_Customize_Control::render_content()
	 */
	protected function render_content() {}
}

