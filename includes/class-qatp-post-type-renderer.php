<?php
/**
 * Post type card renderer.
 *
 * @package QueryAllThePostTypes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders individual post type cards with settings, supports, taxonomies, labels, and REST links.
 */
class QATP_Post_Type_Renderer {

	/**
	 * Render a full card for one post type.
	 *
	 * @param WP_Post_Type $obj       The post type object.
	 * @param string       $ecosystem Optional ecosystem key for styling (e.g., 'woocommerce').
	 */
	public function render_card( $obj, $ecosystem = '' ) {
		$slug           = $obj->name;
		$ecosystem_attr = $ecosystem ? ' data-ecosystem="' . esc_attr( $ecosystem ) . '"' : '';

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $ecosystem_attr is escaped above.
		echo '<div class="postbox qatp-card"' . $ecosystem_attr . '>';

		// Card header with label and action buttons.
		echo '<div class="qatp-card-header">';
		echo '<div class="qatp-card-title">';
		echo '<strong>' . esc_html( $obj->labels->name ) . '</strong> ';
		echo '<code>' . esc_html( $slug ) . '</code>';
		echo '</div>';
		if ( ! empty( $obj->show_ui ) ) {
			echo '<div class="qatp-card-actions">';
			echo '<a class="button button-small" href="' . esc_url( admin_url( 'edit.php?post_type=' . $slug ) ) . '">' . esc_html__( 'View All', 'query-all-the-post-types' ) . '</a> ';
			echo '<a class="button button-small" href="' . esc_url( admin_url( 'post-new.php?post_type=' . $slug ) ) . '">' . esc_html__( 'Add New', 'query-all-the-post-types' ) . '</a>';
			echo '</div>';
		}
		echo '</div>';

		echo '<div class="inside">';

		$this->render_settings_table( $obj );
		$this->render_supports( $slug );
		$this->render_taxonomies( $slug );
		$this->render_labels( $obj );
		$this->render_rest_endpoint( $obj );

		echo '</div>';
		echo '</div>';
	}

