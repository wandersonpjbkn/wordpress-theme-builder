<?php

// ==============================================
// Component: Lazy Image
// ==============================================

defined( 'ABSPATH' ) || exit;

$image_ID = get_query_var( 'lazy_image_ID' );
$image_size = get_query_var( 'lazy_image_size' );
$has_mobile_image = get_query_var( 'lazy_image_has_mobile_image' );
$mobile_image_ID = get_query_var( 'lazy_image_mobile_image_ID' );

?>

<img
  class="lazy <?= esc_attr( $has_mobile_image ? 'is__visible@sm' : '' ) ?>"
  data-src="<?= esc_url( wp_get_attachment_image_src( $image_ID, $image_size )[ 0 ] ) ?>"
  alt="<?= get_the_title( $image_ID ) ?>">

<?php if ( $has_mobile_image ) : ?>

  <img
    class="lazy is__hidden@sm"
    data-src="<?= esc_url( wp_get_attachment_image_src( $mobile_image_ID, $image_size )[ 0 ] ) ?>"
    alt="<?= get_the_title( $mobile_image_ID ) ?>">

<?php endif; ?>
