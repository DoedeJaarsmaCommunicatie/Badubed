<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Badubed
 */
$context = Timber::get_context();
$post = new \Timber\Post();
$context['post'] = $post;
Timber::render( [
	'templates/page' . $post->post_name . '.twig',
	'templates/page.twig',
	'templates/index.twig',
], $context );
