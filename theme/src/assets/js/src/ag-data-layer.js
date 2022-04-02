/* eslint-disable camelcase */
const setDataLayer = () => {
  /** return params */
  const { pathname, search } = window.location

  /** return true/false if this path has the given string or not */
  const pathHas = ref => ~pathname.indexOf(ref)

  /** return true/false if this search has the given string or not */
  const searchHas = ref => ~search.indexOf(ref)

  // search types
  const isSearchType = {
    product: searchHas('?post_type=product&p=')
  }

  // checks
  const is = {
    /** product page */
    product: () => pathHas('/produto/') || isSearchType.product,

    /** checkout page */
    checkout: () => pathHas('/finalizar-compra/') && !pathHas('/pedido-recebido/'),

    /** thankyou page */
    thankyou: () => pathHas('/pedido-recebido/'),

    /** cart page */
    cart: () => pathHas('/carrinho/')
  }

  /** fire datalayer params for product page */
  const fireDataLayerProduct = e => {
    const dl = window.dataLayer

    if (!dl) return console.log('DataLayer not found')

    const dataBlock = document.querySelector('.data-layer-js')
    const data = {
      event: 'productView',
      ecommerce: {
        click: {
          actionField: { list: 'Search Results' },
          products: [{
            id: dataBlock.dataset.id,
            name: dataBlock.dataset.name,
            price: dataBlock.dataset.price,
            brand: '',
            category: JSON.parse(dataBlock.dataset.category)
          }]
        }
      }
    }

    dl.push({ ecommerce: null })
    dl.push(data)
  }

  /** fire datalayer params for checkout page */
  const fireDataLayerCheckout = e => {
    const dl = window.dataLayer

    if (!dl) return console.log('DataLayer not found')

    const dataBlock = document.querySelectorAll('.data-layer-js')

    const products = [...dataBlock].map(item => ({
      id: item.dataset.id,
      name: item.dataset.name,
      price: item.dataset.price,
      brand: '',
      category: JSON.parse(item.dataset.category),
      quantity: item.dataset.quantity
    }))

    const data = {
      event: 'checkout',
      ecommerce: {
        checkout: {
          actionField: { step: 1, option: 'Visa' },
          products
        }
      }
    }

    dl.push({ ecommerce: null })
    dl.push(data)
  }

  /** fire datalayer params for thankyou page */
  const fireDataLayerThankYou = e => {
    const dl = window.dataLayer

    if (!dl) return console.log('DataLayer not found')

    const dataOrder = document.querySelector('.data-layer-order-js')
    const dataBlock = document.querySelectorAll('.data-layer-js')

    const products = [...dataBlock].map(item => ({
      id: item.dataset.id,
      name: item.dataset.name,
      price: item.dataset.price,
      brand: '',
      category: JSON.parse(item.dataset.category),
      quantity: item.dataset.quantity
    }))

    const data = {
      ecommerce: {
        purchase: {
          actionField: {
            id: dataOrder.dataset.orderId,
            revenue: dataOrder.dataset.revenue,
            tax: dataOrder.dataset.tax,
            shipping: dataOrder.dataset.shipping
          },
          products
        }
      }
    }

    dl.push({ ecommerce: null })
    dl.push(data)
  }

  /** fire datalayer params for cart page */
  const fireDataLayerCart = e => {
    const dl = window.dataLayer

    if (!dl) return console.log('DataLayer not found')

    const dataBlock = document.querySelectorAll('.data-layer-js')

    const products = [...dataBlock].map(item => ({
      id: item.dataset.id,
      name: item.dataset.name,
      price: item.dataset.price,
      brand: '',
      category: JSON.parse(item.dataset.category),
      quantity: item.dataset.quantity
    }))

    const data = { ecommerce: { add: { products } } }

    dl.push({ ecommerce: null })
    dl.push(data)
  }

  // fire dataLayer for the given page
  if (is.product()) fireDataLayerProduct()

  if (is.checkout()) fireDataLayerCheckout()

  if (is.thankyou()) fireDataLayerThankYou()

  if (is.cart()) fireDataLayerCart()
}

export default setDataLayer
