<?php

// ==============================================
// Comnponent: Dashboard Custom Filter
// ==============================================

defined( 'ABSPATH' ) || exit;

$name = get_query_var( 'custom_filter_name' );
$options = get_query_var( 'custom_filter_options' );

?>

<select name="<?= esc_attr( $name ) ?>">

  <?php foreach ( $options as $option ) : ?>

    <option
      value="<?= esc_attr( $option[ 'value' ] ) ?>"
      <?= esc_attr( $option[ 'state' ] ? 'selected' : '' ) ?>
    ><?= esc_html( $option[ 'descr' ] ) ?></option>
  
  <?php endforeach; ?>

</select>
