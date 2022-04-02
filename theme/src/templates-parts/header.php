<?php

// ==============================================
// Template Part: Header 
// ==============================================

defined( 'ABSPATH' ) || exit;

?>

<?php get_template_part( 'head' ); ?>

<body <?php body_class(); ?>>

  <!-- When JS Disabled -->
  <?php get_template_part( 'noscript' ); ?>

  <!-- Google Tag Manager (Body) -->
  <?php if ( ! is_dev() ) : ?>
    <?php get_template_part( 'mkt-tagmanager' ) ?>
  <?php endif; ?>
  
  <header class="is__theme--dark sticky">

    <!-- main -->
    <?php get_header( 'default' ); ?>

    <!-- desktop menu -->
    <?php get_header( 'desktop' ); ?>

    <!-- mobile menu -->
    <?php get_header( 'mobile' ); ?>
    
  </header>

  <!-- mobile menu -->
  <?php get_header( 'badge' ); ?>
