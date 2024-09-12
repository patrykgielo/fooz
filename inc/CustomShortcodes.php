<?php

namespace FoozChild;

/**
 * Custom shortcodes for the Fooz child theme.
 */
class CustomShortcodes {

	/**
	 * Register shortcodes.
	 *
	 * @return void
	 */
	public function register() {
		add_shortcode( 'books', array( $this, 'books_shortcode' ) );
		add_shortcode( 'genre_books', array( $this, 'genre_books_shortcode' ) );
	}

	/**
	 * Shortcode to display the title of the most recent book.
	 *
	 * @return string The title of the most recent book.
	 */
	public function books_shortcode() {
		$args = array(
			'post_type'      => 'book',
			'posts_per_page' => 1,
			'orderby'        => 'date',
			'order'          => 'DESC',
		);

		$recent_book = new \WP_Query( $args );

		if ( $recent_book->have_posts() ) {
			$recent_book->the_post();
			$title = get_the_title();
			wp_reset_postdata();
			return $title;
		}

		return 'No books found';
	}

	/**
	 * Shortcode to display a list of 5 books from a given genre.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string HTML list of books.
	 */
	public function genre_books_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'genre_id' => 0,
			),
			$atts,
			'genre_books'
		);

		$genre_id = intval( $atts['genre_id'] );

		if ( $genre_id <= 0 ) {
			return 'Invalid genre ID';
		}

		// Check if the genre exists
		$genre = get_term( $genre_id, 'genre' );
		if ( ! $genre || is_wp_error( $genre ) ) {
			return 'Genre not found';
		}

		$args = array(
			'post_type'      => 'book',
			'posts_per_page' => 5,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'genre',
					'field'    => 'term_id',
					'terms'    => $genre_id,
				),
			),
		);

		$books_query = new \WP_Query( $args );

		if ( $books_query->have_posts() ) {
			$output = '<ul class="genre-books-list">';
			while ( $books_query->have_posts() ) {
				$books_query->the_post();
				$output .= '<li><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></li>';
			}
			$output .= '</ul>';
			wp_reset_postdata();
			return $output;
		}

		return 'No books found in this genre';
	}
}