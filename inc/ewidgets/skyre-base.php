<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

abstract class Skyre_Base extends Widget_Base {

	public $__context         = 'render';
	public $__processed_item  = false;
	public $__processed_index = 0;

	public function testname(){
		return 'SKTEST';
		}
	
	/**
	 * Get globaly affected template
	 *
	 * @param  [type] $name [description]
	 * @return [type]       [description]
	 */


}
