<?php

// ==============================================
// Holds performance hacks
// ==============================================

defined( 'ABSPATH' ) || exit;

// disable embeds
function disable_embeds_tiny_mce_plugin( $plugins )
{
  return array_diff( $plugins, array( 'wpembed' ) );
}
function disable_embeds_rewrites( $rules )
{
  foreach ( $rules as $rule => $rewrite )
    if ( false !== strpos( $rewrite, 'embed=true' ) )
      unset( $rules[ $rule ] );

  return $rules;
}
function disable_embeds_code_init()
{
  remove_action( 'rest_api_init', 'wp_oembed_register_route' ); // Remove the REST API endpoint.
  
  add_filter( 'embed_oembed_discover', '__return_false' ); // Turn off oEmbed auto discovery.
  
  remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 ); // Don't filter oEmbed results.
  
  remove_action( 'wp_head', 'wp_oembed_add_discovery_links' ); // Remove oEmbed discovery links.
  
  remove_action( 'wp_head', 'wp_oembed_add_host_js' ); // Remove oEmbed-specific JS from the front-end and back-end.
  add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );
  
  add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' ); // Remove all embeds rewrite rules.
  
  remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 ); // Remove filter of the oEmbed result before any HTTP requests are made.
}

// remove emoji
function disable_emojis_tinymce( $plugins )
{
  if ( is_array( $plugins ) )
    return array_diff( $plugins, array( 'wpemoji' ) );

  return array();
}
function disable_emojis_remove_dns_prefetch( $urls, $relation_type )
{
  if ( 'dns-prefetch' == $relation_type ) {
    $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
    $urls = array_diff( $urls, array( $emoji_svg_url ) );
  }
  
  return $urls;  
}
function disable_emojis()
{
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
  add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}

// remove wordpress junks on init
function disable_wordpress_junks()
{
  remove_action( 'wp_head', 'rsd_link' ); // remove really simple discovery link
  remove_action( 'wp_head', 'wp_generator' ); // remove wordpress version

  remove_action( 'wp_head', 'feed_links', 2 ); // remove rss feed links
  remove_action( 'wp_head', 'feed_links_extra', 3 ); // removes all extra rss feed links

  remove_action( 'wp_head', 'index_rel_link' ); // remove link to index page
  remove_action( 'wp_head', 'wlwmanifest_link' ); // remove wlwmanifest.xml

  remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // remove random post link
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // remove parent post link
  remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // remove the next and previous post links
  remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

  remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
}

// Remove REST API Discovery
function remove_rest_api_discovery()
{
  // Disable REST API link tag
  remove_action('wp_head', 'rest_output_link_wp_head', 10);

  // Disable oEmbed Discovery Links
  remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

  // Disable REST API link in HTTP headers
  remove_action('template_redirect', 'rest_output_link_header', 11, 0);
}

// disable self-pingbacks
function wpsites_disable_self_pingbacks( &$links )
{
  foreach ( $links as $l => $link )
    if ( 0 === strpos( $link, get_option( 'home' ) ) )
      unset( $links[ $l ] );
}

// remove admin_bar on public
function disable_admin_bar_on_front()
{
  return null;
}

// die feed link
function itsme_disable_feed()
{
  wp_die( __( 'No feed available, please visit the <a href="'. esc_url( home_url( '/' ) ) .'">homepage</a>!' ) );
}

// remove unwanted CSS
function dequeue_unwanted_styles()
{
  // Remove the WooCommerce generator tag
	remove_action( 'wp_head', array( $GLOBALS[ 'woocommerce' ], 'generator' ) );

  // Unless we're in the store, remove all the cruft!
  if (
    ! is_woocommerce()
    && ! is_product_category()
    && ! is_cart()
    && ! is_checkout()
    && ! is_product()
    && ! is_account_page()
  ) {
    wp_dequeue_style( 'woocommerce-general');
  }
  
  // WC : remove anyway  
  wp_dequeue_style( 'woocommerce_frontend_styles' );
  wp_dequeue_style( 'woocommerce-layout' );
  wp_dequeue_style( 'woocommerce_fancybox_styles' );
  wp_dequeue_style( 'woocommerce_chosen_styles' );
  wp_dequeue_style( 'woocommerce-smallscreen' );
  wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
    
  // Contact Form7
  wp_deregister_style( 'contact-form-7' );

  // Gutterberg
  wp_dequeue_style( 'wp-block-library' );
  wp_dequeue_style( 'wp-block-library-theme' );
  wp_dequeue_style( 'wc-block-style' );

  // Frenet
  wp_dequeue_style( 'shipping-simulator' );
}

