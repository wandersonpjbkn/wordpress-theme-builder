/** expand input on focus */
const expandInput = () => {
  /** lazy load animejs */
  const anime = async () => {
    return await import(/* webpackChunkName: 'anime' */ 'animejs').then(fn => fn.default)
  }

  /** expand or retract input */
  const animaInput = async ({ el, isExpanding = false }) => {
    const _anime = await anime()
    const social = document.querySelector('.nav.social')
    const timeout = 250

    _anime({
      targets: social,
      opacity: isExpanding ? 0 : 1,
      scale: isExpanding ? 0.65 : 1,
      easing: isExpanding ? 'easeOutElastic' : 'easeInSine',
      duration: timeout,
      delay: isExpanding ? 0 : timeout
    })

    _anime({
      targets: el,
      width: isExpanding ? expandedWidth : `${initialWidth}px`,
      easing: 'easeInSine',
      duration: timeout
    })
  }

  /** expand on focus */
  const focusExpand = async e => {
    const el = e.target

    initialWidth = await el.dataset.width
    expandedWidth = `${await initialWidth / 0.5}px`

    el.style.width = `${initialWidth}px`

    await animaInput({ el: el, isExpanding: true })
  }

  /** retract on blur */
  const blurRetract = async e => {
    await animaInput({ el: e.target })
  }

  /** set dataset */
  const setDatasetWidth = target => {
    const width = target.offsetWidth
    target.setAttribute('data-width', width)
  }

  let initialWidth
  let expandedWidth

  // prevent run on mobile screens
  if (window.innerWidth < 640) return

  // add event listeners
  ;[...document.querySelectorAll('.aws-search-field')].forEach(el => {
    Promise
      .resolve(setDatasetWidth(el))
      .then(() => {
        el.addEventListener('focus', async e => {
          await focusExpand(e)
        })
        el.addEventListener('blur', async e => {
          await blurRetract(e)
        })
      })
  })
}

export default expandInput
