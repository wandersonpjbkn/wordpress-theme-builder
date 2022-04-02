<?php

// ==============================================
// Changes checkout page behavior
// ==============================================


// General Billing/Shipping Fields Data Change
// ==============================================

// change field label
function change_fields_labels( $category, $fields )
{
	foreach ( $fields as $category => $value ) {
		unset( $fields[ $category ][ 'label' ] );
	}
	
	return $fields;
}

// change field attributes
function change_fields_attributes( $category, $fields )
{
	// add or remove attribute
	if ( ! function_exists( 'add_custom_attribute' ) ) {
		function add_custom_attribute( $_target, $_attribute, $_value )
		{
			global $custom_category;
			global $custom_fields;

			$category_target = $custom_category . $_target;

			if ( array_key_exists( $category_target, $custom_fields ) ) {
				$custom_fields[ $category_target ][ $_attribute ] = $_value;
			}

			return $custom_fields;
		}
	}

	$GLOBALS[ 'custom_category' ] = $category;
	$GLOBALS[ 'custom_fields' ] = $fields;

	$fields = add_custom_attribute( '_address_2', 'maxlength', 40);

	return $fields;
}

// change fields placeholders
function change_fields_placeholders( $category, $fields )
{
	// add or remove placeholder
	if ( ! function_exists( 'add_custom_placeholder' ) ) {
		function add_custom_placeholder( $_target, $_placeholder )
		{
			global $custom_category;
			global $custom_fields;

			$category_target = $custom_category . $_target;

			if ( array_key_exists( $category_target, $custom_fields ) ) {
				$custom_fields[ $category_target ][ 'placeholder' ] = $_placeholder;
			}

			return $custom_fields;
		}
	}

	$GLOBALS[ 'custom_category' ] = $category;
	$GLOBALS[ 'custom_fields' ] = $fields;

	$fields = add_custom_placeholder( '_first_name', 'Nome');
	$fields = add_custom_placeholder( '_last_name', 'Sobrenome');
	$fields = add_custom_placeholder( '_cpf', 'CPF');
	$fields = add_custom_placeholder( '_company', 'Empresa');
	$fields = add_custom_placeholder( '_cnpj', 'CNPJ');
	$fields = add_custom_placeholder( '_postcode', 'CEP');
	$fields = add_custom_placeholder( '_number', 'Número');
	$fields = add_custom_placeholder( '_address_2', 'Complemento');
	$fields = add_custom_placeholder( '_phone', 'Telefone');
	$fields = add_custom_placeholder( '_email', 'E-mail');
	$fields = add_custom_placeholder( '_neighborhood', 'Bairro');
	$fields = add_custom_placeholder( '_city', 'Cidade');
	$fields = add_custom_placeholder( '_state', 'Estado');

	return $fields;
}

// change fields priority
function change_fields_priorities( $category, $fields )
{
	// add or remove priority
	if ( ! function_exists( 'add_custom_priority' ) ) {
		function add_custom_priority( $_target, $_priority )
		{
			global $custom_category;
			global $custom_fields;

			$category_target = $custom_category . $_target;

			if ( array_key_exists( $category_target, $custom_fields ) ) {
				$custom_fields[ $category_target ][ 'priority' ] = $_priority;
			}

			return $custom_fields;
		}
	}

	$GLOBALS[ 'custom_category' ] = $category;
	$GLOBALS[ 'custom_fields' ] = $fields;

	$fields = add_custom_priority( '_email', 21);
	$fields = add_custom_priority( '_phone', 21);
	$fields = add_custom_priority( '_cellphone', 21);
	$fields = add_custom_priority( '_persontype', 23);
	$fields = add_custom_priority( '_cpf', 23);
	$fields = add_custom_priority( '_company', 24);
	$fields = add_custom_priority( '_cnpj', 24);

	return $fields;
}

// change fields class
function change_fields_class( $category, $fields )
{
	// merge custom class array into fields class array
	if ( ! function_exists( 'add_custom_class' ) ) {
		function add_custom_class( $_target, $_array )
		{
			global $custom_category;
			global $custom_fields;
			
			$category_target = $custom_category . $_target;

			if ( array_key_exists( $category_target, $custom_fields ) ) {
				$new_array = array_merge( $custom_fields[ $category_target ][ 'class' ], $_array );
				$custom_fields[ $category_target ][ 'class' ] = $new_array;
			}

			return $custom_fields;
		}
	}

	$GLOBALS[ 'custom_category' ] = $category;
	$GLOBALS[ 'custom_fields' ] = $fields;

	$fields = add_custom_class( '_first_name', array( 'col--1-2@md', 'col--1' ) );
	$fields = add_custom_class( '_last_name' , array( 'col--1-2@md', 'col--1' ) );
	$fields = add_custom_class( '_phone' , array( 'col--1-2@md', 'col--1' ) );
	$fields = add_custom_class( '_email' , array( 'col--1-2@md', 'col--1', 'margin__bottom--medium' ) );

	$fields = add_custom_class( '_persontype' , array( 'col--1-4@md', 'col--1' ) );
	$fields = add_custom_class( '_cpf' , array( 'col--1-4@md', 'col--1', 'margin__bottom--medium', 'offset__right--1-2@md' ) );

	$fields = add_custom_class( '_cnpj' , array( 'col--1-4@md', 'col--1' ) );
	
	$col = 'col--1' . ( is_checkout() && $category == 'billing' ? '-2@md col--1' : '' );
	$fields = add_custom_class( '_company' , array( $col, 'margin__bottom--medium' ) );

	$fields = add_custom_class( '_postcode' , array( 'col--1-4@md', 'col--1-2' ) );
	$fields = add_custom_class( '_address_1' , array( 'col--3-4@md', 'col--1' ) );
	$fields = add_custom_class( '_number' , array( 'col--1-4@md', 'col--1' ) );
	$fields = add_custom_class( '_address_2' , array( 'col--1-4@md', 'col--1' ) );
	$fields = add_custom_class( '_neighborhood' , array( 'col--1-4@md', 'col--1' ) );
	$fields = add_custom_class( '_city' , array( 'col--1-4@md', 'col--1' ) );
	$fields = add_custom_class( '_state' , array( 'col--1-4@md', 'col--1', 'margin__bottom--medium' ) );

	$fields = add_custom_class( '_country' , array( 'is__hidden' ) );
	$fields = add_custom_class( '_cellphone' , array( 'is__hidden' ) );
	
	return $fields;
}

