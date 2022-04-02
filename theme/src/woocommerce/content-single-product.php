<?php
/**
 * Content Product
 * 
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$featured_video = function_exists( 'get_field' ) ? trim( get_field( 'featured_video_link' ) ) : '';
$featured_image = function_exists( 'get_field' ) ? trim( get_field( 'featured_image_id' ) ) : '';

?>

<section>
	<div class="container">

		<!-- Notification -->
		<?php get_template_part( '_notification' ) ?>

		<!-- Hook: woocommerce_before_single_product. -->
		<!-- @hooked wc_print_notices - 10 -->
		<?php do_action( 'woocommerce_before_single_product' ); ?>
		
	</div>
</section>


<?php if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}; ?>

<section class="section__large nocollapse border-featured">
	<div class="container">

		<div	
			id="product-<?php the_ID(); ?>"
			class="grid--1 grid--3-2@md position__relative">

			<!-- Hook: woocommerce_before_single_product_summary. -->
			<!-- @hooked woocommerce_show_product_sale_flash - 10 -->
			<!-- @hooked woocommerce_show_product_images - 20 -->
			<?php do_action( 'woocommerce_before_single_product_summary' ); ?>

			<div class="infos">
				<!-- Hook: woocommerce_single_product_summary. -->
				<!-- @hooked woocommerce_template_single_title - 5 -->
				<!-- @hooked woocommerce_template_single_rating - 10 [REMOVED] -->
				<!-- @hooked woocommerce_template_single_price - 10 -->
				<!-- @hooked woocommerce_template_single_excerpt - 20 [REMOVED] -->
				<!-- @hooked woocommerce_template_single_add_to_cart - 30 -->
				<!-- @hooked woocommerce_template_single_meta - 40 [REMOVED] -->
				<!-- @hooked woocommerce_template_single_sharing - 50 [REMOVED] -->
				<!-- @hooked WC_Structured_Data::generate_product_data() - 60 -->
				<?php do_action( 'woocommerce_single_product_summary' ); ?>
			</div>

		</div>

	</div>
</section>

<section class="section__large nocollapse is__theme--light">

	<!-- main description -->
	<div class="container grid--1 <?= esc_attr( ! empty( $featured_video ) ? 'grid--2@md' : '' ) ?>">

		<!-- Product details info -->
		<div class="product">

			<!-- Description / Tech / Reviews  -->
			<?php woocommerce_output_product_data_tabs(); ?>

		</div>

		<!-- Featured Video -->
		<?php if ( ! empty( $featured_video ) ) : ?>

			<div class="featured-video">

				<iframe
					class="lazy height__large"
					data-src="<?= esc_url( 'https://www.youtube-nocookie.com/embed/' . $featured_video . '?feature=oembed&showinfo=0&rel=0' ) ?>"
					frameborder="0"
					allowfullscreen
				></iframe>

			</div>

		<?php endif; ?>

	</div>
	
	<!-- featured description (custom image) -->
	<?php if ( ! empty( $featured_image ) ) : ?>
		<div class="container margin__top--medium">
		
			<?php set_query_var( 'lazy_image_ID', (int)$featured_image ); ?>
			<?php set_query_var( 'lazy_image_size', 'full' ); ?>
			
			<?php get_component( '_lazy-image' ) ?>

		</div>
	<?php endif; ?>

</section>

<?php
	$product_id = $product->get_id();
	$products_categories_names = htmlspecialchars(
		json_encode(
			get_current_product_category( $product->get_id() ),
			JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK
		)
	);
?>

<aside
	class="data-layer-js"
	data-id="<?= esc_attr( $product_id ) ?>"
	data-name="<?= esc_attr( $product->get_name() ) ?>"
	data-price="<?= esc_attr( $product->get_price() ) ?>"
	data-type="<?= esc_attr( $product->get_type() ) ?>"
	data-category="<?= $products_categories_names ?>"
></aside>

<!-- Related Products -->
<?php get_template_part( 'products-related' ); ?>

<?php do_action( 'woocommerce_after_single_product' ); ?>

<?php /* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
