<?php
/**
 * Admin page rendering.
 *
 * @package QueryAllThePostTypes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles the admin menu registration and page output.
 */
class QATP_Admin_Page {

	/**
	 * Register the Tools sub-menu page.
	 */
	public function register_menu() {
		add_management_page(
			__( 'Query All The Post Types', 'query-all-the-post-types' ),
			__( 'Query Post Types', 'query-all-the-post-types' ),
			'manage_options',
			'query-all-the-post-types',
			array( $this, 'render_page' )
		);
	}

	/**
	 * Render the main plugin page with tabbed groups.
	 */
	public function render_page() {
		$classifier = new QATP_Post_Type_Classifier();
		$renderer   = new QATP_Post_Type_Renderer();
		$groups     = $classifier->get_grouped_post_types();
		$total      = array_sum(
			array_map(
				function ( $g ) {
					return count( $g['post_types'] );
				},
				$groups
			)
		);

		// Filter out empty groups for tabs.
		$active_groups = array_filter(
			$groups,
			function ( $g ) {
				return ! empty( $g['post_types'] );
			}
		);

		echo '<div class="wrap qatp-wrap">';

		// Screen-reader-only H1 to catch admin notices above our custom header.
		echo '<h1 class="screen-reader-text">' . esc_html__( 'Query All The Post Types', 'query-all-the-post-types' ) . '</h1>';

		// Page header banner.
		echo '<div class="qatp-page-header">';
		echo '<div class="qatp-page-header-inner">';
		echo '<div class="qatp-page-header-text">';
		echo '<span class="qatp-page-title">' . esc_html__( 'Query All The Post Types', 'query-all-the-post-types' ) . '</span>';
		echo '<p class="qatp-page-subtitle">' . esc_html__( 'Auto-detected post types registered on this WordPress installation.', 'query-all-the-post-types' ) . '</p>';
		echo '</div>';
		echo '<div class="qatp-page-header-stats">';
		echo '<div class="qatp-stat"><span class="qatp-stat-number">' . (int) $total . '</span><span class="qatp-stat-label">' . esc_html__( 'Total', 'query-all-the-post-types' ) . '</span></div>';
		foreach ( $active_groups as $group ) {
			echo '<div class="qatp-stat"><span class="qatp-stat-number">' . (int) count( $group['post_types'] ) . '</span><span class="qatp-stat-label">' . esc_html( $group['label'] ) . '</span></div>';
		}
		echo '</div>';
		echo '</div>';
		echo '</div>';

		echo '<div id="poststuff">';
		echo '<div id="post-body" class="metabox-holder columns-2">';

		// Main content area.
		echo '<div id="post-body-content">';

		// Tab navigation bar.
		echo '<nav class="qatp-tabs" role="tablist" aria-label="' . esc_attr__( 'Post type groups', 'query-all-the-post-types' ) . '">';
		$first = true;
		foreach ( $active_groups as $key => $group ) {
			$active_class   = $first ? ' qatp-tab-active' : '';
			$selected       = $first ? 'true' : 'false';
			$tabindex       = $first ? '0' : '-1';
			$ecosystem_attr = isset( $group['key'] ) ? ' data-ecosystem="' . esc_attr( $group['key'] ) . '"' : '';
			$tab_id         = 'qatp-tab-' . $key;
			$panel_id       = 'qatp-panel-' . $key;
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $ecosystem_attr is escaped above.
			echo '<button type="button" class="qatp-tab' . esc_attr( $active_class ) . '" id="' . esc_attr( $tab_id ) . '" data-tab="' . esc_attr( $key ) . '"' . $ecosystem_attr . ' role="tab" aria-selected="' . esc_attr( $selected ) . '" aria-controls="' . esc_attr( $panel_id ) . '" tabindex="' . esc_attr( $tabindex ) . '">';
			echo '<span class="qatp-tab-dot" aria-hidden="true" style="background:' . esc_attr( $group['color'] ) . ';"></span>';
			echo '<span class="qatp-tab-text">' . esc_html( $group['label'] ) . '</span>';
			echo '<span class="qatp-tab-count">' . (int) count( $group['post_types'] ) . '</span>';
			echo '</button>';
			$first = false;
		}
		echo '</nav>';

		// Tab content panels.
		$first = true;
		foreach ( $active_groups as $key => $group ) {
			$display   = $first ? 'block' : 'none';
			$hidden    = $first ? 'false' : 'true';
			$group_key = isset( $group['key'] ) ? $group['key'] : '';
			$tab_id    = 'qatp-tab-' . $key;
			$panel_id  = 'qatp-panel-' . $key;
			echo '<div class="qatp-tab-panel" id="' . esc_attr( $panel_id ) . '" role="tabpanel" aria-labelledby="' . esc_attr( $tab_id ) . '" aria-hidden="' . esc_attr( $hidden ) . '" tabindex="0" style="display:' . esc_attr( $display ) . ';">';
			foreach ( $group['post_types'] as $pt_obj ) {
				$renderer->render_card( $pt_obj, $group_key );
			}
			echo '</div>';
			$first = false;
		}

		echo '</div>'; // #post-body-content.

		// Sidebar column.
		echo '<div id="postbox-container-1" class="postbox-container">';
		$this->render_sidebar( $active_groups );
		echo '</div>';

		echo '</div>'; // #post-body.
		echo '</div>'; // #poststuff.
		echo '</div>'; // .wrap.
	}

