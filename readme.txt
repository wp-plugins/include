=== Include ===
Contributors: mflynn, cngann, Clear_Code, bmcsweeney
Tags: shortcodes, posts, pages, the loop, include, include other post, include other pages, loop, get, utilities, 
Requires at least: 2.5
Tested up to: 3.9.1
Stable tag: 2.2
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

`[include id="XXX" show_title="true" title_wrapper_elem="h2" title_wrapper_class="include-title" hr="n" recursion="weak" ]`
`[include slug="hello-world"]`

A shortcode that includes other posts / pages with no nesting of the shortcode, to allow for multiple pages to call each other so that they display their chunks in different orders.

**Shortcode: `[include_children]`**

Same as Include, except that if no ID is given, it includes all child pages of the current page, in order.
If an ID is given it includes the child pages of that page, in order.

= Future Plans =

* TinyMCE Integration - Waiting on WP 3.9 (TinyMCE v4)
 * Buttons to create/edit shortcode
 * Have the editor display included content, and update included pages on save
* Add button/modal like "Add Media" to generate shortcodes for the user and place them in the editor

== Screenshots ==

1. The Include Plugin default Options Panel.  Set the default options for the includes here.

== Changelog ==

= 2.0 =
* Addition of wrap attribute
* Addition of wrap_class attribute
* Addition of include_children shortcode

= 1.7.1 =
* Bugfix for site php error

= 1.7 =
* Added Full PHPdoc Documentation and Line-By-Line comments for what's happening

= 1.6 =
* Added anchor tag

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
1. Activate the plugin through the 'Plugins' menu in WordPress