/** update product price when single variation selected */
const updateSinglePrice = () => {
  /** hide single_variation */
  const hidePrice = elementPrice => {
    elementPrice.style.display = 'none'
  }

  /** check all attributes selects; return true/false to null value within */
  const hasAttibuteEmpty = () => {
    const selects = [...document.querySelectorAll('select[name*="attribute_"]')]
    for (const select of selects) {
      if (select.value === '') return true
    }

    return false
  }

  /** update gallery image */
  const updateGalleryImage = () => {
    if (!cart === true) return

    const variationsMeta = JSON.parse(cart.dataset.product_variations)
    const variationID = parseInt(cart.querySelector('input[name="variation_id"]')?.value || cart.querySelector('.single_add_to_cart_button').value)

    const variationData = variationsMeta.filter(variation => variation.variation_id === variationID)[0]
    const variationSrc = variationData.image.full_src

    galleryTarget.setAttribute('src', variationSrc)

    if (!galleryZoomTarget === true) return

    galleryZoomTarget.setAttribute('src', variationSrc)
  }

  /** update quota */
  const updateQuota = (target, variationPrice) => {
    // get price value in english version
    const getPrice = dom => {
      if (!dom) return null

      return dom.textContent.replace(/(R\$|\s|\.)/g, '').replace(',', '.')
    }

    // get price value
    const price = getPrice(variationPrice.querySelector('ins span')) || getPrice(variationPrice)

    // remove current quota if exists
    if (target.nextElementSibling.classList.contains('quota')) target.nextElementSibling.remove()

    // return if price lower than 200
    if (parseFloat(price) < 200) return

    const quota = document.createElement('div')
    const quotaPrice = (price / 12).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' })

    quota.classList.add('quota')
    quota.innerText = ` ou 12x sem juros de R$ ${quotaPrice}`

    target.insertAdjacentElement('afterend', quota)
  }

  /** call update */
  const update = (entries, observer) => {
    const target = document.querySelector('.title__price') // element where price will be changed
    const entry = entries[0].target // observed element

    // if observed element if hidden, return
    if (entry.style.display === 'none') return

    // set variation price
    let elementPrice = entry.querySelector('.woocommerce-variation-price')

    // deal with price changes
    switch (!elementPrice || elementPrice.innerHTML === '') {
      // if price change
      case false:
        // update price on title
        target.innerHTML = elementPrice.innerHTML

        // update quota
        updateQuota(target, elementPrice)

        // change gallery focus image to variation image
        updateGalleryImage()

        // prevent infinite loop
        observer.disconnect()

        // hide variation price
        hidePrice(elementPrice)

        // restart observer
        setObserver(entry.closest(targetToObserve))
        break

      // if observed element NOT change
      default:
        // prevent update if any attribute is empty
        if (hasAttibuteEmpty()) return

        // set variation price
        elementPrice = document.querySelector('.woocommerce-Price-amount')

        // update quota
        updateQuota(target, elementPrice)

        // change gallery focus image to variation image
        updateGalleryImage()

        // update price on title
        target.innerHTML = ''
        target.appendChild(elementPrice)
        break
    }
  }

  /** observer threshold */
  const setObserver = target => {
    const observeOptions = { attributes: true, childList: true }

    // create a new mutation observer with a callback
    observer = new MutationObserver(update)

    // set observer
    observer.observe(target, observeOptions)
  }

  const targetToObserve = '.single_variation'
  const cart = document.querySelector('.variations_form.cart')
  const galleryTarget = document.querySelector('.gallery__thumb-target img')
  const galleryZoomTarget = document.querySelector('.gallery__zoom img')

  let observer

  // add event listenet
  ;[...document.querySelectorAll(targetToObserve)].forEach(el => {
    setObserver(el)
  })
}

export default updateSinglePrice
