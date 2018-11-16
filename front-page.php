<?php
/**
 * Created by PhpStorm.
 * User: Mitch
 * Date: 15-11-2018
 * Time: 20:23
 */

$context = Timber::get_context();
$context['post'] = new \Timber\Post();
Timber::render( 'templates/front-page.twig', $context );
