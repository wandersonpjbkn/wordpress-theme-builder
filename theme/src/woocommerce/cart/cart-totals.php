<?php
/**
 * Cart totals
 *
 * @package WooCommerce/Templates
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

$GLOBALS[ 'available_methods_varification' ] = '';

?>

<div class="cart_totals is__theme--gray <?= ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : '' ?>">

	<!-- @hook woocommerce_before_cart_totals [REMOVED] -->
	<!-- do_action( 'woocommerce_before_cart_totals' ); -->

	<!-- title -->
	<h3 class="title__subtitle">Resumo da compra</h3>

	<!-- cart-totals -->
	<table class="table">

		<!-- shipping html / calculator -->
		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<!-- @hook woocommerce_cart_totals_before_shipping [REMOVED] -->
			<!-- do_action( 'woocommerce_cart_totals_before_shipping' ); -->

			<?php wc_cart_totals_shipping_html(); ?>

			<!-- @hook woocommerce_cart_totals_after_shipping [REMOVED] -->
			<!-- do_action( 'woocommerce_cart_totals_after_shipping' ); -->

		<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

			<tr class="shipping">
				<td
					data-title="<?php esc_attr_e( 'Shipping', 'woocommerce' ); ?>"
					colspan="2"
				><?php woocommerce_shipping_calculator(); ?></td>
			</tr>

		<?php endif; ?>

		<!-- add coupon -->
		<?php if ( wc_coupons_enabled() ) : ?>

			<tr class="coupon">
				<td colspan="2">

					<form
						action="<?= esc_url( wc_get_cart_url() ) ?>"
						method="post">

						<label for="coupon_code">Cupom de desconto</label>

						<input	
							type="text"
							name="coupon_code"
							class="input-text input"
							id="coupon_code"
							value=""
							placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" />
							
						<button	
							type="submit"
							class="btn"
							name="apply_coupon"
							value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"
						>Aplicar</button>

					</form>

					<?php do_action( 'woocommerce_cart_coupon' ); ?>

				</td>
			</tr>

		<?php endif; ?>

		<!-- subtotal -->
		<tr class="cart-subtotal">
			<th><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
			<td data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>"><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<!-- coupon -->
		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?= esc_attr( sanitize_title( $code ) ) ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td data-title="<?= esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ) ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<!-- discount -->
		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<th><?= esc_html( $fee->name ) ?></th>
				<td data-title="<?= esc_attr( $fee->name ) ?>"><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<!-- tax -->
		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
		
			<?php $taxable_address = WC()->customer->get_taxable_address(); ?>
			<?php $estimated_text  = ''; ?>

				<?php if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) : ?>
					
					<?php $estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] ); ?>

				<?php endif; ?>

				<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>

					<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) :  // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited ?>
						<tr class="tax-rate tax-rate-<?= esc_attr( sanitize_title( $code ) ) ?>">
							<th><?= esc_html( $tax->label ) . $estimated_text // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
							<td data-title="<?= esc_attr( $tax->label ) ?>"><?= wp_kses_post( $tax->formatted_amount ) ?></td>
						</tr>
					<?php endforeach; ?>

				<?php else : ?>

					<tr class="tax-total">
						<th><?= esc_html( WC()->countries->tax_or_vat() ) . $estimated_text // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
						<td data-title="<?= esc_attr( WC()->countries->tax_or_vat() ) ?>"><?php wc_cart_totals_taxes_total_html(); ?></td>
					</tr>

				<?php endif; ?>

		<?php endif; ?>

		<!-- @hook woocommerce_cart_totals_before_order_total [REMOVED] -->
		<!-- do_action( 'woocommerce_cart_totals_before_order_total' ); -->

		<!-- shipping -->
		<tr class="cart-shipping">
			<th>Frete</th>
			<td>
				<?php if ( 0 <= WC()->cart->get_shipping_total() && WC()->customer->has_calculated_shipping() ) : ?>

					<?php if ( ! empty( $GLOBALS[ 'available_methods_varification' ] ) ) : ?>
					
						<span><?= $GLOBALS[ 'available_methods_varification' ] ?></span>
						
					<?php else : ?>
					
						<?= WC()->cart->get_cart_shipping_total(); ?>

					<?php endif; ?>

				<?php elseif( 0 == WC()->cart->get_shipping_total() && WC()->customer->has_calculated_shipping() ) : ?>

					<span>FRETE GRÁTIS</span>

				<?php else : ?>

					<span>À calcular</span>
					
				<?php endif; ?>
			</td>
		</tr>

		<!-- total -->
		<tr class="order-total">
			<th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			<td data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<!-- @hook woocommerce_cart_totals_after_order_total -->
		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	</table>

	<div class="wc-proceed-to-checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<div class="blockUI blockOverlay on-update"></div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