	/**
	 * Render the sidebar with legend, feedback, and about boxes.
	 *
	 * @param array $groups Active post type groups.
	 */
	private function render_sidebar( $groups ) {
		// Legend box.
		echo '<div class="qatp-sidebar-box">';
		echo '<div class="qatp-sidebar-header">';
		echo '<span class="dashicons dashicons-editor-help qatp-sidebar-icon"></span>';
		echo '<h3>' . esc_html__( 'Legend', 'query-all-the-post-types' ) . '</h3>';
		echo '</div>';
		echo '<div class="qatp-sidebar-body qatp-legend-body">';
		foreach ( $groups as $group ) {
			echo '<div class="qatp-legend-row">';
			echo '<span class="qatp-legend-dot" style="background-color:' . esc_attr( $group['color'] ) . ';"></span>';
			echo '<span class="qatp-legend-label">' . esc_html( $group['label'] ) . '</span>';
			echo '<span class="qatp-legend-count">' . (int) count( $group['post_types'] ) . '</span>';
			echo '</div>';
		}
		echo '</div></div>';

		// Feedback box.
		echo '<div class="qatp-sidebar-box">';
		echo '<div class="qatp-sidebar-header">';
		echo '<span class="dashicons dashicons-star-filled qatp-sidebar-icon"></span>';
		echo '<h3>' . esc_html__( 'Feedback', 'query-all-the-post-types' ) . '</h3>';
		echo '</div>';
		echo '<div class="qatp-sidebar-body">';
		echo '<p>' . esc_html__( 'If you find this plugin useful, please leave a review!', 'query-all-the-post-types' ) . '</p>';
		echo '<p><a href="https://wordpress.org/plugins/query-all-the-post-types/#reviews" target="_blank" rel="noopener">' . esc_html__( 'Leave a Review', 'query-all-the-post-types' ) . '<span class="screen-reader-text"> ' . esc_html__( '(opens in a new tab)', 'query-all-the-post-types' ) . '</span></a></p>';
		echo '<p>' . esc_html__( 'Have a question or found a bug?', 'query-all-the-post-types' ) . '</p>';
		echo '<p><a href="https://wordpress.org/support/plugin/query-all-the-post-types/" target="_blank" rel="noopener">' . esc_html__( 'Open a Support Ticket', 'query-all-the-post-types' ) . '<span class="screen-reader-text"> ' . esc_html__( '(opens in a new tab)', 'query-all-the-post-types' ) . '</span></a></p>';
		echo '<p class="qatp-sidebar-note">' . esc_html__( 'WordPress.org account required.', 'query-all-the-post-types' ) . '</p>';
		echo '</div></div>';

		// Notifications box.
		if ( class_exists( 'QATP_Signal_Settings' ) ) {
			QATP_Signal_Settings::render_sidebar_box();
		}

		// About box.
		echo '<div class="qatp-sidebar-box">';
		echo '<div class="qatp-sidebar-header">';
		echo '<span class="dashicons dashicons-info-outline qatp-sidebar-icon"></span>';
		echo '<h3>' . esc_html__( 'About', 'query-all-the-post-types' ) . '</h3>';
		echo '</div>';
		echo '<div class="qatp-sidebar-body">';
		echo '<p>' . esc_html__( 'A developer tool that displays all registered post types on your WordPress site with their settings, supports, taxonomies, labels, and REST API endpoints.', 'query-all-the-post-types' ) . '</p>';
		echo '<p>' . esc_html__( 'Post types are auto-detected and grouped by origin — no configuration required.', 'query-all-the-post-types' ) . '</p>';
		echo '<div class="qatp-sidebar-meta">';
		echo '<span>' . esc_html__( 'Version', 'query-all-the-post-types' ) . ' ' . esc_html( QATP_VERSION ) . '</span>';
		echo '<a href="https://wordpress.org/plugins/query-all-the-post-types/changelog/" target="_blank" rel="noopener">' . esc_html__( 'Changelog', 'query-all-the-post-types' ) . '<span class="screen-reader-text"> ' . esc_html__( '(opens in a new tab)', 'query-all-the-post-types' ) . '</span></a>';
		echo '</div>';
		echo '</div></div>';
	}
}
