<?php

// ==============================================
// Template Part: Menu Main
// ==============================================

defined( 'ABSPATH' ) || exit;

$data = get_header_menu_data();

?>

<?php foreach ( $data as $item ) : ?>

<li class="<?= esc_attr( $item[ 'is_featured' ] ? 'is__theme--featured' : '' ) ?>">

  <?php if ( $item[ 'type' ] == 'category' ) : ?>

    <a
      href="<?= get_category_url( $item[ 'slug' ] ) ?>"
    ><?= esc_html( $item[ 'name' ] ) ?></a>

  <?php elseif ( $item[ 'type' ] == 'internal' ) : ?>

    <a
      href="<?= esc_url( home_url( '/' ) . $item[ 'slug' ] ) ?>"
    ><?= esc_html( $item[ 'name' ] ) ?></a>

  <?php else : ?>

    <a
      href="<?= esc_url( $item[ 'url' ] ) ?>"
    ><?= esc_html( $item[ 'name' ] ) ?></a>

  <?php endif; ?>

</li>

<?php endforeach; ?>
