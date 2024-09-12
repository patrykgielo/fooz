<?php
/**
 * Custom AJAX requests handler.
 *
 * @package FoozChild
 */

namespace FoozChild;

/**
 * Class CustomAjaxRequests
 */
class CustomAjaxRequests {

	/**
	 * Register AJAX actions.
	 *
	 * @return void
	 */
	public function register(): void {
		add_action( 'wp_ajax_get_books', array( $this, 'get_books' ) );
		add_action( 'wp_ajax_nopriv_get_books', array( $this, 'get_books' ) );
	}

	/**
	 * AJAX callback to get books.
	 *
	 * @return void
	 */
	public function get_books(): void {
		// Check nonce for security.
		check_ajax_referer( 'get_books_nonce', 'nonce' );

		$args = array(
			'post_type'      => 'book',
			'posts_per_page' => 20,
			'orderby'        => 'date',
			'order'          => 'DESC',
		);

		$query = new \WP_Query( $args );
		$books = array();

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$genres     = wp_get_post_terms( get_the_ID(), 'genre' );
				$genre_data = array_map(
					function( $term ) {
						return array(
							'name' => sanitize_text_field( $term->name ),
							'link' => esc_url( get_term_link( $term ) ),
						);
					},
					$genres
				);

				$books[] = array(
					'name'    => sanitize_text_field( get_the_title() ),
					'date'    => get_the_date( 'Y-m-d' ),
					'genres'  => $genre_data,
					'excerpt' => wp_kses_post( get_the_excerpt() ),
					'link'    => esc_url( get_permalink() ),
				);
			}
			wp_reset_postdata();
		}

		wp_send_json_success( $books );
	}
}
