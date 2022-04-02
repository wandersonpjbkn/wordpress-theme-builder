<?php

// ==============================================
// Changes archive page behavior
// ==============================================

// Remove outputs notices from default hook
function remove_archive_hookes()
{
  // before main
  remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
  remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
  // before shop loop
  remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
}

add_action( 'init', 'remove_archive_hookes' );
