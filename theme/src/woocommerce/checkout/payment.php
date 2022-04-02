<?php
/**
 * Checkout Payment Section
 *
 * @package WooCommerce/Templates
 * @version 3.5.3
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_ajax() )
	do_action( 'woocommerce_review_order_before_payment' );

$key = 'i' . uniqid();
?>

<div
	id="payment"
	class="woocommerce-checkout-payment">

	<h3 class="title__subtitle header is__theme--gray position__relative">

		<span class="is__hidden@md">
			Forma de pagamento
		</span>

		<span class="is__visible@md">
			Aceitamos os cartões
		</span>

		<img
			class="is__visible@md position__center--right margin__right--small"
			style="max-width:500px"
			src="<?= esc_url( get_template_directory_uri() . '/img/icn-payment-stamps.svg' ) ?>"
			alt="Meios de Pagamento">
			
		<button
			class="js-modal btn btn--icn-help position__center--right margin__right--small is__hidden@md"
			data-modal="<?= esc_attr( $key ) ?>"
		></button>

	</h3>

	<p class="text__center margin--medium is__visible@md">
		Selecione sua forma de pagamento (todas as opções aceitam as bandeiras acima)
	</p>

	<div
		id="<?= esc_attr( $key ) ?>"
		class="modal">

		<div class="modal__canvas"></div>
		<div class="modal__container is__theme--gray">

			<button class="btn btn--icn-close"></button>

			<p>
				Aceitamos as bandeiras:
			</p>

			<img
				class="margin__bottom--small"
				src="<?= esc_url( get_template_directory_uri() . '/img/icn-payment-stamps.svg' ) ?>"
				alt="Meios de Pagamento">

			<p>
				Através dos meios de pagamento:
				<br>- Mercado Pago
				<br>- PayPal
				<br>- PagSeguro
			</p>

		</div>
	</div>
	
	<?php if ( WC()->cart->needs_payment() ) : ?>

		<div class="wc_payment_methods payment_methods methods">

			<?php if ( ! empty( $available_gateways ) ) : ?>

				<?php foreach ( $available_gateways as $gateway ) : ?>

					<?php wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) ); ?>

				<?php endforeach; ?>

			<?php else : ?>

				<?= '<div class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ) . '</div>' // @codingStandardsIgnoreLine ?>
			
			<?php endif; ?>

		</div>

	<?php endif; ?>

	<div class="place-order">

		<div class="header is__theme--gray">

			<?php wc_get_template( 'checkout/terms.php' ); ?>

		</div>

		<noscript>

			<?php printf( esc_html__( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ), '<em>', '</em>' ); ?>
			
			<br/>
			
			<button
				type="submit"
				class="button alt"
				name="woocommerce_checkout_update_totals"
				value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>"
			><?php esc_html_e( 'Update totals', 'woocommerce' ); ?></button>
		
		</noscript>

		<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

		<?= apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="btn--primary alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ) // @codingStandardsIgnoreLine ?>

		<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

		<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>

	</div>

</div>

<?php if ( ! is_ajax() ) : ?>

	<?php do_action( 'woocommerce_review_order_after_payment' ); ?>

<?php endif; ?>

<?php /* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
