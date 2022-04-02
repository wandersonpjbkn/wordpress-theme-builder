<?php
/**
 * My Addresses
 *
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __( 'Billing address', 'woocommerce' ),
			'shipping' => __( 'Shipping address', 'woocommerce' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __( 'Billing address', 'woocommerce' ),
		),
		$customer_id
	);
}

$count = count( $get_addresses );

?>

<p class="margin__bottom--medium">
	<?= apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'woocommerce' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</p>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>

	<div class="grid--1 <?= esc_attr( $count != 1 ? 'grid--2@md' : '' ) ?>">

<?php endif; ?>

<?php foreach ( $get_addresses as $name => $address_title ) : ?>

	<?php $address = wc_get_account_formatted_address( $name ); ?>

	<a
		class="card-account is__flex is__vertical"
		href="<?= esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>">

		<header>
			<h3><?= esc_html( $address_title ) ?></h3>
		</header>

		<address>
			<?= $address ? wp_kses_post( $address ) : esc_html_e( 'You have not set up this type of address yet.', 'woocommerce' ) ?>
		</address>

		<button
			class="btn--success center"
		><?= $address ? esc_html__( 'Edit', 'woocommerce' ) : esc_html__( 'Add', 'woocommerce' ) ?></button>

	</a>

<?php endforeach; ?>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>

	</div>

<?php endif; ?>

<?php /* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
