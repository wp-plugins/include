<?php
/**
 * Plugin Name: Include
 * Plugin URI: http://wordpress.org/plugins/include/
 * Description: Include a page, post, activity, or other query-object into another.
 * Version: 2.5
 * Author: mflynn, cngann, Clear_Code, bmcswee
 * Author URI: http://clearcode.info
 * License: GPL2
 */

	/**
	 * Current Included Posts
	 *
	 * @author Mike Flynn
	 * @since 1.0
	 * @var array An array of posts currently included to prevent infinate loops
	 * @global array $include_included
	 */
	$include_included = array();

	/**
	 * Default Include Shortcode Attributes
	 *
	 * @author Mike Flynn
	 * @since 1.7
	 * @var array An array containing the default attributes for the Include Shortcode
	 * @global array $include_atts
	 */
	$include_atts = array(
		'id' 		=> false,									// (required) The Page/Post Id to Include.  Default: none. Not required if slug is set.
		'slug' 		=> false,									// (optional) The Page/Post Slug to Include. Not recomended as slugs can change.
		'title' 	=> 'h2',									// (optional) Title Wrapper Element. Default: h2.
		'title_class' 	=> '',										// (optional) Class of Title Wrapper Element. Default: none.
		'recursion' 	=> 'weak',									// (optional) Recursion Setting.  Options: strong or weak. Default: weak
		'hr' 		=> '',    									// (optional) Display a hr element before the include.  Set to "" to not show the hr.
                'wrap' 		=> 'div',                                               			// (optional) element to wrap the entire include in.
                'wrap_class' 	=> 'included'    								// (optional) class assigned to the wrap. Default: included.
        );
	
	/**
	 * Default Include Shortcode Attributes
	 *
	 * @since 2.0
	 * @author Brendan McSweeney, Mike Flynn
	 * @var array An array containing the tips for the options panel
	 * @global array $include_option_tips
	 */
	$include_option_tips = array(
		'title'		=> 'The type of element to wrap the title with.',
		'title_class' 	=> 'A class to assign to the title wrap.',
		'recursion' 	=> 'Strict will not run the shortcode on included child pages.',
		'hr' 		=> 'Set to anything other than blank to insert a horizontal rule before included content.',
		'wrap'		=> 'Element to wrap included content with.',
		'wrap_class'	=> 'A class to assign to the wrap.'
        );
	
	add_shortcode('include', 'include_shortcode');
        add_shortcode('include_children', 'include_children_shortcode');
	require_once('functions.php');
        require_once('panel.php');

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
		global $include_included, $wpdb, $post, $wp_query; 							// Get Globals
		$r = ""; 												// Set the return variable
		$include_included[get_the_ID()] = true; 								// Put the current page ID into the list of included pages
		$include_atts = include_get_options();
		extract( shortcode_atts( $include_atts, $atts, 'include' ) ); 						// Get the attributes
		
		$title = !empty($title_wrapper_elem) ? $title_wrapper_elem : $title;
		$title_class = !empty($title_wrapper_class) ? $title_wrapper_class : $title_class;
		if($id &&  ! id_exists( $id )) return $r; 								// If ID is incorrect, don't continue
		else if(!$id && !$slug) return $r; 									// If no viable include parameters, don't continue
		else if($slug) $id = $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name = '{$slug}'");	// If $slug is used instead of $id, Get the ID
		if(!$id) return $r; 											// If no ID set, don't continue
		if(empty($include_included[$id])) $include_included[$id] = ''; 						// Shutting up php Notices
		if($include_included[$id] === true) return $r; 								// If page is already included, don't include it again
		$include_included[$id] = true; 										// Mark the page as included
		$op = clone $wp_query; 											// Back up the $wp_query object
		query_posts(array('page_id' => $id));
		the_post();
		$c = get_the_content();
		$c = strtolower($recursion) == "strict" ? preg_replace( "/\[include[^\]]*\]/im", "", $c ) : $c;
		$c = "<a class='anchor' name='{$post->post_name}'></a>" . apply_filters('the_content',$c);
		$c = ( $hr ? "<hr />" : "" ) . ( $title ? "<{$title} class='{$title_class}' >".get_the_title()."</{$title}>":"") . $c;
		$r = $wrap ? "<{$wrap} class='{$wrap_class}' >{$c}</{$wrap}>" : $c;
		$wp_query = clone $op; 											// Reset the $wp_query Object
		setup_postdata($post); 											// Reset the $post object
		unset($include_included[$id]); 										// Remove the Included post from the List of Includes
		return $r;												// Return the completed content
	}

	/**
	 * Include Children Shortcode
	 *
	 * Creates and returns the "include_children" shortcode
	 *
	 * @since 2.0b
	 * @author Brendan McSweeney
	 */
	function include_children_shortcode ($atts, $content){
		global $include_included, $wpdb, $post, $wp_query;		 					// Get Globals
		$r = ""; 												// Set the return variable
		$include_atts = include_get_options();
		$include_children_atts = shortcode_atts( $include_atts, $atts, 'include_children' );
		extract( $include_children_atts ); 									// Get the attributes
		if($id &&  ! id_exists( $id )) return $r; 								// If ID is incorrect, don't continue
		else if($slug) $id = $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name = '{$slug}'");	// If $slug is used instead of $id, Get the ID
		if(!$id) $id = get_the_ID(); 										// If no ID set, Get the ID of the current page
		if(!$id) return $r;
		if(empty($include_included[$id])) $include_included[$id] = ''; 						// Shutting up php Notices
		if($include_included[$id] === true) return $r; 								// If page is already included, don't include it again
		$include_included[$id] = true; 										// Mark the page as included
                if($wrap == true) $wrap = "div";
                $attributes_string = "";
		unset($include_children_atts['id'], $include_children_atts['slug']);
                foreach ( $include_children_atts as $attribute => $value ) $attributes_string .= $attribute . '="' . $value . '" ';
                $page_children = get_children( array( 'post_parent' => $id, 'post_type'   => 'page', 'numberposts' => -1, 'post_status' => 'publish' ) );
                foreach( (array) $page_children as $page_child_id => $page_child ) $r .= do_shortcode("[include id=\"{$page_child_id}\" {$attributes_string}]");
                return $r;
	}