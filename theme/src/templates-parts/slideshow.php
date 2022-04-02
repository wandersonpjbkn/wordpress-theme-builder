<?php

// ==============================================
// Template Part: Slideshow
// ==============================================

defined( 'ABSPATH' ) || exit;

$slides = get_slideshow_banner_images();
$carousel_metadata = array(
  0 => array( 'key' => 'gap', 'value' => 0 ),
  1 => array( 'key' => 'timeout', 'value' => 10000 )
);

set_query_var( 'carousel_metadata', $carousel_metadata );
set_query_var( 'carousel_type', 'slides' );
set_query_var( 'carousel_loop', $slides );

?>

<section>
  <div>

    <?php get_component( '_carousel' ); ?>

  </div>
</section>
