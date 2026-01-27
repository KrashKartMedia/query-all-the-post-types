=== Query All The Post Types - WordPress Post Type Scanner Plugin ===
Contributors: GeekStreetWP
Author URI: http://russellenvy.com
Tags: post, posts, page, pages, plugin, plugins, admin, custom post type, dashboard, list
Requires at least: 4.1
Tested up to: 5.0
Stable tag: 1.9.4
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A top level view of all the active post types, custom post types & associated taxonomies currently registered on your WordPress install.

== Description ==

Query All The Post Types is a Free WordPress Post Type Scanner Plugin. A great plugin for new WordPress Developers building themes/plugins/custom queries.

Every post type has a specific name. In that unique name lies a problem. Some post types are called "calendar" and some are called "my_other_calendar". These unique names can become a problem when building custom templates, shortcodes, or queries for your WordPress install. Query All The Post Types is a free WordPress plugin helping WordPress website owners, and developers, view of all the active post types, custom post types & associated taxonomies currently registered on your WordPress install.

Each post type is defined as a Regular CPT, Hidden CPT, WordPress Core - Regular CPT, WordPress Core - Hidden CPT, Regular CPT, Hidden CPT, WooCommerce Core Regular CPT, WooCommerce Core Hidden CPT, and Other. Query All The Post Types displays some object data for each post type. Object data includes: post type name, plural name, singular name, menu name, is public queryable, is hierarchical.

