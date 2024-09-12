<?php
/**
 * Fooz Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Fooz_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Autoloader
 */
require_once get_stylesheet_directory() . '/autoloader.php';

// Initialize CustomPostTypes.
( new FoozChild\CustomPostTypes() )->register();

// Initialize CustomShortcodes.
( new FoozChild\CustomShortcodes() )->register();

// Initialize CustomAjaxRequests.
( new FoozChild\CustomAjaxRequests() )->register();

// Initialize CustomActions.
( new FoozChild\CustomActions() )->register();

/**
 * Enqueue parent style.
 *
 * @return void
 */
function fooz_child_enqueue_styles(): void {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'fooz_child_enqueue_styles' );

/**
 * Enqueue custom JavaScript and localize AJAX data.
 *
 * @return void
 */
function fooz_child_enqueue_scripts(): void {
	wp_enqueue_script( 'fooz-child-script', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), '1.0.0', true );

	// Localize the script with new data.
	wp_localize_script(
		'fooz-child-script',
		'foozAjax',
		array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'get_books_nonce' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'fooz_child_enqueue_scripts' );

/**
 * Add theme support for various WordPress features.
 *
 * @return void
 */
function fooz_child_theme_support(): void {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'custom-logo' );
}
add_action( 'after_setup_theme', 'fooz_child_theme_support' );

/**
 * Check if parent theme exists and switch to default theme if not.
 *
 * @return void
 */
function check_parent_theme_exists(): void {
	$theme = wp_get_theme();
	if ( $theme->parent() ) {
		$parent_theme = wp_get_theme( $theme->parent()->template );
		if ( ! $parent_theme->exists() ) {
			add_action( 'admin_notices', 'parent_theme_missing_notice' );
			switch_theme( WP_DEFAULT_THEME );
		}
	}
}
add_action( 'after_setup_theme', 'check_parent_theme_exists' );

/**
 * Display admin notice for missing parent theme.
 *
 * @return void
 */
function parent_theme_missing_notice(): void {
	echo '<div class="error"><p>Parent theme does not exist. Switching to default theme.</p></div>';
}