	/**
	 * Render the key/value settings table.
	 *
	 * @param WP_Post_Type $obj The post type object.
	 */
	private function render_settings_table( $obj ) {
		$rewrite         = $obj->rewrite;
		$rewrite_display = '';
		if ( false === $rewrite ) {
			$rewrite_display = __( 'false', 'query-all-the-post-types' );
		} elseif ( is_array( $rewrite ) ) {
			$parts = array();
			if ( isset( $rewrite['slug'] ) ) {
				/* translators: %s: rewrite slug value */
				$parts[] = sprintf( __( 'slug: %s', 'query-all-the-post-types' ), $rewrite['slug'] );
			}
			if ( isset( $rewrite['with_front'] ) ) {
				/* translators: %s: true or false */
				$parts[] = sprintf( __( 'with_front: %s', 'query-all-the-post-types' ), $rewrite['with_front'] ? __( 'true', 'query-all-the-post-types' ) : __( 'false', 'query-all-the-post-types' ) );
			}
			if ( isset( $rewrite['feeds'] ) ) {
				/* translators: %s: true or false */
				$parts[] = sprintf( __( 'feeds: %s', 'query-all-the-post-types' ), $rewrite['feeds'] ? __( 'true', 'query-all-the-post-types' ) : __( 'false', 'query-all-the-post-types' ) );
			}
			if ( isset( $rewrite['pages'] ) ) {
				/* translators: %s: true or false */
				$parts[] = sprintf( __( 'pages: %s', 'query-all-the-post-types' ), $rewrite['pages'] ? __( 'true', 'query-all-the-post-types' ) : __( 'false', 'query-all-the-post-types' ) );
			}
			$rewrite_display = implode( ', ', $parts );
		} else {
			$rewrite_display = __( 'true', 'query-all-the-post-types' );
		}

		$cap_type = $obj->capability_type;
		if ( is_array( $cap_type ) ) {
			$cap_type = implode( ', ', $cap_type );
		}

		$query_var = $obj->query_var;
		if ( true === $query_var ) {
			$query_var_display = $obj->name;
		} elseif ( is_string( $query_var ) && '' !== $query_var ) {
			$query_var_display = $query_var;
		} else {
			$query_var_display = __( 'false', 'query-all-the-post-types' );
		}

		$description = $obj->description ? $obj->description : "\xe2\x80\x94";

		$rows = array(
			__( 'Slug', 'query-all-the-post-types' )       => esc_html( $obj->name ),
			__( 'Description', 'query-all-the-post-types' ) => esc_html( $description ),
			__( 'Public', 'query-all-the-post-types' )     => $this->bool_label( $obj->public ),
			__( 'Publicly Queryable', 'query-all-the-post-types' ) => $this->bool_label( $obj->publicly_queryable ),
			__( 'Show UI', 'query-all-the-post-types' )    => $this->bool_label( $obj->show_ui ),
			__( 'Show in Nav Menus', 'query-all-the-post-types' ) => $this->bool_label( $obj->show_in_nav_menus ),
			__( 'Show in Admin Bar', 'query-all-the-post-types' ) => $this->bool_label( $obj->show_in_admin_bar ),
			__( 'Show in REST', 'query-all-the-post-types' ) => $this->bool_label( $obj->show_in_rest ),
			__( 'REST Base', 'query-all-the-post-types' )  => esc_html( ! empty( $obj->rest_base ) ? $obj->rest_base : "\xe2\x80\x94" ),
			__( 'REST Namespace', 'query-all-the-post-types' ) => esc_html( ! empty( $obj->rest_namespace ) ? $obj->rest_namespace : "\xe2\x80\x94" ),
			__( 'REST Controller', 'query-all-the-post-types' ) => esc_html( ! empty( $obj->rest_controller_class ) ? $obj->rest_controller_class : "\xe2\x80\x94" ),
			__( 'Has Archive', 'query-all-the-post-types' ) => is_string( $obj->has_archive ) ? esc_html( $obj->has_archive ) : $this->bool_label( $obj->has_archive ),
			__( 'Exclude From Search', 'query-all-the-post-types' ) => $this->bool_label( $obj->exclude_from_search ),
			__( 'Capability Type', 'query-all-the-post-types' ) => esc_html( $cap_type ),
			__( 'Map Meta Cap', 'query-all-the-post-types' ) => $this->bool_label( $obj->map_meta_cap ),
			__( 'Hierarchical', 'query-all-the-post-types' ) => $this->bool_label( $obj->hierarchical ),
			__( 'Rewrite', 'query-all-the-post-types' )    => esc_html( $rewrite_display ),
			__( 'Query Var', 'query-all-the-post-types' )  => esc_html( $query_var_display ),
			__( 'Menu Position', 'query-all-the-post-types' ) => esc_html( null !== $obj->menu_position ? $obj->menu_position : "\xe2\x80\x94" ),
			__( 'Menu Icon', 'query-all-the-post-types' )  => esc_html( ! empty( $obj->menu_icon ) ? $obj->menu_icon : "\xe2\x80\x94" ),
			__( 'Can Export', 'query-all-the-post-types' ) => $this->bool_label( $obj->can_export ),
			__( 'Delete with User', 'query-all-the-post-types' ) => $this->bool_label( $obj->delete_with_user ),
		);

		echo '<table class="widefat qatp-settings-table">';
		echo '<tbody>';
		$i = 0;
		foreach ( $rows as $label => $value ) {
			$alt = ( 0 === $i % 2 ) ? '' : ' alternate';
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $value is pre-escaped above.
			echo '<tr class="' . esc_attr( $alt ) . '"><th scope="row" class="qatp-label">' . esc_html( $label ) . '</th><td>' . $value . '</td></tr>';
			++$i;
		}
		echo '</tbody></table>';
	}

	/**
	 * Render feature support badges.
	 *
	 * @param string $post_type The post type slug.
	 */
	private function render_supports( $post_type ) {
		$all_features = get_all_post_type_supports( $post_type );
		if ( empty( $all_features ) ) {
			return;
		}

		echo '<div class="qatp-supports">';
		echo '<strong>' . esc_html__( 'Supports:', 'query-all-the-post-types' ) . '</strong> ';
		foreach ( array_keys( $all_features ) as $feature ) {
			echo '<span class="qatp-badge">' . esc_html( $feature ) . '</span> ';
		}
		echo '</div>';
	}

