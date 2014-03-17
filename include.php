<?php
/**
 * Plugin Name: Include
 * Plugin URI: http://wordpress.org/plugins/include/
 * Description: Include a page, post, activity, or other query-object into another.
 * Version: 1.6
 * Author: mflynn, cngann
 * Author URI: http://cngann.com
 * License: GPL2
 */
	function id_exists($id){  global $wpdb; return $wpdb->get_var("SELECT count(*) FROM {$wpdb->posts} WHERE ID = '{$id}'") ? true : false; }

	$included = array(  );

	add_shortcode('include', 'include_shortcode');

	function include_shortcode ($atts, $content){
		global $included,$wpdb,$post;
		$included[get_the_ID()] = true;
		extract( shortcode_atts( array( 'id' => false, 'slug' => false, 'show_title' => false, 'title_wrapper_elem' => 'h2', 'title_wrapper_class' => '', 'recursion' => 'weak', 'hr' => 'n' ), $atts, 'include' ) ); $st = $show_title; $twe = $title_wrapper_elem; $twc = $title_wrapper_class; $st = $show_title; $re = $recursion; $hr = strtolower($hr) == 'y';
		if($id &&  ! id_exists( $id )) return "";  else if(!$id && !$slug) return ""; else if($slug) $id = $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name = '{$slug}'");
		if(!$id) return ""; if(empty($included[$id])) $included[$id] = ''; if($included[$id] === true) return ""; $included[$id] = true;
		$op = clone $post; $post = get_post($id); setup_postdata($post); $c = $post->post_content; $t = $post->post_title;
		$r = ($hr ? "<hr />" : "") . ($st ? ( $twe ? "<" . $twe . ($twc ? " class=\"" . $twc . "\" " : "") . ">" . $t . "</".$twe.">" : $t ) : "") ."<a class='anchor' name='".$post->post_name."'></a>". do_shortcode( wpautop( (strtolower($re) == "strict" ? preg_replace("/\[include[^\]]*\]/im","",$c) : $c), true ) );
		$post = clone $op; setup_postdata($post); unset($included[$id]);
		return $r;
	}
?>