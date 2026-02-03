<?php
/**
 * Post type classifier.
 *
 * @package QueryAllThePostTypes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Groups registered post types into categories by their properties and origin.
 */
class QATP_Post_Type_Classifier {

	/**
	 * Post types that WordPress core registers but does not flag as _builtin.
	 * These are documented as default post types in the Theme Handbook.
	 *
	 * @var array
	 */
	private static $wp_core_types = array(
		'wp_template',
		'wp_template_part',
		'wp_block',
		'wp_navigation',
		'wp_global_styles',
		'wp_font_family',
		'wp_font_face',
	);

	/**
	 * Plugin ecosystem definitions.
	 * Each ecosystem has: label, color, detect_callback, and optional plugin_active check.
	 *
	 * @var array
	 */
	private static $plugin_ecosystems = array(
		'woocommerce' => array(
			'label'       => 'WooCommerce',
			'color'       => '#7f54b3', /* Woo Purple 50: #720EEC, using softer purple for dots/stats */
			'color_dark'  => '#720EEC', /* Woo Purple 50 - for tab/header backgrounds */
			'color_light' => '#873EFF', /* Woo Purple 40 - for card headers */
			'plugin_file' => 'woocommerce/woocommerce.php',
			'patterns'    => array(
				'product',
				'product_variation',
				'shop_order',
				'shop_order_refund',
				'shop_coupon',
				'shop_subscription',
				'shop_order_placehold',
			),
			'prefixes'    => array(
				'shop_',
				'wc_',
			),
		),
	);

	/**
	 * Return all post types grouped into categories.
	 *
	 * @return array Associative array of groups, each with label, color, and post_types.
	 */
	public function get_grouped_post_types() {
		$all_types = get_post_types( array(), 'objects' );
		ksort( $all_types );

		// Build base groups.
		$groups = array(
			'core_public'   => array(
				'label'      => __( 'WordPress Core — Public', 'query-all-the-post-types' ),
				'color'      => '#2271b1', /* Blue 50 */
				'post_types' => array(),
			),
			'core_internal' => array(
				'label'      => __( 'WordPress Core — Internal', 'query-all-the-post-types' ),
				'color'      => '#2271b1', /* Blue 50 */
				'post_types' => array(),
			),
		);

		// Add plugin ecosystem groups (only if plugin is active).
		$active_ecosystems = array();
		foreach ( self::$plugin_ecosystems as $key => $eco ) {
			if ( $this->is_plugin_active( $eco['plugin_file'] ) ) {
				$active_ecosystems[ $key ] = $eco;
				$groups[ $key ]            = array(
					'key'        => $key,
					'label'      => $eco['label'],
					'color'      => $eco['color'],
					'post_types' => array(),
				);
			}
		}

		// Add fallback groups for non-ecosystem plugin/theme CPTs.
		$groups['custom_public']   = array(
			'label'      => __( 'Plugin/Theme — Public', 'query-all-the-post-types' ),
			'color'      => '#000000',
			'post_types' => array(),
		);
		$groups['custom_internal'] = array(
			'label'      => __( 'Plugin/Theme — Internal', 'query-all-the-post-types' ),
			'color'      => '#000000',
			'post_types' => array(),
		);

		// Classify each post type.
		foreach ( $all_types as $pt_obj ) {
			$is_builtin = ! empty( $pt_obj->_builtin ) || in_array( $pt_obj->name, self::$wp_core_types, true );
			$is_visible = ! empty( $pt_obj->public ) || ! empty( $pt_obj->show_ui );

			// Core types.
			if ( $is_builtin ) {
				if ( $is_visible ) {
					$groups['core_public']['post_types'][] = $pt_obj;
				} else {
					$groups['core_internal']['post_types'][] = $pt_obj;
				}
				continue;
			}

			// Check plugin ecosystems.
			$matched_ecosystem = $this->match_ecosystem( $pt_obj->name, $active_ecosystems );
			if ( $matched_ecosystem ) {
				$groups[ $matched_ecosystem ]['post_types'][] = $pt_obj;
				continue;
			}

			// Fallback to generic plugin/theme groups.
			if ( $is_visible ) {
				$groups['custom_public']['post_types'][] = $pt_obj;
			} else {
				$groups['custom_internal']['post_types'][] = $pt_obj;
			}
		}

		return $groups;
	}

	/**
	 * Check if a plugin is active.
	 *
	 * @param string $plugin_file Plugin file path (e.g., 'woocommerce/woocommerce.php').
	 * @return bool
	 */
	private function is_plugin_active( $plugin_file ) {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		return is_plugin_active( $plugin_file );
	}

	/**
	 * Match a post type slug against active plugin ecosystems.
	 *
	 * @param string $slug              The post type slug.
	 * @param array  $active_ecosystems Active ecosystem definitions.
	 * @return string|false Ecosystem key if matched, false otherwise.
	 */
	private function match_ecosystem( $slug, $active_ecosystems ) {
		foreach ( $active_ecosystems as $key => $eco ) {
			// Exact match against known patterns.
			if ( ! empty( $eco['patterns'] ) && in_array( $slug, $eco['patterns'], true ) ) {
				return $key;
			}

			// Prefix match.
			if ( ! empty( $eco['prefixes'] ) ) {
				foreach ( $eco['prefixes'] as $prefix ) {
					if ( 0 === strpos( $slug, $prefix ) ) {
						return $key;
					}
				}
			}
		}

		return false;
	}
}
