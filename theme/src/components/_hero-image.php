<?php

// ==============================================
// Component: Hero Image
// ==============================================

defined( 'ABSPATH' ) || exit;

set_query_var( 'lazy_image_size', 'full' );

?>

<section class="is__theme--light hero">

  <div class="hero__container">

    <div class="hero__image">

      <?php get_component( '_lazy-image' ); ?>

    </div>

  </div>

</section>
