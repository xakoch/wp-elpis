<?php

/**
 * Enqueue scripts and styles.
 */
if( ! is_admin() )
	add_action( 'wp_enqueue_scripts', 'stm_load_theme_ss' );

function stm_load_theme_ss() {
	wp_enqueue_style('style', get_stylesheet_directory_uri() . '/assets/css/style.min.css', NULL, 1, 'all' );
	// wp_deregister_script('jquery');
	wp_enqueue_script('libs', get_template_directory_uri() . '/assets/js/lib.js', 'app', 1, TRUE );
	wp_enqueue_script('app', get_template_directory_uri() . '/assets/js/app.js', 'app', 1, TRUE );
}