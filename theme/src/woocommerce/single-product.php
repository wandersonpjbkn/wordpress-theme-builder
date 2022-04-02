<?php
/**
 * Single products
 * 
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

defined( 'ABSPATH' ) || exit;

?>

<?php get_header( 'shop' ); ?>

<main>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php wc_get_template_part( 'content', 'single-product' ); ?>

	<?php endwhile; ?>

</main>

<?php get_footer( 'shop' );
