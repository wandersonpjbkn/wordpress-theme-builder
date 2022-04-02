<?php
/**
 * Checkout Form
 *
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>

<!-- return to shop -->
<div class="is__flex margin__bottom--large">
	<a
		class="btn--secundary"
		href="<?= wc_get_page_permalink( 'shop' ); ?>">
		
		<strong>&#60;</strong>
	
		<span class="margin__left--small">Continuar comprando</span>
	
	</a>
</div>

<form
	name="checkout"
	method="post"
	class="checkout woocommerce-checkout"
	action="<?= esc_url( wc_get_checkout_url() ) ?>"
	enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<div
			id="customer_details"
			class="info">

			<h3 class="title__subtitle header is__theme--gray">Finalizar compra</h3>
		
			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

			<?php do_action( 'woocommerce_checkout_billing' ); ?>

			<?php do_action( 'woocommerce_checkout_shipping' ); ?>

			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

		</div>

	<?php endif; ?>
	
	<!-- @hook woocommerce_checkout_before_order_review_heading [REMOVED] -->
	<!-- do_action( 'woocommerce_checkout_before_order_review_heading' ); -->

	<div class="review">

		<h3 class="title__subtitle header is__theme--gray"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>

		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

		<?php do_action( 'woocommerce_checkout_order_review' ); ?>

		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

	</div>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<?php /* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
