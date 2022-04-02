<?php

// ==============================================
// Template Part: Footer 
// ==============================================

defined( 'ABSPATH' ) || exit;

?>

  <footer class="section__large is__theme--dark position__relative">

    <?php get_footer( 'menu' ); ?>

    <div class="divider"></div>

    <?php get_footer( 'infos' ); ?>
    
    <div class="divider"></div>
    
    <?php get_footer( 'terms' ); ?>

  </footer>

  <!-- Smartlook -->
  <?php if ( is_user_logged_in() && ! is_dev() ) : ?>
    <?php get_template_part( 'mkt-smartlook' ) ?>
  <?php endif; ?>

  <!-- WordPress Footer -->
  <?php wp_footer(); ?>

</body>

</html>
