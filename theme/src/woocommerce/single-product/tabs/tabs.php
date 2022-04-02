<?php
/**
 * Single Product tabs
 *
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

?>

<!-- Filter tabs and allow third parties to add their own. -->
<!-- Each tab is an array containing title, callback and priority. -->
<!-- @see woocommerce_default_product_tabs() -->
<?php $product_tabs = apply_filters( 'woocommerce_product_tabs', array() ); ?>

<?php if ( ! empty( $product_tabs ) ) : ?>

	<div class="woocommerce-tabs wc-tabs-wrapper">

		<ul
			class="wc-tabs nav tab"
			role="tablist">

			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>

				<li
					class="<?= esc_attr( $key ) ?>_tab"
					id="tab-title-<?= esc_attr( $key ) ?>"
					role="tab"
					aria-controls="tab-<?= esc_attr( $key ) ?>">
					
					<a href="#tab-<?= esc_attr( $key ) ?>">

						<?= wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab[ 'title' ], $key ) ) ?>

					</a>

				</li>

			<?php endforeach; ?>

		</ul>

		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>

			<div
				class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?= esc_attr( $key ) ?> panel entry-content wc-tab"
				id="tab-<?= esc_attr( $key ) ?>"
				role="tabpanel"
				aria-labelledby="tab-title-<?= esc_attr( $key ) ?>">
				
				<?php if ( isset( $product_tab[ 'callback' ] ) ) : ?>

					<?php call_user_func( $product_tab[ 'callback' ], $key, $product_tab ); ?>

				<?php endif; ?>

			</div>

		<?php endforeach; ?>

		<?php do_action( 'woocommerce_product_after_tabs' ); ?>

	</div>

<?php endif; ?>
