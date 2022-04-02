<?php
/**
 * Edit account form
 *
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>

<?php do_action( 'woocommerce_before_edit_account_form' ); ?>

<form
	class="woocommerce-EditAccountForm edit-account is__flex"
	action=""
	method="post"
	<?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

	<p class="woocommerce-form-row woocommerce-form-row--first col--1 col--1-2@md">

		<label
			for="account_first_name"
			class="screen-reader-text"
		><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		
		<input
			type="text"
			class="woocommerce-Input woocommerce-Input--text input-text"
			name="account_first_name"
			id="account_first_name"
			autocomplete="given-name"
			placeholder="Nome"
			required
			value="<?= esc_attr( $user->first_name ) ?>" />
	
	</p>

	<p class="woocommerce-form-row woocommerce-form-row--last col--1 col--1-2@md">

		<label
			for="account_last_name"
			class="screen-reader-text"
		><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>

		<input
			type="text"
			class="woocommerce-Input woocommerce-Input--text input-text"
			name="account_last_name"
			id="account_last_name"
			autocomplete="family-name"
			placeholder="Sobrenome"
			required
			value="<?= esc_attr( $user->last_name ) ?>" />

	</p>

	<p class="woocommerce-form-row woocommerce-form-row--wide col--1">

		<label
			for="account_display_name"
			class="screen-reader-text"
		><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>

		<input
			type="text"
			class="woocommerce-Input woocommerce-Input--text input-text margin__bottom--small"
			name="account_display_name"
			id="account_display_name"
			placeholder="Nome de exibição"
			required
			value="<?= esc_attr( $user->display_name ) ?>" />
			
			<span>
				<em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em>
			</span>

	</p>

	<p class="woocommerce-form-row woocommerce-form-row--wide col--1">

		<label
			for="account_email"
			class="screen-reader-text"
		><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>

		<input
			type="email"
			class="woocommerce-Input woocommerce-Input--email input-text"
			name="account_email"
			id="account_email"
			autocomplete="email"
			placeholder="E-mail"
			required
			value="<?=esc_attr( $user->user_email ); ?>" />

	</p>

	<fieldset class="margin__top--medium col--1">

		<legend><?php esc_html_e( 'Password change', 'woocommerce' ); ?></legend>

		<p class="woocommerce-form-row woocommerce-form-row--wide col--1">

			<label
				for="password_current"
				class="screen-reader-text"
			><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>

			<input
				type="password"
				class="woocommerce-Input woocommerce-Input--password input-text"
				name="password_current"
				id="password_current"
				placeholder="<?= esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ) ?>"
				autocomplete="off" />

		</p>

		<p class="woocommerce-form-row woocommerce-form-row--wide col--1">

			<label
				for="password_1"
				class="screen-reader-text"
			><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>

			<input
				type="password"
				class="woocommerce-Input woocommerce-Input--password input-text"
				name="password_1"
				id="password_1"
				placeholder="<?= esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ) ?>"
				autocomplete="off" />

		</p>

		<p class="woocommerce-form-row woocommerce-form-row--wide col--1">

			<label
				for="password_2"
				class="screen-reader-text"
			><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>

			<input
				type="password"
				class="woocommerce-Input woocommerce-Input--password input-text"
				name="password_2"
				id="password_2"
				placeholder="<?= esc_html_e( 'Confirm new password', 'woocommerce' ) ?>"
				autocomplete="off" />

		</p>

	</fieldset>
	
	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p class="margin__bottom--medium col--1">

		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>

		<button
			type="submit"
			class="woocommerce-Button button"
			name="save_account_details"
			value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"
		><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>

		<input
			type="hidden"
			name="action"
			value="save_account_details" />

	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>

</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
