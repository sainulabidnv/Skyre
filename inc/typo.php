<?php 

/**
 * Fonts initialization.
 * Once add records to the `wp_options` table.
 *
 * @package     Skyre
 * @author      Skyretheme
 * @copyright   Copyright (c) 2019, Skyre
 * @link        https://skyretheme.com/sports
 * @since       1.0.0
 */
	
	
function addtypo($args=array(),$wp_customize ){
		//typo
	}
		
		
/**
 * Get text style
 *
 * @return array
 */
function skyre_get_font_styles() {
	return apply_filters( 'skyre_get_font_styles', array(
		'normal'  => esc_html__( 'Normal', 'skyre' ),
		'italic'  => esc_html__( 'Italic', 'skyre' ),
		'oblique' => esc_html__( 'Oblique', 'skyre' ),
		'inherit' => esc_html__( 'Inherit', 'skyre' ),
	) );
}

/**
 * Get text aligns
 *
 * @return array
 */
function skyre_get_text_align() {
	return apply_filters( 'skyre_get_text_align', array(
		'inherit' => esc_html__( 'Inherit', 'skyre' ),
		'center'  => esc_html__( 'Center', 'skyre' ),
		'justify' => esc_html__( 'Justify', 'skyre' ),
		'left'    => esc_html__( 'Left', 'skyre' ),
		'right'   => esc_html__( 'Right', 'skyre' ),
	) );
}

/**
 * Get text aligns
 *
 * @return array
 */
function skyre_get_text_aligns() {
	return apply_filters( 'skyre_get_text_aligns', array(
		'inherit' => esc_html__( 'Inherit', 'skyre' ),
		'center'  => esc_html__( 'Center', 'skyre' ),
		'justify' => esc_html__( 'Justify', 'skyre' ),
		'left'    => esc_html__( 'Left', 'skyre' ),
		'right'   => esc_html__( 'Right', 'skyre' ),
	) );
}

/**
 * Get font weights
 *
 * @return array
 */
function skyre_get_font_weight() {
	return apply_filters( 'skyre_get_font_weight', array(
		'100' => '100',
		'200' => '200',
		'300' => '300',
		'400' => '400',
		'500' => '500',
		'600' => '600',
		'700' => '700',
		'800' => '800',
		'900' => '900',
	) );
}

		
		function getStandardFonts() {
			$file = dirname( __FILE__ ) . '/assets/fonts/standard.json';
			$data = read_font_file( $file );
			return $font = json_decode($data);
			
			}
			
		
		function getFonts() {
			$fonts_data = array(
				'standard' => dirname( __FILE__ ) . '/assets/fonts/standard.json',
				'google'   => dirname( __FILE__ ) . '/assets/fonts/google.json',
			);
			$fonts_data = (array) $fonts_data;
			foreach ( $fonts_data as $type => $file ) {
				$data = read_font_file( $file );
				$font[$type] = json_decode($data);
				foreach ( $font[$type] as $key => $value ) {
					if($type =='standard'){ 
						$fonts[$value] = $value.' [Standard]'; 
					}else {
						$fonts[$value] = $value;
						}
					
				}
			}
			asort($fonts);
			return $fonts;
		}
		
		

		function read_font_file( $file ) {

			if ( ! file_exists( $file ) ) {
				return false;
			}

			// Read the file.
			$json = get_file( $file );

			if ( ! $json ) {
				return new WP_Error( 'reading_error', 'Error when reading file' );
			}

			return $json;
		}
		
		/**
		 * Safely get file content.
		 *
		 * @global object $wp_filesystem
		 * @param  string $file File path.
		 * @return bool
		 */
		function get_file( $file ) {

			if ( ! function_exists( 'WP_Filesystem' ) ) {
				include_once( ABSPATH . '/wp-admin/includes/file.php' );
			}

			WP_Filesystem();
			global $wp_filesystem;

			$result = '';

			if ( $wp_filesystem->abspath() ) {
				$result = $wp_filesystem->get_contents( $file );
			} 

			return $result;
		}
		
/**
 * Adds sanitization callback function: font famly
 * @package skyre
 */
function skyre_sanitize_fontfamily( $input ) {
    $cfonts =  getFonts();
	if ( array_key_exists( $input, $cfonts ) ) {
        return $input;
    } else {
        return '';
    }
}


/**
 * Adds sanitization callback function: font style
 * @package skyre
 */
function skyre_sanitize_fontstyle( $input ) {
    $fstyle = skyre_get_font_styles();
	if ( array_key_exists( $input, $fstyle ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Adds sanitization callback function: font weight
 * @package skyre
 */
function skyre_sanitize_fontweight( $input ) {
    $fweight = skyre_get_font_weight();
	if ( array_key_exists( $input, $fweight ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Adds sanitization callback function: text align
 * @package skyre
 */
function skyre_sanitize_text_align( $input ) {
    $talign = skyre_get_text_aligns();
	if ( array_key_exists( $input, $talign ) ) {
        return $input;
    } else {
        return '';
    }
}


function typofonts(){
	
	require SKYRE_THEME_DIR.'/inc/customizer/configurations/class-skyre-configuration-typo.php' ;
	$typo_panel = new Skyre_Configuration_Typo;
	$args = $typo_panel->typoSettings();
		
	
	$allfonts = array();
	$google_font = array();
	
	$standardfonts = getStandardFonts();
	foreach($args as $arg){
		$family = skyre_get_option($arg['id']);
		if(isset($family['font-family'])){
			$font = $family['font-family'];
			//filter repeat value
			if(!in_array ( $font , $allfonts)){ 
				//check if google font or normal font
				$allfonts[] =  $font;
				if(!in_array ( $font , $standardfonts)){ 
					$google_font[] = $font;
					}
				}
			}
		}
		//preparing for style enque
		if (!empty($google_font)) { 
			$query_args = array(
				'family' => urlencode( implode( '|', array_filter($google_font) ) ),
				);
			if( $query_args['family'] != '') {
				$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
				wp_enqueue_style( 'skyre-customize', esc_url_raw( $fonts_url ), array(), null );
			}
		}
	}
add_action( 'wp_enqueue_scripts', 'typofonts' );

function typostyle($args=array()){
	$style_css = '';
	
	foreach($args as $arg){
		$family = skyre_get_option($arg['id']);
		if($family){
			$style_obj = '';
			$style_resp = '';
			foreach($family as $key  => $value){
				if(is_array($value)) { 
					if($value['desktop'] !='') { $style_obj .= $key.': '.$value['desktop'].$value['desktop-unit'].';'; }
					if($value['tablet'] !='') { $style_resp .= ' @media (max-width: 767.98px) {'.$arg['class'].'{'.$key.': '.$value['tablet'].$value['tablet-unit'].';}} '; }
					if($value['mobile'] !='') { $style_resp .= ' @media (max-width: 575.98px) {'.$arg['class'].'{'.$key.': '.$value['mobile'].$value['mobile-unit'].';}} '; }
					}
				else if($value !='') { $style_obj .= $key.': '.$value.' !important; '; }
				}
				if($style_obj !='') { $style_css .= $arg['class'].' { '.$style_obj.' }'; }
				if($style_resp !='') { $style_css .= $style_resp; }
			}
		}
	return $style_css;
	
	}











