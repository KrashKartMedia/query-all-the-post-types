<?php
/**
 * Main plugin class.
 *
 * @package QueryAllThePostTypes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initialises the plugin, registers hooks, and enqueues assets.
 */
class QATP_Plugin {

	/**
	 * Singleton instance.
	 *
	 * @var QATP_Plugin|null
	 */
	private static $instance = null;

	/**
	 * Create or return the singleton instance.
	 *
	 * @return QATP_Plugin
	 */
	public static function init() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Register all hooks.
	 */
	private function __construct() {
		$admin_page = new QATP_Admin_Page();

		add_action( 'admin_menu', array( $admin_page, 'register_menu' ) );
		add_filter( 'plugin_action_links_' . QATP_PLUGIN_BASENAME, array( $this, 'add_action_links' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
	}

	/**
	 * Add a "View Post Types" link to the plugins list.
	 *
	 * @param array $links Existing action links.
	 * @return array
	 */
	public function add_action_links( $links ) {
		$settings_link = '<a href="' . esc_url( admin_url( 'tools.php?page=query-all-the-post-types' ) ) . '">' . esc_html__( 'View Post Types', 'query-all-the-post-types' ) . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}

	/**
	 * Enqueue admin CSS and JS on the plugin page only.
	 *
	 * @param string $hook The current admin page hook suffix.
	 */
	public function enqueue_admin_assets( $hook ) {
		if ( 'tools_page_query-all-the-post-types' !== $hook ) {
			return;
		}

		wp_enqueue_style(
			'qatp-admin',
			QATP_PLUGIN_URL . 'assets/css/qatp-admin.css',
			array(),
			QATP_VERSION
		);

		wp_enqueue_script(
			'qatp-admin',
			QATP_PLUGIN_URL . 'assets/js/qatp-admin.js',
			array(),
			QATP_VERSION,
			true
		);
	}
}
