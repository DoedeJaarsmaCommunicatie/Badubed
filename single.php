<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Badubed
 */

$templates          = [ 'templates/search.twig', 'templates/index.twig' ];

$context            = \Timber\Timber::get_context();
$context['post']    = new \Timber\Post();

\Timber\Timber::render( $templates, $context );