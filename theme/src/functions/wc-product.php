<?php

// ==============================================
// Changes product page behavior
// ==============================================

// Remove outputs notices from default hook
function remove_product_hookes()
{
  // on sumary
  remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
  remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
  remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
  remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
}

// Get template tab datasheet
function get_product_tab_datasheet()
{
  get_component( '_datasheet' );
}

// Add tab datasheet
function add_product_tab_datasheet( $tabs )
{
  $tabs[ 'datasheet' ] = array( 
    'title' => 'Detalhes',
    'priority' => 25,  
    'callback' => 'get_product_tab_datasheet'
  ); 

  return $tabs; 
}

// Change tabs title
function rename_tabs_title( $tabs )
{
  $tabs[ 'reviews' ][ 'title' ] = __( 'Reviews', 'woocommerce' );
  return $tabs;
}

// Remove tabs
function remove_product_tabs( $tabs )
{
  unset( $tabs[ 'additional_information' ] );
  return $tabs;
}

// Remove GDPR policy
function remove_gdpr_policy()
{
  remove_action( 'set_comment_cookies', 'wp_set_comment_cookies' );
}

// Change in stock message
function change_in_stock_message( $availability, $_product )
{
  if ( $_product->is_in_stock() ) $availability[ 'availability' ] = 'Pronta entrega';  
	return $availability;
}

// Set products card label
function get_card_product_label()
{
  $text = get_label_text();

  if ( $text == false )
   return;

  set_query_var( 'label_text', $text );
  get_component( '_label' );
}


// filters
add_filter( 'woocommerce_get_availability', 'change_in_stock_message', 1, 2);
add_filter( 'woocommerce_product_tabs', 'add_product_tab_datasheet', 97);
add_filter( 'woocommerce_product_tabs', 'rename_tabs_title', 98);
add_filter( 'woocommerce_product_tabs', 'remove_product_tabs', 99 );

// actions
add_action( 'init', 'remove_product_hookes' );
add_action( 'init', 'remove_gdpr_policy' );
add_action( 'card_product_label', 'get_card_product_label' );
