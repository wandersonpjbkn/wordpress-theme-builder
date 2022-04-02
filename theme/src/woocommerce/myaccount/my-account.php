<?php
/**
 * My Account page
 *
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>

<h3 class="title__subtitle margin__bottom--medium is__flex">
	<a href="<?= get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ?>">Minha Conta</a>
	<span class="text__meta">|</span>
	<span class="text__meta"><?= esc_html( get_page_account_title() ); ?></span>
</h3>

<div class="grid--1 grid--1-4@md">
	
	<!-- My Account navigation. -->
	<!-- @since 2.6.0 -->
	<?php do_action( 'woocommerce_account_navigation' ); ?>
	
	<div style="overflow-x: auto;">
		<!-- My Account content. -->
		<!-- @since 2.6.0 -->
		<?php do_action( 'woocommerce_account_content' ); ?>
	</div>

</div>
