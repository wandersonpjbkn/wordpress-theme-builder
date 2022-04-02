<?php
/**
 * Review order table
 *
 * @package WooCommerce/Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="grid--1 grid--4-1@md review-order woocommerce-checkout-review-order-table">

	<table class="table details">

		<thead>

			<tr>

				<th><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>

				<th class="table--shrink"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>

			</tr>

		</thead>

		<tbody>

			<?php do_action( 'woocommerce_review_order_before_cart_contents' ); ?>

			<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) : ?>
			
				<?php $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key ); ?>

				<?php if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) : ?>

					<?php
						$product_id = $_product->get_id();
						$products_categories_names = htmlspecialchars(
							json_encode(
								get_current_product_category( $product_id, $_product->get_type() ),
								JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK
							)
						);
					?>

					<tr class="<?= esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ) ?>">

						<td
							class="data-layer-js product-name"
							data-id="<?= esc_attr( $product_id ) ?>"
							data-name="<?= esc_attr( $_product->get_name() ) ?>"
							data-price="<?= esc_attr( $_product->get_price() ) ?>"
							data-type="<?= esc_attr( $_product->get_type() ) ?>"
							data-category="<?= $products_categories_names ?>"
							data-quantity="<?= esc_attr( $cart_item['quantity'] ) ?>">

							<?= apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?= apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?= wc_get_formatted_cart_item_data( $cart_item ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						
						</td>

						<td class="product-total">

							<?= apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						
						</td>

					</tr>

				<?php endif; ?>
				
				<?php endforeach; ?>

			<?php do_action( 'woocommerce_review_order_after_cart_contents' ); ?>

		</tbody>

	</table>

	<div class="subtotal is__theme--light">
		<table class="table">

			<tbody>

				<!-- shipping -->
				<?php if ( WC()->cart->needs_shipping() ) : ?>

					<?php if ( WC()->cart->show_shipping() ) : ?>

						<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

						<?php wc_cart_totals_shipping_html(); ?>

						<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

					<?php else : ?>

						<tr class="woocommerce-shipping-totals">
							<td colspan="2">
								<h4 class="title__subtitle">Frete</h4>
								<p>Digite seu endereço para ver as opções de entrega. </p>
							</td>
						</tr>

					<?php endif; ?>

				<?php endif; ?>

				<!-- subtotal -->
				<tr class="cart-subtotal">

					<th><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>

					<td><?php wc_cart_totals_subtotal_html(); ?></td>

				</tr>

				<!-- coupon -->
				<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>

					<tr class="cart-discount coupon-<?= esc_attr( sanitize_title( $code ) ) ?>">

						<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>

						<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>

					</tr>

				<?php endforeach; ?>

				<!-- discount -->
				<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>

					<tr class="fee">

						<th><?= esc_html( $fee->name ) ?></th>

						<td><?php wc_cart_totals_fee_html( $fee ); ?></td>

					</tr>

				<?php endforeach; ?>

				<!-- tax -->
				<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>

					<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>

						<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited ?>

							<tr class="tax-rate tax-rate-<?= esc_attr( sanitize_title( $code ) ) ?>">

								<th><?= esc_html( $tax->label ) ?></th>

								<td><?= wp_kses_post( $tax->formatted_amount ) ?></td>

							</tr>

						<?php endforeach; ?>

					<?php else : ?>

						<tr class="tax-total">

							<th><?= esc_html( WC()->countries->tax_or_vat() ) ?></th>

							<td><?php wc_cart_totals_taxes_total_html(); ?></td>

						</tr>

					<?php endif; ?>

				<?php endif; ?>

				<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

				<!-- total -->
				<tr class="order-total">

					<th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>

					<td><?php wc_cart_totals_order_total_html(); ?></td>

				</tr>

				<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

			</tbody>

		</table>
	</div>

</div>
