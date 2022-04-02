<?php

// ==============================================
// Template Part: Footer Terms
// ==============================================

defined( 'ABSPATH' ) || exit;

$terms_links = get_terms_links();

?>

<section class="container is__flex">

  <div class="nav terms logo col--1 col--1-6@md">
    <?php get_component( '_logo' ); ?>
  </div>

  <ul class="nav terms text__meta push__right@md">

    <?php foreach ( $terms_links as $key => $item ) : ?>
      
      <li>

        <a
          href="<?= esc_url( $item[ 'url' ] ) ?>"
        ><?= esc_html( $item[ 'name' ] ) ?></a>

      </li>

      <li class="nav__divider"></li>

    <?php endforeach; ?>

    <li>
      <span class="link">Copyright © <?= esc_html( wp_date( 'Y' ) ) ?></span>
    </li>

  </ul>
</section>
