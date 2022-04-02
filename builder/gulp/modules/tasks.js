// modules external
import gulp from 'gulp'
import del from 'del'
import plumber from 'gulp-plumber'
import strip from 'gulp-strip-comments'
import htmlmin from 'gulp-htmlmin'
import Fiber from 'fibers'
import sass from 'gulp-sass'
import dartSass from 'sass'
import autoprefixer from 'autoprefixer'
import postCSS from 'gulp-postcss'
import cleanCSS from 'gulp-clean-css'
import imagemin from 'gulp-imagemin'
import mode from 'gulp-mode'
import webpack from 'webpack'
import webpackStream from 'webpack-stream'
import pug from 'gulp-pug'
import fs from 'fs'

// modules internal
import { paths } from './paths'
import { theme, route } from '../../config'
import { gulpRename as rename } from '../../utils'
import { config } from '../../webpack'

/** strip comments and minify html / php */
const stripCommentsAndMinify = ({ _path, _strip = { all: true, html: false }, _minify = true }) => {
  const htmlOptions = {
    collapseWhitespace: true,
    ignoreCustomFragments: [
      /<%[\s\S]*?%>/,
      /<\?[=|php]?[\s\S]*?\?>/,
      /<\?[=|php]?[\s\S]*?/
    ]
  }

  // create gulp stream
  let stream = gulp.src(_path.src)

  // suppress any error
  stream = stream.pipe(plumber())

  // strip comments on all files
  if (_strip.all && !_strip.html) { stream = stream.pipe(strip({ safe: true })) }

  // strip comments only on HTML
  if (_strip.html) { stream = stream.pipe(strip.html({ safe: true })) }

  // minify html
  if (_minify) { stream = stream.pipe(htmlmin(htmlOptions)) }

  // return gulp stream
  return stream.pipe(gulp.dest(_path.dist))
}

/** get fonts */
const getFontsObject = () => {
  const fonts = []
  const files = fs.readdirSync(paths.fonts.dist)

  for (const file of files) {
    const splittedFile = file.split('.')

    const href = file
    const type = `font/${splittedFile[1]}`

    fonts.push({ href, type })
  }

  return fonts
}

// holds all tasks
const tasks = {
  /** clean dist folder */
  clean: () => {
    return del([route.dist])
  },

  /** webpack for js */
  js: () => {
    const isProd = mode().production()
    const webConfig = config({ isProd })

    return webpackStream(webConfig, webpack)
      .pipe(gulp.dest(paths.js.dist))
  },

  /** pre-processing and compress CSS */
  css: () => {
    const sassOptions = {
      outputStyle: 'compressed',
      fiber: Fiber
    }

    const postCSSOptions = [
      autoprefixer()
    ]

    const cleanCSSOptions = {
      compatibility: '*',
      level: {
        2: {
          mergeSemantically: true,
          removeUnusedAtRules: true
        }
      }
    }

    const renameOptions = {
      basename: `${theme}-style`,
      extname: '.min.css'
    }

    // set sass compiler to Dart Sass
    sass.compiler = dartSass

    return gulp.src(paths.css.src)
      .pipe(plumber())
      .pipe(sass(sassOptions))
      .pipe(postCSS(postCSSOptions))
      .pipe(cleanCSS(cleanCSSOptions))
      .pipe(rename(renameOptions))
      .pipe(gulp.dest(paths.css.dist))
  },

  /** handle fonts */
  fonts: () => {
    return gulp.src(paths.fonts.src)
      .pipe(plumber())
      .pipe(rename(path => ({
        dirname: '',
        basename: path.dirname.replace(/(\/|\\)/g, '-')
      })))
      .pipe(gulp.dest(paths.fonts.dist))
  },

  /** compress images */
  imgs: () => {
    return gulp.src(paths.imgs.src)
      .pipe(imagemin())
      .pipe(gulp.dest(paths.imgs.dist))
  },

  /** strip root files */
  root: () => {
    return gulp.src(paths.root.src)
      .pipe(imagemin())
      .pipe(gulp.dest(paths.root.dist))
  },

  /** handle function folders */
  functions: () => stripCommentsAndMinify({
    _path: paths.functions,
    _strip: { all: false },
    _minify: false
  }),

  /** handle templates and templates-parts folders */
  html: () => stripCommentsAndMinify({
    _path: paths.html
  }),

  /** handle woocommerce folders */
  woocommerce: () => stripCommentsAndMinify({
    _path: paths.woocommerce
  }),

  /** handle template email folders */
  emails: () => stripCommentsAndMinify({
    _path: paths.emails
  }),

  /** handle pug */
  pug: () => {
    const fonts = getFontsObject()

    return gulp.src(paths.pug.src)
      .pipe(plumber())
      .pipe(pug({
        data: {
          fonts
        }
      }))
      .pipe(rename(() => ({
        extname: '.php'
      })))
      .pipe(gulp.dest(paths.pug.dist))
  }
}

export {
  tasks
}
