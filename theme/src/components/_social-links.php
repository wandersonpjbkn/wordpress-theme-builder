<?php

// ==============================================
// Component: Social Links 
// ==============================================

defined( 'ABSPATH' ) || exit;

$social_links = get_social_links();

?>

<ul class="nav social">
  <?php foreach ( $social_links as $link ) : ?>
    <li>

      <a
        href="<?= esc_url( $link[ 'url' ] ) ?>"
        rel="noreferrer"
        class="btn--icn-<?= esc_attr( $link[ 'icn' ] ) ?>"
        target="_blank"
      ></a>

    </li>
  <?php endforeach; ?>
</ul>
