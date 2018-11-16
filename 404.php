<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Badubed
 */



$context = Timber::get_context();
$context['post'] = new \Timber\Post();

$categories_args = [ 'echo' => false, 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10, ];
$context['categories'] = wp_list_categories( $categories_args );


Timber::render( [
	'templates/404.twig',
], $context );