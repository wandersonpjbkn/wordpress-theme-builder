/** limit quantity value with a friendly message */
const limitQuantity = () => {
  /** call notification */
  const notitify = async () => {
    return await import(/* webpackChunkName: 'notification' */ './notification').then(fn => fn.default)
  }

  /** prevent the new value and throw a message 'error' */
  const preventChange = ({ el, max }) => {
    el.value = max

    Promise
      .resolve(notitify())
      .then(fn => fn({
        title: 'Ops!',
        message: 'Não temos essa quantidade em estoque. O valor foi corrigido'
      }))
  }

  /** prevent change if new value bigger than max value  */
  const limit = e => {
    const max = parseInt(e.target.max)
    const value = parseInt(e.target.value)

    if (isNaN(max) || isNaN(value)) return

    if (value > max) return preventChange({ el: e.target, max: max })
  }

  ;[...document.querySelectorAll('.qty')].forEach(el => {
    // add listener
    el.addEventListener('keyup', limit)
  })
}

export default limitQuantity
