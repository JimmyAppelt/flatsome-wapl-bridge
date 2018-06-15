<?php
/**
 * Main class.
 *
 * @package Fl_WAPL_Bridge
 */

namespace Flwapl\Inc;

defined( 'ABSPATH' ) || exit;

/**
 * Class Plugin
 *
 * @class Plugin
 */
final class Plugin {

	/**
	 * Static instance
	 *
	 * @var Plugin $instance
	 */
	private static $instance = null;

	/**
	 * Plugin constructor.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Init the plugin after plugins_loaded so environment variables are set.
	 */
	public function init() {
		if ( ! function_exists( 'WooCommerce_Advanced_Product_Labels' ) ) {
			return;
		}
		$this->restructure_hooks();
		add_action( 'wp_head', [ $this, 'add_style' ] );
	}

	/**
	 * Add admin menu toolbar item with branch info
	 */
	public function restructure_hooks() {
		if ( class_exists( 'WAPL_Single_Labels' ) ) {
			$single_labels = WooCommerce_Advanced_Product_Labels()->single_labels;
			remove_action( 'woocommerce_before_shop_loop_item_title', [ $single_labels, 'product_label_template_hook' ], 15 );
			add_action( 'woocommerce_before_shop_loop_item', [ $single_labels, 'product_label_template_hook' ], 15 );
		}
		if ( class_exists( 'WAPL_Global_Labels' ) ) {
			$global_labels = WooCommerce_Advanced_Product_Labels()->global_labels;
			remove_action( 'woocommerce_before_shop_loop_item_title', [ $global_labels, 'global_label_hook' ], 15 );
			add_action( 'woocommerce_before_shop_loop_item', [ $global_labels, 'global_label_hook' ], 15 );
		}
	}

	/**
	 * Add styles
	 */
	public function add_style() {
		?>
		<style id="wapl-custom-css" type="text/css">
			div[class^='wapl-label-id-'],
			div[class*=' wapl-label-id-'] {
				z-index: 21;
			}
			.label-wrap {
				pointer-events: none;
			}
		</style>
		<?php
	}

	/**
	 * Initializes the plugin object and returns its instance.
	 *
	 * @return Plugin The plugin object instance
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

Plugin::get_instance();

