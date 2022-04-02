<?php

// ==============================================
// Template Part: Produts Related
// ==============================================

defined( 'ABSPATH' ) || exit;

global $product;

$post_array = wc_get_related_products( $product->get_id() );

if ( empty( $post_array ) )
  return get_template_parts( 'products-featured' );

$carousel_metadata = array(
  0 => array( 'key' => 'responsive', 'value' => 'yes' )
);

set_query_var( 'carousel_metadata', $carousel_metadata );
set_query_var( 'carousel_title', 'Relacionados' );
set_query_var( 'carousel_type', 'product-post' );
set_query_var( 'carousel_loop', $post_array );

?>

<section class="section__large">
  <div class="container">

    <?php get_component( '_carousel' ); ?>

  </div>
</section>
