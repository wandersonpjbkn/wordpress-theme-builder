/** run mask to input fields */
const maskField = () => {
  /** masks type: cep */
  const masks = {
    /** masks type: cep */
    cep: v => {
      v = v.replace(/\D/g, '')
      v = v.replace(/^(\d{5})(\d)/, '$1-$2')
      return v
    },

    /** masks type: tel */
    tel: v => {
      v = v.replace(/\D/g, '')
      v = v.replace(/^(\d{2})(\d)/g, '($1) $2')
      v = v.replace(/(\d)(\d{4})$/, '$1-$2')
      return v
    },

    /** masks type: int */
    number: v => {
      return v.replace(/\D/g, '')
    },

    /** masks type: cpf */
    cpf: v => {
      v = v.replace(/\D/g, '')
      v = v.replace(/(\d{3})(\d)/, '$1.$2')
      v = v.replace(/(\d{3})(\d)/, '$1.$2')
      v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2')
      return v
    },

    /** masks type: cnpj */
    cnpj: v => {
      v = v.replace(/\D/g, '')
      v = v.replace(/^(\d{2})(\d)/, '$1.$2')
      v = v.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3')
      v = v.replace(/\.(\d{3})(\d)/, '.$1/$2')
      v = v.replace(/(\d{4})(\d)/, '$1-$2')
      return v
    }
  }

  /** run mask */
  const runMask = () => {
    obj.value = fn(obj.value)
  }

  /** set mask to run */
  const mask = (_obj, _fn) => {
    obj = _obj
    fn = masks[_fn]

    setTimeout(() => {
      runMask()
    }, 1)
  }

  /** replace default input type */
  const fixInputType = target => {
    target.classList.add('mask-ref')
    target.type = 'text'
    target.pattern = '[0-9]*'
    target.inputmode = 'numeric'
    target.setAttribute('data-maskref', 'number')
  }

  /** set mask on load */
  const setMask = e => {
    mask(e.target, e.target.dataset.maskref)
  }

  let obj
  let fn

  // add events
  ;[...document.querySelectorAll('.mask-ref')].forEach(field => {
    // add event keydown
    field.addEventListener('keyup', setMask)
  })
  ;[...document.querySelectorAll('.qty')].forEach(field => {
    // fix input type
    fixInputType(field)

    // add event keydown
    field.addEventListener('keyup', setMask)
  })
}

export default maskField
