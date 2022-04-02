/** change 'read more' button on product description */
const changeReadMoreBtn = async () => {
  /** submenu-expand */
  const expandSubmenu = async () => {
    return await import(/* webpackChunkName: 'submenu-expand' */ './submenu-expand').then(fn => fn.default)
  }

  /** add read-more btn */
  const addReadMore = async target => {
    const key = `i${Date.now()}`

    const paragraph = target.parentElement
    const container = paragraph.parentElement

    const btn = document.createElement('button')
    const wrapper = document.createElement('div')

    // set button data
    btn.classList.add('btn--primary', 'margin__bottom--medium', 'margin__top--medium', 'toggle')
    btn.setAttribute('data-toggle', key)
    btn.innerText = 'Veja mais'

    // set wrapper data
    wrapper.setAttribute('id', key)
    wrapper.style = 'height:0;overflow-y:hidden'

    // add toggle class to container
    container.classList.add('js-toggle')

    // add btn
    container.insertBefore(btn, paragraph)

    // remove wp paragraph
    paragraph.remove()

    // while has something after button
    while (btn.nextSibling) {
      // move it to wrapper
      wrapper.appendChild(btn.nextSibling)
    }

    // add wrapper
    btn.insertAdjacentElement('afterend', wrapper)
  }

  // locate read-more button
  const btns = [...document.querySelectorAll('span[id*="more"]')]

  // added event
  for (const btn of btns) {
    await addReadMore(btn)
  }

  // call submenu function
  expandSubmenu()
}

export default changeReadMoreBtn
