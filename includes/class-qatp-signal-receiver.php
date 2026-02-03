<?php
/**
 * Signal Hub Receiver for Query All The Post Types
 *
 * Receives signals and drips from Signal Hub on russellenvy.com.
 *
 * @package QueryAllThePostTypes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles receiving and displaying signals from Signal Hub.
 *
 * User must consent via the Developer Notifications settings page.
 */
class QATP_Signal_Receiver {

	/**
	 * Plugin prefix for transients and meta keys.
	 *
	 * @var string
	 */
	const PLUGIN_PREFIX = 'qatp';

	/**
	 * Initialize the receiver.
	 */
	public static function init() {
		// Don't run if user hasn't consented or API isn't configured.
		if ( ! self::is_enabled() ) {
			return;
		}

		add_action( 'admin_init', array( __CLASS__, 'maybe_fetch_signals' ) );
		add_action( 'admin_notices', array( __CLASS__, 'render_signals' ) );
		add_action( 'wp_ajax_qatp_signal_dismiss', array( __CLASS__, 'handle_dismiss' ) );
	}

	/**
	 * Check if notifications are enabled (user consented and API configured).
	 *
	 * @return bool
	 */
	private static function is_enabled() {
		if ( ! class_exists( 'QATP_Signal_Settings' ) ) {
			return false;
		}
		return QATP_Signal_Settings::is_enabled() && QATP_Signal_Settings::is_configured();
	}

	/**
	 * Get the Signal Hub URL.
	 *
	 * @return string
	 */
	private static function get_hub_url() {
		return QATP_Signal_Settings::get_hub_url();
	}

	/**
	 * Get the API username.
	 *
	 * @return string
	 */
	private static function get_user() {
		return QATP_Signal_Settings::get_api_user();
	}

	/**
	 * Get the API password.
	 *
	 * @return string
	 */
	private static function get_password() {
		return QATP_Signal_Settings::get_api_password();
	}

	/**
	 * Check if pro version is active.
	 *
	 * Query All The Post Types is free only, so always returns false.
	 *
	 * @return bool
	 */
	private static function is_pro_active() {
		return false;
	}

	/**
	 * Get the API endpoint.
	 *
	 * WordPress.org free plugins always use the signals endpoint.
	 *
	 * @return string
	 */
	private static function get_endpoint() {
		return '/wp-json/signal-hub/v1/signals';
	}

	/**
	 * Fetch signals from Signal Hub if cache is expired.
	 */
	public static function maybe_fetch_signals() {
		$last_fetch = get_transient( 'signal_last_fetch_' . self::PLUGIN_PREFIX );
		if ( false !== $last_fetch ) {
			return;
		}

		$endpoint = self::get_hub_url() . self::get_endpoint();

		$response = wp_remote_get(
			add_query_arg( 'target', self::PLUGIN_PREFIX, $endpoint ),
			array(
				'headers' => array(
					// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode -- Required for Basic Auth.
					'Authorization' => 'Basic ' . base64_encode( self::get_user() . ':' . self::get_password() ),
				),
				'timeout' => 15,
			)
		);

		if ( ! is_wp_error( $response ) ) {
			$body    = wp_remote_retrieve_body( $response );
			$signals = json_decode( $body, true );

			if ( is_array( $signals ) ) {
				set_transient( 'signal_data_' . self::PLUGIN_PREFIX, $signals, DAY_IN_SECONDS );
			}
		}

		set_transient( 'signal_last_fetch_' . self::PLUGIN_PREFIX, time(), HOUR_IN_SECONDS );
	}

	/**
	 * Get current admin screen ID.
	 *
	 * @return string
	 */
	private static function get_current_screen_id() {
		$screen = get_current_screen();
		return $screen ? $screen->id : '';
	}

