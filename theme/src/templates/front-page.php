<?php

// ==============================================
// Template Name: Front Page
// ==============================================

defined( 'ABSPATH' ) || exit;

$page_ID = get_page_id_by_slug( 'home' );
$count = 1;
$printed_featured = false;
$printed_best_seller = false;
$printed_highlighted = false;

?>

<?php get_header(); ?>

<main>

  <?php get_template_part( 'timer' ); ?>

  <?php get_template_part( 'slideshow' ); ?>

  <?php get_template_part( 'stripe' ); ?>

  <?php if ( function_exists( 'get_field' ) && (int)get_field( 'show_featured_section', $page_ID ) === 0 ) : ?>
    <?php get_template_part( 'products-featured' ); ?>
    <?php $printed_featured = true; ?>
  <?php endif; ?>

  <?php if ( function_exists( 'get_field' ) && (int)get_field( 'show_best_sellers_section', $page_ID ) === 0 ) : ?>
    <?php get_template_part( 'products-best-sellers' ); ?>
    <?php $printed_best_seller = true; ?>
  <?php endif; ?>

  <?php if ( function_exists( 'get_field' ) && (int)get_field( 'show_highlighted_section', $page_ID ) === 0 ) : ?>
    <?php get_template_part( 'products-highlighted' ); ?>
    <?php $printed_featured = true; ?>
  <?php endif; ?>

  <?php if ( function_exists( 'get_field' ) && have_rows( 'dynamic_layout_section', $page_ID ) ) :  ?>

    <?php while ( have_rows( 'dynamic_layout_section', $page_ID ) ) : ?>

      <?php get_dynamic_section( the_row( true ) ); ?>

      <?php if ( (int)get_field( 'show_featured_section', $page_ID ) === $count ) : ?>
        <?php get_template_part( 'products-featured' ); ?>
        <?php $printed_featured = true; ?>
      <?php endif; ?>

      <?php if ( (int)get_field( 'show_best_sellers_section', $page_ID ) === $count ) : ?>
        <?php get_template_part( 'products-best-sellers' ); ?>
        <?php $printed_best_seller = true; ?>
      <?php endif; ?>

      <?php if ( (int)get_field( 'show_highlighted_section', $page_ID ) === $count ) : ?>
        <?php get_template_part( 'products-highlighted' ); ?>
        <?php $printed_highlighted = true; ?>
      <?php endif; ?>

      <?php $count++; ?>

    <?php endwhile; ?>

    <?php if ( ! $printed_featured ) : ?>
      <?php get_template_part( 'products-featured' ); ?>
    <?php endif; ?>

    <?php if ( ! $printed_best_seller ) : ?>
      <?php get_template_part( 'products-best-sellers' ); ?>
    <?php endif; ?>

    <?php if ( ! $printed_highlighted ) : ?>
      <?php get_template_part( 'products-highlighted' ); ?>
    <?php endif; ?>

  <?php elseif( function_exists( 'get_field' ) ) : ?>

    <?php get_template_part( 'slideshow' ); ?>

    <section class="section__large">
      <div class="container">
        <h2>Importante</h2>
        <p>Não há seções dinâmicas cadastradas</p>
      </div>
    </section>

  <?php else : ?>

    <section class="section__large">
      <div class="container">
        <h2>Importante</h2>
        <p>ACF precisa estar ativo!</p>
      </div>
    </section>

  <?php endif;  ?>

</main>

<?php get_footer(); ?>