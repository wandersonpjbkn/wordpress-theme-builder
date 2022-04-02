<?php

// ==============================================
// Component: WooCommerce - Quantity
// ==============================================

defined( 'ABSPATH' ) || exit;

$wc_quantity_margin = get_query_var( 'wc_quantity_margin' ) ? 'margin__bottom--medium' : '';

global $product;

?>

<div
  class="product-info is__flex is__vertical <?= esc_attr( $wc_quantity_margin )?>">

  <label>Quantidade</label>

  <?php
    woocommerce_quantity_input( array(
      'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
      'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
      'input_value' => isset( $_POST[ 'quantity' ] ) ? wc_stock_amount( wp_unslash( $_POST[ 'quantity' ] ) ) : $product->get_min_purchase_quantity(),
      // WPCS: CSRF ok, input var ok.
    ) );
  ?>

</div>
