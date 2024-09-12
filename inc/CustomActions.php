<?php

namespace FoozChild;

/**
 * Class CustomActions
 *
 * Handles custom actions for the Fooz Child theme.
 */
class CustomActions {

	/**
	 * Register actions.
	 *
	 * @return void
	 */
	public function register() {
		add_action( 'pre_get_posts', array( $this, 'custom_pre_get_posts' ) );
	}

	/**
	 * Modifies the main query for the genre taxonomy archive.
	 *
	 * @param \WP_Query $query The WP_Query instance (passed by reference).
	 * @return void
	 */
	public function custom_pre_get_posts( $query ) {
		if ( ! is_admin() && $query->is_main_query() && is_tax( 'genre' ) ) {
			$query->set( 'posts_per_page', 5 );
			$query->set( 'post_type', 'book' );
		}
	}
}
