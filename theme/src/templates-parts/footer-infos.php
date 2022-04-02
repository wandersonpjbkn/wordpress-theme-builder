<?php

// ==============================================
// Template Part: Footer Infos
// ==============================================

defined( 'ABSPATH' ) || exit;

?>

<section class="container margin__top--medium margin__bottom--large grid--1 grid--2@sm">

  <div>

    <h3 class="title__subtitle">Sua Segurança</h3>

    <nav
      role="navigation"
      aria-label="footer-menu-infos">

        <ul class="nav footer is__vertical">
          
          <li>
            <a
              href="<?= esc_url( 'https://transparencyreport.google.com/safe-browsing/search?url=' . home_url( '/' ) . '&hl=pt_BR' ) ?>"
              target="_blank"
              rel="noreferrer">Google Safe Browsing</a>
          </li>

        </ul>

    </nav>

  </div>

  <div>

    <h3 class="title__subtitle">Formas de Pagamento</h3>

    <nav
      role="navigation"
      aria-label="footer-menu-payments">

        <ul class="nav footer is__vertical">
          
          <li>
            <img
              style="width:100%;max-width:500px;"
              src="<?= esc_url( get_template_directory_uri() . '/img/icn-payment-stamps.svg' ) ?>"
              alt="Bandeiras">
          </li>

        </ul>

    </nav>

  </div>

</section>
