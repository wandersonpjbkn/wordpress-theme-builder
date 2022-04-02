/** request cep address */
const getCepAddress = () => {
  /** force address placeholder */
  const forcePlaceholder = prefix => {
    const item = document.querySelector(`#${prefix}_address_1`)

    // prevent errors
    if (!item) return

    item.setAttribute('placeholder', 'Endereço')
  }

  /** reset fields values */
  const reset = prefix => {
    // set target suffixes
    const suffixes = ['_address_1', '_number', '_address_2', '_neighborhood', '_city', '_state']

    suffixes.forEach(suffix => {
      const item = document.querySelector(`#${prefix}${suffix}`)

      // prevent errors
      if (!item) return

      item.value = ''
    })
  }

  /** replace fields value */
  const replace = (prefix, suffix, value, trigger = false) => {
    const item = document.querySelector(`#${prefix}${suffix}`)

    // prevent errors
    if (!item) return

    item.value = value

    // trigger select2 event change
    if (trigger) item.dispatchEvent(new Event('change'))
  }

  /** focus on prefix number field */
  const focusNumber = prefix => {
    const item = document.querySelector(`#${prefix}_number`)

    // prevent errors
    if (!item) return

    item.focus()
  }

  const toggleSpinner = (state, spinner) => {
    switch (state) {
      case true:
        spinner.classList.remove('is__hidden')
        spinner.classList.add('is__visible')
        break

      default:
        spinner.classList.add('is__hidden')
        spinner.classList.remove('is__visible')
        break
    }
  }

  /** get cep */
  const getCep = e => {
    // prevent form submit
    e.preventDefault()

    // get jQuery from context
    const $ = window.$ || window.jQuery

    // get cep field
    const target = e.target
    const field = target.getAttribute('id') === 'billing_postcode'
      ? target
      : target.parentElement.previousSibling.querySelector('input')

    // get field target prefix: 'billing' || 'shipping'
    const prefix = field.getAttribute('id').replace('_postcode', '')

    // get spinner
    const spinner = target.getAttribute('id') === 'billing_postcode'
      ? target.closest(`#${prefix}_postcode_field`).nextSibling.querySelector('.spinner')
      : target.previousSibling

    // get cep value
    const cep = field.value.replace(/(-)/g, '')

    // load spinner
    toggleSpinner(true, spinner)

    // reset prefix section inputs
    window.cepaddress.reset(prefix)

    // return if invalid cep
    if (cep.length < 8) return setTimeout(() => { toggleSpinner(false, spinner) }, 1000)

    // request CEP data
    $.getJSON(`https://viacep.com.br/ws/${cep}/json/?callback=?`, data => {
      // remove load
      toggleSpinner(false, spinner)

      // prevent erros
      if (('erro' in data)) return console.log('Cep não encontrado')

      // set new data
      window.cepaddress.replace(prefix, '_address_1', data.logradouro)
      window.cepaddress.replace(prefix, '_neighborhood', data.bairro)
      window.cepaddress.replace(prefix, '_city', data.localidade)
      window.cepaddress.replace(prefix, '_state', data.uf, true)

      // change focus to number field
      window.cepaddress.focusNumber(prefix)
    })
  }

  /** add refresh button */
  const addRefreshBtn = target => {
    // create element
    const container = document.createElement('div')
    const btn = document.createElement('button')
    const spinner = document.createElement('div')

    // set button data
    btn.innerText = 'Buscar'
    btn.classList.add('btn--success')
    btn.addEventListener('click', getCep)

    // spinner data
    spinner.classList.add('spinner', 'is__hidden')

    // set container data
    container.classList.add('is__flex', 'col--1-2', 'col--1-4@md', 'offset__right--1-2@md')

    // insert spinner & button as child of container
    container.appendChild(spinner)
    container.appendChild(btn)

    // set container after CEP field
    target.insertAdjacentElement('afterend', container)
  }

  // set target prefix
  const prefixes = ['billing', 'shipping']

  // event
  prefixes.forEach(prefix => {
    // force new placeholder
    forcePlaceholder(prefix)

    // loop over all CEP in given prefix section
    ;[...document.querySelectorAll(`#${prefix}_postcode_field`)].forEach(field => {
      // add search button
      addRefreshBtn(field)

      // add event on blur
      field.querySelector('input').addEventListener('blur', getCep)
    })
  })

  // chrome bug fix
  window.cepaddress = {
    reset,
    replace,
    focusNumber
  }
}

export default getCepAddress
