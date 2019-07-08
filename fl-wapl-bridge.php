<?php
/**
 * Flatsome WooCommerce Advanced Product Labels Bridge
 *
 * @package   Fl_WAPL_Bridge
 * @license   GPL v3
 *
 * @wordpress-plugin
 * Plugin Name:       Flatsome WAPL Bridge
 * Description:       Flatsome WooCommerce Advanced Product Labels Bridge.
 * Version:           1.0.3
 * Plugin URI:        https://github.com/JimmyAppelt/flatsome-wapl-bridge
 * GitHub Plugin URI: https://github.com/JimmyAppelt/flatsome-wapl-bridge
 * Author:            Jim Appelt
 * Text Domain:       fl-wapl-bridge
 * Domain Path:       /languages/
 * WC tested up to:   3.6
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

use Flwapl\Inc\Plugin;

defined( 'ABSPATH' ) || exit;

require_once dirname( __FILE__ ) . '/inc/class-plugin.php';

/**
 * Main instance of the plugin.
 *
 * @return Plugin
 */
function flwapl() {
	return Plugin::get_instance();
}
