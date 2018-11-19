<?php

function badubed_set_product( $post ) {
	global $product;
	
	if ( is_woocommerce() ) {
		$product = wc_get_product( $post->ID );
	}
}