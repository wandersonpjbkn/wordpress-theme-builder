<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * @package     WooCommerce/Templates
 * @version     4.4.0
 */

defined( 'ABSPATH' ) || exit;

?>

<!-- gretting -->
<p class="margin__bottom--medium">
	<?php printf(
		'Olá %1$s <small>(não é você? <a href="%2$s">sair</a>)</small>',
		'<strong>' . esc_html( $current_user->display_name ) . '</strong>',
		esc_url( wc_logout_url() )
	); ?>
</p>

<div class="grid--1 grid--2@md">

	<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>

		<!-- < ?php if ( 'customer-logout' != $endpoint ) : ?> -->

			<a
				class="card-account is__flex is__vertical"
				href="<?= esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">

				<span class="btn--icn-<?= esc_attr( $endpoint ) ?>"></span>

				<span><?= esc_html( $label ); ?></span>

			</a>

		<!-- < ?php endif; ?> -->

	<?php endforeach; ?>

</div>

<!-- My Account dashboard. -->
<!-- @since 2.6.0 -->

<?php do_action( 'woocommerce_account_dashboard' ); ?>

<!-- Deprecated woocommerce_before_my_account action. -->
<!-- @deprecated 2.6.0 -->
<?php do_action( 'woocommerce_before_my_account' ); ?>

<!-- Deprecated woocommerce_after_my_account action. -->
<!-- @deprecated 2.6.0 -->
<?php do_action( 'woocommerce_after_my_account' ); ?>

<?php /* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