	/**
	 * Render signals as admin notices.
	 */
	public static function render_signals() {
		$signals = get_transient( 'signal_data_' . self::PLUGIN_PREFIX );

		if ( ! is_array( $signals ) || empty( $signals ) ) {
			return;
		}

		$current_screen = self::get_current_screen_id();
		$user_id        = get_current_user_id();
		$user_meta_key  = 'signal_status_' . self::PLUGIN_PREFIX;
		$signal_status  = get_user_meta( $user_id, $user_meta_key, true );

		if ( ! is_array( $signal_status ) ) {
			$signal_status = array();
		}

		foreach ( $signals as $signal ) {
			$signal_id = $signal['id'];

			// Skip if dismissed.
			if ( isset( $signal_status[ $signal_id ]['dismissed_at'] ) ) {
				continue;
			}

			// Check delay.
			if ( ! empty( $signal['delay_days'] ) ) {
				$install_time = get_option( 'qatp_installed_time', time() );
				$show_after   = $install_time + ( absint( $signal['delay_days'] ) * DAY_IN_SECONDS );
				if ( time() < $show_after ) {
					continue;
				}
			}

			// Check screens.
			if ( ! empty( $signal['target_screens'] ) && ! in_array( $current_screen, $signal['target_screens'], true ) ) {
				continue;
			}

			self::render_signal( $signal );
		}

		self::enqueue_dismiss_script();
	}

