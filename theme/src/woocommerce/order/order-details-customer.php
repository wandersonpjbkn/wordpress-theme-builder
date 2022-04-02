<?php
/**
 * Order Customer Details
 *
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

defined( 'ABSPATH' ) || exit;

$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();

?>

<section class="section__medium">

	<div class="grid--1 <?= esc_attr( $show_shipping ? 'grid--2@md' : '' ) ?>">
	
		<div class="card-account is__flex is__vertical">

			<h2 class="title__subtitle"><?php esc_html_e( 'Billing address', 'woocommerce' ); ?></h2>

			<address>
				<?= wp_kses_post( $order->get_formatted_billing_address( esc_html__( 'N/A', 'woocommerce' ) ) ) ?>

				<?php if ( $order->get_billing_phone() ) : ?>
					<p><?= esc_html( $order->get_billing_phone() ) ?></p>
				<?php endif; ?>

				<?php if ( $order->get_billing_email() ) : ?>
					<p><?= esc_html( $order->get_billing_email() ) ?></p>
				<?php endif; ?>
			</address>

		</div>

		<?php if ( $show_shipping ) : ?>
			<div class="card-account is__flex is__vertical">

				<h2 class="title__subtitle"><?php esc_html_e( 'Shipping address', 'woocommerce' ); ?></h2>

				<address>
					<?= wp_kses_post( $order->get_formatted_shipping_address( esc_html__( 'N/A', 'woocommerce' ) ) ) ?>
				</address>

			</div>
		<?php endif; ?>

	</section>

	<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>

</section>
