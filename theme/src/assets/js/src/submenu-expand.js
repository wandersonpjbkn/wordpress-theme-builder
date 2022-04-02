/** toggle menu items */
const expandSubmenu = () => {
  /** lazy load animejs */
  const anime = async () => {
    return await import(/* webpackChunkName: 'anime' */ 'animejs').then(fn => fn.default)
  }

  /** animate */
  const animate = async ({ mod, target }) => {
    const _anime = await anime()
    const key = target.dataset.toggle
    const menu = document.querySelector(`#${key}`)

    // set max to zero
    let max = 0

    // if a mod was passed
    if (mod !== 0) {
      // set max as the sum of all menu childs height plus margin top/bottom
      ;[...menu.children].forEach(child => {
        max += child.clientHeight

        // this get the correct margin top/bottom value
        max += parseInt(window.getComputedStyle(child).getPropertyValue('margin-top'))
        max += parseInt(window.getComputedStyle(child).getPropertyValue('margin-bottom'))
      })
    }

    // call animejs to toggle the menu
    _anime({
      targets: menu,
      duration: 250,
      easing: 'easeInSine',
      height: max * mod // cuz mod can be either 1 or 0
    })
  }

  /** close all opened menus */
  const closeAll = async target => {
    const parent = target.parentElement.parentElement
    const actived = parent.querySelector('.active')

    // prevent errors
    if (!actived) return

    // close previous opened mene
    actived.classList.remove('active')
    animate({ mod: 0, target: actived })
  }

  /** toogle menu */
  const toggle = async e => {
    const target = e.target

    // close actual menu if opened
    if (target.classList.contains('active')) return closeAll(target)

    // close any other menu opened
    closeAll(target)

    // open current menu
    target.classList.add('active')
    animate({ mod: 1, target: target })
  }

  // add event listener
  ;[...document.querySelectorAll('.js-toggle')].forEach(el => {
    ;[...el.querySelectorAll('.toggle')].forEach(btn => {
      // prevent duplicate
      if (btn.dataset.togglefn === 'true') return

      btn.addEventListener('click', toggle)
      btn.setAttribute('data-togglefn', 'true')
    })
  })
}

export default expandSubmenu