	/**
	 * Render linked taxonomy list.
	 *
	 * @param string $post_type The post type slug.
	 */
	private function render_taxonomies( $post_type ) {
		$taxonomies = get_object_taxonomies( $post_type, 'objects' );
		if ( empty( $taxonomies ) ) {
			return;
		}

		echo '<div class="qatp-taxonomies">';
		echo '<strong>' . esc_html__( 'Taxonomies:', 'query-all-the-post-types' ) . '</strong> ';
		$links = array();
		foreach ( $taxonomies as $tax ) {
			if ( $tax->show_ui ) {
				$links[] = '<a href="' . esc_url( admin_url( 'edit-tags.php?taxonomy=' . $tax->name . '&post_type=' . $post_type ) ) . '">' . esc_html( $tax->labels->name ) . ' (' . esc_html( $tax->name ) . ')</a>';
			} else {
				$links[] = esc_html( $tax->labels->name ) . ' (' . esc_html( $tax->name ) . ')';
			}
		}
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- each link is escaped above.
		echo implode( ', ', $links );
		echo '</div>';
	}

	/**
	 * Render the collapsible labels section.
	 *
	 * @param WP_Post_Type $obj The post type object.
	 */
	private function render_labels( $obj ) {
		$labels = (array) $obj->labels;
		if ( empty( $labels ) ) {
			return;
		}

		$id = 'qatp-labels-' . esc_attr( $obj->name );

		echo '<div class="qatp-labels-section">';
		echo '<button type="button" class="button button-small qatp-toggle" data-target="' . esc_attr( $id ) . '" aria-expanded="false" aria-controls="' . esc_attr( $id ) . '">';
		echo esc_html__( 'Toggle Labels', 'query-all-the-post-types' ) . ' (' . (int) count( $labels ) . ')';
		echo '</button>';
		echo '<div id="' . esc_attr( $id ) . '" class="qatp-labels-list" style="display:none;" aria-hidden="true">';
		echo '<table class="widefat qatp-settings-table">';
		echo '<tbody>';
		$i = 0;
		foreach ( $labels as $key => $value ) {
			$alt = ( 0 === $i % 2 ) ? '' : ' alternate';
			echo '<tr class="' . esc_attr( $alt ) . '">';
			echo '<th scope="row" class="qatp-label">' . esc_html( $key ) . '</th>';
			echo '<td>' . esc_html( $value ) . '</td>';
			echo '</tr>';
			++$i;
		}
		echo '</tbody></table>';
		echo '</div></div>';
	}

	/**
	 * Render the REST API endpoint link.
	 *
	 * @param WP_Post_Type $obj The post type object.
	 */
	private function render_rest_endpoint( $obj ) {
		if ( empty( $obj->show_in_rest ) ) {
			return;
		}

		$namespace = ! empty( $obj->rest_namespace ) ? $obj->rest_namespace : 'wp/v2';
		$base      = ! empty( $obj->rest_base ) ? $obj->rest_base : $obj->name;
		$url       = rest_url( $namespace . '/' . $base );

		echo '<div class="qatp-rest-endpoint">';
		echo '<strong>' . esc_html__( 'REST API Endpoint:', 'query-all-the-post-types' ) . '</strong> ';
		echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener"><code>' . esc_html( $url ) . '</code><span class="screen-reader-text"> ' . esc_html__( '(opens in a new tab)', 'query-all-the-post-types' ) . '</span></a>';
		echo '</div>';
	}

	/**
	 * Return an escaped HTML label for a boolean value.
	 *
	 * @param mixed $value The value to display.
	 * @return string
	 */
	private function bool_label( $value ) {
		if ( true === $value ) {
			return '<span class="qatp-bool-true">' . esc_html__( 'true', 'query-all-the-post-types' ) . '</span>';
		}
		if ( false === $value || null === $value ) {
			return '<span class="qatp-bool-false">' . esc_html__( 'false', 'query-all-the-post-types' ) . '</span>';
		}
		return esc_html( $value );
	}
}
