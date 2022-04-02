<?php

// ==============================================
// Holds global functions
// ==============================================

defined( 'ABSPATH' ) || exit;


// General
// ==============================================

// Return page ID based on a slug
function get_page_id_by_slug( $page_slug, $output = OBJECT, $post_type = 'page' )
{
  $page = get_page_by_path(
    $page_slug,
    $output,
    $post_type
  );

  if ( $page )
    return $page->ID;
    
  return NULL;
}

// Return if is prod or dev env
function is_dev()
{
  if ( $_SERVER[ 'HTTP_HOST' ] == 'test.com' )
    return true;

  return false;
}

// hash version
function get_path_js( $js )
{
  $map = get_template_directory_uri() . '/js/manifest.json';
  $hash = json_decode( file_get_contents( $map ), true );

  if ( array_key_exists( $js, $hash ) ) {
    $js = get_template_directory_uri() . '/js/' . $hash[ $js ];
  }

  return $js;
}

// get all products categories as an array
function get_current_product_category( $product_id, $type = 'simple' )
{
  $ID = $product_id;
  $product_categories = array();

  if ( $type !== 'simple' ) {
    $ID = wp_get_post_parent_id( $product_id );
  }

  $terms = get_the_terms( $ID, 'product_cat' );
    
  foreach( $terms as $term ) {
    array_push( $product_categories , $term->name );
  }

  return $product_categories;
}


// Components
// ==============================================

// reset component custom query_vars
function reset_component_query_var( $component )
{
  switch ( $component ) :
    case '_lazy-image':
      set_query_var( 'lazy_image_ID', NULL );
      set_query_var( 'lazy_image_has_mobile_image', NULL );
      set_query_var( 'lazy_image_mobile_image', NULL );
      set_query_var( 'lazy_image_size', NULL );
      break;

    case '_dashboard-custom-filter':
      set_query_var( 'custom_filter_name', NULL );
      set_query_var( 'custom_filter_options', NULL );
      break;

    case '_carousel':
      set_query_var( 'carousel_title', NULL );
      set_query_var( 'carousel_metadata', NULL );
      set_query_var( 'carousel_type', NULL );
      set_query_var( 'carousel_ctrl', NULL );
      set_query_var( 'carousel_loop', NULL );
      break;

    case '_card-dynamic':
      set_query_var( 'card_dynamic_model', NULL );
      set_query_var( 'card_dynamic_url', NULL );
      set_query_var( 'card_dynamic_title', NULL );
      set_query_var( 'card_dynamic_align', NULL );
      break;

    case '_section-dynamic':
      set_query_var( 'section_dynamic_data', NULL );
      break;
      
    case '_wc_quantity':
      set_query_var( 'wc_quantity_margin', NULL );
      break;

    case '_label':
      set_query_var( 'label_text', NULL );
      set_query_var( 'label_theme', NULL );
      break;

    case '_landing-page-product-card':
      set_query_var( 'landing_page_product_extra_class', NULL );
      set_query_var( 'landing_page_product_card_image_ID', NULL );
      set_query_var( 'landing_page_product_card_name', NULL );
      set_query_var( 'landing_page_product_card_description', NULL );
      break;

    case '_logo':
      set_query_var( 'logo_is_responsive', NULL );
      break;

    case '_card-product':
      set_query_var( 'card_product_title', NULL );
      set_query_var( 'card_product_link', NULL );
      break;

    default:
      // silent is golden
      break;
  endswitch;
}

// get custom component
function get_component( $component_slug, $component_name = NULL, $component_reset_slug = NULL )
{
  if ( $component_name !== NULL ) :

    // if slug/name setted
    get_template_part( $component_slug, $component_name );
    reset_component_query_var( $component_reset_slug );

  else :

    // if name not setted
    get_template_part( $component_slug );
    reset_component_query_var( $component_slug );

  endif;
}


// Component: Carousel
// ==============================================

// Return carousel metadata()
function get_carousel_metadata( $metadata )
{
  if ( empty( $metadata ) )
    return;

  foreach ( $metadata as $data ) {
    $key = $data[ 'key' ];
    $value = $data[ 'value' ];

    echo htmlspecialchars( " data-$key='$value'" );
  }
}

// Get featured products data
function get_products_featured_to_carousel ( $per_page = 12 )
{
  $meta_query  = WC()->query->get_meta_query();
  $tax_query   = WC()->query->get_tax_query();

  $tax_query[] = array(
    'taxonomy' => 'product_visibility',
    'field'    => 'name',
    'terms'    => 'featured',
    'operator' => 'IN',
  );

  $args = array(
    'post_type'           => 'product',
    'post_status'         => 'publish',
    'ignore_sticky_posts' => 1,
    'posts_per_page'      => $per_page,
    'orderby'             => 'random',
    'meta_query'          => $meta_query,
    'tax_query'           => $tax_query,
  );

  return $args;
}

// Get best sellers products data
function get_products_best_sellers_to_carousel ( $per_page = 12 )
{
  $args = array(
    'post_type'           => 'product',
    'post_status'         => 'publish',
    'ignore_sticky_posts' => 1,
    'posts_per_page'      => $per_page,
    'orderby'             => 'random',
    'meta_query'          => 'total_sales'
  );

  return $args;
}

