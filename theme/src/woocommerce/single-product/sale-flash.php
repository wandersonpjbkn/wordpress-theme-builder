<?php
/**
 * Single Product Sale Flash
 *
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

defined( 'ABSPATH' ) || exit;

global $post, $product;

?>

<?php if ( $product->is_on_sale() ) : ?>

	<?= apply_filters( 'woocommerce_sale_flash', '<div class="label is__theme--dark"><span>' . esc_html__( 'Sale', 'woocommerce' ) . '</span></div>', $post, $product ) ?>

<?php endif; ?>

<?php /* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
