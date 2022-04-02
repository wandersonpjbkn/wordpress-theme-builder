/** frenet free shipping replace */
const frenetFreeShippingReplace = () => {
  /** block button upon click to prevent multi clicks while awaiting request */
  const block = e => {
    e.target.classList.add('is__disabled')
  }

  // enable button click
  const enable = () => {
    const btn = document.querySelector('#idx-calc_shipping')
    btn.classList.remove('is__disabled')
  }

  // shadow click on add to cart
  const shadowClick = e => {
    e.preventDefault()

    const btn = document.querySelector('form.cart .btn.is__theme--featured')

    btn.click()
  }

  // replace frenet response
  const replace = () => {
    // create an array with shippings
    const items = document.querySelectorAll('.li-frenet')

    if (!items) return

    // loop over shippings options
    items.forEach(item => {
      // check if exist a free shipping
      if (~item.innerHTML.indexOf('R$ 0.00')) {
        // add a bagde
        item.innerHTML = String(item.innerHTML).replace(
          '<span',
          '<span class="free-shipping">Frete grátis</span><span'
        )
      }

      // add shadow click to add to cart
      item.addEventListener('click', shadowClick)

      // make it visibled clickable
      item.classList.add('is__clickable')
    })
  }

  /** call update */
  const replaceData = (entries, observer) => {
    const target = entries[0].target

    // return if observed element is visible
    // it means that we are awaiting a reply from frenet
    if (target.style.display !== 'none') return

    // if observed element isn't visible
    // it means that we already receive a reply from frenet

    // in this case, enable button
    enable()

    // try replace response data
    replace()
  }

  /** observer threshold */
  const setObserver = target => {
    const options = { attributes: true, childList: true }

    observer = new MutationObserver(replaceData)

    observer.observe(target, options)
  }

  /** move shipping to above add to cart button */
  const moveAfterAddToCart = target => {
    const container = document.querySelector('form.cart')
    const ref = document.querySelector('.single_variation_wrap') || container.querySelector('.btn__group')

    // move
    const newNode = container.insertBefore(target, ref)

    // make visible in single page
    if (!ref.classList.contains('single_variation_wrap')) { newNode.style.display = 'block' }

    // call observer
    setObserver(container.querySelector('#loading_simulator'))

    // add block to ref upon click
    container.querySelector('#idx-calc_shipping').addEventListener('click', block)
  }

  let observer

  // call replace
  ;[...document.querySelectorAll('#shipping-simulator')].forEach(item => {
    // move element
    moveAfterAddToCart(item)
  })
}

export default frenetFreeShippingReplace
