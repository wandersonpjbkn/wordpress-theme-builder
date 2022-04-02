<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

?>

<div class="woocommerce-variation-add-to-cart variations_button btn__group">

	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<button
		type="submit"
		class="single_add_to_cart_button btn alt is__theme--featured">
		
		<?= esc_html( $product->single_add_to_cart_text() ); ?>

	</button>

	<button class="single_add_to_cart_button js-add-to-cart btn alt is__theme--dark">
			
		<div class="js-add-to-cart--text position__relative">
			<span>Adicionar ao carrinho</span>
			<div class="spinner--centerY position__center--right is__theme--light is__hidden"></div>
		</div>

		<span class="btn--icn-cart btn--inline"></span>
		
	</button>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<input
		type="hidden"
		name="add-to-cart"
		value="<?= absint( $product->get_id() ); ?>" />

	<input
		type="hidden"
		name="product_id"
		value="<?= absint( $product->get_id() ); ?>" />

	<input
		type="hidden"
		name="variation_id"
		class="variation_id"
		value="0" />
	
</div>
