<?php

// ==============================================
// Template Part: Header Menu (Mobile)
// ==============================================

defined( 'ABSPATH' ) || exit;

$key = 'i' . uniqid();

?>

<div
  class="is__hidden@md nav mobile js-toggle">

  <!-- mobile : account, cart and menu -->
  <nav
    role="navigation"
    aria-label="menu-mobile">

    <ul class="nav account-menu">

      <!-- log(in/out) -->
      <?php if ( is_user_logged_in() ) : ?>
        <li>
          <a
            class="btn--icn-home"
            href="<?= get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ?>"
          ></a>
        </li>
        <li>
          <a
            class="btn--icn-customer-logout"
            href="<?= wp_logout_url( home_url() ) ?>"
          ></a>
        </li>
      <?php else : ?>
        <li>
            <a
              class="btn--icn-user"
              href="<?= get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ?>"
            ></a>
        </li>
      <?php endif; ?>

      <!-- cart -->
      <?php get_template_part( 'cart' ) ?>

      <!-- menu -->
      <li>
        <button
          class="btn--icn-menu toggle"
          data-toggle="<?= esc_attr( $key ) ?>"></button>
      </li>

    </ul>

  </nav>

  <!-- mobile : menu categories -->
  <nav
    role="navigation"
    aria-label="menu-mobile">
    
    <ul
      id="<?= esc_attr( $key ) ?>"
      class="nav is__vertical menu-mobile">

      <!-- search -->
      <li class="input-icn">
        <?= do_shortcode( '[aws_search_form]' ); ?>
      </li>

      <!-- shop -->
      <li>
        <a
          href="<?= esc_url( home_url( '/' ) . 'loja' ) ?>"
        >Todos os produtos</a>
      </li>

      <!-- category links -->
      <?php get_template_part( 'menu-main' ) ?>

    </ul>

  </nav>

</div>
