<?php

// ==============================================
// Template Part: Header Badge
// ==============================================

defined( 'ABSPATH' ) || exit;

$invalid_pages = (is_front_page() || is_cart() || is_checkout() || is_account_page());

?>

<?php if ( is_black_friday_up() && ! $invalid_pages ) : ?>

<div class="badge"></div>

<?php endif; ?>
