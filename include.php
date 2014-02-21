<?php
/**
 * Plugin Name: Include
 * Plugin URI:http://www.cngann.com/
 * Description: Include a page, post, activity, or other query-object into another.
 * Version: 1.1.2
 * Author: mflynn, cngann
 * Author URI: http://cngann.com
 * License: GPL2
 */
	function id_exists($id){ return $wpdb->get_var("SELECT count(*) FROM {$wpdb->posts} WHERE ID = '{$id}'") ? true : false; }

	$included = array();

	add_shortcode('include', function($atts){
		global $included,$wpdb,$post;
		$included[get_the_ID()] = true;
		extract( shortcode_atts( array( 'id' => false, 'slug' => false, 'show_title' => false, 'title_wrapper_elem' => 'h2', 'title_wrapper_class' => '', 'recursion' => 'weak' ), $atts, 'include' ) );
		$st = $show_title; $twe = $title_wrapper_elem; $twc = $title_wrapper_class; $st = $show_title; $re = $recursion;
		if($id) { if( ! id_exists( $id )) return ""; }
		else if(!$id && !$slug) return "";
		else if($slug) $id = $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name = '{$slug}'");
		if(!$id) return "";
		if(empty($included[$id])) $included[$id] = '';
		if($included[$id] === true) return "";
		$included[$id] = true;
		$op = clone $post;
		$post = get_post($id);
		setup_postdata($post);
		$c = $post->post_content;
		$t = $post->post_title;
		$r = ($st ? ( $twe ? "<" . $twe . ($twc ? " class=\"" . $twc . "\" " : "") . ">" . $t . "</".$twe.">" : $t ) : "") . do_shortcode( wpautop( (strtolower($re) == "strict" ? preg_replace("/\[include[^\]]*\]/im","",$c) : $c), true ) );
		$post = clone $op;
		setup_postdata($post);
		$included[$id] = false;
		return $r;
	});
?>
