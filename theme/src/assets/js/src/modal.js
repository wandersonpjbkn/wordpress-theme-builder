/** open/close modal window */
const modal = () => {
  // add or remove class 'active' from modal
  const active = e => {
    e.preventDefault()

    const id = e.target.dataset.modal || document.querySelector('.js-modal').dataset.modal
    const modal = document.querySelector(`#${id}`)

    const modalActived = modal.classList.contains('active')

    if (modalActived) return modal.classList.remove('active')

    modal.classList.add('active')
  }

  // observer mutation
  const setObserver = () => {
    const options = { attributes: true, childList: true }
    const observer = new MutationObserver(addEventClickAfterMutation)

    const target = document.querySelector('.review')

    observer.observe(target, options)
  }

  // add mutation event
  const addEventClickAfterMutation = async (entries, observer) => {
    const target = entries[0].target
    console.log('target', target)
    addEventClick()
  }

  // add event click
  const addEventClick = () => {
    const modalBtn = document.querySelector('.js-modal')
    const id = modalBtn.dataset.modal
    const modal = document.querySelector(`#${id}`)

    // add to button
    modalBtn.addEventListener('click', active)

    // add to close
    modal.querySelector('[class*="close"]').addEventListener('click', active)

    // add to canvas
    modal.querySelector('[class*="canvas"]').addEventListener('click', active)
  }

  // set observer upon checkout form
  setObserver()
}

export default modal
