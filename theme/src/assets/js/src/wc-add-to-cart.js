/* eslint-disable camelcase */
const addToCart = () => {
  /** call notification */
  const notitify = async () => {
    return await import(/* webpackChunkName: 'notification' */ './notification').then(fn => fn.default)
  }

  /** add/remove load effect */
  const loading = btn => {
    const target = btn.closest('.js-add-to-cart')

    const spinner = target.querySelector('.spinner--centerY')
    const cartIcn = target.querySelector('.btn--icn-cart')

    target.classList.toggle('active')
    target.classList.toggle('is__disabled')

    cartIcn.classList.toggle('is__hidden')

    spinner.classList.toggle('is__hidden')
    spinner.classList.toggle('is__visible')
  }

  /** update data on cart */
  const updateCartQuantity = quantity => {
    const isMobile = window.innerWidth < 960
    const targetBtnCart = isMobile ? '.nav.account-menu' : '.nav.account-cart'

    const btnCart = document.querySelector(`${targetBtnCart} .btn--icn-cart`)
    const cartQuantity = btnCart.dataset?.cartCounter || 0
    const newCartQuantity = parseInt(quantity) + parseInt(cartQuantity)

    btnCart.dataset.cartCounter = newCartQuantity

    if (!btnCart.classList.contains('oncart')) btnCart.classList.add('oncart')
  }

  /** reload current product */
  const reloadPage = url => {
    const pathname = location.pathname
    const hostname = location.hostname

    location.replace(url || `https://${hostname}${pathname}`)
  }

  /** ajax call to add product to cart */
  const ajaxAddtoCart = e => {
    e.preventDefault()

    const $ = window.$ || window.jQuery
    const wc_ajax_url = window.woocommerce_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart')

    const btn = e.target
    const form = btn.closest('.cart')

    const product_id = form.querySelector('input[name="variation_id"]')?.value || form.querySelector('.single_add_to_cart_button').value
    const quantity = form.querySelector('.qty').value

    const data = { product_id, quantity }

    // loading
    loading(btn)

    // woocommerce purpose
    $(document.body).trigger('adding_to_cart', [btn, data])

    $.post(
      wc_ajax_url,
      data,
      response => {
        const message = '<span>Item adicionado ao carrinho!</span><span class="btn--inline btn--icn-check"></span>'
        const countdown = true
        const timeout = 1500

        if (response.error && response.product_url) return reloadPage(response.product_url)

        updateCartQuantity(quantity)

        Promise
          .resolve(notitify())
          .then(fn => fn({ message, countdown, timeout }))
          .finally(() => {
            // woocommerce purpose
            $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, btn])
          })
      })
      .then(() => {
        loading(btn)
      })
  }

  ;[...document.querySelectorAll('.js-add-to-cart')].forEach(btn => {
    btn.addEventListener('click', ajaxAddtoCart)
  })
}

export default addToCart
