<?php
/**
 * Created by PhpStorm.
 * User: Mitch
 * Date: 15-11-2018
 * Time: 20:57
 */

add_filter('header_class', function (array $classes) {
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

add_filter( 'timber/context', function ( $context ) {
	// So here you are adding data to Timber's context object, i.e...
	$context['foo'] = 'I am some other typical value set in your functions.php file, unrelated to the menu';
	
	// Now, in similar fashion, you add a Timber Menu and send it along to the context.
	$context['menu'] = new \Timber\Menu( 'primary-menu' );
	
	return $context;
} );
