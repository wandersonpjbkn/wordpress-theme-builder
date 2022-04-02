<?php

// ==============================================
// Template Part: Header Menu (Desktop)
// ==============================================

defined( 'ABSPATH' ) || exit;

?>

<div class="is__theme--gray is__visible@md">

  <!-- desktop : menus -->
  <nav
    class="container is__flex"
    role="navigation"
    aria-label="main-menu">

    <!-- desktop : menu category -->
    <div>
      <ul class="nav menu-desktop">

        <!-- category links -->
        <?php get_template_part( 'menu-main' ) ?>

      </ul>
    </div>

    <!-- desktop : account / cart -->
    <div class="push__right is__flex">
      <ul class="nav account-cart">

        <!-- log(in/out) -->
        <?php if ( is_user_logged_in() ) : ?>
          <li>
            <a
              href="<?= get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ?>"
            >Minha Conta</a>
          </li>
          <li>
            <a
              href="<?= wp_logout_url( home_url() ) ?>"
            >Logout</a>
          </li>
        <?php else : ?>
          <li>
            <a
              href="<?= get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ?>"
            >Login</a>
          </li>
        <?php endif; ?>

        <!-- cart -->
        <?php get_template_part( 'cart' ) ?>
        
      </ul>
    </div>

  </nav>

</div>
