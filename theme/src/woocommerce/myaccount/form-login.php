<?php
/**
 * Login Form
 *
 * @package WooCommerce/Templates
 * @version 4.1.0
 */

defined( 'ABSPATH' ) || exit;

?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="is__flex">

	<div class="col--3-5@md col--1 center">

		<!-- enable two columns if register actived -->
		<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

		<div class="js-tabs">

			<ul
				id="customer_login"
				class="nav tab">
				
				<li>

					<button
						class="link tab-btn"
						data-target="tab-login">Login</a>

				</li>
				
				<li>

					<button
						class="link tab-btn"
						data-target="tab-register">Registro</a>

				</li>

			</ul>

			<div
				id="tab-login"
				class="tab-target">

		<?php endif; ?>

				<!-- login form -->
				<form
					class="woocommerce-form woocommerce-form-login"
					method="post">

					<?php do_action( 'woocommerce_login_form_start' ); ?>

					<!-- username -->
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						
						<label
							for="username"
							class="screen-reader-text"
						><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?></label>
					
						<input
							type="text"
							class="woocommerce-Input woocommerce-Input--text input-text input"
							name="username"
							id="username"
							placeholder="Nome de usuário ou e-mail"
							autocomplete="username"
							required
							value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
							
						<?php // @codingStandardsIgnoreLine ?>
					
					</p>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						
						<label
							for="password"
							class="screen-reader-text"
						><?php esc_html_e( 'Password', 'woocommerce' ); ?></label>
						
						<input
							class="woocommerce-Input woocommerce-Input--text input-text input"
							type="password"
							name="password"
							id="password"
							placeholder="Senha"
							required
							autocomplete="current-password" />
					
					</p>

					<?php do_action( 'woocommerce_login_form' ); ?>

					<!-- remember checkbox -->
					<p class="form-row action">

						<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
						
						<button 
							type="submit"
							class="woocommerce-button btn--success woocommerce-form-login__submit"
							name="login"
							value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"
						><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>

						<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">

							<input
								class="woocommerce-form__input woocommerce-form__input-checkbox"
								name="rememberme"
								type="checkbox"
								id="rememberme"
								value="forever" /><span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>

						</label>
					
					</p>
					
					<p class="woocommerce-LostPassword lost_password margin__top--medium">
						
						<a
							href="<?php echo esc_url( wp_lostpassword_url() ); ?>"
						><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
					
					</p>

					<?php do_action( 'woocommerce_login_form_end' ); ?>

				</form>

		<!-- register form -->
		<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

			</div>

			<div
				id="tab-register"
				class="tab-target">

				<!-- register form -->
				<form
					method="post"
					class="woocommerce-form woocommerce-form-register"
					<?php do_action( 'woocommerce_register_form_tag' ); ?>>

					<?php do_action( 'woocommerce_register_form_start' ); ?>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">

							<label
								for="reg_username"
								class="screen-reader-text"
							><?php esc_html_e( 'Username', 'woocommerce' ); ?></label>

							<input
								type="text"
								class="woocommerce-Input woocommerce-Input--text input-text input"
								name="username"
								id="reg_username"
								autocomplete="username"
								placeholder="Nome de usuário"
								required
								value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
								
								<?php // @codingStandardsIgnoreLine ?>

						</p>

					<?php endif; ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">

						<label
							for="reg_email"
							class="screen-reader-text"
						><?php esc_html_e( 'Email address', 'woocommerce' ); ?></label>

						<input
							type="email"
							class="woocommerce-Input woocommerce-Input--text input-text input"
							name="email"
							id="reg_email"
							required
							autocomplete="email"
							placeholder="Informe um e-mail válido"
							value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" />
							
							<?php // @codingStandardsIgnoreLine ?>

					</p>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">

							<label
								for="reg_password"
								class="screen-reader-text"
							><?php esc_html_e( 'Password', 'woocommerce' ); ?></label>

							<input
								type="password"
								class="woocommerce-Input woocommerce-Input--text input-text input"
								required
								name="password"
								id="reg_password"
								placeholder="Senha"
								autocomplete="new-password" />

						</p>

					<?php else : ?>

						<p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>

					<?php endif; ?>

					<?php do_action( 'woocommerce_register_form' ); ?>

					<p class="woocommerce-form-row form-row">

						<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>

						<button
							type="submit"
							class="woocommerce-Button woocommerce-button btn--success woocommerce-form-register__submit"
							name="register"
							value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"
						><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>

					</p>

					<?php do_action( 'woocommerce_register_form_end' ); ?>

				</form>

			</div>

		</div>

		<?php endif; ?>

  	<?php get_template_part( 'recaptcha' ); ?>

	</div>

</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
