<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class Show_Price_Including_And_Excluding_Tax_Admin
 *
 * This class handles the admin functionalities of the Show Price Including And Excluding Tax plugin.
 * It is responsible for enqueuing admin-specific scripts and styles,
 * as well as managing the admin menu and other related settings.
 *
 * @since 1.0.0
 */
class Show_Price_Including_And_Excluding_Tax_Admin {

	/**
	 * Show_Price_Including_And_Excluding_Tax_Admin constructor.
	 *
	 * Initializes the class by adding necessary hooks for admin scripts and styles.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
	}

	/**
	 * Enqueues admin-specific styles and scripts.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_admin_scripts() {
		wp_enqueue_style( 'spiaet_admin_style', SPIAXT_PLUGIN_URL . 'assets/css/admin.css', array(), SPIAXT_VERSION );
		wp_enqueue_script( 'spiaet_admin_scripts', SPIAXT_PLUGIN_URL . 'assets/js/admin.js', array( 'jquery' ), SPIAXT_VERSION, true );
	}
}
