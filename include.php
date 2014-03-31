<?php
/**
 * Plugin Name: Include
 * Plugin URI: http://wordpress.org/plugins/include/
 * Description: Include a page, post, activity, or other query-object into another.
 * Version: 1.7
 * Author: mflynn, cngann
 * Author URI: http://cngann.com
 * License: GPL2
 */

	/* Define Globals  */

	/**
	 * Current Included Posts
	 *
	 * @author Mike Flynn
	 * @since 1.0
	 * @var array An array of posts currently included to prevent infinate loops
	 * @global array $include_included
	 */
	$include_included = array(  );

	/**
	 * Default Include Shortcode Attributes
	 *
	 * @author Mike Flynn
	 * @since 1.7
	 * @var array An array containing the default attributes for the Include Shortcode
	 * @global array $include_atts
	 */
	$include_atts = array(
		'id' => false,												// (required) The Page/Post Id to Include.  Default: none. Not required if slug is set.
		'slug' => false,											// (optional) The Page/Post Slug to Include. Not recomended as slugs can change.
		'show_title' => false,											// (optional) Show Title.  Default: false.
		'title_wrapper_elem' => 'h2',										// (optional) Title Wrapper Element. Default: h2.
		'title_wrapper_class' => '',										// (optional) Class of Title Wrapper Element. Default: none.
		'recursion' => 'weak',											// (optional) Recursion Setting.  Options: strong or weak. Default: weak
		'hr' => 'n'												// (optional) Show hr before Include.  Default: false.
	);

	add_shortcode('include', 'include_shortcode');									// Add "[include]" shortcode

	require_once('functions.php');											// Include Functions

	/**
	 * ID Exists
	 *
	 * @author Mike Flynn
	 * @since 1.0
	 * @param integer $id The ID to check for
	 * @global $wpdb The WordPress Database Object
	 * @return boolean
	 */
	function id_exists($id){
		global $wpdb;
		return $wpdb->get_var("SELECT count(*) FROM {$wpdb->posts} WHERE ID = '{$id}'") ? true : false;
	}

	/**
	 * Include Shortcode
	 *
	 * Creates and returns the "include" shortcode
	 *
	 * @author Mike Flynn
	 * @since 1.0
	 * @global $include_included A list of files already Included
	 * @global $include_atts The default attributes for the shortcode
	 * @global $wpdb The wordpress database object
	 * @global $post The current post object
	 * @global $wp_query The wp_query object
	 * @param $atts The current shortcode attributes
	 * @param $content The area inbetween the shortcut opener and closer if any
	 * @return string The shortcode content
	 */
	function include_shortcode ($atts, $content){

		/* Setup */

		global $include_included, $include_atts, $wpdb, $post, $wp_query; 					// Get Globals
		$r = ""; 												// Set the return variable
		$include_included[get_the_ID()] = true; 								// Put the current page ID into the list of included pages
		extract( shortcode_atts( $include_atts, $atts, 'include' ) ); 						// Get the attributes
		$hr = strtolower($hr) == 'y'; 										// Set $hr to boolean
		if($id &&  ! id_exists( $id )) return $r; 								// If ID is incorrect, don't continue
		else if(!$id && !$slug) return $r; 									// If no viable include parameters, don't continue
		else if($slug) $id = $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name = '{$slug}'");	// If $slug is used instead of $id, Get the ID
		if(!$id) return $r; 											// If no ID set, don't continue
		if(empty($include_included[$id])) $include_included[$id] = ''; 						// Shutting up php Notices
		if($include_included[$id] === true) return $r; 								// If page is already included, don't include it again
		$include_included[$id] = true; 										// Mark the page as included
		$op = clone $wp_query; 											// Back up the $wp_query object

		/* Work the Magic */

		query_posts(array('page_id' => $id)); 									// Generate a new $wp_query object for the page to include
		apply_filters('the_posts', array()); 									// TODO: Find out if this does anything, remove it if it doesn't
		the_post(); 												// Load the Post into $post
		$c = get_the_content(); 										// Get the Content
		$c = strtolower($recursion) == "strict" ? preg_replace( "/\[include[^\]]*\]/im", "", $c ) : $c; 	// Apply Recursion Attribute to Content
		$r = 	( $hr ? "<hr />" : "" ) . 									// Show hr
			( $show_title ? 										// If Show Title attr set
				( $title_wrapper_elem ? 								// If Wrap Title attr set
					"<{$title_wrapper_elem} class='{$title_wrapper_class}' >". 			// Open Wrap
					get_the_title(). 								// Title
					"</{$title_wrapper_elem}>" 							// Close Wrap
					:
					get_the_title() 								// Unwrapped Title
				)
				:
				"" 											// Don't show title
			) .
			"<a class='anchor' name='{$post->post_name}'></a>" . 						// Declare Anchor Tag
			apply_filters('the_content',$c); 								// Include the content

		/* Cleanup */

		$wp_query = clone $op; 											// Reset the $wp_query Object
		setup_postdata($post); 											// Reset the $post object
		unset($include_included[$id]); 										// Remove the Included post from the List of Includes
		return $r; 												// Return the completed content
	}
?>