// Get highlights products data
function get_products_highlighted()
{
  $data = array();
  $page_ID = get_page_id_by_slug( 'home' );

  if ( have_rows( 'products_highlighted', $page_ID ) ) {
    while ( have_rows( 'products_highlighted', $page_ID ) ) : the_row();

      array_push(
        $data,
        array(
          'image_ID' => get_sub_field( 'highlighted_photo' ),
          'title' => trim( get_sub_field( 'highlighted_title' ) ),
          'link' => trim( get_sub_field( 'highlighted_link' ) ),
        )
      );

    endwhile;
  }

  return empty( $data ) ? '' : $data;
}


// Component: Product Card
// ==============================================

function get_product_quota( $sale_price, $shorted = true )
{
  $quota = 12;
  return 'ou ' . $quota . 'x ' . ( $shorted ? '' : 'sem juros de ' ) . wc_price( $sale_price / $quota );
}

function get_card_product_image( $product, $type )
{
  if ( $type == 'item' ) {
    $image_ID = $product->get_image_id();
  } else {
    $image_ID = $product->get_gallery_image_ids();
    $image_ID = empty( $image_ID[ 0 ] ) ? $product->get_image_id() : $image_ID[ 0 ];
  }

  set_query_var( 'lazy_image_ID', (int)$image_ID );
  set_query_var( 'lazy_image_size', 'medium' );

  get_component( '_lazy-image' );
}

function get_label_text()
{
  global $product;

  // return false if product is not on sale
  if ( $product->is_on_sale() != true )
    return false;

  // return a string if product is variable
  if ( $product->is_type( 'variable' ) )
    return 'Oferta';
  
  // return given discount
  $regular_price  = $product->get_regular_price();
  $sale_price     = $product->get_sale_price();

  return ( round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 ) * -1 ) . '%';
}

function get_show_on_showcase( $product_id )
{
  return get_field( 'show_on_showcase', $product_id );
}


// Component: Lazy Image
// ==============================================

// Return a image placeholder
function get_image_placeholder()
{
  return esc_url( get_template_directory_uri() . '/img/placeholder.svg' );
}


// Component: Hero Image
// ==============================================

// get category featured image id for hero image component
function get_category_featured_image_ID()
{
  global $wp_query;

  if ( ! function_exists( 'get_field' ) )
    return 0;

  // get current category image
  $category = $wp_query->get_queried_object();
  $thumb_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
  
  // if image is empty
  if ( empty( $thumb_id ) )
    return false;

  // if current category has an image
  return $thumb_id;
}


// Component: Social Links
// ==============================================

// get social networks
function get_social_links()
{
  $page_ID = get_page_id_by_slug( 'home' );
  $data = array();

  if ( ! function_exists( 'get_field' ) )
    return array();

  array_push(
    $data,
    array( 'url' => trim( get_field( 'facebook_url', $page_ID ) ), 'icn' => 'facebook' ),
    array( 'url' => trim( get_field( 'instagram_url', $page_ID ) ), 'icn' => 'instagram' ),
    array( 'url' => trim( get_field( 'youtube_url', $page_ID ) ), 'icn' => 'youtube' )
  );

  return $data;
}


// Component: Social Links
// ==============================================

// return a class align
function get_dynamic_card_align( $align )
{
  if ( $align === 'center' )
    return 'center';

  if ( $align === 'left' )
    return 'push__left';

  if ( $align === 'right' )
    return 'push__right';
}


// Template Part: Sidebar
// ==============================================

// get category URl
function get_category_url( $slug )
{
  return esc_url( home_url( '/' ) . get_option( 'woocommerce_permalinks' )[ 'category_base' ] . '/' . $slug );
}

function get_products_categories( $parent = 0 )
{
  $terms = get_terms(
    array(
    'taxonomy'    => 'product_cat',
    'orderby'     => 'name',
    'order'       => 'ASC',
    'parent'      => $parent,
    'hide_empty'  => true
    )
  );

  $exclude_slugs = array(
    'sem-categoria'
  );

  foreach ( $terms as $key => $value ) {
    if ( in_array( $value->slug, $exclude_slugs ) )
      unset( $terms[ $key ] );
  }

  return $terms;
}


// Template Part: Slideshow
// ==============================================

// return images to the slideshow banner
function get_slideshow_banner_images()
{
  $page_ID = get_page_id_by_slug( 'home' );
  $data = array();

  if ( have_rows( 'banner_slide', $page_ID ) ) {

    while ( have_rows( 'banner_slide', $page_ID ) ) : the_row();
      
      $datetime_now = wp_date( 'Y-m-d H:i:s' );
      $banner_is_active = get_sub_field( 'banner_is_active' );
      $banner_start_date = empty( get_sub_field( 'banner_start_date' ) ) ? $datetime_now : get_sub_field( 'banner_start_date' );
      $banner_end_date = empty( get_sub_field( 'banner_end_date' ) ) ? $datetime_now : get_sub_field( 'banner_end_date' );

      if ( 
        $banner_is_active && 
        ( $datetime_now >= $banner_start_date && $datetime_now <= $banner_end_date )
      )
      {
        array_push(
          $data,
          array(
            'url' => trim( get_sub_field( 'banner_url' ) ),
            'image_ID' => get_sub_field( 'banner_image' )
          )
        );
      }

    endwhile;
  }

  return $data;
}


