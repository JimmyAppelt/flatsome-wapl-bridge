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
	 * Conditionals
	 *
	 * @var object Conditionals
	 */
	public $conditionals;

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
		$this->include();
		$this->conditionals = new Conditionals();

		// Hook us in.
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Init the plugin after plugins_loaded so environment variables are set.
	 */
	public function init() {
		if ( ! function_exists( 'WooCommerce_Advanced_Product_Labels' ) || ! flwapl()->conditionals->is_flatsome_activated() ) {
			return; // Abort.
		}
		$this->restructure_hooks();
		add_action( 'wp_head', [ $this, 'add_style' ] );
	}

	/**
	 * Restructure hooks
	 */
	public function restructure_hooks() {
		if ( class_exists( 'WAPL_Single_Labels' ) ) {
			$single_labels = WooCommerce_Advanced_Product_Labels()->single_labels;
			// Archive.
			remove_action( 'woocommerce_before_shop_loop_item_title', [ $single_labels, 'product_label_template_hook' ], 15 );
			add_action( 'woocommerce_before_shop_loop_item', [ $single_labels, 'product_label_template_hook' ], 15 );
			// Single.
			remove_action( 'woocommerce_product_thumbnails', [ $single_labels, 'product_label_template_hook' ], 9 );
			add_action( 'flatsome_sale_flash', [ $single_labels, 'product_label_template_hook' ], 9 );

		}
		if ( class_exists( 'WAPL_Global_Labels' ) ) {
			$global_labels = WooCommerce_Advanced_Product_Labels()->global_labels;
			// Archive.
			remove_action( 'woocommerce_before_shop_loop_item_title', [ $global_labels, 'global_label_hook' ], 15 );
			add_action( 'flatsome_woocommerce_shop_loop_images', [ $global_labels, 'global_label_hook' ], 15 );
			// Single.
			remove_action( 'woocommerce_product_thumbnails', [ $global_labels, 'global_label_hook' ], 9 );
			add_action( 'flatsome_sale_flash', [ $global_labels, 'global_label_hook' ], 9 );
		}
	}

	/**
	 * Plugin Files to include.
	 */
	private function include() {
		include_once dirname( __FILE__ ) . '/class-conditionals.php';
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
			.label-wrap.wapl-corner.wapl-alignleft .product-label {
				top: -22px;
			}
			.badge .on-sale {
				display: none;
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

