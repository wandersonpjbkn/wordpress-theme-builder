<?php

// ==============================================
// Template Part: Produts Best Sellers
// ==============================================

defined( 'ABSPATH' ) || exit;

$carousel_metadata = array(
  0 => array( 'key' => 'responsive', 'value' => 'yes' )
);

set_query_var( 'carousel_metadata', $carousel_metadata );
set_query_var( 'carousel_title', 'Mais Vendidos' );
set_query_var( 'carousel_type', 'product-query' );
set_query_var( 'carousel_loop', new WP_Query( get_products_best_sellers_to_carousel() ) );

?>

<section class="section__large">
  <div class="container">

    <?php get_component( '_carousel' ); ?>

  </div>
</section>