// Template Part: Header-Menu
// ==============================================

// get header-menu data
function get_header_menu_data()
{
  $data = array();
  $page_ID = get_page_id_by_slug( 'home' );

  if ( have_rows( 'menu_items', $page_ID ) ) {

    while ( have_rows( 'menu_items', $page_ID ) ) : the_row();

    $options = array(
      'name' => trim( get_sub_field( 'menu_item_text' ) ),
      'is_featured' => get_sub_field( 'is_featured' )
    );
        
    $type = get_sub_field( 'menu_item_type' );

    switch ( $type ) :
      case 'category':
        $options = array_merge( $options, array(
          'type' => 'category',
          'slug' => trim( get_sub_field( 'menu_item_slug' ) )
        ));
        break;

      case 'internal':
        $options = array_merge( $options, array(
          'type' => 'internal',
          'slug' => trim( get_sub_field( 'menu_item_slug' ) )
        ));
        break;
      
      default:
        $options = array_merge( $options, array(
          'type' => 'external',
          'url' => trim( get_sub_field( 'menu_item_url' ) )
        ));
        break;
    endswitch;

    array_push( $data, $options);

    endwhile;
  }

  return $data;
}


// Template Part: Footer-Menu
// ==============================================

// get footer-menu data
function get_footer_menu_data()
{
  $data = array();  
  
  $data['site_map_items'] = array('title' => 'Mapa do Site', 'data' => array() );
  $data['contacts'] = array('title' => 'Contatos', 'data' => array() );
  $data['informations'] = array('title' => 'Informações', 'data' => array() );
  
  $page_ID = get_page_id_by_slug( 'home' );

  if ( have_rows( 'contacts', $page_ID ) ) {

    while ( have_rows( 'contacts', $page_ID ) ) : the_row();

      array_push(
        $data['contacts']['data'],
        array(
          'name' => trim( get_sub_field( 'contact_text' ) ),
          'url' => trim( get_sub_field( 'contact_link' ) ),
          'type' => get_sub_field( 'contact_type' )
        )
      );

    endwhile;
  }

  if ( have_rows( 'informations', $page_ID ) ) {

    while ( have_rows( 'informations', $page_ID ) ) : the_row();

      array_push(
        $data['informations']['data'],
        array(
          'name' => trim( get_sub_field( 'information_text' ) ),
          'url' => trim( get_sub_field( 'information_url' ) ),
          'type' => get_sub_field( 'information_type' )
        )
      );

    endwhile;
  }

  if ( have_rows( 'site_map_items', $page_ID ) ) {

    while ( have_rows( 'site_map_items', $page_ID ) ) : the_row();

      array_push(
        $data['site_map_items']['data'],
        array(
          'name' => trim( get_sub_field( 'site_map_text' ) ),
          'url' => trim( get_sub_field( 'site_map_url' ) ),
          'type' => get_sub_field( 'site_map_type' )
        )
      );

    endwhile;
  }

  return $data;
}

// get terms links
function get_terms_links()
{
  $page_ID = get_page_id_by_slug( 'home' );
  $data = array();

  if ( ! function_exists( 'get_field' ) )
    return array();

  $data['terms_conditions'] = array( 
    'name' => 'Termos e Condições', 
    'url' => trim( get_field( 'terms_conditions_url', $page_ID )  )
  );

  $data['privacy_policy'] = array( 
    'name' => 'Política de Privacidade', 
    'url' => trim( get_field( 'privacy_policy_url', $page_ID ) )
  );

  $data['faq'] = array( 
    'name' => 'Perguntas Frequentes', 
    'url' => trim( get_field( 'faq_url', $page_ID ) )
  );
  
  return $data;
}


// Template: Front-Page
// ==============================================

// return a custom section layout
function get_dynamic_section( $row )
{
  $card_layout_ID = (int)$row[ 'cards_layout' ];
  $card_layout_active = $row[ 'is_active_layout_section' ];

  if ( ! $card_layout_active )
    return;

  set_query_var( 'section_dynamic_data', $row[ 'section_layout_' . $card_layout_ID ] );

  get_component( '_section-dynamic/section', $card_layout_ID, '_section-dynamic' );
}

// get stripe data
function get_stripe_data()
{
  $data = array();
  $page_ID = get_page_id_by_slug( 'home' );

  if ( have_rows( 'stripe', $page_ID ) ) {
    while ( have_rows( 'stripe', $page_ID ) ) : the_row();

      array_push(
        $data,
        array(
          'image_ID' => get_sub_field( 'stripe_photo' ),
          'title' => get_sub_field( 'stripe_title' ),
          'text' => get_sub_field( 'stripe_text' )
        )
      );

    endwhile;
  }

  return empty( $data ) ? '' : $data;
}
