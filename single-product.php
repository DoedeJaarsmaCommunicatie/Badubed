<?php
/**
 * Created by PhpStorm.
 * User: mitch
 * Date: 2018-11-16
 * Time: 10:06
 */

$context['post']    = Timber::get_post();
$product            = wc_get_product( $context['post']->ID );
$context['product'] = $product;

// Get related products
$related_limit               =  wc_get_loop_prop( 'columns' );
$related_ids                 =  wc_get_related_products( $context['post']->id, $related_limit );
$context['related_products'] =  Timber::get_posts( $related_ids );

// Restore the context and loop back to the main query loop.
wp_reset_postdata();

Timber::render( 'templates/woocommerce/single-product.twig', $context );
