=== Query All The Post Types ===
Contributors: GeekStreetWP
Author URI: https://russellenvy.com
Tags: post types, custom post type, cpt, developer tools, woocommerce
Requires at least: 5.0
Tested up to: 6.9
Stable tag: 2.0.1
Requires PHP: 7.4
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A developer tool that displays all registered post types with their settings, supports, taxonomies, labels, and REST API endpoints.

== Description ==

Query All The Post Types is a lightweight developer tool that **auto-detects** every registered post type on your WordPress site and displays comprehensive information about each one.

Post types are automatically grouped by origin — no configuration required.

**WooCommerce store owners:** All your WooCommerce post types (products, orders, coupons, subscriptions, etc.) are grouped in a dedicated purple **WooCommerce tab** for easy access.

= Features =

* **Auto-Detection** — Discovers all post types registered by WordPress core, plugins, and themes
* **Tabbed Interface** — Post types organized into logical groups for easy navigation
* **Comprehensive Data** — View all registration settings, REST API config, supports, taxonomies, and labels
* **REST API Links** — Clickable endpoint URLs for post types exposed to the REST API
* **WooCommerce Tab** — Dedicated purple tab groups all your WooCommerce post types (products, orders, coupons, and more)
* **Quick Actions** — View All and Add New buttons for post types with admin UI

= Post Type Groups =

* **WordPress Core — Public** — Built-in types with a UI (post, page, attachment)
* **WordPress Core — Internal** — Built-in types without a UI (revision, nav_menu_item, wp_template, etc.)
* **WooCommerce** — Products, orders, coupons, and other Woo-related types (when active)
* **Plugin/Theme — Public** — Custom post types with a public UI
* **Plugin/Theme — Internal** — Custom post types without a public UI

= Data Displayed Per Post Type =

* Slug, description, and all boolean settings
* Public, publicly queryable, show UI, show in nav menus, show in admin bar
* REST API: show in REST, REST base, REST namespace, REST controller class
* Has archive, exclude from search, capability type, map meta cap
* Hierarchical, rewrite rules, query var, menu position, menu icon
* Can export, delete with user
* Supported features (title, editor, thumbnail, excerpt, comments, etc.)
* Associated taxonomies with admin links
* All registered labels (expandable section)
* REST API endpoint URL (clickable)

== Installation ==

1. Upload the `query-all-the-post-types` folder to `/wp-content/plugins/`
2. Activate the plugin through the Plugins menu
3. Navigate to **Tools > Query Post Types**

== Frequently Asked Questions ==

= How does the plugin detect post types? =

It uses the WordPress core function `get_post_types()` to retrieve all registered post types at runtime. Nothing is hardcoded — any post type registered by any plugin, theme, or WordPress core will appear automatically.

= Where do I find the plugin page? =

Go to **Tools > Query Post Types** in your WordPress admin dashboard.

= I updated and can't find the plugin anymore! =

In version 2.0, the plugin moved from its own top-level admin menu to the **Tools** menu. Look for **Tools > Query Post Types**.

= Why don't I see View All / Add New buttons on some post types? =

These buttons only appear for post types that have `show_ui` set to `true`. Internal post types without an admin interface won't have these action buttons.

= Where are my WooCommerce post types? =

Look for the purple **WooCommerce tab**! All WooCommerce-related post types (products, orders, coupons, subscriptions, etc.) are grouped there for easy access. The tab only appears when WooCommerce is active.

= Can I use this on a production site? =

Yes. The plugin is read-only and doesn't modify any data. It only displays information about registered post types.

= Does this plugin work with multisite? =

Yes. Each site in a multisite network will display its own registered post types.

== Screenshots ==

1. Main interface showing post types grouped into tabs
2. Post type card with settings, supports, and taxonomies
3. WooCommerce tab with purple-branded styling

== Changelog ==

= 2.0.1 =
* Accessibility: Added aria-hidden to decorative sidebar icons
* Accessibility: Settings tables now use proper th scope="row" for screen readers
* Accessibility: Added prefers-reduced-motion support for users who prefer reduced animations
* Tested up to WordPress 6.9

= 2.0.0 =
* **Breaking:** Plugin page moved to **Tools > Query Post Types** (was its own top-level menu)
* Complete rewrite with modern OOP architecture
* New tabbed interface for better organization
* Auto-detection of all post types (zero hardcoded slugs)
* Intelligent grouping based on _builtin, public, and show_ui properties
* WooCommerce ecosystem tab with custom styling (when WooCommerce is active)
* Comprehensive settings display for each post type
* REST API endpoint links
* Feature support badges
* Taxonomy links to admin pages
* Expandable labels section
* Page header with post type statistics
* Sidebar with about info and legend
* Responsive card-based layout
* WordPress 5.7 admin color palette
* All output properly escaped per WordPress coding standards

= 1.9.4 =
* Tested with WP 5.0

= 1.9.3 =
* Added post type counter details

= 1.9.2 =
* Fixed SVN sync issues from 1.9.1

= 1.9.1 =
* Fixed changelog link in admin panel
* Fixed unlinked taxonomies in newer WooCommerce versions
* Fixed taxonomies not showing for hierarchical post types
* Added link to custom post type register page
* Added active post type count display

= 1.9 =
* Major UI overhaul with color-coded post type categories
* Added WooCommerce core post type support

= 1.8.1 =
* Security improvements

= 1.8 =
* Refactored page layout
* Added sidebar, CPT details, action buttons

= 1.0 =
* Initial release

== Upgrade Notice ==

= 2.0.0 =
Major update! The plugin page has moved to **Tools > Query Post Types** (previously had its own top-level menu). New tabbed interface, WooCommerce support, and comprehensive post type data display.
