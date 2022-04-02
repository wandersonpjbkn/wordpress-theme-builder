<?php

// ==============================================
// Set critical WooCommerce params
// ==============================================

// add support to custom theme
function add_theme_support()
{
	add_theme_support( 'woocommerce' );
	add_theme_support( 'post-thumbnails' );
}

// remove WordPress 5.3 image threshold
function update_big_image_size_threshold()
{
	return false;
}


add_filter( 'big_image_size_threshold', 'update_big_image_size_threshold' );

add_action( 'after_setup_theme', 'add_theme_support' );
