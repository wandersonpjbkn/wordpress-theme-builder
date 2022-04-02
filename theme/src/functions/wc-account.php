<?php

// ==============================================
// Changes account page behavior
// ==============================================


// return account page title
function get_page_account_title()
{
  $items = wc_get_account_menu_items();

  switch ( $items ) {
    case is_wc_endpoint_url( 'orders' ):
      return $items[ 'orders' ];

    case is_wc_endpoint_url( 'edit-address' ):
      return $items[ 'edit-address' ];

    case is_wc_endpoint_url( 'edit-account' ):
      return $items[ 'edit-account' ];

    case is_wc_endpoint_url( 'downloads' ):
      return $items[ 'downloads' ];
    
    default:
      return 'Dashboard';
  }
}

// remove menu itens from dashboard
function remove_dashboard_itens( $items )
{
  $targets = array( 'dashboard', 'downloads' );

  foreach ( $targets as $target ) {
    unset( $items[ $target ] );
  }
	
	return $items;
}

add_filter( 'woocommerce_account_menu_items', 'remove_dashboard_itens' );