// remove unwanted JS from load
function dequeue_unwanted_scripts()
{
  // Unless we're in the store, remove all the cruft!
  if (
      ! is_admin()
      && ! is_woocommerce()
      && ! is_product_category()
      && ! is_cart()
      && ! is_checkout()
      && ! is_product()
      && ! is_account_page()
    ) {
		wp_dequeue_script( 'selectWoo' );
		wp_deregister_script( 'selectWoo' );
		wp_dequeue_script( 'wc-add-payment-method' );
		wp_dequeue_script( 'wc-lost-password' );
		wp_dequeue_script( 'wc_price_slider' );
		wp_dequeue_script( 'wc-single-product' );
		wp_dequeue_script( 'wc-add-to-cart' );
		wp_dequeue_script( 'wc-cart-fragments' );
		wp_dequeue_script( 'wc-credit-card-form' );
		wp_dequeue_script( 'wc-checkout' );
		wp_dequeue_script( 'wc-add-to-cart-variation' );
		wp_dequeue_script( 'wc-single-product' );
		wp_dequeue_script( 'wc-cart' );
    wp_dequeue_script( 'wc-chosen' );
    wp_dequeue_script( 'woocommerce' );
		wp_dequeue_script( 'prettyPhoto' );
		wp_dequeue_script( 'prettyPhoto-init' );
		wp_dequeue_script( 'jquery-blockui' );
		wp_dequeue_script( 'jquery-placeholder' );
		wp_dequeue_script( 'jquery-payment' );
		wp_dequeue_script( 'fancybox' );
    wp_dequeue_script( 'jqueryui' );
  }
    
  // Contact Form7
  wp_deregister_script( 'contact-form-7' );
}

// remove jQuery migrate
function remove_jquery_migrate( $scripts )
{
  if ( ! is_admin() && isset( $scripts->registered[ 'jquery' ] ) ) {
    $script = $scripts->registered['jquery'];
    
    if ( $script->deps )
      $script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
  }
}

// remove version string
function remove_query_strings_split( $src )
{
  $output = preg_split( "/(&ver|\?ver)/", $src );

  return $output[0];
}
function remove_query_strings()
{
  if ( ! is_admin() ) {
    add_filter( 'script_loader_src', 'remove_query_strings_split', 15 );
    add_filter( 'style_loader_src', 'remove_query_strings_split', 15 );
  }
}

// defer scripts
function defer_parsing_of_js( $url ) {
  if ( ( is_user_logged_in() && current_user_can( 'administrator' ) ) || is_cart() || is_checkout() )
    return $url;

  if ( FALSE === strpos( $url, '.js' ) )
    return $url;

  return str_replace( ' src', ' defer src', $url );
}

add_filter( 'script_loader_tag', 'defer_parsing_of_js', 10 );

add_action( 'init', 'disable_embeds_code_init' );

add_action( 'init', 'disable_emojis' );

add_action( 'init', 'disable_wordpress_junks' );

add_action( 'init', 'remove_rest_api_discovery' );

add_action( 'init', 'remove_query_strings' );

add_action( 'pre_ping', 'wpsites_disable_self_pingbacks' );

add_action( 'do_feed', 'itsme_disable_feed', 1 );
add_action( 'do_feed_rdf', 'itsme_disable_feed', 1 );
add_action( 'do_feed_rss', 'itsme_disable_feed', 1 );
add_action( 'do_feed_rss2', 'itsme_disable_feed', 1 );
add_action( 'do_feed_atom', 'itsme_disable_feed', 1 );
add_action( 'do_feed_rss2_comments', 'itsme_disable_feed', 1 );
add_action( 'do_feed_atom_comments', 'itsme_disable_feed', 1 );

add_filter( 'show_admin_bar', 'disable_admin_bar_on_front' );

add_action( 'wp_enqueue_scripts', 'dequeue_unwanted_styles' );

add_action( 'wp_print_scripts', 'dequeue_unwanted_scripts', 100 );

add_action( 'wp_default_scripts', 'remove_jquery_migrate' );
