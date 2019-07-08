<?php
/**
 * Conditionals.
 *
 * @package Fl_WAPL_Bridge
 */

namespace Flwapl\Inc;

defined( 'ABSPATH' ) || exit;

/**
 * Class Conditionals
 */
class Conditionals {

	/**
	 * Check if Flatsome theme is activated.
	 *
	 * @return bool
	 */
	public function is_flatsome_activated() {
		$theme = wp_get_theme( get_template() );
		$name  = $theme->get( 'Name' );

		return 'Flatsome' === $name;
	}
}
