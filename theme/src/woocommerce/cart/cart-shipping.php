<?php
/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

$formatted_destination = isset( $formatted_destination ) ? $formatted_destination : WC()->countries->get_formatted_address( $package[ 'destination' ], ', ' );
$has_calculated_shipping = ! empty( $has_calculated_shipping );
$show_shipping_calculator = ! empty( $show_shipping_calculator );
$calculator_text = '';

?>

<tr class="woocommerce-shipping-totals shipping">
	<td
		colspan="2"
		data-title="<?= esc_attr( $package_name ) ?>">

		<?php if ( is_checkout() ) : ?>

			<h4 class="title__subtitle">Frete</h4>

		<?php endif; ?>

		<?php if ( $available_methods ) : ?>

			<!-- custom variable -->
			<?php $GLOBALS['available_methods_varification'] = ''; ?>

			<ul
				id="shipping_method"
				class="woocommerce-shipping-methods">

				<?php foreach ( $available_methods as $method ) : ?>

					<li>

						<?php if ( 1 < count( $available_methods ) ) : ?>

							<?php printf(
								'<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" %4$s />',
								$index,
								esc_attr( sanitize_title( $method->id ) ),
								esc_attr( $method->id ),
								checked( $method->id, $chosen_method, false )
							); // WPCS: XSS ok. ?>

						<?php else : ?>

							<?php printf(
								'<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />',
								$index,
								esc_attr( sanitize_title( $method->id ) ),
								esc_attr( $method->id )
							); // WPCS: XSS ok. ?>

						<?php endif; ?>

						<?php printf(
							'<label for="shipping_method_%1$s_%2$s">%3$s</label>',
							$index,
							esc_attr( sanitize_title( $method->id ) ),
							wc_cart_totals_shipping_method_label( $method )
						); // WPCS: XSS ok. ?>

						<?php do_action( 'woocommerce_after_shipping_rate', $method, $index ); ?>

					</li>

				<?php endforeach; ?>

			</ul>

			<!-- REMOVED woocommerce-shipping-destination -->

		<?php elseif ( ! $has_calculated_shipping || ! $formatted_destination ) : ?>

			<?php if ( is_cart() && 'no' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

				<!-- custom variable -->
				<?php $GLOBALS['available_methods_varification'] = 'Frete é calculado no checkout'; ?>

				<?= wp_kses_post( apply_filters( 'woocommerce_shipping_not_enabled_on_cart_html', __( 'Shipping costs are calculated during checkout.', 'woocommerce' ) ) ) ?>

			<?php else : ?>

				<!-- custom variable -->
				<?php $GLOBALS['available_methods_varification'] = 'Informe o CEP antes'; ?>

				<?= wp_kses_post( apply_filters( 'woocommerce_shipping_may_be_available_html', __( 'Enter your address to view shipping options.', 'woocommerce' ) ) ) ?>

			<?php endif; ?>

		<?php elseif ( ! is_cart() ) : ?>

			<!-- custom variable -->
			<?php $GLOBALS['available_methods_varification'] = 'CEP inválido'; ?>

			<?= wp_kses_post( apply_filters( 'woocommerce_no_shipping_available_html', __( 'There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woocommerce' ) ) ) ?>

		<?php else : ?>

			<!-- custom variable -->
			<?php $GLOBALS['available_methods_varification'] = 'CEP inválido'; ?>

			<?= wp_kses_post( apply_filters( 'woocommerce_cart_no_shipping_available_html', sprintf( esc_html__( 'No shipping options were found for %s.', 'woocommerce' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' ) ) ) ?>

			<?php $calculator_text = esc_html__( 'Enter a different address', 'woocommerce' ); ?>

		<?php endif; ?>

		<?php if ( $show_package_details ) : ?>

			<?= '<p class="woocommerce-shipping-contents"><small>' . esc_html( $package_details ) . '</small></p>' ?>

		<?php endif; ?>

		<?php if ( $show_shipping_calculator ) : ?>

			<?php woocommerce_shipping_calculator( $calculator_text ); ?>

		<?php endif; ?>

	</td>
</tr>
