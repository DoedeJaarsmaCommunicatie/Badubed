<?php
/**
 * Created by PhpStorm.
 * User: Mitch
 * Date: 15-11-2018
 * Time: 20:57
 */

add_filter('footer_class', function (array $classes) {
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
	
	return array_unique($classes);
});