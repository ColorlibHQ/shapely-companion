=== Shapely Companion ===
Contributors: colorlibplugins, silkalns
Tags: woocommerce, widgets, demo, companion, one page
Requires at least: 6.4
Requires PHP: 7.4
Tested up to: 7.0
Stable tag: 1.2.11
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Shapely Companion is a companion plugin for Shapely WordPress theme by Colorlib.com.
== Description ==

Shapely Companion is a companion for Shapely One Page WordPress theme by Colorlib.com. This plugin won't do anything for other free or premium WordPress themes and you need to download and install <a href="https://colorlib.com/wp/themes/shapely/" target="_blank">Shapely</a>. If you are having problems with Shapely theme or its companion plugin the fastest way to receive help is via our theme <a href="https://colorlib.com/wp/forums" target="_blank">support forum</a>.

This plugin will add necessary WordPress widgets and allow to import demo content which will help you to with website setup.

While Shapely is a great one page WordPress theme it might not be for everyone therefore you might want to check other free <a href="https://colorlib.com/wp/themes/" target="_blank">WordPress themes</a> that are created by Colorlib.

= Plugin Options =

* Creates required WordPress widgets to be used in theme
* Creates demo(dummy) content for widgets to make them easier to use and understand how they work
* Provides an option to import demo(dummy) content.

= About Colorlib =

Colorlib is the best and by far the most popular source for free and premium WordPress themes. Our themes has been downloaded over 1,5 million times and are used by developers, webmasters and regular users all over the world. We believe in open source and that's why we have made our themes free to use for private and commercial use.

= Further Reading =

If you are new to WordPress but are dedicated to <a href="https://colorlib.com/wp/how-to-make-a-website/" target="_blank" >make a website</a> on your own Colorlib is the right place to start. Usually the trickiest part is to choose the right hosting because all hosting providers are not equal. We have outlined the best <a href="https://colorlib.com/wp/wordpress-hosting/" target="_blank"> WordPress hosting</a> providers and we hope you'll find them useful.


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the whole contents of the folder `shapely-companion` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress dashboard
3. Enjoy using it :)


== Frequently Asked Questions ==

= What themes this plugin supports? =

Currently it works only with Shapely theme.

= Am I obligated to use it? =

You can still use Shapely theme without this plugin but you won't be able to import demo content and use theme specific widgets that you see on front page of theme demo.

== Changelog ==

= 1.2.11 =
* Security: the shapely_get_attachment_image and shapely_get_attachment_media AJAX actions were also registered for logged-out visitors (wp_ajax_nopriv_) with no nonce and no capability check, letting anyone resolve an arbitrary attachment ID to its URL and enumerate media attached to drafts and private posts. Both now require an authenticated user with the upload_files capability and a valid nonce.
* Fixed the Portfolio and Testimonials widgets silently disappearing on Jetpack 13 and newer. Registration was gated on Jetpack::is_module_active( 'custom-content-types' ), which now returns false even when the post types are registered and enabled, so both sections vanished from the demo homepage.
* Import Demo Content is now idempotent: it reuses the existing Front Page and Blog pages instead of creating duplicate front-page-2 / blog-2 pages each time it is run.
* Replaced the deprecated get_page_by_title() (deprecated in WordPress 6.2) in the demo importer.
* Fixed the Clients widget logo re-ordering breaking under jQuery 4, which removes jQuery.fn.bind().
* Fixed the Call for Action widget rendering an empty <a href=""></a> when no button was configured, and using esc_url_raw() for HTML output, which left ampersands unencoded in links with query strings.
* Committed the admin.js AJAX response handling that shipped in 1.2.10 but was never pushed to the repository.
* Tested against WordPress 7.0 and PHP 8.5.

= 1.2.10 =
* Fixed demo content import functionality
* Added proper error handling for failed imports
* Fixed contact form widget PHP warnings
* Added null checks for non-existent contact forms
* Improved AJAX response handling in admin.js
* Enhanced demo content with better sample posts
* Fixed frontpage template assignment during import
* Added detailed error logging for debugging

= 1.2.9 =
* Fixed compatibility with PHP 8.4
* Fixed broken demo content
* Improved widget alignment options
* Added better social menu integration
* Enhanced category widget functionality
* Updated Font Awesome to version 6

= 1.2.7 =
* Fixed: Sanitizations & Security

= 1.2.6 =
* Fixed demo images
* compatibility with jQuery 3.0

= 1.2.5 =

* Improved compatibility with Kali Forms plugin.

= 1.2.4 =

* Implemented milestone https://github.com/puikinsh/shapely/milestone/8?closed=1

= 1.2.2 =

* Implemented milestone https://github.com/puikinsh/shapely/milestone/6?closed=1
* Updated player.js Vimeo library
* Improved checks for JetPack exists

= 1.2.1 =

* Implemented milestone https://github.com/puikinsh/shapely/milestone/5

= 1.2.0 =

* Implemented milestone https://github.com/puikinsh/shapely/milestone/4

= 1.0.6 =
* Added Vimeo for Video Widget
* Changed images' path from demo importer.
* Fixed PHP error that occurs with lower PHP Versions.
* Integrated with Travis

= 1.0.5 =
* Updated demo content importer
* Allow html on title,description,buttons of Shapely Parallax Widget

= 1.0.3 =
* Updated escape functions to allow users to enter minimal HTML in textareas

= 1.0.2 =
* Various bug fixes.

= 1.0.0 =
* Initial release.

== Upgrade Notice ==

= 1.2.11 =
Security release. Two AJAX endpoints were reachable by logged-out visitors and could be used to enumerate media URLs, including attachments on drafts and private posts. Updating is recommended for all sites.
