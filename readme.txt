=== Query All The Post Types ===
Contributors: GeekStreetWP
Author URI: http://russellenvy.com
Tags: post, posts, page, pages, plugin, plugins, admin, custom post type, dashboard, list
Requires at least: 4.1
Tested up to: 4.7.2
Stable tag: 1.8
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A top level view of all the post types & associated taxonomies currently registered on your WordPress install.

== Description ==

You install a plugin and it registers a Portfolio custom post type. You would assume the post type is named "portfolio". After hours of digging, you discover it's actually named "porftolio_awesome_type". Wouldn't it be easier to have a top level view of all your post types & associated taxonomies, custom or default? We have you covered. Simply install and view the plugin page. You'll find all the active post types & associated taxonomies on your current WP Install.

Supports all post types that come default with WordPress and all Custom Post types in your theme or plugins. Works with WooCommerce, Easy Digital Downloads, Custom Post Type UI, Pods & many more.

= Plugins We've Tested =
* Jetpack By WordPress.com
* Custom Post Type UI
* Pods
* Advanced Custom Fields
* Contact Form 7
* Hashtag URL Placeholder
* WP-PageNavi
* Google XML Sitemaps
* Theme Check
* Easy Digital Downloads
* WooCommerce
* TinyMCE Advanced
* Give
* The Events Calendar
* bbPress
* BuddyPress
* Google Analytics by MonsterInsights
* Yoast SEO
* WordPress Importer

= Introduction =
[youtube https://www.youtube.com/watch?v=vvzRC20sFOQ]
                      
== Frequently Asked Questions ==

= Does this plugin work with all plugins & themes? =

As of right now, we have tested 19 of the most popular plugins. More are being added every day. We'll get to themes sometime down the road.

= What version(s) of WordPress have been tested? =

As of now, we've tested the plugin against the last 5 versions of WordPress.

= What are post type definitions? =

We have set up a check to determine if a post type is public facing, hidden or some type of other custom post type. This is to make it easier for the end user to understand why a custom post type might be hidden from the WordPress Navigation Menu.

= Why is a hidden post type showing as a regular post type? =

Simple. We have not added it to the function that defines what is a hidden post type. Open a suppor ticket and let us know if you find a plugin with a hidden post type.

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
