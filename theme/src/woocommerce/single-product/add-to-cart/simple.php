<?php
/**
 * Simple product add to cart
 *
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() )
  return;
  
?>

<?= wc_get_stock_html( $product ) // WPCS: XSS ok ?>

<?php if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form
		class="cart"
		action="<?= esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ) ?>"
		method="post"
		enctype='multipart/form-data'>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<?php set_query_var( 'wc_quantity_margin', true ); ?>
		<?php get_component( '_wc-quantity' ); ?>
		
		<div class="btn__group">

			<button
				type="submit"
				name="add-to-cart"
				value="<?= esc_attr( $product->get_id() ) ?>"
				class="single_add_to_cart_button btn alt is__theme--featured">
				
				<?= esc_html( $product->single_add_to_cart_text() ); ?>
				
			</button>
	
			<button class="single_add_to_cart_button js-add-to-cart btn alt is__theme--dark margin__top--medium">
				
				<div class="js-add-to-cart--text position__relative">
					<span>Adicionar ao carrinho</span>
					<div class="spinner--centerY position__center--right is__theme--light is__hidden"></div>
				</div>
	
				<span class="btn--icn-cart btn--inline"></span>
				
			</button>
			
		</div>
		
		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
