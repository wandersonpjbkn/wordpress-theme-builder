/** frenet free shipping replace */
const frenetMask = () => {
  /** set CEP mask to field */
  const setCEPMask = target => {
    target.setAttribute('data-maskref', 'cep')
    target.setAttribute('maxlength', '9')
    target.classList.add('mask-ref')
  }

  // call mask
  ;[...document.querySelectorAll('#calc_shipping_postcode')].forEach(el => {
    // move element
    setCEPMask(el)
  })
  ;[...document.querySelectorAll('#zipcode')].forEach(el => {
    // move element
    setCEPMask(el)
  })
}

export default frenetMask
