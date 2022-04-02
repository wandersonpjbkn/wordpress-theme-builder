<?php
/**
 * Shipping Calculator
 *
 * @package WooCommerce/Templates
 * @version 4.0.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_shipping_calculator' );

?>

<form
	class="woocommerce-shipping-calculator"
	action="<?= esc_url( wc_get_cart_url() ) ?>"
	method="post">

	<?php wp_nonce_field( 'woocommerce-shipping-calculator', 'woocommerce-shipping-calculator-nonce' ); ?>

	<label>Digite seu CEP</label>

	<!-- country | hidden -->
	<input
		type="hidden"
		value="BR"
		name="calc_shipping_country">

	<!-- state  -->
	<input
		type="hidden"
		value="são paulo"
		name="calc_shipping_state" />

	<div class="form-grid">

		<input
			type="text"
			class="input-text"
			value="<?= esc_attr( WC()->customer->get_shipping_postcode() ) ?>"
			placeholder="<?php esc_attr_e( 'Postcode / ZIP', 'woocommerce' ); ?>"
			name="calc_shipping_postcode"
			id="calc_shipping_postcode" />

		<button
			type="submit"
			name="calc_shipping"
			value="1"
			class="button"
		>Calcular</button>

		<a
			href="http://www.buscacep.correios.com.br/sistemas/buscacep/"
			target="_blank"
		>Não sei meu CEP</a>

	</div>

</form>

<?php do_action( 'woocommerce_after_shipping_calculator' ); ?>

<?php /* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
