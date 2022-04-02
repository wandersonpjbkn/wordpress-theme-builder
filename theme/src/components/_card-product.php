<?php

// ==============================================
// Component: Card Product
// ==============================================

defined( 'ABSPATH' ) || exit;

global $product;

$card_product_title = get_query_var( 'card_product_title', get_the_title() );
$card_product_link = get_query_var( 'card_product_link', get_permalink() );

if ( $product->is_type( 'variable' ) ) {
  $price = (float)$product->get_variation_sale_price() > 0
    ? (float)$product->get_variation_sale_price()
    : (float)$product->get_variation_regular_price();
} else {
  $price = (float)$product->get_sale_price() > 0
  ? (float)$product->get_sale_price()
  : (float)$product->get_regular_price();
}

$is_on_sale = $product->is_on_sale();
$has_quota = $price >= 200;

?>

<a
  class="card__product"
  href="<?= esc_url( $card_product_link ) ?>">

  <!-- label special offer -->
  <?php do_action( 'card_product_label' ) ?>

  <!-- image -->
  <div class="card__product__image">

    <div class="card__product__image--container item">
      <?php get_card_product_image( $product, 'item' ); ?>
    </div>

    <div class="card__product__image--container usage">
      <?php get_card_product_image( $product, 'usage' ); ?>
    </div>

  </div>

  <!-- infos -->
  <div class="card__product__info">

    <!-- title -->
    <p class="card__product__title">
      <strong><?= $card_product_title ?></strong>
    </p>

    <div class="card__product__price <?= $has_quota ? 'is__flex--row-reverse' : 'is__flex' ?>">

      <!-- quota -->
      <?php if ( $has_quota ) : ?>

        <div class="card__product__price--quota">
          <?= get_product_quota( $price ) ?>
        </div>

      <?php endif; ?>

      <!-- price -->
      <?php if ( ! $product->is_type( 'variable' ) && $is_on_sale ) : ?>

      <!-- price with special offer price -->
        <div class="is__flex is__vertical">

          <div class="card__product__price--regular">
            <?= wc_price( $product->get_regular_price() ) ?>
          </div>

          <div class="card__product__price--sales">
            <?= wc_price( $price ) ?>
          </div>

        </div>

      <?php elseif ( $product->is_type( 'variable' ) ) : ?>

        <!-- price variable -->
        <div class="card__product__price--sales <?= $has_quota ? 'is__flex is__vertical' : '' ?>">
          <small>a partir de </small>
          <?= wc_price( $price ) ?>
        </div>

      <?php else : ?>

        <!-- price single  -->
        <div class="card__product__price--sales">
          <?= wc_price( $price ) ?>
        </div>

      <?php endif; ?>

    </div>

  </div>

</a>
