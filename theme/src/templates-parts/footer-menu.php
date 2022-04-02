<?php

// ==============================================
// Template Part: Footer Menu
// ==============================================

defined( 'ABSPATH' ) || exit;

$data = get_footer_menu_data();
$social_links = array_slice( get_social_links(), 0, 2);
$social_links_labels = array( 'Facebook', 'Instagram' );

?>

<section class="container grid--1 grid--2@sm grid--4@lg">

  <div
    class="position__center--top is__theme--gray"
    style="margin-top:-20px;">

    <nav
      role="navigation"
      aria-label="social-links-footer-1">

      <ul class="nav social__float">
        <?php $count = 0; ?>
        <?php foreach ( $social_links as $social_item ) : ?>

          <li>
            <a
              class="<?= esc_attr( 'btn--icn-' . $social_item[ 'icn' ] ) ?>"
              href="<?= esc_url( $social_item[ 'url' ] ) ?>"
              rel="noreferrer"
              target="_blank"
            ><span><?= esc_html( $social_links_labels[ $count++ ] ) ?></span></a>
          </li>

        <?php endforeach; ?>
      </ul>

    </nav>
  </div>

  <?php foreach ( $data as $key => $item ) : ?>
    <div>

      <h3 class="title__subtitle">
        <?= esc_html( $item[ 'title' ] ) ?>
      </h3>

      <nav
        role="navigation"
        aria-label="footer-menu-<?= esc_attr( $key ) ?>">

        <ul class="nav footer is__vertical">

          <?php foreach ( $item[ 'data' ] as $nav ) : ?>
            <li>

              <?php if ( $nav[ 'type' ] == 'url' ) : ?>

                <a
                  href="<?= esc_url( $nav[ 'url' ] ) ?>"
                ><?= esc_html( $nav[ 'name' ] ) ?></a>

              <?php else : ?>

                <span class="link"><?= esc_html( $nav[ 'name' ] ) ?></span>

              <?php endif; ?>

            </li>
          <?php endforeach; ?>

        </ul>

      </nav>

    </div>
  <?php endforeach; ?>

  <div>

    <h3 class="title__subtitle">Novidades</h3>

    <p>Receba as nossas promoções</p>

    <!-- FORM GOES HERE -->

  </div>

</section>
