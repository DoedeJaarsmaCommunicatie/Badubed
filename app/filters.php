<?php
/**
 * Created by PhpStorm.
 * User: mitch
 * Date: 2018-10-24
 * Time: 10:11
 */

/**
 * Extra helper files
 */
array_map(function ($file) {
	require_once get_template_directory() . "/app/filters/{$file}.php";
}, [ 'header' ]);

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
	/** Add page slug if it doesn't exist */
	if ( is_single() || ( is_page() && ! is_front_page() ) ) {
		if (!in_array(basename(get_permalink()), $classes)) {
			$classes[] = basename(get_permalink());
		}
	}
	/** add hfeed if not single */
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	
	/** Add class if sidebar is active */
	if (display_sidebar()) {
		$classes[] = 'sidebar-primary';
	}
	
	/** Clean up class names for custom templates */
	$classes = array_map(function ($class) {
		return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
	}, $classes);
	return array_filter($classes);
});

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function badubed_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'badubed_pingback_header' );