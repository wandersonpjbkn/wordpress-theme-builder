<?php

// ==============================================
// Holds Mass Discount implemention
// ==============================================

defined( 'ABSPATH' ) || exit;

function_exists( 'get_field' ) || exit;

// Everytime a customer visite the website, it will check if mass discount is up
// if so, this file will change all displayed prices to fit the discount configs

// check if mass discount is up
function is_mass_discount_up()
{
  $page_ID = get_page_id_by_slug( 'home' );
  $start = get_field( 'mass_discount_start', $page_ID );
  $end = get_field( 'mass_discount_end', $page_ID );

  $today = wp_date( 'Y-m-d H:i:s' );

  if ( empty( $start ) || empty( $end ) )
    return false;

  if ( $start <= $today && $today <= $end )
    return true;

  return false;
}

// change sale price for single product or single variation
function custom_dynamic_sale_price( $sale_price, $product )
{
  // returns if product has manual discount
  if ( ! empty( $sale_price ) || $sale_price != 0 )
    return $sale_price;

  // otherwise, set discount
  $percent = (int)get_field( 'mass_discount_percent', get_page_id_by_slug( 'home' ) );
  $rate = (100 - $percent) / 100;

  return ( $product->get_regular_price() * $rate );
}

// change sale price for variation product
function custom_dynamic_variation_sale_price( $price, $product, $min_or_max, $include_taxes )
{
  $percent = (int)get_field( 'mass_discount_percent', get_page_id_by_slug( 'home' ) );
  $rate = (100 - $percent) / 100;

  $mass_discount_price = ( $price * $rate );

  // product don't have sale price
  // return mass discount price
  if ( ! $product->is_on_sale() )
    return $mass_discount_price;

  // at least one variation have sale price
  $prices = $product->get_variation_prices();
  foreach ( $prices[ 'regular_price' ] as $key => $value ) {
    if ( $prices[ 'sale_price' ][ $key ] == $value ) {
      // return min or max
      if ( 'min' == $min_or_max ) {
        $min_sale = min( $prices[ 'sale_price' ] );
        $min_regular = min( $prices[ 'regular_price' ] ) * $rate;

        return min( $min_sale, $min_regular );
      }

      // max
      return $price;
    }
  }
  
  // all variations have sale price
  // return price
  return $price;
}

// return html price
function custom_dynamic_sale_price_html( $price_html, $product )
{
  // return if product is variable
  if ( $product->is_type( 'variable' ) ) {
    $min = $product->get_variation_sale_price( 'min' );
    $max = $product->get_variation_regular_price( 'max' );

    return ( wc_price( $min ) .' - '. wc_price( $max ) );
  }

  $price_sale = $product->get_sale_price();
  $price_regular = $product->get_regular_price();

  // display old and new price in HTML format
  $price_html = wc_format_sale_price(
    wc_get_price_to_display( $product, array( 'price' => $price_regular ) ),
    wc_get_price_to_display( $product, array( 'price' => $price_sale ) )
  ) . $product->get_price_suffix();

  return $price_html;
}

// set product price on cart and checkout page as sale price
function custom_dynamic_calculate_totals( $cart )
{
  if ( is_admin() && ! defined( 'DOING_AJAX ') )
    return;

  // Iterate through each cart item
  foreach ( $cart->get_cart() as $cart_item ) {
    // get sale price
    $price = $cart_item[ 'data' ]->get_sale_price();
    
    // set price as sale price right on cart
    $cart_item[ 'data' ]->set_price( $price );
  }
}

// activate
if ( is_mass_discount_up() )
{  
  // sale price
	add_filter( 'woocommerce_product_get_sale_price', 'custom_dynamic_sale_price', 10, 2 );
  add_filter( 'woocommerce_product_variation_get_sale_price', 'custom_dynamic_sale_price', 10, 2 );
  add_filter( 'woocommerce_get_variation_sale_price', 'custom_dynamic_variation_sale_price', 20, 4 );
  
  // displayed HTML
  add_filter( 'woocommerce_get_price_html', 'custom_dynamic_sale_price_html', 20, 2 );
  
  // cart & checkout
  add_action( 'woocommerce_before_calculate_totals', 'custom_dynamic_calculate_totals', 10, 1 );
}
