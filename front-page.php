<?php
/**
 * Created by PhpStorm.
 * User: Mitch
 * Date: 15-11-2018
 * Time: 20:23
 */

get_header();

$context = Timber::get_context();
$context['foo'] = 'bar';
$context['post'] = new \Timber\Post();
Timber::render( 'templates/front-page.twig', $context );

get_footer();