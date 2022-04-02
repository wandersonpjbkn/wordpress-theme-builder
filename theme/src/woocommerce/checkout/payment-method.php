<?php
/**
 * Output a single payment method
 *
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>

<input
	id="payment_method_<?= esc_attr( $gateway->id ) ?>"
	type="radio"
	class="input-radio"
	name="payment_method"
	value="<?= esc_attr( $gateway->id ) ?>" <?php checked( $gateway->chosen, true ); ?>
	data-order_button_text="<?= esc_attr( $gateway->order_button_text ) ?>" />

<label
	class="payment-label"
	for="payment_method_<?= esc_attr( $gateway->id ) ?>">

	<?= $gateway->get_title() /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?><!-- [REMOVED WooCommerce icon] -->

</label>

<?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>

	<div
		class="payment_box payment_method_<?= esc_attr( $gateway->id ) ?>"
		<?php if ( ! $gateway->chosen ) : /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>style="display:none;"<?php endif; /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>>
		
		<?php $gateway->payment_fields(); ?>
	
	</div>

<?php endif; ?>
