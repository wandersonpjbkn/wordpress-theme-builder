/** update product price when single variation selected */
const cartEvent = async () => {
  /** loading */
  const loading = (active = true) => {
    const blockUI = document.querySelector('.blockUI.blockOverlay.on-update')

    active === true
      ? blockUI.classList.add('active')
      : blockUI.classList.remove('active')
  }

  /** prevent invalid quantities */
  const isInvalidData = target => {
    const value = parseInt(target.value)
    const max = parseInt(target.getAttribute('max'))

    if (isNaN(value)) return true

    if (!isNaN(max) && value > max) return true

    if (value < 0) return true

    return false
  }

  /** update page */
  const updatePage = e => {
    const update = document.querySelector('.update-cart')

    // prevent invalid data
    if (isInvalidData(e.target)) return

    // if else, set a delayed click
    let timeout

    // reset timeout
    clearTimeout(timeout)

    // delayed click
    timeout = setTimeout(() => {
      loading()
      timeout = null
      update.click()
    }, 1000)
  }

  /** add blockUi after zipcode calc */
  const addBlockUI = () => {
    const target = document.querySelector('.cart_totals')
    const blockUI = document.querySelector('.blockUI.blockOverlay.on-update')

    if (!target === true || !blockUI !== true) return // prevent errors

    const newBlock = document.createElement('div')

    newBlock.classList.add('blockUI', 'blockOverlay', 'on-update')

    target.appendChild(newBlock)
  }

  // add event listenet
  ;[...document.querySelectorAll('.qty')].forEach(el => {
    el.addEventListener('keyup', updatePage)
  })

  // add document event listener
  const $ = window.$ || window.jQuery
  // readd blockui
  await $(document).on('change', () => {
    addBlockUI()
  })

  // reapply change listener
  await $(document).on('change', '.qty', updatePage)
}

export default cartEvent
