<?php

// ==============================================
// Component: Card Dynamic
// ==============================================

defined( 'ABSPATH' ) || exit;

$card_dynamic_model = get_query_var( 'card_dynamic_model' );
$card_dynamic_url = get_query_var( 'card_dynamic_url' );
$card_dynamic_title = get_query_var( 'card_dynamic_title' );
$card_dynamic_align = get_dynamic_card_align( get_query_var( 'card_dynamic_align' ) );

set_query_var( 'lazy_image_size', 'full' );

?>

<a
  class="card__dynamic position__relative <?= esc_attr( $card_dynamic_model ) ?>"
  href="<?= esc_url( $card_dynamic_url ) ?>">
  
  <div class="card__dynamic__image">
    <?php get_component( '_lazy-image' ); ?>
  </div>

  <?php if ( ! ( empty( $card_dynamic_title ) || $card_dynamic_title === NULL ) ) : ?>

    <div class="position__bottom--left margin--small margin--medium@md">

      <strong class="card__dynamic__title <?= esc_attr( $card_dynamic_align ) ?>">
        <?= esc_html( $card_dynamic_title ) ?>
      </strong>
      
      <button class="card__dynamic__cta <?= esc_attr( $card_dynamic_align ) ?> is__visible@sm">
        Conferir
      </button>

    </div>

  <?php endif; ?>

</a>
