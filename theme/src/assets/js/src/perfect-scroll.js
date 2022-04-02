/** initialise perfect scroll */
const initPerfectScroll = () => {
  /** lazy load perfect scroll */
  const perfectScroll = async () => {
    return await import(/* webpackChunkName: 'perfect-scroll' */ 'perfect-scrollbar').then(fn => fn.default)
  }

  const loadPerfectScroll = async () => {
    const PerfectScroll = await perfectScroll()

    // eslint-disable-next-line no-unused-vars
    const ps = new PerfectScroll('.gallery__nav')
  }

  loadPerfectScroll()
}

export default initPerfectScroll
