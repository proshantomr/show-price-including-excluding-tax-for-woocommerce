<?php
/**
 * Plugin Name:       Show Price Including & Excluding Tax
 * Plugin URI:        https://woocopilot.com/plugins/show-price-including-and-excluding-tax/
 * Description:       "Toggle Payment by Category" is a plugin that allows administrators to enable or disable specific payment methods based on product categories in an online store. It provides greater flexibility by ensuring that certain payment options are available or restricted for different product types, enhancing the checkout experience for both the store owner and customers.
 * Version:           1.0.0
 * Requires at least: 6.5
 * Requires PHP:      7.2
 * Author:            WooCopilot
 * Author URI:        https://woocopilot.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       show-price-including-and-excluding-tax
 * Domain Path:       /languages
 *
 * @package           TogglePaymentByCategory
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/includes/class-admin-show-price-including-and-excluding-tax.php';
require_once __DIR__ . '/includes/class-show-price-including-and-excluding-tax.php';

/**
 * Initializing plugin.
 *
 * @since 1.0.0
 * @return object Plugin object.
 */
function show_price_including_and_excluding_tax() {
	return new Show_Price_Including_And_Excluding_Tax( __FILE__, '1.0.0' );
}

show_price_including_and_excluding_Tax();
