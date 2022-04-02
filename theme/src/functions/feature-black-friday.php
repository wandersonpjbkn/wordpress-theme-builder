<?php

// ==============================================
// Holds Black Friday implemention
// ==============================================

defined( 'ABSPATH' ) || exit;

// check if mass discount is up
function is_black_friday_up()
{
  $page_ID = get_page_id_by_slug( 'home' );
  $start = get_field( 'black_friday_start_date', $page_ID );
  $end = get_field( 'black_friday_end_date', $page_ID );

  $today = wp_date( 'Y-m-d H:i:s' );
  
  if ( empty( $start ) || empty( $end ) )
    return false;

  if ( $start <= $today && $today <= $end )
    return true;

  return false;
}

function get_card_product_label_black_friday()
{
  $text = get_label_text();
  $black_friday_label = $text === false ? 'Oferta' : $text;

  set_query_var( 'label_text', $black_friday_label );
  set_query_var( 'label_theme', 'is__theme--dark' );
  get_component( '_label' );
}

function set_black_friday_body_class ( $classes )
{ 
  $classes[] = 'bf';
  return $classes;     
}

if ( is_black_friday_up() ) {
  remove_action( 'card_product_label', 'get_card_product_label' );
  add_action( 'card_product_label', 'get_card_product_label_black_friday' );
  add_filter( 'body_class', 'set_black_friday_body_class' );
}
