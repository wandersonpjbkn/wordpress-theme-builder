<?php
/**
 * Product archives
 *
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

?>

<?php get_header( 'shop' ); ?>

<!-- Hook: woocommerce_before_main_content. -->
<!-- @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content) [REMOVED] -->
<!-- @hooked woocommerce_breadcrumb - 20 [REMOVED] -->
<!-- @hooked WC_Structured_Data::generate_website_data() - 30 -->
<?php do_action( 'woocommerce_before_main_content' ); ?>

<main>

	<?php $thumb_id = get_category_featured_image_ID(); ?>
	
	<?php 
		if ( $thumb_id ) 
		{
			set_query_var( 'lazy_image_ID', (int)$thumb_id ); 
			get_component( '_hero-image' );
		}
	?>

	<section class="section__large">

		<div class="container">

			<!-- @hooked woocommerce_output_all_notices -->
			<?php wc_print_notices(); ?>

		</div>

    <div class="container grid--1 grid--1-4@md">

			<aside class="sidebar">

				<?php get_sidebar(); ?>

			</aside>

      <div>

				<?php if ( woocommerce_product_loop() ) : ?>

				<div class="is__flex--center margin__bottom--small">

					<!-- Hook: woocommerce_before_shop_loop. -->
					<!-- @hooked woocommerce_output_all_notices - 10 [REMOVED] -->
					<!-- @hooked woocommerce_result_count - 20 -->
					<!-- @hooked woocommerce_catalog_ordering - 30 -->
					<?php do_action( 'woocommerce_before_shop_loop' ); ?>

				</div>

					<div class="container grid--1 grid--2@sm grid--4@lg">

						<?php if ( wc_get_loop_prop( 'total' ) ) : ?>

							<?php while ( have_posts() ) : the_post(); ?>

								<!-- Hook: woocommerce_shop_loop. -->
								<?php do_action( 'woocommerce_shop_loop' ); ?>

								<!-- loop over simple or variable -->
								<?php global $product; ?>

								<?php if ( $product->get_type() == 'variable' && get_show_on_showcase( $product->get_id() ) ) : ?>

									<?php $variables = $product->get_available_variations(); ?>
									<?php foreach ( $variables as $variable ): ?>

										<?php $product = new WC_Product_Variation( $variable[ 'variation_id' ] ); ?>
										<?php $link = $product->get_permalink(); ?>
										<?php $title = html_entity_decode( get_the_title() ); ?>
										<?php $attributes = array_values( $product->get_attributes() ); ?>

										<?php foreach ( $attributes as $attribute ) { $title .= " $attribute"; } ?>

										<?php set_query_var( 'card_product_title', $title ); ?>
										<?php set_query_var( 'card_product_link', $link ); ?>

										<!-- call product card -->
										<?php get_component( '_card-product' ); ?>

									<?php endforeach; ?>

									<?php wp_reset_postdata(); ?>

								<?php else : ?>

									<!-- call product card -->
									<?php get_component( '_card-product' ); ?>

								<?php endif; ?>

							<?php endwhile; ?>

						<?php endif; ?>

					</div>

					<!-- Hook: woocommerce_after_shop_loop. -->
					<!-- @hooked woocommerce_pagination - 10 -->
					<?php do_action( 'woocommerce_after_shop_loop' ); ?>

				<?php else : ?>

					<!-- Hook: woocommerce_no_products_found. -->
					<!-- @hooked wc_no_products_found - 10 -->
					<?php do_action( 'woocommerce_no_products_found' ); ?>

				<?php endif; ?>

				<!-- Hook: woocommerce_after_main_content. -->
				<!-- @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content) -->
				<?php do_action( 'woocommerce_after_main_content' ); ?>

			</div>

    </div>
  </section>

</main>

<?php get_footer( 'shop' ); ?>
