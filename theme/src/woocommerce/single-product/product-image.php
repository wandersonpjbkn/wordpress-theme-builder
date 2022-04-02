<?php
/**
 * Single Product Image
 * 
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attachment_ids = array_merge( array( $product->get_image_id() ), $product->get_gallery_image_ids() );

?>

<div class="gallery">

  <!-- Gallery control -->
  <nav class="gallery__carousel height__xlarge@md">

    <div class="gallery__wrapper">

      <ul class="gallery__nav">
  
        <?php if ( function_exists( 'get_field' ) && have_rows( get_field( 'video_360_links' ) ) ) : ?>
  
          <li>
            <button class="gallery__carousel--btn gallery__video-btn">360 °</button>
          </li>
  
        <?php endif; ?>

        <?php $count = 0; ?>
        <?php foreach ( $attachment_ids as $attachment_id ) : ?>
  
          <li>
            <button
              class="gallery__carousel--btn gallery__thumb"
              data-index="<?= $count++; ?>">
        
              <?php set_query_var( 'lazy_image_ID', (int)$attachment_id ); ?>
              <?php set_query_var( 'lazy_image_size', 'thumbnail' ); ?>
  
              <?php get_component( '_lazy-image' ) ?>
  
            </button>
          </li>
  
        <?php endforeach; ?>
  
      </ul>

    </div>

    <button
      class="gallery__carousel--btn gallery__prev js-gallery-prev"
      data-index="-1"
    ></button>

    <button
      class="gallery__carousel--btn gallery__next js-gallery-next"
      data-index="1"
    ></button>

  </nav>

  <!-- Gallery video -->
  <div class="gallery__video-target height__medium height__xlarge@md"></div>

  <!-- Gallery image -->
  <div class="gallery__thumb-target height__medium height__xlarge@md">

    <!-- Gallery Target -->
    <img
      src="<?= get_image_placeholder() ?>"
      alt="featured-image">

    <!-- Zoom Target -->
    <div class="gallery__zoom">

      <!-- Close -->
      <nav class="gallery__zoom--close is__flex is__theme--gray container--expand">
        <ul class="nav push__right">
          <li>
            
            <button class="gallery__toggle link btn--icn-close"></button>
          
          </li>
        </ul>
      </nav>

      <!-- Pinch Zoom -->
      <div class="gallery__zoom--pinch-zoom">

        <!-- zoom target -->
        <img
          src="<?= get_image_placeholder() ?>"
          alt="zoom-image">

        <!-- zoom navigation -->
        <nav
          class="gallery__zoom--ctrl btns"
          data-type="btn">

          <button
            class="js-gallery-prev gallery__zoom--btn btn btn--icn-prev"
            data-index="-1"
          ></button>

          <button
            class="js-gallery-next gallery__zoom--btn btn btn--icn-next push__right"
            data-index="1"
          ></button>

        </nav>

      </div>

    </div>

    <!-- Zoom Active -->
    <nav class="position__bottom--right margin--small">
      <ul class="nav">
        <li>
        
          <button class="gallery__toggle link btn--icn-expand"></button>
        
        </li>
      </ul>
    </nav>

  </div>

</div>
