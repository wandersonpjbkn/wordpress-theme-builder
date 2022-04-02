<?php

// ==============================================
// Component: Logo
// ==============================================

defined( 'ABSPATH' ) || exit;

$is_responsive = get_query_var( 'logo_is_responsive', true );

?>

<a href="<?= esc_url( home_url( '/' ) ) ?>">

  <img
    class="js-desktop <?= esc_attr( $is_responsive ? 'is__visible@sm ' : '' ) ?>"
    src="<?= esc_url( get_template_directory_uri() . '/img/logotipo-desktop.svg' ) ?>"
    alt="<?= bloginfo( 'name' ) ?>">

  <?php if ( $is_responsive ) : ?>
    <img
      class="is__hidden@sm js-mobile"
      src="<?= get_template_directory_uri() . '/img/logotipo-mobile.svg' ?>"
      alt="<?= bloginfo( 'name' ) ?>">
  <?php endif; ?>

</a>
