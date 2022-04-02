<?php

// ==============================================
// Changes orders page behavior
// ==============================================


// get all order notes
function get_private_order_notes( $order_id )
{
	global $wpdb;

	$table_perfixed = $wpdb->prefix . 'comments';
	$results = $wpdb->get_results(
		"SELECT *
			FROM $table_perfixed
			WHERE `comment_post_ID` = $order_id
			AND `comment_type` LIKE 'order_note'"
		);

	foreach ( $results as $note ){
		$order_note[]  = array(
			'id'      => $note->comment_ID,
			'date'    => $note->comment_date,
			'author'  => $note->comment_author,
			'content' => $note->comment_content,
		);
  }
  
	return $order_note;
}

// return delivery steps
function get_delivery_steps()
{
  return array(
		'on-hold' => array( 'value' => 'Aguardando Pagamento', 'icn' => 'engines' ),
		'processing' => array( 'value' => 'Pagamento Aprovado', 'icn' => 'approved' ),
		'processing-two-days' => array( 'value' => 'Em Separação', 'icn' => 'box' ),
		'processing-three-days' => array( 'value' => 'Produto Enviado', 'icn' => 'shipping' ),
		'completed' => array( 'value' => 'Produto Entregue', 'icn' => 'delivered' )
	);
}

// return order_status for delivery steps
function get_delivery_steps_order_status( $order_status, $notes )
{
	foreach ( $notes as $note ) {
		// look up for 'Processing' status
		if ( false !== strpos( $note[ 'content' ], 'para Processando' ) && $order_status === 'processing' ) {
			$note_date = date_create( $note[ 'date' ] );
			$today = wp_date( 'Y-m-d' );
	
			// set 'in separation'
			date_add( $note_date, date_interval_create_from_date_string( '1 days' ) );
			$date_two_days = date_format( $note_date, 'Y-m-d' );
	
			// set 'dispatched'
			date_add( $note_date, date_interval_create_from_date_string( '2 days' ) );
			$date_three_days = date_format( $note_date, 'Y-m-d' );
	
			// set order status
			$order_status = 'processing';
	
			if ( $today >= $date_two_days )
				$order_status = 'processing-two-days';
	
			if ( $today >= $date_three_days )
				$order_status = 'processing-three-days';
			
			break;
		}
	}

	return $order_status;
}


// function to check orders and send notification
function send_shipping_statuses()
{
  $today = wp_date( 'Y-m-d' );
	$orders = wc_get_orders([
		'limit' => -1,
		'status' => [ 'processing' ]
  ]);
  
	foreach ( $orders as $order ) {
		$is_shipping = false;
		$order_notes = get_private_order_notes( $order->get_id() );

		foreach ( $order_notes as $note ) {
			if ( false !== ( strpos( $note[ 'content' ], 'para Processando' ) ) ) {
				$note_date = date_create( $note[ 'date' ] );
        
				date_add( $note_date, date_interval_create_from_date_string( '1 days' ) );
				$date_to_shipping = date_format( $note_date, 'Y-m-d' );

				if ( $date_to_shipping === $today )
					$is_shipping = true;

				break;
			}
		}

		if ( $is_shipping )
			notify_shipping_process( $order );
	}
}

// function to send shipping email
function notify_shipping_process( $order )
{
	$mailer = WC()->mailer();

	$headers = "Content-Type: text/html\r\n";
	$subject = 'Seu pedido está sendo preparado';
	$recipient = $order->get_billing_email();
	$content = get_shipping_notification_content( $order, $subject, $mailer );

	$mailer->send( $recipient, $subject, $content, $headers );
}

// return email content for shipping notify
function get_shipping_notification_content( $order, $heading = false, $mailer )
{
	$template = 'emails/customer-shipping-order.php';

	return wc_get_template_html(
		$template,
		array(
			'order' => $order,
			'email_heading' => $heading,
			'sent_to_admin' => true,
			'plain_text' => false,
			'email' => $mailer
		)
	);
}

// register a hook to send emails to client
function load_event_send_notification()
{
  if ( ! wp_next_scheduled ( 'event_send_shipping_statuses' ) ) {
    wp_schedule_event( time(), 'daily', 'event_send_shipping_statuses' );
  }
}

add_action( 'init', 'load_event_send_notification' );

add_action( 'event_send_shipping_statuses', 'send_shipping_statuses'  );
