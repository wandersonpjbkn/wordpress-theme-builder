<?php

// ==============================================
// Template Part: Stripe
// ==============================================

defined( 'ABSPATH' ) || exit;

$stripe = get_stripe_data();

?>

<?php if ( ! empty( $stripe  ) ) : ?>

  <section class="section__medium is__theme--dark">
    <div class="container grid--2 grid--4@sm">

      <?php foreach( $stripe as $item ) : ?>
        <div class="stripe grid--1-3">

          <div class="stripe__img">
            <?php set_query_var( 'lazy_image_ID', (int)$item[ 'image_ID' ] ); ?>
            <?php get_component( '_lazy-image' ); ?>
          </div>

          <div class="stripe__box">

            <div class="stripe__title">
              <?= esc_html( $item[ 'title' ] ) ?>
            </div>

            <div class="stripe__text">
              <?= esc_html( $item[ 'text' ] ) ?>
            </div>

          </div>

        </div>        
      <?php endforeach; ?>

    </div>
  </section>
  
<? endif; ?>
