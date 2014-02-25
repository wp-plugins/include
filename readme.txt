=== Include ===
Contributors: mflynn, cngann
Tags: shortcodes, posts, pages, the loop, include, include other post, include other pages, loop, get
Requires at least: 2.5
Tested up to: 3.8.1
Stable tag: 1.5.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A shortcode that includes other posts / pages with no nesting of the shortcode, to allow for multiple pages to call each other so that they display their chunks in different orders.

== Description ==

**Shortcode: `[include]`**

*Parameters*

* id: the page/post/etc id to use
* slug: the page slug to use to find the ID
* show_title: set to anything other than "" to show the title of the included page
* title_wrapper_elem: the type of element to wrap the title with
 * Default: h2
* title_wrapper_class: a class to assign to the title wrap
* recursion:
 * Options:
  * strict: only show first page, do not run `[include]` if it's included
  * weak: only filter out shortcodes with the same id as the current shortcode to prevent infinate loops
 * Default: weak

*Example*

`[include id="XXX" show_title="true" title_wrapper="h2" hr="n" recursion="weak" ]`

A shortcode that includes other posts / pages with no nesting of the shortcode, to allow for multiple pages to call each other so that they display their chunks in different orders.

= Future Plans =

* Figure out how to include the page-template (if it exists) - with the post, but without header or footer
* TinyMCE Integration - Waiting on WP 3.9 (TinyMCE v4)
 * Buttons to create/edit shortcode
 * Have the editor display included content, and update included pages on save
* Include all child pages in order
* Include all child pages in order as tabs
* Include all child pages in order as slides

== Changelog ==

= 1.4 =
* Added Documentation

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