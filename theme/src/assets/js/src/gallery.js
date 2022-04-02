/** gallery functions */
const gallery = async () => {
  /** return viewport threshold */
  const isMobile = () => {
    return window.innerWidth < 960
  }

  /** lazy import */
  const pinchZoom = async () => {
    return await import(/* webpackChunkName: 'pinch-zoom' */ 'pinch-zoom-js').then(fn => fn.default)
  }

  /** lazy load animejs */
  const anime = async () => {
    return await import(/* webpackChunkName: 'anime' */ 'animejs').then(fn => fn.default)
  }

  /** animate */
  const animate = async scroll => {
    const _anime = await anime()

    const scrollTo = !isMobile()
      ? { scrollTop: scroll }
      : { scrollLeft: scroll }

    _anime(Object.assign({
      targets: galleryNav,
      duration: 150,
      easing: 'linear'
    }, scrollTo))
  }

  /** add animation */
  const addAnimation = () => {
    galleryTarget.classList.add('image-changed')
  }

  /** remove animation */
  const removeAnimation = () => {
    galleryTarget.classList.remove('image-changed')
  }

  /** load thumb ref image to gallery target */
  const changeGalleryImage = e => {
    const target = e.target || e
    const dataIndex = parseInt(target.dataset.index)

    if (index === dataIndex) return

    index = dataIndex

    const img = target.querySelector('img')
    const src = img.dataset.src.replace('-150x150', '')

    galleryTarget.src = src

    highlightThumb()

    if (galleryZoom) return galleryZoomTarget.setAttribute('src', src)
  }

  /** shift thumb by nav click */
  const shiftThumb = e => {
    const lastIndex = thumbsLength - 1
    const refIndex = parseInt(e.target.dataset.index)

    let shiftIndex = index + (refIndex)

    if (shiftIndex < 0) { shiftIndex = lastIndex }
    if (shiftIndex > lastIndex) { shiftIndex = 0 }

    changeGalleryImage(galleryThumbs[shiftIndex])
    moveToViewpoint(shiftIndex)
  }

  /** scroll to viewpoint */
  const moveToViewpoint = index => {
    const railY = !isMobile()
      ? document.querySelector('.ps__rail-y').offsetTop - 2
      : document.querySelector('.ps__rail-x').offsetLeft - 2
    const threshold = ++index * thumbSize

    // scroll to viewpoint, itens below it
    if (threshold > gallerySize) {
      if ((railY) <= (threshold - gallerySize)) {
        animate(threshold - gallerySize + 2)
      }
    }

    // scroll to viewpoint, itens above it
    if (railY > 0) {
      animate(--index * thumbSize)
    }
  }

  /** highlight current thumb */
  const highlightThumb = () => {
    ;[...galleryNav.querySelectorAll('.active')].forEach(btn => {
      btn.classList.remove('active')
    })

    galleryThumbs[index].classList.add('active')
  }

  /** toggle zoom element */
  const toggleZoom = () => {
    // get current zoom state
    const zoom = document.querySelector('.gallery__zoom')

    if (!zoom) return

    // active
    switch (zoom.classList.contains('active')) {
      case false:
        document.querySelector('body').style.overflow = 'hidden'
        zoom.classList.add('active')
        break

      default:
        // reset animation
        zoom.style.animation = 'none'
        // eslint-disable-next-line no-unused-expressions
        zoom.offsetWidth
        zoom.style.animation = null

        zoom.classList.add('close')
        break
    }
  }

  /** hide zoom */
  const closeZoom = e => {
    if (!e.target.classList.contains('close')) return

    e.target.classList.remove('active')
    e.target.classList.remove('close')

    document.querySelector('body').style.overflow = 'inherit'
  }

  const galleryNav = document.querySelector('.gallery__nav')
  const galleryTarget = document.querySelector('.gallery__thumb-target img')
  const galleryZoom = document.querySelector('.gallery__zoom')
  const galleryZoomTarget = document.querySelector('.gallery__zoom img')
  const galleryThumbs = document.querySelectorAll('.gallery__thumb')
  const gallerySize = !isMobile() ? galleryNav.offsetHeight : galleryNav.offsetWidth
  const thumbsLength = galleryThumbs.length
  const thumbSize = !isMobile() ? galleryThumbs[0].offsetHeight : galleryThumbs[0].offsetWidth

  let index

  // transition events
  galleryTarget.addEventListener('load', addAnimation)
  galleryTarget.addEventListener('webkitAnimationEnd', removeAnimation)
  galleryTarget.addEventListener('animationend', removeAnimation)

  if (galleryZoom) {
    galleryZoom.addEventListener('webkitAnimationEnd', closeZoom)
    galleryZoom.addEventListener('animationend', closeZoom)
  }

  // event click
  ;[...galleryThumbs].forEach(btn => {
    btn.addEventListener('click', changeGalleryImage)
  })
  ;[...document.querySelectorAll('.js-gallery-prev')].forEach(btn => {
    btn.addEventListener('click', shiftThumb)
  })
  ;[...document.querySelectorAll('.js-gallery-next')].forEach(btn => {
    btn.addEventListener('click', shiftThumb)
  })
  ;[...document.querySelectorAll('.gallery__toggle')].forEach(btn => {
    btn.addEventListener('click', toggleZoom)
  })
  galleryTarget.addEventListener('click', toggleZoom)

  // init zoom element
  galleryZoom && await pinchZoom().then(Pz => new Pz(galleryZoom.querySelector('img'), {}))

  // first show
  changeGalleryImage(galleryThumbs[0])
}

export default gallery
