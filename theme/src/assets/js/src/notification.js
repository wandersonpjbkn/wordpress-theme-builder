/** throw a notification on the screen */
const notification = ({ title, message, inline = false, countdown = false, timeout = 2000 }) => {
  /** add an event listener to close notify */
  const addCloseEvent = () => {
    // add event on button and canvas
    if (_btn.dataset.closefn !== 'true') {
      _canvas.addEventListener('click', () => { toggleVisibility(false) })
      _btn.addEventListener('click', () => { toggleVisibility(false) })

      _btn.setAttribute('data-closefn', 'true')
    }
  }

  const smoothScroll = () => {
    const top = 0
    const left = 0
    const behavior = 'smooth'

    window.scroll({ top, left, behavior })
  }

  const appers = () => {
    // set notification title and message
    _title.innerHTML = title || ''
    _message.innerHTML = message || ''

    _alert.classList.add(inline === true ? 'inline' : 'popup')

    if (countdown === true) _alert.classList.add('countdown')
  }

  const reset = () => {
    _title.innerHTML = _message.innerHTML = ''

    _alert.classList.remove(inline === true ? 'inline' : 'popup')

    if (countdown === true) _alert.classList.remove('countdown')
  }

  /** open/close the notify */
  const toggleVisibility = state => {
    switch (state) {
      // show
      case true:
        appers()

        // smooth scroll
        if (inline === true) smoothScroll()

        // countdown
        if (countdown === true) setTimeout(() => { reset() }, timeout)
        break

      // erase alert content
      default:
        reset()
        break
    }
  }

  const _alert = document.querySelector('.alert')

  if (!_alert) return

  const _title = _alert.querySelector('[class*="__title"]')
  const _message = _alert.querySelector('[class*="__message"]')

  const _canvas = _alert.querySelector('[class*="__canvas"]')
  const _btn = _alert.querySelector(`[class*="${inline === true ? '__link' : '__btn'}"]`)

  // add close event
  addCloseEvent()

  // show notfy
  toggleVisibility(true)
}

export default notification
