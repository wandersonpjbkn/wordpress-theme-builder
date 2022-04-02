<?php
/**
 * Order details
 *
 * @package WooCommerce/Templates
 * @version 4.6.0
 */

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id );

if ( ! $order )
	return;

$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

if ( $show_downloads ) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}
?>

<section class="woocommerce-order-details">

	<?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>

	<h2 class="title__subtitle"><?php esc_html_e( 'Order details', 'woocommerce' ); ?></h2>

	<table class="table">

		<thead>
			<tr>
				<th><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
				<th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			</tr>
		</thead>

		<tbody>

			<?php do_action( 'woocommerce_order_details_before_order_table_items', $order ); ?>

			<?php foreach( $order_items as $item_id => $item ) : ?>

				<?php $product = $item->get_product(); ?>

				<?php wc_get_template(
					'order/order-details-item.php',
					array(
						'order'              => $order,
						'item_id'            => $item_id,
						'item'               => $item,
						'show_purchase_note' => $show_purchase_note,
						'purchase_note'      => $product ? $product->get_purchase_note() : '',
						'product'            => $product,
					)
				); ?>
			
			<?php endforeach; ?>

			<?php do_action( 'woocommerce_order_details_after_order_table_items', $order ); ?>

		</tbody>

		<tfoot>

			<?php foreach ( $order->get_order_item_totals() as $key => $total ) : ?>

				<tr>
					<th><?= esc_html( $total['label'] ); ?></th>
					<td><?= ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : wp_kses_post( $total['value'] ) ?></td>
				</tr>

			<?php endforeach; ?>

			<?php if ( $order->get_customer_note() ) : ?>

				<tr>
					<th><?= esc_html_e( 'Note:', 'woocommerce' ) ?></th>
					<td><?= wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
				</tr>

			<?php endif; ?>

		</tfoot>

	</table>

	<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>

</section>

<!-- Action hook fired after the order details. -->
<!-- @since 4.4.0 -->
<!-- @param WC_Order $order Order data. -->
<?php do_action( 'woocommerce_after_order_details', $order ); ?>

<?php if ( $show_customer_details ) : ?>
	<?php wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) ); ?>
<?php endif; ?>

<?php /* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
