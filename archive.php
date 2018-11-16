<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Badubed
 */

$templates = [
	'templates/archive.twig',
];

$context = Timber::get_context();
$posts = new \Timber\PostQuery();
$context['posts'] = $posts;

if ( is_category() ) {
	$context[ 'title' ] = single_cat_title( '', false );
	array_unshift( $templates, 'templates/archive-' . get_query_var( 'cat' ) . '.twig' );
}
if ( is_post_type_archive() ) {
	$context['title'] = post_type_archive_title( '', false );
	array_unshift( $templates, 'templates/archive-' . get_post_type() . '.twig' );
}

Timber::render( $templates, $context );
