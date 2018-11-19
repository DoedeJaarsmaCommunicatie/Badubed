<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Badubed
 */

$templates        = [ 'templates/search.twig', 'templates/archive.twig', 'templates/index.twig' ];
$context          = Timber::get_context();
$context['title'] = 'Search results for: ' . get_search_query();
$context['posts'] = new Timber\PostQuery();

Timber::render( $templates, $context );