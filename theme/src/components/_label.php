<?php

// ==============================================
// Component: Label
// ==============================================

defined( 'ABSPATH' ) || exit;

$label_text = get_query_var( 'label_text' );
$label_theme = get_query_var( 'label_theme', 'is__theme--dark' );

?>

<div class="card__product__label <?= esc_attr( $label_theme ) ?>">
  <span><?= esc_html( $label_text ) ?></span>
</div>
