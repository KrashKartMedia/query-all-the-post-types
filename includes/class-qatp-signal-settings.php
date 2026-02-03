<?php
/**
 * Signal Hub Settings for Query All The Post Types
 *
 * Provides a consent-based opt-in for receiving developer communications.
 *
 * @package QueryAllThePostTypes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles Signal Hub consent and connection settings.
 */
class QATP_Signal_Settings {

	/**
	 * Option name for storing settings.
	 *
	 * @var string
	 */
	const OPTION_NAME = 'qatp_signal_settings';

	/**
	 * Signal Hub URL.
	 *
	 * @var string
	 */
	const HUB_URL = 'https://russellenvy.com';

	/**
	 * API username (subscriber-level read-only access).
	 *
	 * @var string
	 */
	const API_USER = 'qatp-reader';

	/**
	 * API password (application password for subscriber account).
	 *
	 * @var string
	 */
	const API_PASSWORD = 'siTL awjE lup5 jA5B 19MP W43s';

	/**
	 * Initialize the settings.
	 */
	public static function init() {
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
	}

	/**
	 * Register settings.
	 */
	public static function register_settings() {
		register_setting(
			'qatp_signal_settings',
			self::OPTION_NAME,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( __CLASS__, 'sanitize_settings' ),
			)
		);
	}

	/**
	 * Sanitize settings before saving.
	 *
	 * @param array $input The input array.
	 * @return array
	 */
	public static function sanitize_settings( $input ) {
		$sanitized = array();

		$sanitized['enabled'] = ! empty( $input['enabled'] ) ? 1 : 0;

		// Clear transients when settings change to force a fresh fetch.
		delete_transient( 'signal_last_fetch_qatp' );

		return $sanitized;
	}

	/**
	 * Check if notifications are enabled (user has consented).
	 *
	 * @return bool
	 */
	public static function is_enabled() {
		$settings = get_option( self::OPTION_NAME, array() );
		return ! empty( $settings['enabled'] );
	}

	/**
	 * Get the Signal Hub URL.
	 *
	 * @return string
	 */
	public static function get_hub_url() {
		return self::HUB_URL;
	}

	/**
	 * Get the API username.
	 *
	 * @return string
	 */
	public static function get_api_user() {
		return self::API_USER;
	}

	/**
	 * Get the API password.
	 *
	 * @return string
	 */
	public static function get_api_password() {
		return self::API_PASSWORD;
	}

	/**
	 * Check if the API is configured (credentials are set).
	 *
	 * @return bool
	 */
	public static function is_configured() {
		return 'PLACEHOLDER_APP_PASSWORD' !== self::API_PASSWORD;
	}

	/**
	 * Render the notifications sidebar box.
	 */
	public static function render_sidebar_box() {
		$is_enabled = self::is_enabled();
		?>
		<div class="qatp-sidebar-box">
			<div class="qatp-sidebar-header">
				<span class="dashicons dashicons-megaphone qatp-sidebar-icon"></span>
				<h3><?php esc_html_e( 'Notifications', 'query-all-the-post-types' ); ?></h3>
			</div>
			<div class="qatp-sidebar-body">
				<form method="post" action="options.php">
					<?php settings_fields( 'qatp_signal_settings' ); ?>
					<p>
						<label for="qatp_enabled">
							<input type="checkbox" id="qatp_enabled" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[enabled]" value="1" <?php checked( $is_enabled ); ?>>
							<?php esc_html_e( 'Enable developer notifications', 'query-all-the-post-types' ); ?>
						</label>
					</p>
					<p class="description" style="font-size: 12px; color: #646970;">
						<?php esc_html_e( 'Receive important updates and announcements from the developer in your dashboard.', 'query-all-the-post-types' ); ?>
					</p>
					<?php submit_button( __( 'Save', 'query-all-the-post-types' ), 'small', 'submit', false ); ?>
				</form>
			</div>
		</div>
		<?php
	}

	/**
	 * Clean up on uninstall.
	 */
	public static function uninstall() {
		delete_option( self::OPTION_NAME );
		delete_transient( 'signal_last_fetch_qatp' );
		delete_transient( 'signal_data_qatp' );

		// Clean up user meta for dismissed signals.
		global $wpdb;
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$wpdb->delete(
			$wpdb->usermeta,
			array( 'meta_key' => 'signal_status_qatp' ) // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		);
	}
}

QATP_Signal_Settings::init();
