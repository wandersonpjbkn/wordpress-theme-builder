<?php

// ==============================================
// Template Part: Sidebar 
// ==============================================

defined( 'ABSPATH' ) || exit;

?>

<?php if ( is_search() ) : ?>

  <?php $search_text = 'Resultados da pesquisa por:'; ?>
  <?php $search_query = '“' . get_search_query() . '”'; ?>

  <span class="is__flex margin__bottom--xsmall">
    <?= esc_html( $search_text ) ?>
  </span>

  <h2 class="title__category">
    <span class="margin__right--xsmall"><?= esc_html( $search_query ) ?></span>
    <small><?= esc_html( get_query_var( 'paged' ) ? 'pág ' . get_query_var( 'paged' ) : '' ) ?></small>
  </h2>

<?php else : ?>

  <h2 class="title__category">
    <?php woocommerce_page_title(); ?>
  </h2>

<?php endif; ?>

<div class="is__visible@md">
  <!-- Hook: woocommerce_archive_description. -->
  <!-- @hooked woocommerce_taxonomy_archive_description - 10 -->
  <!-- @hooked woocommerce_product_archive_description - 10 -->
  <?php do_action( 'woocommerce_archive_description' ); ?>
</div>

<nav class="is__visible@md">
  <ul class="nav sidebar-main js-toggle">

    <?php $main_categories = get_products_categories(); ?>

    <?php foreach ( $main_categories as $main_category ) : ?>

      <!-- gen randon id key -->
      <?php $key = 'i' . uniqid(); ?>

      <li>

        <!-- expand nav -->
        <button
          class="toggle"
          data-toggle="<?= esc_attr( $key ) ?>">

          <?= esc_html( $main_category->name ) ?>

        </button>

        <!-- nav -->
        <ul
          id="<?= esc_attr( $key ) ?>"
          class="nav sidebar-sub">

          <!-- view category -->
          <li>
            <a
              href="<?= get_category_url( $main_category->slug ) ?>"
            >Ver todos</a>
          </li>

          <!-- view child categories -->
          <?php $child_categories = get_products_categories( $main_category->term_id ); ?>

          <!-- check if this category has childrens -->
          <?php if ( ! empty( $child_categories ) ) : ?>

            <!-- display them in a list -->
            <?php foreach ( $child_categories as $child_category ) : ?>

              <!-- view child-category -->
              <li>
                <a
                  href="<?= get_category_url( $child_category->slug ) ?>"
                ><?= esc_html( $child_category->name ) ?></a>
              </li>

            <?php endforeach; ?>


          <?php endif; ?>

        </ul>

      </li>

    <?php endforeach; ?>

  </ul>
</nav>
