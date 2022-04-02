import path from 'path'

const local = '/'

const theme = 'theme'

const route = {
  // sources
  public: path.resolve(__dirname, './../', './theme/public'),
  src: path.resolve(__dirname, './../', './theme/src'),

  // destiny
  dist: path.resolve(__dirname, './../', `./dist/${theme}`)
}

export {
  theme,
  route,
  local
}
