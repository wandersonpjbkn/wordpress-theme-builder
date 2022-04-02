<?php

// ==============================================
// Component: Notification
// ==============================================

defined( 'ABSPATH' ) || exit;

?>

<div class="alert">

  <div class="alert__canvas"></div>

  <div class="alert__notify">

    <div class="alert__container">

      <p class="alert__title"></p>
      
      <p class="alert__message"></p>

    </div>

    <div class="alert__ctrl">

      <button class="alert__btn">Fechar</button>

      <a
        class="alert__link"
        href="<?= wc_get_cart_url() ?>"
      >Ver carrinho</a>

    </div>

  </div>  

</div>
