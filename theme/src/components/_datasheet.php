<?php

// ==============================================
// Component: Product Datasheet Info
// ==============================================

defined( 'ABSPATH' ) || exit;

?>

<h2 class="is__hidden">Informações Técnicas</h2>

<?php if ( have_rows( 'datasheet' ) ) : ?>

  <table class="table">
    <tbody>

      <?php while ( have_rows( 'datasheet' ) ) : the_row(); ?>
        <tr>

          <!-- title -->
          <td>
            <?= esc_html( the_sub_field( 'data_title' ) ) ?>
          </td>
          
          <?php if ( get_sub_field( 'data_type' ) !== 'url' ) : ?>

            <!-- value HTML -->
            <td>
              <?= esc_html( the_sub_field( 'data_info' ) ) ?>
            </td>

            <?php else : ?>

              <!-- value LINK -->
              <td>
                <?= esc_url( the_sub_field( 'data_info' ) ) ?>
              </td>

          <?php endif; ?>
          
        </tr>
      <?php endwhile; ?>

    </tbody>
  </table>

<?php else : ?>

  <p>Item ainda não possui uma ficha técnica</p>

<?php endif; ?>
