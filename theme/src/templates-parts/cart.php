<?php

// ==============================================
// Template Part: Cart Menu
// ==============================================

defined( 'ABSPATH' ) || exit;

$cart_count = (int)WC()->cart->get_cart_contents_count();

?>

<li>

  <?php if ( $cart_count !== 0 ) : ?>

    <a
      class="btn--icn-cart oncart"
      href="<?= wc_get_cart_url() ?>"
      data-cart-counter="<?= $cart_count ?>"
    ></a>

  <?php else : ?>

    <a
      class="btn--icn-cart"
      href="<?= wc_get_cart_url() ?>"
    ></a>
    
  <?php endif; ?>

</li>