// change fields required
function change_fields_required( $category, $fields )
{
	// add or remove required
	if ( ! function_exists( 'add_custom_required' ) ) {
		function add_custom_required( $_target, $is_required )
		{
			global $custom_category;
			global $custom_fields;

			$category_target = $custom_category . $_target;

			if ( array_key_exists( $category_target, $custom_fields ) ) {
				if ( $is_required ) {
					$custom_fields[ $category_target ][ 'required' ] = 1;
				} else {
					unset( $custom_fields[ $category_target ][ 'required' ] );
				}
			}

			return $custom_fields;
		}
	}

	$GLOBALS[ 'custom_category' ] = $category;
	$GLOBALS[ 'custom_fields' ] = $fields;

	// remove
	$fields = add_custom_required( '_cellphone', false );

	// add
	$fields = add_custom_required( '_persontype', true );
	$fields = add_custom_required( '_neighborhood', true );

	return $fields;
}


// Shipping Fields
// ==============================================

// change shipping fields
function change_shipping_fields( $fields )
{
	//set
	$_fields = $fields;
	$_category = 'shipping';
	
	// change
	$_fields = change_fields_labels( $_category, $_fields );
	$_fields = change_fields_attributes( $_category, $_fields );
	$_fields = change_fields_placeholders( $_category, $_fields );
	$_fields = change_fields_class( $_category, $_fields );

	// final return
	return $_fields;
}


// Billing Fields
// ==============================================

// change billing fields
function change_billing_fields( $fields )
{
	//set
	$_fields = $fields;
	$_category = 'billing';
	
	// change
	$_fields = change_fields_labels( $_category, $_fields );
	$_fields = change_fields_attributes( $_category, $_fields );
	$_fields = change_fields_placeholders( $_category, $_fields );
	$_fields = change_fields_priorities( $_category, $_fields );
	$_fields = change_fields_class( $_category, $_fields );
	$_fields = change_fields_required( $_category, $_fields );

	// final return
	return $_fields;
}


// Checkout Fieds
// ==============================================

// change checkout fields data
function change_checkout_fields( $fields )
{
	// order
	array_push( $fields[ 'order' ][ 'order_comments' ][ 'class' ], 'col--1' );

	// ensure checkout label remove
	foreach ( $fields as $category => $value ) {
		foreach ( $fields[ $category ] as $field => $item ) {
			unset( $fields[ $category ][ $field ][ 'label' ] );
		}
	}
	
	return $fields;
}

// always set 'Terms and conditions' to checked
function always_mark_terms_as_checked()
{
  add_filter( 'woocommerce_terms_is_checked', '__return_true', 10 );
  add_filter( 'woocommerce_terms_is_checked_default', '__return_true', 10 );
}

// remove cupom from checkout
function remove_cupom_from_checkout()
{
	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
}

// remove form-row class from checkout fields
function change_form_field( $field, $key, $args, $value )
{
	if ( is_checkout() || is_account_page() ) {
		$field = str_replace(
			array( 'class="form-row ', 'class="form-row-first ', 'class="form-row-wide ', 'class="form-row-last ' ),
			array( 'class="', 'class="', 'class="', 'class="' ),
			$field
		);
	}

	if ( $args[ 'required' ] ) {
		$field = str_replace(
			'<input ',
			'<input required ',
			$field
		);
	}
	
	return $field;
}


add_filter( 'woocommerce_form_field', 'change_form_field', 10, 4 );

add_filter( 'woocommerce_billing_fields' , 'change_billing_fields', 999 );

add_filter( 'woocommerce_shipping_fields' , 'change_shipping_fields', 999 );

add_filter( 'woocommerce_checkout_fields' , 'change_checkout_fields', 999 );

add_action( 'init', 'always_mark_terms_as_checked' );

add_action( 'init', 'remove_cupom_from_checkout' );
