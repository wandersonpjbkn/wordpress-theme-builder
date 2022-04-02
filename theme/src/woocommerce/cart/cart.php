<?php
/**
 * Cart Page
 *
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );

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

<!-- @hook woocommerce_output_all_notices -->
<?php wc_print_notices(); ?>

<!-- itens in cart  -->
<h3 class="title__subtitle">
	<?= 'Meu carrinho ( ' . WC()->cart->get_cart_contents_count() . ' )' ?>
</h3>

<div class="grid--1 grid--4-1@md">

	<!-- cart form -->
	<form
		class="woocommerce-cart-form"
		action="<?= esc_url( wc_get_cart_url() ) ?>"
		method="post">

		<!-- @hook woocommerce_before_cart_table [REMOVED] -->
		<!-- do_action( 'woocommerce_before_cart_table' ); -->

		<!-- @hook woocommerce_before_cart_contents [REMOVED] -->
		<!-- do_action( 'woocommerce_before_cart_contents' ); -->

		<table class="table">

			<thead class="is__theme--light">
			
				<tr>
					<th class="table--shrink">&nbsp;</th>
					<th><?php esc_html_e( 'Informações', 'woocommerce' ); ?></th>
					<th class="table--shrink"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
					<th class="table--shrink">Ações</th>
				</tr>

			</thead>

			<tbody>

				<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) : ?>

					<?php $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item[ 'data' ], $cart_item, $cart_item_key ); ?>

					<?php $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item[ 'product_id' ], $cart_item, $cart_item_key ); ?>

					<?php if ( $_product && $_product->exists() && $cart_item[ 'quantity' ] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) : ?>

						<?php $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key ); ?>

						<tr class="woocommerce-cart-form__cart-item <?= esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ) ?>">

							<!-- thumb -->
							<td class="thumb">
								<?php $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key ); ?>

								<?php if ( ! $product_permalink ) : ?>

									<?= $thumbnail; // PHPCS: XSS ok. ?>
								
								<?php else : ?>

									<?php printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok. ?>
								
								<?php endif; ?>
							</td>

							<!-- infos -->
							<td class="info">

								<!-- title -->
								<div
									class="margin__bottom--small"
									data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">

									<strong>

										<?php if ( ! $product_permalink ) : ?>
											
											<?=  wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' ); ?>

										<?php else : ?>

											<?= wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) ); ?>

										<?php endif; ?>
										
									</strong>

									<?php do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key ); ?>

									<!-- Meta data. -->
									<?= wc_get_formatted_cart_item_data( $cart_item ) // PHPCS: XSS ok. ?>

									<!-- Backorder notification. -->
									<?php if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) : ?>

										<?= wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) ); ?>

									<?php endif; ?>

								</div>
							
								<!-- price -->
								<div
									class="margin__bottom--small"
									data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">

									<?= apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok. ?>

								</div>
								
								<!-- quantity -->
								<div data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">

									<label>Quantidade</label>

									<?php if ( $_product->is_sold_individually() ) : ?>

										<?php $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key ); ?>

									<?php else : ?>

										<?php $product_quantity = woocommerce_quantity_input(
											array(
												'input_name'   => "cart[{$cart_item_key}][qty]",
												'input_value'  => $cart_item['quantity'],
												'max_value'    => $_product->get_max_purchase_quantity(),
												'min_value'    => '0',
												'product_name' => $_product->get_name(),
											),
											$_product,
											false
										); ?>

									<?php endif; ?>

									<?= apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok. ?>

								</div>

							</td>

							<!-- subtotal -->
							<td data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
								<?= apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok. ?>
							</td>

							<!-- actions -->
							<td class="action">
								<?= apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										'woocommerce_cart_item_remove_link',
										sprintf(
											'<a href="%s" class="btn btn--icn-delete" aria-label="%s" data-product_id="%s" data-product_sku="%s"></a>',
											esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
											esc_html__( 'Remove this item', 'woocommerce' ),
											esc_attr( $product_id ),
											esc_attr( $_product->get_sku() )
										),
										$cart_item_key
									); ?>

									<?php
										$product_id = $_product->get_id();
										$products_categories_names = htmlspecialchars(
											json_encode(
												get_current_product_category( $_product->get_id(), $_product->get_type() ),
												JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK
											)
										);
									?>

									<aside
										class="data-layer-js"
										data-id="<?= esc_attr( $product_id ) ?>"
										data-name="<?= esc_attr( $_product->get_name() ) ?>"
										data-price="<?= esc_attr( $_product->get_price() ) ?>"
										data-type="<?= esc_attr( $_product->get_type() ) ?>"
										data-category="<?= $products_categories_names ?>"
										data-quantity="<?= esc_attr( $cart_item['quantity'] ) ?>"
									></aside>
							</td>

						</tr>
						
					<?php endif; ?>

				<?php endforeach; ?>

				<!-- @hook woocommerce_cart_contents [REMOVED] -->
				<!-- do_action( 'woocommerce_cart_contents' ); -->

				<!-- update cart button -->
				<button
					type="submit"
					class="btn is__hidden update-cart"
					name="update_cart"
					value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"
				><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

				<!-- coupon MOVED to 'cart-totals.php' -->

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

			 <?php do_action( 'woocommerce_after_cart_contents' ); ?>

			</tbody>
		</table>

		<?php do_action( 'woocommerce_after_cart_table' ); ?>

	</form>

	<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

	<div class="cart-collaterals">

		<!-- Cart collaterals hook. -->
		<!-- @hooked woocommerce_cross_sell_display [REMOVED] -->
		<!-- @hooked woocommerce_cart_totals - 10 -->
		<?php do_action( 'woocommerce_cart_collaterals' ); ?>

	</div>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>

<?php /* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
