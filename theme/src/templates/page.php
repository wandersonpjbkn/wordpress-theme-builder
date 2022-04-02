<?php

// ==============================================
// Template Name: General Page
// ==============================================

defined( 'ABSPATH' ) || exit;

?>

<?php get_header(); ?>

<main class="<?= esc_attr( is_cart() || is_checkout() || is_account_page() ? '' : 'content' ) ?>">

  <!-- Notification -->
  <?php get_template_part( '_notification' ) ?>

  <section class="section__large">
    <div class="container">

      <?php if ( is_cart() || is_checkout() || is_account_page() ) : ?>

        <h2 class="title__subtitle is__hidden">
          <?php the_title(); ?>
        </h2>

      <?php else : ?>

        <h2 class="title__subtitle">
          <?php the_title(); ?>
        </h2>

      <?php endif; ?>

      <?php the_content(); ?>

    </div>
  </section>

</main>

<?php get_footer(); ?>
