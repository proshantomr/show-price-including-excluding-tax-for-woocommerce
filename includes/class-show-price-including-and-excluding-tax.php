<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class Show_Price_Including_And_Excluding_Tax
 *
 * This class is responsible for displaying prices including and excluding tax
 * on product pages and in the WooCommerce shop loop. It provides methods to
 * retrieve and format these prices for a better shopping experience for customers.
 *
 * @since 1.0.0
 */
class Show_Price_Including_And_Excluding_Tax {

	/**
	 * Plugin file path.
	 *
	 * @var string
	 */
	public string $file;

	/**
	 * Plugin version.
	 *
	 * @var string
	 */

	public string $version;

	/**
	 * Constructor for the class.
	 *
	 * Initializes the plugin by setting the file path and version, defining constants,
	 * and registering activation and deactivation hooks.
	 *
	 * @param string $file    Path to the main plugin file.
	 * @param string $version Plugin version.
	 */
	public function __construct( $file, $version = '1.0.0' ) {
		$this->file    = $file;
		$this->version = $version;
		$this->define_constants();
		$this->inithooks();

		register_activation_hook( $file, array( $this, 'activate' ) );
		register_deactivation_hook( $file, array( $this, 'deactivate' ) );
	}

	/**
	 * Defines plugin constants.
	 *
	 * This function defines constants that store the version, file path, directory path,
	 * URL, and the plugin basename. These constants are used throughout the plugin
	 * to avoid hardcoding these values in multiple places.
	 *
	 * @since 1.0.0
	 */
	public function define_constants() {
		define( 'SPIAXT_VERSION', $this->version );
		define( 'SPIAXT_FILE', $this->file );
		define( 'SPIAXT_PLUGIN_DIR', plugin_dir_path( $this->file ) );
		define( 'SPIAXT_PLUGIN_URL', plugin_dir_url( $this->file ) );
		define( 'SPIAXT_PLUGIN_BASENAME', plugin_basename( $this->file ) );
	}

	/**
	 * Initializes hooks for the plugin.
	 *
	 * This function registers WordPress actions and filters to initialize the plugin.
	 * - It hooks into the 'init' action to initialize plugin functionality.
	 * - It hooks into 'plugins_loaded' to load the plugin's text domain for translations.
	 * - It hooks into the 'woocommerce_available_payment_gateways' filter to customize available payment gateways during checkout.
	 *
	 * @since 1.0.0
	 */
	public function inithooks() {
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
	}

	/**
	 * Plugin activation hook.
	 *
	 * This function is triggered upon plugin activation. Activation logic can be added here
	 * if needed (e.g., creating database tables or setting default options).
	 *
	 * @since 1.0.0
	 */
	public function activate() {
		// Activation logic here if needed.
	}

	/**
	 * Plugin deactivation hook.
	 *
	 * This function is triggered upon plugin deactivation. Deactivation logic can be added here
	 * if needed (e.g., cleaning up settings or removing temporary data).
	 *
	 * @since 1.0.0
	 */
	public function deactivate() {
		// Deactivation logic here if needed.
	}

	/**
	 * Initializes the admin functionality.
	 *
	 * This function initializes the plugin's admin-related functionality by creating
	 * an instance of the `Toggle_Payments_By_Category_Admin` class.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		new Show_Price_Including_And_Excluding_Tax_Admin();

		// Use WooCommerce filter to modify price display.
		add_filter( 'woocommerce_get_price_html', array( $this, 'filter_price_with_and_without_tax' ), 100, 2 );
	}

	/**
	 * Loads the plugin textdomain for translations.
	 *
	 * This function loads the textdomain to enable translation of the plugin. It looks
	 * for translation files in the `languages` directory.
	 *
	 * @since 1.0.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'show-price-including-and-excluding-tax', false, basename( __DIR__ ) . '/languages/' );
	}


	/**
	 * Modify the product price to show both excluding and including tax.
	 *
	 * @param string     $price_html The existing price HTML.
	 * @param WC_Product $product The WooCommerce product object.
	 * @return string Modified price HTML with both tax-inclusive and tax-exclusive prices.
	 */
	public function filter_price_with_and_without_tax( $price_html, $product ) {
		if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
			return $price_html;
		}

		// Get the regular price or sale price directly from the product (no tax).
		if ( $product->is_on_sale() ) {
			// Show the sale price (as set in the product settings).
			$price_excluding_tax = $product->get_sale_price();
		} else {
			// Show the regular price (as set in the product settings).
			$price_excluding_tax = $product->get_regular_price();
		}

		// Get the price including tax (WooCommerce will calculate this automatically based on tax settings).
		$price_including_tax = wc_get_price_including_tax( $product );

		// Format the prices with the appropriate currency symbols and formatting.
		$price_html  = '<div class="price-tax-info">';
		$price_html .= '<p><strong>' . esc_html__( 'Price (Excl. Tax):', 'show-price-including-and-excluding-tax' ) . '</strong> ' . wc_price( $price_excluding_tax ) . '</p>';
		$price_html .= '<p><strong>' . esc_html__( 'Price (Incl. Tax):', 'show-price-including-and-excluding-tax' ) . '</strong> ' . wc_price( $price_including_tax ) . '</p>';
		$price_html .= '</div>';

		return $price_html;
	}
}
