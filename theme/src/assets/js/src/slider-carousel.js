/** slide function */
const sliderCarousel = async () => {
  /** lazy import */
  const anime = async () => {
    return await import(/* webpackChunkName: 'anime' */ 'animejs').then(fn => fn.default)
  }

  /** lazy import */
  const tiny = async () => {
    return await import(/* webpackChunkName: 'tiny' */ 'tiny-slider/src/tiny-slider').then(fn => fn.tns)
  }

  /** lazy tiny slider */
  const tinyBuilder = async obj => {
    const _tiny = await tiny()
    return _tiny(obj)
  }

  /** lazy images */
  const lazyImages = async () => {
    return await import(/* webpackChunkName: 'lazy' */ './lazy').then(fn => fn.default)
  }

  /** progress bar animation */
  const animateBar = async (progress, timeout) => {
    const _anime = await anime()

    progress.value = 0

    _progress = _anime({
      targets: progress,
      easing: 'linear',
      duration: timeout,
      value: 100
    })
  }

  /** autoplay slider */
  const autoplaySlide = ({ ts, timeout, controls }) => {
    let interval

    // play slider
    const play = () => {
      clearTimeout(interval)
      interval = setTimeout(() => {
        Promise
          .resolve(ts.goTo('next'))
          .then(() => { play() })
      }, timeout)
    }

    // play slider
    play()

    // reset autoplay after each click
    if (controls.isActivated) {
      const controlChildrens = [...controls.element.children]

      controlChildrens.forEach(control => {
        control.addEventListener('click', play)
      })
    }
  }

  /** Stop observing this element and load its sources */
  const lazyLoad = (entries, observer) => {
    entries.forEach(entry => {
      if (entry.intersectionRatio <= 0) return

      initTiny(entry.target)
      observer.unobserve(entry.target)
    })
  }

  /** init tiny slider */
  const initTiny = async (carousel) => {
    // set params
    const slides = carousel.children[0].children[0]
    const progressbar = carousel.children[0].children[1] || false
    const control = carousel.children[1] || null
    const timeout = carousel.dataset.timeout || 4500

    const dotnav = {
      isActivated: control !== null ? control.dataset.type === 'dot' : false,
      element: control
    }

    const btnnav = {
      isActivated: control !== null ? control.dataset.type === 'btn' : false,
      element: control
    }

    const responsiveData = carousel.dataset.responsiveData !== undefined
      ? JSON.parse(carousel.dataset.responsiveData)
      : { 640: { items: 2 }, 960: { items: 3 }, 1200: { items: 4 } }

    const responsive = carousel.dataset.responsive === 'yes'
      ? responsiveData
      : false

    // async call tinyslider
    const _ts = await tinyBuilder({
      // controls visibility
      autoplayButtonOutput: true,

      // functions settings
      mouseDrag: false,
      freezable: false,

      // carousel custom settings
      responsive: responsive,
      gutter: carousel.dataset.gap || '30',
      container: slides,
      controls: btnnav.isActivated,
      controlsContainer: btnnav.element,
      nav: dotnav.isActivated,
      navContainer: dotnav.element
    })

    // (re)start progress
    progressbar && await animateBar(progressbar, timeout)
    progressbar && _ts.events.on('transitionStart', () => { _progress.restart() })

    // autoplay
    autoplaySlide({
      ts: _ts,
      timeout: timeout,
      controls: control !== null ? dotnav || btnnav : false
    })

    // lazy images
    Promise
      .resolve(lazyImages())
      .then(fn => fn())
  }

  /** observer threshold */
  const observer = new IntersectionObserver(lazyLoad, { threshold: 0.15 })

  /** init carousels */
  const init = () => {
    const casousels = [...document.querySelectorAll('.carousel')]

    for (const carousel of casousels) {
      // get carousel params
      const slides = carousel.children[0].children[0]
      const progressbar = carousel.children[0].children[1] || false
      const control = carousel.children[1] || null

      // check situation
      switch (slides.children.length > 1) {
        case true:
          // place observer
          observer.observe(carousel)
          break

        default:
          // fill progressbar
          if (slides.children.length === 1 && progressbar) { progressbar.value = 100 }

          // hide control if exists
          if (control) control.classList.add('is__hidden')
          break
      }
    }
  }

  let _progress

  // delay loading
  setTimeout(() => { init() }, 1500)
}

export default sliderCarousel
