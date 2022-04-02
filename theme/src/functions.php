<?php

// ==============================================
// Embed all ./functions
// Priority
// * critical - 0
// * frontend - 1
// * backend - 2
// ==============================================

defined( 'ABSPATH' ) || exit;


// Critical =====================================
// ==============================================

// default functions path
define( 'FUNCTIONS_PATH', TEMPLATEPATH . '/functions' );

// needed for others .php files
include( FUNCTIONS_PATH . '/structure-variables.php' );
include( FUNCTIONS_PATH . '/structure-helpers.php' );
include( FUNCTIONS_PATH . '/structure-settings.php' );


// Frontend =====================================
// ==============================================

// needed for website become functional
include( FUNCTIONS_PATH . '/website-assets.php' );
include( FUNCTIONS_PATH . '/website-performance.php' );

// needed for theme pages and others website features
include( FUNCTIONS_PATH . '/feature-black-friday.php' );
include( FUNCTIONS_PATH . '/feature-mass-discount.php' );

// needed for WooCommerce pages
include( FUNCTIONS_PATH . '/wc-archive.php' );
include( FUNCTIONS_PATH . '/wc-product.php' );
include( FUNCTIONS_PATH . '/wc-cart.php' );
include( FUNCTIONS_PATH . '/wc-checkout.php' );
include( FUNCTIONS_PATH . '/wc-orders.php' );
include( FUNCTIONS_PATH . '/wc-account.php' );


// Backend ======================================
// ==============================================

// needed for WordPress Dashboard
include( FUNCTIONS_PATH . '/admin-dashboard.php' );
