<?php

// ==============================================
// Changes cart page behavior
// ==============================================

// remove the warnings of cart about reposition
function remove_cross_selling_from_default_hook()
{
  remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 10 );
}

// remove variation metadata from product title
function remove_variation_metadata_product_title()
{
  add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_false' );
  add_filter( 'woocommerce_is_attribute_in_product_name', '__return_false' );
}

// change shipping label response
function replace_shipping_label_response( $label )
{
	$estimateStart = '(';
	$estimateEnd = '):'; 

	if ( strpos ($label, $estimateStart ) !== false && strpos( $label, $estimateEnd ) !== false) {
		$label = '<span><span>' . $label;
		$label = str_replace( $estimateStart, '</span><span>', $label );
		$label = str_replace( $estimateEnd, '</span></span>', $label );
	}

	return $label;
}

// remove city and country from shipping calc
function remove_shipping_city_state_country()
{
  add_filter( 'woocommerce_shipping_calculator_enable_city', '__return_false', 10 );
  add_filter( 'woocommerce_shipping_calculator_enable_state', '__return_false', 10 );
  add_filter( 'woocommerce_shipping_calculator_enable_country', '__return_false', 10 );
}


// filters
add_filter( 'woocommerce_cart_shipping_method_full_label', 'replace_shipping_label_response', 10, 2 );
add_filter( 'wc_add_to_cart_message_html', '__return_null' );

// actions
add_action( 'init', 'remove_variation_metadata_product_title' );
add_action( 'init', 'remove_cross_selling_from_default_hook' );
add_action( 'init', 'remove_shipping_city_state_country' );
