/** website version */
const version = 'v1.0.0'

/** wait dom complete load */
const load = async () => {
  /** return params */
  const { pathname, search } = window.location

  /** return true/false if this path has the given string or not */
  const pathHas = ref => ~pathname.indexOf(ref)

  /** return true/false if this search has the given string or not */
  const searchHas = ref => ~search.indexOf(ref)

  /** run promise */
  const loadScript = async ({ arr, env }) => {
    console.log(`Website version: ${version};`, `env: (website) ${env || 'undefined'}`)
    for (const script of arr) {
      try {
        await import(/* webpackChunkName: "[request]" */ `./src/${script}`).then(async fn => {
          await fn.default()
        })
      } catch (err) {
        console.log(err)
      }
    }
  }

  // search types
  const isSearchType = {
    plugin: (searchHas('?s=') && searchHas('&type_aws=true')),
    product: searchHas('?post_type=product&p=')
  }

  // checks
  const is = {
    /** global variable */
    global: true,

    /** preview mode */
    preview: () => searchHas('&preview=true'),

    /** home page */
    home: () => pathname === '/',

    /** shop page */
    shop: () => pathHas('/loja/'),

    /** category page */
    category: () => pathHas('/categoria/') || isSearchType.plugin,

    /** tag page */
    tag: () => pathHas('/produto-tag/'),

    /** product page */
    product: () => pathHas('/produto/') || isSearchType.product,

    /** cart page */
    cart: () => pathHas('/carrinho/'),

    /** checkout page */
    checkout: () => pathHas('/finalizar-compra/') && !pathHas('/pedido-recebido/'),

    /** thankyou page */
    thankyou: () => pathHas('/pedido-recebido/'),

    /** account page */
    account: () => pathHas('/minha-conta/')
  }

  // variables
  let arr
  let env

  // global
  if (is.global) {
    arr = [
      'submenu-expand',
      'expand-input',
      'ag-data-layer'
    ]
    env = 'global'
    await loadScript({ arr, env })
  }

  // home only
  if (is.home()) {
    arr = [
      'slider-carousel',
      'lazy'
    ]
    env = 'home'
    await loadScript({ arr, env })
  }

  // category or shop or tag only
  if (is.category() || is.shop() || is.tag()) {
    arr = [
      'lazy'
    ]
    env = 'categoty || shop || tag'
    await loadScript({ arr, env })
  }

  // product and preview only
  if (is.product() || is.preview()) {
    arr = [
      'slider-carousel',
      'lazy',
      'gallery',
      'perfect-scroll',
      'mask-frenet',
      'mask',
      'wc-single-variation',
      'wc-add-to-cart',
      'wc-single-excerpt',
      'frenet-free-shipping',
      'quantity-limit'
    ]
    env = 'product || preview'
    await loadScript({ arr, env })
  }

  // cart only
  if (is.cart()) {
    arr = [
      'mask-frenet',
      'mask',
      'quantity-limit',
      'wc-cart'
    ]
    env = 'cart'
    await loadScript({ arr, env })
  }

  // checkout only
  if (is.checkout()) {
    arr = [
      'cep-address',
      'modal'
    ]
    env = 'checkout'
    await loadScript({ arr, env })
  }

  // account only
  if (is.account()) {
    arr = [
      'tab',
      'cep-address'
    ]
    env = 'account'
    await loadScript({ arr, env })
  }
}

window.addEventListener('DOMContentLoaded', load)
