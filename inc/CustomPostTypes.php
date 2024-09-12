<?php

/**
 * Custom Post Types and Taxonomies registration.
 *
 * @package FoozChild
 */

namespace FoozChild;

/**
 * CustomPostTypes class
 */
class CustomPostTypes {

	/**
	 * Register custom post types and taxonomies
	 *
	 * @return void
	 */
	public function register(): void {
		add_action( 'init', array( $this, 'register_post_types' ) );
	}

	/**
	 * Register custom post types
	 *
	 * @return void
	 */
	public function register_post_types(): void {
		$this->register_books_post_type();
		$this->register_genre_taxonomy();
	}

	/**
	 * Register books post type
	 *
	 * @return void
	 */
	private function register_books_post_type(): void {
		$labels = array(
			'name'               => __( 'Books', 'fooz-child' ),
			'singular_name'      => __( 'Book', 'fooz-child' ),
			'menu_name'          => __( 'Books', 'fooz-child' ),
			'name_admin_bar'     => __( 'Book', 'fooz-child' ),
			'add_new'            => __( 'Add New', 'fooz-child' ),
			'add_new_item'       => __( 'Add New Book', 'fooz-child' ),
			'new_item'           => __( 'New Book', 'fooz-child' ),
			'edit_item'          => __( 'Edit Book', 'fooz-child' ),
			'view_item'          => __( 'View Book', 'fooz-child' ),
			'all_items'          => __( 'All Books', 'fooz-child' ),
			'search_items'       => __( 'Search Books', 'fooz-child' ),
			'parent_item_colon'  => __( 'Parent Books:', 'fooz-child' ),
			'not_found'          => __( 'No books found.', 'fooz-child' ),
			'not_found_in_trash' => __( 'No books found in Trash.', 'fooz-child' )
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'library' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 30,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
		);

		register_post_type( 'book', $args );
	}

	/**
	 * Register genre taxonomy
	 *
	 * @return void
	 */
	private function register_genre_taxonomy(): void {
		$labels = array(
			'name'              => __( 'Genres', 'fooz-child' ),
			'singular_name'     => __( 'Genre', 'fooz-child' ),
			'search_items'      => __( 'Search Genres', 'fooz-child' ),
			'all_items'         => __( 'All Genres', 'fooz-child' ),
			'parent_item'       => __( 'Parent Genre', 'fooz-child' ),
			'parent_item_colon' => __( 'Parent Genre:', 'fooz-child' ),
			'edit_item'         => __( 'Edit Genre', 'fooz-child' ),
			'update_item'       => __( 'Update Genre', 'fooz-child' ),
			'add_new_item'      => __( 'Add New Genre', 'fooz-child' ),
			'new_item_name'     => __( 'New Genre Name', 'fooz-child' ),
			'menu_name'         => __( 'Genre', 'fooz-child' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'book-genre' ),
		);

		register_taxonomy( 'genre', array( 'book' ), $args );
	}
}