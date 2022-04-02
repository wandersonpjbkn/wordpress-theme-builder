<?php

// ==============================================
// Template Part: Header Main
// ==============================================

defined( 'ABSPATH' ) || exit;

?>

<div class="container is__flex--center">

  <!-- logo -->
  <div class="push__left">
    <h1 class="logo">
      <?php get_component( '_logo' ); ?>
    </h1>
  </div>

  <!-- social and search -->
  <div class="is__hidden is__flex@md push__right">

    <!-- social links -->
    <div class="margin__right--large">
      <nav
        role="navigation"
        aria-label="social-links-header">

        <?php get_component( '_social-links' ); ?>
        
      </nav>
    </div>

    <!-- search -->
    <div class="input--icn">
      <?= do_shortcode( '[aws_search_form]' ); ?>
    </div>

    
  </div>

</div>
