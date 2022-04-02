<?php
/**
 * Customer shipping order email
 *
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

?>

<!-- @hooked WC_Emails::email_header() Output the email header -->
<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<!-- translators: %s: Customer first name -->
<p>
	<?php
		printf(
			esc_html__( 'Hi %s,', 'woocommerce' ),
			esc_html( $order->get_billing_first_name() )
		);
	?>
</p>

<!-- translators: %s: Order number -->
<p>
	<?php
		printf(
			esc_html__(
				'Apenas para que você saiba &mdash; seu pedido #%s está sendo preparado para envio. Você o receberá no prazo contratado.',
				'woocommerce'
			),
			esc_html( $order->get_order_number() )
		);
	?>
</p>

<!-- @hooked WC_Emails::order_details() Shows the order details table. -->
<!-- @hooked WC_Structured_Data::generate_order_data() Generates structured data. -->
<!-- @hooked WC_Structured_Data::output_structured_data() Outputs structured data. -->
<!-- @since 2.5.0 -->
<?php do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email ); ?>

<!-- @hooked WC_Emails::order_meta() Shows order meta data. -->
<?php do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email ); ?>

<!-- @hooked WC_Emails::customer_details() Shows customer details -->
<!-- @hooked WC_Emails::email_address() Shows email address -->
<?php do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email ); ?>

<!-- @hooked WC_Emails::email_footer() Output the email footer -->
<?php do_action( 'woocommerce_email_footer', $email ); ?>

<?php /* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
