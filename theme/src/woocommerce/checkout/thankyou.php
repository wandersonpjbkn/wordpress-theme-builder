<?php
/**
 * Thankyou page
 *
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="woocommerce-order">

	<?php if ( $order ) : do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed">
				<?= esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ) ?>
			</p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">

				<a
					href="<?= esc_url( $order->get_checkout_payment_url() ) ?>"
					class="button pay">
					
					<?= esc_html_e( 'Pay', 'woocommerce' ) ?>
					
				</a>

				<?php if ( is_user_logged_in() ) : ?>

					<a
						href="<?= esc_url( wc_get_page_permalink( 'myaccount' ) ) ?>"
						class="button pay">
						
						<?= esc_html_e( 'My account', 'woocommerce' ) ?>
						
					</a>

				<?php endif; ?>

			</p>

		<?php else : ?>

			<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received margin__bottom--large">
				<?= apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), $order ) ?>
			</p>

			<ul
				class="data-layer-order-js woocommerce-order-overview woocommerce-thankyou-order-details order_details"
				data-order-id="<?= $order->get_order_number() ?>"
				data-revenue="<?= $order->get_total() ?>"
				data-tax="<?= $order->get_total_tax() ?>"
				data-shipping="<?= $order->get_shipping_total() ?>">

				<li class="woocommerce-order-overview__order order margin__bottom--small">
					<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
					<strong><?= $order->get_order_number() ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date margin__bottom--small">
					<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
					<strong><?= wc_format_datetime( $order->get_date_created() ) ?></strong>
				</li>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email margin__bottom--small">
						<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
						<strong><?= $order->get_billing_email() ?></strong>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total total margin__bottom--small">
					<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
					<strong><?= $order->get_formatted_order_total() ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method margin__bottom--small">
						<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
						<strong><?= wp_kses_post( $order->get_payment_method_title() ) ?></strong>
					</li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
			<?= apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ) ?>
		</p>

	<?php endif; ?>

</div>
