<?php
/**
 * Order Item Details
 *
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
	return;
}
?>

<tr class="<?= esc_attr( apply_filters( 'woocommerce_order_item_class', 'woocommerce-table__line-item order_item', $item, $order ) ) ?>">

	<td class="woocommerce-table__product-name product-name">

		<?php $is_visible = $product && $product->is_visible(); ?>
		<?php $product_permalink = apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $order ); ?>

		<?= apply_filters( 'woocommerce_order_item_name', $product_permalink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $item->get_name() ) : $item->get_name(), $item, $is_visible ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

		<?php $qty = $item->get_quantity(); ?>
		<?php $refunded_qty = $order->get_qty_refunded_for_item( $item_id ); ?>

		<?php if ( $refunded_qty ) : ?>

			<?php $qty_display = '<del>' . esc_html( $qty ) . '</del> <ins>' . esc_html( $qty - ( $refunded_qty * -1 ) ) . '</ins>'; ?>
			
		<?php else : ?>

			<?php $qty_display = esc_html( $qty ); ?>

		<?php endif; ?>

		<?= apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $qty_display ) . '</strong>', $item ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

		<?php do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false ); ?>

		<?php wc_display_item_meta( $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

		<?php do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false ); ?>

		<?php
			$product_id = $product->get_id();
			$products_categories_names = htmlspecialchars(
				json_encode(
					get_current_product_category( $product->get_id(), $product->get_type() ),
					JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK
				)
			);
		?>

		<aside
			class="data-layer-js"
			data-id="<?= esc_attr( $product_id ) ?>"
			data-name="<?= esc_attr( $product->get_name() ) ?>"
			data-price="<?= esc_attr( $product->get_price() ) ?>"
			data-type="<?= esc_attr( $product->get_type() ) ?>"
			data-category="<?= $products_categories_names ?>"
			data-quantity="<?= esc_attr( $qty_display ) ?>"
		></aside>

	</td>

	<td class="woocommerce-table__product-total product-total">
		<?= $order->get_formatted_line_subtotal( $item ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</td>

</tr>

<?php if ( $show_purchase_note && $purchase_note ) : ?>

<tr class="woocommerce-table__product-purchase-note product-purchase-note">
	<td colspan="2">

		<?= wpautop( do_shortcode( wp_kses_post( $purchase_note ) ) ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	
	</td>
</tr>

<?php endif; ?>