	/**
	 * Render a single signal notice.
	 *
	 * @param array $signal The signal data.
	 */
	private static function render_signal( $signal ) {
		$signal_id = $signal['id'];
		$position  = ! empty( $signal['position'] ) ? $signal['position'] : 'top';

		// Determine CSS classes based on position.
		$is_floating = in_array( $position, array( 'bottom-right', 'bottom-left' ), true );
		$classes     = $is_floating
			? 'qatp-signal-floating qatp-signal-' . esc_attr( $position )
			: 'notice notice-info is-dismissible';
		$classes    .= ' qatp-signal-notice';
		?>
		<div class="<?php echo esc_attr( $classes ); ?>" data-signal-id="<?php echo esc_attr( $signal_id ); ?>">
			<?php if ( $is_floating ) : ?>
				<button type="button" class="qatp-signal-close" aria-label="<?php esc_attr_e( 'Dismiss this notice', 'query-all-the-post-types' ); ?>">&times;</button>
			<?php endif; ?>

			<?php if ( ! empty( $signal['image_url'] ) ) : ?>
				<img src="<?php echo esc_url( $signal['image_url'] ); ?>" alt="" class="qatp-signal-image">
			<?php endif; ?>

			<?php if ( ! empty( $signal['heading'] ) ) : ?>
				<h3 class="qatp-signal-heading"><?php echo esc_html( $signal['heading'] ); ?></h3>
			<?php endif; ?>

			<?php if ( ! empty( $signal['message'] ) ) : ?>
				<p class="qatp-signal-message"><?php echo wp_kses_post( $signal['message'] ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $signal['features'] ) && is_array( $signal['features'] ) ) : ?>
				<ul class="qatp-signal-features">
					<?php foreach ( $signal['features'] as $feature ) : ?>
						<li><?php echo esc_html( $feature ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php if ( ! empty( $signal['buttons'] ) && is_array( $signal['buttons'] ) ) : ?>
				<p class="qatp-signal-buttons">
					<?php foreach ( $signal['buttons'] as $button ) : ?>
						<a href="<?php echo esc_url( $button['url'] ); ?>" class="button <?php echo isset( $button['class'] ) ? esc_attr( $button['class'] ) : ''; ?>" target="<?php echo isset( $button['target'] ) ? esc_attr( $button['target'] ) : '_self'; ?>">
							<?php echo esc_html( $button['text'] ); ?>
						</a>
					<?php endforeach; ?>
				</p>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Enqueue inline styles and script for signals.
	 */
	private static function enqueue_dismiss_script() {
		?>
		<style>
		/* Floating signal notifications */
		.qatp-signal-floating {
			position: fixed;
			bottom: 20px;
			z-index: 9999;
			max-width: 400px;
			background: #fff;
			border: 1px solid #c3c4c7;
			border-left: 4px solid #2271b1;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
			padding: 16px 40px 16px 16px;
			border-radius: 4px;
		}
		.qatp-signal-floating.qatp-signal-bottom-right {
			right: 20px;
		}
		.qatp-signal-floating.qatp-signal-bottom-left {
			left: 20px;
		}
		.qatp-signal-close {
			position: absolute;
			top: 8px;
			right: 8px;
			background: none;
			border: none;
			font-size: 20px;
			cursor: pointer;
			color: #787c82;
			padding: 0;
			line-height: 1;
		}
		.qatp-signal-close:hover {
			color: #1d2327;
		}
		.qatp-signal-floating .qatp-signal-image {
			max-width: 100px;
			float: right;
			margin: 0 0 10px 15px;
			border-radius: 4px;
		}
		.qatp-signal-floating .qatp-signal-heading {
			margin: 0 0 8px 0;
			font-size: 14px;
		}
		.qatp-signal-floating .qatp-signal-message {
			margin: 0 0 12px 0;
			font-size: 13px;
			color: #50575e;
		}
		.qatp-signal-floating .qatp-signal-features {
			list-style: disc;
			margin: 0 0 12px 20px;
			font-size: 13px;
		}
		.qatp-signal-floating .qatp-signal-buttons {
			margin: 12px 0 0 0;
		}
		.qatp-signal-floating .qatp-signal-buttons .button {
			margin-right: 8px;
		}
		/* Top notice styles (keep existing inline styles working) */
		.notice.qatp-signal-notice .qatp-signal-image {
			max-width: 150px;
			float: right;
			margin-left: 15px;
		}
		.notice.qatp-signal-notice .qatp-signal-features {
			list-style: disc;
			margin-left: 20px;
		}
		.notice.qatp-signal-notice .qatp-signal-buttons {
			margin-top: 10px;
		}
		.notice.qatp-signal-notice .qatp-signal-buttons .button {
			margin-right: 8px;
		}
		</style>
		<script>
		jQuery(document).ready(function($) {
			// Handle standard WordPress notice dismiss button.
			$(document).on('click', '.qatp-signal-notice .notice-dismiss', function() {
				var signalId = $(this).closest('.qatp-signal-notice').data('signal-id');
				$.post(ajaxurl, {
					action: 'qatp_signal_dismiss',
					signal_id: signalId,
					nonce: '<?php echo esc_js( wp_create_nonce( 'qatp_signal_action' ) ); ?>'
				});
			});
			// Handle floating notification close button.
			$(document).on('click', '.qatp-signal-close', function() {
				var $notice = $(this).closest('.qatp-signal-notice');
				var signalId = $notice.data('signal-id');
				$notice.fadeOut(200, function() {
					$(this).remove();
				});
				$.post(ajaxurl, {
					action: 'qatp_signal_dismiss',
					signal_id: signalId,
					nonce: '<?php echo esc_js( wp_create_nonce( 'qatp_signal_action' ) ); ?>'
				});
			});
		});
		</script>
		<?php
	}

	/**
	 * Handle AJAX dismiss request.
	 */
	public static function handle_dismiss() {
		check_ajax_referer( 'qatp_signal_action', 'nonce' );

		$signal_id = isset( $_POST['signal_id'] ) ? absint( $_POST['signal_id'] ) : 0;
		if ( ! $signal_id ) {
			wp_die();
		}

		$user_id       = get_current_user_id();
		$user_meta_key = 'signal_status_' . self::PLUGIN_PREFIX;
		$signal_status = get_user_meta( $user_id, $user_meta_key, true );

		if ( ! is_array( $signal_status ) ) {
			$signal_status = array();
		}

		$signal_status[ $signal_id ] = array(
			'dismissed_at' => time(),
		);

		update_user_meta( $user_id, $user_meta_key, $signal_status );

		wp_send_json_success();
	}
}

QATP_Signal_Receiver::init();
