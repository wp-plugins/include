=== Include ===
Contributors: mflynn, cngann
Tags: shortcodes, posts, pages, the loop, include, include other post, include other pages, loop, get
Requires at least: 2.5
Tested up to: 3.8.1
Stable tag: 1.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A shortcode that includes other posts / pages with no nesting of the shortcode, to allow for multiple pages to call each other so that they display their chunks in different orders.

== Description ==

A shortcode that includes other posts / pages with no nesting of the shortcode, to allow for multiple pages to call each other so that they display their chunks in different orders.

`[include id="XXX" show_title="true" title_wrapper="h2" hr="n" recursion="weak" ]`

Recursion options:
* strict: only show first page, do not run `[include]` if it's included
* weak: only filter out shortcodes with the same id as the current shortcode to prevent infinate loops


== Changelog ==

= 1.3 =
* Removed dependancy on PHP 5.3+
* Determined correct "requires at least" version

= 1.2 =
* Added 'hr' Parameter
* Added changelog
* Added cngann as author

= 1.0 =
* First Check-In

== Installation ==

1. Upload `include-shortcode` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Future Plans ==

* Figure out how to include the page-template (if it exists) - with the post, but without header or footer
* Better documentation / usage descriptors / examples
* TinyMCE Integration - Waiting on WP 3.9 (TinyMCE v4)
* * Buttons to create/edit shortcode
* * Have the editor display included content, and update included pages on save
* Include all child pages in order
* Include all child pages in order as tabs
* Include all child pages in order as slides