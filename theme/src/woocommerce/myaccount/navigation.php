<?php
/**
 * My Account navigation
 *
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

defined( 'ABSPATH' ) || exit;

?>

<?php do_action( 'woocommerce_before_account_navigation' ); ?>

<nav class="nav login is__vertical is__theme--light">

	<ul>
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>

			<li class="<?= wc_get_account_menu_item_classes( $endpoint ); ?>">

				<a
					class="btn--icn-<?= esc_attr( $endpoint ) ?>"
					href="<?= esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"
				><span><?= esc_html( $label ); ?></span></a>

			</li>

		<?php endforeach; ?>
	</ul>

</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