= Introduction =
[youtube https://youtu.be/8raL-2V-5Vw]
                      
== Frequently Asked Questions ==

= What version(s) of WordPress have been tested? =

As of now, we've tested the plugin on WordPress Version 4.1 and higher.

= Does this plugin work with all plugins & themes? =

Yes. However, it's impossible to know every post type active on your WordPress website. The post types we do know about, in popular themes and plugins, will be listed as Regular CPT, Hidden CPT, WordPress Core - Regular CPT, WordPress Core - Hidden CPT, Regular CPT, Hidden CPT, WooCommerce Core Regular CPT, WooCommerce Core Hidden CPT. Everything else will be called Other.

A definition is provided in the sidebar of the plugin settings page.

= What are post type definitions? =

We have set up a check to determine if a post type is public facing, hidden or some type of other custom post type. This is to make it easier for the end user to understand why a custom post type might be hidden from the WordPress Navigation Menu.

== Installation ==

This section describes how to install the plugin and get it working.

= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'Query All The Post Types'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `query-all-the-post-types.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `query-all-the-post-types.zip`
2. Extract the `query-all-the-post-types` directory to your computer
3. Upload the `query-all-the-post-types` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard

== Screenshots ==

1. Plugin page shows you a list of all the post types.

== Changelog ==

= 1.9.4 =
* Installed Most Popular 81 plugins from WordPress.org Tested each Post Type name to see if they're public, private or hidden. Updated our list of arrays.
* Tested with WP 5.0. Ready to go.

= 1.9.3 =
* Added: Post Type Counter Details. Number of post types added by themes and plugins minus the seven core post types equals total number of post types.

= 1.9.2 =
* Fixed: 1.9.1 changes were not taken by svn.

= 1.9.1 =
* Fixed: Changelog link in admin panel.
* Fixed: Unlinked some taxonomies showing up in new WooCommerce version.
* Fixed: If the post type is hierarchical, we were not showing the taxonomies. 
* Added: New link to custom post type register page in admin panel.
* Added: Number of active post types displayed on page.

= 1.9 =
* Removed: Post type names in the headings. Changed to Regular CPT, Hidden CPT, WordPress Core - Regular CPT, WordPress Core - Hidden CPT, Regular CPT, Hidden CPT, WooCommerce Core Regular CPT, WooCommerce Core Hidden CPT, and Other.
* Added: New column for the post type name.
* Added: Defined version number to use as a constant in the plugin.
* Added: New colors for each type of post type heading.
* Added: Now supporting WooCommerce Core Post Types from .org plugin. Has a unique color just for WooCommerce Post Types.
* Added: Give a lot of WooCommerce Add On plugins to test. Defined properly.
* Added: Color cordinated definitions to make post type definitions more recognizable.
* Fixed: CSS style fixes.
* Fixed: Link to changelog
* Fixed: Post types appear in alphabetical order. Starting with underscores, numbers, letters.
* Fixed: Changed Public Queryable and Hierarchical to Is Public Queryable and Is Hierarchical.

= 1.8.1 =
* Updated files with define path exit script. If direct file path is called, exit.
* Updated number of WP versions tested on to 7.
* Tested on 4.7.3.
* Version number bumb.

= 1.8 =
* Removed enqueue_scripts & other files.
* Removed jQuery Themeroller & html to render.
* Removed Bootstrap & html to render.
* Removed Sidebar of suggested plugins & images.
* Removed Thickbox & html to render.
* Removed Footer Details & Moved to another place.
* Refactored page to show hidden, regular and other post types.
* Added new HTML to render page. Thanks to bueltge on Github.
* Added New Sidebar with plugin details, CPT Details & Plugins/Core versions tested on.
* Added new CPT details like Plural name, singular name, menu name, hierarchical & taxonomies.
* Added buttons to View All/ Add New posts to custom post types.
* Added new functions to link to contact form 7 custom pages. CF& doenst use CPTS like other plugins.
* Color coded hidden, regular and other post types.
* Updated list of CPTS and Taxonomies and updated to show link or not.
* Updated Version Number & Tested Up To Number.

= 1.7.2 =
* Removed function to hide hidden post types.
* Added hidden post types to main query on page.
* Assigned a definition to each post type
* Updated thickbox popup to display a list of plugins & wordpress core versions that have been tested.
* Added in 1/2 colums for each post type jQuery Accordion
* Displaying some Post Type Object Details. Such as Name, Singular Name and Menu / Submenu Name.
* Updated Page Settings UI.
* Changed Excluded From Button text. Now reads Tested On.

= 1.7.1 =
* Updated Version Numbering Conflicts.
* Excluded more Custom Post Types without Edit Screen - custom_css & customize_changeset
* Updated Bootstrap Scripts for faster UI. Only loads Bootstrap on our settings page.

= 1.7 =
* Updated UI Visual Look to match Default WP Blue Color.
* Changed list of excluded post types link, from a link to a button and repositioned it lower on page.
* Grammar Checks.
* Removed download link and replaced with install button for 3rd party plugins suggested.
* Added support for multisite install buttons for 3rd party plugins suggested. Used to be a text link, now it's a button. Buttons are now pulled right. 
* If you are using Multisite, the install button links properly to Network Plugins install search page. Before it was breaking Multisite. If you have non Multisite, button links to plugins install search page.


= 1.6.1 =
* Fixed Settings Link. Our code changed all settings links, for all plugins, to our url. It was great promotion, but not intended.
* Removed the events calendar post types tribe-ea-record & deleted_event. Add to list of removed post types.
* Trying something new with links. Links in Ad section take you directly to the plugins install page, with the search term in the url.

= 1.6 =
* Dequeue the events calendar jQuery ui styles on our setting page.
* Update jQuery Theme Roller for better response time.
* Changed links to See All post_types or See All taxonomies.

= 1.5 =
* One file was doing all the work. Added includes to break upspecific functions.
* Changed links titles from Click Here to See All - See All.
* Removed New: from plugin settings page description.

= 1.4 =
* Minified CSS scripts in order to reduce load time.
* Optimized partner images
* Updated Bootstrap Version
* Updates Jquery theme roller

= 1.3 =
* Tested on WP Version 4.5.2
* Updated UI / UX for full responsiveness to the screen.
* Added recommended plugins section for the plugins that extend post types and taxonomies.
* Excluded EDD taxonomies edd_log, edd_payment, edd_discount until we can link to them properly.
* Excluded WooCommerce product_variation, shop_order_refund, product_type
* Added in thickbox function to display a popup of post types and taxonomies excluded.

= 1.2 =
* Added jQuery accordion to the settings page. This way each post type is inside of it’s own accordion item.
* Added in a query to get all of the Taxonomies for each post type. Now you can see all of the post types and taxonomies.

= 1.1 =
* Was adding a menu item for the settings page. Now, the plugin creates a menu options page. Visit Settings > Query The CPT’s

= 1.0 =
* Release Date - 31st March, 2016
* First release
