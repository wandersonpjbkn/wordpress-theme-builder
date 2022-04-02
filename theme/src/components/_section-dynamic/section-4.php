<?php

// ==============================================
// Component: Dynamic Section Type #4
// ==============================================

defined( 'ABSPATH' ) || exit;

// get card data
$data = get_query_var( 'section_dynamic_data' );
$models = array( 'md--2-3', 'md--1-3' );
$count = 0;

?>

<section class="section__large">
  <div class="container grid--1 grid--2-1@md">

    <?php foreach ( $data as $item ) : ?>

      <!-- set card model -->
      <?php set_query_var( 'card_dynamic_model', $models[ $count++ ] ) ?>

      <!-- set card align -->
      <?php set_query_var( 'card_dynamic_align', 'left' ) ?>

      <!-- set card url -->
      <?php set_query_var( 'card_dynamic_url', $item[ 'card_url' ] ); ?>

      <!-- set card image -->
      <?php set_query_var( 'lazy_image_ID', (int)$item[ 'card_image' ] ); ?>
      <?php set_query_var( 'lazy_image_size', 'full' ); ?>

      <!-- set card title -->
      <?php set_query_var( 'card_dynamic_title', $item[ 'card_text' ] ); ?>

      <!-- call dynamic card component -->
      <?php get_component( '_card-dynamic' ); ?>

    <?php endforeach; ?>

  </div>
</section>
