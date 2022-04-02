/** lazy load images */
const lazyImage = () => {
  /** Remove lazy class */
  const removeLazy = target => {
    target.classList.remove('lazy')
  }

  /** Update img src */
  const loadImage = img => {
    img.setAttribute('src', img.dataset.src)

    img.addEventListener('load', e => {
      removeLazy(e.target)
    }, false)
  }

  /** Stop observing this image and load its source */
  const lazyLoad = (entries, observer) => {
    entries.forEach(entry => {
      if (entry.intersectionRatio <= 0) return

      loadImage(entry.target)
      observer.unobserve(entry.target)
    })
  }

  /** observer threshold */
  const observer = new IntersectionObserver(lazyLoad, { threshold: 0.15 })

  // apply observer over all images
  ;[...document.querySelectorAll('.lazy')]
    .forEach(pic => observer.observe(pic))
}

export default lazyImage
