=== Include ===
Contributors: mflynn, cngann, Clear_Code, bmcswee
Tags: shortcodes, page, post, posts, pages, the loop, include, include other post, include other pages, loop, get, utilities, fetch, content,
Requires at least: 2.5
Tested up to: 4.0
Stable tag: 2.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Include one Page or Post into another.

== Description ==

**Shortcode: `[include]`**

*Parameters*

* id: the page/post/etc id to use
* slug: the page slug to use to find the ID
* title: the type of element to wrap the title with.  If set to "" no title will be displayed.
 * Default: h2
* title_class: a class to assign to the title
* wrap: the type of element to wrap the entire include area with.  If set to "" no wrap will be applied.
 * Default: div
* wrap_class: a class you want assigned to the wrap.
 * Default: 'included'
* hr: Display a hr before the include.  Set to "" to not display the hr.
* recursion:
 * Options:
  * strict: only show first page, do not run `[include]` if it's included
  * weak: only filter out shortcodes with the same id as the current shortcode to prevent infinate loops
 * Default: weak

*Depreciated Parameters*

These parameters are depreciated, but still supported (for now).

* title_wrapper_elem: old name for title
* title_wrapper_class: old name for title_class

*Example*

`[include id="XXX" title="true" title_elem="h2" title_class="include-title" hr="" recursion="weak" wrap="article" wrap_class="news"]`
`[include slug="hello-world"]`

A shortcode that includes other posts / pages with no nesting of the shortcode, to allow for multiple pages to call each other so that they display their chunks in different orders.

**Shortcode: `[include_children]`**

*Parameters*

* id: the page/post/etc id to use
* slug: the page slug to use to find the ID
* title: the type of element to wrap the title with.  If set to "" no title will be displayed.
 * Default: h2
* title_class: a class to assign to the title
* wrap: the type of element to wrap the entire include area with.  If set to "" no wrap will be applied.
 * Default: div
* wrap_class: a class you want assigned to the wrap.
 * Default: 'included'
* hr: Display a hr before the include.  Set to "" to not display the hr.
* recursion:
 * Options:
  * strict: only show first page, do not run `[include]` if it's included
  * weak: only filter out shortcodes with the same id as the current shortcode to prevent infinate loops
 * Default: weak

*Depreciated Parameters*

These parameters are depreciated, but still supported (for now).

* title_wrapper_elem: old name for title
* title_wrapper_class: old name for title_class

Same as Include, except that if no ID is given, it includes all child pages of the current page, in order.
If an ID is given it includes the child pages of that page, in order.

= Future Plans =

* TinyMCE Integration - Waiting on WP 3.9 (TinyMCE v4)
 * Buttons to create/edit the include shortcode
 * Have the editor display included content, and update included pages on save
* Add button/modal like "Add Media" to generate shortcodes for the user and place them in the editor

== Screenshots ==

1. The Include Plugin default Options Panel.  Set the default options for the includes here.  Located at Tools > Include

== Changelog ==

= 2.5 = 
* Fix for sizable bug.  Settings panel didn’t do anything… Now it does.

= 2.4 =
* Fix for 2.3 array bug

= 2.3 =
* Updated documentation to be displaying the correct information.
* Code Cleanup

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