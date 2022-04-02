<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

$invalid_order_status = array( 'failed', 'cancelled', 'refunded' );
$order_status = $order->get_status();
$notes = $order->get_customer_order_notes();

// Loop over all order notes if order was not cancelled
if ( ! in_array( $order_status, $invalid_order_status ) ) {
	$order_status = get_delivery_steps_order_status( $order_status, get_private_order_notes( $order->get_id() ) );
	$steps = get_delivery_steps();
	$step_is_processing = false;
	$times = 0;
}

?>

<!-- Order table details -->
<?php do_action( 'woocommerce_view_order', $order_id ); ?>

<!-- Timeline -->
<?php if ( ! in_array( $order_status, $invalid_order_status ) ) : ?>
	<div class="timeline text__center margin__bottom--medium">

		<?php foreach ( $steps as $step_key => $step_value ) : ?>

			<?php $step_is_done = false; ?>

			<?php if ( ! $step_is_processing ) { $step_is_done = ! $step_is_done; $step_is_processing = $order_status === $step_key; } ?>

			<div class="timeline__step is__flex <?= esc_attr( $step_is_done ? 'done' : '' ) ?>">

				<div class="timeline__icn center">
					<span class="btn btn--icn-<?= esc_html( $step_value[ 'icn' ] ) ?>"></span>
				</div>

				<label class="timeline__label">
					<?= esc_html( $step_value[ 'value' ] ) ?>
				</label>

			</div>

			<?php if ( count( $steps ) != ++$times ) : ?>

				<div class="timeline__progress <?= esc_attr( $step_is_processing ? '' : 'done' ) ?>"></div>

			<?php endif; ?>

		<?php endforeach; ?>

	</div>
<?php endif; ?>

<!-- Order notes -->
<?php if ( $notes ) : ?>
	<h2 class="title__subtitle margin__top--medium">
		<?= esc_html_e( 'Order updates', 'woocommerce' ) ?>
	</h2>

	<dl
		class="dl backwards js-toggle"
		style="counter-reset:dl-counter <?= esc_attr( count( $notes ) + 1 ) ?>">

		<?php foreach ( array_reverse( $notes ) as $note ) : ?>

			<!-- gen randon id key -->
			<?php $key = 'i' . uniqid(); ?>

			<!-- date -->
			<dt
				class="toggle"
				data-toggle="<?= esc_attr( $key ) ?>"
			><?= wp_date( 'l j \d\e F Y, H:i', strtotime( '-3 hours', strtotime( $note->comment_date ) ) ) ?></dt>

			<!-- note -->
			<dd id="<?= esc_attr( $key ) ?>">
				<?= wpautop( wptexturize( $note->comment_content ) ) ?>
			</dd>

		<?php endforeach; ?>

	</dl>
<?php endif; ?>

<div class="margin__top--medium">
	<h2 class="title__subtitle">Trocas e Devoluções</h2>
	<p>
		<a
			href="<?= esc_url( home_url( '/' ) . 'troca-e-devolucao' ) ?>"
			class="login-logout"
		>Clique aqui</a> se deseja realizar uma <strong>troca</strong> ou <strong>devolução</strong>
	</p>
</div>
