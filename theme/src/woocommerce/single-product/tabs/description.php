<?php
/**
 * Description tab
 *
 * @package WooCommerce/Templates
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $post;

$heading = apply_filters( 'woocommerce_product_description_heading', __( 'Description', 'woocommerce' ) );

?>

<?php if ( $heading ) : ?>

<h2 class="is__hidden"><?= esc_html( $heading ); ?></h2>

<?php endif; ?>

<?php the_content(); ?>
