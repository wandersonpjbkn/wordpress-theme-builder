<?php
/**
 * Single Product Price
 *
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$sale_price = (float)$product->get_sale_price() > 0
  ? (float)$product->get_sale_price()
  : (float)$product->get_regular_price();

$has_quota = $sale_price >= 200;

?>

<?php if ( $product->is_type( 'variable' ) ) : ?>

	<?php $price = (float)$product->get_variation_sale_price(); ?>

	<p class="title__price">
		<small>a partir de</small>
		<?= wc_price( $price ) ?>
	</p>

<?php else : ?>

	<p class="title__price">
		<?= $product->get_price_html() ?>
	</p>

<?php endif; ?>

<?php if ( $has_quota ) : ?>

	<div class="quota">
		<?= get_product_quota( $sale_price, false ) ?>
	</div>

<?php endif; ?>

<div class="divider is__theme--meta"></div>
