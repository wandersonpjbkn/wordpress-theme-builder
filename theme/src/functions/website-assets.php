<?php

// ==============================================
// Holds any css/js inserted during load
// ==============================================

defined( 'ABSPATH' ) || exit;

// enqueue default theme script
function enqueue_theme_script()
{
  wp_enqueue_script( 'main', get_path_js( 'main.js' ) . '?ver=' . THEME_VERSION, array(), THEME_VERSION, true );
  wp_localize_script( 'main', 'ajaxobject', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

// enqueue marketing script only in prod env
function enqueue_markerting_script()
{
  // tawk.to
  wp_enqueue_script( 'tawkto', get_template_directory_uri() . '/js/tawk-to.js', array(), THEME_VERSION, true );
  
  if ( ! is_dev() ) {
    // tagmanager
    wp_enqueue_script( 'tagmanager', get_template_directory_uri() . '/js/tagmanager.js', array(), THEME_VERSION, false );
  }
}

add_action( 'wp_enqueue_scripts', 'enqueue_theme_script' );
add_action( 'wp_enqueue_scripts', 'enqueue_markerting_script' );
