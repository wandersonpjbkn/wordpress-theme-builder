<?php

// ==============================================
// Component: Carousel
// ==============================================

defined( 'ABSPATH' ) || exit;

$carousel_title = get_query_var( 'carousel_title', '' );
$carousel_metadata = get_query_var( 'carousel_metadata', '' );
$carousel_type = get_query_var( 'carousel_type', 'product' );
$carousel_ctrl = get_query_var( 'carousel_ctrl', 'btns' );
$carousel_loop = get_query_var( 'carousel_loop' );

?>

<!-- title -->
<?php if ( ! empty( $carousel_title ) ) : ?>

  <h2 class="title__section">
    <span><?= esc_html( $carousel_title ) ?></span>
  </h2>

<?php endif; ?>

<div
  class="carousel"
  <?php get_carousel_metadata( $carousel_metadata ) ?>>

  <!-- slides overflow: hidden -->
  <div class="carousel__wrapper">

    <!-- slides holder -->
    <div class="carousel__slides">

      <?php if ( $carousel_type === 'product-query' ) : ?>
        
        <!-- loop products -->
        <?php while ( $carousel_loop->have_posts() ) : $carousel_loop->the_post(); ?>

          <div class="carousel__card">
            <?php get_component( '_card-product' ) ?>
          </div>

        <?php endwhile; ?>

        <?php wp_reset_query(); ?>

      <?php elseif ( $carousel_type === 'product-post' ) : ?>
        
        <!-- loop products -->
        <?php foreach ( $carousel_loop as $post_ID ) : ?>

          <?php $post_object = get_post( $post_ID ); ?>
					<?php setup_postdata( $GLOBALS['post'] =& $post_object ); ?>

          <div class="carousel__card">
            <?php get_component( '_card-product' ) ?>
          </div>

        <?php endforeach; ?>

        <?php wp_reset_postdata(); ?>

      <?php elseif ( $carousel_type === 'slides' ) : ?>

        <!-- product card loop -->
        <?php foreach ( $carousel_loop as $slide ) : ?>
          
          <?php set_query_var( 'lazy_image_ID', (int)$slide[ 'image_ID' ] ); ?>
          <?php set_query_var( 'lazy_image_size', 'full' ); ?>

          <!-- responsive -->
          <div class="carousel__slide">

            <?php if ( ! empty( $slide[ 'url' ] ) ) : ?>

              <a
                class="carousel__slide--container"
                href="<?= esc_url( $slide[ 'url' ] ) ?>">

                <?php get_component( '_lazy-image' ) ?>
                
              </a>

            <?php else :  ?>

              <?php get_component( '_lazy-image' ) ?>

            <?php endif; ?>          

          </div>

        <?php endforeach; ?>

      <?php elseif ( $carousel_type === 'testimonials' ) : ?>

        <?php foreach( $carousel_loop as $testimonial ) : ?>
        
          <div class="carousel__testimonial">

            <div class="carousel__testimonial--avatar position__relative is__centered--margin">
              <?php set_query_var( 'lazy_image_ID', (int)$testimonial[ 'image_ID' ] ); ?>
              <?php get_component( '_lazy-image' ); ?>
            </div>

            <h3 class="carousel__testimonial--name">
              <?= esc_html( $testimonial[ 'name' ] ) ?>
            </h3>

            <h4 class="carousel__testimonial--company">
              <?= esc_html( $testimonial[ 'company' ] ) ?>
            </h4>

            <p class="carousel__testimonial--description">
              <?= esc_html( $testimonial[ 'testimonial' ] ) ?>
            </p>

          </div>
          
        <?php endforeach; ?>

      <?php elseif ( $carousel_type === 'highlighted' ) : ?>

        <?php foreach( $carousel_loop as $highlighted ) : ?>
        
          <a
            class="carousel__highlighted"
            href="<?= esc_html( $highlighted[ 'link' ] ) ?>">

            <div class="carousel__highlighted--image position__relative is__centered--margin">

              <?php set_query_var( 'lazy_image_ID', (int)$highlighted[ 'image_ID' ] ); ?>
              <?php get_component( '_lazy-image' ); ?>

              <?php if ( ! empty( $highlighted[ 'title' ] ) ) : ?>

                <span class="carousel__highlighted--title position__absolute">
                  <?= esc_html( $highlighted[ 'title' ] ) ?>
                </span>

                <?php endif; ?>

            </div>

          </a>
          
        <?php endforeach; ?>

      <?php else : ?>

        <pre>Carousel type is invalid</pre>

      <?php endif; ?>

    </div>

    <!-- Progress -->
    <?php if ( $carousel_type === 'slides' ) : ?>

      <progress
        class="carousel__progress"
        max="100"
        value="0"
        aria-label="slideshow-progress"
      ></progress>

    <?php endif; ?>

  </div>

  <!-- Navigation -->
  <?php if ( $carousel_ctrl === 'dots' ) : ?>

    <?php $count = 0; ?>

    <nav
      class="carousel__ctrl dots"
      data-type="dot">

      <?php for ( $i = 0; $i < count( $carousel_loop ); $i++ ) : ?>

        <button class="carousel__dot dot"></button>

      <?php endfor; ?>

    </nav>

  <?php elseif ( $carousel_ctrl === 'btns' ) : ?>

    <nav
      class="carousel__ctrl btns"
      data-type="btn">

      <button class="carousel__btn btn btn--icn-prev"></button>
      
      <button class="carousel__btn btn btn--icn-next push__right"></button>

    </nav>

  <?php else : ?>

    <!-- Nothing here -->
    
  <?php endif; ?>

</div>
