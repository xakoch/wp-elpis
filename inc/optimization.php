<?php
	// WordPress optimization

	/**
	 * delete link on comment's
	 *
	**/

	function plc_comment_post( $incoming_comment ) {
		$incoming_comment['comment_content'] = htmlspecialchars($incoming_comment['comment_content']);
		$incoming_comment['comment_content'] = str_replace( "'", '&apos;', $incoming_comment['comment_content'] );
		return( $incoming_comment );
	}

	add_filter('preprocess_comment', 'plc_comment_post', '', 1);

	function plc_comment_display( $comment_to_display ) {
		$comment_to_display = str_replace( '&apos;', "'", $comment_to_display );
		return $comment_to_display;
	}

	add_filter('comment_text', 'plc_comment_display', '', 1);
	add_filter('comment_text_rss', 'plc_comment_display', '', 1);
	add_filter('comment_excerpt', 'plc_comment_display', '', 1);

	/**
	 * Delete WordPress smile's
	 *
	**/

	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	/**
	 * Delete WordPress feed
	 *
	**/

	function fb_disable_feed() {
		wp_redirect(get_option('siteurl'));
	}

	add_action('do_feed', 'fb_disable_feed', 1);
	add_action('do_feed_rdf', 'fb_disable_feed', 1);
	add_action('do_feed_rss', 'fb_disable_feed', 1);
	add_action('do_feed_rss2', 'fb_disable_feed', 1);
	add_action('do_feed_atom', 'fb_disable_feed', 1);

	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action('wp_head', 'wp_generator');

	/**
	 * Delete style on site header
	 *
	**/

	function theme_remove_recent_comments_style() {
		global $wp_widget_factory;
		remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
	}
	add_action( 'widgets_init', 'theme_remove_recent_comments_style' );