<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Badubed
 */

$templates          = [
	'templates/single-' .$post->post_type . '-' . $post->slug . '.twig',
	'templates/single-' .$post->post_type . '.twig',
	'templates/single.twig',
	'templates/index.twig'
];

$context            = \Timber\Timber::get_context();
$context['post']    = new \Timber\Post();

\Timber\Timber::render( $templates, $context );