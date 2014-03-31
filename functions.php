<?php
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
?>