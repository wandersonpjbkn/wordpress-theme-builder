<?php

// ==============================================
// Template Part: Produts Featured
// ==============================================

defined( 'ABSPATH' ) || exit;

$carousel_metadata = array(
  0 => array( 'key' => 'responsive', 'value' => 'yes' )
);

set_query_var( 'carousel_metadata', $carousel_metadata );
set_query_var( 'carousel_title', 'Destaques' );
set_query_var( 'carousel_type', 'product-query' );
set_query_var( 'carousel_loop', new WP_Query( get_products_featured_to_carousel() ) );

?>

<section class="section__large">
  <div class="container">

    <?php get_component( '_carousel' ); ?>

  </div>
</section>
