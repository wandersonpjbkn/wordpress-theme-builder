<?php

// ==============================================
// Holds Admin Dashboard changes
// ==============================================

defined( 'ABSPATH' ) || exit;

// add a custom filter on WooCommerce Admin Dashboard : filter featured products
function filter_products_by_featured_status()
{
  global $typenow;
  
  if ( $typenow != 'product' )
    return;

  $is_all = true;
  $is_featured = false;
  $is_normal = false;

  if ( isset( $_GET[ 'featured_status' ] ) ) {
    $is_all = $_GET[ 'featured_status' ] == '';
    $is_featured = $_GET[ 'featured_status' ] == 'featured';
    $is_normal = $_GET[ 'featured_status' ] == 'normal';
  }

  $name = 'featured_status';

  $options = array(
    '0' => array(
      'value' => '',
      'state' => $is_all,
      'descr' => 'Todos os destacados'
    ),
    '1' => array(
      'value' => 'featured',
      'state' => $is_featured,
      'descr' => 'Destacado'
    ),
    '2' => array(
      'value' => 'normal',
      'state' => $is_normal,
      'descr' => 'Não destacado'
    )
  );

  set_query_var( 'custom_filter_name', $name );
  set_query_var( 'custom_filter_options', $options );
  
  get_component( '_dashboard-custom-filter' );
}

// filter featured products : handle selected options
function featured_products_admin_filter_query( $query )
{
  global $typenow;

  if ( $typenow != 'product' )
    return;

  // Subtypes
  if ( ! empty( $_GET[ 'featured_status' ] ) ) {
    $array_query = array(
      'taxonomy' => 'product_visibility',
      'field'    => 'slug',
      'terms'    => 'featured'
    );
    
    if ( $_GET[ 'featured_status' ] == 'normal' )
      $array_query['operator'] = 'NOT IN';

    $query->query_vars['tax_query'][] = $array_query;
  }
}

add_action( 'restrict_manage_posts', 'filter_products_by_featured_status' );

add_filter( 'parse_query', 'featured_products_admin_filter_query' );
