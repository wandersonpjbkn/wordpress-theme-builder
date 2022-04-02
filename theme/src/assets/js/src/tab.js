/** set tabs */
const setTabs = () => {
  /** remove previous active */
  const reset = wrapper => {
    const btn = wrapper.querySelector('.active')
    const target = document.querySelector('.tab-target.active')

    if (btn) btn.classList.remove('active')
    if (target) target.classList.remove('active')
  }

  /** set tabs change */
  const changeTab = e => {
    e.preventDefault()

    const btn = e.target
    const parent = btn.closest('.tab')
    const target = document.querySelector(`#${btn.dataset.target}`)

    // reset
    reset(parent)

    // add active class
    btn.parentElement.classList.add('active')
    target.classList.add('active')
  }

  // event
  ;[...document.querySelectorAll('.js-tabs')].forEach(wrapper => {
    let oneActived = false

    ;[...wrapper.querySelectorAll('.tab-btn')].forEach(tab => {
      tab.addEventListener('click', changeTab)

      if (oneActived) return

      tab.click()

      oneActived = true
    })
  })
}

export default setTabs
