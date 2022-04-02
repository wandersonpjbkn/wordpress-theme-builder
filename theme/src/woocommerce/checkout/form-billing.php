<?php
/**
 * Checkout billing information form
 *
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="woocommerce-billing-fields">

	<!-- REMOVED title -->

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<div class="woocommerce-billing-fields__field-wrapper is__flex">

		<?php $fields = $checkout->get_checkout_fields( 'billing' ); ?>

		<?php foreach ( $fields as $key => $field ) : ?>

			<?php if ( isset( $field[ 'country_field' ], $fields[ $field[ 'country_field' ] ] ) ) : ?>

				<?php $field[ 'country' ] = $checkout->get_value( $field[ 'country_field' ] ); ?>

			<?php endif; ?>

			<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
	
		<?php endforeach; ?>

	</div>

	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>

</div>

<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>

	<div class="woocommerce-account-fields margin__bottom--medium col--1 is__theme--light">

		<?php if ( ! $checkout->is_registration_required() ) : ?>

			<p class="create-account">

				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">

					<input
						class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
						id="createaccount"
						<?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ); ?>
						type="checkbox"
						name="createaccount"
						value="1"
					/><span><?php esc_html_e( 'Create an account?', 'woocommerce' ); ?></span>
				
				</label>

			</p>

		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

			<div class="create-account">

				<?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>

					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

				<?php endforeach; ?>

			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>

	</div>
	
<?php endif; ?>
