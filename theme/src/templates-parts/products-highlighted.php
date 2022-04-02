<?php

// ==============================================
// Template Part: Produts Highlighted
// ==============================================

defined( 'ABSPATH' ) || exit;

$highlighted = get_products_highlighted();

$carousel_metadata = array(
  0 => array( 'key' => 'responsive', 'value' => 'yes' ),
  1 => array( 'key' => 'responsive-data', 'value' => '{ "640": { "items": "2" }, "960": { "items": "3" }, "1200": { "items": "6" } }' ),
  2 => array( 'key' => 'timeout', 'value' => 20000 ),
  3 => array( 'key' => 'gap', 'value' => 30 ),
);

set_query_var( 'carousel_metadata', $carousel_metadata );
set_query_var( 'carousel_loop', $highlighted );
set_query_var( 'carousel_title', '#Dev' );
set_query_var( 'carousel_type', 'highlighted' );
set_query_var( 'carousel_ctrl', 'btns' );

?>

<?php if ( ! empty( $highlighted  ) ) : ?>

  <section class="section__large">
    <div class="container">

      <?php get_component( '_carousel' ); ?>

    </div>
  </section>
  
<? endif; ?>
